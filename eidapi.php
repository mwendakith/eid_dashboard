<?php
error_reporting(0);
$format = 'json';
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];
$patient  = $_GET['samplecode'];
$mflcode  = $_GET['mflcode'];
$apikey=$_GET['apikey'];

if ($apikey !='uT!7x5e3aw')
{
echo '<h1>401 Unauthorized</h1>';
 //header("HTTP/1.1 401 Unauthorized");

}
else
{
	
$table='samples';	
	


$con = mysql_connect("10.230.50.11:3307", "root", "FnP5FjbnMrzXCm.") or die ('MySQL Error.');
mysql_select_db('eid_kemri2', $con) or die('MySQL Error.');



if ($patient !="''") //amr identifier provided
{
	if ($startDate !='' && $endDate !='') //date range provided
	{
		
$vvresult = mysql_query("SELECT v.ID,v.patient,f.facilitycode,v.datecollected,v.datereceived,v.datetested,v.result,v.datedispatched   FROM $table v ,facilitys f  where v.facility=f.ID  and v.patient like '$patient%' and v.datecollected between '$startDate' and '$endDate' and v.flag=1 AND v.repeatt=0 " , $con) or die('MySQL Error.');	
		
	}
	else  //no date range, so retrieve for patient alone
	{
$vvresult = mysql_query("SELECT v.ID,v.patient,f.facilitycode,v.datecollected,v.datereceived,v.datetested,v.result,v.datedispatched   FROM $table v ,facilitys f  where v.facility=f.ID  and v.patient like '$patient%'  and v.flag=1 AND v.repeatt=0 " , $con) or die(mysql_error());	
		
	}

}
elseif ($mflcode !="''")  //mfl code & date range
{
	$fautoid=GetFacilityAutoID($mflcode);
	if ($startDate !='' && $endDate !='') //date range provided
	{
		
$vvresult = mysql_query("SELECT v.ID,v.patient,f.facilitycode,v.datecollected,v.datereceived,v.datetested,v.result,v.datedispatched   FROM $table v ,facilitys f  where v.facility=f.ID  and v.facility='$fautoid' and v.datecollected between '$startDate' and '$endDate' and v.flag=1 AND v.repeatt=0" , $con) or die('MySQL Error.');	
		
	}
	else  //no date range so only mflcode
	{
$vvresult = mysql_query("SELECT v.ID,v.patient,f.facilitycode,v.datecollected,v.datereceived,v.datetested,v.result,v.datedispatched  FROM $table v ,facilitys f  where v.facility=f.ID  and v.facility='$fautoid'  and v.flag=1 AND v.repeatt=0" , $con) or die('MySQL Error.');	
		
	}

}


		
		
$numrows=mysql_num_rows($vvresult);


		//echo $offset;
//ECHO $numrows;
// number of rows to show per page

$rowsperpage = 100;
$pageNum = 1;
		
		// if $_GET['page'] defined, use it as page number
		if(isset($_GET['page']))
		{
		$pageNum = $_GET['page'];
		}
		
		// counting the offset
		$offset = ($pageNum - 1) * $rowsperpage;
		//echo $currentpage  .$offset.$rowsperpage;

if ($patient !="") //amr identifier provided
{
	if ($startDate !='' && $endDate !='') //date range provided
	{
		
$vresult = mysql_query("SELECT v.ID,v.patient,f.facilitycode,v.datecollected,v.datereceived,v.datetested,v.result,v.datedispatched   FROM $table v ,facilitys f  where v.facility=f.ID  and v.patient like '$patient%' and v.datecollected between '$startDate' and '$endDate' and v.flag=1 AND v.repeatt=0 LIMIT $offset, $rowsperpage" , $con) or die('MySQL Error.');	
		
	}
	else  //no date range, so retrieve for patient alone
	{
$vresult = mysql_query("SELECT v.ID,v.patient,f.facilitycode,v.datecollected,v.datereceived,v.datetested,v.result,v.datedispatched   FROM $table v ,facilitys f  where v.facility=f.ID  and v.patient like '$patient%'  and v.flag=1 AND v.repeatt=0 LIMIT $offset, $rowsperpage" , $con) or die(mysql_error());	
		
	}

}
elseif ($mflcode > 0)  //mfl code & date range
{
	$fautoid=GetFacilityAutoID($mflcode);
	$mwaka=date('Y');
	$mwezi=date('m');
	if ($startDate !='' && $endDate !='') //date range provided
	{
		
$vresult = mysql_query("SELECT v.ID,v.patient,f.facilitycode,v.datecollected,v.datereceived,v.datetested,v.result,v.datedispatched   FROM $table v ,facilitys f  where v.facility=f.ID  and v.facility='$fautoid' and v.datecollected between '$startDate' and '$endDate' and v.flag=1 AND v.repeatt=0 LIMIT $offset, $rowsperpage" , $con) or die('MySQL Error.');	
		
	}
	else  //no date range so only mflcode
	{
$vresult = mysql_query("SELECT v.ID,v.patient,f.facilitycode,v.datecollected,v.datereceived,v.datetested,v.result,v.datedispatched  FROM $table v ,facilitys f  where v.facility=f.ID  and v.facility='$fautoid' AND YEAR(datetested)='$mwaka' AND MONTH(datecollected)='$mwezi' and v.flag=1 AND v.repeatt=0 LIMIT $offset, $rowsperpage" , $con) or die('MySQL Error.');	
		
	}

}

 
//Preapre our output
if($format == 'json') {

$json = array();
$mnumrows=mysql_num_rows($vresult);


		while ($maRow = mysql_fetch_assoc($vresult))
		{
$maArray[] = $maRow['ID']  ;
$maArray1[] = $maRow['patient']  ;
$maArray3[] = $maRow['facilitycode']  ;
$maArray6[] = $maRow['datecollected']  ;
$maArray7[] = $maRow['datereceived']  ;
$maArray8[] = $maRow['datetested']  ;
$maArray10[] = $maRow['result']  ;
$maArray11[] = $maRow['datedispatched']  ;
	   }
		for ($mrow = 0; $mrow < $mnumrows; $mrow++)
		{
		$labid=$maArray[$mrow];	
         $cname=$maArray1[$mrow];			
		$fcode=$maArray3[$mrow];
		$datecollected=$maArray6[$mrow];
 if (($datecollected !="0000-00-00") &&  ( $datecollected !="")&&  ($datecollected !="1970-01-01") &&  ($datecollected !="0"))
{
$datecollected=date("d-M-Y",strtotime($datecollected));	
}
else
{
$datecollected="";
}
		$datereceived=$maArray7[$mrow];
 if (( $datereceived !="0000-00-00") &&  ( $datereceived !="")&&  ( $datereceived !="1970-01-01") &&  ( $datereceived !="0"))
{
$datereceived=date("d-M-Y",strtotime( $datereceived));	
}
else
{
$datereceived="";
}
		$datetested=$maArray8[$mrow];
 if (( $datetested !="0000-00-00") &&  ( $datetested !="")&&  ( $datetested !="1970-01-01") &&  ( $datetested !="0"))
{
 $datetested=date("d-M-Y",strtotime( $datetested));	
}
else
{
$datetested="";
}


$results=GetResultType($maArray10[$mrow]);	

   



$datedispatched=$maArray11[$mrow];
if (( $datedispatched !="0000-00-00") &&  ( $datedispatched !="")&&  ( $datedispatched !="1970-01-01") && ($datedispatched !="0") )
{
$datedispatched=date("d-M-Y",strtotime($datedispatched));	
}
else
{
$datedispatched="";
}
	 $bus = array(
        'LabID' => $labid ,
		'PatientID' => $cname,
		'MFLCode' => $fcode,
		'DateCollected' => $datecollected,
		'DateReceived' => $datereceived,
		'DateTested' => $datetested,
		'Result' => $results,
		'DateDispatched' => $datedispatched ,
		
		
    );
    array_push($json, $bus);
		}
		
//$jsonstring = json_encode($json);
$jsonstring = json_encode(array_map('utf8_encode', $json));



//echo json_encode($url, JSON_UNESCAPED_SLASHES), "\n";
//echo $jsonstring;
$output = json_encode(array('posts' => $json ), JSON_UNESCAPED_SLASHES);
//echo $jsonstring;

 
} elseif($format == 'xml') {
/*
 
header('Content-type: text/xml');
$outputÂ  = "<?xml version=\"1.0\"?>\n";
$output .= "<viralsamples >\n";
 		$mnumrows=mysql_num_rows($vresult);
		while ($maRow = mysql_fetch_assoc($vresult))
		{
			$maArray[] = $maRow['Patient']  ;
			$maArray1[] = $maRow['MFLCode']  ;
			$maArray2[] = $maRow['District']  ;
			$maArray3[] = $maRow['DateTested']  ;
			$maArray4[] = $maRow['Result']  ;
		}	
		
		for ($mrow = 0; $mrow < $mnumrows; $mrow++)
		{

$dname=GetDistrictName($maArray2[$mrow]);

//echo 'name'. $dname;

//exit();
$output .= "<viralsample> \n";
$output .= "<viralsample_ccc_no>" . $maArray[$mrow] . "</viralsample_ccc_no> \n";
$output .= "<viralsample_MFL_Code>" . $maArray1[$mrow] . "</viralsample_MFL_Code> \n";
$output .= "<viralsample_district>" . $dname . "</viralsample_district> \n";
$output .= "<viralsample_datetested>" . $maArray3[$mrow] . "</viralsample_datetested> \n";
$output .= "<viralsample_result>" . urlencode($maArray4[$mrow]) . "</viralsample_result> \n";

$output .= "</viralsample> \n";
}
 
$output .= "</viralsamples >";
 */
} else {
die('Improper response format.');
}
 
//Output the output.
echo $output;
}
//get sample result
function GetResultType($result)
{
	$result = "SELECT name FROM results WHERE ID = '$result'";
	$getresult = mysql_query($result) or die(mysql_error());
	$resulttype = mysql_fetch_array($getresult);
	$showresult = $resulttype['name'];
	
return $showresult;
}
function GetAMRLocation($location)
{
$sql=mysql_query("select name from amrslocations where identifier='$location'") or die(mysql_error());
$aa=mysql_fetch_array($sql);
$amrslocation=$aa['name'];
return $amrslocation;
}

//get mfl code
function GetFacilityMFLCode($AutoID)
{
$districtnamequery=mysql_query("SELECT facilitycode
            FROM facilitys
            WHERE  ID='$AutoID'"); 
			$districtname = mysql_fetch_array($districtnamequery);  
			$fcode=$districtname['facilitycode'];
			if ($fcode ==0)
			{
			$fcode="";
			}
			elseif ($fcode > 19000)
			{
			$fcode="";
			}
			else
			{
			$fcode=$fcode;
			}
		return $fcode;
}
function GetFacilityName($fcode)
{
$districtnamequery=mysql_query("SELECT name 
            FROM facilitys
            WHERE  ID='$fcode'"); 
			$districtname = mysql_fetch_array($districtnamequery);  
			$facilityname=$districtname['name'];
		return $facilityname;
}
function GetFacilityAutoID($fcode)
{
$districtnamequery=mysql_query("SELECT ID
            FROM facilitys
            WHERE  facilitycode='$fcode'"); 
			$districtname = mysql_fetch_array($districtnamequery);  
			$facilityname=$districtname['ID'];
		return $facilityname;
}
function getfacilitycounty($facility)
{
$countyquery=mysql_query("select countys.name as countyname from countys, districts, facilitys where facilitys.ID = '$facility' and facilitys.district = districts.ID and districts.county = countys.ID"); 
		$countydets = mysql_fetch_array($countyquery);  
		$countyname = $countydets['countyname'];
return $countyname;
}

function GetDistrictID($facility)
{
	$districtidquery=mysql_query("SELECT district
            FROM facilitys
            WHERE  ID='$facility'"); 
			$noticia = mysql_fetch_array($districtidquery);  
			
			$distid=$noticia['district'];
			return $distid;

}
//get county name
function GetCountyName($countyid)
{
$districtnamequery=mysql_query("SELECT name 
            FROM countys
            WHERE  ID='$countyid'"); 
			$districtname = mysql_fetch_array($districtnamequery);  
			$CountyName=$districtname['name'];
		return $CountyName;
}
 //get distrcit name
function GetDistrictName($distid)
{
$districtnamequery=mysql_query("SELECT name 
            FROM districts
            WHERE  ID='$distid'"); 
			$districtname = mysql_fetch_array($districtnamequery);  
			$distname=$districtname['name'];
		return $distname;
}

function gettotalviralloadtestsbyfacility($period,$facility,$startdate,$enddate,$monthly,$monthyear,$startmonth,$endmonth,$quarteryear,$bistartmonth,$biendmonth,$biannualyear,$yearly)
{

If ($period == 1)//weekly/date range
{ 
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result !='' AND viralsamples.datetested BETWEEN '$startdate'  AND '$enddate'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 2)//monthly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result !='' AND YEAR(viralsamples.datetested)='$monthyear' and MONTH(viralsamples.datetested)='$monthly'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 3)//quarterly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result !='' AND YEAR(viralsamples.datetested)='$quarteryear' and MONTH(viralsamples.datetested) BETWEEN  '$startmonth'  and '$endmonth' AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 4)//bi-annaul
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result !='' AND YEAR(viralsamples.datetested)='$biannualyear' and MONTH(viralsamples.datetested) BETWEEN  '$bistartmonth'  and '$biendmonth' AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 5)//yearly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result !='' AND YEAR(viralsamples.datetested)='$yearly'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
$dd2=mysql_fetch_array($dd);
$totaltests=$dd2['numsamples'];		
return $totaltests;
}
function gettotalviralloadinvalidtestsbyfacility($period,$facility,$startdate,$enddate,$monthly,$monthyear,$startmonth,$endmonth,$quarteryear,$bistartmonth,$biendmonth,$biannualyear,$yearly)
{

If ($period == 1)//weekly/date range
{ 
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result !='' AND viralsamples.datetested BETWEEN '$startdate'  AND '$enddate'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 AND  (viralsamples.result ='' or viralsamples.result='0' or viralsamples.result='Collect New Sample' or viralsamples.result='Failed' or viralsamples.result='Invalid') ") or die(mysql_error());
}
elseif ($period == 2)//monthly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result !='' AND YEAR(viralsamples.datetested)='$monthyear' and MONTH(viralsamples.datetested)='$monthly'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 AND  (viralsamples.result ='' or viralsamples.result='0' or viralsamples.result='Collect New Sample' or viralsamples.result='Failed' or viralsamples.result='Invalid')") or die(mysql_error());
}
elseif ($period == 3)//quarterly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result !='' AND YEAR(viralsamples.datetested)='$quarteryear' and MONTH(viralsamples.datetested) BETWEEN  '$startmonth'  and '$endmonth' AND viralsamples.repeatt=0  AND viralsamples.Flag=1 AND  (viralsamples.result ='' or viralsamples.result='0' or viralsamples.result='Collect New Sample' or viralsamples.result='Failed' or viralsamples.result='Invalid')") or die(mysql_error());
}
elseif ($period == 4)//bi-annaul
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result !='' AND YEAR(viralsamples.datetested)='$biannualyear' and MONTH(viralsamples.datetested) BETWEEN  '$bistartmonth'  and '$biendmonth' AND viralsamples.repeatt=0  AND viralsamples.Flag=1 AND  (viralsamples.result ='' or viralsamples.result='0' or viralsamples.result='Collect New Sample' or viralsamples.result='Failed' or viralsamples.result='Invalid')") or die(mysql_error());
}
elseif ($period == 5)//yearly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result !='' AND YEAR(viralsamples.datetested)='$yearly'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
$dd2=mysql_fetch_array($dd);
$totaltests=$dd2['numsamples'];		
return $totaltests;
}
function gettotalviralloadrejectedbyfacility($period,$facility,$startdate,$enddate,$monthly,$monthyear,$startmonth,$endmonth,$quarteryear,$bistartmonth,$biendmonth,$biannualyear,$yearly)
{

If ($period == 1)//weekly/date range
{ 
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result !='' AND viralsamples.datereceived BETWEEN '$startdate'  AND '$enddate'   and viralsamples.receivedstatus=2 AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 2)//monthly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result !='' AND YEAR(viralsamples.datereceived)='$monthyear' and MONTH(viralsamples.datereceived)='$monthly' and viralsamples.receivedstatus=2 AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 3)//quarterly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result !='' AND YEAR(viralsamples.datereceived)='$quarteryear' and MONTH(viralsamples.datereceived) BETWEEN  '$startmonth'  and '$endmonth' and viralsamples.receivedstatus=2 AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 4)//bi-annaul
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result !='' AND YEAR(viralsamples.datereceived)='$biannualyear' and MONTH(viralsamples.datereceived) BETWEEN  '$bistartmonth'  and '$biendmonth' and viralsamples.receivedstatus=2 AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 5)//yearly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result !='' AND YEAR(viralsamples.datereceived)='$yearly' and viralsamples.receivedstatus=2  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
$dd2=mysql_fetch_array($dd);
$totaltests=$dd2['numsamples'];		
return $totaltests;
}
function gettotalviralloadtestssuppressedbyfacility($period,$facility,$startdate,$enddate,$monthly,$monthyear,$startmonth,$endmonth,$quarteryear,$bistartmonth,$biendmonth,$biannualyear,$yearly)
{

If ($period == 1)//weekly/date range
{ 
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result !='' And viralsamples.rcategory BETWEEN 1 AND 2  AND viralsamples.datetested BETWEEN '$startdate'  AND '$enddate'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 2)//monthly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result !='' And viralsamples.rcategory BETWEEN 1 AND 2 AND YEAR(viralsamples.datetested)='$monthyear' and MONTH(viralsamples.datetested)='$monthly'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 3)//quarterly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result !='' And viralsamples.rcategory BETWEEN 1 AND 2 AND YEAR(viralsamples.datetested)='$quarteryear' and MONTH(viralsamples.datetested) BETWEEN  '$startmonth'  and '$endmonth' AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 4)//bi-annaul
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result !='' And viralsamples.rcategory BETWEEN 1 AND 2 AND YEAR(viralsamples.datetested)='$biannualyear' and MONTH(viralsamples.datetested) BETWEEN  '$bistartmonth'  and '$biendmonth' AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 5)//yearly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result !='' And viralsamples.rcategory BETWEEN 1 AND 2  AND YEAR(viralsamples.datetested)='$yearly'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
$dd2=mysql_fetch_array($dd);
$totaltests=$dd2['numsamples'];		
return $totaltests;
}
function gettotalviralloadtestssuppressedbyfacilitybyage($age,$period,$facility,$startdate,$enddate,$monthly,$monthyear,$startmonth,$endmonth,$quarteryear,$bistartmonth,$biendmonth,$biannualyear,$yearly)
{
if ($age ==1 )//children
{
$d ='AND  viralpatients.age BETWEEN 0.01 AND 15 AND';
}
elseif ($age ==2) //adults
{
$d='AND viralpatients.age > 15 AND';

}
else //not specified
{
$d='AND viralpatients.age =0 AND';
}

If ($period == 1)//weekly/date range
{ 
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples,viralpatients WHERE viralsamples.patientid=viralpatients.AutoID  $d viralsamples.facility ='$facility' AND viralsamples.result !='' And viralsamples.rcategory BETWEEN 1 AND 2  AND viralsamples.datetested BETWEEN '$startdate'  AND '$enddate'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 2)//monthly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples,viralpatients WHERE viralsamples.patientid=viralpatients.AutoID  $d viralsamples.facility ='$facility' AND viralsamples.result !='' And viralsamples.rcategory BETWEEN 1 AND 2 AND YEAR(viralsamples.datetested)='$monthyear' and MONTH(viralsamples.datetested)='$monthly'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 3)//quarterly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples,viralpatients WHERE viralsamples.patientid=viralpatients.AutoID $d  viralsamples.facility ='$facility' AND viralsamples.result !='' And viralsamples.rcategory BETWEEN 1 AND 2 AND YEAR(viralsamples.datetested)='$quarteryear' and MONTH(viralsamples.datetested) BETWEEN  '$startmonth'  and '$endmonth' AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 4)//bi-annaul
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples,viralpatients WHERE viralsamples.patientid=viralpatients.AutoID $d  viralsamples.facility ='$facility' AND viralsamples.result !='' And viralsamples.rcategory BETWEEN 1 AND 2 AND YEAR(viralsamples.datetested)='$biannualyear' and MONTH(viralsamples.datetested) BETWEEN  '$bistartmonth'  and '$biendmonth' AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 5)//yearly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples,viralpatients WHERE viralsamples.patientid=viralpatients.AutoID $d  viralsamples.facility ='$facility' AND viralsamples.result !='' And viralsamples.rcategory BETWEEN 1 AND 2  AND YEAR(viralsamples.datetested)='$yearly'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
$dd2=mysql_fetch_array($dd);
$totaltests=$dd2['numsamples'];		
return $totaltests;
}

function gettotalviralloadfailuresbyfacility($period,$facility,$startdate,$enddate,$monthly,$monthyear,$startmonth,$endmonth,$quarteryear,$bistartmonth,$biendmonth,$biannualyear,$yearly)
{

If ($period == 1)//weekly/date range
{ 
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result  > 1000 AND  ( viralsamples.receivedstatus=1  OR viralsamples.reason_for_repeat ='Repeat For Rejection'  OR viralsamples.reason_for_repeat ='Repeat For Failed Sample')  AND viralsamples.datetested BETWEEN '$startdate'  AND '$enddate'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 2)//monthly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result  > 1000 AND  ( viralsamples.receivedstatus=1  OR viralsamples.reason_for_repeat ='Repeat For Rejection'  OR viralsamples.reason_for_repeat ='Repeat For Failed Sample')  AND YEAR(viralsamples.datetested)='$monthyear' and MONTH(viralsamples.datetested)='$monthly'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 3)//quarterly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result  > 1000 AND  ( viralsamples.receivedstatus=1  OR viralsamples.reason_for_repeat ='Repeat For Rejection'  OR viralsamples.reason_for_repeat ='Repeat For Failed Sample')  AND YEAR(viralsamples.datetested)='$quarteryear' and MONTH(viralsamples.datetested) BETWEEN  '$startmonth'  and '$endmonth' AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 4)//bi-annaul
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result  > 1000 AND  ( viralsamples.receivedstatus=1  OR viralsamples.reason_for_repeat ='Repeat For Rejection'  OR viralsamples.reason_for_repeat ='Repeat For Failed Sample')  AND YEAR(viralsamples.datetested)='$biannualyear' and MONTH(viralsamples.datetested) BETWEEN  '$bistartmonth'  and '$biendmonth' AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 5)//yearly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result  > 1000 AND  ( viralsamples.receivedstatus=1  OR viralsamples.reason_for_repeat ='Repeat For Rejection'  OR viralsamples.reason_for_repeat ='Repeat For Failed Sample')  AND YEAR(viralsamples.datetested)='$yearly'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
$dd2=mysql_fetch_array($dd);
$totalfailures=$dd2['numsamples'];		
return $totalfailures;
}

function gettotalviralloadsuppressedbyfacility($period,$facility,$startdate,$enddate,$monthly,$monthyear,$startmonth,$endmonth,$quarteryear,$bistartmonth,$biendmonth,$biannualyear,$yearly)
{

If ($period == 1)//weekly/date range
{ 
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' and viralsamples.result < 1000 and viralsamples.result !='Collect New Sample' AND viralsamples.result !='Failed' AND viralsamples.result !='Invalid' AND viralsamples.result !='' AND  ( viralsamples.receivedstatus=1  OR viralsamples.reason_for_repeat ='Repeat For Rejection'  OR viralsamples.reason_for_repeat ='Repeat For Failed Sample')  AND viralsamples.datetested BETWEEN '$startdate'  AND '$enddate'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 2)//monthly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' and viralsamples.result < 1000 and viralsamples.result !='Collect New Sample' AND viralsamples.result !='Failed' AND viralsamples.result !='Invalid' AND viralsamples.result !='' AND  ( viralsamples.receivedstatus=1  OR viralsamples.reason_for_repeat ='Repeat For Rejection'  OR viralsamples.reason_for_repeat ='Repeat For Failed Sample')  AND YEAR(viralsamples.datetested)='$monthyear' and MONTH(viralsamples.datetested)='$monthly'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 3)//quarterly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' and viralsamples.result < 1000 and viralsamples.result !='Collect New Sample' AND viralsamples.result !='Failed' AND viralsamples.result !='Invalid' AND viralsamples.result !=''AND  ( viralsamples.receivedstatus=1  OR viralsamples.reason_for_repeat ='Repeat For Rejection'  OR viralsamples.reason_for_repeat ='Repeat For Failed Sample')  AND YEAR(viralsamples.datetested)='$quarteryear' and MONTH(viralsamples.datetested) BETWEEN  '$startmonth'  and '$endmonth' AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 4)//bi-annaul
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' and viralsamples.result < 1000 and viralsamples.result !='Collect New Sample' AND viralsamples.result !='Failed' AND viralsamples.result !='Invalid' AND viralsamples.result !='' AND  ( viralsamples.receivedstatus=1  OR viralsamples.reason_for_repeat ='Repeat For Rejection'  OR viralsamples.reason_for_repeat ='Repeat For Failed Sample')  AND YEAR(viralsamples.datetested)='$biannualyear' and MONTH(viralsamples.datetested) BETWEEN  '$bistartmonth'  and '$biendmonth' AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 5)//yearly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' and viralsamples.result < 1000 and viralsamples.result !='Collect New Sample' AND viralsamples.result !='Failed' AND viralsamples.result !='Invalid' AND viralsamples.result !='' AND  ( viralsamples.receivedstatus=1  OR viralsamples.reason_for_repeat ='Repeat For Rejection'  OR viralsamples.reason_for_repeat ='Repeat For Failed Sample')  AND YEAR(viralsamples.datetested)='$yearly'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
$dd2=mysql_fetch_array($dd);
$totalfailures=$dd2['numsamples'];		
return $totalfailures;
}

function gettotalviralloadconfirmedfailuresbyfacility($period,$facility,$startdate,$enddate,$monthly,$monthyear,$startmonth,$endmonth,$quarteryear,$bistartmonth,$biendmonth,$biannualyear,$yearly)
{

If ($period == 1)//weekly/date range
{ 
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result  > 1000 AND viralsamples.receivedstatus =3 AND viralsamples.reason_for_repeat !='Repeat For Rejection' AND viralsamples.reason_for_repeat !='Repeat For Failed Sample' and viralsamples.reason_for_repeat !='' AND viralsamples.datetested BETWEEN '$startdate'  AND '$enddate'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 2)//monthly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result  > 1000 AND viralsamples.receivedstatus =3 AND viralsamples.reason_for_repeat !='Repeat For Rejection' AND viralsamples.reason_for_repeat !='Repeat For Failed Sample' and viralsamples.reason_for_repeat !=''  AND YEAR(viralsamples.datetested)='$monthyear' and MONTH(viralsamples.datetested)='$monthly'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 3)//quarterly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result  > 1000 AND viralsamples.receivedstatus =3 AND viralsamples.reason_for_repeat !='Repeat For Rejection' AND viralsamples.reason_for_repeat !='Repeat For Failed Sample' and viralsamples.reason_for_repeat !=''  AND YEAR(viralsamples.datetested)='$quarteryear' and MONTH(viralsamples.datetested) BETWEEN  '$startmonth'  and '$endmonth' AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 4)//bi-annaul
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.receivedstatus =3 AND viralsamples.reason_for_repeat !='Repeat For Rejection' AND viralsamples.reason_for_repeat !='Repeat For Failed Sample' and viralsamples.reason_for_repeat !=''  AND YEAR(viralsamples.datetested)='$biannualyear' and MONTH(viralsamples.datetested) BETWEEN  '$bistartmonth'  and '$biendmonth' AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 5)//yearly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.result  > 1000 AND viralsamples.receivedstatus =3 AND viralsamples.reason_for_repeat !='Repeat For Rejection' AND viralsamples.reason_for_repeat !='Repeat For Failed Sample' and viralsamples.reason_for_repeat !='' AND YEAR(viralsamples.datetested)='$yearly'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
$dd2=mysql_fetch_array($dd);
$totalfailures=$dd2['numsamples'];		
return $totalfailures;
}
function gettotalviralloadrejectedsamplesbyfacility($period,$facility,$startdate,$enddate,$monthly,$monthyear,$startmonth,$endmonth,$quarteryear,$bistartmonth,$biendmonth,$biannualyear,$yearly)
{

If ($period == 1)//weekly/date range
{ 
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.receivedstatus=2 AND viralsamples.datereceived BETWEEN '$startdate'  AND '$enddate'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 2)//monthly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.receivedstatus=2 AND YEAR(viralsamples.datereceived)='$monthyear' and MONTH(viralsamples.datereceived)='$monthly'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 3)//quarterly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.receivedstatus=2 AND YEAR(viralsamples.datereceived)='$quarteryear' and MONTH(viralsamples.datereceived) BETWEEN  '$startmonth'  and '$endmonth' AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 4)//bi-annaul
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.receivedstatus=2 AND YEAR(viralsamples.datereceived)='$biannualyear' and MONTH(viralsamples.datereceived) BETWEEN  '$bistartmonth'  and '$biendmonth' AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 5)//yearly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples WHERE   viralsamples.facility ='$facility' AND viralsamples.receivedstatus=2 AND YEAR(viralsamples.datereceived)='$yearly'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
$dd2=mysql_fetch_array($dd);
$totalrejected=$dd2['numsamples'];		
return $totalrejected;
}
function gettotalviralloadtestsbyfacilitybyage($age,$period,$facility,$startdate,$enddate,$monthly,$monthyear,$startmonth,$endmonth,$quarteryear,$bistartmonth,$biendmonth,$biannualyear,$yearly)
{
if ($age ==1 )//children
{
$d ='AND  viralpatients.age BETWEEN 0.01 AND 15 AND';
}
elseif ($age ==2) //adults
{
$d='AND viralpatients.age > 15 AND';

}
else //not specified
{
$d='AND viralpatients.age =0 AND';
}

If ($period == 1)//weekly/date range
{ 
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples,viralpatients WHERE  viralsamples.patientid=viralpatients.AutoID $d  viralsamples.facility ='$facility' AND viralsamples.result !='' AND viralsamples.datetested BETWEEN '$startdate'  AND '$enddate'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 2)//monthly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples,viralpatients WHERE  viralsamples.patientid=viralpatients.AutoID $d  viralsamples.facility ='$facility' AND viralsamples.result !='' AND YEAR(viralsamples.datetested)='$monthyear' and MONTH(viralsamples.datetested)='$monthly'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 3)//quarterly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples,viralpatients WHERE  viralsamples.patientid=viralpatients.AutoID $d viralsamples.facility ='$facility' AND viralsamples.result !='' AND YEAR(viralsamples.datetested)='$quarteryear' and MONTH(viralsamples.datetested) BETWEEN  '$startmonth'  and '$endmonth' AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 4)//bi-annaul
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples,viralpatients WHERE   viralsamples.patientid=viralpatients.AutoID $d viralsamples.facility ='$facility' AND viralsamples.result !='' AND YEAR(viralsamples.datetested)='$biannualyear' and MONTH(viralsamples.datetested) BETWEEN  '$bistartmonth'  and '$biendmonth' AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
elseif ($period == 5)//yearly
{
$dd=mysql_query("SELECT COUNT(viralsamples.ID) as numsamples FROM viralsamples,viralpatients WHERE viralsamples.patientid=viralpatients.AutoID  $d  viralsamples.facility ='$facility' AND viralsamples.result !='' AND YEAR(viralsamples.datetested)='$yearly'  AND viralsamples.repeatt=0  AND viralsamples.Flag=1 ") or die(mysql_error());
}
$dd2=mysql_fetch_array($dd);
$totaltests=$dd2['numsamples'];		
return $totaltests;
}
?>