-- ----------------------------------------------------------------------
-- Box Score: Lineup
-- ----------------------------------------------------------------------
-- Description
--   Returns each player for the given team, grouping first those who
--   played in the given game.
--
-- In Arguments
--   p_teamRef
--   p_gameRef
-- ----------------------------------------------------------------------
DROP PROCEDURE IF EXISTS box_score_lineup;
CREATE PROCEDURE box_score_lineup
	(p_teamRef	INT,
	 p_gameRef	INT)
--
SELECT p.jerseyNo,
	IF(p.FName != "", CONCAT_WS(" ", p.FName, p.LName), p.LName) AS player_name,
	IF(pl.gameRef = p_gameRef, pl.position, p.position) AS position,
	IF(pl.gameRef = p_gameRef,
		IF(pl.position = "A" OR pl.position = "M" OR pl.position = "", 1, 2),
		IF(p.position = "A" OR p.position = "M" OR p.position = "", 1, 2)) AS sequence,
	IF(pl.gameRef = p_gameRef, pl.started, NULL) AS started
FROM players p
LEFT JOIN plays pl
	ON p.teamRef = pl.teamRef 
	AND p.jerseyNo = pl.playerRef
	AND pl.gameRef = p_gameRef
WHERE p.teamRef = p_teamRef
GROUP BY p.jerseyNo
ORDER BY started DESC, sequence, position, p.jerseyNo;
--