<?php
error_reporting(0);
$dbh1 = mysql_connect("10.230.50.11:3307", "root", "FnP5FjbnMrzXCm."); 
mysql_select_db('vl_kemri2', $dbh1);
echo 'we here';
	exit();       
        $order = json_decode(file_get_contents('php://input'));
        //Get the values you need to insert into the database
        $smsphoneno = $order->smsphoneno;
		$smsphoneno=mysql_real_escape_string($smsphoneno);
		$smsmessage = $order->smsmessage;
        $smsmessage=mysql_real_escape_string($smsmessage);
		//$datereceived = date('Y-m-d h:i:s a', time());
		date_default_timezone_set('Africa/Nairobi');
		$datereceived = date('Y-m-d H:i:s');
		
//$smsphoneno='254725227833';	
//$smsmessage='R15204-639930159-4';
$querytype=substr($smsmessage,0,1);
$mflcode=substr($smsmessage,1,5);
$querytypeplusmfl=substr($smsmessage,0,6);
$actual_sampleID = substr($smsmessage, ($pos = strpos($smsmessage, $querytypeplusmfl)) !== false ? $pos + 7 : 0);

//echo 'Message'.$smsmessage. '<br/>'.'Query Type:'.$querytype. '<br/>'.'MFL:'.$mflcode. '<br/>'.'Query+MFL:'.$querytypeplusmfl. '<br/>'.'ccc:'.$actual_sampleID;	
		
		
		if  ( $smsphoneno !="" && $smsmessage  !="")
		{
	
	
					//loop thru extracting
$sql=mysql_query("select s.ID,s.batchno,s.patient,p.age,p.gender,s.facility,f.name,f.facilitycode,s.datecollected,s.datereceived,s.receivedstatus,s.rejectedreason,s.datetested,s.result,s.labtestedin from viralsamples s ,view_facilitys f ,viralpatients p  where  s.facility=f.ID  and f.facilitycode='$mflcode'  and  s.patientid=p.AutoID AND s.patient like '$actual_sampleID%' AND s.repeatt=0") or die (mysql_error());
if (mysql_num_rows($sql) > 0)  //VL Results
{


while(list($ID,$batchno,$patient,$age,$gender,$facility,$facilityname,$facilitycode,$datecollected,$datereceived,$receivedstatus,$rejectedreason,$datetested,$result,$labtestedin) = 	mysql_fetch_array($sql))
				{  
			echo $patient.$datecollected .'<br/>';
					if (($datecollected !="0000-00-00") &&  ($datecollected !="")&&  ($datecollected !="1970-01-01"))
					{
						$datecollected=date("d-M-Y",strtotime($datecollected));	
					}
					else
					{
						$datecollected="";
					}
					if (($datetested !="0000-00-00") &&  ($datetested !="")&&  ($datetested !="1970-01-01") &&  ($datetested !="0"))
					{
						$datetested=date("d-M-Y",strtotime($datetested));	
					}
					else
					{
						$datetested="";
					}
					$labtested=GetLab($labtestedin);
					
	$sampletitle="CCC #: ";	
	$batchnum="Batch #: ";
	$fdetails="Facility: ";
	$datec="Date Drawn: ";
	$datet="Date Tested: ";
	$sresult="VL Result: ";
	$labt="Lab Tested In: ";
	$approv="Approved by : Supervisor";
	$mmflcode="[".$facilitycode."] ";
	$inprocessmsg="Sample Still In process at the ";
	$inprocessmsg2=" The Result will be automatically sent to your number as soon as it is Available.";

	$rejmsg=" VL Rejected Sample ";
	$rejmsg2=" - Collect New Sample.";
	//."\n".
	$routcome=$result;
	
	if ($receivedstatus !=2 )
	{ 
	 if ($result=='0' OR $result =='' )
	 {
		  
	 $sstatus=$fdetails.$facilityname.$mmflcode."\n".$sampletitle .$patient ."\n".$batchnum.$batchno."\n".$datec.$datecollected ."\n".$inprocessmsg."\n".$labtested."\n".$inprocessmsg2;
  	  $msgstatus=2;
	 }
	 else
	 {
		
	 $sstatus=$fdetails.$facilityname.$mmflcode."\n".$sampletitle .$patient ."\n".$batchnum.$batchno."\n".$datec.$datecollected ."\n".$datet.$datetested ."\n".$sresult.$routcome."\n".$approv."\n".$labtested;
      $msgstatus=1;
	 }	
	}
	else
	{
	$vlrejectedreason=GetVLRejectedReason($rejectedreason);
	$sstatus=$fdetails.$facilityname.$mmflcode."\n".$sampletitle .$patient ."\n".$batchnum.$batchno."\n".$datec.$datecollected ."\n".$rejmsg.$vlrejectedreason.$rejmsg2."\n".$approv."\n".$labtested;
	 $msgstatus=1;
	}
		
//echo 'rr'.$routcome;	
$message=$sstatus;
//echo 	$message .'<br/>'.'<br/>';	
			
$username="tngugi@clintonhealthaccess.org";
$password="9LeJ?K?_Z5=7_y%eJ8nB_pD3&A=gUWfLAG2C";
$num=$smsphoneno;
$msg=$message;
$senderid="20027";
$message= array("sender"=>$senderid,"recipient"=>$num ,"message"=>$msg);
$URL="http://104.155.214.144/fastSMSstage/public/api/v1/messages";
$sms = json_encode($message);
$httpRequest = curl_init($URL);
curl_setopt($httpRequest, CURLOPT_NOBODY, true);
curl_setopt($httpRequest, CURLOPT_POST, true);
curl_setopt($httpRequest, CURLOPT_POSTFIELDS, $sms);
curl_setopt($httpRequest, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
curl_setopt($httpRequest, CURLOPT_RETURNTRANSFER,1);
curl_setopt($httpRequest, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($sms)));
curl_setopt($httpRequest, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($httpRequest, CURLOPT_USERPWD, "$username:$password");
$results=curl_exec ($httpRequest);
$status_code = curl_getinfo($httpRequest, CURLINFO_HTTP_CODE); //get status code
curl_close ($httpRequest);
$response = json_decode($results);
echo $status_code;
//echo $response->message;			



			
			
				
				
		}//end while


if ($status_code =='201')
{
	ECHO 'SUCCES';
date_default_timezone_set('Africa/Nairobi');
$dateresponded = date('Y-m-d H:i:s');
//$d=mysql_query("update shortcodequeries set status='$msgstatus' , dateresponded='$dateresponded' where ID='$qid'");

$sql=mysql_query("INSERT INTO shortcodequeries (phoneno,message,datereceived,mflcode,samplecode,status,dateresponded) VALUES ('$smsphoneno','$smsmessage','$datereceived','$mflcode','$actual_sampleID','$msgstatus','$dateresponded')") or die(mysql_error());


}		
else
{
$sql=mysql_query("INSERT INTO shortcodequeries (phoneno,message,datereceived,mflcode,samplecode) VALUES ('$smsphoneno','$smsmessage','$datereceived','$mflcode','$actual_sampleID')") or die(mysql_error());
	
}



	
}//end if vl num rows
else  // EID Results
{
$sql2=mysql_query("select s.ID,s.batchno,s.patient,p.age,p.gender,s.facility,f.name,f.facilitycode,s.datecollected,s.datereceived,s.receivedstatus,s.rejectedreason,s.datetested,s.result,s.labtestedin from samples s ,view_facilitys f ,patients p  where  s.facility=f.ID  and f.facilitycode='$mflcode'  and  s.patientautoid=p.AutoID AND s.patient like '$actual_sampleID%' AND s.repeatt=0") or die (mysql_error());
	if (mysql_num_rows($sql2) > 0)  //eid Results
	{
	
	
	
	while(list($ID,$batchno,$patient,$age,$gender,$facility,$facilityname,$facilitycode,$datecollected,$datereceived,$receivedstatus,$rejectedreason,$datetested,$result,$labtestedin) = 	mysql_fetch_array($sql2))
				{  
					if (($datecollected !="0000-00-00") &&  ($datecollected !="")&&  ($datecollected !="1970-01-01"))
					{
						$datecollected=date("d-M-Y",strtotime($datecollected));	
					}
					else
					{
						$datecollected="";
					}
					if (($datetested !="0000-00-00") &&  ($datetested !="")&&  ($datetested !="1970-01-01") &&  ($datetested !="0"))
					{
						$datetested=date("d-M-Y",strtotime($datetested));	
					}
					else
					{
						$datetested="";
					}
					$labtested=GetLab($labtestedin);
					
	$sampletitle="Patient ID: ";	
	$batchnum="Batch #: ";
	$fdetails="Facility: ";
	$datec="Date Drawn: ";
	$datet="Date Tested: ";
	$sresult="EID Result: ";
	$labt="Lab Tested In: ";
	$approv="Approved by : Supervisor.";
	$mmflcode="[".$facilitycode."] ";
	$inprocessmsg=" Sample Still In process at the ";
	$inprocessmsg2=" The Result will be automatically sent to your number as soon as it is Available.";
	$rejmsg=" EID Rejected Sample ";
	$rejmsg2=" - Collect New Sample.";
	//."\n".
	$eidresult=$result;
	if($receivedstatus !=2) //accepted & repeats
	{ 
	  
	 if ($result==0 OR $result =='')
	 {  
	 $sstatus=$fdetails.$facilityname.$mmflcode."\n".$sampletitle .$patient ."\n".$batchnum.$batchno."\n".$datec.$datecollected ."\n".$inprocessmsg."\n".$labtested."\n".$inprocessmsg2;
	 $msgstatus=2;
  	 }
	 else
	 { 
	 $routcome=GetResultDesc($eidresult);
	 $sstatus=$fdetails.$facilityname.$mmflcode."\n".$sampletitle .$patient ."\n".$batchnum.$batchno."\n".$datec.$datecollected ."\n".$datet.$datetested ."\n".$sresult.$routcome."\n".$approv."\n".$labtested;
      $msgstatus=1;
	 }		
	}
	else
	{
	$vlrejectedreason=GetEIDRejectedReason($rejectedreason);
	$sstatus=$fdetails.$facilityname.$mmflcode."\n".$sampletitle .$patient ."\n".$batchnum.$batchno."\n".$datec.$datecollected ."\n".$rejmsg.$vlrejectedreason.$rejmsg2."\n".$approv."\n".$labtested;
 	 $msgstatus=1;
	}
				
$message=$sstatus;
//echo 	$message .'<br/>'.'<br/>';	
			
$username="tngugi@clintonhealthaccess.org";
$password="9LeJ?K?_Z5=7_y%eJ8nB_pD3&A=gUWfLAG2C";
$num=$smsphoneno;
$msg=$message;
$senderid="20027";
$message= array("sender"=>$senderid,"recipient"=>$num ,"message"=>$msg);
$URL="http://104.155.214.144/fastSMSstage/public/api/v1/messages";
$sms = json_encode($message);
$httpRequest = curl_init($URL);
curl_setopt($httpRequest, CURLOPT_NOBODY, true);
curl_setopt($httpRequest, CURLOPT_POST, true);
curl_setopt($httpRequest, CURLOPT_POSTFIELDS, $sms);
curl_setopt($httpRequest, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
curl_setopt($httpRequest, CURLOPT_RETURNTRANSFER,1);
curl_setopt($httpRequest, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($sms)));
curl_setopt($httpRequest, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($httpRequest, CURLOPT_USERPWD, "$username:$password");
$results=curl_exec ($httpRequest);
$status_code = curl_getinfo($httpRequest, CURLINFO_HTTP_CODE); //get status code
curl_close ($httpRequest);
$response = json_decode($results);
echo $status_code;
//echo $response->message;			



				}//end while eid
	
	
	if ($status_code =='201')
{
	ECHO 'SUCCES';
date_default_timezone_set('Africa/Nairobi');
$dateresponded = date('Y-m-d H:i:s');
//$d=mysql_query("update shortcodequeries set status='$msgstatus' , dateresponded='$dateresponded' where ID='$qid'");

$sql=mysql_query("INSERT INTO shortcodequeries (phoneno,message,datereceived,mflcode,samplecode,status,dateresponded) VALUES ('$smsphoneno','$smsmessage','$datereceived','$mflcode','$actual_sampleID','$msgstatus','$dateresponded')") or die(mysql_error());


}		
else
{
$sql=mysql_query("INSERT INTO shortcodequeries (phoneno,message,datereceived,mflcode,samplecode) VALUES ('$smsphoneno','$smsmessage','$datereceived','$mflcode','$actual_sampleID')") or die(mysql_error());
	
}
	
	
	
	}
	else //that identifier doesnt exist
	{
	$message='The Patient Idenfier Provided Does not Exist in the Lab. Kindly confirm you have the correct one as on the Sample Request Form. Thanks.';
	
$username="tngugi@clintonhealthaccess.org";
$password="9LeJ?K?_Z5=7_y%eJ8nB_pD3&A=gUWfLAG2C";
$num=$smsphoneno;
$msg=$message;
$senderid="20027";
$message= array("sender"=>$senderid,"recipient"=>$num ,"message"=>$msg);
$URL="http://104.155.214.144/fastSMSstage/public/api/v1/messages";
$sms = json_encode($message);
$httpRequest = curl_init($URL);
curl_setopt($httpRequest, CURLOPT_NOBODY, true);
curl_setopt($httpRequest, CURLOPT_POST, true);
curl_setopt($httpRequest, CURLOPT_POSTFIELDS, $sms);
curl_setopt($httpRequest, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
curl_setopt($httpRequest, CURLOPT_RETURNTRANSFER,1);
curl_setopt($httpRequest, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($sms)));
curl_setopt($httpRequest, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($httpRequest, CURLOPT_USERPWD, "$username:$password");
$results=curl_exec ($httpRequest);
$status_code = curl_getinfo($httpRequest, CURLINFO_HTTP_CODE); //get status code
curl_close ($httpRequest);
$response = json_decode($results);
echo $status_code;
//echo $response->message;			


if ($status_code =='201')
{
	ECHO 'SUCCES';
date_default_timezone_set('Africa/Nairobi');
$dateresponded = date('Y-m-d H:i:s');
//$d=mysql_query("update shortcodequeries set status=1 , dateresponded='$dateresponded' where ID='$qid'");
$sql=mysql_query("INSERT INTO shortcodequeries (phoneno,message,datereceived,mflcode,samplecode,status,dateresponded) VALUES ('$smsphoneno','$smsmessage','$datereceived','$mflcode','$actual_sampleID',1,'$dateresponded')") or die(mysql_error());

}
	
	}

}//end if num rows for VL
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

  if ($sql)
  {
	$st= " Test Message Sent to Site " ; 
    echo $st;
//echo $response->message;			

		
  echo json_encode($sql);
  
  }
  else//Else
  {
	  echo json_encode('an error occured');	  
  }
		}
else//Else
{
	echo json_encode('Error No Fields Passed');	 
}		
			
			
			
//get rejected reason
function GetEIDRejectedReason($ID)
{ 
$query = "SELECT Name  FROM rejectedreasons where ID='$ID'";
$result = mysql_query($query) or die(mysql_error());
$dd=mysql_fetch_array($result);
$rejreason=$dd['Name'];
return $rejreason;
}
function GetVLRejectedReason($ID)
{ 
$query = "SELECT Name  FROM viralrejectedreasons where ID='$ID'";
$result = mysql_query($query) or die(mysql_error());
$dd=mysql_fetch_array($result);
$rejreason=$dd['Name'];
return $rejreason;
}
function GetLab($lab)
{
$labquery=mysql_query("SELECT name FROM labs where ID='$lab' ")or die(mysql_error()); 
$dd=mysql_fetch_array($labquery);
$labname=$dd['name'];
return $labname;
}
//get sample result
function GetResultDesc($result)
{
	$result = "SELECT name FROM results WHERE ID = '$result'";
	$getresult = mysql_query($result) or die(mysql_error());
	$resulttype = mysql_fetch_array($getresult);
	$showresult = $resulttype['name'];
	
return $showresult;
}			
			
			?>
