DROP PROCEDURE IF EXISTS `proc_get_eid_hei_validation`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_hei_validation`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN type INT(11), IN ID INT(11))
BEGIN
  SET @QUERY =    "SELECT
        `join`.`name`,
        SUM(`validation_confirmedpos`) AS `Confirmed_Positive`,
        SUM(`validation_repeattest`) AS `Repeat_Test`,
        SUM(`validation_viralload`) AS `Viral_Load`,
        SUM(`validation_adult`) AS `Adult`,
        SUM(`validation_unknownsite`) AS `Unknown_Facility`,
        SUM(`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`) AS `Followup_Hei`, 
        SUM(`enrolled`) AS `enrolled`, 
        SUM(`ltfu`) AS `ltfu`, 
        SUM(`adult`) AS `adult`, 
        SUM(`transout`) AS `transout`, 
        SUM(`dead`) AS `dead`, 
        SUM(`other`) AS `other`, 
        sum(`actualinfantsPOS`) AS `positives`, 
        SUM(`actualinfants`-((`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`)-(`validation_repeattest`+`validation_unknownsite`+`validation_adult`+`validation_viralload`))) AS `actualinfants_tests` ";
    
    IF (type = 0) THEN
        IF (ID = 0) THEN 
            IF (from_month != 0 && from_month != '') THEN
              SET @QUERY = CONCAT(@QUERY, " FROM `county_summary` `main` JOIN `countys` `join` ON `join`.`ID` = `main`.`county` WHERE 1 ");
            ELSE
                SET @QUERY = CONCAT(@QUERY, " FROM `county_summary_yearly` `main` JOIN `countys` `join` ON `join`.`ID` = `main`.`county` WHERE 1 ");
            END IF;
        ELSE
            IF (from_month != 0 && from_month != '') THEN
              SET @QUERY = CONCAT(@QUERY, " FROM `county_summary` `main` JOIN `countys` `join` ON `join`.`ID` = `main`.`county` WHERE `main`.`county` = '",ID,"' ");
            ELSE
                SET @QUERY = CONCAT(@QUERY, " FROM `county_summary_yearly` `main` JOIN `countys` `join` ON `join`.`ID` = `main`.`county` WHERE `main`.`county` = '",ID,"' ");
            END IF;
        END IF;
    END IF;
    IF (type = 1) THEN
        IF (ID = 0) THEN 
            IF (from_month != 0 && from_month != '') THEN
              SET @QUERY = CONCAT(@QUERY, " FROM `ip_summary` `main` JOIN `partners` `join` ON `join`.`ID` = `main`.`partner` WHERE `join`.`flag` = '1' ");
            ELSE
                SET @QUERY = CONCAT(@QUERY, " FROM `ip_summary_yearly` `main` JOIN `partners` `join` ON `join`.`ID` = `main`.`partner` WHERE `join`.`flag` = '1' ");
            END IF;
        ELSE
            IF (from_month != 0 && from_month != '') THEN
              SET @QUERY = CONCAT(@QUERY, " FROM `ip_summary` `main` JOIN `partners` `join` ON `join`.`ID` = `main`.`partner` WHERE `main`.`partner` = '",ID,"' AND `join`.`flag` = '1' ");
            ELSE
                SET @QUERY = CONCAT(@QUERY, " FROM `ip_summary_yearly` `main` JOIN `partners` `join` ON `join`.`ID` = `main`.`partner` WHERE `main`.`partner` = '",ID,"' AND `join`.`flag` = '1' ");
            END IF;
        END IF;
    END IF;
    IF (type = 2) THEN
        IF (ID = 0) THEN 
            IF (from_month != 0 && from_month != '') THEN
              SET @QUERY = CONCAT(@QUERY, " FROM `subcounty_summary` `main` JOIN `districts` `join` ON `join`.`ID` = `main`.`subcounty` WHERE 1 ");
            ELSE
                SET @QUERY = CONCAT(@QUERY, " FROM `subcounty_summary_yearly` `main` JOIN `districts` `join` ON `join`.`ID` = `main`.`subcounty` WHERE 1 ");
            END IF;
        ELSE
            IF (from_month != 0 && from_month != '') THEN
              SET @QUERY = CONCAT(@QUERY, " FROM `subcounty_summary` `main` JOIN `districts` `join` ON `join`.`ID` = `main`.`subcounty` WHERE `main`.`subcounty` = '",ID,"' ");
            ELSE
                SET @QUERY = CONCAT(@QUERY, " FROM `subcounty_summary_yearly` `main` JOIN `districts` `join` ON `join`.`ID` = `main`.`subcounty` WHERE `main`.`subcounty` = '",ID,"' ");
            END IF;
        END IF;
    END IF;
    IF (type = 3) THEN
        IF (ID = 0) THEN 
            IF (from_month != 0 && from_month != '') THEN
              SET @QUERY = CONCAT(@QUERY, " FROM `site_summary` `main` JOIN `facilitys` `join` ON `join`.`ID` = `main`.`facility` WHERE 1 ");
            ELSE
                SET @QUERY = CONCAT(@QUERY, " FROM `site_summary_yearly` `main` JOIN `facilitys` `join` ON `join`.`ID` = `main`.`facility` WHERE 1 ");
            END IF;
        ELSE
            IF (from_month != 0 && from_month != '') THEN
              SET @QUERY = CONCAT(@QUERY, " FROM `site_summary` `main` JOIN `facilitys` `join` ON `join`.`ID` = `main`.`facility` WHERE `main`.`facility` = '",ID,"' ");
            ELSE
                SET @QUERY = CONCAT(@QUERY, " FROM `site_summary_yearly` `main` JOIN `facilitys` `join` ON `join`.`ID` = `main`.`facility` WHERE `main`.`facility` = '",ID,"' ");
            END IF;
        END IF;
    END IF;
    
    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `name` ORDER BY `actualinfants_tests` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
     
END //
DELIMITER ;