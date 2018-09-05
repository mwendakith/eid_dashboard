<?php
defined('BASEPATH') or exit('No direct script acces allowed!');
 /**
 * 
 */
 class Rht extends MY_Controller
 {
 	
 	function __construct()
 	{
 		parent:: __construct();
 		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','custom','select2','tablecloth')));
 		$this->load->module('charts/rht');
 	}

 	function index()
 	{
 		$this->data['content_view'] = 'rht/rht_view';
		// echo "<pre>";print_r($this->data);die();
		$this -> template($this->data);
 	}

 	
 }
?> 