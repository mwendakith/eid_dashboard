<?php
error_reporting(0);

$data = trim(file_get_contents('php://input'),'<?xml version="1.0" encoding="UTF-8"?> ');
$order = json_decode($data);
//Get the values you need to insert into the database
//$labid = $order->labid;
$serialno = $order->Instrumentserialno;
$facility = $order->Laboratory;
$runid = $order->RunID;
$rundate = $order->RunDateTime;
$runby = $order->Operator;
$reagentlotid = $order->ReagentLotID;
$reagentlotexp = $order->ReagentLotExp;
$processlotid = $order->ProcessLotID;	
$processlotexp = $order->ProcessLotExp;
$patientid = $order->PatientID;
$instqc = $order->InstQCPassed;
$reagentqc = $order->ReagentQCPassed;
$result = $order->CD4result;	
$resultpercent = $order->CD4percent;
$hb = $order->Hb;
$errorcode = $order->ErrorCodes;

$vldb = mysqli_connect("10.230.50.11:3307", "root", "FnP5FjbnMrzXCm.", "nodedata");

if ( $patientid !='' &&  $rundate !='' && $serialno !=''   ) {
	function Checkifrecordexists($runid,$patientid,$rundate,$vldb) {
		$strQuery=mysqli_query($vldb, "SELECT RunID,RunDate,PatientID FROM nodetests WHERE RunID='$runid' and RunDate='$rundate' and PatientID='$patientid' ")or die(mysqli_error($vldb));
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
		echo  'Patient ID'.$patientid .' Run On'.$rundate.' already exists in database.';
	} else {
		$query = "INSERT INTO nodetests(Instrumentserialno,Laboratory,RunID,RunDate,Operator,ReagentLotID,ReagentLotExp,ProcessLotID,ProcessLotExp,PatientID,InstQCPassed,ReagentQCPassed,CD4,CD4percent,Hb,ErrorCodes,dateuploaded)
		VALUES ('$serialno','$facility','$runid','$rundate','$runby','$reagentlotid','$reagentlotexp','$processlotid','$reagentlotexp','$patientid','$instqc','$reagentqc','$result','$resultpercent','$hb','$errorcode','$today')";
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
?>