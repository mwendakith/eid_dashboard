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

	function site_outcomes($year=NULL,$month=NULL,$site=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->sites_model->sites_outcomes($year,$month,$site,$partner);

    	$this->load->view('site_outcomes_view',$data);
	}

	function partner_sites($year=NULL,$month=NULL,$site=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->sites_model->partner_sites_outcomes($year,$month,$site,$partner);

    	$this->load->view('partner_site__view',$data);
	}

}
?>