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
 		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','custom','select2','tablecloth')));
 		$this->load->module('charts/ages');
 		$this->data['age'] = TRUE;
 	}

 	function index()
 	{
 		$this->clear_all_session_data();
 		$this->data['content_view'] = 'age/age_view';
		// echo "<pre>";print_r($this->data);die();
		$this -> template($this->data);
 	}

 	function check_ageGroup()
 	{
 		if ($this->session->userdata('age_filter')) {
 			echo $this->session->userdata('age_filter');
 		} else {
 			echo 0;
 		}
 	}

 	function test1(){
 		$this->data['content_view'] = 'age/testv1';
 		$this->template($this->data);
 	}
 	function test2(){
 		$this->data['content_view'] = 'age/testv2';
 		$this->template($this->data);
 	}
 }
?> 