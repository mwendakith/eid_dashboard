<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 
 */
class Agencies_model extends MY_Model
{
	
	function __construct() {
		parent:: __construct();
	}


	function positivity($year=null,$month=null,$to_year=null,$to_month=null,$type=null,$agency_id) {
		if ($year==null || $year=='null') 
			$year = $this->session->userdata('filter_year');
		
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		if ($to_month==null || $to_month=='null') 
			$to_month = 0;

		if ($to_year==null || $to_year=='null') 
			$to_year = 0;

		if ($agency_id==null || $agency_id == 'null')
			$agency_id = $this->session->userdata('funding_agency_filter');

		if ($type==null || $type == 'null'){
			$type = 0;
			$agency_id = 0;
		}

		$sql = "CALL `proc_get_eid_agencies_outcomes`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$agency_id."')";

		$result = $this->db->query($sql)->result_array();

		$data['outcomes'][0]['name'] = "Positive";
		$data['outcomes'][1]['name'] = "Negative";
		$data['outcomes'][2]['name'] = "Positivity";
		$data['outcomes'][2]['color'] = '#913D88';

		$data['outcomes'][0]['type'] = "column";
		$data['outcomes'][1]['type'] = "column";
		$data['outcomes'][2]['type'] = "spline";

		$data['outcomes'][0]['yAxis'] = 1;
		$data['outcomes'][1]['yAxis'] = 1;

		$data['outcomes'][0]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][1]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][2]['tooltip'] = array("valueSuffix" => ' %');

		$data['title'] = "";
		
		$data['categories'][0] = 'No Data';
		$data["outcomes"][0]["data"][0]	= 0;
		$data["outcomes"][1]["data"][0]	= 0;
		$data["outcomes"][2]["data"][0]	= 0;

		foreach ($result as $key => $value) {
			
				$data['categories'][$key] = $value['agency'];
				$data["outcomes"][0]["data"][$key]	= (int) $value['positive'];
				$data["outcomes"][1]["data"][$key]	= (int) $value['negative'];
				$data["outcomes"][2]["data"][$key]	= round(@( ((int) $value['positive']*100) /((int) $value['positive']+(int) $value['negative'])),1);
			
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}
}
?>