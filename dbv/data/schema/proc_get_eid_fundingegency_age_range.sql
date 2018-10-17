DROP PROCEDURE IF EXISTS `proc_get_eid_fundingegency_age_range`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_fundingegency_age_range`
(IN band_type INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN type INT(11), IN agency INT(11))
BEGIN
  SET @QUERY =    "SELECT  
            `a`.`name` AS `age_band`,
            `a`.`age_range`,
            SUM(`pos`) AS `pos`, 
            SUM(`neg`) AS `neg`
          FROM `ip_age_breakdown` `n`
          LEFT JOIN `age_bands` `a` ON `a`.`ID` = `n`.`age_band_id`
          LEFT JOIN `partners` ON `partners`.`id` = `n`.`partner`
          WHERE 1";
  
    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    IF (type = 1) THEN
      SET @QUERY = CONCAT(@QUERY, " AND `partners`.`funding_agency_id` = '",agency,"' ");
    END IF;

    IF (band_type = 1) THEN
        SET @QUERY = CONCAT(@QUERY, " GROUP BY `a`.`ID`  ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " GROUP BY `a`.`age_range_id`  ");
    END IF;

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;

END //
DELIMITER ;
