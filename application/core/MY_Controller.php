<?php
if(!defined("BASEPATH")) exit("No direct script access allowed!");
	/**
	* 
	*/
	class MY_Controller extends MX_Controller
	{
		public $data = array();
		function __construct()
		{
			parent:: __construct();

			if($this->config->item('maintenance_mode') && $this->config->item('maintenance_mode') == TRUE){
				// $this->load->view('maintenance_view');
				echo "We are undergoing maintenance. We apologise for the inconvenience.";							
				die();
			}
			
			$this->initialize_filter();
			$this->data['part'] = FALSE;
			$this->data['labs'] = FALSE;
			$this->data['sit'] = FALSE;
			$this->data['county'] = FALSE;
			$this->data['contacts'] = FALSE;
			$this->data['sub_county'] = FALSE;
			$this->data['age'] = FALSE;
			$this->data['reg'] = FALSE;
			$this->session->unset_userdata('filter_month');
		}

		public function load_libraries($arr){

<<<<<<< HEAD
			array_unshift($arr, "jquery", "jquery-ui","bootstrap");
=======
			array_unshift($arr, "jquery", "jquery-ui","bootstrap","datatables");
>>>>>>> 6f706d757719ba85748ebde050471e61e5ec9556
					
			$libs['js_files']				=	array();		
			$libs['css_files']				=	array();			
			$libs['js_plugin_files']		=	array();
			$libs['css_plugin_files']		=	array();

			$asset_path		=	$this->config->item('asset_path');

			$css_path		=	$this->config->item('asset_path');
			$js_path		=	$this->config->item('js_path');
			$plugin_path	=	$this->config->item('plugin_path');

			$all_css		=	$this->config->item('css_files');
			$all_js			=	$this->config->item('js_files');
			$all_plugin_css	=	$this->config->item('plugin_css_files');
			$all_plugin_js	=	$this->config->item('plugin_js_files');
			//load css
			foreach ($arr as $css) {
				foreach($all_css as $all){
					if($css==$all['title']){
						$libs['css_files']			=	array_merge($libs['css_files'],array($all['file']));
					}
				}
			}
			//load js
			foreach ($arr as $js) {
				foreach($all_js as $all){
					if($js==$all['title']){
						$libs['js_files']			=	array_merge($libs['js_files'],array($all['file']));
					}
				}
			}
			//load plugin css
			foreach ($arr as $css) {
				foreach($all_plugin_css as $all){
					if($css==$all['title']){
						$libs['css_plugin_files']	=	array_merge($libs['css_plugin_files'],array($all['file']));
					}
				}
			}
			//load plugin js
			foreach ($arr as $js) {
				foreach($all_plugin_js as $all){
					if($js==$all['title']){
						$libs['js_plugin_files']	=	array_merge($libs['js_plugin_files'],array($all['file']));

					}
				}
			}	
			return 	$libs;
		}

		function clear_all_session_data()
		{
			$filter_data = array(
								'county_filter',
								'sub_county_filter',
								'partner_filter',
								'site_filter',
								'filter_year',
								'filter_month',
								'age_filter',
<<<<<<< HEAD
								'regimen_filter'
=======
								'regimen_filter',
								'funding_agency_filter'
>>>>>>> 6f706d757719ba85748ebde050471e61e5ec9556
								);
			$this->session->unset_userdata($filter_data);
		}

		function initialize_filter()
		{
			if(!(null !== $this->session->userdata('filter_year')))
			{
				$filter_data = array(
								'county_filter' => null,
								'sub_county_filter' => null,
								'partner_filter' => null,
								'site_filter' => null,
								'filter_year' => Date('Y'),
								'filter_month' => null,
								'age_filter' => null,
								'regimen_filter' => null
								);
				$this->session->set_userdata($filter_data);
			}
		}

		function set_filter_date($data=null)
		{
<<<<<<< HEAD
			// echo "<pre";print_r($data);die();
			$year = $data['year'];
			$month = $data['month'];

=======
			$year = $data['year'];
			$month = $data['month'];
			
>>>>>>> 6f706d757719ba85748ebde050471e61e5ec9556
			if ($year) {
				$this->session->unset_userdata('filter_month');
				$return = $this->session->set_userdata('filter_year', $year);
				$this->session->unset_userdata('filter_month');
			} else {
<<<<<<< HEAD
				$return = $this->session->set_userdata('filter_month', $month);
=======
				if ($month=='all') {
					$this->session->unset_userdata('filter_month');
				}else {
					$this->session->set_userdata('filter_month', $month);
				}
>>>>>>> 6f706d757719ba85748ebde050471e61e5ec9556
			}
			$this->load->model('template/template_model');
			if(!$year)
				$year = $this->session->userdata('filter_year');
			if(!$month)
				$month = $this->session->userdata('filter_month');
			
			echo json_encode(array('year' => $year, 'prev_year' => $year-1, 'month' => $this->template_model->resolve_month($month), 'monthNo' => $month ));
		}

		function template($data)
		{
			$this -> load -> module('template');
			$this -> template ->load_template($data);
		}

		function filter_regions($data=NULL)
		{
			if (!$data) {//if $data is null
				
			} else {//if data is not null
				if ($data['county']==48||$data['county']=='NA') {
					$this->clear_all_session_data();
				}else{
					$this->session->set_userdata('county_filter', $data['county']);
					$this->session->unset_userdata('sub_county_filter');
					$this->session->set_userdata('filter_month', null);
					$this->session->set_userdata('partner_filter', null);
					$this->session->unset_userdata('site_filter');
					$this->session->unset_userdata('age_filter');
<<<<<<< HEAD
=======
					$this->session->unset_userdata('funding_agency_filter');
				}
			}
			
			return TRUE;
		}

		function filter_sub_county($data=NULL)
		{
			if (!$data) {//if $data is null
				
			} else {//if data is not null
				if ($data['sub_county']==0||$data['sub_county']=='NA') {
					$this->clear_all_session_data();
				}else{
					$this->session->unset_userdata('county_filter');
					$this->session->set_userdata('sub_county_filter', $data['sub_county']);
					$this->session->unset_userdata('filter_month');
					$this->session->unset_userdata('partner_filter');
					$this->session->unset_userdata('site_filter');
					$this->session->unset_userdata('age_filter');
					$this->session->unset_userdata('regimen_filter');
					$this->session->unset_userdata('funding_agency_filter');
>>>>>>> 6f706d757719ba85748ebde050471e61e5ec9556
				}
			}
			
			return TRUE;
		}

<<<<<<< HEAD
		function filter_sub_county($data=NULL)
		{
			if (!$data) {//if $data is null
				
			} else {//if data is not null
				if ($data['sub_county']==0||$data['sub_county']=='NA') {
					$this->clear_all_session_data();
				}else{
					$this->session->unset_userdata('county_filter');
					$this->session->set_userdata('sub_county_filter', $data['sub_county']);
					$this->session->unset_userdata('filter_month');
					$this->session->unset_userdata('partner_filter');
					$this->session->unset_userdata('site_filter');
					$this->session->unset_userdata('age_filter');
					$this->session->unset_userdata('regimen_filter');
				}
			}
			
			return TRUE;
		}

=======
>>>>>>> 6f706d757719ba85748ebde050471e61e5ec9556
		function filter_partners($data=NULL)
		{
			if (!$data) {
				
			} else {
				if ($data['partner']=='NA') {
					$this->session->unset_userdata('partner_filter');
					$this->session->unset_userdata('sub_county_filter');
					$this->session->unset_userdata('filter_month');
					$this->session->unset_userdata('county_filter');
					$this->session->unset_userdata('site_filter');
					$this->session->unset_userdata('age_filter');
					$this->session->unset_userdata('regimen_filter');
<<<<<<< HEAD
=======
					$this->session->unset_userdata('funding_agency_filter');
>>>>>>> 6f706d757719ba85748ebde050471e61e5ec9556
				}else{
					$this->session->set_userdata('partner_filter', $data['partner']);
					$this->session->unset_userdata('sub_county_filter');
					$this->session->unset_userdata('filter_month');
					$this->session->unset_userdata('county_filter');
					$this->session->unset_userdata('site_filter');
					$this->session->unset_userdata('age_filter');
					$this->session->unset_userdata('regimen_filter');
<<<<<<< HEAD
=======
					$this->session->unset_userdata('funding_agency_filter');
>>>>>>> 6f706d757719ba85748ebde050471e61e5ec9556
				}
			}
			
			return TRUE;
		}

		function filter_site($data=null)
		{

			if (!$data) {
				
			} else {
				if ($data['site']=='NA') {
					$this->session->unset_userdata('site_filter');
					$this->session->set_userdata('partner_filter', null);
					$this->session->set_userdata('filter_month', null);
					$this->session->set_userdata('county_filter', null);
					$this->session->unset_userdata('sub_county_filter');
					$this->session->unset_userdata('age_filter');
					$this->session->unset_userdata('regimen_filter');
<<<<<<< HEAD
=======
					$this->session->unset_userdata('funding_agency_filter');
>>>>>>> 6f706d757719ba85748ebde050471e61e5ec9556
				}else{
					$this->session->set_userdata('site_filter', $data['site']);
					$this->session->set_userdata('partner_filter', null);
					$this->session->set_userdata('filter_month', null);
					$this->session->set_userdata('county_filter', null);
					$this->session->unset_userdata('sub_county_filter');
					$this->session->unset_userdata('age_filter');
					$this->session->unset_userdata('regimen_filter');
<<<<<<< HEAD
=======
					$this->session->unset_userdata('funding_agency_filter');
				}
			}
			// print_r($this->session->all_userdata());die();
			return TRUE;
		}

		function filter_age($data=null)
		{
			if (!$data) {
				# code...
			} else {
				if ($data['age'] == '0' || $data['age'] == 0) {
					$this->session->unset_userdata('age_filter');
					$this->session->unset_userdata('site_filter');
					$this->session->unset_userdata('partner_filter');
					$this->session->unset_userdata('filter_month');
					$this->session->unset_userdata('county_filter');
					$this->session->unset_userdata('sub_county_filter');
					$this->session->unset_userdata('regimen_filter');
					$this->session->unset_userdata('funding_agency_filter');
				} else {
					$this->session->set_userdata('age_filter', $data['age']);
					$this->session->unset_userdata('site_filter');
					$this->session->unset_userdata('partner_filter');
					$this->session->unset_userdata('filter_month');
					$this->session->unset_userdata('county_filter');
					$this->session->unset_userdata('sub_county_filter');
					$this->session->unset_userdata('regimen_filter');
					$this->session->unset_userdata('funding_agency_filter');
				}
				
			}

			return TRUE;
		}

		function filter_regimen($data=null)
		{
			if (!$data) {
				# code...
			} else {
				if ($data['regimen'] == '48' || $data['regimen'] == 48) {
					$this->session->unset_userdata('regimen_filter');
					$this->session->unset_userdata('age_filter');
					$this->session->unset_userdata('site_filter');
					$this->session->unset_userdata('partner_filter');
					$this->session->unset_userdata('filter_month');
					$this->session->unset_userdata('county_filter');
					$this->session->unset_userdata('sub_county_filter');
					$this->session->unset_userdata('funding_agency_filter');
				} else {
					$this->session->set_userdata('regimen_filter', $data['regimen']);
					$this->session->unset_userdata('age_filter');
					$this->session->unset_userdata('site_filter');
					$this->session->unset_userdata('partner_filter');
					$this->session->unset_userdata('filter_month');
					$this->session->unset_userdata('county_filter');
					$this->session->unset_userdata('sub_county_filter');
					$this->session->unset_userdata('funding_agency_filter');
				}
				
			}

			return TRUE;
		}

		function filter_funding_agency($data=NULL) {
			$session_data = $this->session->all_userdata();
			
			if(!$data){}
			else {
				if ($data['funding_agency'] == 'NA') {
					foreach ($session_data as $key => $value) {
				        if (!($key == 'filter_year' || $key == '__ci_last_regenerate'))
				            $this->session->unset_userdata($key);
				    }
				} else {
					$this->session->set_userdata('funding_agency_filter', $data['funding_agency']);
					foreach ($session_data as $key => $value) {
						if (!($key == 'filter_year' || $key == 'funding_agency_filter' || $key == '__ci_last_regenerate'))
				            $this->session->unset_userdata($key);
				    }
>>>>>>> 6f706d757719ba85748ebde050471e61e5ec9556
				}
			}
			// print_r($this->session->all_userdata());die();
			return TRUE;
		}

		function filter_age($data=null)
		{
			if (!$data) {
				# code...
			} else {
				if ($data['age'] == '0' || $data['age'] == 0) {
					$this->session->unset_userdata('age_filter');
					$this->session->unset_userdata('site_filter');
					$this->session->unset_userdata('partner_filter');
					$this->session->unset_userdata('filter_month');
					$this->session->unset_userdata('county_filter');
					$this->session->unset_userdata('sub_county_filter');
					$this->session->unset_userdata('regimen_filter');
				} else {
					$this->session->set_userdata('age_filter', $data['age']);
					$this->session->unset_userdata('site_filter');
					$this->session->unset_userdata('partner_filter');
					$this->session->unset_userdata('filter_month');
					$this->session->unset_userdata('county_filter');
					$this->session->unset_userdata('sub_county_filter');
					$this->session->unset_userdata('regimen_filter');
				}
				
			}

			return TRUE;
		}

		function filter_regimen($data=null)
		{
			if (!$data) {
				# code...
			} else {
				if ($data['regimen'] == '48' || $data['regimen'] == 48) {
					$this->session->unset_userdata('regimen_filter');
					$this->session->unset_userdata('age_filter');
					$this->session->unset_userdata('site_filter');
					$this->session->unset_userdata('partner_filter');
					$this->session->unset_userdata('filter_month');
					$this->session->unset_userdata('county_filter');
					$this->session->unset_userdata('sub_county_filter');
				} else {
					$this->session->set_userdata('regimen_filter', $data['regimen']);
					$this->session->unset_userdata('age_filter');
					$this->session->unset_userdata('site_filter');
					$this->session->unset_userdata('partner_filter');
					$this->session->unset_userdata('filter_month');
					$this->session->unset_userdata('county_filter');
					$this->session->unset_userdata('sub_county_filter');
				}
				
			}

			return TRUE;
		}

		function display_time_period()
		{
			$display = array('year' => $this->session->userdata('filter_year'), 'month' => $this->session->userdata('filter_month') );

			echo json_encode($display);
		}

		
	}
?>
