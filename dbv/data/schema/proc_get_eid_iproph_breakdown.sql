DROP PROCEDURE IF EXISTS `proc_get_eid_iproph_breakdown`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_iproph_breakdown`
(IN Pr_ID INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN county INT(11), IN subcounty INT(11), IN partner INT(11))
BEGIN
  SET @QUERY =    "SELECT
                `com`.`name`,
                SUM(`tests`) AS `tests`,       
                SUM(`pos`) AS `pos`,     
                SUM(`neg`) AS `neg`,       
                SUM(`redraw`) AS `redraw` ";

    IF (county != 0 || county != '') THEN
        SET @QUERY = CONCAT(@QUERY, "FROM `county_iprophylaxis` LEFT JOIN `countys` `com` ON `county_iprophylaxis`.`county` = `com`.`ID` WHERE 1");
    END IF;           
        IF (subcounty != 0 || subcounty != '') THEN
        SET @QUERY = CONCAT(@QUERY, "FROM `subcounty_iprophylaxis` LEFT JOIN `districts` `com` ON `subcounty_iprophylaxis`.`subcounty` = `com`.`ID` WHERE 1");
    END IF;
    IF (partner != 0 || partner != '') THEN
        SET @QUERY = CONCAT(@QUERY, "FROM `ip_iprophylaxis` LEFT JOIN `partners` `com` ON `ip_iprophylaxis`.`partner` = `com`.`ID` WHERE `p`.`flag` = '1'");
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

    SET @QUERY = CONCAT(@QUERY, " AND `prophylaxis` = '",Pr_ID,"' GROUP BY `com`.`ID` ORDER BY `tests` DESC ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;