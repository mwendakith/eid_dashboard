DROP PROCEDURE IF EXISTS `proc_get_eid_national_yearly_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_yearly_summary`
()
BEGIN
  SET @QUERY =    "SELECT 
                    `year`, 
                    SUM(`tests`) AS `tests`, 
                    SUM(`pos`) AS `positive`, 
                    SUM(`neg`) AS `negative`, 
                    SUM(`redraw`) AS `redraws` 
                  FROM `national_summary`  
                  WHERE `year` > '2007'
                  GROUP BY `year` ORDER BY `year` ASC";

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
