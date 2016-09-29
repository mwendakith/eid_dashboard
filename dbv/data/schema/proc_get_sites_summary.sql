DROP PROCEDURE IF EXISTS `proc_get_all_sites_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_all_sites_outcomes`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `vf`.`name`, 
                    SUM((`ss`.`pos`)) AS `pos`, 
                    SUM((`ss`.`neg`)) AS `neg` 
                  FROM `site_summary` `ss` 
                  LEFT JOIN `view_facilitys` `vf` 
                    ON `ss`.`facility` = `vf`.`ID`
    WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ss`.`facility` ORDER BY `neg` DESC, `pos` DESC LIMIT 0, 50 ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_sites_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_sites_trends`
(IN filter_year INT(11), IN filter_site INT(11))
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


DROP PROCEDURE IF EXISTS `proc_get_sites_eid`;
DELIMITER //
CREATE PROCEDURE `proc_get_sites_eid`
(IN filter_year INT(11), IN filter_month INT(11),  IN filter_site INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM((`ss`.`pos`)) AS `pos`, 
                    SUM(`ss`.`neg`) AS `neg`, 
                    SUM(`ss`.`neg`) AS `tests`, 
                    SUM(`ss`.`neg`) AS `rejected` 
                  FROM `site_summary` `ss` 
    WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `facility` = '",filter_site,"' AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `facility` = '",filter_site,"' AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ss`.`facility`");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_sites_hei_follow_up`;
DELIMITER //
CREATE PROCEDURE `proc_get_sites_hei_follow_up`
(IN filter_year INT(11), IN filter_month INT(11),  IN filter_site INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM((`ss`.`enrolled`)) AS `enrolled`, 
                    SUM(`ss`.`dead`) AS `dead`, 
                    SUM(`ss`.`ltfu`) AS `ltfu`, 
                    SUM(`ss`.`transout`) AS `transout` 
                  FROM `site_summary` `ss` 
    WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `facility` = '",filter_site,"' AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `facility` = '",filter_site,"' AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ss`.`facility` ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

