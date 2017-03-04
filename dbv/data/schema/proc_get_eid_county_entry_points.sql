DROP PROCEDURE IF EXISTS `proc_get_county_entry_points`;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_entry_points`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_entry_points`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `ep`.`name`, 
                        SUM(`pos`) AS `positive`, 
                        SUM(`neg`) AS `negative`  
                    FROM `county_entrypoint` `nep` 
                    JOIN `entry_points` `ep` 
                    ON `nep`.`entrypoint` = `ep`.`ID`
                WHERE 1";

    IF (from_month != 0 && from_month != '') THEN
       IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_id,"' AND `nep`.`year` = '",filter_year,"' AND `nep`.`month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_id,"' AND `nep`.`year` = '",filter_year,"' AND `nep`.`month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_id,"' AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ep`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;