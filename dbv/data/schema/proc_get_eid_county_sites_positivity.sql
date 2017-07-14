DROP PROCEDURE IF EXISTS `proc_get_eid_county_sites_positivity`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_sites_positivity`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
						            SUM(`vss`.`actualinfantsPOS`) AS `pos`, 
                        SUM(`vss`.`actualinfants`) AS `alltests`,
                        ((SUM(`vss`.`actualinfantsPOS`)/SUM(`vss`.`actualinfants`))*100) AS `positivity`, 
                        `vf`.`ID`, 
                        `vf`.`name` ";

     IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `site_summary` `vss` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `site_summary_yearly` `vss` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " LEFT JOIN `view_facilitys` `vf` 
                    ON `vss`.`facility`=`vf`.`ID` 
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

    SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",C_id,"' GROUP BY `vf`.`ID` ORDER BY `positivity` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
