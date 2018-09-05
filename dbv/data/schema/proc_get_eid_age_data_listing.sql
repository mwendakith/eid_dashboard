DROP PROCEDURE IF EXISTS `proc_get_eid_age_data_listing`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_age_data_listing`
(IN type INT(11), IN age INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  
  SET @column = '';

  SET @QUERY =    "SELECT
                    `a`.`name`,
                    SUM(`att`.`pos`) AS `pos`,
                    SUM(`att`.`neg`) AS `neg` ";
    
  IF(type = 1) THEN
    SET @column = " `att`.`county` ";
    SET @QUERY = CONCAT(@QUERY, " FROM `county_age_breakdown` `att` JOIN `countys` `a`   ");
  END IF;
  IF(type = 2) THEN
    SET @column = " `att`.`subcounty` ";
    SET @QUERY = CONCAT(@QUERY, " FROM `subcounty_age_breakdown` `att` JOIN `districts` `a` ");
  END IF;
  IF(type = 3) THEN
    SET @column = " `att`.`partner` ";
    SET @QUERY = CONCAT(@QUERY, " FROM `ip_age_breakdown` `att` JOIN `partners` `a` ");
  END IF;
  IF(type = 4) THEN
    SET @column = " `att`.`site` ";
    SET @QUERY = CONCAT(@QUERY, " FROM `site_age_breakdown` `att` JOIN `facilitys` `a` ");
  END IF;

    
  SET @QUERY = CONCAT(@QUERY, "  ON ", @column ," = `a`.`ID` WHERE 1 ");    

    

    IF(age != 0) THEN
      SET @QUERY = CONCAT(@QUERY, " AND `age_band_id` = '",age,"' ");
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



    SET @QUERY = CONCAT(@QUERY, " GROUP BY ", @column , " ORDER BY `pos` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
