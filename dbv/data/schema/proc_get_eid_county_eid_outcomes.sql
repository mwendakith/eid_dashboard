DROP PROCEDURE IF EXISTS `proc_get_eid_county_eid_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_eid_outcomes`
(IN C_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`pos`) AS `pos`,
        SUM(`neg`) AS `neg`,
        AVG(`medage`) AS `medage`,
        SUM(`alltests`) AS `alltests`,
        SUM(`eqatests`) AS `eqatests`,
        SUM(`firstdna`) AS `firstdna`,
        SUM(`confirmdna`) AS `confirmdna`,
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
    FROM `county_summary`
    WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_id,"' AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_id,"' AND `year` = '",filter_year,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;