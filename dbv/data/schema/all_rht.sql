
DROP PROCEDURE IF EXISTS `proc_get_eid_rht_pos_trend`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_rht_pos_trend`
(IN filter_county INT(11), IN filter_year INT(11), IN filter_result INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    MONTH(`rs`.`datetested`) AS `month`, 
                    COUNT(*) AS `tests`
                  FROM `rht_samples` `rs` 
                  LEFT JOIN `view_facilitys` `vf` 
                    ON `rs`.`facility` = `vf`.`ID`
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND YEAR(`datetested`) = '",filter_year,"' ");

    
    IF (filter_result != 0 && filter_result != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `rs`.`result` = '",filter_result,"' ");
    END IF;

    IF (filter_county != 0 && filter_county != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",filter_county,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `month` ORDER BY `month` ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_rht_yearly_trend`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_rht_yearly_trend`
(IN filter_county INT(11), IN filter_result INT(11))
BEGIN
  SET @QUERY =    "SELECT  
                    YEAR(`rs`.`datetested`) AS `year`, 
                    MONTH(`rs`.`datetested`) AS `month`,
                    COUNT(*) AS `tests`
                  FROM `rht_samples` `rs` 
                  LEFT JOIN `view_facilitys` `vf` 
                    ON `rs`.`facility` = `vf`.`ID`
    WHERE 1";

    
    IF (filter_result != 0 && filter_result != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `rs`.`result` = '",filter_result,"' ");
    END IF;

    IF (filter_county != 0 && filter_county != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",filter_county,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `month`, `year` ORDER BY `year` DESC, `month` ASC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_rht_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_rht_outcomes`
(IN filter_county INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN filter_result INT(11), IN filter_gender VARCHAR(11))
BEGIN
  SET @QUERY =    "SELECT 
                    COUNT(*) AS `tests` 
                  FROM `rht_samples` `rs` 
                  LEFT JOIN `view_facilitys` `vf` 
                    ON `rs`.`facility` = `vf`.`ID`
    WHERE 1";

    IF (filter_county != 0 && filter_county != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",filter_county,"' ");
    END IF;

    IF (filter_gender != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `rs`.`gender` = '",filter_gender,"' ");
    END IF;

    IF (filter_result != 0 && filter_result != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `rs`.`result` = '",filter_result,"' ");
    END IF;

    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
        SET @QUERY = CONCAT(@QUERY, " AND YEAR(`datetested`) = '",filter_year,"' AND MONTH(`datetested`) BETWEEN '",from_month,"' AND '",to_month,"' ");
      ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
        SET @QUERY = CONCAT(@QUERY, " AND ((YEAR(`datetested`) = '",filter_year,"' AND MONTH(`datetested`) >= '",from_month,"')  OR (YEAR(`datetested`) = '",to_year,"' AND MONTH(`datetested`) <= '",to_month,"') OR (YEAR(`datetested`) > '",filter_year,"' AND YEAR(`datetested`) < '",to_year,"')) ");
      ELSE
        SET @QUERY = CONCAT(@QUERY, " AND YEAR(`datetested`) = '",filter_year,"' AND MONTH(`datetested`)='",from_month,"' ");
      END IF;
    END IF;
    ELSE
      SET @QUERY = CONCAT(@QUERY, " AND YEAR(`datetested`) = '",filter_year,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_rht_facility_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_rht_facility_outcomes`
(IN filter_county INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN filter_result INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    DISTINCT(`rs`.`facility`) AS `facility`,
                    `vf`.`name` AS `name`,
                    COUNT(*) AS `tests` 
                  FROM `rht_samples` `rs` 
                  LEFT JOIN `view_facilitys` `vf` 
                    ON `rs`.`facility` = `vf`.`ID`
    WHERE 1";

    IF (filter_county != 0 && filter_county != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",filter_county,"' ");
    END IF;


    IF (filter_result != 0 && filter_result != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `rs`.`result` = '",filter_result,"' ");
    END IF;

    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
        SET @QUERY = CONCAT(@QUERY, " AND YEAR(`datetested`) = '",filter_year,"' AND MONTH(`datetested`) BETWEEN '",from_month,"' AND '",to_month,"' ");
      ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
        SET @QUERY = CONCAT(@QUERY, " AND ((YEAR(`datetested`) = '",filter_year,"' AND MONTH(`datetested`) >= '",from_month,"')  OR (YEAR(`datetested`) = '",to_year,"' AND MONTH(`datetested`) <= '",to_month,"') OR (YEAR(`datetested`) > '",filter_year,"' AND YEAR(`datetested`) < '",to_year,"')) ");
      ELSE
        SET @QUERY = CONCAT(@QUERY, " AND YEAR(`datetested`) = '",filter_year,"' AND MONTH(`datetested`)='",from_month,"' ");
      END IF;
    END IF;
    ELSE
      SET @QUERY = CONCAT(@QUERY, " AND YEAR(`datetested`) = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `rs`.`facility` ORDER BY `tests` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
