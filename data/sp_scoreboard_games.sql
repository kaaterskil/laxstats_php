-- ----------------------------------------------------------------------
-- Scoreboard: Games
-- ----------------------------------------------------------------------
-- Description
--   Returns game, field and team information in addition to quarterly
--   and game total scoring for each team in each game in the specified
--   season and month. Game, field and team ids are included to build 
--   links.
--
-- In Arguments
--   p_season
--   p_month
-- ----------------------------------------------------------------------
DROP PROCEDURE IF EXISTS scoreboard_games;
CREATE PROCEDURE scoreboard_games
  (p_season	INT,
   p_month  INT)
--
SELECT gm.gameRef, gm.date, gm.fieldRef, gm.seasonType,
	CONCAT(f.town, " ", f.name) AS field,
	IF(t2.town = f.town, t2.town, t1.town) AS home_team,
	IF(t2.town = f.town, UPPER(t2.shortName), UPPER(t1.shortName)) AS home_abbrev,
	IF(t2.town = f.town, t2.teamRef, t1.teamRef) AS home_tr,
	IF(t2.town = f.town, t2.teamMasterRef, t1.teamMasterRef) AS home_tmr,
	IF(t2.town = f.town, t1.town, t2.town) AS visitor_team,
	IF(t2.town = f.town, UPPER(t1.shortName), UPPER(t2.shortName)) AS visitor_abbrev,
	IF(t2.town = f.town, t1.teamRef, t2.teamRef) AS visitor_tr,
	IF(t2.town = f.town, t1.teamMasterRef, t2.teamMasterRef) AS visitor_tmr,
	IF(t2.town = f.town,
		SUM(IF(g.teamRef = t2.teamRef, 1, 0)),
		SUM(IF(g.teamRef = t1.teamRef, 1, 0))) AS home_score,
	IF(t2.town = f.town,
		SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 1, 1, 0)),
		SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 1, 1, 0))) AS home_goalsQ1,
	IF(t2.town = f.town,
		SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 2, 1, 0)),
		SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 2, 1, 0))) AS home_goalsQ2,
	IF(t2.town = f.town,
		SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 3, 1, 0)),
		SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 3, 1, 0))) AS home_goalsQ3,
	IF(t2.town = f.town,
		SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 4, 1, 0)),
		SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 4, 1, 0))) AS home_goalsQ4,
	IF(t2.town = f.town,
		SUM(IF(g.teamRef = t2.teamRef AND g.quarter LIKE "O%", 1, 0)),
		SUM(IF(g.teamRef = t1.teamRef AND g.quarter LIKE "O%", 1, 0))) AS home_goalsOT,
	IF(t2.town = f.town,
		SUM(IF(g.teamRef = t1.teamRef, 1, 0)),
		SUM(IF(g.teamRef = t2.teamRef, 1, 0))) AS visitor_score,
	IF(t2.town = f.town,
		SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 1, 1, 0)),
		SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 1, 1, 0))) AS visitor_goalsQ1,
	IF(t2.town = f.town,
		SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 2, 1, 0)),
		SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 2, 1, 0))) AS visitor_goalsQ2,
	IF(t2.town = f.town,
		SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 3, 1, 0)),
		SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 3, 1, 0))) AS visitor_goalsQ3,
	IF(t2.town = f.town,
		SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 4, 1, 0)),
		SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 4, 1, 0))) AS visitor_goalsQ4,
	IF(t2.town = f.town,
		SUM(IF(g.teamRef = t1.teamRef AND g.quarter LIKE "O%", 1, 0)),
		SUM(IF(g.teamRef = t2.teamRef AND g.quarter LIKE "O%", 1, 0))) AS visitor_goalsOT
FROM games gm
INNER JOIN sites f
	ON gm.fieldRef = f.fieldRef
INNER JOIN goals g
	ON gm.gameRef = g.gameRef
INNER JOIN teams t1
	ON gm.usTeamRef = t1.teamRef
INNER JOIN teams t2
	ON gm.themTeamRef = t2.teamRef
WHERE YEAR(gm.date) = p_season
	AND MONTH(gm.date) = p_month
	AND gm.final != "F"
GROUP BY gm.gameRef
ORDER BY gm.date DESC, gm.startTime, gm.gameRef;
--