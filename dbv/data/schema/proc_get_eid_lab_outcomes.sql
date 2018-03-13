DROP PROCEDURE IF EXISTS `proc_get_eid_lab_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_lab_outcomes`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `l`.`ID`, `l`.`labname` AS `name`, 
                    SUM(`ls`.`pos`+`ls`.`confirmedPOs`+`ls`.`tiebreakerPOS`+`ls`.`repeatposPOS`) AS `pos`,
                    SUM(`ls`.`neg`+(`ls`.`confirmdna`-`ls`.`confirmedPOs`)+(`ls`.`tiebreaker`-`ls`.`tiebreakerPOS`)+(`ls`.`repeatspos`-`ls`.`repeatposPOS`)) AS `neg`,
                    SUM(`redraw`) AS `redraw`
                FROM `lab_summary` `ls`
                JOIN `labs` `l`
                ON `l`.`ID` = `ls`.`lab` 
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
      

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `l`.`ID` ");    
    SET @QUERY = CONCAT(@QUERY, " ORDER BY `l`.`ID` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
