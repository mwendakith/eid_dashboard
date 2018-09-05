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
                WHERE `p`.`flag` = '1' ";

         IF (filter_partner != 0 && filter_partner != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `p`.`ID` = '",filter_partner,"' ");
        END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ip`.`year` ");
  
    SET @QUERY = CONCAT(@QUERY, " ORDER BY `ip`.`year` ASC ");


  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
