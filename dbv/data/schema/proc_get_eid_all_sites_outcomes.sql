DROP PROCEDURE IF EXISTS `proc_get_eid_all_sites_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_all_sites_outcomes`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `vf`.`name`,
                    `ss`.`facility`, 
                    SUM(`ss`.`pos`) AS `pos`, 
                    SUM(`ss`.`neg`) AS `neg` 
                  FROM `site_summary` `ss` 
                  JOIN `view_facilitys` `vf` ON `ss`.`facility` = `vf`.`ID` 
    WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `ss`.`year` = '",filter_year,"' AND `ss`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `ss`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ss`.`facility` ORDER BY `pos`, `neg` DESC LIMIT 0, 50 ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;