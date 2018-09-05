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
		$obj = $this->trends_model->yearly_trends($county);
		// echo "<pre>";print_r($obj);echo "</pre>";die();
		$data['trends'] = $obj['test_trends'];
		$data['title'] = "Testing Trends (Initial PCR)";
		$data['div_name'] = "tests";
		$data['suffix'] = "";
		$data['yAxis'] = "Number of Tests";
		$this->load->view('lab_performance_view', $data);

		$data['trends'] = $obj['rejected_trends'];
		$data['title'] = "Rejection Rate Trends";
		$data['div_name'] = "rejects";
		$data['suffix'] = "%";
		$data['yAxis'] = "Rejection (%)";
		$this->load->view('lab_performance_view', $data);

		$data['trends'] = $obj['tat4_trends'];
		$data['title'] = "Turn Around Time ( Collection - Dispatch )";
		$data['div_name'] = "tat";
		$data['suffix'] = "";
		$data['yAxis'] = "TAT(Days)";
		$this->load->view('lab_performance_view', $data);


		$data['trends'] = $obj['infant_trends'];
		$data['title'] = "Infant tests (less than 2m)";
		$data['div_name'] = "infants";
		$data['suffix'] = "";
		$data['yAxis'] = "Number of Infant Tests";
		$this->load->view('lab_performance_view', $data);

		$data['trends'] = $obj['positivity_trends'];
		$data['title'] = "Positivity Trends";
		$data['div_name'] = "positivity";
		$data['suffix'] = "%";
		$data['yAxis'] = "Positivity (%)";
		$this->load->view('lab_performance_wide_view', $data);		
		

		//echo json_encode($obj);
		//echo "<pr>";print_r($obj);die;

	}

	function summary($county=NULL){
		$data['trends'] = $this->trends_model->yearly_summary($county);
		$data['div_name'] = "national_trends";
		//$data['trends'] = $this->positivity_model->yearly_summary();
		//echo json_encode($data);
		// echo "<pre>";print_r($data);die();
		$this->load->view('trends_outcomes_view', $data);
	}

	function quarterly($county=NULL){
		$obj = $this->trends_model->quarterly_trends($county);
		// echo "<pre>";print_r($obj);echo "</pre>";die();
		$data['trends'] = $obj['test_trends'];
		$data['title'] = "Testing Trends (Initial PCR)";
		$data['div_name'] = "tests_q";
		$data['suffix'] = "";
		$data['yAxis'] = "Number of Tests";
		$this->load->view('quarterly_view', $data);

		$data['trends'] = $obj['positivity_trends'];
		$data['title'] = "Positivity Trends";
		$data['div_name'] = "positivity_q";
		$data['suffix'] = "%";
		$data['yAxis'] = "Positivity (%)";
		$this->load->view('quarterly_view', $data);

		$data['trends'] = $obj['rejected_trends'];
		$data['title'] = "Rejection Rate Trends";
		$data['div_name'] = "rejects_q";
		$data['suffix'] = "%";
		$data['yAxis'] = "Rejection (%)";
		$this->load->view('quarterly_view', $data);

		$data['trends'] = $obj['tat4_trends'];
		$data['title'] = "Turn Around Time ( Collection - Dispatch )";
		$data['div_name'] = "tat_q";
		$data['suffix'] = "";
		$data['yAxis'] = "TAT(Days)";
		$this->load->view('quarterly_view', $data);


		$data['trends'] = $obj['infant_trends'];
		$data['title'] = "Infant tests (less than 2m)";
		$data['div_name'] = "infants_q";
		$data['suffix'] = "";
		$data['yAxis'] = "Number of Infant Tests";
		$this->load->view('quarterly_view', $data);

		//echo json_encode($obj);
		//echo "<pr>";print_r($obj);die;

	}

	function alltests_q($county=NULL){
		$data['trends'] = $this->trends_model->alltests($county);
		$data['div_name'] = "all_q_trends";
		$this->load->view('trends_outcomes_view', $data);
	}

	function repeat_q($county=NULL){
		$data['trends'] = $this->trends_model->rtests($county);
		$data['div_name'] = "repeat_q_trends";
		$this->load->view('trends_outcomes_view', $data);
	}

	function infants_q($county=NULL){
		$data['trends'] = $this->trends_model->infant_tests($county);
		$data['div_name'] = "infants_q_trends";
		$this->load->view('trends_outcomes_view', $data);
	}

	function less2m_q($county=NULL){
		$data['trends'] = $this->trends_model->ages_2m_quarterly($county);
		$data['div_name'] = "less2m_q_trends";
		$this->load->view('trends_view2', $data);
	}

	function quarterly_outcomes($county=NULL){
		$data['trends'] = $this->trends_model->quarterly_outcomes($county);
		// echo "<pre>";print_r($data);echo "</pre>";die();
		$data['div_name'] = "quarterly_trends";
		$this->load->view('trends_outcomes_view', $data);
	}



}