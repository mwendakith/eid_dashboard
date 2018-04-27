<?php
(defined('BASEPATH') or exit('No direct script access allowed!'));

/**
* 
*/
class Hei_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();
	}

	function validation($year=null, $month=null, $to_year=null, $to_month=null, $type=null, $id=null)
	{
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
		if ($type==null || $type=='null') $type = 0;
		if ($type == 0 || $type == '0') {
			if (null !== $this->session->userdata('county_filter')) $id = $this->session->userdata('county_filter');
		} else if ($type == 1 || $type == '1') {
			if (null !== $this->session->userdata('partner_filter')) $id = $this->session->userdata('partner_filter');
		} else if ($type == 2 || $type == '2') {
			if (null !== $this->session->userdata('sub_county_filter')) $id = $this->session->userdata('sub_county_filter');
		} else if ($type == 3 || $type == '3') {
			if (null !== $this->session->userdata('site_filter')) $id = $this->session->userdata('site_filter');
		}
	
		if ($id==null || $id=='null') $id = 0;
		$id = 0;
		$sql = "CALL `proc_get_eid_hei_validation`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$id."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result();
		// echo "<pre>";print_r($result);die();
		$count = 1;
		$table = '';
		foreach ($result as $key => $value) {
			$followup_percentage = round(@($value->Followup_Hei/$value->positives)*100,1);
			$confirmed_percentage = round(@($value->Confirmed_Positive/$value->Followup_Hei)*100,1);
			$table .= '<tr>';
			$table .= '<td>'.$count.'</td>';
			$table .= '<td>'.$value->name.'</td>';
			$table .= '<td>'.number_format($value->positives).'</td>';
			$table .= '<td>'.number_format($value->Followup_Hei).'</td>';
			$table .= '<td>'.$followup_percentage.'%</td>';
			$table .= '<td>'.number_format($value->Confirmed_Positive).'</td>';
			if ($confirmed_percentage > 69) {
				$table .= '<td><span class="alert alert-success" style="color:black;">'.$confirmed_percentage.'%</span></td>';
			} else if ($confirmed_percentage < 70 && $confirmed_percentage > 39) {
				$table .= '<td><span class="alert alert-warning" style="color:black;">'.$confirmed_percentage.'%</span></td>';
			} else {
				$table .= '<td><span class="alert alert-danger" style="color:black;">'.$confirmed_percentage.'%</span></td>';
			}
			$table .= '<td>'.number_format($value->enrolled).'</td>';
			$table .= '<td>'.number_format($value->ltfu).'</td>';
			$table .= '<td>'.number_format($value->adult).'</td>';
			$table .= '<td>'.number_format($value->transout).'</td>';
			$table .= '<td>'.number_format($value->dead).'</td>';
			$table .= '<td>'.number_format($value->other).'</td>';
			$table .= '</tr>';
			$count++;
		}
		return $table;
	}
}

?>