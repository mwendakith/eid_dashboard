DROP PROCEDURE IF EXISTS `proc_get_eid_county_yearly_tests_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_yearly_tests_age`
(IN C_ID INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `cab`.`year`, `cab`.`month`, `ab`.`age_range_id`,  `ab`.`age_range`, 

                    SUM(`cab`.`pos`) AS `pos`,
                    SUM(`cab`.`neg`) AS `neg`

                FROM `county_age_breakdown` `cab`
                  LEFT JOIN `age_bands` `ab` 
                    ON `cab`.`age_band_id` = `ab`.`ID`

                WHERE 1 ";

      SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_ID,"' ");

      SET @QUERY = CONCAT(@QUERY, " GROUP BY `cab`.`month`, `cab`.`year`, `ab`.`age_range_id` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `cab`.`year` DESC, `cab`.`month` ASC, `ab`.`age_range_id` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
