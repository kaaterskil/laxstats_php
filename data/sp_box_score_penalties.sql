-- ----------------------------------------------------------------------
-- Box Score: Penalties
-- ----------------------------------------------------------------------
-- Description
--   Returns penalty information for each player in the specified game.
--   The team id is included to build links.
--
-- In Arguments
--   p_gameRef
-- ----------------------------------------------------------------------
DROP PROCEDURE IF EXISTS box_score_penalties;
CREATE PROCEDURE box_score_penalties
	(p_gameRef INT)
--
SELECT pn.teamRef, 
	pn.duration, 
	pn.startQtr, 
	pn.startTime, 
	pn.infraction,
	IF(p.FName != "", CONCAT_WS(" ", p.FName, p.LName), p.LName) AS player
FROM penalties pn
INNER JOIN players p
	ON pn.teamRef = p.teamRef AND pn.playerRef = p.jerseyNo
WHERE pn.gameRef = p_gameRef
ORDER BY startQtr ASC, startTime DESC;
--