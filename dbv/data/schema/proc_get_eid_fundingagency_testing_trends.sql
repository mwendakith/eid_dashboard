DROP PROCEDURE IF EXISTS `proc_get_eid_fundingagency_testing_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_fundingagency_testing_trends`
(IN agency INT(11), IN from_year INT(11), IN to_year INT(11))
BEGIN
  SET @QUERY = "SELECT 
                `year`, 
                `month`, 
                SUM(`pos`) AS `pos`, 
                SUM(`neg`) AS `neg`,
                SUM(`rpos`) AS `rpos`, 
                SUM(`rneg`) AS `rneg`,
                SUM(`allpos`) AS `allpos`, 
                SUM(`allneg`) AS `allneg` 
            FROM `ip_summary`
            JOIN `partners` ON `partners`.`id` = `ip_summary`.`partner`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `partners`.`funding_agency_id` = '",agency,"' AND `year` BETWEEN '",from_year,"' AND '",to_year,"' GROUP BY `year`, `month` ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

