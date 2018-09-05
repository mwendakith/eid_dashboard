DROP PROCEDURE IF EXISTS `proc_get_eid_age_testing_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_age_testing_trends`
(IN from_year INT(11), IN to_year INT(11))
BEGIN
  SET @QUERY =    "SELECT 
            `year`, 
            `month`, 
            `nodatapos`,       
            `nodataneg`,     
            `less2wpos`,       
            `less2wneg`,    
            `twoto6wpos`,        
            `twoto6wneg`,     
            `sixto8wpos`,      
            `sixto8wneg`,   
            `sixmonthpos`,              
            `sixmonthneg`,
            `ninemonthpos`,      
            `ninemonthneg`,   
            `twelvemonthpos`,              
            `twelvemonthneg` 
            FROM `national_agebreakdown`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `year` BETWEEN '",from_year,"' AND '",to_year,"' ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

