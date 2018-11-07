<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class PartnerTrends extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('partner_model');
	}

	function partner_trends($partner=NULL){
		$obj = $this->partner_model->yearly_trends($partner);

		$data['trends'] = $obj['test_trends'];
		$data['title'] = "Test Trends";
		$data['div'] = "#tests";
		$data['div_name'] = "tests";
		$data['suffix'] = "";
		$data['yAxis'] = "Number of Tests";
		$this->load->view('lab_performance_view', $data);

		$data['trends'] = $obj['rejected_trends'];
		$data['title'] = "Rejection Rate Trends";
		$data['div'] = "#rejects";
		$data['div_name'] = "rejects";
		$data['suffix'] = "%";
		$data['yAxis'] = "Rejection (%)";
		$this->load->view('lab_performance_view', $data);

		$data['trends'] = $obj['infant_trends'];
		$data['title'] = "Infants Less than 2m";
		$data['div'] = "#infants";
		$data['div_name'] = "infants";
		$data['suffix'] = "";
		$data['yAxis'] = "Number of Tests (Infants under 2m)";
		$this->load->view('lab_performance_view', $data);

		$data['trends'] = $obj['positivity_trends'];
		$data['title'] = "Positivity Trends";
		$data['div'] = "#positivity";
		$data['div_name'] = "positivity";
		$data['suffix'] = "%";
		$data['yAxis'] = "Positivity (%)";
		$this->load->view('lab_performance_view', $data);
		
	}

	function summary($partner=NULL){
		$data['trends'] = $this->partner_model->yearly_summary($partner);
		$data['div_name'] = "partner_outcome_trends";
		// echo "<pre>";print_r($data);die();
		$this->load->view('trends_outcomes_view', $data);
	}

	function quarterly($partner=NULL){
		$obj = $this->partner_model->quarterly_trends($partner);
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

	function alltests_q($partner=NULL){
		$data['trends'] = $this->partner_model->alltests($partner);
		$data['div_name'] = "all_q_trends";
		$this->load->view('trends_outcomes_view', $data);
	}

	function repeat_q($partner=NULL){
		$data['trends'] = $this->partner_model->rtests($partner);
		$data['div_name'] = "repeat_q_trends";
		$this->load->view('trends_outcomes_view', $data);
	}

	function infants_q($partner=NULL){
		$data['trends'] = $this->partner_model->infant_tests($partner);
		$data['div_name'] = "infants_q_trends";
		$this->load->view('trends_outcomes_view', $data);
	}

	function less2m_q($partner=NULL){
		$data['trends'] = $this->partner_model->ages_2m_quarterly($partner);
		$data['div_name'] = "less2m_q_trends";
		$this->load->view('trends_view2', $data);
	}

	function quarterly_outcomes($partner=NULL){
		$data['trends'] = $this->partner_model->quarterly_outcomes($partner);
		// echo "<pre>";print_r($data);echo "</pre>";die();
		$data['div_name'] = "quarterly_trends";
		$this->load->view('trends_outcomes_view', $data);
	}

	function some_test($partner=null) {
		$data['trends'] = $this->partner_model->some_quarters($partner);
		echo "<pre>";print_r($data);die();
	}


}