DROP PROCEDURE IF EXISTS `proc_get_eid_partner_sites_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_sites_outcomes`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
					`vf`.`name`,
					SUM(`cs`.`actualinfantsPOS`) AS `positive`,
          SUM(`cs`.`actualinfants`-`cs`.`actualinfantsPOS`) AS `negative` 
					FROM `site_summary` `ss` 
					LEFT JOIN `view_facilitys` `vf` 
					ON `ss`.`facility` = `vf`.`ID`  
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

    SET @QUERY = CONCAT(@QUERY, " AND `vf`.`partner` = '",P_id,"' ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vf`.`name` ORDER BY `negative` DESC, `positive` DESC LIMIT 0, 50 ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
