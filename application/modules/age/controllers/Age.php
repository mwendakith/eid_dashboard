<?php
defined('BASEPATH') or exit('No direct script acces allowed!');
 /**
 * 
 */
 class Age extends MY_Controller
 {
 	
 	function __construct()
 	{
 		parent:: __construct();
 		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','highstock','highmaps','highcharts','custom','select2','tablecloth')));
 		$this->load->module('charts/ages');
 	}

 	function index()
 	{
 		$this->data['content_view'] = 'age/age_view';
		// echo "<pre>";print_r($this->data);die();
		$this -> template($this->data);
 	}
 }
?> 