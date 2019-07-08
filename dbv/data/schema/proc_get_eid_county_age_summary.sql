DROP PROCEDURE IF EXISTS `proc_get_eid_county_age_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_eid_county_age_summary`
(IN C_Id INT(11), IN filter_year INT(11), IN from_month INT(11), IN to_year INT(11), IN to_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
  					SUM(`infantsless2m`) AS `infantsless2m`,       
					SUM(`infantsless2mPOS`) AS `infantsless2mPOS`,     
					SUM(`infantsless2w`) AS `infantsless2w`,       
					SUM(`infantsless2wPOS`) AS `infantsless2wPOS`,    
					SUM(`infants4to6w`) AS `infants4to6w`,        
					SUM(`infants4to6wPOS`) AS `infants4to6wPOS`,     
					SUM(`infantsabove2m`) AS `infantsabove2m`,      
					SUM(`infantsabove2mPOS`) AS `infantsabove2mPOS`,   
					SUM(`adults`) AS `adults`,              
					SUM(`adultsPOS`) AS `adultsPOS`            
					FROM `county_summary`
    WHERE 1";


    IF (from_month != 0 && from_month != '') THEN
      IF (to_month != 0 && to_month != '' && filter_year = to_year) THEN
            SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month` BETWEEN '",from_month,"' AND '",to_month,"' ");
        ELSE IF(to_month != 0 && to_month != '' && filter_year != to_year) THEN
          SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND ((`year` = '",filter_year,"' AND `month` >= '",from_month,"')  OR (`year` = '",to_year,"' AND `month` <= '",to_month,"') OR (`year` > '",filter_year,"' AND `year` < '",to_year,"')) ");
        ELSE
            SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' AND `month`='",from_month,"' ");
        END IF;
    END IF;
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `county` = '",C_Id,"' AND `year` = '",filter_year,"' ");
    END IF;

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;
