<?php
/**
* 
*/
class County extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->data	=	array_merge($this->data, $this->load_libraries(array('material','custom', 'Kenya', 'tablecloth', 'select2')));
		$this->session->set_userdata('partner_filter', NULL);
		$this->load->module('charts/counties');

	}

	public function index()
	{
		$this->clear_all_session_data();
		$this->load->module('charts/summaries');
		$this->data['content_view'] = 'county/county_view';
		$this -> template($this->data);
	}

	public function subCounty()
	{
		$this->load->module('charts/subcounties');
		$this->data['sub_county'] = TRUE;
		$this->clear_all_session_data();
		$this->data['content_view'] = 'county/subCounty_view';
		// echo "<pre>";print_r($this->data);die();
		$this->template($this->data);
	}

	public function countyMap()
	{
		$this->data['content_view'] = 'county/county_map';
		$this -> template($this->data);
	}

	public function check_county_select()
	{
		if ($this->session->userdata('county_filter')) {
			$county = $this->session->userdata('county_filter');
		} else {
			$county = 0;
		}
		echo json_encode($county);
	}


	public function tat()
	{
		$this->clear_all_session_data();
		$this->load->module('charts/counties');
		$this->data['content_view'] = 'county/counties_tat_view';
		$this->template($this->data);
	}

	public function subCountytat()
	{
		$this->clear_all_session_data();
		$this->data['sub_county'] = TRUE;
		$this->data['content_view'] = 'county/subcounty_tat_view';

		$this->template($this->data);
	}

	public function check_subcounty_select()
	{
		if ($this->session->userdata('sub_county_filter')) {
			$subcounty = $this->session->userdata('sub_county_filter');
		} else {
			$subcounty = 0;
		}
		echo $subcounty;
	}
}
?>