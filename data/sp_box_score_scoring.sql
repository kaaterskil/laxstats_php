-- ----------------------------------------------------------------------
-- Box Score: Scoring
-- ----------------------------------------------------------------------
-- Description
--   Returns scoring and assit detail. The team id is included for
--   building links.
--
-- In Arguments
--   p_gameRef
-- ----------------------------------------------------------------------
DROP PROCEDURE IF EXISTS box_score_scoring;
CREATE PROCEDURE box_score_scoring
  (p_gameRef INT)
--
SELECT g.teamRef, 
	g.quarter, 
	g.timeClock, 
	g.goalCode,
	IF(p1.FName != "", CONCAT_WS(" ", p1.FName, p1.LName), p1.LName) AS scorer,
	IF(g.assist > 0,
		IF(p2.FName != "",
			CONCAT_WS(" ", "Assist:", p2.FName, p2.LName),
			CONCAT_WS(" ", "Assist:", p2.LName)),
		"Unassisted") AS assist
FROM goals g
INNER JOIN players p1
	ON g.teamRef = p1.teamRef AND g.scorer = p1.jerseyNo
LEFT JOIN players p2
	ON g.teamRef = p2.teamRef AND g.assist = p2.jerseyNo
WHERE g.gameRef = p_gameRef
ORDER BY g.quarter ASC, g.timeClock DESC;
--