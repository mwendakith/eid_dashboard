DROP PROCEDURE IF EXISTS `proc_get_eid_national_tat`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_tat`
(IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11), IN type INT(11), IN ID INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `vls`.`tat1`, 
                        `vls`.`tat2`, 
                        `vls`.`tat3`, 
                        `vls`.`tat4`";
    IF (type = 0) THEN
      SET @QUERY = CONCAT(@QUERY, " FROM `national_summary` `vls` WHERE 1 ");
    END IF;
    IF (type = 1) THEN
      SET @QUERY = CONCAT(@QUERY, " , `c`.`name` FROM `county_summary` `vls` JOIN `countys` `c` ON `c`.`ID` = `vls`.`county` WHERE `vls`.`county` = '",ID,"' ");
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
    

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
