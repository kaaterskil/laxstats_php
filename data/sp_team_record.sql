-- ----------------------------------------------------------------------
-- Team Record
-- ----------------------------------------------------------------------
-- Description
--   Returns the team's record for each game of the season up to the
--   specified date.
--
-- In Arguments
--   p_teamRef
--   p_date
-- ----------------------------------------------------------------------
DROP PROCEDURE IF EXISTS team_record;
CREATE PROCEDURE team_record
  (p_teamRef INT,
   p_date DATE)
--
SELECT gm.date, 
	SUM(IF(g.teamRef = t.teamRef, 1, 0)) AS us,
	SUM(IF(g.teamRef != t.teamRef, 1, 0)) AS them
FROM goals g
INNER JOIN games gm
	ON g.gameRef = gm.gameRef
INNER JOIN teams t
	ON (gm.usTeamRef = t.teamRef OR gm.themTeamRef = t.teamRef)
WHERE gm.date < p_date
	AND t.teamRef = p_teamRef
	AND gm.final != 'F'
GROUP BY gm.gameRef;
--