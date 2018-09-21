<?php
error_reporting(0);

$data = trim(file_get_contents('php://input'),'<?xml version="1.0" encoding="UTF-8"?> ');
$order = json_decode($data);

//$order = json_decode(file_get_contents('php://input'));
//Get the values you need to insert into the database

$testtype = $order->testtype;
$labss = $order->testinglab;
$specimenlabelID = $order->specimenlabelID;
$specimenclientcode = $order->specimenclientcode;
$facilityname = $order->facilityname;
$MFLCode = $order->MFLCode;
$Sex = $order->Sex;
$Age = $order->Age;	
$datecollected = $order->datecollected;
$datereceived = $order->datereceived;
$logindate = $order->logindate;
$receivedstatus = $order->receivedstatus;
$rejectedreason = $order->rejectedreason;
$reasonforrepeat = $order->reasonforrepeat;	
$labcomment = $order->labcomment;
$datetested = $order->datetested;
$datedispatched = $order->datedispatched;
$results = $order->results;


if ($testtype == 2) //VL
{//echo    json_encode('vl').$testtype;
$vldb = mysql_connect("10.230.50.11:3307", "root", "FnP5FjbnMrzXCm."); 
mysql_select_db('vl_kemri2', $vldb);

//$vldb = mysql_connect("127.0.0.1", "root", "FnP5FjbnMrzXCm"); 
//mysql_select_db('vl_kemri2', $vldb);

$sampletype = $order->sampletype;
$currentregimen = $order->currentregimen;
$ARTInitiationdate = $order->ARTInitiationdate;		
$justification = $order->justification;





if   ( $specimenlabelID !='' &&  $specimenclientcode !='' && $MFLCode !='' )
		{
		//
		//$pquery = "INSERT INTO  test(name,descr) VALUES('$name','$desc')";
		//$import = mysql_query($pquery);	
  //get last patient id to save into the samples' table for reference
function GetLastPatientIDVL($lab,$vldb)
{
	$getpid = "SELECT viralpatients.AutoID
            FROM viralpatients	WHERE labtestedin='$lab'		
			ORDER by viralpatients.AutoID DESC LIMIT 0,1 ";
			$getp=mysql_query($getpid,$vldb);
			$prec=mysql_fetch_array($getp);
			$sid=$prec['AutoID'];
			return $sid;
}
function GetFacilityAutoIDfromMFLcode($mflcode)
{
$fquery=mysql_query("SELECT ID as autoid
            FROM facilitys
            WHERE  facilitycode='$mflcode'"); 
	    $numrows=mysql_num_rows($fquery);
	    
	    if  ( $numrows > 0)
	    {
	    	$sqs = mysql_fetch_array($fquery);  
			$facilityautoid=$sqs['autoid'];
	    }
	    else
	    {
	    $facilityautoid=0;
	    }

		return $facilityautoid;
}
function GetSampleTypeIDfromDesc($sampletypedesc,$vldb)
{
$fquery=mysql_query("SELECT ID as autoid
            FROM viralsampletype
            WHERE  alias='$sampletypedesc'",$vldb); 
			$sqs = mysql_fetch_array($fquery);  
			$stypeautoid=$sqs['autoid'];
		return $stypeautoid;
}
function GetSamplesPerBatchVL($batchno,$lab,$vldb)
{
	$samplequery = mysql_query("SELECT COUNT(ID) as num_samples FROM viralsamples WHERE batchno='$batchno' and labtestedin='$lab' AND Flag=1",$vldb) or die(mysql_error());
		
		
		$samplerow = mysql_fetch_array($samplequery);
		$num_samples = $samplerow['num_samples'];
	
	
return $num_samples ;
}
//determine if batch exists
function GetBatchNoifExistsVL($datereceived,$facility,$lab,$vldb)
{
$strQuery=mysql_query("SELECT batchno FROM viralsamples WHERE labtestedin='$lab' AND datereceived='$datereceived' AND fcode='$facility' order by batchno DESC limit 0,1 ",$vldb)or die(mysql_error());
$exists=mysql_num_rows($strQuery);
if ($exists > 0)
{
$resultarray=mysql_fetch_array($strQuery);
$batchno=$resultarray['batchno'];
$samplesinbatch=GetSamplesPerBatchVL($batchno,$lab,$vldb);
}
else
{
$batchno='';
$samplesinbatch=0;
}
return array($exists,$batchno, $samplesinbatch); 
}
//determine EXISITNG BATCH NO
function GetExistingBatchNoVL($datereceived,$facility,$lab,$vldb)
{

$strQuery=mysql_query("SELECT viralsamples.batchno FROM viralsamples WHERE viralsamples.datereceived='$datereceived'  AND viralsamples.fcode='$facility'",$vldb)or die(mysql_error());
$dd=mysql_fetch_array($strQuery);
$batch=$dd['batchno'];
return $batch;
}
//generate new  batch no
function GetNewBatchNoVL($lab,$vldb)
{

$RES = mysql_query("SELECT max( cast(batchno as unsigned) ) as 'Max' FROM viralsamples WHERE  viralsamples.labtestedin='$lab'",$vldb);

if(mysql_num_rows($RES) == 1)
{
$ROW = mysql_fetch_assoc($RES);
$BatchNo = $ROW['Max'] + 1; 
}
return $BatchNo;
}	
function CheckifLabelIDExistsVL($labelid,$lab,$vldb)
{
$strQuery=mysql_query("SELECT viralsamples.comments FROM viralsamples WHERE labtestedin='$lab' AND comments='$labelid' ",$vldb)or die(mysql_error());
$numrows=mysql_num_rows($strQuery);
return $numrows;
}

	                $labelid=$specimenlabelID;
			$labelexists=CheckifLabelIDExistsVL($labelid,$labss,$vldb);
				if ($labelexists > 0 )
				{
				//do nothing
				echo  'Label ID'.$labelid .'already exists in database';
				}
				else
				{
			      
			$prophylaxis=$currentregimen;
			if ($prophylaxis > 0)
			{
	 			$prophylaxis=$prophylaxis;
			}
			else
			{
				$prophylaxis=16;
			}
			$cccno=mysql_real_escape_string($specimenclientcode);
			$facilityname=mysql_real_escape_string($facilityname);
			$age=$Age;
			$sex=$Sex;
			$fcode=$MFLCode;
			//$sampletypedesc=mysql_real_escape_string($data[6]);
			$sampletype=$sampletype;
			
			if ($sampletype =='PLASMA' )
			{
			$sampletype=1;
			}
			else
			{
			$sampletype=$sampletype;
			}
			$fautoid=GetFacilityAutoIDfromMFLcode($fcode);
			$sdrec=$datereceived;
			$sdoc=$datecollected;
			$datetested=$datetested;
			$datedispatched=$datedispatched;
			$outcome=$results;
			$logindate=$logindate;
			$receivedstatus=$receivedstatus;
			$rejectedreason=$rejectedreason;
			$reasonforrepeat=$reasonforrepeat;
			$labcomment=$labcomment;
			$labss=$labss;
			$justification=$justification;
			if ($justification > 0)
			{
	 			$justification=$justification;
			}
			else
			{
				$justification=8;
			}
			$initiationdate=$ARTInitiationdate;
			if ($initiationdate != "")
			{
	 			$initiationdate=date("Y-m-d",strtotime($initiationdate));
			}
			else
			{
				$initiationdate="";
			}
			if ($sdrec != "")
			{
	 			$sdrec=date("Y-m-d",strtotime($sdrec));
			}
			else
			{
				$sdrec="";
			}
			if ($sdoc != "")
			{
	 			$sdoc=date("Y-m-d",strtotime($sdoc));
			}
			else
			{
				$sdoc="";
			}
			if ($datetested != "")
			{
	 			$datetested=date("Y-m-d",strtotime($datetested));
			}
			else
			{
				$datetested="";
			}
				if ($datedispatched != "")
			{
	 			$datedispatched=date("Y-m-d",strtotime($datedispatched));
			}
			else
			{
				$datedispatched="";
			}
			if ($age > 0)
			{
	 			$age=$age;
			}
			elseif ($age =='NULL')
			{
	 			$age=0;;
			}
			elseif ($age =='N/A')
			{
	 			$age=0;;
			}
			elseif ($age =='NA')
			{
	 			$age=0;;
			}
			else
			{
				$age=0;;
				
			}
			if ($datedispatchedd == "")
{
	$datedispatchedd='0000-00-00';
}
if ($dateentered == "")
{
	$dateentered='0000-00-00';
}
if ($rejectedreason == "")
{
$rejectedreason=0;
}
if ($parentid =="")
{
$parentid=0;
}
if ($sspot !='')
{
$sspot=$sspot;
}
else
{
$sspot=0;
}
if ($rejectedreason == "")
{
$rejectedreason=0;
}
			list($exists,$sbatchno,$samplesinbatch)=GetBatchNoifExistsVL($sdrec,$fcode,$labss,$vldb);
				if ($exists > 0) //batchno exists
				{
					if ( $samplesinbatch ==10) //generate new batchno
					{
					$BatchNo=GetNewBatchNoVL($labss,$vldb); //capture new batchno	
					}
					else //use the same batch no
					{
					$BatchNo=$sbatchno;
					}
				}
				else//doesnt exists so generate a new one
				{
					$BatchNo=GetNewBatchNoVL($labss,$vldb); //capture new batchno		
				}
			
			if ( (stripos($labelid,'affected') !== false) && $cccno =="" && $facilityname =="")
			{
			//do nothing
			}
			elseif ($cccno =="" && $facilityname =="")
			{
			//do nothing
			}
			else
			{
			//echo $labelid. '<br/>';
		$query = "INSERT INTO viralpatients(ID,age,gender,prophylaxis,labtestedin) VALUES ('$cccno','$age','$sex','$prophylaxis','$labss')";
			$import = mysql_query($query,$vldb) or die(mysql_error());	
			
			if ($import) //mother successfully saved
			{
				//get last mother ID
				$lastpatientid = GetLastPatientIDVL($labss,$vldb);
$pquery ="
INSERT INTO viralsamples
(batchno, patient,DispatchComments ,facility, receivedstatus,rejectedreason,reason_for_repeat, datecollected, datereceived, comments,parentid,datetested,result,datemodified,datedispatched,fcode,Inworksheet,BatchComplete,Flag,repeatt,sampletype,justification,patientid,prophylaxis,initiationdate,inputcomplete,approved,run,labtestedin,dateentered)
VALUES
('$BatchNo', '$cccno','$facilityname', '$fautoid','$receivedstatus','$rejectedreason','$reasonforrepeat', '$sdoc', '$sdrec', '$labelid', 0, '$datetested', '$outcome', '$datetested', '$datedispatched', '$fcode', 1,1,1,0,'$sampletype','$justification','$lastpatientid','$prophylaxis','$initiationdate',1,1,1,'$labss','$logindate')";

				$pimport = mysql_query($pquery,$vldb) or die(mysql_error());
				
				if ($pimport) //patient successfully saved
				{ 
					$count=$count+1;
				} //end if samples done
				
			}//end if patient dones
			
			
			}//end if row not empty
			  if ($pimport){// If the sample was saved return the sample data
            echo json_encode($pimport);
          }else{//Else return an error message
            echo json_encode('an error occured, could not save');
          }	
				}//end if label id exists or not		
        
        
		  
		  }
		 else
		  
		 {
		 echo    json_encode('Error, ALL Viral Load Variables Must be Provided');
		 
	//	
		  }
		  
		  














		


}
elseif ($testtype == 1) //eid
{
$eiddb = mysql_connect("10.230.50.11:3307", "root", "FnP5FjbnMrzXCm."); 
mysql_select_db('eid_kemri2', $eiddb);

//$eiddb = mysql_connect("127.0.0.1", "root", "FnP5FjbnMrzXCm"); 
//mysql_select_db('eid_kemri2', $eiddb);

$spots = $order->spots;
$iprophylaxis = $order->infantprophylaxis;
$HAARTInitiationdate = $order->HAARTInitiationdate;		
$mprophylaxis = $order->motherprophylaxis;
$entrypoint = $order->entrypoint;
$infantfeeding= $order->infantfeeding;
$pcrtype = $order->pcrtype;






if   ( $specimenlabelID !='' &&  $specimenclientcode !='' && $MFLCode !='' )
		{

			function GetLastMotherID($labss,$eiddb)
{
	$getmotherid = "SELECT ID
            FROM mothers WHERE labtestedin='$labss'
			ORDER by ID DESC LIMIT 1 ";
			$getmum=mysql_query($getmotherid,$eiddb);
			$mumrec=mysql_fetch_array($getmum);
			$mid=$mumrec['ID'];
			return $mid;
}	  
		  
		  //get last patient id to save into the samples' table for reference
function GetLastPatientID($lab,$eiddb)
{
	$getpid = "SELECT patients.AutoID
            FROM patients	WHERE labtestedin='$lab'		
			ORDER by patients.AutoID DESC LIMIT 0,1 ";
			$getp=mysql_query($getpid,$eiddb);
			$prec=mysql_fetch_array($getp);
			$sid=$prec['AutoID'];
			return $sid;
}
function GetFacilityAutoIDfromMFLcode($mflcode)
{
$fquery=mysql_query("SELECT ID as autoid
            FROM facilitys
            WHERE  facilitycode='$mflcode'"); 
	    $numrows=mysql_num_rows($fquery);
	    
	    if  ( $numrows > 0)
	    {
	    	$sqs = mysql_fetch_array($fquery);  
			$facilityautoid=$sqs['autoid'];
	    }
	    else
	    {
	    $facilityautoid=0;
	    }

		return $facilityautoid;
}

function GetSamplesPerBatch($batchno,$lab,$eiddb)
{
	$samplequery = mysql_query("SELECT COUNT(ID) as num_samples FROM samples WHERE batchno='$batchno' and labtestedin='$lab' AND Flag=1",$eiddb) or die(mysql_error());
		
		
		$samplerow = mysql_fetch_array($samplequery);
		$num_samples = $samplerow['num_samples'];
	
	
return $num_samples ;
}
//determine if batch exists
function GetBatchNoifExists($datereceived,$facility,$lab,$eiddb)
{
$strQuery=mysql_query("SELECT batchno FROM samples WHERE labtestedin='$lab' AND datereceived='$datereceived' AND fcode='$facility' order by batchno DESC limit 0,1 ",$eiddb)or die(mysql_error());
$exists=mysql_num_rows($strQuery);
if ($exists > 0)
{
$resultarray=mysql_fetch_array($strQuery);
$batchno=$resultarray['batchno'];
$samplesinbatch=GetSamplesPerBatch($batchno,$lab,$eiddb);
}
else
{
$batchno='';
$samplesinbatch=0;
}
return array($exists,$batchno, $samplesinbatch); 
}
//determine EXISITNG BATCH NO
function GetExistingBatchNo($datereceived,$facility,$lab,$eiddb)
{

$strQuery=mysql_query("SELECT samples.batchno FROM samples WHERE samples.datereceived='$datereceived'  AND samples.fcode='$facility'",$eiddb)or die(mysql_error());
$dd=mysql_fetch_array($strQuery);
$batch=$dd['batchno'];
return $batch;
}
//generate new  batch no
function GetNewBatchNo($lab,$eiddb)
{

$RES = mysql_query("SELECT max( cast(batchno as unsigned) ) as 'Max' FROM samples WHERE  samples.labtestedin='$lab'",$eiddb);

if(mysql_num_rows($RES) == 1)
{
$ROW = mysql_fetch_assoc($RES);
$BatchNo = $ROW['Max'] + 1; 
}
return $BatchNo;
}	
function CheckifLabelIDExists($labelid,$lab,$eiddb)
{
$strQuery=mysql_query("SELECT samples.comments FROM samples WHERE labtestedin='$lab' AND comments='$labelid' ",$eiddb)or die(mysql_error());
$numrows=mysql_num_rows($strQuery);
return $numrows;
}
		
			        $labelid=$specimenlabelID;
					//echo    json_encode('eid here ').$testtype.$labelid.'lab'.$labss.'exist?'.$labelexists;
			$labelexists=CheckifLabelIDExists($labelid,$labss,$eiddb);
		
				if ($labelexists > 0 )
				{
				//do nothing
				echo  'Label ID'.$labelid .'already exists in database';
				}
				else
				{
			      
			$prophylaxis=$currentregimen;
			if ($prophylaxis > 0)
			{
	 			$prophylaxis=$prophylaxis;
			}
			else
			{
				$prophylaxis=16;
			}
			$cccno=mysql_real_escape_string($specimenclientcode);
			$facilityname=mysql_real_escape_string($facilityname);
			$age=$Age;
			$sex=$Sex;
			$fcode=$MFLCode;
			//$sampletypedesc=mysql_real_escape_string($data[6]);
			$sampletype=$sampletype;
			$fautoid=GetFacilityAutoIDfromMFLcode($fcode);
			$sdrec=$datereceived;
			$sdoc=$datecollected;
			$datetested=$datetested;
			$entrypoint=$entrypoint;
			$infantfeeding=$infantfeeding;
			$datedispatched=$datedispatched;
			$outcome=$results;
			$spots=$spots;
			$logindate=$logindate;
			$receivedstatus=$receivedstatus;
			$rejectedreason=$rejectedreason;
			$reasonforrepeat=$reasonforrepeat;
			$labcomment=$labcomment;
			$labss=$labss;
			$iprophylaxis=$iprophylaxis;
			$HAARTInitiationdate=$HAARTInitiationdate;
			$mprophylaxis=$mprophylaxis;
			if ( $iprophylaxis > 0)
			{
			$iprophylaxis=$iprophylaxis;
			}
			else
			{
			$iprophylaxis=12;
			}
			if ( $mprophylaxis > 0)
			{
			$mprophylaxis=$mprophylaxis;
			}
			elseif ( $mproph ='AF2B')
			{
			$mprophylaxis=4;
			}
			else
			{
			$mprophylaxis=6;
			}
			if ( $entrypoint > 0)
			{
			$entrypoint=$entrypoint;
			}
			else
			{
			$entrypoint=6;
			}
			if ($HAARTInitiationdate != "")
			{
	 			$HAARTInitiationdate=date("Y-m-d",strtotime($HAARTInitiationdate));
			}
			else
			{
				$HAARTInitiationdate="";
			}
			if ($sdrec != "")
			{
	 			$sdrec=date("Y-m-d",strtotime($sdrec));
			}
			else
			{
				$sdrec="";
			}
			if ($sdoc != "")
			{
	 			$sdoc=date("Y-m-d",strtotime($sdoc));
			}
			else
			{
				$sdoc="";
			}
			if ($datetested != "")
			{
	 			$datetested=date("Y-m-d",strtotime($datetested));
			}
			else
			{
				$datetested="";
			}
				if ($datedispatched != "")
			{
	 			$datedispatched=date("Y-m-d",strtotime($datedispatched));
			}
			else
			{
				$datedispatched="";
			}
			if ($age > 0)
			{
	 			$age=$age;
			}
			elseif ($age =='NULL')
			{
	 			$age=0;;
			}
			elseif ($age =='N/A')
			{
	 			$age=0;;
			}
			elseif ($age =='NA')
			{
	 			$age=0;;
			}
			else
			{
				$age=0;;
				
			}
			
			if ($datedispatchedd == "")
{
	$datedispatchedd='0000-00-00';
}
if ($dateentered == "")
{
	$dateentered='0000-00-00';
}
if ($rejectedreason == "")
{
$rejectedreason=0;
}
if ($parentid =="")
{
$parentid=0;
}
if ($spots !='')
{
$spots=$spots;
}
else
{
$spots=0;
}
if ($rejectedreason == "")
{
$rejectedreason=0;
}
			list($exists,$sbatchno,$samplesinbatch)=GetBatchNoifExists($sdrec,$fcode,$labss,$eiddb);
				if ($exists > 0) //batchno exists
				{
					if ( $samplesinbatch ==10) //generate new batchno
					{
					$BatchNo=GetNewBatchNo($labss,$eiddb); //capture new batchno	
					}
					else //use the same batch no
					{
					$BatchNo=$sbatchno;
					}
				}
				else//doesnt exists so generate a new one
				{
					$BatchNo=GetNewBatchNo($labss,$eiddb); //capture new batchno		
				}
			
			if ( (stripos($labelid,'affected') !== false) && $cccno =="" && $facilityname =="")
			{
			//do nothing
			}
			elseif ($cccno =="" && $facilityname =="")
			{
			//do nothing
			}
			else
			{
			//echo $labelid. '<br/>';
		$mquery = "INSERT INTO mothers(facility,fcode,entry_point,feeding,prophylaxis,status,labtestedin) VALUES ('$fautoid','$fcode','$entrypoint','$infantfeeding','$mprophylaxis',2,'$labss')";
		$mimport = mysql_query($mquery,$eiddb) or die(mysql_error());	
		if ($mimport) //mother successfully saved
		{
				//get last mother ID
			$motherid=GetLastMotherID($labss,$eiddb);//get last entred mother record
			
			$pquery = "INSERT INTO patients(ID,mother,age,dob,gender,prophylaxis,labtestedin) VALUES ('$cccno','$motherid','$age','$dob','$sex','$iprophylaxis','$labss')";
			$pimport = mysql_query($pquery,$eiddb) or die(mysql_error());
				
				if ($pimport) //patient successfully saved
				{ 
				$lastpatientid = GetLastPatientID($labss,$eiddb);
				$squery ="
INSERT INTO samples
(batchno, patient,patientAutoID, facility, receivedstatus,rejectedreason,reason_for_repeat, spots, datecollected,datereceived, comments, labcomment,parentid,datetested,result,datemodified,datedispatched,fcode,Inworksheet,BatchComplete,Flag,repeatt,DispatchComments,inputcomplete,approved,run,labtestedin,dateentered)
VALUES
('$BatchNo', '$cccno','$lastpatientid', '$fautoid','$receivedstatus','$rejectedreason','$reasonforrepeat' ,'$spots', '$sdoc', '$sdrec', '$labelid','$facilityname', 0, '$datetested', '$outcome', '$datetested', '$datedispatched', '$fcode', 1,1,1,0,'$routcome',1,1,1,'$labss','$logindate')";
				$simport = mysql_query($squery,$eiddb) or die(mysql_error());
				
				if ($simport) //patient successfully saved
				{ 
					$count=$count+1;
				} //end if samples done	
					
				} //end if patients DONE
				
		}//end if mother dones		
			
			
			}//end if row not empty
			 if ($simport){// If the sample was saved return the sample data
            echo json_encode($simport);
          }else{//Else return an error message
            echo json_encode('an error occured, could not save');
          }	
				}//end if label id exists or not		
        
         
		  
		  }
		 else
		  
		 {
		 echo    json_encode('Error, ALL EID Variables Must be Provided');
		 
	//	
		  }
		  
	  
		  










}
else
{
		
	 echo    json_encode('An error, Test Type ( 1-EID, 2-VL ) Must be Provided');	
}