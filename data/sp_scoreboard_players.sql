-- ----------------------------------------------------------------------
-- Scoreboard Players
-- ----------------------------------------------------------------------
-- Description
--   Returns player names, goals and assists by player for each game in 
--   the specified season and month. Player and game ids are included 
--   for building links.
--
-- In Arguments
--   p_season
--   p_month
-- ----------------------------------------------------------------------
DROP PROCEDURE IF EXISTS scoreboard_players;
CREATE PROCEDURE scoreboard_players
   (p_season INT,
    p_month INT)
--
SELECT gm.gameRef, pm.reference, p.teamRef,
	IF(pm.FName != "", CONCAT(SUBSTRING(pm.FName, 1, 1), ". ", pm.LName), pm.LName) AS name,
	SUM(IF(g.teamRef = p.teamRef AND g.scorer = p.jerseyNo, 1, 0)) AS goals,
	SUM(IF(g.teamRef = p.teamRef AND g.assist = p.jerseyNo, 1, 0)) AS assists
FROM games gm
INNER JOIN goals g
	ON gm.gameRef = g.gameRef
INNER JOIN players p
	ON g.teamRef = p.teamRef
	AND (g.scorer = p.jerseyNo OR g.assist = p.jerseyNo)
INNER JOIN playerMaster pm
	ON p.playerMasterRef = p.reference
WHERE YEAR(gm.date) = p_season
	AND MONTH(gm.date) = p_month
	AND gm.final != "F"
GROUP BY pm.reference, gm.date
ORDER BY gm.date DESC, gm.gameRef, p.teamRef;
--