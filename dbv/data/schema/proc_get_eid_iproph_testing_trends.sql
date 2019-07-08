DROP PROCEDURE IF EXISTS `proc_get_eid_iproph_testing_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_iproph_testing_trends`
(IN Pr_ID INT(11), IN from_year INT(11), IN to_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
            `year`, 
            `month`, 
            `tests`,       
            `pos`,     
            `neg`,       
            `redraw` 
            FROM `national_iprophylaxis`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `prophylaxis` = '",Pr_ID,"' AND `year` BETWEEN '",from_year,"' AND '",to_year,"' ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;