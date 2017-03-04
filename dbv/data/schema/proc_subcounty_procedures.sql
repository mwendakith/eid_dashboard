DROP PROCEDURE IF EXISTS `proc_get_eid_subcounty_eid`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_subcounty_eid`
(IN filter_year INT(11), IN filter_month INT(11),  IN filter_subcounty INT(11))
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
                  FROM `subcounty_summary` 
    WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",filter_subcounty,"' AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",filter_subcounty,"' AND `year` = '",filter_year,"' ");
    END IF;


     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_subcounty_hei_follow_up`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_subcounty_hei_follow_up`
(IN filter_year INT(11), IN filter_month INT(11),  IN filter_subcounty INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM((`ss`.`enrolled`)) AS `enrolled`, 
                    SUM(`ss`.`dead`) AS `dead`, 
                    SUM(`ss`.`ltfu`) AS `ltfu`, 
                    SUM(`ss`.`transout`) AS `transout`, 
                    SUM(`ss`.`adult`) AS `adult`, 
                    SUM(`ss`.`other`) AS `other` 
                  FROM `subcounty_summary` `ss` 
    WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",filter_subcounty,"' AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",filter_subcounty,"' AND `year` = '",filter_year,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_subcounty_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_subcounty_age`
(IN C_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  
            SUM(`sixweekspos`) AS `sixweekspos`, 
            SUM(`sixweeksneg`) AS `sixweeksneg`, 
            SUM(`sevento3mpos`) AS `sevento3mpos`, 
            SUM(`sevento3mneg`) AS `sevento3mneg`,
            SUM(`threemto9mpos`) AS `threemto9mpos`, 
            SUM(`threemto9mneg`) AS `threemto9mneg`,
            SUM(`ninemto18mpos`) AS `ninemto18mpos`, 
            SUM(`ninemto18mneg`) AS `ninemto18mneg`,
            SUM(`above18mpos`) AS `above18mpos`, 
            SUM(`above18mneg`) AS `above18mneg`,
            SUM(`nodatapos`) AS `nodatapos`, 
            SUM(`nodataneg`) AS `nodataneg`
          FROM `subcounty_agebreakdown` WHERE 1";
  
    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",C_id,"' AND `year` = '",filter_year,"' AND `month` = '",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",C_id,"' AND `year` = '",filter_year,"' ");
    END IF;
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;