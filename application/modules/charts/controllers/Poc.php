<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Poc extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('poc_model');
	}

	function testing_trends($county=null,$year=null,$month=null,$toYear=null,$toMonth=null)
	{
		$data['trends'] = $this->poc_model->testing_trends($county,$year,$month,$toYear,$toMonth);
		$data['div_name'] = "poc_time_summary";

		$this->load->view('trends_outcomes_view', $data);
	}

	function summary($county=null,$year=null,$month=null,$toYear=null,$toMonth=null)
	{
		$data['outcomes'] = $this->poc_model->get_agebreakdown($county,$year,$month,$toYear,$toMonth);

		$this->load->view('breakdown_listing', $data);
	}

	function entrypoint($county=null,$year=null,$month=null,$toYear=null,$toMonth=null)
	{
		$data['outcomes'] = $this->poc_model->get_agebreakdown($county,$year,$month,$toYear,$toMonth);

		$this->load->view('breakdown_listing', $data);
	}

	function age($county=null,$year=null,$month=null,$toYear=null,$toMonth=null)
	{
		$data['outcomes'] = $this->poc_model->get_agebreakdown($county,$year,$month,$toYear,$toMonth);

		$this->load->view('breakdown_listing', $data);
	}

	function county($county=null,$year=null,$month=null,$toYear=null,$toMonth=null)
	{
		$data['outcomes'] = $this->poc_model->get_agebreakdown($county,$year,$month,$toYear,$toMonth);

		$this->load->view('breakdown_listing', $data);
	}
}

?>