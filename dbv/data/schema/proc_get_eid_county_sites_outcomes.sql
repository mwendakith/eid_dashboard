DROP PROCEDURE IF EXISTS `proc_get_eid_county_sites_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_sites_outcomes`
(IN C_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                      `vf`.`name`,
                      SUM(`pos`) AS `positive`,
                      SUM(`neg`) AS `negative` 
                      FROM `site_summary` `ss` 
                      LEFT JOIN `view_facilitys` `vf` ON `ss`.`facility` = `vf`.`ID`  
                  WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",C_id,"' AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",C_id,"' AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vf`.`name` ORDER BY `negative` DESC, `positive` DESC LIMIT 0, 50 ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;