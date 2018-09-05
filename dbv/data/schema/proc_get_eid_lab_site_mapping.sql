DROP PROCEDURE IF EXISTS `proc_get_eid_lab_site_mapping`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_lab_site_mapping`
(IN lab INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        `county` AS `county`,
        SUM(`total`) AS `value`,
        SUM(`site_sending`) AS `site_sending`

        FROM `lab_mapping` ";

    SET @QUERY = CONCAT(@QUERY, " WHERE 1 ");


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

    IF (lab != 0 && lab != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `lab` = '",lab,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `county`  ORDER BY `county` DESC ");
    

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
     
END //
DELIMITER ;
