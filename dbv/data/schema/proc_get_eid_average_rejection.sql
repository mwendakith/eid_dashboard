DROP PROCEDURE IF EXISTS `proc_get_eid_average_rejection`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_average_rejection`
(IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `year`, `month`,
                    AVG(`tests`) AS `tests`, 
                    AVG(`rejected`) AS `rejected`
                  FROM `national_summary` 
                  WHERE 1";
				  
	SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    SET @QUERY = CONCAT(@QUERY, " GROUP BY `month` ");
    SET @QUERY = CONCAT(@QUERY, " ORDER BY `month` ASC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;