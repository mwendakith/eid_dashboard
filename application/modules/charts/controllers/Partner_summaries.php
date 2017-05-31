<?php
defined('BASEPATH') or exit('No direct script access allowed!');
/**
* 
*/
class Partner_summaries extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('partner_summaries_model');
	}

	function testing_trends($year=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->partner_summaries_model->test_trends($year,$partner);

		$this->load->view('testing_trends_view', $data);
	}

	function eid_outcomes($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->partner_summaries_model->eid_outcomes($year,$month,$partner,$to_year,$to_month);

		$this->load->view('eid_outcomes_view', $data);
	}

	function hei_validation($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->partner_summaries_model->hei_validation($year,$month,$partner,$to_year,$to_month);

		$this->load->view('hei_validation_pie', $data);
	}

	function hei_follow($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->partner_summaries_model->hei_follow($year,$month,$partner,$to_year,$to_month);

		$this->load->view('hei_view', $data);
	}

	function agegroup($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->partner_summaries_model->age($year,$month,$partner,$to_year,$to_month);

		$this->load->view('agegroup_view', $data);
	}

	function entry_points($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->partner_summaries_model->entry_points($year,$month,$partner,$to_year,$to_month);

		$this->load->view('entry_point_view', $data);
	}

	function mprophyalxis($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->partner_summaries_model->mprophylaxis($year,$month,$partner,$to_year,$to_month);

		$this->load->view('mprophylaxis_view', $data);
	}

	function iprophyalxis($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->partner_summaries_model->iprophylaxis($year,$month,$partner,$to_year,$to_month);

		$this->load->view('iprophylaxis_view', $data);
	}

	function partner_outcomes($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->partner_summaries_model->partner_outcomes($year,$month,$partner,$to_year,$to_month);

    	$this->load->view('county_outcomes_view',$data);
	}

}
?>