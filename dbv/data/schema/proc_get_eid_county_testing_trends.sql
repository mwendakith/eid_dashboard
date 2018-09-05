DROP PROCEDURE IF EXISTS `proc_get_eid_county_testing_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_testing_trends`
(IN C_id INT(11), IN from_year INT(11), IN to_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
            `year`, 
            `month`, 
            `pos`, 
            `neg`,
            `rpos`, 
            `rneg`,
            `allpos`, 
            `allneg` 
            FROM `county_summary`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_id,"' AND `year` BETWEEN '",from_year,"' AND '",to_year,"' ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
