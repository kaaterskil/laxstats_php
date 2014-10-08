-- ----------------------------------------------------------------------
-- Box Score: Summary
-- ----------------------------------------------------------------------
-- Description
--   Returns game, field and scring information for the specified game.
--
-- In Arguments
--   p_gameRef
-- ----------------------------------------------------------------------
DROP PROCEDURE IF EXISTS box_score_summary;
CREATE PROCEDURE box_score_summary
  (p_gameRef INT)
--
SELECT gm.season, 
	gm.seasonType, 
	gm.date, 
	TIME_TO_SEC(gm.startTime) AS time,
	gm.usTeamRef, 
	gm.themTeamRef, 
	gm.fieldRef, 
	gm.conditions, 
	gm.scorekeeper,
	gm.timekeeper, 
	gm.referee, 
	gm.umpire, 
	gm.fieldJudge, 
	gm.conference,
	t1.town AS us_town, 
	t1.name AS us_name, 
	t1.shortName AS us_short_name,
	t2.town AS them_town, 
	t2.name AS them_name, 
	t2.shortName AS them_short_name,
	SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 1, 1, 0)) AS us_q1,
	SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 2, 1, 0)) AS us_q2,
	SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 3, 1, 0)) AS us_q3,
	SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 4, 1, 0)) AS us_q4,
	SUM(IF(g.teamRef = t1.teamRef AND g.quarter LIKE "O%", 1, 0)) AS us_ot,
	SUM(IF(g.teamRef = t1.teamRef, 1, 0)) AS us_score,
	SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 1, 1, 0)) AS them_q1,
	SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 2, 1, 0)) AS them_q2,
	SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 3, 1, 0)) AS them_q3,
	SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 4, 1, 0)) AS them_q4,
	SUM(IF(g.teamRef = t2.teamRef AND g.quarter LIKE "O%", 1, 0)) AS them_ot,
	SUM(IF(g.teamRef = t2.teamRef, 1, 0)) AS them_score,
	s.town AS field, 
	s.name AS field_name
FROM games gm
INNER JOIN teams t1
	ON gm.usTeamRef = t1.teamRef
INNER JOIN teams t2
	ON gm.themTeamRef = t2.teamRef
INNER JOIN goals g
	ON gm.gameRef = g.gameRef
INNER JOIN sites s
	ON gm.fieldRef = s.fieldRef
WHERE gm.gameRef = p_gameRef
GROUP BY gm.gameRef;
--