<?php
defined('BASEPATH') or exit();

/**
* 
*/
class Sites_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();
	}


	function sites_outcomes($year=null,$month=null){

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}

		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}
		$sql = "CALL `proc_get_eid_all_sites_outcomes`('".$year."','".$month."')";

		$result = $this->db->query($sql)->result_array();

		$data['sites_outcomes'][0]['name'] = 'Positive';
		$data['sites_outcomes'][1]['name'] = 'Negative';

		$count = 0;

		$data["sites_outcomes"][0]["data"][0]	= $count;
		$data["sites_outcomes"][1]["data"][0]	= $count;
		$data['categories'][0]					= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data["sites_outcomes"][0]["data"][$key]	=  (int) $value['pos'];
			$data["sites_outcomes"][1]["data"][$key]	=  (int) $value['neg'];
		}
		// echo "<pre>";print_r($data);die();
		return $data;

	}

	function get_trends($site=null, $year=null){

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}

		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}

		
		$sql = "CALL `proc_get_eid_sites_trends`('".$year."','".$site."')";

		$result = $this->db->query($sql)->result_array();

		$data;

		$data['year'] = $year;
		
		$data['trends'][0]['name'] = "Tests";
		$data['trends'][1]['name'] = "Rejected";
		$data['trends'][2]['name'] = "Positives";
		$data['trends'][3]['name'] = "Negatives";

		foreach ($result as $key => $value) {

			$month = (int) $value['month'];
			$month--;


			$data['trends'][0]['data'][$month] = (int) $value['tests'];
			$data['trends'][1]['data'][$month] = (int) $value['rejected'];
			$data['trends'][2]['data'][$month] = (int) $value['pos'];
			$data['trends'][3]['data'][$month] = (int) $value['neg'];
		}

		return $data;
	}


	function get_positivity($site=null, $year=null){

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}

		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}

		
		$sql = "CALL `proc_get_eid_sites_trends`('".$year."','".$site."')";

		$result = $this->db->query($sql)->result_array();

		$data;
		$data['year'] = $year;
				
		foreach ($result as $key => $value) {

			$month = (int) $value['month'];
			$month--;


			$data['trends'][0][$month] = (int) $value['pos'];

			if ($value['pos'] == 0 && $value['neg'] == 0){
				$data['trends'][1][$month] = 0;
			}else{
				$data['trends'][1][$month] = (int) ($value['pos'] / 
					($value['pos'] + $value['neg']) * 100);
			}
		}

		return $data;
	}

	function get_eid($site=null, $year=null, $month=null){

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}

		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}

		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}

		
		$sql = "CALL `proc_get_eid_sites_eid`('".$year."', '".$month."', '".$site."')";

		$result = $this->db->query($sql)->row();

		$data['trend'][0]['name'] = "positive";
		$data['trend'][1]['name'] = "negative";

		$data['trend'][0]['y'] = (int) $result->pos;
		$data['trend'][1]['y'] = (int) $result->neg;

		$data['value'][0] = (int) $result->tests;

		if($result->pos == 0 && $result->neg == 0){
			$data['value'][1] = 0;
			$data['value'][2] = 0;
		}else{
			$data['value'][1] = (int) ($result->pos / ($result->pos + $result->neg) * 100);
			$data['value'][2] = (int) ($result->neg / ($result->pos + $result->neg) * 100);
		}

		$data['value'][3] = (int) $result->rejected;
		if($result->tests == 0){
			$data['value'][4] = 0; 
		}else{
			$data['value'][4] = (int) ($result->rejected / $result->tests * 100);
		}
		

		return $data;
	}

	function get_hei($site=null, $year=null, $month=null){

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}

		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}

		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}

		
		$sql = "CALL `proc_get_eid_sites_hei_follow_up`('".$year."', '".$month."', '".$site."')";

		$result = $this->db->query($sql)->row();

		$data['trend'][0]['name'] = "enrolled";
		$data['trend'][1]['name'] = "dead";
		$data['trend'][2]['name'] = "lost to follow up";
		$data['trend'][3]['name'] = "transferred out";

		$data['trend'][0]['y'] = (int) $result->enrolled;
		$data['trend'][1]['y'] = (int) $result->dead;
		$data['trend'][2]['y'] = (int) $result->ltfu;
		$data['trend'][3]['y'] = (int) $result->transout;
		

		return $data;
	}

	
}
?>