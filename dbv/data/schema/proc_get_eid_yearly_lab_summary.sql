DROP PROCEDURE IF EXISTS `proc_get_eid_yearly_lab_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_yearly_lab_summary`
(IN lab INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `ls`.`year`,  
                    SUM(`ls`.`neg`) AS `negative`, 
                    SUM(`ls`.`pos`) AS `positive`, 
                    SUM(`ls`.`redraw`) AS `redraws`
                FROM `lab_summary` `ls`
                WHERE 1 ";

      IF (lab != 0 && lab != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `ls`.`lab` = '",lab,"' ");
      END IF; 
    
      SET @QUERY = CONCAT(@QUERY, " GROUP BY `ls`.`year` ");
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `ls`.`year` ASC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
