DROP PROCEDURE IF EXISTS `proc_get_partner_outcomes`;
DROP PROCEDURE IF EXISTS `proc_get_eid_partner_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_outcomes`
(IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `p`.`name`,
                    SUM((`ps`.`pos`)) AS `positive`,
                    SUM((`ps`.`neg`)) AS `negative`
                FROM `ip_summary` `ps`
                    JOIN `partners` `p` ON `ps`.`partner` = `p`.`ID`
                WHERE 1";

    IF (from_month != 0 && from_month != '') THEN
        IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `ps`.`year` = '",filter_year,"' AND `ps`.`month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `ps`.`year` = '",filter_year,"' AND `ps`.`month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `ps`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ps`.`partner` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_partner_sites_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_sites_outcomes`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `vf`.`name`,
                    SUM(`pos`) AS `positive`,
                    SUM(`neg`) AS `negative` 
                    FROM `site_summary` `ss` 
                    LEFT JOIN `view_facilitys` `vf` 
                    ON `ss`.`facility` = `vf`.`ID`  
                  WHERE 1";

    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `vf`.`partner` = '",P_id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `vf`.`partner` = '",P_id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vf`.`partner` = '",P_id,"' AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vf`.`name` ORDER BY `negative` DESC, `positive` DESC LIMIT 0, 50 ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_partner_iprophylaxis`;
DROP PROCEDURE IF EXISTS `proc_get_eid_partner_iprophylaxis`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_iprophylaxis`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `p`.`name`, 
                        SUM(`pos`) AS `positive`, 
                        SUM(`neg`) AS `negative` 
                    FROM `ip_iprophylaxis` `nip` 
                    JOIN `prophylaxis` `p` ON `nip`.`prophylaxis` = `p`.`ID`
                WHERE 1";

    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `nip`.`year` = '",filter_year,"' AND `nip`.`month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `nip`.`year` = '",filter_year,"' AND `nip`.`month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `nip`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `p`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;


DROP PROCEDURE IF EXISTS `proc_get_partner_mprophylaxis`;
DROP PROCEDURE IF EXISTS `proc_get_eid_partner_mprophylaxis`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_mprophylaxis`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `p`.`name`, 
                        SUM(`pos`) AS `positive`, 
                        SUM(`neg`) AS `negative` 
                    FROM `ip_mprophylaxis` `nmp` 
                    JOIN `prophylaxis` `p` ON `nmp`.`prophylaxis` = `p`.`ID`
                WHERE 1";

    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `nmp`.`year` = '",filter_year,"' AND `nmp`.`month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `nmp`.`year` = '",filter_year,"' AND `nmp`.`month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `nmp`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `p`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_partner_entry_points`;
DROP PROCEDURE IF EXISTS `proc_get_eid_partner_entry_points`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_entry_points`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `ep`.`name`, 
                        SUM(`pos`) AS `positive`, 
                        SUM(`neg`) AS `negative`  
                    FROM `ip_entrypoint` `nep` 
                    JOIN `entry_points` `ep` 
                    ON `nep`.`entrypoint` = `ep`.`ID`
                WHERE 1";

    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `nep`.`year` = '",filter_year,"' AND `nep`.`month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `nep`.`year` = '",filter_year,"' AND `nep`.`month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `nep`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ep`.`ID` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_partner_age`;
DROP PROCEDURE IF EXISTS `proc_get_eid_partner_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_age`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
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
      IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` = '",filter_year,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_partner_hei`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_hei`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
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
      IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` = '",filter_year,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_partner_eid_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_eid_outcomes`
(IN P_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
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
        AVG(`sitessending`) AS `sitessending`
    FROM `ip_summary`
    WHERE 1";

    IF (from_month != 0 && from_month != '') THEN
       IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` = '",filter_year,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;