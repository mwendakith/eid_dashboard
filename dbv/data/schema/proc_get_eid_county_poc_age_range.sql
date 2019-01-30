DROP PROCEDURE IF EXISTS `proc_get_eid_county_poc_age_range`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_poc_age_range`
(IN band_type INT(11), IN filter_county INT(11),  IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  ";

    IF (band_type = 1) THEN
        SET @QUERY = CONCAT(@QUERY, "  `a`.`name` AS `agename`,  ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " `a`.`age_range` AS `agename`,  ");
    END IF;


    SET @QUERY = CONCAT(@QUERY,   " 
        
        SUM(`pos`) AS `pos`, 
        SUM(`neg`) AS `neg`
      FROM `site_age_breakdown_poc` `n`
      LEFT JOIN `age_bands` `a` ON `a`.`ID` = `n`.`age_band_id`
      LEFT JOIN `view_facilitys` `vf` ON `n`.`facility` = `vf`.`ID` 
      WHERE 1 ");
  
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

    IF (filter_county != 0 && filter_county != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `county` = '",filter_county,"' ");
    END IF;

    IF (band_type = 1) THEN
        SET @QUERY = CONCAT(@QUERY, " GROUP BY `a`.`name`  ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " GROUP BY `a`.`age_range`  ");
    END IF;

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;

END //
DELIMITER ;
