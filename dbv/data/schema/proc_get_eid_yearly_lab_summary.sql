DROP PROCEDURE IF EXISTS `proc_get_eid_yearly_lab_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_yearly_lab_summary`
(IN lab INT(11), IN from_year INT(11), IN to_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `ls`.`year`,  
                    `ls`.`month`,  
                    (`ls`.`neg` + (`ls`.`confirmdna`-`ls`.`confirmedPOs`) + (`ls`.`repeatspos`-`ls`.`repeatposPOS`) + (`ls`.`tiebreaker`-`ls`.`tiebreakerPOS`)) AS `neg`, 
                    (`ls`.`pos` + `ls`.`confirmedPOs` + `ls`.`repeatposPOS` + `ls`.`tiebreakerPOS`) AS `pos`, 
                    `ls`.`redraw`
                FROM `lab_summary` `ls`
                WHERE 1 ";

      IF (lab != 0 && lab != '') THEN
           SET @QUERY = CONCAT(@QUERY, " AND `ls`.`lab` = '",lab,"' ");
      END IF; 

      SET @QUERY = CONCAT(@QUERY, "  AND `year` BETWEEN '",from_year,"' AND '",to_year,"' ORDER BY `year` ASC, `month`  ");
    

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;