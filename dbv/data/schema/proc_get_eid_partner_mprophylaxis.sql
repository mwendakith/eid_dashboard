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