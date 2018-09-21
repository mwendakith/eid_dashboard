<?php
error_reporting(0);
$format = 'json';
$datesent = $_GET['datesent'];
$startDate=$datesent;
$endDate=$datesent;
//$startDate = $_GET['startdate'];
//$endDate = $_GET['enddate'];
$apikey=$_GET['apikey'];
$test=$_GET['testtype'];
$currentmonth=date('m');
$location=$_GET['location'];

/*
if ($test !=1 || $test !=2)
{
$test=1;	
}

*/
if ($apikey !='uTy57x5e3aw')
{
echo '<h1>401 Unauthorized</h1>';
 //header("HTTP/1.1 401 Unauthorized");

}
else
{
	if ($test==1)  //eid logs
	{
$con = mysql_connect("10.230.50.11:3307", "root", "FnP5FjbnMrzXCm."); 
mysql_select_db('eid_kemri2', $con);
$table='eidsms_log';
$table2='samples';

if ($startDate !='' && $endDate !='') //date range provided
	{
$vvresult = mysql_query("SELECT v.timesent  FROM $table v ,$table2 s  where  s.batchno=v.batchno and s.labtestedin=v.lab  and v.timesent between '$startDate' and '$endDate' ",$con) or die('MySQL Error.');	
	}
	else  //no date range //generate for current month
	{
$vvresult = mysql_query("SELECT v.timesent  FROM $table v ,$table2 s  where s.batchno=v.batchno and s.labtestedin=v.lab  and YEAR(v.timesent)= '$currentyear' and MONTH(v.timesent)='$currentmonth'",$con) or die(mysql_error());	
	}
$numrows=mysql_num_rows($vvresult);
$rowsperpage = 50;
$pageNum = 1;
// if $_GET['page'] defined, use it as page number
if(isset($_GET['page']))
{
$pageNum = $_GET['page'];
}
// counting the offset
$offset = ($pageNum - 1) * $rowsperpage;
//echo $currentpage  .$offset.$rowsperpage;

	if ($startDate !='' && $endDate !='') //date range provided
	{
$vresult = mysql_query("SELECT v.timesent,v.batchno,v.facility,v.phoneno,v.lab,s.patient,s.datecollected,s.result  FROM $table v ,$table2 s where s.batchno=v.batchno and s.labtestedin=v.lab  and v.timesent between '$startDate' and '$endDate' LIMIT $offset, $rowsperpage",$con) or die('MySQL Error.');	
	}
	else  //no date range //generate for current month
	{
$vresult = mysql_query("SELECT v.timesent,v.batchno,v.facility,v.phoneno,v.lab,s.patient,s.datecollected,s.result  FROM $table v ,$table2 s  where s.batchno=v.batchno and s.labtestedin=v.lab  and YEAR(v.timesent)= '$currentyear' and MONTH(v.timesent)='$currentmonth' LIMIT $offset, $rowsperpage",$con) or die(mysql_error());	
	}




		
	}
	elseif ($test==2) //vl logs
	{
$con = mysql_connect("10.230.50.11:3307", "root", "FnP5FjbnMrzXCm."); 
mysql_select_db('vl_kemri2', $con);	
$table='vlsms_log';
$table2='viralsamples';


if ($startDate !='' && $endDate !='') //date range provided
	{
$vvresult = mysql_query("SELECT v.timesent  FROM $table v ,$table2 s  where  s.batchno=v.batchno and s.labtestedin=v.lab  and v.timesent between '$startDate' and '$endDate' ",$con) or die('MySQL Error.');	
	}
	else  //no date range //generate for current month
	{
$vvresult = mysql_query("SELECT v.timesent  FROM $table v ,$table2 s  where s.batchno=v.batchno and s.labtestedin=v.lab  and YEAR(v.timesent)= '$currentyear' and MONTH(v.timesent)='$currentmonth'",$con) or die(mysql_error());	
	}
$numrows=mysql_num_rows($vvresult);
$rowsperpage = 50;
$pageNum = 1;
// if $_GET['page'] defined, use it as page number
if(isset($_GET['page']))
{
$pageNum = $_GET['page'];
}
// counting the offset
$offset = ($pageNum - 1) * $rowsperpage;
//echo $currentpage  .$offset.$rowsperpage;

	if ($startDate !='' && $endDate !='') //date range provided
	{
$vresult = mysql_query("SELECT v.timesent,v.batchno,v.facility,v.phoneno,v.lab,s.patient,s.datecollected,s.result  FROM $table v ,$table2 s where s.batchno=v.batchno and s.labtestedin=v.lab  and v.timesent between '$startDate' and '$endDate' LIMIT $offset, $rowsperpage",$con) or die('MySQL Error.');	
	}
	else  //no date range //generate for current month
	{
$vresult = mysql_query("SELECT v.timesent,v.batchno,v.facility,v.phoneno,v.lab,s.patient,s.datecollected,s.result  FROM $table v ,$table2 s  where s.batchno=v.batchno and s.labtestedin=v.lab  and YEAR(v.timesent)= '$currentyear' and MONTH(v.timesent)='$currentmonth' LIMIT $offset, $rowsperpage",$con) or die(mysql_error());	
	}





	}


	



 
//Preapre our output
if($format == 'json') {

$json = array();
$mnumrows=mysql_num_rows($vresult);


		while ($maRow = mysql_fetch_assoc($vresult))
		{
$maArray[] = $maRow['timesent']  ;
$maArray0[] = $maRow['batchno']  ;
$maArray1[] = $maRow['facility']  ;
$maArray2[] = $maRow['phoneno']  ;
$maArray3[] = $maRow['lab']  ;
$maArray4[] = $maRow['patient']  ;
$maArray5[] = $maRow['datecollected']  ;
$maArray6[] = $maRow['result']  ;
	}
		for ($mrow = 0; $mrow < $mnumrows; $mrow++)
		{
$timesent=$maArray[$mrow];
$batchno=$maArray0[$mrow];
$fid=$maArray1[$mrow];
$phoneno=$maArray2[$mrow];
$lab=$maArray3[$mrow];
$patient= $maArray4[$mrow];
$datecollected=$maArray5[$mrow];
$result=$maArray6[$mrow];
$mflcode=GetFacilityMFLCode($fid);
	 $bus = array(
       		'mflcode' =>$mflcode,
		'phoneno' => $phoneno,
		'batchno' => $batchno,
		'patientid' => $patient,
		'datecollected' => $datecollected,
		'result' => $result,
		'timesent' => $timesent,
		'lab' => $lab,
		
		
    );
    array_push($json, $bus);
		}
		
//$jsonstring = json_encode($json);
$jsonstring = json_encode(array_map('utf8_encode', $json));

//echo json_encode($url, JSON_UNESCAPED_SLASHES), "\n";
//echo $jsonstring;
$output = json_encode(array('posts' => $json ), JSON_UNESCAPED_SLASHES);
 
} elseif($format == 'xml') {

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