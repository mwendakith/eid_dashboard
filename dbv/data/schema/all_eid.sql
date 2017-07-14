DROP PROCEDURE IF EXISTS `proc_get_eid_national_age_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_age_summary`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
  					SUM(`infantsless2m`) AS `infantsless2m`,       
					SUM(`infantsless2mPOS`) AS `infantsless2mPOS`,     
					SUM(`infantsless2w`) AS `infantsless2w`,       
					SUM(`infantsless2wPOS`) AS `infantsless2wPOS`,    
					SUM(`infants4to6w`) AS `infants4to6w`,        
					SUM(`infants4to6wPOS`) AS `infants4to6wPOS`,     
					SUM(`infantsabove2m`) AS `infantsabove2m`,      
					SUM(`infantsabove2mPOS`) AS `infantsabove2mPOS`,   
					SUM(`adults`) AS `adults`,              
					SUM(`adultsPOS`) AS `adultsPOS`            
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

DROP PROCEDURE IF EXISTS `proc_get_eid_county_age_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_age_summary`
(IN C_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
            SUM(`infantsless2m`) AS `infantsless2m`,       
          SUM(`infantsless2mPOS`) AS `infantsless2mPOS`,     
          SUM(`infantsless2w`) AS `infantsless2w`,       
          SUM(`infantsless2wPOS`) AS `infantsless2wPOS`,    
          SUM(`infants4to6w`) AS `infants4to6w`,        
          SUM(`infants4to6wPOS`) AS `infants4to6wPOS`,     
          SUM(`infantsabove2m`) AS `infantsabove2m`,      
          SUM(`infantsabove2mPOS`) AS `infantsabove2mPOS`,   
          SUM(`adults`) AS `adults`,              
          SUM(`adultsPOS`) AS `adultsPOS`            
          FROM `county_summary`
    WHERE 1";


    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_subcounty_age_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_subcounty_age_summary`
(IN SC_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
            SUM(`infantsless2m`) AS `infantsless2m`,       
          SUM(`infantsless2mPOS`) AS `infantsless2mPOS`,     
          SUM(`infantsless2w`) AS `infantsless2w`,       
          SUM(`infantsless2wPOS`) AS `infantsless2wPOS`,    
          SUM(`infants4to6w`) AS `infants4to6w`,        
          SUM(`infants4to6wPOS`) AS `infants4to6wPOS`,     
          SUM(`infantsabove2m`) AS `infantsabove2m`,      
          SUM(`infantsabove2mPOS`) AS `infantsabove2mPOS`,   
          SUM(`adults`) AS `adults`,              
          SUM(`adultsPOS`) AS `adultsPOS`            
          FROM `subcounty_summary`
    WHERE 1";


    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND `year` = '",filter_year,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_national_age_breakdown`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_age_breakdown`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM(`less2wpos`) AS `less2wpos`,
                    SUM(`less2wneg`) AS `less2wneg`,
                    SUM(`twoto6wpos`) AS `twoto6wpos`,
                    SUM(`twoto6wneg`) AS `twoto6wneg`,
                    SUM(`sixto8wpos`) AS `sixto8wpos`,
                    SUM(`sixto8wneg`) AS `sixto8wneg`,
                    SUM(`sixmonthpos`) AS `sixmonthpos`,
                    SUM(`sixmonthneg`) AS `sixmonthneg`,
                    SUM(`ninemonthpos`) AS `ninemonthpos`,
                    SUM(`ninemonthneg`) AS `ninemonthneg`,
                    SUM(`twelvemonthpos`) AS `twelvemonthpos`,
                    SUM(`twelvemonthneg`) AS `twelvemonthneg`
                    FROM national_agebreakdown
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

DROP PROCEDURE IF EXISTS `proc_get_eid_county_age_breakdown`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_age_breakdown`
(IN C_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM(`less2wpos`) AS `less2wpos`,
                    SUM(`less2wneg`) AS `less2wneg`,
                    SUM(`twoto6wpos`) AS `twoto6wpos`,
                    SUM(`twoto6wneg`) AS `twoto6wneg`,
                    SUM(`sixto8wpos`) AS `sixto8wpos`,
                    SUM(`sixto8wneg`) AS `sixto8wneg`,
                    SUM(`sixmonthpos`) AS `sixmonthpos`,
                    SUM(`sixmonthneg`) AS `sixmonthneg`,
                    SUM(`ninemonthpos`) AS `ninemonthpos`,
                    SUM(`ninemonthneg`) AS `ninemonthneg`,
                    SUM(`twelvemonthpos`) AS `twelvemonthpos`,
                    SUM(`twelvemonthneg`) AS `twelvemonthneg`
                    FROM county_agebreakdown
    WHERE 1";


    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_subcounty_age_breakdown`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_subcounty_age_breakdown`
(IN SC_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM(`less2wpos`) AS `less2wpos`,
                    SUM(`less2wneg`) AS `less2wneg`,
                    SUM(`twoto6wpos`) AS `twoto6wpos`,
                    SUM(`twoto6wneg`) AS `twoto6wneg`,
                    SUM(`sixto8wpos`) AS `sixto8wpos`,
                    SUM(`sixto8wneg`) AS `sixto8wneg`,
                    SUM(`sixmonthpos`) AS `sixmonthpos`,
                    SUM(`sixmonthneg`) AS `sixmonthneg`,
                    SUM(`ninemonthpos`) AS `ninemonthpos`,
                    SUM(`ninemonthneg`) AS `ninemonthneg`,
                    SUM(`twelvemonthpos`) AS `twelvemonthpos`,
                    SUM(`twelvemonthneg`) AS `twelvemonthneg`
                    FROM subcounty_agebreakdown
    WHERE 1";


    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND `year` = '",filter_year,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;-- DROP PROCEDURE IF EXISTS `proc_get_eid_county_hei_validation`;
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

DROP PROCEDURE IF EXISTS `proc_get_eid_subcounty_yearly_hei_follow_up`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_subcounty_yearly_hei_follow_up`
(IN filter_subcounty INT(11), IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM((`ss`.`enrolled`)) AS `enrolled`, 
                    SUM(`ss`.`dead`) AS `dead`, 
                    SUM(`ss`.`ltfu`) AS `ltfu`, 
                    SUM(`ss`.`transout`) AS `transout`, 
                    SUM(`ss`.`adult`) AS `adult`, 
                    SUM(`ss`.`other`) AS `other` 
                  FROM `subcounty_summary_yearly` `ss` 
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",filter_subcounty,"' AND `year` = '",filter_year,"' ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_sites_yearly_hei_follow_up`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_sites_yearly_hei_follow_up`
(IN filter_site INT(11), IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM((`ss`.`enrolled`)) AS `enrolled`, 
                    SUM(`ss`.`dead`) AS `dead`, 
                    SUM(`ss`.`ltfu`) AS `ltfu`, 
                    SUM(`ss`.`transout`) AS `transout`, 
                    SUM(`ss`.`adult`) AS `adult`, 
                    SUM(`ss`.`other`) AS `other` 
                  FROM `site_summary_yearly` `ss` 
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `facility` = '",filter_site,"' AND `year` = '",filter_year,"' ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ss`.`facility` ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
     
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_rht_pos_trend`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_rht_pos_trend`
(IN filter_county INT(11), IN filter_year INT(11), IN filter_result INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    MONTH(`rs`.`datetested`) AS `month`, 
                    COUNT(*) AS `tests`
                  FROM `rht_samples` `rs` 
                  LEFT JOIN `view_facilitys` `vf` 
                    ON `rs`.`facility` = `vf`.`ID`
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND YEAR(`datetested`) = '",filter_year,"' ");

    
    IF (filter_result != 0 && filter_result != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `rs`.`result` = '",filter_result,"' ");
    END IF;

    IF (filter_county != 0 && filter_county != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",filter_county,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `month` ORDER BY `month` ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_rht_yearly_trend`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_rht_yearly_trend`
(IN filter_county INT(11), IN filter_result INT(11))
BEGIN
  SET @QUERY =    "SELECT  
                    YEAR(`rs`.`datetested`) AS `year`, 
                    MONTH(`rs`.`datetested`) AS `month`,
                    COUNT(*) AS `tests`
                  FROM `rht_samples` `rs` 
                  LEFT JOIN `view_facilitys` `vf` 
                    ON `rs`.`facility` = `vf`.`ID`
    WHERE 1";

    
    IF (filter_result != 0 && filter_result != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `rs`.`result` = '",filter_result,"' ");
    END IF;

    IF (filter_county != 0 && filter_county != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",filter_county,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `month`, `year` ORDER BY `year` DESC, `month` ASC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_rht_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_rht_outcomes`
(IN filter_county INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN filter_result INT(11), IN filter_gender VARCHAR(11))
BEGIN
  SET @QUERY =    "SELECT 
                    COUNT(*) AS `tests` 
                  FROM `rht_samples` `rs` 
                  LEFT JOIN `view_facilitys` `vf` 
                    ON `rs`.`facility` = `vf`.`ID`
    WHERE 1";

    IF (filter_county != 0 && filter_county != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",filter_county,"' ");
    END IF;

    IF (filter_gender != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `rs`.`gender` = '",filter_gender,"' ");
    END IF;

    IF (filter_result != 0 && filter_result != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `rs`.`result` = '",filter_result,"' ");
    END IF;

    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
        SET @QUERY = CONCAT(@QUERY, " AND YEAR(`datetested`) = '",filter_year,"' AND MONTH(`datetested`) BETWEEN '",from_month,"' AND '",to_month,"' ");
      ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
        SET @QUERY = CONCAT(@QUERY, " AND ((YEAR(`datetested`) = '",filter_year,"' AND MONTH(`datetested`) >= '",from_month,"')  OR (YEAR(`datetested`) = '",to_year,"' AND MONTH(`datetested`) <= '",to_month,"') OR (YEAR(`datetested`) > '",filter_year,"' AND YEAR(`datetested`) < '",to_year,"')) ");
      ELSE
        SET @QUERY = CONCAT(@QUERY, " AND YEAR(`datetested`) = '",filter_year,"' AND MONTH(`datetested`)='",from_month,"' ");
      END IF;
    END IF;
    ELSE
      SET @QUERY = CONCAT(@QUERY, " AND YEAR(`datetested`) = '",filter_year,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_rht_facility_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_rht_facility_outcomes`
(IN filter_county INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN filter_result INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    DISTINCT(`rs`.`facility`) AS `facility`,
                    `vf`.`name` AS `name`,
                    COUNT(*) AS `tests` 
                  FROM `rht_samples` `rs` 
                  LEFT JOIN `view_facilitys` `vf` 
                    ON `rs`.`facility` = `vf`.`ID`
    WHERE 1";

    IF (filter_county != 0 && filter_county != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",filter_county,"' ");
    END IF;


    IF (filter_result != 0 && filter_result != '') THEN
      SET @QUERY = CONCAT(@QUERY, " AND `rs`.`result` = '",filter_result,"' ");
    END IF;

    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
        SET @QUERY = CONCAT(@QUERY, " AND YEAR(`datetested`) = '",filter_year,"' AND MONTH(`datetested`) BETWEEN '",from_month,"' AND '",to_month,"' ");
      ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
        SET @QUERY = CONCAT(@QUERY, " AND ((YEAR(`datetested`) = '",filter_year,"' AND MONTH(`datetested`) >= '",from_month,"')  OR (YEAR(`datetested`) = '",to_year,"' AND MONTH(`datetested`) <= '",to_month,"') OR (YEAR(`datetested`) > '",filter_year,"' AND YEAR(`datetested`) < '",to_year,"')) ");
      ELSE
        SET @QUERY = CONCAT(@QUERY, " AND YEAR(`datetested`) = '",filter_year,"' AND MONTH(`datetested`)='",from_month,"' ");
      END IF;
    END IF;
    ELSE
      SET @QUERY = CONCAT(@QUERY, " AND YEAR(`datetested`) = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `rs`.`facility` ORDER BY `tests` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_county_positivity_notification`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_positivity_notification`
(IN C_ID INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                        SUM(`actualinfantsPOS`) AS `positive`, 
                        ((SUM(`actualinfantsPOS`)/SUM(`actualinfants`))*100) AS `positivity_rate` 
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

    SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_ID,"' ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_county_positivity_yearly_notification`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_positivity_yearly_notification`
(IN C_Id INT(11), IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
                        SUM(`actualinfantsPOS`) AS `positive`, 
                        ((SUM(`actualinfantsPOS`)/SUM(`actualinfants`))*100) AS `positivity_rate` 
                    FROM `county_summary_yearly`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"'  ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_all_sites_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_all_sites_outcomes`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `vf`.`name`, 
                    SUM((`ss`.`actualinfantsPOS`)) AS `pos`, 
                    SUM((`ss`.`actualinfants`-`ss`.`actualinfantsPOS`)) AS `neg` 
                  FROM `site_summary` `ss` 
                  LEFT JOIN `view_facilitys` `vf` 
                    ON `ss`.`facility` = `vf`.`ID`
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ss`.`facility` ORDER BY `neg` DESC, `pos` DESC LIMIT 0, 50 ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_average_rejection`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_average_rejection`
(IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `year`, `month`,
                    AVG(`tests`) AS `tests`, 
                    AVG(`rejected`) AS `rejected`
                  FROM `national_summary` 
                  WHERE 1";
				  
	SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    SET @QUERY = CONCAT(@QUERY, " GROUP BY `month` ");
    SET @QUERY = CONCAT(@QUERY, " ORDER BY `month` ASC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_counties_positivity_mixed`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_counties_positivity_mixed`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =  "SELECT 
                    `c`.`name`,
                    SUM(`actualinfantsPOS`) AS `pos`,
                    SUM(`actualinfants`-`actualinfantsPOS`) AS `neg`,
                    SUM(`actualinfants`) AS `tests`,
                    ((SUM(`actualinfantsPOS`)/(SUM(`actualinfants`)))*100) AS `pecentage`
                ";

     IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `county_summary` `cs` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `county_summary_yearly` `cs` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " LEFT JOIN countys `c`
                    ON c.ID = cs.county WHERE 1 ");


   
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `c`.`name` ORDER BY `tests` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_counties_positivity_stats`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_counties_positivity_stats`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =  "SELECT 
                    `c`.`name`,
                    SUM(`actualinfantsPOS`) AS `pos`,
                    SUM(`actualinfants`-`actualinfantsPOS`) AS `neg`,
                    ((SUM(`actualinfantsPOS`)/(SUM(`actualinfants`)))*100) AS `pecentage`";

     IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `county_summary` `cs` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `county_summary_yearly` `cs` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " LEFT JOIN countys `c`
                    ON c.ID = cs.county WHERE 1 ");

   
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `c`.`name` ORDER BY `pecentage` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_age_breakdown`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_age_breakdown`
(IN C_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM(`less2wpos`) AS `less2wpos`,
                    SUM(`less2wneg`) AS `less2wneg`,
                    SUM(`twoto6wpos`) AS `twoto6wpos`,
                    SUM(`twoto6wneg`) AS `twoto6wneg`,
                    SUM(`sixto8wpos`) AS `sixto8wpos`,
                    SUM(`sixto8wneg`) AS `sixto8wneg`,
                    SUM(`sixmonthpos`) AS `sixmonthpos`,
                    SUM(`sixmonthneg`) AS `sixmonthneg`,
                    SUM(`ninemonthpos`) AS `ninemonthpos`,
                    SUM(`ninemonthneg`) AS `ninemonthneg`,
                    SUM(`twelvemonthpos`) AS `twelvemonthpos`,
                    SUM(`twelvemonthneg`) AS `twelvemonthneg`
                    FROM county_agebreakdown
    WHERE 1";


    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_age_positivity`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_age_positivity`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        SUM(`nodatapos`) AS `nodatapos`,
                        SUM(`nodataneg`) AS `nodataneg`,
                        SUM(`less2wpos`) AS `less2wpos`,
                        SUM(`less2wneg`) AS `less2wneg`,
                        SUM(`twoto6wpos`) AS `twoto6wpos`,
                        SUM(`twoto6wneg`) AS `twoto6wneg`,
                        SUM(`sixto8wpos`) AS `sixto8wpos`,
                        SUM(`sixto8wneg`) AS `sixto8wneg`,
                        SUM(`sixmonthpos`) AS `sixmonthpos`,
                        SUM(`sixmonthneg`) AS `sixmonthneg`,
                        SUM(`ninemonthpos`) AS `ninemonthpos`,
                        SUM(`ninemonthneg`) AS `ninemonthneg`,
                        SUM(`twelvemonthpos`) AS `twelvemonthpos`,
                        SUM(`twelvemonthneg`) AS `twelvemonthneg`
                    FROM `county_agebreakdown` 
                WHERE 1 ";

   
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
DROP PROCEDURE IF EXISTS `proc_get_county_age`;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_age`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  
            SUM(`sixweekspos`) AS `sixweekspos`, 
            SUM(`sixweeksneg`) AS `sixweeksneg`, 
            SUM(`sevento3mpos`) AS `sevento3mpos`, 
            SUM(`sevento3mneg`) AS `sevento3mneg`,
            SUM(`threemto9mpos`) AS `threemto9mpos`, 
            SUM(`threemto9mneg`) AS `threemto9mneg`,
            SUM(`ninemto18mpos`) AS `ninemto18mpos`, 
            SUM(`ninemto18mneg`) AS `ninemto18mneg`,
            SUM(`above18mpos`) AS `above18mpos`, 
            SUM(`above18mneg`) AS `above18mneg`,
            SUM(`nodatapos`) AS `nodatapos`, 
            SUM(`nodataneg`) AS `nodataneg`
          FROM `county_agebreakdown` WHERE 1";
  

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
DROP PROCEDURE IF EXISTS `proc_get_eid_county_age_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_age_summary`
(IN C_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
  					SUM(`infantsless2m`) AS `infantsless2m`,       
					SUM(`infantsless2mPOS`) AS `infantsless2mPOS`,     
					SUM(`infantsless2w`) AS `infantsless2w`,       
					SUM(`infantsless2wPOS`) AS `infantsless2wPOS`,    
					SUM(`infants4to6w`) AS `infants4to6w`,        
					SUM(`infants4to6wPOS`) AS `infants4to6wPOS`,     
					SUM(`infantsabove2m`) AS `infantsabove2m`,      
					SUM(`infantsabove2mPOS`) AS `infantsabove2mPOS`,   
					SUM(`adults`) AS `adults`,              
					SUM(`adultsPOS`) AS `adultsPOS`            
					FROM `county_summary`
    WHERE 1";


    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_eid_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_eid_outcomes`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`pos`) AS `pos`,
        SUM(`neg`) AS `neg`,
        AVG(`medage`) AS `medage`,
        SUM(`alltests`) AS `alltests`,
        SUM(`eqatests`) AS `eqatests`,
        SUM(`firstdna`) AS `firstdna`,
        SUM(`confirmdna`) AS `confirmdna`,
        SUM(`confirmedPOS`) AS `confirmpos`,
        SUM(`repeatspos`) AS `repeatspos`,
        SUM(`actualinfants`) AS `actualinfants`,
        SUM(`actualinfantsPOS`) AS `actualinfantspos`,
        SUM(`infantsless2m`) AS `infantsless2m`,
        SUM(`infantsless2mPOS`) AS `infantless2mpos`,
        SUM(`adults`) AS `adults`,
        SUM(`adultsPOS`) AS `adultsPOS`,
        SUM(`redraw`) AS `redraw`,
        SUM(`tests`) AS `tests`,
        SUM(`rejected`) AS `rejected`, 
        AVG(`sitessending`) AS `sitessending`";


    IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `county_summary` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `county_summary_yearly` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " WHERE 1 ");


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
DROP PROCEDURE IF EXISTS `proc_get_county_entry_points`;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_entry_points`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_entry_points`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `ep`.`name`, 
                        SUM(`pos`) AS `positive`, 
                        SUM(`neg`) AS `negative`  
                    FROM `county_entrypoint` `nep` 
                    JOIN `entry_points` `ep` 
                    ON `nep`.`entrypoint` = `ep`.`ID`
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ep`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_entryP_positivity`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_entryP_positivity`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
  						`p`.`name`,
                        SUM(`pos`) AS `pos`,
                        SUM(`neg`) AS `neg`
                    FROM `county_entrypoint` `ci` 
                    LEFT JOIN `entry_points` `p` ON `ci`.`entrypoint` = `p`.`ID`
                WHERE 1 ";

   
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

    SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_id,"' GROUP BY `p`.`ID` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_hei`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_hei`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`enrolled`) AS `enrolled`,
        SUM(`dead`) AS `dead`,
        SUM(`ltfu`) AS `ltfu`,
        SUM(`adult`) AS `adult`,
        SUM(`transout`) AS `transout`,
        SUM(`other`) AS `other`
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
DROP PROCEDURE IF EXISTS `proc_get_eid_county_infantsless2m`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_infantsless2m`
(IN C_id INT(11))
BEGIN
  SET @QUERY =  "SELECT 
                    `month`, 
                    `year`, 
                    `infantsless2m` 
                FROM `county_summary`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_id,"' ORDER BY `year`, `month` ASC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_iproph_positivity`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_iproph_positivity`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
  								`p`.`name`,
                        SUM(`pos`) AS `pos`,
                        SUM(`neg`) AS `neg`
                    FROM `county_iprophylaxis` `ci` 
                    LEFT JOIN `prophylaxis` `p` ON `ci`.`prophylaxis` = `p`.`ID`
                WHERE 1 ";

   
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

    SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_id,"' GROUP BY `p`.`ID` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_county_iprophylaxis`;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_iprophylaxis`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_iprophylaxis`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `p`.`name`, 
                        SUM(`pos`) AS `positive`, 
                        SUM(`neg`) AS `negative` 
                    FROM `county_iprophylaxis` `nip` 
                    JOIN `prophylaxis` `p` ON `nip`.`prophylaxis` = `p`.`ID`
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `p`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_mproph_positivity`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_mproph_positivity`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
  						`p`.`name`,
                        SUM(`pos`) AS `pos`,
                        SUM(`neg`) AS `neg`
                    FROM `county_mprophylaxis` `ci` 
                    LEFT JOIN `prophylaxis` `p` ON `ci`.`prophylaxis` = `p`.`ID`
                WHERE 1 ";

   
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

    SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_id,"' GROUP BY `p`.`ID` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_county_mprophylaxis`;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_mprophylaxis`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_mprophylaxis`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `p`.`name`, 
                        SUM(`pos`) AS `positive`, 
                        SUM(`neg`) AS `negative` 
                    FROM `county_mprophylaxis` `nmp` 
                    JOIN `prophylaxis` `p` ON `nmp`.`prophylaxis` = `p`.`ID`
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `p`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_outcomes`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `c`.`name`,
                    `cs`.`county`,
                    SUM(`cs`.`actualinfantsPOS`) AS `positive`,
                    SUM(`cs`.`actualinfants`-`cs`.`actualinfantsPOS`) AS `negative` 
                FROM `county_summary` `cs`
                    JOIN `countys` `c` ON `cs`.`county` = `c`.`ID`
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `cs`.`county` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_partner_positivity`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_partner_positivity`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =  "SELECT 
                    DISTINCT(`p`.`name`) AS `name`,
                    SUM(`actualinfantsPOS`) AS `pos`,
                    SUM(`actualinfants`-`actualinfantsPOS`) AS `neg`,
                    ((SUM(`actualinfantsPOS`)/(SUM(`actualinfants`)))*100) AS `pecentage` ";


     IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `ip_summary` `is` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `ip_summary_yearly` `is` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " LEFT JOIN `partners` `p` 
                  ON `is`.`partner` = `p`.`ID` 
                LEFT JOIN `view_facilitys` `vf`
                    ON `p`.`ID` = `vf`.`partner`
                WHERE 1 ");



   
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

    SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",C_id,"' GROUP BY `name` ORDER BY `pecentage` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_partners_details`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_partners_details`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                  `p`.name AS `partner`, 
                  `c`.name AS `county`,
                  SUM(`tests`) AS `tests`, 
                  SUM(`actualinfants`) AS `actualinfants`, 
                  SUM(`confirmdna` + `repeatspos`) AS `confirmdna`,
                  SUM(`actualinfantsPOS`) AS `positive`, 
                  SUM(`actualinfants`-`actualinfantsPOS`) AS `negative`, 
                  SUM(`redraw`) AS `redraw`, 
                  SUM(`adults`) AS `adults`, 
                  SUM(`adultsPOS`) AS `adultspos`, 
                  AVG(`medage`) AS `medage`, 
                  SUM(`rejected`) AS `rejected`, 
                  SUM(`infantsless2w`) AS `infantsless2w`, 
                  SUM(`infantsless2wPOS`) AS `infantsless2wpos`, 
                  SUM(`infantsless2m`) AS `infantsless2m`, 
                  SUM(`infantsless2mPOS`) AS `infantsless2mpos`, 
                  SUM(`infantsabove2m`) AS `infantsabove2m`, 
                  SUM(`infantsabove2mPOS`) AS `infantsabove2mpos`     ";


     IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `site_summary` `is` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `site_summary_yearly` `is` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " LEFT JOIN `view_facilitys` `vf` ON `vf`.`ID` = `is`.`facility`
                    LEFT JOIN `partners` `p` ON `p`.`ID` = `vf`.`partner`
                    LEFT JOIN `countys` `c` ON `c`.`ID` = `vf`.`county`
                  WHERE 1 ");


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

    SET @QUERY = CONCAT(@QUERY, " AND `vf`.county = '",C_id,"' ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `p`.`name` ORDER BY `tests` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_countys_details`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_countys_details`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                  `countys`.`name` AS `county`, 
                  SUM(`tests`) AS `tests`, 
                  SUM(`actualinfants`) AS `actualinfants`, 
                  SUM(`confirmdna` + `repeatspos`) AS `confirmdna`,
                  SUM(`actualinfantsPOS`) AS `positive`, 
                  SUM(`actualinfants`-`actualinfantsPOS`) AS `negative`, 
                  SUM(`redraw`) AS `redraw`, 
                  SUM(`adults`) AS `adults`, 
                  SUM(`adultsPOS`) AS `adultspos`, 
                  AVG(`medage`) AS `medage`, 
                  SUM(`rejected`) AS `rejected`, 
                  SUM(`infantsless2w`) AS `infantsless2w`, 
                  SUM(`infantsless2wPOS`) AS `infantsless2wpos`, 
                  SUM(`infantsless2m`) AS `infantsless2m`, 
                  SUM(`infantsless2mPOS`) AS `infantsless2mpos`, 
                  SUM(`infantsabove2m`) AS `infantsabove2m`, 
                  SUM(`infantsabove2mPOS`) AS `infantsabove2mpos`
                  FROM `county_summary` 
                  LEFT JOIN `countys` ON `county_summary`.`county` = `countys`.`ID`  WHERE 1";


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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `county_summary`.`county` ORDER BY `tests` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_sites_details`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_sites_details`
(IN C_id INT(11), IN filter_year INT(11), IN to_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                  `view_facilitys`.`facilitycode` AS `MFLCode`, 
                  `view_facilitys`.`name`, 
                  `countys`.`name` AS `county`, 
                  `districts`.`name` AS `subcounty`, 
                  SUM(`tests`) AS `tests`, 
                  SUM(`firstdna`) AS `firstdna`, 
                  SUM(`confirmdna` + `repeatspos`) AS `confirmdna`,
                  SUM(`pos`) AS `positive`, 
                  SUM(`neg`) AS `negative`, 
                  SUM(`redraw`) AS `redraw`, 
                  SUM(`adults`) AS `adults`, 
                  SUM(`adultsPOS`) AS `adultspos`, 
                  AVG(`medage`) AS `medage`, 
                  SUM(`rejected`) AS `rejected`, 
                  SUM(`infantsless2m`) AS `infantsless2m`, 
                  SUM(`infantsless2mPOS`) AS `infantsless2mpos` 

                  FROM `site_summary` 
                  LEFT JOIN `view_facilitys` ON `site_summary`.`facility` = `view_facilitys`.`ID` 
                  LEFT JOIN `countys` ON `view_facilitys`.`county` = `countys`.`ID` 
                  LEFT JOIN `districts` ON `view_facilitys`.`district` = `districts`.`ID`  WHERE 1";


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

    SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`county` = '",C_id,"' ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `view_facilitys`.`ID` ORDER BY `tests` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_sites_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_sites_outcomes`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                      `vf`.`name`,
                      SUM(`actualinfantsPOS`) AS `positive`,
                      SUM(`actualinfants`-`actualinfantsPOS`) AS `negative` 
                      FROM `site_summary` `ss` 
                      LEFT JOIN `view_facilitys` `vf` ON `ss`.`facility` = `vf`.`ID`  
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

    SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",C_id,"' ");


    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vf`.`name` ORDER BY `negative` DESC, `positive` DESC LIMIT 0, 50 ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_sites_positivity`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_sites_positivity`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
						            SUM(`vss`.`actualinfantsPOS`) AS `pos`, 
                        SUM(`vss`.`actualinfants`) AS `alltests`,
                        ((SUM(`vss`.`actualinfantsPOS`)/SUM(`vss`.`actualinfants`))*100) AS `positivity`, 
                        `vf`.`ID`, 
                        `vf`.`name` ";

     IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `site_summary` `vss` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `site_summary_yearly` `vss` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " LEFT JOIN `view_facilitys` `vf` 
                    ON `vss`.`facility`=`vf`.`ID` 
                    WHERE 1 ");



  
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

    SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",C_id,"' GROUP BY `vf`.`ID` ORDER BY `positivity` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_subcounties_details`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_subcounties_details`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                  `d`.`name` AS `subcounty`,
                   `c`.`name` AS `county`,
                  SUM(`tests`) AS `tests`, 
                  SUM(`actualinfants`) AS `actualinfants`, 
                  SUM(`confirmdna` + `repeatspos`) AS `confirmdna`,
                  SUM(`actualinfantsPOS`) AS `positive`, 
                  SUM(`actualinfants`-`actualinfantsPOS`) AS `negative`, 
                  SUM(`redraw`) AS `redraw`, 
                  SUM(`adults`) AS `adults`, 
                  SUM(`adultsPOS`) AS `adultspos`, 
                  AVG(`medage`) AS `medage`, 
                  SUM(`rejected`) AS `rejected`, 
                  SUM(`infantsless2w`) AS `infantsless2w`, 
                  SUM(`infantsless2wPOS`) AS `infantsless2wpos`, 
                  SUM(`infantsless2m`) AS `infantsless2m`, 
                  SUM(`infantsless2mPOS`) AS `infantsless2mpos`, 
                  SUM(`infantsabove2m`) AS `infantsabove2m`, 
                  SUM(`infantsabove2mPOS`) AS `infantsabove2mpos`   ";


     IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `subcounty_summary` `scs` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `subcounty_summary_yearly` `scs` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " LEFT JOIN `districts` `d` ON `scs`.`subcounty` = `d`.`ID`
            LEFT JOIN `countys` `c` ON `d`.`county` = `c`.`ID`  WHERE 1 ");


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

    SET @QUERY = CONCAT(@QUERY, " AND `c`.`ID` = '",C_id,"' ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `subcounty` ORDER BY `tests` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

    DROP PROCEDURE IF EXISTS `proc_get_eid_county_subcounties_positivity`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_subcounties_positivity`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =  "SELECT 
                    `c`.`name`,
                    SUM(`actualinfantsPOS`) AS `pos`,
                    SUM(`actualinfants`-`actualinfantsPOS`) AS `neg`,
                    ((SUM(`actualinfantsPOS`)/(SUM(`actualinfants`)))*100) AS `pecentage`
                ";


     IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `subcounty_summary` `cs` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `subcounty_summary_yearly` `cs` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " LEFT JOIN districts `c`
                    ON c.ID = cs.subcounty 
                WHERE 1 ");


   
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

    SET @QUERY = CONCAT(@QUERY, " AND `c`.`county` = '",C_id,"' GROUP BY `name` ORDER BY `pecentage` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_testing_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_testing_trends`
(IN C_id INT(11), IN from_year INT(11), IN to_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
            `year`, 
            `month`, 
            `pos`, 
            `neg` 
            FROM `county_summary`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_id,"' AND `year` BETWEEN '",from_year,"' AND '",to_year,"' ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_county_yearly_hei`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_yearly_hei`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
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
DROP PROCEDURE IF EXISTS `proc_get_eid_lab_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_lab_outcomes`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `l`.`ID`, `l`.`labname` AS `name`, 
                    SUM(`ls`.`pos`) AS `pos`,
                    SUM(`ls`.`neg`) AS `neg`,
                    SUM(`redraw`) AS `redraw`
                FROM `lab_summary` `ls`
                JOIN `labs` `l`
                ON `l`.`ID` = `ls`.`lab` 
                WHERE 1 ";


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
      

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `l`.`ID` ");    
    SET @QUERY = CONCAT(@QUERY, " ORDER BY `l`.`ID` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_lab_performance`;
DROP PROCEDURE IF EXISTS `proc_get_eid_lab_performance`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_lab_performance`
(IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `l`.`ID`, `l`.`labname` AS `name`, (`ls`.`alltests`+`ls`.`confirmdna`+`ls`.`repeatspos`+`ls`.`eqatests`) AS `tests`, `ls`.`rejected`, `ls`.`pos`, `ls`.neg,
                    `ls`.`month` 
                FROM `lab_summary` `ls`
                JOIN `labs` `l`
                ON `l`.`ID` = `ls`.`lab` 
                WHERE 1 ";

    
        SET @QUERY = CONCAT(@QUERY, " AND `ls`.`year` = '",filter_year,"' ");
  
  SET @QUERY = CONCAT(@QUERY, " ORDER BY `ls`.`month`, `l`.`ID` ");
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_lab_performance_stats`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_lab_performance_stats`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `l`.`labname` AS `name`, 
                    AVG(`ls`.`sitessending`) AS `sitesending`, 
                    SUM(`ls`.`batches`) AS `batches`, 
                    SUM(`ls`.`received`) AS `received`, 
                    SUM(`ls`.`tests`) AS `tests`, 
                    SUM(`ls`.`alltests`) AS `alltests`,  
                    SUM(`ls`.`rejected`) AS `rejected`,  
                    SUM(`ls`.`confirmdna`) AS `confirmdna`,  
                    SUM(`ls`.`repeatspos`) AS `repeatspos`,  
                    SUM(`ls`.`eqatests`) AS `eqa`,  
                    SUM(`ls`.`pos`) AS `pos`, 
                    SUM(`ls`.`neg`) AS `neg`, 
                    SUM(`ls`.`redraw`) AS `redraw` 
                  FROM `lab_summary` `ls` JOIN `labs` `l` ON `ls`.`lab` = `l`.`ID` 
                WHERE 1 ";


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

      SET @QUERY = CONCAT(@QUERY, " GROUP BY `l`.`ID` ORDER BY `alltests` DESC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_lab_tat`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_lab_tat`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `l`.`ID`, `l`.`labname` AS `name`, AVG(`ls`.`tat1`) AS `tat1`,
                    AVG(`ls`.`tat2`) AS `tat2`, AVG(`ls`.`tat3`) AS `tat3`,
                    AVG(`ls`.`tat4`) AS `tat4`
                FROM `lab_summary` `ls`
                JOIN `labs` `l`
                ON `l`.`ID` = `ls`.`lab` 
                WHERE 1 ";


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
      

  SET @QUERY = CONCAT(@QUERY, " GROUP BY `l`.`ID` ");
    SET @QUERY = CONCAT(@QUERY, " ORDER BY `l`.`ID` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_national_age_breakdown`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_age_breakdown`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM(`less2wpos`) AS `less2wpos`,
                    SUM(`less2wneg`) AS `less2wneg`,
                    SUM(`twoto6wpos`) AS `twoto6wpos`,
                    SUM(`twoto6wneg`) AS `twoto6wneg`,
                    SUM(`sixto8wpos`) AS `sixto8wpos`,
                    SUM(`sixto8wneg`) AS `sixto8wneg`,
                    SUM(`sixmonthpos`) AS `sixmonthpos`,
                    SUM(`sixmonthneg`) AS `sixmonthneg`,
                    SUM(`ninemonthpos`) AS `ninemonthpos`,
                    SUM(`ninemonthneg`) AS `ninemonthneg`,
                    SUM(`twelvemonthpos`) AS `twelvemonthpos`,
                    SUM(`twelvemonthneg`) AS `twelvemonthneg`
                    FROM national_agebreakdown
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
DROP PROCEDURE IF EXISTS `proc_get_national_age`;
DROP PROCEDURE IF EXISTS `proc_get_eid_national_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_age`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  
            SUM(`sixweekspos`) AS `sixweekspos`, 
            SUM(`sixweeksneg`) AS `sixweeksneg`, 
            SUM(`sevento3mpos`) AS `sevento3mpos`, 
            SUM(`sevento3mneg`) AS `sevento3mneg`,
            SUM(`threemto9mpos`) AS `threemto9mpos`, 
            SUM(`threemto9mneg`) AS `threemto9mneg`,
            SUM(`ninemto18mpos`) AS `ninemto18mpos`, 
            SUM(`ninemto18mneg`) AS `ninemto18mneg`,
            SUM(`above18mpos`) AS `above18mpos`, 
            SUM(`above18mneg`) AS `above18mneg`,
            SUM(`nodatapos`) AS `nodatapos`, 
            SUM(`nodataneg`) AS `nodataneg`
          FROM `national_agebreakdown` WHERE 1";
  
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
DROP PROCEDURE IF EXISTS `proc_get_eid_national_age_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_age_summary`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
  					SUM(`infantsless2m`) AS `infantsless2m`,       
					SUM(`infantsless2mPOS`) AS `infantsless2mPOS`,     
					SUM(`infantsless2w`) AS `infantsless2w`,       
					SUM(`infantsless2wPOS`) AS `infantsless2wPOS`,    
					SUM(`infants4to6w`) AS `infants4to6w`,        
					SUM(`infants4to6wPOS`) AS `infants4to6wPOS`,     
					SUM(`infantsabove2m`) AS `infantsabove2m`,      
					SUM(`infantsabove2mPOS`) AS `infantsabove2mPOS`,   
					SUM(`adults`) AS `adults`,              
					SUM(`adultsPOS`) AS `adultsPOS`            
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
DROP PROCEDURE IF EXISTS `proc_get_eid_national_eid_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_eid_outcomes`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`pos`) AS `pos`,
        SUM(`neg`) AS `neg`,
        AVG(`medage`) AS `medage`,
        SUM(`alltests`) AS `alltests`,
        SUM(`eqatests`) AS `eqatests`,
        SUM(`firstdna`) AS `firstdna`,
        SUM(`confirmdna`) AS `confirmdna`,
        SUM(`confirmedPOS`) AS `confirmpos`,
        SUM(`repeatspos`) AS `repeatspos`,
        SUM(`actualinfants`) AS `actualinfants`,
        SUM(`actualinfantsPOS`) AS `actualinfantspos`,
        SUM(`infantsless2m`) AS `infantsless2m`,
        SUM(`infantsless2mPOS`) AS `infantless2mpos`,
        SUM(`adults`) AS `adults`,
        SUM(`adultsPOS`) AS `adultsPOS`,
        SUM(`redraw`) AS `redraw`,
        SUM(`tests`) AS `tests`,
        SUM(`rejected`) AS `rejected`, 
        AVG(`sitessending`) AS `sitessending`";


    IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `national_summary` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `national_summary_yearly` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " WHERE 1 ");


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
DROP PROCEDURE IF EXISTS `proc_get_national_entry_points`;
DROP PROCEDURE IF EXISTS `proc_get_eid_national_entry_points`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_entry_points`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `ep`.`name`, 
                        SUM(`pos`) AS `positive`, 
                        SUM(`neg`) AS `negative`  
                    FROM `national_entrypoint` `nep` 
                    JOIN `entry_points` `ep` 
                    ON `nep`.`entrypoint` = `ep`.`ID`
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ep`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_national_entryP_positivity`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_entryP_positivity`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
  						`p`.`name`,
                        SUM(`pos`) AS `pos`,
                        SUM(`neg`) AS `neg`
                    FROM `national_entrypoint` `ci` 
                    LEFT JOIN `entry_points` `p` ON `ci`.`entrypoint` = `p`.`ID`
                WHERE 1 ";

   
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `p`.`ID` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_national_hei`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_hei`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`enrolled`) AS `enrolled`,
        SUM(`dead`) AS `dead`,
        SUM(`ltfu`) AS `ltfu`,
        SUM(`adult`) AS `adult`,
        SUM(`transout`) AS `transout`,
        SUM(`other`) AS `other`
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
DROP PROCEDURE IF EXISTS `proc_get_eid_national_infantsless2m`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_infantsless2m`
(IN filter_year INT(11), IN filter_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =  "SELECT 
                    `month`, 
                    `year`, 
                    `infantsless2m` 
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
DROP PROCEDURE IF EXISTS `proc_get_eid_national_iproph_positivity`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_iproph_positivity`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
  						`p`.`name`,
                        SUM(`pos`) AS `pos`,
                        SUM(`neg`) AS `neg`
                    FROM `national_iprophylaxis` `ci` 
                    LEFT JOIN `prophylaxis` `p` ON `ci`.`prophylaxis` = `p`.`ID`
                WHERE 1 ";

   
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `p`.`ID` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_national_iprophylaxis`;
DROP PROCEDURE IF EXISTS `proc_get_eid_national_iprophylaxis`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_iprophylaxis`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `p`.`name`, 
                        SUM(`pos`) AS `positive`, 
                        SUM(`neg`) AS `negative` 
                    FROM `national_iprophylaxis` `nip` 
                    JOIN `prophylaxis` `p` ON `nip`.`prophylaxis` = `p`.`ID`
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `p`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_national_mproph_positivity`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_mproph_positivity`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
  						`p`.`name`,
                        SUM(`pos`) AS `pos`,
                        SUM(`neg`) AS `neg`
                    FROM `national_mprophylaxis` `ci` 
                    LEFT JOIN `prophylaxis` `p` ON `ci`.`prophylaxis` = `p`.`ID`
                WHERE 1 ";

   
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `p`.`ID` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_national_mprophylaxis`;
DROP PROCEDURE IF EXISTS `proc_get_eid_national_mprophylaxis`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_mprophylaxis`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `p`.`name`, 
                        SUM(`pos`) AS `positive`, 
                        SUM(`neg`) AS `negative` 
                    FROM `national_mprophylaxis` `nmp` 
                    JOIN `prophylaxis` `p` ON `nmp`.`prophylaxis` = `p`.`ID`
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `p`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_national_tat`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_tat`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `vls`.`tat1`, 
                        `vls`.`tat2`, 
                        `vls`.`tat3`, 
                        `vls`.`tat4` 
                    FROM `national_summary` `vls` 
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
DROP PROCEDURE IF EXISTS `proc_get_national_testing_trends`;
DROP PROCEDURE IF EXISTS `proc_get_eid_national_testing_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_testing_trends`
(IN from_year INT(11), IN to_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
            `year`, 
            `month`, 
            `pos`, 
            `neg` 
            FROM `national_summary`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `year` = '",from_year,"' OR `year` = '",to_year,"' ORDER BY `year` ASC, `month` ");
    
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
DROP PROCEDURE IF EXISTS `proc_get_eid_national_yearly_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_yearly_summary`
()
BEGIN
  SET @QUERY =    "SELECT 
                    `year`, 
                    SUM(`tests`) AS `tests`, 
                    SUM(`pos`) AS `positive`, 
                    SUM(`neg`) AS `negative`, 
                    SUM(`redraw`) AS `redraws` 
                  FROM `national_summary`  
                  WHERE `year` > '2007'
                  GROUP BY `year` ORDER BY `year` ASC";

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_national_yearly_tests`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_yearly_tests`
()
BEGIN
  SET @QUERY =    "SELECT
                    `ns`.`year`, `ns`.`month`, SUM(`ns`.`tests`) AS `tests`, 
                    SUM(`ns`.`pos`) AS `positive`,
                    SUM(`ns`.`neg`) AS `negative`,
                    SUM(`ns`.`rejected`) AS `rejected`,
                    SUM(`ns`.`infantsless2m`) AS `infants`,
                    SUM(`ns`.`redraw`) AS `redraw`,
                    SUM(`ns`.`tat4`) AS `tat4`
                FROM `national_summary` `ns`
                WHERE 1 ";

      SET @QUERY = CONCAT(@QUERY, " GROUP BY `ns`.`month`, `ns`.`year` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `ns`.`year` DESC, `ns`.`month` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_nat_partner_positivity`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_nat_partner_positivity`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =  "SELECT 
                    `p`.`name`,
                    SUM(`actualinfantsPOS`) AS `pos`,
                    SUM(`actualinfants`-`actualinfantsPOS`) AS `neg`,
                    ((SUM(`actualinfantsPOS`)/(SUM(`actualinfants`)))*100) AS `pecentage` ";


     IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `ip_summary` `is` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `ip_summary_yearly` `is` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " LEFT JOIN `partners` `p` 
                  ON `is`.`partner` = `p`.`ID` 
                WHERE 1 ");



   
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `name` ORDER BY `pecentage` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_nat_subcounties_positivity`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_nat_subcounties_positivity`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =  "SELECT 
                    `c`.`name`,
                    SUM(`actualinfantsPOS`) AS `pos`,
                    SUM(`actualinfants`-`actualinfantsPOS`) AS `neg`,
                    ((SUM(`actualinfantsPOS`)/(SUM(`actualinfants`)))*100) AS `pecentage` ";


     IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `subcounty_summary` `cs` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `subcounty_summary_yearly` `cs` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " LEFT JOIN districts `c`
                    ON c.ID = cs.subcounty 
                WHERE 1 ");

   
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `name` ORDER BY `pecentage` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_partner_age`;
DROP PROCEDURE IF EXISTS `proc_get_eid_partner_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_age`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  
            SUM(`sixweekspos`) AS `sixweekspos`, 
            SUM(`sixweeksneg`) AS `sixweeksneg`, 
            SUM(`sevento3mpos`) AS `sevento3mpos`, 
            SUM(`sevento3mneg`) AS `sevento3mneg`,
            SUM(`threemto9mpos`) AS `threemto9mpos`, 
            SUM(`threemto9mneg`) AS `threemto9mneg`,
            SUM(`ninemto18mpos`) AS `ninemto18mpos`, 
            SUM(`ninemto18mneg`) AS `ninemto18mneg`,
            SUM(`above18mpos`) AS `above18mpos`, 
            SUM(`above18mneg`) AS `above18mneg`,
            SUM(`nodatapos`) AS `nodatapos`, 
            SUM(`nodataneg`) AS `nodataneg`
          FROM `ip_agebreakdown` WHERE 1";
  

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
DROP PROCEDURE IF EXISTS `proc_get_eid_partner_counties_details`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_counties_details`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                      `c`.`name` AS `county`, 
                      `p`.`name` AS `partner`, 
                      SUM(`tests`) AS `tests`, 
                      SUM(`firstdna`) AS `firstdna`, 
                      SUM(`confirmdna` + `repeatspos`) AS `confirmdna`,
                      SUM(`pos`) AS `positive`, 
                      SUM(`neg`) AS `negative`, 
                      SUM(`redraw`) AS `redraw`, 
                      SUM(`adults`) AS `adults`, 
                      SUM(`adultsPOS`) AS `adultspos`, 
                      AVG(`medage`) AS `medage`, 
                      SUM(`rejected`) AS `rejected`, 
                      SUM(`infantsless2m`) AS `infantsless2m`, 
                      SUM(`infantsless2mPOS`) AS `infantsless2mpos`
                  FROM `county_summary` `cs`
                  JOIN `view_facilitys` `vf` ON `vf`.county = `cs`.county 
                  JOIN `countys` `c` ON `c`.ID = `cs`.county 
                  JOIN `partners` `p` ON `p`.ID = `vf`.partner  WHERE 1";



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

    SET @QUERY = CONCAT(@QUERY, " AND `vf`.`partner` = '",P_id,"' ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `c`.ID ORDER BY `tests` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_partner_county_details`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_county_details`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  
                  `countys`.`name` AS `county`, 
                  COUNT(DISTINCT `view_facilitys`.`ID`) AS `facilities`, 
                  SUM(`tests`) AS `tests`, 
                  SUM(`actualinfants`) AS `actualinfants`, 
                  SUM(`confirmdna` + `repeatspos`) AS `confirmdna`,
                  SUM(`actualinfantsPOS`) AS `positive`, 
                  SUM(`actualinfants`-`actualinfantsPOS`) AS `negative`, 
                  SUM(`redraw`) AS `redraw`, 
                  SUM(`adults`) AS `adults`, 
                  SUM(`adultsPOS`) AS `adultspos`, 
                  AVG(`medage`) AS `medage`, 
                  SUM(`rejected`) AS `rejected`, 
                  SUM(`infantsless2w`) AS `infantsless2w`, 
                  SUM(`infantsless2wPOS`) AS `infantsless2wpos`, 
                  SUM(`infantsless2m`) AS `infantsless2m`, 
                  SUM(`infantsless2mPOS`) AS `infantsless2mpos`, 
                  SUM(`infantsabove2m`) AS `infantsabove2m`, 
                  SUM(`infantsabove2mPOS`) AS `infantsabove2mpos` ";


    IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `site_summary` `ss` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `site_summary_yearly` `ss` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, "  
                  LEFT JOIN `view_facilitys` ON `ss`.`facility` = `view_facilitys`.`ID` 
                  LEFT JOIN `countys` ON `view_facilitys`.`county` = `countys`.`ID`  WHERE 1 ");


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

    SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`partner` = '",P_id,"' ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `view_facilitys`.`county` ORDER BY `tests` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_partner_eid_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_eid_outcomes`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`pos`) AS `pos`,
        SUM(`neg`) AS `neg`,
        AVG(`medage`) AS `medage`,
        SUM(`alltests`) AS `alltests`,
        SUM(`eqatests`) AS `eqatests`,
        SUM(`firstdna`) AS `firstdna`,
        SUM(`confirmdna`) AS `confirmdna`,
        SUM(`confirmedPOS`) AS `confirmpos`,
        SUM(`repeatspos`) AS `repeatspos`,
        SUM(`actualinfants`) AS `actualinfants`,
        SUM(`actualinfantsPOS`) AS `actualinfantspos`,
        SUM(`infantsless2m`) AS `infantsless2m`,
        SUM(`infantsless2mPOS`) AS `infantless2mpos`,
        SUM(`adults`) AS `adults`,
        SUM(`adultsPOS`) AS `adultsPOS`,
        SUM(`redraw`) AS `redraw`,
        SUM(`tests`) AS `tests`,
        SUM(`rejected`) AS `rejected`, 
        AVG(`sitessending`) AS `sitessending`";

    IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `ip_summary` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `ip_summary_yearly` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " WHERE 1 ");


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
DROP PROCEDURE IF EXISTS `proc_get_partner_entry_points`;
DROP PROCEDURE IF EXISTS `proc_get_eid_partner_entry_points`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_entry_points`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `ep`.`name`, 
                        SUM(`actualinfantsPOS`) AS `positive`, 
                        SUM(`actualinfants`-`actualinfantsPOS`) AS `negative`  
                    FROM `ip_entrypoint` `nep` 
                    JOIN `entry_points` `ep` 
                    ON `nep`.`entrypoint` = `ep`.`ID`
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ep`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_partner_hei`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_hei`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`enrolled`) AS `enrolled`,
        SUM(`dead`) AS `dead`,
        SUM(`ltfu`) AS `ltfu`,
        SUM(`adult`) AS `adult`,
        SUM(`transout`) AS `transout`,
        SUM(`other`) AS `other`
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
DROP PROCEDURE IF EXISTS `proc_get_partner_iprophylaxis`;
DROP PROCEDURE IF EXISTS `proc_get_eid_partner_iprophylaxis`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_iprophylaxis`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `p`.`name`, 
                        SUM(`actualinfantsPOS`) AS `positive`, 
                        SUM(`actualinfants`-`actualinfantsPOS`) AS `negative` 
                    FROM `ip_iprophylaxis` `nip` 
                    JOIN `prophylaxis` `p` ON `nip`.`prophylaxis` = `p`.`ID`
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `p`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_partner_mprophylaxis`;
DROP PROCEDURE IF EXISTS `proc_get_eid_partner_mprophylaxis`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_mprophylaxis`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `p`.`name`, 
                        SUM(`pos`) AS `positive`, 
                        SUM(`neg`) AS `negative` 
                    FROM `ip_mprophylaxis` `nmp` 
                    JOIN `prophylaxis` `p` ON `nmp`.`prophylaxis` = `p`.`ID`
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `p`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_partner_outcomes`;
DROP PROCEDURE IF EXISTS `proc_get_eid_partner_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_outcomes`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `p`.`name`,
                    SUM(`ps`.`actualinfantsPOS`) AS `positive`,
                    SUM(`ps`.`actualinfants`-`ps`.`actualinfantsPOS`) AS `negative`";

    IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `ip_summary` `ps` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `ip_summary_yearly` `ps` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " JOIN `partners` `p` ON `ps`.`partner` = `p`.`ID`
                WHERE 1 ");

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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ps`.`partner` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_partner_performance`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_performance`
(IN filter_partner INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `p`.`name`, `ip`.`month`, `ip`.`year`, SUM(`ip`.`tests`) AS `tests`, 
                    SUM(`ip`.`infantsless2m`) AS `infants`, 
                    SUM(`ip`.`pos`) AS `pos`,
                    SUM(`ip`.`neg`) AS `neg`, SUM(`ip`.`rejected`) AS `rej`
                FROM `ip_summary` `ip`
                JOIN `partners` `p`
                ON `p`.`ID` = `ip`.`partner` 
                WHERE 1 ";

    
        

         IF (filter_partner != 0 && filter_partner != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `p`.`ID` = '",filter_partner,"' ");
        END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ip`.`month`, `ip`.`year` ");
  
    SET @QUERY = CONCAT(@QUERY, " ORDER BY `ip`.`year` DESC, `ip`.`month` ASC ");


  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_partner_sites_details`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_sites_details`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                  `view_facilitys`.`facilitycode` AS `MFLCode`, 
                  `view_facilitys`.`name`, 
                  `countys`.`name` AS `county`, 
                  SUM(`tests`) AS `tests`, 
                  SUM(`actualinfants`) AS `actualinfants`, 
                  SUM(`confirmdna` + `repeatspos`) AS `confirmdna`,
                  SUM(`actualinfantsPOS`) AS `positive`, 
                  SUM(`actualinfants`-`actualinfantsPOS`) AS `negative`, 
                  SUM(`redraw`) AS `redraw`, 
                  SUM(`adults`) AS `adults`, 
                  SUM(`adultsPOS`) AS `adultspos`, 
                  AVG(`medage`) AS `medage`, 
                  SUM(`rejected`) AS `rejected`, 
                  SUM(`infantsless2w`) AS `infantsless2w`, 
                  SUM(`infantsless2wPOS`) AS `infantsless2wpos`, 
                  SUM(`infantsless2m`) AS `infantsless2m`, 
                  SUM(`infantsless2mPOS`) AS `infantsless2mpos`, 
                  SUM(`infantsabove2m`) AS `infantsabove2m`, 
                  SUM(`infantsabove2mPOS`) AS `infantsabove2mpos`";


    IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `site_summary` ss ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `site_summary_yearly` ss ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " 
      LEFT JOIN `view_facilitys` ON `ss`.`facility` = `view_facilitys`.`ID` 
      LEFT JOIN `countys` ON `view_facilitys`.`county` = `countys`.`ID`  WHERE 1 ");



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

    SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`partner` = '",P_id,"' ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `view_facilitys`.`ID` ORDER BY `tests` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_partner_sites_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_sites_outcomes`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
					`vf`.`name`,
					SUM(`ss`.`actualinfantsPOS`) AS `positive`,
          SUM(`ss`.`actualinfants`-`ss`.`actualinfantsPOS`) AS `negative`";


    IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `site_summary` ss ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `site_summary_yearly` ss ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " 
      LEFT JOIN `view_facilitys` `vf` ON `ss`.`facility` = `vf`.`ID` 
      LEFT JOIN `countys` ON `vf`.`county` = `countys`.`ID`  WHERE 1 ");


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

    SET @QUERY = CONCAT(@QUERY, " AND `vf`.`partner` = '",P_id,"' ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vf`.`name` ORDER BY `negative` DESC, `positive` DESC LIMIT 0, 50 ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
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
DROP PROCEDURE IF EXISTS `proc_get_eid_partner_testing_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_testing_trends`
(IN P_id INT(11), IN from_year INT(11), IN to_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
            `year`, 
            `month`, 
            `pos`, 
            `neg` 
            FROM `ip_summary`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` BETWEEN '",from_year,"' AND '",to_year,"' ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

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
DROP PROCEDURE IF EXISTS `proc_get_eid_partner_year_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_year_summary`
(IN filter_partner INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `ip`.`year`,  SUM(`ip`.`pos`) AS `positive`,
                    SUM(`ip`.`neg`) AS `negative`,
                    SUM(`ip`.`redraw`) AS `redraws`
                FROM `ip_summary` `ip`
                JOIN `partners` `p`
                ON `p`.`ID` = `ip`.`partner` 
                WHERE 1 ";

         IF (filter_partner != 0 && filter_partner != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `p`.`ID` = '",filter_partner,"' ");
        END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ip`.`year` ");
  
    SET @QUERY = CONCAT(@QUERY, " ORDER BY `ip`.`year` ASC ");


  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_sites_eid`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_sites_eid`
(IN filter_site INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM(`pos`) AS `pos`,
                    SUM(`neg`) AS `neg`,
                    AVG(`medage`) AS `medage`,
                    SUM(`alltests`) AS `alltests`,
                    SUM(`eqatests`) AS `eqatests`,
                    SUM(`firstdna`) AS `firstdna`,
                    SUM(`confirmdna`) AS `confirmdna`,
                    SUM(`confirmedPOS`) AS `confirmpos`,
                    SUM(`repeatspos`) AS `repeatspos`,
                    SUM(`actualinfants`) AS `actualinfants`,
                    SUM(`actualinfantsPOS`) AS `actualinfantspos`,
                    SUM(`infantsless2m`) AS `infantsless2m`,
                    SUM(`infantsless2mPOS`) AS `infantless2mpos`,
                    SUM(`adults`) AS `adults`,
                    SUM(`adultsPOS`) AS `adultsPOS`,
                    SUM(`redraw`) AS `redraw`,
                    SUM(`tests`) AS `tests`,
                    SUM(`rejected`) AS `rejected`, 
                    AVG(`sitessending`) AS `sitessending`";


    IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `site_summary` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `site_summary_yearly` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " WHERE 1 ");


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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `facility`");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
     
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_sites_hei_follow_up`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_sites_hei_follow_up`
(IN filter_site INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM((`ss`.`enrolled`)) AS `enrolled`, 
                    SUM(`ss`.`dead`) AS `dead`, 
                    SUM(`ss`.`ltfu`) AS `ltfu`, 
                    SUM(`ss`.`transout`) AS `transout`, 
                    SUM(`ss`.`adult`) AS `adult`, 
                    SUM(`ss`.`other`) AS `other` 
                  FROM `site_summary` `ss` 
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ss`.`facility` ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
     
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_sites_positivity`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_sites_positivity`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
						            SUM(`vss`.`actualinfantsPOS`) AS `pos`, 
                        SUM(`vss`.`actualinfants`) AS `alltests`,
                        ((SUM(`vss`.`actualinfantsPOS`)/SUM(`vss`.`actualinfants`))*100) AS `positivity`, 
                        `vf`.`ID`, 
                        `vf`.`name` ";



     IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `site_summary` `vss` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `site_summary_yearly` `vss` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " LEFT JOIN `view_facilitys` `vf` 
                    ON `vss`.`facility`=`vf`.`ID` 
                    WHERE 1 ");

  
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

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vf`.`ID` ORDER BY `positivity` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_sites_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_sites_trends`
(IN filter_site INT(11), IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `ss`.`month`, 
                    SUM((`ss`.`actualinfantsPOS`)) AS `pos`, 
                    SUM(`ss`.`actualinfants`-`ss`.`actualinfantsPOS`) AS `neg`,
                    SUM(`ss`.`pos`+`ss`.`neg`) AS `tests`,
                    SUM(`ss`.`rejected`) AS `rejected`
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
DROP PROCEDURE IF EXISTS `proc_get_eid_sites_yearly_hei_follow_up`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_sites_yearly_hei_follow_up`
(IN filter_site INT(11), IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM((`ss`.`enrolled`)) AS `enrolled`, 
                    SUM(`ss`.`dead`) AS `dead`, 
                    SUM(`ss`.`ltfu`) AS `ltfu`, 
                    SUM(`ss`.`transout`) AS `transout`, 
                    SUM(`ss`.`adult`) AS `adult`, 
                    SUM(`ss`.`other`) AS `other` 
                  FROM `site_summary_yearly` `ss` 
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `facility` = '",filter_site,"' AND `year` = '",filter_year,"' ");

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ss`.`facility` ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
     
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_subcounty_age_breakdown`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_subcounty_age_breakdown`
(IN SC_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM(`less2wpos`) AS `less2wpos`,
                    SUM(`less2wneg`) AS `less2wneg`,
                    SUM(`twoto6wpos`) AS `twoto6wpos`,
                    SUM(`twoto6wneg`) AS `twoto6wneg`,
                    SUM(`sixto8wpos`) AS `sixto8wpos`,
                    SUM(`sixto8wneg`) AS `sixto8wneg`,
                    SUM(`sixmonthpos`) AS `sixmonthpos`,
                    SUM(`sixmonthneg`) AS `sixmonthneg`,
                    SUM(`ninemonthpos`) AS `ninemonthpos`,
                    SUM(`ninemonthneg`) AS `ninemonthneg`,
                    SUM(`twelvemonthpos`) AS `twelvemonthpos`,
                    SUM(`twelvemonthneg`) AS `twelvemonthneg`
                    FROM subcounty_agebreakdown
    WHERE 1";


    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND `year` = '",filter_year,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_subcounty_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_subcounty_age`
(IN SC_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  
            SUM(`sixweekspos`) AS `sixweekspos`, 
            SUM(`sixweeksneg`) AS `sixweeksneg`, 
            SUM(`sevento3mpos`) AS `sevento3mpos`, 
            SUM(`sevento3mneg`) AS `sevento3mneg`,
            SUM(`threemto9mpos`) AS `threemto9mpos`, 
            SUM(`threemto9mneg`) AS `threemto9mneg`,
            SUM(`ninemto18mpos`) AS `ninemto18mpos`, 
            SUM(`ninemto18mneg`) AS `ninemto18mneg`,
            SUM(`above18mpos`) AS `above18mpos`, 
            SUM(`above18mneg`) AS `above18mneg`,
            SUM(`nodatapos`) AS `nodatapos`, 
            SUM(`nodataneg`) AS `nodataneg`
          FROM `subcounty_agebreakdown` WHERE 1";
 

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

    SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_id,"' ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_subcounty_age_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_subcounty_age_summary`
(IN SC_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
  					SUM(`infantsless2m`) AS `infantsless2m`,       
					SUM(`infantsless2mPOS`) AS `infantsless2mPOS`,     
					SUM(`infantsless2w`) AS `infantsless2w`,       
					SUM(`infantsless2wPOS`) AS `infantsless2wPOS`,    
					SUM(`infants4to6w`) AS `infants4to6w`,        
					SUM(`infants4to6wPOS`) AS `infants4to6wPOS`,     
					SUM(`infantsabove2m`) AS `infantsabove2m`,      
					SUM(`infantsabove2mPOS`) AS `infantsabove2mPOS`,   
					SUM(`adults`) AS `adults`,              
					SUM(`adultsPOS`) AS `adultsPOS`            
					FROM `subcounty_summary`
    WHERE 1";


    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",SC_Id,"' AND `year` = '",filter_year,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_subcounty_eid`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_subcounty_eid`
(IN filter_subcounty INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM(`pos`) AS `pos`,
                    SUM(`neg`) AS `neg`,
                    AVG(`medage`) AS `medage`,
                    SUM(`alltests`) AS `alltests`,
                    SUM(`eqatests`) AS `eqatests`,
                    SUM(`firstdna`) AS `firstdna`,
                    SUM(`confirmdna`) AS `confirmdna`,
                    SUM(`repeatspos`) AS `repeatspos`,
                    SUM(`actualinfants`) AS `actualinfants`,
                    SUM(`actualinfantsPOS`) AS `actualinfantspos`,
                    SUM(`infantsless2m`) AS `infantsless2m`,
                    SUM(`infantsless2mPOS`) AS `infantless2mpos`,
                    SUM(`adults`) AS `adults`,
                    SUM(`adultsPOS`) AS `adultsPOS`,
                    SUM(`redraw`) AS `redraw`,
                    SUM(`tests`) AS `tests`,
                    SUM(`rejected`) AS `rejected`, 
                    AVG(`sitessending`) AS `sitessending` ";


     IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `subcounty_summary` `scs` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `subcounty_summary_yearly` `scs` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " WHERE 1 ");



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
DROP PROCEDURE IF EXISTS `proc_get_eid_subcounty_hei_follow_up`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_subcounty_hei_follow_up`
(IN filter_subcounty INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM((`ss`.`enrolled`)) AS `enrolled`, 
                    SUM(`ss`.`dead`) AS `dead`, 
                    SUM(`ss`.`ltfu`) AS `ltfu`, 
                    SUM(`ss`.`transout`) AS `transout`, 
                    SUM(`ss`.`adult`) AS `adult`, 
                    SUM(`ss`.`other`) AS `other` 
                  FROM `subcounty_summary` `ss` 
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
DROP PROCEDURE IF EXISTS `proc_get_eid_subcounty_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_subcounty_outcomes`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `d`.`name`,
                    `scs`.`subcounty`,
                    SUM(`scs`.`actualinfantsPOS`) AS `positive`,
                    SUM(`scs`.`actualinfants`-`scs`.`actualinfantsPOS`) AS `negative` 
                ";


     IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `subcounty_summary` `scs` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `subcounty_summary_yearly` `scs` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " JOIN `districts` `d` ON `scs`.`subcounty` = `d`.`ID` 
                JOIN `countys` `c` ON `d`.`county` = `c`.`ID`
    WHERE 1 ");

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

    SET @QUERY = CONCAT(@QUERY, " AND `c`.`ID` = '",C_id,"' ");



    SET @QUERY = CONCAT(@QUERY, " GROUP BY `scs`.`subcounty` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ; 
DROP PROCEDURE IF EXISTS `proc_get_eid_subcounty_sites_details`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_subcounty_sites_details`
(IN SC_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                  `view_facilitys`.`facilitycode` AS `MFLCode`, 
                  `view_facilitys`.`name`, 
                  `countys`.`name` AS `county`, 
                  `districts`.`name` AS `subcounty`, 
                  SUM(`tests`) AS `tests`, 
                  SUM(`actualinfants`) AS `actualinfants`, 
                  SUM(`confirmdna` + `repeatspos`) AS `confirmdna`,
                  SUM(`actualinfantsPOS`) AS `positive`, 
                  SUM(`actualinfants`-`actualinfantsPOS`) AS `negative`, 
                  SUM(`redraw`) AS `redraw`, 
                  SUM(`adults`) AS `adults`, 
                  SUM(`adultsPOS`) AS `adultspos`, 
                  AVG(`medage`) AS `medage`, 
                  SUM(`rejected`) AS `rejected`, 
                  SUM(`infantsless2w`) AS `infantsless2w`, 
                  SUM(`infantsless2wPOS`) AS `infantsless2wpos`, 
                  SUM(`infantsless2m`) AS `infantsless2m`, 
                  SUM(`infantsless2mPOS`) AS `infantsless2mpos`, 
                  SUM(`infantsabove2m`) AS `infantsabove2m`, 
                  SUM(`infantsabove2mPOS`) AS `infantsabove2mpos`
                  FROM `site_summary`
                  LEFT JOIN `view_facilitys` ON `site_summary`.`facility` = `view_facilitys`.`ID`
                  JOIN `districts` ON  `view_facilitys`.`district` = `districts`.`ID` 
                  LEFT JOIN `countys` ON `view_facilitys`.`county` = `countys`.`ID`  WHERE 1";


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

    SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`district` = '",SC_id,"' ");



    SET @QUERY = CONCAT(@QUERY, " GROUP BY `view_facilitys`.`ID` ORDER BY `tests` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;  
DROP PROCEDURE IF EXISTS `proc_get_eid_subcounty_yearly_hei_follow_up`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_subcounty_yearly_hei_follow_up`
(IN filter_subcounty INT(11), IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    SUM((`ss`.`enrolled`)) AS `enrolled`, 
                    SUM(`ss`.`dead`) AS `dead`, 
                    SUM(`ss`.`ltfu`) AS `ltfu`, 
                    SUM(`ss`.`transout`) AS `transout`, 
                    SUM(`ss`.`adult`) AS `adult`, 
                    SUM(`ss`.`other`) AS `other` 
                  FROM `subcounty_summary_yearly` `ss` 
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `subcounty` = '",filter_subcounty,"' AND `year` = '",filter_year,"' ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_top_subcounty_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_top_subcounty_outcomes`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `d`.`name`,
                    `scs`.`subcounty`,
                    SUM(`scs`.`actualinfantsPOS`) AS `positive`,
                    SUM(`scs`.`actualinfants`-`scs`.`actualinfantsPOS`) AS `negative` ";


     IF (from_month != 0 && from_month != '') THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `subcounty_summary` `scs` ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " FROM `subcounty_summary_yearly` `scs` ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " JOIN `districts` `d` ON `scs`.`subcounty` = `d`.`ID`
    WHERE 1 ");



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



    SET @QUERY = CONCAT(@QUERY, " GROUP BY `scs`.`subcounty` ORDER BY `negative` DESC, `positive` DESC ");
    SET @QUERY = CONCAT(@QUERY, " LIMIT 50 ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_unsupported_facilities`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_unsupported_facilities`
()
BEGIN
  SET @QUERY =    "SELECT  
            `vf`.`facilitycode`, `vf`.`name`, `vf`.`DHIScode`,
            `d`.`name` AS `subcounty`, `c`.`name` AS `county`
          FROM `view_facilitys` `vf` 
          JOIN `districts` `d` ON `vf`.`district` = `d`.`ID`
          JOIN `countys` `c` ON `vf`.`county` = `c`.`ID`
          WHERE 1 AND `partner`=0 ";
  
    
    SET @QUERY = CONCAT(@QUERY, " ORDER BY `vf`.`name` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_yearly_lab_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_yearly_lab_summary`
(IN lab INT(11), IN from_year INT(11), IN to_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `ls`.`year`,  
                    `ls`.`month`,  
                    `ls`.`neg`, 
                    `ls`.`pos`, 
                    `ls`.`redraw`
                FROM `lab_summary` `ls`
                WHERE 1 ";

      IF (lab != 0 && lab != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `ls`.`lab` = '",lab,"' ");
      END IF; 

      SET @QUERY = CONCAT(@QUERY, "  AND `year` BETWEEN '",from_year,"' AND '",to_year,"' ORDER BY `year` ASC, `month`  ");
    

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_eid_yearly_lab_tests`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_yearly_lab_tests`
(IN lab INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `ls`.`year`, `ls`.`month`, SUM(`ls`.`tests`) AS `tests`, 
                    SUM(`ls`.`pos`) AS `positive`,
                    SUM(`ls`.`neg`) AS `negative`,
                    SUM(`ls`.`rejected`) AS `rejected`,
                    SUM(`ls`.`tat4`) AS `tat4`
                FROM `lab_summary` `ls`
                WHERE 1 ";

      IF (lab != 0 && lab != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `ls`.`lab` = '",lab,"' ");
      END IF;  

    
      SET @QUERY = CONCAT(@QUERY, " GROUP BY `ls`.`month`, `ls`.`year` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `ls`.`year` DESC, `ls`.`month` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_yearly_summary`;
DROP PROCEDURE IF EXISTS `proc_get_eid_yearly_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_yearly_summary`
(IN county INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `cs`.`year`,  
                    SUM(`cs`.`neg`) AS `negative`, 
                    SUM(`cs`.`pos`) AS `positive`, 
                    SUM(`cs`.`redraw`) AS `redraws`
                FROM `county_summary` `cs`
                WHERE 1 ";

      IF (county != 0 && county != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `cs`.`county` = '",county,"' ");
      END IF; 
    
      SET @QUERY = CONCAT(@QUERY, " GROUP BY `cs`.`year` ");
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `cs`.`year` ASC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_yearly_tests`;
DROP PROCEDURE IF EXISTS `proc_get_eid_yearly_tests`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_yearly_tests`
(IN county INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `cs`.`year`, `cs`.`month`, SUM(`cs`.`tests`) AS `tests`, 
                    SUM(`cs`.`pos`) AS `positive`,
                    SUM(`cs`.`neg`) AS `negative`,
                    SUM(`cs`.`rejected`) AS `rejected`,
                    SUM(`cs`.`infantsless2m`) AS `infants`,
                    SUM(`cs`.`redraw`) AS `redraw`,
                    SUM(`cs`.`tat4`) AS `tat4`
                FROM `county_summary` `cs`
                WHERE 1 ";

      IF (county != 0 && county != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `cs`.`county` = '",county,"' ");
      END IF;  

    
      SET @QUERY = CONCAT(@QUERY, " GROUP BY `cs`.`month`, `cs`.`year` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `cs`.`year` DESC, `cs`.`month` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_lab_performance`;
DELIMITER //
CREATE PROCEDURE `proc_get_lab_performance`
(IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `l`.`ID`, `l`.`labname` AS `name`, `ls`.`tests`, `ls`.`rejected`, `ls`.`pos`, `ls`.neg,
                    `ls`.`month` 
                FROM `lab_summary` `ls`
                JOIN `labs` `l`
                ON `l`.`ID` = `ls`.`lab` 
                WHERE 1 ";

    
        SET @QUERY = CONCAT(@QUERY, " AND `ls`.`year` = '",filter_year,"' ");
  
  SET @QUERY = CONCAT(@QUERY, " ORDER BY `ls`.`month`, `l`.`ID` ");
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_lab_tat`;
DELIMITER //
CREATE PROCEDURE `proc_get_lab_tat`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `l`.`ID`, `l`.`labname` AS `name`, AVG(`ls`.`tat1`) AS `tat1`,
                    AVG(`ls`.`tat2`) AS `tat2`, AVG(`ls`.`tat3`) AS `tat3`,
                    AVG(`ls`.`tat4`) AS `tat4`
                FROM `lab_summary` `ls`
                JOIN `labs` `l`
                ON `l`.`ID` = `ls`.`lab` 
                WHERE 1 ";

       

        IF (filter_month != 0 && filter_month != '') THEN
           SET @QUERY = CONCAT(@QUERY, "  AND `ls`.`year` = '",filter_year,"' AND `ls`.`month`='",filter_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `ls`.`year` = '",filter_year,"' ");
        END IF;
      

  SET @QUERY = CONCAT(@QUERY, " GROUP BY `l`.`ID` ");
    SET @QUERY = CONCAT(@QUERY, " ORDER BY `l`.`ID` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_lab_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_lab_outcomes`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `l`.`ID`, `l`.`labname` AS `name`, 
                    SUM(`ls`.`pos`) AS `pos`,
                    SUM(`ls`.`neg`) AS `neg`
                FROM `lab_summary` `ls`
                JOIN `labs` `l`
                ON `l`.`ID` = `ls`.`lab` 
                WHERE 1 ";

       

        IF (filter_month != 0 && filter_month != '') THEN
           SET @QUERY = CONCAT(@QUERY, "  AND `ls`.`year` = '",filter_year,"' AND `ls`.`month`='",filter_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `ls`.`year` = '",filter_year,"' ");
        END IF;
      

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `l`.`ID` ");    
    SET @QUERY = CONCAT(@QUERY, " ORDER BY `l`.`ID` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;


DROP PROCEDURE IF EXISTS `proc_get_yearly_tests`;
DELIMITER //
CREATE PROCEDURE `proc_get_yearly_tests`
(IN county INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `cs`.`year`, `cs`.`month`, SUM(`cs`.`tests`) AS `tests`, 
                    SUM(`cs`.`pos`) AS `positive`,
                    SUM(`cs`.`neg`) AS `negative`,
                    SUM(`cs`.`rejected`) AS `rejected`,
                    SUM(`cs`.`infantsless2m`) AS `infants`
                FROM `county_summary` `cs`
                WHERE 1 ";

      IF (county != 0 && county != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `cs`.`county` = '",county,"' ");
      END IF;  

    
      SET @QUERY = CONCAT(@QUERY, " GROUP BY `cs`.`month`, `cs`.`year` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `cs`.`year` DESC, `cs`.`month` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_yearly_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_yearly_summary`
(IN county INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `cs`.`year`,  SUM(`cs`.`neg`) AS `neg`, 
                    SUM(`cs`.`pos`) AS `positive`
                FROM `county_summary` `cs`
                WHERE 1 ";

      IF (county != 0 && county != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `cs`.`county` = '",county,"' ");
      END IF; 
    
      SET @QUERY = CONCAT(@QUERY, " GROUP BY `cs`.`year` ");
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `cs`.`year` DESC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;


DROP PROCEDURE IF EXISTS `proc_get_eid_national_age_positivity`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_age_positivity`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        SUM(`nodatapos`) AS `nodatapos`,
                        SUM(`nodataneg`) AS `nodataneg`,
                        SUM(`less2wpos`) AS `less2wpos`,
                        SUM(`less2wneg`) AS `less2wneg`,
                        SUM(`twoto6wpos`) AS `twoto6wpos`,
                        SUM(`twoto6wneg`) AS `twoto6wneg`,
                        SUM(`sixto8wpos`) AS `sixto8wpos`,
                        SUM(`sixto8wneg`) AS `sixto8wneg`,
                        SUM(`sixmonthpos`) AS `sixmonthpos`,
                        SUM(`sixmonthneg`) AS `sixmonthneg`,
                        SUM(`ninemonthpos`) AS `ninemonthpos`,
                        SUM(`ninemonthneg`) AS `ninemonthneg`,
                        SUM(`twelvemonthpos`) AS `twelvemonthpos`,
                        SUM(`twelvemonthneg`) AS `twelvemonthneg`
                    FROM `national_agebreakdown` 
                WHERE 1 ";

   
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
DROP PROCEDURE IF EXISTS `proc_get_national_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_age`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  
            SUM(`sixweekspos`) AS `sixweekspos`, 
            SUM(`sixweeksneg`) AS `sixweeksneg`, 
            SUM(`sevento3mpos`) AS `sevento3mpos`, 
            SUM(`sevento3mneg`) AS `sevento3mneg`,
            SUM(`threemto9mpos`) AS `threemto9mpos`, 
            SUM(`threemto9mneg`) AS `threemto9mneg`,
            SUM(`ninemto18mpos`) AS `ninemto18mpos`, 
            SUM(`ninemto18mneg`) AS `ninemto18mneg`,
            SUM(`above18mpos`) AS `above18mpos`, 
            SUM(`above18mneg`) AS `above18mneg`,
            SUM(`nodatapos`) AS `nodatapos`, 
            SUM(`nodataneg`) AS `nodataneg`
          FROM `national_agebreakdown` WHERE 1";
  
    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month` = '",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;
    SET @QUERY = CONCAT(@QUERY, " ORDER BY `month` ASC ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_national_entry_points`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_entry_points`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
						`ep`.`name`, 
						SUM(`pos`) AS `positive`, 
						SUM(`neg`) AS `negative`  
					FROM `national_entrypoint` `nep` 
					JOIN `entry_points` `ep` 
					ON `nep`.`entrypoint` = `ep`.`ID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `nep`.`year` = '",filter_year,"' AND `nep`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `nep`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ep`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_national_iprophylaxis`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_iprophylaxis`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
						`p`.`name`, 
						SUM(`pos`) AS `positive`, 
						SUM(`neg`) AS `negative` 
					FROM `national_iprophylaxis` `nip` 
					JOIN `prophylaxis` `p` ON `nip`.`prophylaxis` = `p`.`ID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `nip`.`year` = '",filter_year,"' AND `nip`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `nip`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `p`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_national_mprophylaxis`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_mprophylaxis`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
						`p`.`name`, 
						SUM(`pos`) AS `positive`, 
						SUM(`neg`) AS `negative` 
					FROM `national_mprophylaxis` `nmp` 
					JOIN `prophylaxis` `p` ON `nmp`.`prophylaxis` = `p`.`ID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `nmp`.`year` = '",filter_year,"' AND `nmp`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `nmp`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `p`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_national_positivity_notification`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_positivity_notification`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                        SUM(`actualinfantsPOS`) AS `positive`, 
                        ((SUM(`actualinfantsPOS`)/SUM(`actualinfants`))*100) AS `positivity_rate` 
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
DROP PROCEDURE IF EXISTS `proc_get_national_positivity_yearly_notification`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_positivity_yearly_notification`
(IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
                        SUM(`actualinfantsPOS`) AS `positive`, 
                        ((SUM(`actualinfantsPOS`)/SUM(`actualinfants`))*100) AS `positivity_rate` 
                    FROM `national_summary_yearly`
                WHERE 1 ";

    SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_national_testing_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_testing_trends`
(IN from_year INT(11), IN to_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
            `year`, 
            `month`, 
            `pos`, 
            `neg` 
            FROM `national_summary`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `year` = '",from_year,"' OR `year` = '",to_year,"' ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_partner_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_age`
(IN P_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  
            SUM(`sixweekspos`) AS `sixweekspos`, 
            SUM(`sixweeksneg`) AS `sixweeksneg`, 
            SUM(`sevento3mpos`) AS `sevento3mpos`, 
            SUM(`sevento3mneg`) AS `sevento3mneg`,
            SUM(`threemto9mpos`) AS `threemto9mpos`, 
            SUM(`threemto9mneg`) AS `threemto9mneg`,
            SUM(`ninemto18mpos`) AS `ninemto18mpos`, 
            SUM(`ninemto18mneg`) AS `ninemto18mneg`,
            SUM(`above18mpos`) AS `above18mpos`, 
            SUM(`above18mneg`) AS `above18mneg`,
            SUM(`nodatapos`) AS `nodatapos`, 
            SUM(`nodataneg`) AS `nodataneg`
          FROM `ip_agebreakdown` WHERE 1";
  
    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` = '",filter_year,"' AND `month` = '",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` = '",filter_year,"' ");
    END IF;
    SET @QUERY = CONCAT(@QUERY, " ORDER BY `month` ASC ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_partner_entry_points`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_entry_points`
(IN P_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
						`ep`.`name`, 
						SUM(`pos`) AS `positive`, 
						SUM(`neg`) AS `negative`  
					FROM `ip_entrypoint` `nep` 
					JOIN `entry_points` `ep` 
					ON `nep`.`entrypoint` = `ep`.`ID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `nep`.`year` = '",filter_year,"' AND `nep`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `nep`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ep`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_partner_iprophylaxis`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_iprophylaxis`
(IN P_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
						`p`.`name`, 
						SUM(`pos`) AS `positive`, 
						SUM(`neg`) AS `negative` 
					FROM `ip_iprophylaxis` `nip` 
					JOIN `prophylaxis` `p` ON `nip`.`prophylaxis` = `p`.`ID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `nip`.`year` = '",filter_year,"' AND `nip`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `nip`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `p`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_partner_mprophylaxis`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_mprophylaxis`
(IN P_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
						`p`.`name`, 
						SUM(`pos`) AS `positive`, 
						SUM(`neg`) AS `negative` 
					FROM `ip_mprophylaxis` `nmp` 
					JOIN `prophylaxis` `p` ON `nmp`.`prophylaxis` = `p`.`ID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `nmp`.`year` = '",filter_year,"' AND `nmp`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `nmp`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `p`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_partner_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_outcomes`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `p`.`name`,
                    SUM((`ps`.`pos`)) AS `positive`,
                    SUM((`ps`.`neg`)) AS `negative`
                FROM `ip_summary` `ps`
                    JOIN `partners` `p` ON `ps`.`partner` = `p`.`ID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `ps`.`year` = '",filter_year,"' AND `ps`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `ps`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ps`.`partner` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS `proc_get_partner_performance`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_performance`
(IN filter_partner INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `p`.`name`, `ip`.`month`, `ip`.`year`, SUM(`ip`.`tests`) AS `tests`, 
                    SUM(`ip`.`infantsless2m`) AS `infants`, 
                    SUM(`ip`.`pos`) AS `pos`,
                    SUM(`ip`.`neg`) AS `neg`, SUM(`ip`.`rejected`) AS `rej`
                FROM `ip_summary` `ip`
                JOIN `partners` `p`
                ON `p`.`ID` = `ip`.`partner` 
                WHERE 1 ";

    
        

         IF (filter_partner != 0 && filter_partner != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `p`.`ID` = '",filter_partner,"' ");
        END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ip`.`month`, `ip`.`year` ");
  
    SET @QUERY = CONCAT(@QUERY, " ORDER BY `ip`.`year` DESC, `ip`.`month` ASC ");


  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;


DROP PROCEDURE IF EXISTS `proc_get_partner_year_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_year_summary`
(IN filter_partner INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `ip`.`year`,  SUM(`ip`.`pos`) AS `positive`,
                    SUM(`ip`.`neg`) AS `negative`
                FROM `ip_summary` `ip`
                JOIN `partners` `p`
                ON `p`.`ID` = `ip`.`partner` 
                WHERE 1 ";

         IF (filter_partner != 0 && filter_partner != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `p`.`ID` = '",filter_partner,"' ");
        END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ip`.`year` ");
  
    SET @QUERY = CONCAT(@QUERY, " ORDER BY `ip`.`year` DESC ");


  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_partner_testing_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_testing_trends`
(IN P_id INT(11), IN from_year INT(11), IN to_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
            `year`, 
            `month`, 
            `pos`, 
            `neg` 
            FROM `ip_summary`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` BETWEEN '",from_year,"' AND '",to_year,"' ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
