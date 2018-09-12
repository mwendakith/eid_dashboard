DROP PROCEDURE IF EXISTS `proc_get_eid_poc_performance_stats`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_poc_performance_stats`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `f`.`name`, 
                    `f`.`facilitycode`, 
                    AVG(`ps`.`sitessending`) AS `sitesending`, 
                    SUM(`ps`.`batches`) AS `batches`, 
                    SUM(`ps`.`received`) AS `received`, 
                    SUM(`ps`.`tests`) AS `tests`, 
                    SUM(`ps`.`alltests`) AS `alltests`,  
                    SUM(`ps`.`rejected`) AS `rejected`,  
                    SUM(`ps`.`confirmdna`) AS `confirmdna`,  
                    SUM(`ps`.`confirmedPOs`) AS `confirmedpos`,
                    SUM(`ps`.`tiebreaker`) AS `tiebreaker`,
                    SUM(`ps`.`tiebreakerPOS`) AS `tiebreakerPOS`,
                    SUM(`ps`.`fake_confirmatory`) AS `fake_confirmatory`,
                    SUM(`ps`.`repeatspos`) AS `repeatspos`,  
                    SUM(`ps`.`repeatposPOS`) AS `repeatspospos`,
                    SUM(`ps`.`eqatests`) AS `eqa`, 
                    SUM(`ps`.`controls`) AS `controls`,  
                    SUM(`ps`.`pos`) AS `pos`, 
                    SUM(`ps`.`neg`) AS `neg`, 
                    SUM(`ps`.`redraw`) AS `redraw` 
                  FROM `poc_summary` `ps` LEFT JOIN `facilitys` `f` ON `ps`.`facility` = `f`.`ID` 
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

      SET @QUERY = CONCAT(@QUERY, " GROUP BY `ps`.`facility` ORDER BY `alltests` DESC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
