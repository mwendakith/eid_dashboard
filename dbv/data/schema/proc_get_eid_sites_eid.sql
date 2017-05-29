DROP PROCEDURE IF EXISTS `proc_get_eid_sites_eid`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_sites_eid`
(IN filter_site INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM(`pos`) AS `pos`,
                    SUM(`neg`) AS `neg`,
                    AVG(`medage`) AS `medage`,
                    SUM(`alltests`) AS `alltests`,
                    SUM(`eqatests`) AS `eqatests`,
                    SUM(`firstdna`) AS `firstdna`,
                    SUM(`confirmdna`) AS `confirmdna`,
                    SUM(`confirmedPOS`) AS `confirmpos`,
                    SUM(`repeatspos`) AS `repeatspos`,
                    SUM(`actualinfants`) AS `actualinfants`,
                    SUM(`actualinfantsPOS`) AS `actualinfantspos`,
                    SUM(`infantsless2m`) AS `infantsless2m`,
                    SUM(`infantsless2mPOS`) AS `infantless2mpos`,
                    SUM(`adults`) AS `adults`,
                    SUM(`adultsPOS`) AS `adultsPOS`,
                    SUM(`redraw`) AS `redraw`,
                    SUM(`tests`) AS `tests`,
                    SUM(`rejected`) AS `rejected`, 
                    AVG(`sitessending`) AS `sitessending` 
                  FROM `site_summary` `ss` 
            WHERE 1";


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

    SET @QUERY = CONCAT(@QUERY, " AND `facility` = '",filter_site,"' ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ss`.`facility`");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
     
END //
DELIMITER ;
