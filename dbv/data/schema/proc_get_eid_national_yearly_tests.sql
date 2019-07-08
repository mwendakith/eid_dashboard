DROP PROCEDURE IF EXISTS `proc_get_eid_national_yearly_tests`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_yearly_tests`
()
BEGIN
  SET @QUERY =    "SELECT
                    `ns`.`year`, `ns`.`month`, 
                    SUM(`ns`.`firstdna`) AS `tests`, 
                    SUM(`ns`.`pos`) AS `positive`,
                    SUM(`ns`.`neg`) AS `negative`,
                    SUM(`ns`.`allpos`) AS `allpositive`,
                    SUM(`ns`.`allneg`) AS `allnegative`,
                    SUM(`ns`.`rpos`) AS `rpos`,
                    SUM(`ns`.`rneg`) AS `rneg`,
                    SUM(`ns`.`rejected`) AS `rejected`,
                    SUM(`ns`.`infantsless2m`) AS `infants`,
                    SUM(`ns`.`infantsless2mPOS`) AS `infantspos`,
                    SUM(`ns`.`redraw`) AS `redraw`,
                    SUM(`ns`.`tat4`) AS `tat4`
                FROM `national_summary` `ns`
                WHERE 1 ";

      SET @QUERY = CONCAT(@QUERY, " GROUP BY `ns`.`month`, `ns`.`year` ");

     
      SET @QUERY = CONCAT(@QUERY, " ORDER BY `ns`.`year` ASC, `ns`.`month` ASC ");
      

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
