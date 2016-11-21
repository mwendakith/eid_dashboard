<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sites extends MY_Controller {

	public $data = array();

	function __construct()
	{
		parent:: __construct();
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','highstock','highmaps','highcharts','custom','select2','tablecloth')));
		//$this->session->set_userdata('site_filter', NULL);
		$this->session->set_userdata('partner_filter', NULL);
		$this->data['sit'] = TRUE;
		// $this->initialize_filter();
		$this->load->module('charts/labperformance');
		$this->load->module('charts/sites');
	}

	public function index()
	{
		$this->data['content_view'] = 'sites/sites_view';
		// echo "<pre>";print_r($this->data);die();
		$this -> template($this->data);
	}

	public function check_site_select()
	{
		echo json_encode($this->session->userdata('site_filter'));
	}
}