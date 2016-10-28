<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class LabPerformance extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('performance_model');
	}

	function lab_performance_stats($year=NULL,$month=NULL)
	{
		$data['stats'] = $this->performance_model->lab_performance_stat($year,$month);

		$this->load->view('lab_performance_stats_view', $data);
	}

	function testing_trends($year=NULL)
	{
		$obj['trends'] = $this->performance_model->lab_testing_trends($year);
		//echo "<pr>";print_r($data);die;
		//
		//echo json_encode($data);

		$data['trends'] = $obj['trends']['test_trends'];
		$data['title'] = "Test Trends (" . $obj['trends']['year'] . ")";
		$data['div'] = "#tests";
		$data['div_name'] = "tests";
		$data['suffix'] = "";
		$data['yAxis'] = "Number of Tests";
		$this->load->view('lab_performance_view', $data);

		$data['trends'] = $obj['trends']['positivity_trends'];
		$data['title'] = "Positivity Trends (" . $obj['trends']['year'] . ")";
		$data['div'] = "#positivity";
		$data['div_name'] = "positivity";
		$data['suffix'] = "%";
		$data['yAxis'] = "Number of Positives(%)";
		$this->load->view('lab_performance_view', $data);

		$data['trends'] = $obj['trends']['rejected_trends'];
		$data['title'] = "Rejected Trends (" . $obj['trends']['year'] . ")";
		$data['div'] = "#rejects";
		$data['div_name'] = "rejects";
		$data['suffix'] = "%";
		$data['yAxis'] = "Number of Rejects(%)";
		$this->load->view('lab_performance_view', $data);

		
	}

	function lab_outcomes($year=NULL, $month=NULL){
		$data['trends'] = $this->performance_model->lab_outcomes($year, $month);
		//echo json_encode($data);
		$this->load->view('lab_outcomes_view', $data);

	}

	function lab_turnaround($year=NULL, $month=NULL){
		$data = $this->performance_model->lab_turnaround($year, $month);
		//echo json_encode($data);

		foreach ($data as $key => $value) {
			$this->load->view('lab_turnaround_time_view', $value);
		}
		
		$this->load->view('lab_turnaround_key_view');

	}


}