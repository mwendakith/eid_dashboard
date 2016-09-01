<?php
/**
* 
*/
class Positivity extends MY_Controller
{
	
	public $data = array();

	function __construct()
	{
		parent:: __construct();
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','highstock','highmaps','highcharts','custom','select2')));
		$this->session->set_userdata('partner_filter', NULL);
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