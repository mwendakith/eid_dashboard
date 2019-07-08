<<<<<<< HEAD
DROP PROCEDURE IF EXISTS `proc_get_partner_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_age`
(IN P_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  
            SUM(`sixweekspos`) AS `sixweekspos`, 
            SUM(`sixweeksneg`) AS `sixweeksneg`, 
            SUM(`sevento3mpos`) AS `sevento3mpos`, 
            SUM(`sevento3mneg`) AS `sevento3mneg`,
            SUM(`threemto9mpos`) AS `threemto9mpos`, 
            SUM(`threemto9mneg`) AS `threemto9mneg`,
            SUM(`ninemto18mpos`) AS `ninemto18mpos`, 
            SUM(`ninemto18mneg`) AS `ninemto18mneg`,
            SUM(`above18mpos`) AS `above18mpos`, 
            SUM(`above18mneg`) AS `above18mneg`,
            SUM(`nodatapos`) AS `nodatapos`, 
            SUM(`nodataneg`) AS `nodataneg`
          FROM `ip_agebreakdown` WHERE 1";
  
    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` = '",filter_year,"' AND `month` = '",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` = '",filter_year,"' ");
    END IF;
    SET @QUERY = CONCAT(@QUERY, " ORDER BY `month` ASC ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
=======
DROP PROCEDURE IF EXISTS `proc_get_partner_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_age`
(IN P_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  
            SUM(`sixweekspos`) AS `sixweekspos`, 
            SUM(`sixweeksneg`) AS `sixweeksneg`, 
            SUM(`sevento3mpos`) AS `sevento3mpos`, 
            SUM(`sevento3mneg`) AS `sevento3mneg`,
            SUM(`threemto9mpos`) AS `threemto9mpos`, 
            SUM(`threemto9mneg`) AS `threemto9mneg`,
            SUM(`ninemto18mpos`) AS `ninemto18mpos`, 
            SUM(`ninemto18mneg`) AS `ninemto18mneg`,
            SUM(`above18mpos`) AS `above18mpos`, 
            SUM(`above18mneg`) AS `above18mneg`,
            SUM(`nodatapos`) AS `nodatapos`, 
            SUM(`nodataneg`) AS `nodataneg`
          FROM `ip_agebreakdown` WHERE 1";
  
    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` = '",filter_year,"' AND `month` = '",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` = '",filter_year,"' ");
    END IF;
    SET @QUERY = CONCAT(@QUERY, " ORDER BY `month` ASC ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;
>>>>>>> 6f706d757719ba85748ebde050471e61e5ec9556
