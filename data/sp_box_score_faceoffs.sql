-- ----------------------------------------------------------------------
-- Box Score: Faceoffs
-- ----------------------------------------------------------------------
-- Description
--   Returns player faceoff wins and losses for the given team and game.
--   The game id is included in order to build links.
--
-- In Arguments
--   p_teamRef
--   p_gameRef
-- ----------------------------------------------------------------------
DROP PROCEDURE IF EXISTS box_score_faceoffs;
CREATE PROCEDURE box_score_faceoffs
	(p_teamRef	INT,
	 p_gameRef	INT)
--
SELECT p.playerMasterRef,
	IF(p.FName != "", CONCAT_WS(" ", p.FName, p.LName), p.LName) AS player_name,
	(fo.wonQ1 + fo.wonQ2 + fo.wonQ3 + fo.wonQ4 + fo.wonOT) AS won,
	(fo.lostQ1 + fo.lostQ2 + fo.lostQ3 + fo.lostQ4 + fo.lostOT) AS lost
FROM faceoffs fo
INNER JOIN players p
	ON fo.teamRef = p.teamRef AND fo.playerRef = p.jerseyNo
INNER JOIN plays pl
	ON fo.gameRef = pl.gameRef
	AND fo.teamRef = pl.teamRef
	AND fo.playerRef = pl.playerRef
WHERE fo.gameRef = p_gameRef
	AND fo.teamRef = p_teamRef
ORDER BY won DESC, p.jerseyNo;
--