DROP PROCEDURE IF EXISTS `proc_get_eid_lab_performance_stats`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_lab_performance_stats`
(IN filter_year INT(11), IN filter_month INT(11))
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

      IF (filter_month != 0 && filter_month != '') THEN
        SET @QUERY = CONCAT(@QUERY, " AND `ls`.`year` = '",filter_year,"' AND `ls`.`month`='",filter_month,"' ");
      ELSE
          SET @QUERY = CONCAT(@QUERY, " AND `ls`.`year` = '",filter_year,"' ");
      END IF;

      SET @QUERY = CONCAT(@QUERY, " GROUP BY `l`.`ID` ORDER BY `alltests` DESC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;