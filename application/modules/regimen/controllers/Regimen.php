<?php
(defined('BASEPATH') OR exit('No direct script access allowed'));


class Regimen extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','highstock','highmaps','highcharts','custom','select2')));
 		$this->load->module('charts/regimens');
 		$this->data['reg'] = TRUE;
	}

	function index()
	{
		$this->clear_all_session_data();
 		$this->data['content_view'] = 'regimen/regimen_view';
		echo "<pre>";print_r($this->data);die();
		$this -> template($this->data);
	}

	function check_Regimen()
 	{
 		if ($this->session->userdata('regimen_filter')) {
 			echo $this->session->userdata('regimen_filter');
 		} else {
 			echo 0;
 		}
 	}
}
?>