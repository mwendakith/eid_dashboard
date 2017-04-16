DROP PROCEDURE IF EXISTS `proc_get_yearly_summary`;
DROP PROCEDURE IF EXISTS `proc_get_eid_yearly_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_yearly_summary`
(IN county INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `cs`.`year`,  
                    SUM(`cs`.`neg`) AS `negative`, 
                    SUM(`cs`.`pos`) AS `positive`, 
                    SUM(`cs`.`redraw`) AS `redraws`
                FROM `county_summary` `cs`
                WHERE 1 ";

      IF (county != 0 && county != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `cs`.`county` = '",county,"' ");
      END IF; 
    
      SET @QUERY = CONCAT(@QUERY, " GROUP BY `cs`.`year` ");
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `cs`.`year` ASC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
