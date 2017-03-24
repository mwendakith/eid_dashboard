DROP PROCEDURE IF EXISTS `proc_get_eid_sites_eid`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_sites_eid`
(IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11),  IN filter_site INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM((`ss`.`pos`)) AS `pos`, 
                    SUM(`ss`.`neg`) AS `neg`, 
                    SUM(`ss`.`neg`) AS `tests`, 
                    SUM(`ss`.`neg`) AS `rejected` 
                  FROM `site_summary` `ss` 
            WHERE 1";

    IF (from_month != 0 && from_month != '') THEN
       IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `facility` = '",filter_site,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `facility` = '",filter_site,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `facility` = '",filter_site,"' AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ss`.`facility`");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
     
END //
DELIMITER ;