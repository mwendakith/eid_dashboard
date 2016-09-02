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

	function testing_trends($year=NULL,$month=NULL,$pfil=NULL,$partner=NULL,$county=NULL)
	{
		$data['outcomes'] = $this->summaries_model->test_trends($year,$month,$pfil,$partner,$county);

		$this->load->view('testing_trends_view', $data);
	}

	function eid_outcomes($year=NULL,$month=NULL,$county=NULL,$partner=NULL)
	{
		$data['outcomes'] =$this->summaries_model->eid_outcomes($year,$month,$county,$partner);

		$this->load->view('eid_outcomes_view', $data);
	}

	function hei_follow($year=NULL,$month=NULL,$county=NULL,$partner=NULL)
	{
		$data['outcomes'] =$this->summaries_model->hei_follow($year,$month,$county,$partner);

		$this->load->view('hei_view', $data);
	}

	function agegroup($year=NULL,$month=NULL,$county=NULL,$partner=NULL)
	{
		$data['outcomes'] =$this->summaries_model->age($year,$month,$county,$partner);

		$this->load->view('eid_outcomes_view', $data);
	}

}
?>