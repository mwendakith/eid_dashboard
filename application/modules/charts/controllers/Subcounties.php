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

	function subcounties_outcomes($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['trends'] = $this->subcounties_model->subcounties_outcomes($year,$month,$to_year,$to_month);
		$data['div_name'] = "subcounties_subcounties_summary";

		$this->load->view('trends_outcomes_view', $data);
	}

	function subcounties_eid($sub_county=NULL,$year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->subcounties_model->get_eid($sub_county, $year,$month,$to_year,$to_month);

    	$this->load->view('sites_eid_outcomes_view',$data);
	}

	function subcounties_hei_outcomes($sub_county=NULL,$year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes']= $this->subcounties_model->hei_validation($sub_county,$year,$month,$to_year,$to_month);

    	$this->load->view('hei_validation_pie',$data);
	}

	function subcounties_hei($sub_county=NULL,$year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data= $this->subcounties_model->get_hei($sub_county,$year,$month,$to_year,$to_month);

    	$this->load->view('sites_pie_chart_view',$data);
	}

	function subcounties_age($sub_county=NULL,$year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->subcounties_model->age2($sub_county,$year,$month,$to_year,$to_month);

    	$this->load->view('agegroup_view',$data);
	}

	function subcounties_sites($sub_county=NULL,$year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->subcounties_model->subcounty_sites_outcomes($sub_county,$year,$month,$to_year,$to_month);

		$link = $sub_county . '/' . $year . '/' . $month . '/' . $to_year . '/' . $to_month;

    	$data['link'] = base_url('charts/subcounties/download_subcounty_sites/' . $link);

    	$this->load->view('subcounty_sites_view',$data);
	}

	function download_subcounty_sites($sub_county=NULL,$year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL)
	{
		$this->subcounties_model->subcounty_sites_outcomes_download($sub_county,$year,$month,$to_year,$to_month);
	}
}
?>