<?php
error_reporting(0);

$data = trim(file_get_contents('php://input'),'<?xml version="1.0" encoding="UTF-8"?> ');
$order = json_decode($data);

//Get the values you need to insert into the database
//$labid = $order->labid;
$serialno = $order->DeviceSerial;
$assay = $order->TestName;
$runid = $order->ResultNo;
$rundate = $order->Timestamp;
$runby = $order->Operator;
$catridgeid = $order->CartridgeID;
$errorcode = $order->ErrorCode;
$sampledetection = $order->SampleDetection;	
$device = $order->Device;
$patientid = $order->SampleID;
$hiv1control = $order->HIV1PositiveControl;
$hiv2control = $order->HIV2PositiveControl;
$result = $order->HIV1MN;	
$result2 = $order->HIV1O;
$result3 = $order->HIV2;
$negcontrol= $order->NegativeControl;
$analysis = $order->Analysis;
$software = $order->DeviceSoftware;
$devicemode = $order->DeviceMode;
$status = $order->Status;

//echo    json_encode('vl').$testtype;
$vldb = mysqli_connect("10.230.50.11:3307", "root", "FnP5FjbnMrzXCm.", "nodedata");

if ($patientid !='' &&  $rundate !='' && $serialno !='') {
	function Checkifrecordexists($runid,$patientid,$rundate,$vldb) {
		$strQuery=mysqli_query($vldb, "SELECT ResultNo,RunDate,SampleID FROM alereqtests WHERE ResultNo='$runid' and RunDate='$rundate' and SampleID='$patientid' ")or die(mysqli_error($vldb));
		$numrows=mysqli_num_rows($strQuery);
		return $numrows; 
	}

	$runby=mysqli_real_escape_string($vldb, $runby);
	$facility=addslashes($facility);
	$facility=mysqli_real_escape_string($vldb, $facility);

	if ($rundate != "") {
		$rundate=date("Y-m-d",strtotime($rundate));
	} else {
		$rundate="";
	}

	$today=date("Y-m-d");				
	$labelexists=Checkifrecordexists($runid,$patientid,$rundate,$vldb);
	if ($labelexists > 0 ) {
		echo  'Sample ID '.$patientid .' Run On '.$rundate.' already exists in database.';
	} else {
		$query = "INSERT INTO alereqtests(ResultNo,Instrumentserialno,TestName,CartridgeID,SampleID,HIV1MN,HIV1O,HIV2,ErrorCode,Operator,RunDate,SampleDetection,Device	,HIV1PositiveControl,HIV2PositiveControl,NegativeControl,Analysis,DeviceSoftware,DeviceMode,Status,dateuploaded)
		VALUES ('$runid','$serialno','$assay','$catridgeid','$patientid','$result','$result2','$result3','$errorcode','$runby','$rundate','$sampledetection','$device','$hiv1control','$hiv2control','$negcontrol','$analysis','$software','$devicemode','$status','$today')";
		$import = mysqli_query($vldb, $query) or die(mysqli_error($vldb));	

		if ($import) {// If the sample was saved return the sample data
			echo json_encode($import);
			$count=$count+1;
		} else {//Else return an error message
			echo json_encode('an error occured, could not save');
		}	
	}//end if record exists
} else {
	echo json_encode('Error, ALL Key Varibales{ e.g. Run ID, Patient ID, Run Date} Variables Must be Provided');
}
		  
		  














		




	  
		  










