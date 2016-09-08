<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class Trends extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('trends_model');
	}

	function positive_trends($county=NULL){
		$obj['trends'] = $this->trends_model->yearly_trends($county);

		$data['trends'] = $obj['trends']['test_trends'];
		$data['title'] = "Test Trends";
		$data['div'] = "#tests";
		$data['div_name'] = "tests";
		$this->load->view('lab_performance_view', $data);

		$data['trends'] = $obj['trends']['rejected_trends'];
		$data['title'] = "Rejected Trends";
		$data['div'] = "#rejects";
		$data['div_name'] = "rejects";
		$this->load->view('lab_performance_view', $data);

		$data['trends'] = $obj['trends']['positivity_trends'];
		$data['title'] = "Positivity Trends";
		$data['div'] = "#positivity";
		$data['div_name'] = "positivity";
		$this->load->view('lab_performance_view', $data);

		//echo json_encode($obj);
		//echo "<pr>";print_r($obj);die;

	}

	function summary($county=NULL){
		$data['trends'] = $this->trends_model->yearly_summary($county);
		//$data['trends'] = $this->positivity_model->yearly_summary();
		//echo json_encode($data);
		$this->load->view('lab_outcomes_view', $data);
	}


}