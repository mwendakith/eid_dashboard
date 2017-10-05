<?php 
defined('BASEPATH') or exit('No direct script access allowed');

/**
* 
*/
class Positivity extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','highstock','highmaps','highcharts','custom','select2')));
		$this->session->unset_userdata('partner_filter');
		$this->load->module('charts/positivity');
	}

	public function index()
	{
		$this->data['content_view'] = 'positivity/positivity_view';
		// echo "<pre>";print_r($this->data);die();
		$this -> template($this->data);
	}
}

?>