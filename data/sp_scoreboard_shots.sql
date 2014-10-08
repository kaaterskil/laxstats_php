-- ----------------------------------------------------------------------
-- Scoreboard Shots
-- ----------------------------------------------------------------------
-- Description
--   Returns the total shots by team for each game in the specified
--   season and month. The game id is included in order to build links.
--
-- In Arguments
--   p_season
--   p_month
-- ----------------------------------------------------------------------
DROP PROCEDURE IF EXISTS scoreboard_shots;
CREATE PROCEDURE scoreboard_shots
   (p_season INT,
    p_month INT)
--
SELECT gm.gameRef,
	IF(t2.town = f.town,
		SUM(IF(pl.teamRef = t2.teamRef, 
			pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT, 0)),
		SUM(IF(pl.teamRef = t1.teamRef, 
			pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT, 0))) AS home_shots,
	IF(t2.town = f.town,
		SUM(IF(pl.teamRef = t1.teamRef, 
			pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT, 0)),
		SUM(IF(pl.teamRef = t2.teamRef, 
			pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT, 0))) AS visitor_shots
FROM games gm
INNER JOIN sites f
	ON gm.fieldRef = f.fieldRef
INNER JOIN plays pl
	ON gm.gameRef = pl.gameRef
INNER JOIN teams t1
	ON gm.usTeamRef = t1.teamRef
INNER JOIN teams t2
	ON gm.themTeamRef = t2.teamRef
WHERE YEAR(gm.date) = p_season
	AND MONTH(gm.date) = p_month
	AND gm.final!= "F"
GROUP BY gm.gameRef
ORDER BY gm.date DESC, gm.startTime, gm.gameRef;
--