DROP PROCEDURE IF EXISTS `proc_get_eid_yearly_lab_tests`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_yearly_lab_tests`
(IN lab INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `ls`.`year`, `ls`.`month`, SUM(`ls`.`tests`) AS `tests`, 
                    SUM(`ls`.`pos`) AS `positive`,
                    SUM(`ls`.`neg`) AS `negative`,
                    SUM(`ls`.`rejected`) AS `rejected`,
                    SUM(`ls`.`tat4`) AS `tat4`
                FROM `lab_summary` `ls`
                WHERE 1 ";

      IF (lab != 0 && lab != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `ls`.`lab` = '",lab,"' ");
      END IF;  

    
      SET @QUERY = CONCAT(@QUERY, " GROUP BY `ls`.`month`, `ls`.`year` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `ls`.`year` DESC, `ls`.`month` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
