DROP PROCEDURE IF EXISTS `proc_get_lab_performance`;
DROP PROCEDURE IF EXISTS `proc_get_eid_lab_performance`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_lab_performance`
(IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `l`.`ID`, `l`.`labname` AS `name`, `ls`.`tests`, `ls`.`rejected`, `ls`.`pos`, `ls`.neg,
                    `ls`.`month` 
                FROM `lab_summary` `ls`
                JOIN `labs` `l`
                ON `l`.`ID` = `ls`.`lab` 
                WHERE 1 ";

    
        SET @QUERY = CONCAT(@QUERY, " AND `ls`.`year` = '",filter_year,"' ");
  
  SET @QUERY = CONCAT(@QUERY, " ORDER BY `ls`.`month`, `l`.`ID` ");
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
