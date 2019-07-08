<?php
	error_reporting(0);
	$data = trim(file_get_contents('php://input'),'<?xml version="1.0" encoding="UTF-8"?> ');
	$order = json_decode($data);
	//Get the values you need to insert into the database
	//$labid = $order->labid;
	$password = $order->password;
	$systemName = $order->systemName;
	$exportedDate = $order->exportedDate;
	$assay = $order->assay;
	$assayVersion= $order->assayVersion;
	$sampleId = $order->sampleId;
	$patientId = $order->patientId;
	$user = $order->user;	
	$status = $order->status;
	$startTime = $order->startTime;
	$endTime = $order->endTime;
	$errorStatus = $order->errorStatus;
	$reagentLotId = $order->reagentLotId;	
	$cartridgeExpirationDate = $order->cartridgeExpirationDate;
	$cartridgeSerial = $order->cartridgeSerial;
	$moduleName = $order->moduleName;
	$moduleSerial = $order->moduleSerial;
	$instrumentSerial = $order->instrumentSerial;
	$softwareVersion = $order->softwareVersion;
	$resultId = $order->resultId;
	$resultIdinterpretation = $order->resultIdinterpretation;

	$vldb = mysqli_connect("10.230.50.11:3307", "root", "FnP5FjbnMrzXCm.", "nodedata"); 

	if ($sampleId !='') {
		function Checkifrecordexists($sampleId,$startTime,$endTime,$vldb) {
			$strQuery=mysqli_query($vldb, "SELECT ID FROM genexperttests WHERE  startTime='$startTime' and endTime='$endTime' and sampleId='$sampleId' ")or die(mysqli_error($vldb));
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
		$labelexists=Checkifrecordexists($sampleId,$startTime,$endTime,$vldb);
		if ($labelexists > 0) {
			echo  'Sample ID'.$sampleId .' Run On'.$startTime.' already exists in database.';
		} else {
			$query = "INSERT INTO genexperttests
			(password,systemName,exportedDate ,assay ,assayVersion,sampleId ,patientId ,user,status ,startTime ,endTime ,errorStatus,reagentLotId ,cartridgeExpirationDate ,cartridgeSerial,moduleName ,moduleSerial ,instrumentSerial ,softwareVersion,resultId ,resultIdinterpretation,dateuploaded)
			VALUES ('$password','$systemName','$exportedDate ' ,'$assay' ,'$assayVersion','$sampleId' ,'$patientId' ,'$user','$status' ,'$startTime' ,'$endTime' ,'$errorStatus','$reagentLotId' ,'$cartridgeExpirationDate' ,'$cartridgeSerial','$moduleName' ,'$moduleSerial' ,'$instrumentSerial' ,'$softwareVersion','$resultId' ,'$resultIdinterpretation','$today')";
			$import = mysqli_query($vldb,$query) or die(mysqli_error($vldb));	

			if ($import) {// If the sample was saved return the sample data
				echo json_encode($import);
				$count=$count+1;
			} else {//Else return an error message
				echo json_encode('an error occured, could not save');
			}	

		}//end if record exists
	}
	else {
		echo json_encode('Error, ALL Key Varibales{ e.g. Sample ID} Variables Must be Provided');
	}
?>