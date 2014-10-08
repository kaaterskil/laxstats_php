-- ----------------------------------------------------------------------
-- Box Score: Saves
-- ----------------------------------------------------------------------
-- Description
--   Returns goalkeeper detail for the given team and game. The player id
--   is included in order to build links.
--
-- In Arguments
--   p_teamRef
--   p_gameRef
-- ----------------------------------------------------------------------
DROP PROCEDURE IF EXISTS box_score_saves;
CREATE PROCEDURE box_score_saves
	(p_teamRef	INT,
	 p_gameRef	INT)
--
SELECT p.playerMasterRef,
	IF(p.FName != "", CONCAT_WS(" ", p.FName, p.LName), p.LName) AS player_name,
	(sv.savedQ1 + sv.savedQ2 + sv.savedQ3 + sv.savedQ4 + sv.savedOT) AS saved,
	(sv.allowedQ1 + sv.allowedQ2 + sv.allowedQ3 + sv.allowedQ4 + sv.allowedOT) AS allowed
FROM saves sv
INNER JOIN players p
	ON sv.teamRef = p.teamRef AND sv.playerRef = p.jerseyNo
INNER JOIN plays pl
	ON sv.gameRef = pl.gameRef
	AND sv.teamRef = pl.teamRef
	AND sv.playerRef = pl.playerRef
WHERE sv.gameRef = p_gameRef
	AND sv.teamRef = p_teamRef
ORDER BY saved DESC, p.jerseyNo;
--