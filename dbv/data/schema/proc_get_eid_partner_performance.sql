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
