<?php
(defined('BASEPATH') or exit('No direct script access allowed!'));
/**
* 
*/
class Regimens extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('regimen_model');
	}

	function get_regimen_outcomes($year=null,$month=null,$toYear=null,$toMonth=null)
	{
		$data['agesOutcomes'] = $this->regimen_model->regimen_outcomes($year,$month,$toYear,$toMonth);

		$this->load->view('agegroupsoutcomes_view', $data);
	}

	function get_regimen_testing_trends($year=null,$regimen=null)
	{
		$data['trends'] = $this->regimen_model->regimen_testing_trends($year,$regimen);
		$data['div_name'] = "regimen_testing_trends";
		$data['export'] = TRUE;
		$link = $year . '/' . $regimen;

		$data['link'] = base_url('charts/regimens/download_testing_trends/' . $link);

		$this->load->view('trends_outcomes_view', $data);
	}

	function download_testing_trends($year=NULL,$regimen=NULL)
	{
		$this->regimen_model->download_testing_trends($year,$regimen);
	}

	function get_regimen_breakdown($year=null,$month=null,$to_year=null,$to_month=null,$regimen=null,$county=null,$subcounty=null,$partner=null)
	{
		$data['outcomes'] = $this->regimen_model->get_regimen_breakdown($year,$month,$to_year,$to_month,$regimen,$county,$subcounty,$partner);

		$this->load->view('breakdown_listing', $data);
	}

	function get_counties_regimen($year=null,$month=null,$to_year=null,$to_month=null,$regimen=null)
	{
		$data['trends'] = $this->regimen_model->get_regimen_counties($year,$month,$to_year,$to_month,$regimen);

		$data['div_name'] = "counties_regimenbreakdown";

		$this->load->view('trends_outcomes_view', $data);
	}
}
?>