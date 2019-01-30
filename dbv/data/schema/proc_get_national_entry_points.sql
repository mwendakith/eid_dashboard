DROP PROCEDURE IF EXISTS `proc_get_national_entry_points`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_entry_points`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
						`ep`.`name`, 
						SUM(`pos`) AS `positive`, 
						SUM(`neg`) AS `negative`  
					FROM `national_entrypoint` `nep` 
					JOIN `entry_points` `ep` 
					ON `nep`.`entrypoint` = `ep`.`ID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `nep`.`year` = '",filter_year,"' AND `nep`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `nep`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ep`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;