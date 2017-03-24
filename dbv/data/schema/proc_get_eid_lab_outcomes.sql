DROP PROCEDURE IF EXISTS `proc_get_eid_lab_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_lab_outcomes`
(IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `l`.`ID`, `l`.`labname` AS `name`, 
                    SUM(`ls`.`pos`) AS `pos`,
                    SUM(`ls`.`neg`) AS `neg`,
                    SUM(`redraw`) AS `redraw`
                FROM `lab_summary` `ls`
                JOIN `labs` `l`
                ON `l`.`ID` = `ls`.`lab` 
                WHERE 1 ";

       

        IF (from_month != 0 && from_month != '') THEN
           IF (to_month != 0 && to_month != '') THEN
                SET @QUERY = CONCAT(@QUERY, " AND `ls`.`year` = '",filter_year,"' AND `ls`.`month` BETWEEN '",from_month,"' AND '",to_month,"' ");
            ELSE
                SET @QUERY = CONCAT(@QUERY, " AND `ls`.`year` = '",filter_year,"' AND `ls`.`month`='",from_month,"' ");
            END IF;
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `ls`.`year` = '",filter_year,"' ");
        END IF;
      

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `l`.`ID` ");    
    SET @QUERY = CONCAT(@QUERY, " ORDER BY `l`.`ID` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;