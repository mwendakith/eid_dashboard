DROP PROCEDURE IF EXISTS `proc_get_eid_national_yearly_tests`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_yearly_tests`
()
BEGIN
  SET @QUERY =    "SELECT
                    `ns`.`year`, `ns`.`month`, SUM(`ns`.`tests`) AS `tests`, 
                    SUM(`ns`.`pos`) AS `positive`,
                    SUM(`ns`.`neg`) AS `negative`,
                    SUM(`ns`.`rejected`) AS `rejected`,
                    SUM(`ns`.`infantsless2m`) AS `infants`,
                    SUM(`ns`.`tat4`) AS `tat4`
                FROM `national_summary` `ns`
                WHERE 1 ";

      SET @QUERY = CONCAT(@QUERY, " GROUP BY `ns`.`month`, `ns`.`year` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `ns`.`year` DESC, `ns`.`month` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_eid_yearly_tests`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_yearly_tests`
(IN county INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `cs`.`year`, `cs`.`month`, SUM(`cs`.`tests`) AS `tests`, 
                    SUM(`cs`.`pos`) AS `positive`,
                    SUM(`cs`.`neg`) AS `negative`,
                    SUM(`cs`.`rejected`) AS `rejected`,
                    SUM(`cs`.`infantsless2m`) AS `infants`,
                    SUM(`cs`.`tat4`) AS `tat4`
                FROM `county_summary` `cs`
                WHERE 1 ";

      IF (county != 0 && county != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `cs`.`county` = '",county,"' ");
      END IF;  

    
      SET @QUERY = CONCAT(@QUERY, " GROUP BY `cs`.`month`, `cs`.`year` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `cs`.`year` DESC, `cs`.`month` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;