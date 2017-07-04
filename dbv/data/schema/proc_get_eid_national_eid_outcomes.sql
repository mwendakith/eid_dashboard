DROP PROCEDURE IF EXISTS `proc_get_eid_national_eid_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_eid_outcomes`
(IN filter_year INT(11), IN to_year INT(11))
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
    FROM `national_summary_yearly`
    WHERE 1";

    IF (to_year != 0 && to_year != '') THEN
        SET @QUERY = CONCAT(@QUERY, " AND `year` BETWEEN '",filter_year,"' AND '",to_year,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
     
END //
DELIMITER ;
