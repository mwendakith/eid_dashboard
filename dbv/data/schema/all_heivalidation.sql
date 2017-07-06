-- DROP PROCEDURE IF EXISTS `proc_get_eid_county_hei_validation`;
-- DELIMITER //
-- CREATE PROCEDURE `proc_get_eid_county_hei_validation`
-- (IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
-- BEGIN
--   SET @QUERY =    "SELECT
--         SUM(`validation_confirmedpos`) AS `Confirmed Positive`,
--         SUM(`validation_repeattest`) AS `Repeat Test`,
--         AVG(`validation_viralload`) AS `Viral Load`,
--         SUM(`validation_adult`) AS `Adult`,
--         SUM(`validation_unknownsite`) AS `Unknown Facility`,
--         SUM(`validation_confirmedpos`+`validation_repeattest`+`validation_unknownsite`+`validation_adult`+`validation_viralload`) AS `followup_positives`, 
--         sum(`actualinfantsPOS`) AS `positives`, 
--         SUM(`tests`-(`validation_repeattest`+`validation_unknownsite`+`validation_adult`+`validation_viralload`)) AS `true_tests` 
--     FROM `county_summary`
--     WHERE 1";


--     IF (from_month != 0 && from_month != '') THEN
--       IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
--             SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
--         ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
--           SET @QUERY = CONCAT(@QUERY, " AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
--         ELSE
--             SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
--         END IF;
--     END IF;
--     ELSE
--         SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
--     END IF;

--     SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_id,"' ");

--      PREPARE stmt FROM @QUERY;
--      EXECUTE stmt;
-- END //
-- DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_county_hei_validation`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_hei_validation`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`validation_confirmedpos`) AS `Confirmed Positive`,
        SUM(`validation_repeattest`) AS `Repeat Test`,
        AVG(`validation_viralload`) AS `Viral Load`,
        SUM(`validation_adult`) AS `Adult`,
        SUM(`validation_unknownsite`) AS `Unknown Facility`,
        SUM(`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`) AS `followup_hei`, 
        sum(`actualinfantsPOS`) AS `positives`, 
        SUM(`actualinfants`-((`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`)-(`validation_repeattest`+`validation_unknownsite`+`validation_adult`+`validation_viralload`))) AS `true_tests` 
    FROM `county_summary`
    WHERE 1";


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

    SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_id,"' ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_national_hei_validation`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_hei_validation`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`validation_confirmedpos`) AS `Confirmed Positive`,
        SUM(`validation_repeattest`) AS `Repeat Test`,
        AVG(`validation_viralload`) AS `Viral Load`,
        SUM(`validation_adult`) AS `Adult`,
        SUM(`validation_unknownsite`) AS `Unknown Facility`,
        SUM(`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`) AS `followup_hei`, 
        sum(`actualinfantsPOS`) AS `positives`, 
        SUM(`actualinfants`-((`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`)-(`validation_repeattest`+`validation_unknownsite`+`validation_adult`+`validation_viralload`))) AS `true_tests` 
        FROM `national_summary`
    WHERE 1";

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

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
     
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_partner_hei_validation`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_hei_validation`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`validation_confirmedpos`) AS `Confirmed Positive`,
        SUM(`validation_repeattest`) AS `Repeat Test`,
        AVG(`validation_viralload`) AS `Viral Load`,
        SUM(`validation_adult`) AS `Adult`,
        SUM(`validation_unknownsite`) AS `Unknown Facility`,
        SUM(`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`) AS `followup_hei`, 
        sum(`actualinfantsPOS`) AS `positives`, 
        SUM(`actualinfants`-((`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`)-(`validation_repeattest`+`validation_unknownsite`+`validation_adult`+`validation_viralload`))) AS `true_tests`
    FROM `ip_summary`
    WHERE 1";

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

    SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_subcounty_hei_validation`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_subcounty_hei_validation`
(IN filter_subcounty INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`validation_confirmedpos`) AS `Confirmed Positive`,
        SUM(`validation_repeattest`) AS `Repeat Test`,
        AVG(`validation_viralload`) AS `Viral Load`,
        SUM(`validation_adult`) AS `Adult`,
        SUM(`validation_unknownsite`) AS `Unknown Facility`,
        SUM(`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`) AS `followup_hei`, 
        sum(`actualinfantsPOS`) AS `positives`, 
        SUM(`actualinfants`-((`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`)-(`validation_repeattest`+`validation_unknownsite`+`validation_adult`+`validation_viralload`))) AS `true_tests` 
                  FROM `subcounty_summary` 
    WHERE 1";


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

    SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",filter_subcounty,"' ");


     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ; 

DROP PROCEDURE IF EXISTS `proc_get_eid_site_hei_validation`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_site_hei_validation`
(IN filter_site INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
       SUM(`validation_confirmedpos`) AS `Confirmed Positive`,
        SUM(`validation_repeattest`) AS `Repeat Test`,
        AVG(`validation_viralload`) AS `Viral Load`,
        SUM(`validation_adult`) AS `Adult`,
        SUM(`validation_unknownsite`) AS `Unknown Facility`,
        SUM(`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`) AS `followup_hei`, 
        sum(`actualinfantsPOS`) AS `positives`, 
        SUM(`actualinfants`-((`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`)-(`validation_repeattest`+`validation_unknownsite`+`validation_adult`+`validation_viralload`))) AS `true_tests`  
                  FROM `site_summary` 
            WHERE 1";


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

    SET @QUERY = CONCAT(@QUERY, " AND `facility` = '",filter_site,"' ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
     
END //
DELIMITER ;

-- ************************************* --
-- Yearly
-- ************************************* --
DROP PROCEDURE IF EXISTS `proc_get_eid_county_yearly_hei_validation`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_yearly_hei_validation`
(IN C_id INT(11), IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`validation_confirmedpos`) AS `Confirmed Positive`,
        SUM(`validation_repeattest`) AS `Repeat Test`,
        AVG(`validation_viralload`) AS `Viral Load`,
        SUM(`validation_adult`) AS `Adult`,
        SUM(`validation_unknownsite`) AS `Unknown Facility`,
        SUM(`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`) AS `followup_hei`, 
        sum(`actualinfantsPOS`) AS `positives`, 
        SUM(`actualinfants`-((`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`)-(`validation_repeattest`+`validation_unknownsite`+`validation_adult`+`validation_viralload`))) AS `true_tests` 
    FROM `county_summary_yearly`
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_id,"' AND `year` = '",filter_year,"' ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_national_yearly_hei_validation`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_yearly_hei_validation`
(IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`validation_confirmedpos`) AS `Confirmed Positive`,
        SUM(`validation_repeattest`) AS `Repeat Test`,
        AVG(`validation_viralload`) AS `Viral Load`,
        SUM(`validation_adult`) AS `Adult`,
        SUM(`validation_unknownsite`) AS `Unknown Facility`,
        SUM(`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`) AS `followup_hei`, 
        sum(`actualinfantsPOS`) AS `positives`, 
        SUM(`actualinfants`-((`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`)-(`validation_repeattest`+`validation_unknownsite`+`validation_adult`+`validation_viralload`))) AS `true_tests` 
        FROM `national_summary_yearly`
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
     
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_partner_yearly_hei_validation`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_yearly_hei_validation`
(IN P_id INT(11), IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`validation_confirmedpos`) AS `Confirmed Positive`,
        SUM(`validation_repeattest`) AS `Repeat Test`,
        AVG(`validation_viralload`) AS `Viral Load`,
        SUM(`validation_adult`) AS `Adult`,
        SUM(`validation_unknownsite`) AS `Unknown Facility`,
        SUM(`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`) AS `followup_hei`, 
        sum(`actualinfantsPOS`) AS `positives`, 
        SUM(`actualinfants`-((`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`)-(`validation_repeattest`+`validation_unknownsite`+`validation_adult`+`validation_viralload`))) AS `true_tests`
    FROM `ip_summary_yearly`
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` = '",filter_year,"' ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_subcounty_yearly_hei_validation`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_subcounty_yearly_hei_validation`
(IN filter_subcounty INT(11), IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    SUM(`validation_confirmedpos`) AS `Confirmed Positive`,
                    SUM(`validation_repeattest`) AS `Repeat Test`,
                    AVG(`validation_viralload`) AS `Viral Load`,
                    SUM(`validation_adult`) AS `Adult`,
                    SUM(`validation_unknownsite`) AS `Unknown Facility`,
                    SUM(`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`) AS `followup_hei`, 
                    sum(`actualinfantsPOS`) AS `positives`, 
                    SUM(`actualinfants`-((`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`)-(`validation_repeattest`+`validation_unknownsite`+`validation_adult`+`validation_viralload`))) AS `true_tests` 
                  FROM `subcounty_summary_yearly` 
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",filter_subcounty,"' AND `year` = '",filter_year,"' ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ; 

DROP PROCEDURE IF EXISTS `proc_get_eid_site_yearly_hei_validation`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_site_yearly_hei_validation`
(IN filter_site INT(11), IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    SUM(`validation_confirmedpos`) AS `Confirmed Positive`,
                    SUM(`validation_repeattest`) AS `Repeat Test`,
                    AVG(`validation_viralload`) AS `Viral Load`,
                    SUM(`validation_adult`) AS `Adult`,
                    SUM(`validation_unknownsite`) AS `Unknown Facility`,
                    SUM(`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`) AS `followup_hei`, 
                    sum(`actualinfantsPOS`) AS `positives`, 
                    SUM(`actualinfants`-((`enrolled`+`ltfu`+`adult`+`transout`+`dead`+`other`)-(`validation_repeattest`+`validation_unknownsite`+`validation_adult`+`validation_viralload`))) AS `true_tests`  
                  FROM `site_summary_yearly` 
            WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `facility` = '",filter_site,"' AND `year` = '",filter_year,"' ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
     
END //
DELIMITER ;

-- ************************* --
-- HEI follow up Yearly
-- ************************* --
DROP PROCEDURE IF EXISTS `proc_get_eid_partner_yearly_hei`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_yearly_hei`
(IN P_id INT(11), IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`enrolled`) AS `enrolled`,
        SUM(`dead`) AS `dead`,
        SUM(`ltfu`) AS `ltfu`,
        SUM(`adult`) AS `adult`,
        SUM(`transout`) AS `transout`,
        SUM(`other`) AS `other`
    FROM `ip_summary_yearly`
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` = '",filter_year,"' ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_national_yearly_hei`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_yearly_hei`
(IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`enrolled`) AS `enrolled`,
        SUM(`dead`) AS `dead`,
        SUM(`ltfu`) AS `ltfu`,
        SUM(`adult`) AS `adult`,
        SUM(`transout`) AS `transout`,
        SUM(`other`) AS `other`
    FROM `national_summary_yearly`
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
     
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_county_yearly_hei`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_yearly_hei`
(IN C_id INT(11), IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`enrolled`) AS `enrolled`,
        SUM(`dead`) AS `dead`,
        SUM(`ltfu`) AS `ltfu`,
        SUM(`adult`) AS `adult`,
        SUM(`transout`) AS `transout`,
        SUM(`other`) AS `other`
    FROM `county_summary_yearly`
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_id,"' AND `year` = '",filter_year,"' ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
     
END //
DELIMITER ;
