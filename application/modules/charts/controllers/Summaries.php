<?php
defined('BASEPATH') or exit('No direct script access allowed!');
/**
* 
*/
class Summaries extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('summaries_model');
	}

	function turnaroundtime($year=NULL,$month=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->summaries_model->turnaroundtime($year,$month,$county,$to_year,$to_month);
		$this->load->view('turnaroundtime_view',$data);
	}
	
	function testing_trends($year=NULL,$type=NULL,$county=NULL,$partner=NULL)
	{
		$data['trends'] = $this->summaries_model->test_trends($year,$type,$county,$partner);
		$data['div_name'] = "summary_yearly_summary";
		$data['export'] = TRUE;
		$link = $year . '/' . $county . '/' . $partner;

		$data['link'] = base_url('charts/summaries/download_testing_trends/' . $link);
		print_r($data) ; die();
		$this->load->view('trends_outcomes_view', $data);

	}

	function download_testing_trends($year=NULL,$county=NULL,$partner=NULL)
	{
		$this->summaries_model->download_testing_trends($year,$county,$partner);
	}

	function eid_outcomes($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->summaries_model->eid_outcomes($year,$month,$county,$partner,$to_year,$to_month);

		$this->load->view('eid_outcomes_view', $data);
	}

	function hei_validation($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->summaries_model->hei_validation($year,$month,$county,$partner,$to_year,$to_month);

		// echo json_encode($data);


		$this->load->view('hei_validation_pie', $data);
	}

	function hei_follow($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->summaries_model->hei_follow($year,$month,$county,$partner,$to_year,$to_month);

		// echo json_encode($data);

		$this->load->view('hei_view', $data);
	}

	function agegroup($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->summaries_model->age2($year,$month,$county,$partner,$to_year,$to_month);

		$this->load->view('agegroup_view', $data);
	}

	function entry_points($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->summaries_model->entry_points($year,$month,$county,$partner,$to_year,$to_month);

		$this->load->view('entry_point_view', $data);
	}

	function mprophyalxis($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->summaries_model->mprophylaxis($year,$month,$county,$partner,$to_year,$to_month);

		$this->load->view('mprophylaxis_view', $data);
	}

	function iprophyalxis($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->summaries_model->iprophylaxis($year,$month,$county,$partner,$to_year,$to_month);

		$this->load->view('iprophylaxis_view', $data);
	}

	function county_outcomes($year=NULL,$month=NULL,$pfil=NULL,$partner=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['trends'] = $this->summaries_model->county_outcomes($year,$month,$pfil,$partner,$county,$to_year,$to_month);
		$data['div_name'] = "summary_counties_summary";

		$this->load->view('trends_outcomes_view', $data);

	}

	function get_patients($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data = $this->summaries_model->get_patients($year,$month,$county,$partner,$to_year,$to_month);

    	$this->load->view('patients_view',$data);
	}

	function get_patients_outcomes($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data = $this->summaries_model->get_patients_outcomes($year,$month,$county,$partner,$to_year,$to_month);

    	$this->load->view('patients_outcomes_graph',$data);
	}

	function get_patients_graph($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data = $this->summaries_model->get_patients_graph($year,$month,$county,$partner,$to_year,$to_month);

    	$this->load->view('patients_graph',$data);
	}

}
?>