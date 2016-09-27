<?php
defined("BASEPATH") or exit("No direct script access allowed");

/**
* 
*/
class Performance_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();;
	}

	function lab_testing_trends($year=NULL)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}

		$data['year'] = $year;

		$sql = "CALL `proc_get_lab_performance`('".$year."')";

		$result = $this->db->query($sql)->result_array();

		$categories = array();
		foreach ($result as $key => $value) {

			$month = (int) $value['month'];
			$month--;

			$lab = (int) $value['ID'];
			$lab--;

			$data['test_trends'][$lab]['name'] = $value['name'];
			$data['test_trends'][$lab]['data'][$month] = (int) $value['tests'];

			$data['rejected_trends'][$lab]['name'] = $value['name'];
			if($value['tests'] == 0){
				$data['rejected_trends'][$lab]['data'][$month] = 0;
			}else{
				$data['rejected_trends'][$lab]['data'][$month] = (int) 
				 ($value['rejected'] / $value['tests'] * 100);
			}

			$data['positivity_trends'][$lab]['name'] = $value['name'];
			if($value['pos'] == 0){
				$data['positivity_trends'][$lab]['data'][$month] = 0;
			}else{
				$data['positivity_trends'][$lab]['data'][$month] = (int) 
				(($value['pos']/ ($value['pos'] + $value['neg'])) * 100);
			}



		}

		//echo "<pre>";print_r($data);die();

		return $data;
	}

	function lab_outcomes($year=NULL, $month=NULL){
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}
		
		$sql = "CALL `proc_get_lab_outcomes`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$data;
		if($month == 0){
			$data['title'] = "Outcomes (" . $year . ")";
		}
		else{
			$data['title'] = "Outcomes (" . $year . ", " . $this->resolve_month($month) . ")";
		}

		
		foreach ($result as $key => $value) {

			$lab = (int) $value['ID'];
			$lab--;

			$data['categories'][$lab] = $value['name'];

			$data['outcomes'][0]['name'] = "positive";
			$data['outcomes'][0]['data'][$lab] = (int) $value['pos'];


			$data['outcomes'][1]['name'] = "negative";
			$data['outcomes'][1]['data'][$lab] = (int) $value['neg'];

		}
		 // echo "<pre>";print_r($data);die();
		return $data;
	}

	function lab_turnaround($year=NULL, $month=NULL){
		$title = null;
		if($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}

		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
				$title = " (" . $year . ")";
			}else {
				$month = $this->session->userdata('filter_month');
				//$title += " (" . $year . ", " . $this->resolve_month($month) . ")";
			}

		}

		if(!$title){
			$title = " (" . $year . ", " . $this->resolve_month($month) . ")";
		}
		 
		

		$sql = "CALL `proc_get_lab_tat`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$data;
		foreach ($result as $key => $value) {
			$lab = (int) $value['ID'];
			$lab--;

			$data[$lab]['div'] = "#container" . ($lab+1);	
			$data[$lab]['div_name'] = "container" . ($lab+1);	
			$data[$lab]['name'] = $value['name'] . $title;	
			$data[$lab]['tat1'] = (int) $value['tat1'];	
			$data[$lab]['tat2'] = (int) $value['tat2'] + $data[$lab]['tat1'];	
			$data[$lab]['tat3'] = (int) $value['tat3'] + $data[$lab]['tat2'];	
			$data[$lab]['tat4'] = (int) $value['tat4'];	
			
		}
		 // echo "<pre>";print_r($data);die();
		return $data;		
	}


}