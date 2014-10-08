-- ----------------------------------------------------------------------
-- Scoreboard Goalkeepers
-- ----------------------------------------------------------------------
-- Description
--   Returns goalkeeper names for each game in the specified season and 
--   month. Player, team and game ids are included for building links.
--
-- In Arguments
--   p_season
--   p_month
-- ----------------------------------------------------------------------
DROP PROCEDURE IF EXISTS scoreboard_goalkeepers;
CREATE PROCEDURE scoreboard_goalkeepers
  (p_season INT,
   p_month INT)
--
SELECT gm.gameRef, pm.reference, p.teamRef,
	IF(pm.FName != "", CONCAT(SUBSTRING(pm.FName, 1, 1), ". ", pm.LName), pm.LName) AS name
FROM games gm
INNER JOIN plays pl
	ON (gm.themTeamRef = pl.teamRef OR gm.usTeamRef = pl.teamRef)
INNER JOIN players p 
	ON (pl.teamRef = p.teamRef AND pl.playerRef = p.jerseyNo)
INNER JOIN playerMaster pm
	ON p.playerMasterRef = pm.reference
WHERE YEAR(gm.date) = p_season
	AND MONTH(gm.date) = p_month
	AND gm.final != "F"
	AND p.position LIKE "G%"
	AND pl.started = "T"
ORDER BY gm.date DESC, gm.gameRef;
--