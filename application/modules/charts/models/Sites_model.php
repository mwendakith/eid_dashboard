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


	function sites_outcomes($year=null,$month=null,$site=null,$partner=null)
	{
		if (!$partner) {
			$partner = $this->session->userdata('partner_filter');
		}
		
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

		if ($partner) {
			$sql = "CALL `proc_get_partner_sites_outcomes`('".$partner."','".$year."','".$month."')";
		} else if ($site) {
			$sql = "CALL `proc_get_partner_outcomes`('".$year."','".$month."')";
		} else {
			$sql = "CALL `proc_get_all_sites_outcomes`('".$year."','".$month."')";
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$data['sites_outcomes'][0]['name'] = 'Not Suppresed';
		$data['sites_outcomes'][1]['name'] = 'Suppresed';

		$count = 0;
		
		$data["sites_outcomes"][0]["data"][0]	= $count;
		$data["sites_outcomes"][1]["data"][0]	= $count;
		$data['categories'][0]					= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data["sites_outcomes"][0]["data"][$key]	=  (int) $value['nonsuppressed'];
			$data["sites_outcomes"][1]["data"][$key]	=  (int) $value['suppressed'];
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
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}

		$sql = "CALL `proc_get_partner_sites_details`('".$partner."','".$year."','".$month."')";
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
			$table .= '<td>'.$value['sustxfail'].'</td>';
			$table .= '<td>'.$value['repeatvl'].'</td>';
			$table .= '<td>'.$value['confirmtx'].'</td>';
			$table .= '<td>'.$value['rejected'].'</td>';
			$table .= '<td>'.$value['adults'].'</td>';
			$table .= '<td>'.$value['paeds'].'</td>';
			$table .= '<td>'.$value['maletest'].'</td>';
			$table .= '<td>'.$value['femaletest'].'</td>';
			$table .= '</tr>';
			$count++;
		}
		

		return $table;
	}

	
}
?>