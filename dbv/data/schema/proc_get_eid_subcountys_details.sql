DROP PROCEDURE IF EXISTS `proc_get_eid_subcountys_details`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_subcountys_details`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                  `districts`.`name` AS `subcounty`, 
                  AVG(`sitessending`) AS `sitessending`,
                  SUM(`alltests`) AS `alltests`, 
                  SUM(`actualinfants`) AS `actualinfants`, 
                  SUM(`pos`) AS `positive`, 
                  SUM(`neg`) AS `negative`, 
                  SUM(`repeatspos`) AS `repeatspos`,
                  SUM(`repeatposPOS`) AS `repeatsposPOS`,
                  SUM(`confirmdna`) AS `confirmdna`,
                  SUM(`confirmedPOS`) AS `confirmedPOS`,
                  SUM(`infantsless2w`) AS `infantsless2w`, 
                  SUM(`infantsless2wPOS`) AS `infantsless2wpos`, 
                  SUM(`infantsless2m`) AS `infantsless2m`, 
                  SUM(`infantsless2mPOS`) AS `infantsless2mpos`, 
                  SUM(`infantsabove2m`) AS `infantsabove2m`, 
                  SUM(`infantsabove2mPOS`) AS `infantsabove2mpos`,  
                  AVG(`medage`) AS `medage`,
                  SUM(`rejected`) AS `rejected`";

    IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `subcounty_summary` LEFT JOIN `districts` ON `subcounty_summary`.`subcounty` = `districts`.`id`  WHERE 1 ");
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `subcounty_summary_yearly` LEFT JOIN `districts` ON `subcounty_summary_yearly`.`subcounty` = `districts`.`id`  WHERE 1 ");
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " GROUP BY `subcounty_summary`.`subcounty` ORDER BY `tests` DESC ");
    ELSE
      SET @QUERY = CONCAT(@QUERY, " GROUP BY `subcounty_summary_yearly`.`subcounty` ORDER BY `tests` DESC ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
