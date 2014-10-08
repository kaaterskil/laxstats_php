-- ----------------------------------------------------------------------
-- Schedule: Goalkeepers
-- ----------------------------------------------------------------------
-- Description
--   Returns last name and total saves for each goalkeeper in the 
--   specified game. Player and team ids are included to build links.
--
-- In Arguments
--   p_gameRef
-- ----------------------------------------------------------------------
DROP PROCEDURE IF EXISTS schedule_goalkeepers;
CREATE PROCEDURE schedule_goalkeepers
  (p_gameRef INT)
--
SELECT pm.reference, 
	pm.LName, 
	s.teamRef,
	(s.savedQ1 + s.savedQ2 + s.savedQ3 + s.savedQ4 + s.savedOT) AS saves
FROM saves s 
INNER JOIN players p
	ON (s.teamRef = p.teamRef AND s.playerRef = p.jerseyNo)
INNER JOIN playerMaster pm
	ON p.playerMasterRef = p.reference
WHERE s.gameRef = p_gameRef
GROUP BY pm.reference
ORDER BY p.depth, saves DESC;
--