DROP PROCEDURE IF EXISTS `proc_get_eid_poc_summary_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_poc_summary_outcomes`
(IN filter_county INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                  SUM(`alltests`) AS `alltests`, 
                  SUM(`tests`) AS `tests`, 
                  SUM(`actualinfants`) AS `actualinfants`, 
                  SUM(`pos`) AS `pos`, 
                  SUM(`neg`) AS `neg`, 
                  SUM(`repeatspos`) AS `repeatspos`,
                  SUM(`repeatposPOS`) AS `repeatsposPOS`,
                  SUM(`firstdna`) AS `firstdna`,
                  SUM(`confirmdna`) AS `confirmdna`,
                  SUM(`confirmedPOS`) AS `confirmpos`,
                  SUM(`infantsless2w`) AS `infantsless2w`, 
                  SUM(`infantsless2wPOS`) AS `infantsless2wpos`, 
                  SUM(`infantsless2m`) AS `infantsless2m`, 
                  SUM(`infantsless2mPOS`) AS `infantless2mpos`, 
                  SUM(`infantsabove2m`) AS `infantsabove2m`, 
                  SUM(`infantsabove2mPOS`) AS `infantsabove2mpos`,  
                  SUM(`adults`) AS `adults`,
                  SUM(`adultsPOS`) AS `adultsPOS`,
                  SUM(`redraw`) AS `redraw`,
                  SUM(`rejected`) AS `rejected`
                  FROM `site_summary_poc` `ssp`
                  LEFT JOIN `view_facilitys` `vf` ON `ssp`.`facility` = `vf`.`ID` 
                  WHERE 1 ";
   


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

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
