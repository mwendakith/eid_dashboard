<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Poc_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();
	}

	function testing_trends($county=null,$year=null,$month=null,$to_year=null,$to_month=null)
	{
		if($county == NULL || $county == 48) $county=0;
		if ($year==null || $year=='null') $year = $this->session->userdata('filter_year');

		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}
		if ($to_month==null || $to_month=='null') $to_month = 0;
		if ($to_year==null || $to_year=='null') $to_year = 0;


		$sql = "CALL `proc_get_eid_poc_trends`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo $sql;die();
		$result = $this->db->query($sql)->result_array();

		$data['outcomes'][0]['name'] = "Other PCRs";
		$data['outcomes'][1]['name'] = "Initial PCR";
		$data['outcomes'][2]['name'] = "Positivity";
		$data['outcomes'][3]['name'] = "&lt; 2m % Contribution";

		//$data['outcomes'][0]['color'] = '#52B3D9';
		// $data['outcomes'][0]['color'] = '#E26A6A';
		// $data['outcomes'][1]['color'] = '#257766';
		$data['outcomes'][2]['color'] = '#913D88';

		$data['outcomes'][0]['type'] = "column";
		$data['outcomes'][1]['type'] = "column";
		$data['outcomes'][2]['type'] = "spline";
		$data['outcomes'][3]['type'] = "spline";

		$data['outcomes'][0]['yAxis'] = 1;
		$data['outcomes'][1]['yAxis'] = 1;

		$data['outcomes'][0]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][1]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][2]['tooltip'] = array("valueSuffix" => ' %');
		$data['outcomes'][3]['tooltip'] = array("valueSuffix" => ' %');

		$data['title'] = "";
		
		$data['categories'][0] = 'No Data';

		foreach ($result as $key => $value) {
			
				$data['categories'][$key] = $this->resolve_month($value['month']).'-'.$value['year'];
				$data["outcomes"][0]["data"][$key]	= (int) ($value['tests'] - $value['confirmdna']);
				$data["outcomes"][1]["data"][$key]	= (int) $value['confirmdna'];
				$data["outcomes"][2]["data"][$key]	= round(@( ((int) $value['positive']*100) /((int) $value['positive']+(int) $value['negative'])),1);
				$data["outcomes"][3]["data"][$key]	= round(@( ((int) $value['infantsless2m']*100) /((int) $value['tests'])),1);
			
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

}