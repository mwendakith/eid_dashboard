DROP PROCEDURE IF EXISTS `proc_get_eid_county_infantsless2m`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_infantsless2m`
(IN C_id INT(11))
BEGIN
  SET @QUERY =  "SELECT 
                    `month`, 
                    `year`, 
                    `infantsless2m` 
                FROM `county_summary`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_id,"' ORDER BY `year`, `month` ASC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
