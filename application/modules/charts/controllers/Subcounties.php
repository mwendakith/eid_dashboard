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

	function subcounties_eid($sub_county=NULL,$year=NULL,$month=NULL)
	{
		$data['outcomes'] = $this->subcounties_model->get_eid($sub_county, $year,$month);

    	$this->load->view('sites_eid_outcomes_view',$data);
	}

	function subcounties_hei($sub_county=NULL,$year=NULL,$month=NULL)
	{
		$data= $this->subcounties_model->get_hei($year,$month);

    	$this->load->view('sites_pie_chart_view',$data);
	}

	function subcounties_age($sub_county=NULL,$year=NULL,$month=NULL)
	{
		$data['outcomes'] = $this->subcounties_model->age($year,$month);

    	$this->load->view('agegroup_view',$data);
	}

	function subcounties_sites($sub_county=NULL,$year=NULL,$month=NULL)
	{
		$data['outcomes'] = $this->subcounties_model->subcounty_sites_outcomes($year,$month, $sub_county);

		$link = $sub_county . '/' . $year . '/' . $month;


    	$data['link'] = "<a href='" . base_url('charts/subcounties/download_subcounty_sites/' . $link) . "'>Download List</a>";

    	$this->load->view('partner_site__view',$data);
	}

	function download_subcounty_sites($subcounty=NULL,$year=NULL,$month=NULL)
	{
		$this->subcounties_model->subcounty_sites_outcomes_download($year,$month,$subcounty);
	}
}
?>