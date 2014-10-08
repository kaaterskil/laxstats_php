-- ----------------------------------------------------------------------
-- Box Score: Offense
-- ----------------------------------------------------------------------
-- Description
--   Returns offensive data (goals, assists, shots, shot pct and ground
--   balls) by player for the specified team and game in descending order.
--   Includes the player id for building links.
--
-- In Arguments
--   p_teamRef
--   p_gameRef
-- ----------------------------------------------------------------------
DROP PROCEDURE IF EXISTS box_score_offense;
CREATE PROCEDURE box_score_offense
	(p_teamRef	INT,
	 p_gameRef	INT)
--
SELECT pl.position, 
	p.jerseyNo, 
	p.playerMasterRef,
	IF(p.FName != "", CONCAT_WS(" ", p.FName, p.LName), p.LName) AS player_name,
	SUM(IF(pl.playerRef = g.scorer, 1, 0)) AS goals,
	SUM(IF(pl.playerRef = g.assist, 1, 0)) AS assists,
	SUM(IF(pl.playerRef = g.scorer, 1, 0)) + SUM(IF(pl.playerRef = g.assist, 1, 0)) AS points,
	pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT AS shots,
	IF(pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT > 0,
		FORMAT(SUM(IF(pl.playerRef = g.scorer, 1, 0)) / (pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT), 3),
		FORMAT(0, 3)) AS shot_pct,
	(pl.gbQ1 + pl.gbQ2 + pl.gbQ3 + pl.gbQ4 + pl.gbOT) AS gb
FROM plays pl
INNER JOIN players p
	ON pl.teamRef = p.teamRef 
	AND pl.playerRef = p.jerseyNo
LEFT JOIN goals g
	ON pl.gameRef = g.gameRef 
	AND pl.teamRef = g.teamRef
WHERE pl.gameRef = p_gameRef
	AND pl.teamRef = p_teamRef
GROUP BY pl.playerRef
ORDER BY points DESC, goals DESC, assists DESC, shot_pct DESC, shots DESC,
	gb DESC, p.jerseyNo;
--