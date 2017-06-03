<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Ages_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();
	}

	function ages_summary($year=null,$month=null,$toYear=null,$toMonth=null,$county=null,$subCounty=null){
		$result = $this->get_summary_data($year,$month,$toYear,$toMonth,$county,$subCounty);
		// echo "<pre>";print_r($result);echo "</pre>";
		// $this->db->close();
		// $result = $this->get_breakdown_data($year,$month,$toYear,$toMonth,$county,$subCounty);
		// echo "<pre>";print_r($result);die();
		$data['eidAgesSummary']['name'] = 'Tests';
		$data['eidAgesSummary']['colorByPoint'] = true;

		$data['eidAgesSummary']['data'][0]['name'] = '<=2M';
		$data['eidAgesSummary']['data'][0]['y'] = (int) $result['infantsless2m'];
		$data['eidAgesSummary']['data'][1]['name'] = '>2M';
		$data['eidAgesSummary']['data'][1]['y'] = (int) $result['infantsabove2m'];
		$data['eidAgesSummary']['data'][2]['name'] = 'Adults';
		$data['eidAgesSummary']['data'][2]['y'] = (int) $result['adults'];

		$data['eidAgesSummary']['data'][0]['sliced'] = true;
		$data['eidAgesSummary']['data'][0]['selected'] = true;
		$data['eidAgesSummary']['data'][0]['color'] = '#F2784B';
		$data['eidAgesSummary']['data'][1]['color'] = '#1BA39C';

		$data['ul'] = '<tr>
					<td colspan="4">Infants tested:</td>
				</tr>
		    	<tr>
		    		<td>&nbsp;&nbsp;&nbsp;&nbsp;<=2M</td>
		    		<td>'.number_format((int) $result['infantsless2m']).'</td>
		    		<td>Positive:</td>
		    		<td>'.number_format((int) $result['infantsless2mPOS']).'&nbsp;<strong>('.round((((int) $result['infantsless2mPOS']/(int) $result['infantsless2m'])*100),1).'%)</strong></td>
		    	</tr>

		    	<tr>
		    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<2Weeks:</td>
		    		<td>&nbsp;&nbsp;&nbsp;&nbsp;'. number_format((int) $result['infantsless2w']).'</td>
		    		<td>Positive:</td>
		    		<td>'.number_format((int) $result['infantsless2wPOS']).'&nbsp;<strong>('.round((((int) $result['infantsless2wPOS']/(int) $result['infantsless2w'])*100),1).'%)</strong></td>
		    	</tr>

		    	<tr>
		    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4-6 weeks:</td>
		    		<td>&nbsp;&nbsp;&nbsp;&nbsp;'. number_format((int) $result['infants4to6w']).'</td>
		    		<td>Positive:</td>
		    		<td>'. number_format((int) $result['infants4to6wPOS']) .'&nbsp;<strong>('. round(((int) $result['infants4to6wPOS'])/((int) $result['infants4to6w'])*100,1) .'%)</strong></td>
		    	</tr>

		    	<tr>
		    		<td>>2M:</td>
		    		<td>'. number_format((int) $result['infantsabove2m']).'</td>
		    		<td>Positive:</td>
		    		<td>'.number_format((int) $result['infantsabove2mPOS']).'&nbsp;<strong>('.round((((int) $result['infantsabove2mPOS']/(int) $result['infantsabove2m'])*100),1).'%)</strong></td>
		    	</tr>';

		    	// <tr>
		    	// 	<td>Adults:</td>
		    	// 	<td>'. number_format((int) $result['adults']) .'</td>
		    	// 	<td>Positive:</td>
		    	// 	<td>'. number_format((int) $result['adultsPOS']) .'&nbsp;<strong>('. round(((int) $result['adultsPOS'])/((int) $result['adults'])*100,1) .'%)</strong></td>
		    	// </tr>
		
		return $data;
	}

	function ages_positivity($year=null,$month=null,$toYear=null,$toMonth=null,$county=null,$subCounty=null){
		$result = $this->get_breakdown_data($year,$month,$toYear,$toMonth,$county,$subCounty);
		// print_r($result);
		$data['eidAgesPositivity']['name'] = 'Positivity';
		$data['eidAgesPositivity']['colorByPoint'] = true;

		$data['eidAgesPositivity']['data'][0]['name'] = '<2 weeks';
		$data['eidAgesPositivity']['data'][1]['name'] = '2-6 weeks';
		$data['eidAgesPositivity']['data'][2]['name'] = '6-8 weeks';
		$data['eidAgesPositivity']['data'][3]['name'] = '6 months';
		$data['eidAgesPositivity']['data'][4]['name'] = '9 months';
		$data['eidAgesPositivity']['data'][5]['name'] = '12 months';
		$data['eidAgesPositivity']['data'][0]['y'] = round((((int) $result['less2wpos']/((int) $result['less2wpos']+(int) $result['less2wneg']))*100),1);
		$data['eidAgesPositivity']['data'][1]['y'] = round((((int) $result['twoto6wpos']/((int) $result['twoto6wpos']+(int) $result['twoto6wneg']))*100),1);
		$data['eidAgesPositivity']['data'][2]['y'] = round((((int) $result['sixto8wpos']/((int) $result['sixto8wpos']+(int) $result['sixto8wneg']))*100),1);
		$data['eidAgesPositivity']['data'][3]['y'] = round((((int) $result['sixmonthpos']/((int) $result['sixmonthpos']+(int) $result['sixmonthneg']))*100),1);
		$data['eidAgesPositivity']['data'][4]['y'] = round((((int) $result['ninemonthpos']/((int) $result['ninemonthpos']+(int) $result['ninemonthneg']))*100),1);
		$data['eidAgesPositivity']['data'][5]['y'] = round((((int) $result['twelvemonthpos']/((int) $result['twelvemonthpos']+(int) $result['twelvemonthneg']))*100),1);

		$data['eidAgesPositivity']['data'][0]['sliced'] = true;
		$data['eidAgesPositivity']['data'][0]['selected'] = true;
		$data['eidAgesPositivity']['data'][0]['color'] = '#F2784B';
		$data['eidAgesPositivity']['data'][1]['color'] = '#1BA39C';
		$data['eidAgesPositivity']['data'][2]['color'] = '#AEA8D3';
		$data['eidAgesPositivity']['data'][3]['color'] = '#913D88';

		return $data;
	}

	function ages_outcomes($year=null,$month=null,$toYear=null,$toMonth=null,$county=null,$subCounty=null){
		$result = $this->get_breakdown_data($year,$month,$toYear,$toMonth,$county,$subCounty);
		// print_r($result);
		$data['outcomes'][0]['name'] = "Positive";
		$data['outcomes'][1]['name'] = "Negative";
		$data['outcomes'][2]['name'] = "Positivity";

		$data['outcomes'][0]['color'] = '#E26A6A';
		$data['outcomes'][1]['color'] = '#257766';
		$data['outcomes'][2]['color'] = '#913D88';

		$data['outcomes'][0]['type'] = "column";
		$data['outcomes'][1]['type'] = "column";
		$data['outcomes'][2]['type'] = "spline";

		$data['outcomes'][0]['yAxis'] = 1;
		$data['outcomes'][1]['yAxis'] = 1;

		$data['categories'] = array('<2 weeks', '2-6 weeks', '6-8 weeks', '6 months', '9 months', '12 months');
		//This is the section that needs to be edited
		$data['outcomes'][0]['data'][0] = (int) $result['less2wpos'];
		$data['outcomes'][1]['data'][0] = (int) $result['less2wneg'];
		$data['outcomes'][2]['data'][0] = round((((int) $result['less2wpos']/((int) $result['less2wpos']+(int) $result['less2wneg']))*100),1);

		$data['outcomes'][0]['data'][1] = (int) $result['twoto6wpos'];
		$data['outcomes'][1]['data'][1] = (int) $result['twoto6wneg'];
		$data['outcomes'][2]['data'][1] = round((((int) $result['twoto6wpos']/((int) $result['twoto6wpos']+(int) $result['twoto6wneg']))*100),1);

		$data['outcomes'][0]['data'][2] = (int) $result['sixto8wpos'];
		$data['outcomes'][1]['data'][2] = (int) $result['sixto8wneg'];
		$data['outcomes'][2]['data'][2] = round((((int) $result['sixto8wpos']/((int) $result['sixto8wpos']+(int) $result['sixto8wneg']))*100),1);

		$data['outcomes'][0]['data'][3] = (int) $result['sixmonthpos'];
		$data['outcomes'][1]['data'][3] = (int) $result['sixmonthneg'];
		$data['outcomes'][2]['data'][3] = round((((int) $result['sixmonthpos']/((int) $result['sixmonthpos']+(int) $result['sixmonthneg']))*100),1);

		$data['outcomes'][0]['data'][4] = (int) $result['ninemonthpos'];
		$data['outcomes'][1]['data'][4] = (int) $result['ninemonthneg'];
		$data['outcomes'][2]['data'][4] = round((((int) $result['ninemonthpos']/((int) $result['ninemonthpos']+(int) $result['ninemonthneg']))*100),1);

		$data['outcomes'][0]['data'][5] = (int) $result['twelvemonthpos'];
		$data['outcomes'][1]['data'][5] = (int) $result['twelvemonthneg'];
		$data['outcomes'][2]['data'][5] = round((((int) $result['twelvemonthpos']/((int) $result['twelvemonthpos']+(int) $result['twelvemonthneg']))*100),1);
		//This is the section that needs to be edited
		$data['outcomes'][0]['tooltip'] = array("resultSuffix" => ' ');
		$data['outcomes'][1]['tooltip'] = array("resultSuffix" => ' ');
		$data['outcomes'][2]['tooltip'] = array("resultSuffix" => ' %');

		$data['title'] = "Outcomes by Age Groups";

		return $data;
	}

	function get_summary_data($year=null,$month=null,$to_year=null,$to_month=null,$county=null,$subcounty=null)
	{
		if ($county == null || $county == 'null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($subcounty == null || $subcounty == 'null') {
			$subcounty = $this->session->userdata('sub_county_filter');
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
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		// echo "County: ".$county." and sub-county:".$subcounty;die();
		if ($county) {
			$sql = "CALL `proc_get_eid_county_age_summary`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else if ($subcounty) {
			$sql = "CALL `proc_get_eid_subcounty_age_summary`('".$subcounty."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_eid_national_age_summary`('".$year."','".$month."','".$to_year."','".$to_month."')";
		}
		// echo "<pre>";print_r($sql);die();
		$data = $this->db->query($sql)->result_array();

		$newdata = array();
		foreach ($data as $kresult) {
			$newdata = $kresult;
		}
		return $newdata;
	}

	function get_breakdown_data($year=null,$month=null,$to_year=null,$to_month=null,$county=null,$subcounty=null)
	{
		if ($county == null || $county == 'null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($subcounty == null || $subcounty == 'null') {
			$subcounty = $this->session->userdata('sub_county_filter');
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
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		// echo "County: ".$county." and sub-county:".$subcounty;die();
		if ($county) {
			$sql = "CALL `proc_get_eid_county_age_breakdown`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else if ($subcounty) {
			$sql = "CALL `proc_get_eid_subcounty_age_breakdown`('".$subcounty."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_eid_national_age_breakdown`('".$year."','".$month."','".$to_year."','".$to_month."')";
		}
		// echo "<pre>";print_r($sql);die();
		$data = $this->db->query($sql)->result_array();

		$newdata = array();
		foreach ($data as $kresult) {
			$newdata = $kresult;
		}
		return $newdata;
	}
}
?>