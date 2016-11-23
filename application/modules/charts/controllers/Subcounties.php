<?php 
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Subcounties extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('subcounties_model');
	}

	function subcounties_outcomes($year=NULL,$month=NULL)
	{
		$data['outcomes'] = $this->subcounties_model->subcounties_outcomes($year,$month);

    	$this->load->view('subcounty_outcomes_view',$data);
	}

	function unsupported_sites()
	{
		$data['outcomes'] = $this->subcounties_model->unsupported_sites();

    	$this->load->view('unsupported_sites_view',$data);
	}

	function download_unsupported_sites()
	{
		$this->subcounties_model->download_unsupported_sites();
	}

	function site_trends($site=NULL,$year=NULL)
	{
		$data = $this->subcounties_model->get_trends($site,$year);
		$this->load->view('site_trends_view', $data);
	}

	function site_positivity($site=NULL, $year=NULL){
		$data = $this->subcounties_model->get_positivity($site,$year);
		
		$this->load->view('site_positivity_view', $data);
	}

	function site_eid($site=NULL, $year=NULL, $month=NULL){
		$data['outcomes'] = $this->subcounties_model->get_eid($site, $year, $month);
		
		$this->load->view('sites_eid_outcomes_view', $data);
	}

	function site_hei($site=NULL, $year=NULL, $month=NULL){
		$data = $this->subcounties_model->get_hei($site, $year, $month);
		$this->load->view('sites_pie_chart_view', $data);
	}

	function partner_sites($year=NULL,$month=NULL,$site=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->subcounties_model->partner_sites_outcomes($year,$month,$site,$partner);

		$link = $year . '/' . $month . '/' . $partner;

		//$data['link'] = anchor('charts/sites/download_partner_sites/' . $link, 'Download List');

		$data['link'] = "<a href='" . base_url('charts/sites/download_partner_sites/' . $link) . "'>Download List</a>";

    	$this->load->view('partner_site__view',$data);
	}

	function download_partner_sites($year=NULL,$month=NULL,$partner=NULL)
	{
		$this->subcounties_model->partner_sites_outcomes_download($year,$month,$partner);
	}

	function partner_sites_excel($partner=NULL)
	{
		return $this->subcounties_model->partner_sites_outcomes(null,null,null,$partner);
	}
}
?>