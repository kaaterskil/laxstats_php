-- ----------------------------------------------------------------------
-- Schedule: Team
-- ----------------------------------------------------------------------
-- Description
--   Returns game and team information, including scores for each game in 
--   the specified time period, irrespective of whether the game is in the
--   future or past. Game and team ids are included for building links.
--
-- In Arguments
--   p_start_month
--   p_end_month
-- ----------------------------------------------------------------------
DROP PROCEDURE IF EXISTS schedule_team;
CREATE PROCEDURE schedule_team
  (p_start_month INT,
   p_end_month   INT)
--
SELECT DISTINCT 
	gm.gameRef, 
	gm.date, 
	gm.startTime, 
	TIME_TO_SEC(gm.startTime) AS time_as_seconds,
	gm.fieldRef, 
	gm.final, 
	gm.created, 
	gm.modified, 
	f.town AS site, 
	CONCAT(f.town, " ", f.name) AS field,
	IF(t2.town = f.town, "at", "vs") AS versus,
	IF(t2.town = f.town, t2.town, t1.town) AS home_team,
	IF(t2.town = f.town, t2.teamRef, t1.teamRef) AS home_tr,
	IF(t2.town = f.town, t1.town, t2.town) AS visitor_team,
	IF(t2.town = f.town, t1.teamRef, t2.teamRef) AS visitor_tr,
	SUM(IF(g.teamRef = t1.teamRef, 1, 0)) AS home_score,
	SUM(IF(g.teamRef = t2.teamRef, 1, 0)) AS visitor_score
FROM games gm
RIGHT JOIN sites f
	ON gm.fieldRef = f.fieldRef
INNER JOIN goals g
	ON gm.gameRef = g.gameRef
INNER JOIN teams t1
	ON t1.teamRef = gm.usTeamRef
INNER JOIN teams t2
	ON t2.teamRef = gm.themTeamRef
WHERE gm.date >= DATE(p_start_month)
	AND gm.date <= DATE(p_end_month)
GROUP BY gm.gameRef
ORDER BY date, startTime;
--