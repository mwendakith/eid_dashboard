DROP PROCEDURE IF EXISTS `proc_get_eid_unsupported_facilities`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_unsupported_facilities`
()
BEGIN
  SET @QUERY =    "SELECT  
            `vf`.`facilitycode`, `vf`.`name`, `d`.`name` AS `subcounty`, `c`.`name` AS `county`
          FROM `view_facilitys` `vf` 
          JOIN `districts` `d` ON `vf`.`district` = `d`.`ID`
          JOIN `countys` `c` ON `vf`.`county` = `c`.`ID`
          WHERE 1 AND `partner`=0 ";
  
    
    SET @QUERY = CONCAT(@QUERY, " ORDER BY `vf`.`name` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;