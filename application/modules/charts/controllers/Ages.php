<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Ages extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('ages_model');
	}

	function get_age_summary($year=null,$month=null,$toYear=null,$toMonth=null,$county=null,$subCounty=null)
	{
		$data['agesSummary'] = $this->ages_model->ages_summary($year,$month,$toYear,$toMonth,$county,$subCounty);

		$this->load->view('agegroupsummary_view', $data);
	}

	function get_age_positivity($year=null,$month=null,$toYear=null,$toMonth=null,$county=null,$subCounty=null)
	{
		$data['agesPositivity'] = $this->ages_model->ages_positivity($year,$month,$toYear,$toMonth,$county,$subCounty);

		$this->load->view('agegroupspositivity_view', $data);
	}

	function get_age_outcomes($year=null,$month=null,$toYear=null,$toMonth=null,$county=null,$subCounty=null)
	{
		$data['agesOutcomes'] = $this->ages_model->ages_outcomes($year,$month,$toYear,$toMonth,$county,$subCounty);

		$this->load->view('agegroupsoutcomes_view', $data);
	}

	function test($year=null,$month=null,$toYear=null,$toMonth=null,$county=null,$subCounty=null)
	{
		$test = $this->ages_model->get_breakdown_data($year,$month,$toYear,$toMonth,$county,$subCounty);
		print_r($test);
	}
}

?>