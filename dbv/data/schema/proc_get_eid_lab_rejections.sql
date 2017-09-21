DROP PROCEDURE IF EXISTS `proc_get_eid_lab_rejections`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_lab_rejections`
(IN lab INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`total`) AS `total`,
        `rr`.`name`,
        `rr`.`alias` ";


    IF (lab != 0 && lab != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `lab_rejections` `v`");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `national_rejections` `v`");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " WHERE 1 ");

    SET @QUERY = CONCAT(@QUERY, " LEFT JOIN `rejectedreasons` `rr` ON `v`.`rejected_reason` = `rr`.`ID`");


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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `rr`.`ID` ORDER BY `total` DESC ");
    

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
     
END //
DELIMITER ;
