<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Positivity_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();
	}

	function notification_bar($year=NULL,$month=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}

		$data['year'] = $year;
		$data['month'] = '';

		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}else {
			$data['month'] = ' as of '.$this->resolve_month($month);
		}

		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}else {
			$data['month'] .= ' to '.$this->resolve_month($to_month).' of '.$to_year;
		}

		if ($county==null || $county=='null') {
			$sql = "CALL `proc_get_national_positivity_notification`('".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_county_positivity_notification`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
			// $data['county'] = $county;
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		
		foreach ($result as $key => $value) {
			$data['rate'] = (int) $value['positivity_rate'];
			$data['sustxfail'] = number_format((int) $value['positive']);
			if ((int) $value['positivity_rate']=0) {
				$data['color'] = '#E4F1FE';
			} else if ($value['positivity_rate']>0 && $value['positivity_rate']<10) {
				$data['color'] = '#E4F1FE';
			} else if($value['positivity_rate']>=10 && $value['positivity_rate']<50) {
				$data['color'] = '#E4F1FE';
			} else if($value['positivity_rate']>=50 && $value['positivity_rate']<90) {
				$data['color'] = '#E4F1FE';
			} else if($value['positivity_rate']>=90 && $value['positivity_rate']<100) {
				$data['color'] = '#E4F1FE';
			}
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function age($year=NULL,$month=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}

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

		
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_eid_national_age_positivity`('".$year."','".$month."','".$to_year."','".$to_month."')";
			} else {
				$sql = "CALL `proc_get_eid_county_age_positivity`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
			}
		 // echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();

		$data['positivity'][0]['name'] = 'Positives';
		$data['positivity'][1]['name'] = 'Negatives';

		$count = 0;
		
		$data["positivity"][0]["data"][0]	= $count;
		$data["positivity"][1]["data"][0]	= $count;
		$data['categories'][0]				= 'No Data';
		$data['categories'][1]				= '< 2 Weeks';
		$data['categories'][2]				= '2 - 6 Weeks';
		$data['categories'][3]				= '6 - 8 Weeks';
		$data['categories'][4]				= '6 Months';
		$data['categories'][5]				= '9 Months';
		$data['categories'][6]				= '12 Months';

		foreach ($result as $key => $value) {
			$data["positivity"][0]["data"][0]	=  (int) $value['nodatapos'];
			$data["positivity"][1]["data"][0]	=  (int) $value['nodataneg'];
			$data["positivity"][0]["data"][1]	=  (int) $value['less2wpos'];
			$data["positivity"][1]["data"][1]	=  (int) $value['less2wneg'];
			$data["positivity"][0]["data"][2]	=  (int) $value['twoto6wpos'];
			$data["positivity"][1]["data"][2]	=  (int) $value['twoto6wneg'];
			$data["positivity"][0]["data"][3]	=  (int) $value['sixto8wpos'];
			$data["positivity"][1]["data"][3]	=  (int) $value['sixto8wneg'];
			$data["positivity"][0]["data"][4]	=  (int) $value['sixmonthpos'];
			$data["positivity"][1]["data"][4]	=  (int) $value['sixmonthneg'];
			$data["positivity"][0]["data"][5]	=  (int) $value['ninemonthpos'];
			$data["positivity"][1]["data"][5]	=  (int) $value['ninemonthneg'];
			$data["positivity"][0]["data"][6]	=  (int) $value['twelvemonthpos'];
			$data["positivity"][1]["data"][6]	=  (int) $value['twelvemonthneg'];
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}


	function iprophylaxis($year=NULL,$month=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}

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

		if ($county==null || $county=='null') {
			$sql = "CALL `proc_get_eid_national_iproph_positivity`('".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_eid_county_iproph_positivity`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();

		$data['positivity'][0]['name'] = 'Positives';
		$data['positivity'][1]['name'] = 'Negatives';

		$count = 0;
		
		$data["positivity"][0]["data"][0]	= $count;
		$data["positivity"][1]["data"][0]	= $count;
		$data['categories'][0]					= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data["positivity"][0]["data"][$key]	=  (int) $value['pos'];
			$data["positivity"][1]["data"][$key]	=  (int) $value['neg'];
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function mprophylaxis($year=NULL,$month=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}

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

		if ($county==null || $county=='null') {
			$sql = "CALL `proc_get_eid_national_mproph_positivity`('".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_eid_county_mproph_positivity`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();

		$data['positivity'][0]['name'] = 'Positives';
		$data['positivity'][1]['name'] = 'Negatives';

		$count = 0;
		
		$data["positivity"][0]["data"][0]	= $count;
		$data["positivity"][1]["data"][0]	= $count;
		$data['categories'][0]					= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data["positivity"][0]["data"][$key]	=  (int) $value['pos'];
			$data["positivity"][1]["data"][$key]	=  (int) $value['neg'];
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function entryPoint($year=NULL,$month=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}

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

		if ($county==null || $county=='null') {
			$sql = "CALL `proc_get_eid_national_entryP_positivity`('".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_eid_county_entryP_positivity`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();

		$data['positivity'][0]['name'] = 'Positives';
		$data['positivity'][1]['name'] = 'Negatives';

		$count = 0;
		
		$data["positivity"][0]["data"][0]	= $count;
		$data["positivity"][1]["data"][0]	= $count;
		$data['categories'][0]					= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data["positivity"][0]["data"][$key]	=  (int) $value['pos'];
			$data["positivity"][1]["data"][$key]	=  (int) $value['neg'];
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function county_listings($year=NULL,$month=NULL,$county=NULL,$to_year=NULL,$to_month=null)
	{
		$li = '';
		$table = '';
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}

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

		$sql = "CALL `proc_get_eid_counties_positivity_stats`('".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

		// echo "<pre>";print_r($result);die();
		$count = 1;
		$listed = FALSE;

		if($result)
		{
			foreach ($result as $key => $value)
			{
				if ($count<16) {
					$li .= '<a href="javascript:void(0);" class="list-group-item" ><strong>'.$count.'.</strong>&nbsp;'.$value['name'].':&nbsp;'.round($value['pecentage'],1).'%</a>';
				}
					$table .= '<tr>';
					$table .= '<td>'.$count.'</td>';
					$table .= '<td>'.$value['name'].'</td>';
					$table .= '<td>'.round($value['pecentage'],1).'%</td>';
					$table .= '</tr>';
					$count++;
			}
		}else{
			$li = 'No Data';
		}
		
		$data = array(
						'ul' => $li,
						'table' => $table);
		return $data;
	}

	function subcounty_listings($year=null,$month=null,$county=null,$to_year=NULL,$to_month=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}

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
		if ($county==null || $county=='null') {
			$sql = "CALL `proc_get_eid_nat_subcounties_positivity`('".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_eid_county_subcounties_positivity`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$li = '';
		$table = '';
		$count = 1;
		if($result)
			{
				foreach ($result as $key => $value) {
					if ($count<16) {
						$li .= '<a href="#" class="list-group-item"><strong>'.$count.'.</strong>&nbsp;'.$value['name'].'.&nbsp;'.(int) $value['pecentage'].'%</a>';
					}
					$table .= '<tr>';
					$table .= '<td>'.$count.'</td>';
					$table .= '<td>'.$value['name'].'</td>';
					$table .= '<td>'.(int) $value['pecentage'].'%</td>';
					$table .= '</tr>';
					$count++;
				}
			}else{
				$li = 'No Data';
			}

		$data = array(
					'ul' => $li,
					'table' => $table);
		return $data;
	}

	function partners($year=null,$month=null,$county=null,$to_year=NULL,$to_month=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}

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
		if ($county==null || $county=='null') {
			$sql = "CALL `proc_get_eid_nat_partner_positivity`('".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_eid_county_partner_positivity`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$li = '';
		$table = '';
		$count = 1;
		if($result)
			{
				foreach ($result as $key => $value) {
					if ($count<16) {
						$li .= '<a href="#" class="list-group-item"><strong>'.$count.'.</strong>&nbsp;'.$value['name'].'.&nbsp;'.(int) $value['pecentage'].'%</a>';
					}
					$table .= '<tr>';
					$table .= '<td>'.$count.'</td>';
					$table .= '<td>'.$value['name'].'</td>';
					$table .= '<td>'.(int) $value['pecentage'].'%</td>';
					$table .= '</tr>';
				$count++;
				}
			}else{
				$li = 'No Data';
			}

		$data = array(
					'ul' => $li,
					'table' => $table);
		return $data;
	}

	function facility_listing($year=null,$month=null,$county=NULL,$to_year=NULL,$to_month=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}

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

		
		if ($county==null || $county=='null') {
			$sql = "CALL `proc_get_eid_sites_positivity`('".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_eid_county_sites_positivity`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$li = '';
		$table = '';
		$count = 1;
		if($result)
			{
				
				foreach ($result as $key => $value) {
					if ($count<16) {
						$li .= '<a href="#" class="list-group-item"><strong>'.$count.'.</strong>&nbsp;'.$value['name'].'.&nbsp;'.(int) $value['positivity'].'%</a>';
					}
					$table .= '<tr>';
					$table .= '<td>'.$count.'</td>';
					$table .= '<td>'.$value['name'].'</td>';
					$table .= '<td>'.(int) $value['positivity'].'%</td>';
					$table .= '</tr>';
					$count++;
				}
			}else{
				$li = 'No Data';
			}
			$data = array(
						'ul' => $li,
						'table' => $table);
		return $data;
	}

	function county_positivities($year=null,$month=null,$county=NULL,$to_year=NULL,$to_month=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}

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

		$sql = "CALL `proc_get_eid_counties_positivity_stats`('".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();

		$data['positivity'][0]['name'] = 'Positives';
		$data['positivity'][1]['name'] = 'Negatives';

		$count = 0;
		
		$data["positivity"][0]["data"][0]	= $count;
		$data["positivity"][1]["data"][0]	= $count;
		$data['categories'][0]					= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data["positivity"][0]["data"][$key]	=  (int) $value['pos'];
			$data["positivity"][1]["data"][$key]	=  (int) $value['neg'];
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}
}
?>