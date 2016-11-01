<?php
defined('BASEPATH') or exit('No direct script access allowed!');
/**
* 
*/
class Partner extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->module('summaries');
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','highstock','highmaps','highcharts','custom','select2','tablecloth')));
		$this->session->unset_userdata('county_filter');
		$this->initialize_filter();
		$this->data['part'] = TRUE;
	}

	function index()
	{
		$this->session->unset_userdata('partner_filter');
		$this->load->module('charts/partner_summaries');
		
		$this->data['content_view'] = 'partner/partner_summary_view';
		$this -> template($this->data);
	}

	function trends()
	{
		$this->session->unset_userdata('partner_filter');
		$this->load->module('charts/partnertrends');
		
		$this->data['content_view'] = 'partner/partner_trends_view';
		$this -> template($this->data);
		
	}

	function sites()
	{
		$this->session->unset_userdata('partner_filter');
		$this->load->module('charts/sites');

		$this->data['content_view'] = 'partner/partner_sites_view';
		// echo "<pre>";print_r($this->data);die();
		$this -> template($this->data);
	}

	public function get_selected_partner()
	{
		if ($this->session->userdata('partner_filter')) {
			$partner = $this->session->userdata('partner_filter');
		} else {
			$partner = 1;
		}
		 echo $partner;
	}

	public function check_partner_select()
	{
		if ($this->session->userdata('partner_filter')) {
			$partner = $this->session->userdata('partner_filter');
		} else {
			$partner = 0;
		}
		echo json_encode($partner);
	}
}
?>