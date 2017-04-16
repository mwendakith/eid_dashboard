DROP PROCEDURE IF EXISTS `proc_get_eid_sites_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_sites_trends`
(IN filter_site INT(11), IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `ss`.`month`, 
                    SUM((`ss`.`pos`)) AS `pos`, 
                    SUM(`ss`.`neg`) AS `neg`,
                    SUM(`ss`.`neg`) AS `tests`,
                    SUM(`ss`.`neg`) AS `rejected`
                  FROM `site_summary` `ss` 
                  LEFT JOIN `view_facilitys` `vf` 
                    ON `ss`.`facility` = `vf`.`ID`
    WHERE 1";

    IF (filter_site != 0 && filter_site != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `facility`='",filter_site,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ss`.`month` ORDER BY `ss`.`month` ASC  ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
