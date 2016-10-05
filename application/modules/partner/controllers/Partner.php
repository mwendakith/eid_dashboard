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
		$this->session->set_userdata('county_filter', NULL);
		$this->data['part'] = TRUE;
	}

	function index()
	{
		$this->load->module('charts/summaries');
		
		$this->data['content_view'] = 'partner/partner_summary_view';
		$this -> template($this->data);
	}

	function trends()
	{
		$this->load->module('charts/partnertrends');
		
		$this->data['content_view'] = 'partner/partner_trends_view';
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