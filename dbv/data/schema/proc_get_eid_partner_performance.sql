DROP PROCEDURE IF EXISTS `proc_get_eid_partner_performance`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_partner_performance`
(IN filter_partner INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `ip`.`month`, `ip`.`year`, 

                    SUM(`ip`.`firstdna`) AS `tests`, 
                    SUM(`ip`.`pos`) AS `positive`,
                    SUM(`ip`.`neg`) AS `negative`,
                    SUM(`ip`.`allpos`) AS `allpositive`,
                    SUM(`ip`.`allneg`) AS `allnegative`,
                    SUM(`ip`.`rpos`) AS `rpos`,
                    SUM(`ip`.`rneg`) AS `rneg`,
                    SUM(`ip`.`rejected`) AS `rejected`,
                    SUM(`ip`.`infantsless2m`) AS `infants`,
                    SUM(`ip`.`infantsless2mPOS`) AS `infantspos`,
                    SUM(`ip`.`redraw`) AS `redraw`,
                    SUM(`ip`.`tat4`) AS `tat4`
                FROM `ip_summary` `ip`
                JOIN `partners` `p`
                ON `p`.`ID` = `ip`.`partner` 
                WHERE `p`.`flag` = '1' ";

    
        

       SET @QUERY = CONCAT(@QUERY, " AND `p`.`ID` = '",filter_partner,"' ");


    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ip`.`month`, `ip`.`year` ");
  
    SET @QUERY = CONCAT(@QUERY, " ORDER BY `ip`.`year` DESC, `ip`.`month` ASC ");


  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
