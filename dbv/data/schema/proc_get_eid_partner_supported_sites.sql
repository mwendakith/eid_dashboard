DROP PROCEDURE IF EXISTS `proc_get_eid_partner_supported_sites`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_supported_sites`
(IN P_id INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                      `view_facilitys`.`DHIScode` AS `DHIS Code`, 
                      `view_facilitys`.`facilitycode` AS `MFL Code`, 
                      `view_facilitys`.`name` AS `Facility`, 
                      `countys`.`name` AS `County` 
                  FROM `view_facilitys` 
                  LEFT JOIN `countys` 
                    ON `view_facilitys`.`county` = `countys`.`ID` 
                  WHERE 1 ";

    SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`partner` = '",P_id,"' ORDER BY `Facility` ASC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
