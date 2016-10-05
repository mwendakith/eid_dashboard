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

	function partner_sites_outcomes($year=NULL,$month=NULL,$site=NULL,$partner=NULL)
	{
		$table = '';
		$count = 1;
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		$sql = "CALL `proc_get_eid_partner_sites_details`('".$partner."','".$year."','".$month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($sql);die();
		foreach ($result as $key => $value) {
			$table .= '<tr>';
			$table .= '<td>'.$count.'</td>';
			$table .= '<td>'.$value['MFLCode'].'</td>';
			$table .= '<td>'.$value['name'].'</td>';
			$table .= '<td>'.$value['county'].'</td>';
			$table .= '<td>'.$value['tests'].'</td>';
			$table .= '<td>'.$value['eqatests'].'</td>';
			$table .= '<td>'.$value['firstdna'].'</td>';
			$table .= '<td>'.$value['confirmdna'].'</td>';
			$table .= '<td>'.$value['positive'].'</td>';
			$table .= '<td>'.$value['negative'].'</td>';
			$table .= '<td>'.$value['redraw'].'</td>';
			$table .= '<td>'.$value['infantsless2m'].'</td>';
			$table .= '<td>'.$value['infantsless2mpos'].'</td>';
			$table .= '</tr>';
			$count++;
		}
		

		return $table;
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
		
		$data['title'] = "Test Trends (" . $year . ")";
		$data['div'] = "#tests";
		$data['div_name'] = "tests";
		$data['suffix'] = " ";
		$data['yAxis'] = "Number of Tests";

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

		$data['trend'][0]['color'] = '#F2784B';
		$data['trend'][1]['color'] = '#1BA39C';

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

		$data['div'] = "eid_pie";
		$data['content'] = "eid_content";
		$data['title'] = "EID";
		$str = "Total Tests: " . $data['value'][0];
		$str .= "<br />Total Positives: " . $data['trend'][0]['y'] . " <b>(" . $data['value'][1] . "%) </b>";
		$str .= "<br />Total Negatives: " . $data['trend'][1]['y'] . " <b>(" . $data['value'][2] . "%) </b>";
		$str .= "<br />Total Rejected: " . $data['value'][3] . " <b>(" . $data['value'][4] . "%) </b>";
		$data['stats'] = $str;
		

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

		$per = (int) ($result->enrolled + $result->dead + $result->ltfu + $result->transout + $result->adult + $result->other);

		$data['trend'][0]['y'] = (int) $result->enrolled;
		$data['trend'][1]['y'] = (int) $result->dead;
		$data['trend'][2]['y'] = (int) $result->ltfu;
		$data['trend'][3]['y'] = (int) $result->transout;

		$data['trend'][0]['sliced'] = true;
		$data['trend'][0]['selected'] = true;

		$data['trend'][0]['color'] = '#F2784B';
		$data['trend'][1]['color'] = '#1BA39C';
		$data['trend'][2]['color'] = '#5C97BF';

		$data['other'][0] = (int) $result->adult;
		$data['other'][1] = (int) $result->other;

		$data['per'][0] = (int) ($result->enrolled / $per * 100);
		$data['per'][1] = (int) ($result->dead / $per * 100);
		$data['per'][2] = (int) ($result->ltfu / $per * 100);
		$data['per'][3] = (int) ($result->transout / $per * 100);
		$data['per'][4] = (int) ($result->adult / $per * 100);
		$data['per'][5] = (int) ($result->other / $per * 100);

		$str = "Enrolled: " . $data['trend'][0]['y'] . " <b>(" . $data['per'][0] . "%)</b>";
		$str .= "<br />Dead: " . $data['trend'][1]['y'] . " <b>(" . $data['per'][1] . "%)</b>";
		$str .= "<br />Lost to follow up: " . $data['trend'][2]['y'] . " <b>(" . $data['per'][2] . "%)</b>";
		$str .= "<br />Transferred out: " . $data['trend'][3]['y'] . " <b>(" . $data['per'][3] . "%)</b>";
		$str .= "<br />Adults: " . $data['other'][0] . " <b>(" . $data['per'][4] . "%)</b>";
		$str .= "<br />Other: " . $data['other'][1] . " <b>(" . $data['per'][5] . "%)</b>";

		$data['stats'] = $str;


		$data['div'] = "hei_pie";
		$data['content'] = "hei_content";
		$data['title'] = "HEI Follow Up";
		

		return $data;
	}

	
}
?>