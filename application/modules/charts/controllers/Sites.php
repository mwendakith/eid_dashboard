<?php 
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Sites extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('sites_model');
	}

	function site_outcomes($year=NULL,$month=NULL)
	{
		$data['outcomes'] = $this->sites_model->sites_outcomes($year,$month);

    	$this->load->view('site_outcomes_view',$data);
	}

	function site_trends($site=NULL,$year=NULL)
	{
		$data = $this->sites_model->get_trends($site,$year);
		$this->load->view('site_trends_view', $data);
	}

	function site_positivity($site=NULL, $year=NULL){
		$data = $this->sites_model->get_positivity($site,$year);
		
		$this->load->view('site_positivity_view', $data);
	}

	function site_eid($site=NULL, $year=NULL, $month=NULL){
		$data = $this->sites_model->get_eid($site, $year, $month);
		
		$this->load->view('sites_pie_chart_view', $data);
	}

	function site_hei($site=NULL, $year=NULL, $month=NULL){
		$data = $this->sites_model->get_hei($site, $year, $month);
		$this->load->view('sites_pie_chart_view', $data);
	}

}
?>