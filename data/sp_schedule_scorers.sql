-- ----------------------------------------------------------------------
-- Schedule: Scorers
-- ----------------------------------------------------------------------
-- Description
--   Returns the last name and total goals for each scorer in the
--   specified game. The player and team ids are included to build links.
--
-- In Arguments
--   p_gameRef
-- ----------------------------------------------------------------------
DROP PROCEDURE IF EXISTS schedule_scorers;
CREATE PROCEDURE schedule_scorers
  (p_gameRef INT)
--
SELECT pm.reference, 
	pm.LName, 
	COUNT(g.scorer) AS goals, 
	g.teamRef
FROM goals g
INNER JOIN players p 
	ON (g.teamRef = p.teamRef AND g.scorer = p.jerseyNo)
INNER JOIN playerMaster pm
	ON p.playerMasterRef = pm.reference
WHERE g.gameRef = p_gameRef
GROUP BY pm.reference
ORDER BY g.teamRef, goals DESC, p.jerseyNo;
--