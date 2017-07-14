DROP PROCEDURE IF EXISTS `proc_get_eid_county_partners_details`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_partners_details`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                  `p`.name AS `partner`, 
                  `c`.name AS `county`,
                  SUM(`tests`) AS `tests`, 
                  SUM(`actualinfants`) AS `actualinfants`, 
                  SUM(`confirmdna` + `repeatspos`) AS `confirmdna`,
                  SUM(`actualinfantsPOS`) AS `positive`, 
                  SUM(`actualinfants`-`actualinfantsPOS`) AS `negative`, 
                  SUM(`redraw`) AS `redraw`, 
                  SUM(`adults`) AS `adults`, 
                  SUM(`adultsPOS`) AS `adultspos`, 
                  AVG(`medage`) AS `medage`, 
                  SUM(`rejected`) AS `rejected`, 
                  SUM(`infantsless2w`) AS `infantsless2w`, 
                  SUM(`infantsless2wPOS`) AS `infantsless2wpos`, 
                  SUM(`infantsless2m`) AS `infantsless2m`, 
                  SUM(`infantsless2mPOS`) AS `infantsless2mpos`, 
                  SUM(`infantsabove2m`) AS `infantsabove2m`, 
                  SUM(`infantsabove2mPOS`) AS `infantsabove2mpos`     ";


     IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `site_summary` `is` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `site_summary_yearly` `is` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " LEFT JOIN `view_facilitys` `vf` ON `vf`.`ID` = `is`.`facility`
                    LEFT JOIN `partners` `p` ON `p`.`ID` = `vf`.`partner`
                    LEFT JOIN `countys` `c` ON `c`.`ID` = `vf`.`county`
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

    SET @QUERY = CONCAT(@QUERY, " AND `vf`.county = '",C_id,"' ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `p`.`name` ORDER BY `tests` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
