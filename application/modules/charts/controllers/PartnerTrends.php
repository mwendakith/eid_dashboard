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
		$this->load->view('lab_performance_wide_view', $data);
		
	}

	function summary($partner=NULL){
		$data['trends'] = $this->partner_model->yearly_summary($partner);
		// echo "<pre>";print_r($data);die();
		$this->load->view('lab_outcomes_view', $data);
	}


}