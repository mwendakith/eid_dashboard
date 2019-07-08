DROP PROCEDURE IF EXISTS `proc_get_eid_national_yearly_hei`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_national_yearly_hei`
(IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
        SUM(`enrolled`) AS `enrolled`,
        SUM(`dead`) AS `dead`,
        SUM(`ltfu`) AS `ltfu`,
        SUM(`adult`) AS `adult`,
        SUM(`transout`) AS `transout`,
        SUM(`other`) AS `other`
    FROM `national_summary_yearly`
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
     
END //
DELIMITER ;
