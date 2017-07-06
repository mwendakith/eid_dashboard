DROP PROCEDURE IF EXISTS `proc_get_county_positivity_yearly_notification`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_positivity_yearly_notification`
(IN C_Id INT(11), IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
                        SUM(`actualinfantsPOS`) AS `positive`, 
                        ((SUM(`actualinfantsPOS`)/SUM(`actualinfants`))*100) AS `positivity_rate` 
                    FROM `county_summary_yearly`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"'  ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
