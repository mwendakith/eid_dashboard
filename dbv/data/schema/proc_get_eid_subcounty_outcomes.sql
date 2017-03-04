DROP PROCEDURE IF EXISTS `proc_get_eid_subcounty_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_subcounty_outcomes`
(IN C_id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `d`.`name`,
                    `scs`.`subcounty`,
                    SUM(`scs`.`pos`) AS `positive`,
                    SUM(`scs`.`neg`) AS `negative` 
                FROM `subcounty_summary` `scs` 
                JOIN `districts` `d` ON `scs`.`subcounty` = `d`.`ID` 
                JOIN `countys` `c` ON `d`.`county` = `c`.`ID`
    WHERE 1";

    IF (from_month != 0 && from_month != '') THEN
        IF (to_month != 0 && to_month != '') THEN
            SET @QUERY = CONCAT(@QUERY, " AND `c`.`ID` = '",C_id,"' AND `scs`.`year` = '",filter_year,"' AND `scs`.`month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `c`.`ID` = '",C_id,"' AND `scs`.`year` = '",filter_year,"' AND `scs`.`month`='",from_month,"' ");
        END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `c`.`ID` = '",C_id,"' AND `scs`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `scs`.`subcounty` ORDER BY `negative` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;   