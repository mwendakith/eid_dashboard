DROP PROCEDURE IF EXISTS `proc_get_eid_partner_yearly_tests_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_yearly_tests_age`
(IN P_ID INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `pab`.`year`, `pab`.`month`, `ab`.`age_range_id`,  `ab`.`age_range`, 

                    SUM(`pab`.`pos`) AS `pos`,
                    SUM(`pab`.`neg`) AS `neg`

                FROM `ip_age_breakdown` `pab`
                  LEFT JOIN `age_bands` `ab` 
                    ON `pab`.`age_band_id` = `ab`.`ID`

                WHERE 1 ";

      SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_ID,"' ");
      SET @QUERY = CONCAT(@QUERY, " GROUP BY `pab`.`month`, `pab`.`year`, `ab`.`age_range_id` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `pab`.`year` DESC, `pab`.`month` ASC, `ab`.`age_range_id` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
