DROP PROCEDURE IF EXISTS `proc_get_eid_subcounty_hei_follow_up`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_subcounty_hei_follow_up`
(IN filter_subcounty INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
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

    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",filter_subcounty,"' ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
