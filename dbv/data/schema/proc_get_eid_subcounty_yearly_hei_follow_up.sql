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
