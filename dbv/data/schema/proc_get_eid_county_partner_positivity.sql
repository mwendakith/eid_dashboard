DROP PROCEDURE IF EXISTS `proc_get_eid_county_partner_positivity`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_partner_positivity`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =  "SELECT 
                    DISTINCT(`p`.`name`) AS `name`,
                    SUM(`actualinfantsPOS`) AS `pos`,
                    SUM(`actualinfants`-`actualinfantsPOS`) AS `neg`,
                    ((SUM(`actualinfantsPOS`)/(SUM(`actualinfants`)))*100) AS `pecentage` ";


     IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `ip_summary` `is` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `ip_summary_yearly` `is` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " LEFT JOIN `partners` `p` 
                  ON `is`.`partner` = `p`.`ID` 
                LEFT JOIN `view_facilitys` `vf`
                    ON `p`.`ID` = `vf`.`partner`
                WHERE 1 ");



   
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

    SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",C_id,"' GROUP BY `name` ORDER BY `pecentage` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
