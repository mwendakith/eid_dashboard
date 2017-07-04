<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Rht extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('rht_model');
	}

	function get_trends($county=null,$year=null)
	{
		$data['trends'] = $this->rht_model->get_trends($county,$year);

		$data['div_name'] = "rht_outcome_trends";

		$this->load->view('trends_outcomes_view', $data);
	}

	function get_outcomes($county=null,$year=null,$month=null,$toYear=null,$toMonth=null)
	{
		$data['outcomes'] = $this->rht_model->get_outcomes($county,$year,$month,$toYear,$toMonth);

		$this->load->view('eid_outcomes_view', $data);
	}

	function get_gender($county=null,$year=null,$month=null,$toYear=null,$toMonth=null)
	{
		$data['outcomes'] = $this->rht_model->get_gender($county,$year,$month,$toYear,$toMonth);

		$this->load->view('agegroup_view', $data);
	}

	function get_yearly_trends($county=null)
	{
		$obj = $this->rht_model->get_yearly_trends($county);

		$data['trends'] = $obj['test_trends'];
		$data['title'] = "";
		$data['div_name'] = "tests";
		$data['suffix'] = "";
		$data['yAxis'] = "Number of Tests";
		$this->load->view('lab_performance_wide_view', $data);
	}

	function get_positivity($county=null,$year=null)
	{
		$obj = $this->rht_model->get_positivity($county,$year);

		$data['trends'] = $obj['test_trends'];
		$data['title'] = "";
		$data['div_name'] = "pos";
		$data['suffix'] = "";
		$data['yAxis'] = "Number of Tests";
		$this->load->view('lab_performance_wide_view', $data);
	}

	function get_negativity($county=null,$year=null)
	{
		$obj = $this->rht_model->get_negativity($county,$year);

		$data['trends'] = $obj['test_trends'];
		$data['title'] = "";
		$data['div_name'] = "neg";
		$data['suffix'] = "";
		$data['yAxis'] = "Number of Tests";
		$this->load->view('lab_performance_wide_view', $data);
	}

	function get_facilities($county=null,$year=null,$month=null,$toYear=null,$toMonth=null)
	{
		$data['outcomes'] = $this->rht_model->get_facilities($county,$year,$month,$toYear,$toMonth);

		$this->load->view('county_outcomes_view', $data);
	}




}

?>