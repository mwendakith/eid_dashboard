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

	function site_outcomes($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->sites_model->sites_outcomes($year,$month,$to_year,$to_month);

    	$this->load->view('site_outcomes_view',$data);
	}

	function unsupported_sites()
	{
		$data['outcomes'] = $this->sites_model->unsupported_sites();

    	$this->load->view('unsupported_sites_view',$data);
	}

	function download_unsupported_sites()
	{
		$this->sites_model->download_unsupported_sites();
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

	function site_eid($site=NULL, $year=NULL, $month=NULL, $to_month=NULL){
		$data['outcomes'] = $this->sites_model->get_eid($site,$year,$month,$to_year,$to_month);
		
		$this->load->view('sites_eid_outcomes_view', $data);
	}

	function site_hei($site=NULL, $year=NULL, $month=NULL){
		$data = $this->sites_model->get_hei($site, $year, $month);
		$this->load->view('sites_pie_chart_view', $data);
	}

	function partner_sites($year=NULL,$month=NULL,$site=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->sites_model->partner_sites_outcomes($year,$month,$site,$partner,$to_year,$to_month);

		$link = $year . '/' . $month . '/' . $partner . '/' . $to_year . '/' . $to_month;
		$link2 = $partner;
		//$data['link'] = anchor('charts/sites/download_partner_sites/' . $link, 'Download List');

		$data['link'] = "<a href='" . base_url('charts/sites/download_partner_sites/' . $link) . "'><button class='btn btn-primary' style='background-color: #009688;color: white;'>Export to Excel</button></a>";
		$data['link2'] = "<a href='" . base_url('charts/sites/download_partner_supported_sites/' . $link2) . "'><button class='btn btn-primary' style='background-color: #009688;color: white;'>DOWNLOAD LIST OF ALL SUPPORTED SITES</button></a>";

    	$this->load->view('partner_site__view',$data);
	}

	function download_partner_sites($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$this->sites_model->partner_sites_outcomes_download($year,$month,$partner,$to_year,$to_month);
	}

	function download_partner_supported_sites($partner=NULL)
	{
		$this->sites_model->partner_supported_sites_download($partner);
	}

	function partner_sites_excel($partner=NULL)
	{
		return $this->sites_model->partner_sites_outcomes(null,null,null,$partner);
	}
}
?>