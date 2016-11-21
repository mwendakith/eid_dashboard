DROP PROCEDURE IF EXISTS `proc_get_eid_partner_sites_details`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_sites_details`
(IN P_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                  `view_facilitys`.`facilitycode` AS `MFLCode`, 
                  `view_facilitys`.`name`, 
                  `countys`.`name` AS `county`, 
                  SUM(`tests`) AS `tests`, 
                  SUM(`firstdna`) AS `firstdna`, 
                  SUM(`confirmdna`) AS `confirmdna`,
                  SUM(`pos`) AS `positive`, 
                  SUM(`neg`) AS `negative`, 
                  SUM(`redraw`) AS `redraw`, 
                  SUM(`adults`) AS `adults`, 
                  SUM(`adultsPOS`) AS `adultspos`, 
                  SUM(`medage`) AS `medage`, 
                  SUM(`rejected`) AS `rejected`, 
                  SUM(`infantsless2m`) AS `infantsless2m`, 
                  SUM(`infantsless2mPOS`) AS `infantsless2mpos` 
                  FROM `site_summary` 
                  LEFT JOIN `view_facilitys` ON `site_summary`.`facility` = `view_facilitys`.`ID` 
                  LEFT JOIN `countys` ON `view_facilitys`.`county` = `countys`.`ID`  WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`partner` = '",P_id,"' AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`partner` = '",P_id,"' AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `view_facilitys`.`ID` ORDER BY `tests` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;