DROP PROCEDURE IF EXISTS `proc_get_national_testing_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_testing_trends`
(IN from_year INT(11), IN to_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
            `year`, 
            `month`, 
            `pos`, 
            `neg` 
            FROM `national_summary`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `year` = '",from_year,"' OR `year` = '",to_year,"' ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;