DROP PROCEDURE IF EXISTS `proc_get_eid_age_breakdown_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_age_breakdown_trends`
(IN age INT(11), IN from_year INT(11), IN to_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
            `year`, 
            `month`, 
            `pos`, 
            `neg`

            FROM `national_age_breakdown`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND (`year` = '",from_year,"' OR `year` = '",to_year,"') 
        and `age_band_id` = '",age,"'
     ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

