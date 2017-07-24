<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Positivity extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('positivity_model');
	}

	function notification ($year=NULL,$month=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['suppressions'] = $this->positivity_model->notification_bar($year,$month,$county,$to_year,$to_month);

		$this->load->view('sup_notification_view',$data);
	}

	function age($year=NULL,$month=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['suppressions'] = $this->positivity_model->age($year,$month,$county,$to_year,$to_month);
		$data['div'] = 'age_positivity';

		$this->load->view('positivity_view',$data);
	}

	function i_prophylaxis($year=NULL,$month=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['suppressions'] = $this->positivity_model->iprophylaxis($year,$month,$county,$to_year,$to_month);
		$data['div'] = 'iproph_positivity';

		$this->load->view('positivity_view',$data);
	}

	function m_prophylaxis($year=NULL,$month=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['suppressions'] = $this->positivity_model->mprophylaxis($year,$month,$county,$to_year,$to_month);
		$data['div'] = 'mproph_positivity';

		$this->load->view('positivity_view',$data);
	}

	function entry_point($year=NULL,$month=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['suppressions'] = $this->positivity_model->entryPoint($year,$month,$county,$to_year,$to_month);
		$data['div'] = 'entry_point';

		$this->load->view('positivity_view',$data);
	}

	function counties($year=NULL,$month=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['countys'] = $this->positivity_model->county_listings($year,$month,$to_year,$to_month);

		$this->load->view('county_listings',$data);
	}

	function subCounties($year=NULL,$month=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['subCounty'] = $this->positivity_model->subcounty_listings($year,$month,$county,$to_year,$to_month);

		$this->load->view('sup_subcounty_listing',$data);
	}

	function facilites($year=NULL,$month=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['facilities'] = $this->positivity_model->facility_listing($year,$month,$county,$to_year,$to_month);

		$this->load->view('site_listings',$data);
	}

	function partners($year=NULL,$month=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['partners'] = $this->positivity_model->partners($year,$month,$county,$to_year,$to_month);

    	$this->load->view('sup_partner_listing',$data);
	}

	function county_outcomes($year=NULL,$month=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['suppressions'] = $this->positivity_model->county_positivities($year,$month,$county,$to_year,$to_month);
		$data['div'] = 'county_positivity';

		$this->load->view('positivity_view',$data);

	}

	function county_mixed($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['trends'] = $this->positivity_model->county_mixed($year,$month,$to_year,$to_month);
		$data['div_name'] = 'county_mixed';

		$this->load->view('trends_outcomes_view',$data);

	}


}
?>