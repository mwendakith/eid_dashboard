DROP PROCEDURE IF EXISTS `proc_get_national_iprophylaxis`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_iprophylaxis`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
						`p`.`name`, 
						SUM(`pos`) AS `positive`, 
						SUM(`neg`) AS `negative` 
					FROM `national_iprophylaxis` `nip` 
					JOIN `prophylaxis` `p` ON `nip`.`prophylaxis` = `p`.`ID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `nip`.`year` = '",filter_year,"' AND `nip`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `nip`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `p`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
