DROP PROCEDURE IF EXISTS `proc_get_eid_age_data`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_age_data`
(IN type INT(11), IN param INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  
  SET @column = '';

  SET @QUERY =    "SELECT
                    `a`.`name`,
                    SUM(`att`.`pos`) AS `positive`,
                    SUM(`att`.`neg`) AS `negative` ";
    
    IF(type = 1) THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `county_age_breakdown` `att` ");
      SET @column = " `att`.`county` ";
    END IF;
    IF(type = 2) THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `subcounty_age_breakdown` `att`  ");
      SET @column = " `att`.`subcounty` ";
    END IF;
    IF(type = 3) THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `ip_age_breakdown` `att`  ");
      SET @column = " `att`.`partner` ";
    END IF;
    IF(type = 4) THEN
      SET @QUERY = CONCAT(@QUERY, "  FROM `site_age_breakdown` `att` ");
      SET @column = " `att`.`site` ";
    END IF;
    IF(type = 0) THEN
      SET @QUERY = CONCAT(@QUERY, "  FROM `national_age_breakdown` `att` ");
    END IF;

    
    SET @QUERY = CONCAT(@QUERY, " JOIN `age_bands` `a` ON `att`.`age_band_id` = `a`.`ID` WHERE 1 ");


    
    IF(type != 0) THEN
      SET @QUERY = CONCAT(@QUERY, " AND ", @column , " = '",param,"' ");
    END IF;


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



    SET @QUERY = CONCAT(@QUERY, " GROUP BY `a`.`name` ORDER BY `age_band_id` ASC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
