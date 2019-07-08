<?php
	error_reporting(0);

	$data = trim(file_get_contents('php://input'),'<?xml version="1.0" encoding="UTF-8"?> ');
	$order = json_decode($data);
	//Get the values you need to insert into the database
	//$labid = $order->labid;
	$serialno = $order->Instrumentserialno;
	$facility = $order->Laboratory;
	$month = $order->month;
	$year = $order->year;
	$totaltests = $order->totaltestsdone;
	$catridgeused = $order->totalcatridgeused;
	//echo    json_encode('vl').$testtype;
	$vldb = mysqli_connect("10.230.50.11:3307", "root", "FnP5FjbnMrzXCm.", "nodedata");

	if ($month !='' &&  $year !='' && $serialno !='') {
		function Checkifrecordexists($month,$year,$serialno,$vldb) {
			$strQuery=mysqli_query($vldb, "SELECT month FROM nodesummaries WHERE month='$month' and year='$year' and Instrumentserialno='$serialno' ")or die(mysqli_error($vldb));
			$numrows=mysqli_num_rows($strQuery);
			return $numrows; 
		}

		$facility=addslashes($facility);
		$facility=mysqli_real_escape_string($vldb, $facility);
		$today=date("Y-m-d");				
		$labelexists=Checkifrecordexists($month,$year,$serialno,$vldb);
		if ($labelexists > 0) {
			echo  'Summary for Month '.$month .'- '.$year.' already exists in database.';
		} else {
			$query = "INSERT INTO nodesummaries(Instrumentserialno,Laboratory,month,year,totaltestsdone,catridgeused,dateuploaded)
			VALUES ('$serialno','$facility','$month','$year','$totaltests','$catridgeused','$today')";
			$import = mysqli_query($vldb, $query) or die(mysqli_error($vldb));	

			if ($import) {// If the sample was saved return the sample data
				echo json_encode($import);
				$count=$count+1;
			} else {//Else return an error message
				echo json_encode('an error occured, could not save');
			}	
		}//end if record exists
	} else {
		echo json_encode('Error, ALL Key Varibales{ e.g. Month ,Year , Tests } Variables Must be Provided');
	}
?>
		  














		




	  
		  










