<?php
defined("BASEPATH") or exit("No direct script access allowed");

/**
* 
*/
class Trends_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();;
	}

	function yearly_trends($county=NULL){

		if($county == NULL || $county == 48){
			$county = 0;
		}

		$sql = "CALL `proc_get_yearly_tests`(" . $county . ");";

		$result = $this->db->query($sql)->result_array();

		$year = date("Y");
		$i = 0;

		$data;

		foreach ($result as $key => $value) {

			$y = (int) $value['year'];
			if($value['year'] != $year){
				$i++;
				$year--;
			}

			$month = (int) $value['month'];
			$month--;


			$data['test_trends'][$i]['name'] = $value['year'];
			$data['test_trends'][$i]['data'][$month] = (int) $value['tests'];

			$data['rejected_trends'][$i]['name'] = $value['year'];
			$data['rejected_trends'][$i]['data'][$month] = (int) $value['rejected'];


			$data['positivity_trends'][$i]['name'] = $value['year'];
			$data['positivity_trends'][$i]['data'][$month] = (int) $value['positive'];

		}

		return $data;
	}

	function yearly_summary($county=NULL){

		if($county == NULL || $county == 48){
			$county = 0;
		}

		$sql = "CALL `proc_get_yearly_summary`(" . $county . ");";

		$result = $this->db->query($sql)->result_array();

		$year = date("Y");
		$i = 0;

		$data;

		foreach ($result as $key => $value) {

			$data['categories'][$i] = $value['year'];

			$data['outcomes'][0]['name'] = "positive";
			$data['outcomes'][0]['data'][$i] = (int) $value['positive'];


			$data['outcomes'][1]['name'] = "negative";
			$data['outcomes'][1]['data'][$i] = (int) $value['neg'];
			$i++;
		}
		$data['title'] = "Outcomes";

		return $data;
	}




}