DROP PROCEDURE IF EXISTS `proc_get_eid_national_yearly_tests_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_yearly_tests_age`
()
BEGIN
  SET @QUERY =    "SELECT
                    `nab`.`year`, `nab`.`month`, `ab`.`age_range_id`,  `ab`.`age_range`, 

                    SUM(`nab`.`pos`) AS `pos`,
                    SUM(`nab`.`neg`) AS `neg`

                FROM `national_age_breakdown` `nab`
                  LEFT JOIN `age_bands` `ab` 
                    ON `nab`.`age_band_id` = `ab`.`ID`

                WHERE 1 ";

      SET @QUERY = CONCAT(@QUERY, " GROUP BY `nab`.`month`, `nab`.`year`, `ab`.`age_range_id` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `nab`.`year` DESC, `nab`.`month` ASC, `ab`.`age_range_id` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
