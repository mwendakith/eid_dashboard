<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Summaries_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();
	}

	function turnaroundtime($year=null,$month=null,$county=null)
	{
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

		$sql = "CALL `proc_get_eid_national_tat`('".$year."','".$month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$count = 0;
		$tat1 = 0;
		$tat2 = 0;
		$tat3 = 0;
		$tat4 = 0;
		$tat = array();
		
		foreach ($result as $key => $value) {
			if (($value['tat1']!=0) || ($value['tat2']!=0) || ($value['tat3']!=0) || ($value['tat4']!=0)) {
				$count++;

				$tat1 = $tat1+$value['tat1'];
				$tat2 = $tat2+$value['tat2'];
				$tat3 = $tat3+$value['tat3'];
				$tat4 = $tat4+$value['tat4'];
			}
		}
		$tat[] = array(
					'tat1' => $tat1,
					'tat2' => $tat2,
					'tat3' => $tat3,
					'tat4' => $tat4,
					'count' => $count
					);
		// echo "<pre>";print_r($tat);die();
		foreach ($tat as $key => $value) {
			$data['tat1'] = round(@$value['tat1']/@$value['count']);
			$data['tat2'] = round((@$value['tat2']/@$value['count']) + @$data['tat1']);
			$data['tat3'] = round((@$value['tat3']/@$value['count']) + @$data['tat2']);
			$data['tat4'] = round(@$value['tat4']/@$value['count']);
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function test_trends($year=null,$county=null,$partner=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
		}

		if ($year==null || $year=='null') {
			$to = $this->session->userdata('filter_year');
		}else {
			$to = $year;
		}
		$from = $to-1;
		
		if ($partner) {
			$sql = "CALL `proc_get_eid_partner_testing_trends`('".$partner."','".$from."','".$to."')";
			// $sql2 = "CALL `proc_get_partner_sitessending`('".$partner."','".$year."','".$month."')";
		} else {
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_eid_national_testing_trends`('".$from."','".$to."')";
				// $sql2 = "CALL `proc_get_national_sitessending`('".$year."','".$month."')";
			} else {
				$sql = "CALL `proc_get_eid_county_testing_trends`('".$county."','".$from."','".$to."')";
				// $sql2 = "CALL `proc_get_regional_sitessending`('".$county."','".$year."','".$month."')";
			}
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		
		// echo "<pre>";print_r($result);die();
		$data['testing_trends'][0]['name'] = 'Positive';
		$data['testing_trends'][1]['name'] = 'Negative';

		$count = 0;
		
		$data['categories'][0] = 'No Data';
		$data["testing_trends"][0]["data"][0]	= $count;
		$data["testing_trends"][1]["data"][0]	= $count;

		foreach ($result as $key => $value) {
			
				$data['categories'][$key] = $this->resolve_month($value['month']).'-'.$value['year'];

				$data["testing_trends"][0]["data"][$key]	= (int) $value['pos'];
				$data["testing_trends"][1]["data"][$key]	= (int) $value['neg'];
			
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function eid_outcomes($year=null,$month=null,$county=null,$partner=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
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

		if ($partner) {
			$sql = "CALL `proc_get_eid_partner_eid_outcomes`('".$partner."','".$year."','".$month."')";
			// $sql2 = "CALL `proc_get_partner_sitessending`('".$partner."','".$year."','".$month."')";
		} else {
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_eid_national_eid_outcomes`('".$year."','".$month."')";
				// $sql2 = "CALL `proc_get_national_sitessending`('".$year."','".$month."')";
			} else {
				$sql = "CALL `proc_get_eid_county_eid_outcomes`('".$county."','".$year."','".$month."')";
				// $sql2 = "CALL `proc_get_regional_sitessending`('".$county."','".$year."','".$month."')";
			}
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		// $this->db->close();
		// $sitessending = $this->db->query($sql2)->result_array();
		$data['ul'] = '';
		$data['eid_outcomes']['name'] = 'Tests';
		$data['eid_outcomes']['colorByPoint'] = true;

		$count = 0;

		$data['eid_outcomes']['data'][0]['name'] = 'No Data';
		$data['eid_outcomes']['data'][0]['y'] = $count;

		foreach ($result as $key => $value) {
			$data['ul'] .= '<tr>
		    		<td>Cumulative Tests:</td>
		    		<td>'.(int) $value['alltests'].'</td>
		    		<td>EQA Tests:</td>
		    		<td>'.(int) $value['eqatests'].'</td>
		    	</tr>
		    	<tr>
		    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actual Tests:</td>
		    		<td>'.(int) $value['tests'].'</td>
		    		<td>Positive Outcomes:</td>
		    		<td>'.(int) $value['pos'].'('.round((((int) $value['pos']/(int) $value['tests'])*100),1).'%)</td>
		    	</tr>
		    	<tr>
		    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;First DNA PCR:</td>
		    		<td>'.(int) $value['firstdna'].'</td>
		    		<td>Confirmatory PCR @9M:</td>
		    		<td>'.(int) $value['confirmdna'].'</td>
		    	</tr>
		    	<tr>
		    		<td colspan="2"><center>Repeats for  Positive Confimation:</center></td>
			    	<td colspan="2">'.(int) $value['repeatspos'].'</td>
			    </tr>
		    	<tr>
		    		<th colspan="4"></th>
		    	</tr>
		    	<tr>
		    		<td>Actual Infants Tested:</td>
		    		<td>'.(int) $value['actualinfants'].'</td>
		    		<td>Positive Outcomes:</td>
		    		<td>'.(int) $value['actualinfantspos'].'('.round((((int) $value['actualinfantspos']/(int) $value['actualinfants'])*100),1).'%)</td>
		    	</tr>
		    	<tr>
		    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Infants &lt; 2M:</td>
		    		<td>'.(int) $value['infantsless2m'].'</td>
		    		<td>Infants &lt; 2M Positive:</td>
		    		<td>'.(int) $value['infantless2mpos'].'('.round((((int) $value['infantless2mpos']/(int) $value['infantsless2m'])*100),1).'%)</td>
		    	</tr>
		    	<tr>
		    		<td>Adults Tested:</td>
		    		<td>'.(int) $value['adults'].'</td>
		    		<td>Positive Outcomes:</td>
		    		<td>'.(int) $value['adultsPOS'].'('.round((((int) $value['adultsPOS']/(int) $value['adults'])*100),1).'%)</td>
		    	</tr>
		    	<tr>
		    		<th colspan="4"></th>
		    	</tr>
		    	<tr>
		    		<td>Redraws:</td>
		    		<td>'.(int) $value['redraw'].'</td>
		    		<td>Rejected Samples:</td>
		    		<td>'.(int) $value['rejected'].'</td>
		    	</tr>
		    	<tr>
		    		<td>Median Age of Testing:</td>
		    		<td>'.round($value['medage']).'</td>
		    		<td>Average Sites sending:</td>
		    		<td>'.(int) $value['sitessending'].'</td>
		    	</tr>';
			// $data['ul'] .= '<li>Cumulative No. of Tests: <strong>'.(int) $value['alltests'].'</strong></li>';
			// $data['ul'] .= '<li>Cumulative No. of EQA Tests: <strong>'.(int) $value['eqatests'].'</strong></li>';
			// $data['ul'] .= '<li>No. of All Infants Tested: <strong>'.(int) $value['tests'].'</strong></li>';
			// $data['ul'] .= '<li>No. of All Infants Tested ( < 2 months): <strong>'.(int) $value['infantsless2m'].'</strong></li>';
			// $data['ul'] .= '<li>No. of first DNA PCR Test: <strong>'.(int) $value['firstdna'].'</strong></li>';
			// $data['ul'] .= '<li>No of Confirmatory PCR Test @9M: <strong>'.(int) $value['confirmdna'].'</strong></li>';
			// $data['ul'] .= '<li>Median Age of Testing (Months): <strong>'.$value['medage'].'</strong></li>';
			// $data['ul'] .= '<li>Rejected Samples: <strong>'.$value['rejected'].'</strong></li>';
			// $data['ul'] .= '<li>Sites Sending: <strong>'.(int) $value['sitessending'].'</strong></li>';
			// if($value['name'] == ''){
			// 	$data['hei']['data'][$key]['color'] = '#5C97BF';
			// }
			$data['eid_outcomes']['data'][$key]['y'] = $count;

			$data['eid_outcomes']['data'][0]['name'] = 'Positive';
			$data['eid_outcomes']['data'][1]['name'] = 'Negative';

			$data['eid_outcomes']['data'][0]['y'] = (int) $value['pos'];
			$data['eid_outcomes']['data'][1]['y'] = (int) $value['neg'];
		}

		$data['eid_outcomes']['data'][0]['sliced'] = true;
		$data['eid_outcomes']['data'][0]['selected'] = true;
		$data['eid_outcomes']['data'][0]['color'] = '#F2784B';
		$data['eid_outcomes']['data'][1]['color'] = '#1BA39C';
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function hei_follow($year=null,$month=null,$county=null,$partner=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
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

		if ($partner) {
			$sql = "CALL `proc_get_eid_partner_hei`('".$partner."','".$year."','".$month."')";
		} else {
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_eid_national_hei`('".$year."','".$month."')";
			} else {
				$sql = "CALL `proc_get_eid_county_hei`('".$county."','".$year."','".$month."')";
			}
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$data['hei']['name'] = 'Tests';
		$data['hei']['colorByPoint'] = true;

		$count = 0;
		$data['ul'] = '';

		$data['hei']['data'][0]['name'] = 'No Data';
		$data['hei']['data'][0]['y'] = $count;

		foreach ($result as $key => $value) {
			$total = (int) ($value['enrolled']+$value['dead']+$value['ltfu']+$value['adult']+$value['transout']+$value['other']);
			$data['ul'] .= '<li>Initiated On Treatment: '.(int) $value['enrolled'].' <strong>('.(int) (($value['enrolled']/$total)*100).'%)</strong></li>';
			$data['ul'] .= '<li>Lost to Follow Up: '.$value['ltfu'].' <strong>('.(int) (($value['ltfu']/$total)*100).'%)</strong></li>';
			$data['ul'] .= '<li>Dead: '.(int) $value['dead'].' <strong>('.(int) (($value['dead']/$total)*100).'%)</strong></li>';
			$data['ul'] .= '<li>Adult Samples: '.$value['adult'].' <strong>('.(int) (($value['adult']/$total)*100).'%)</strong></li>';
			$data['ul'] .= '<li>Transferred Out: '.$value['transout'].' <strong>('.(int) (($value['transout']/$total)*100).'%)</strong></li>';
			$data['ul'] .= '<li>Other Reasons(e.g denial): '.$value['other'].' <strong>('.(int) (($value['other']/$total)*100).'%)</strong></li>';
			// if($value['name'] == ''){
			// 	$data['hei']['data'][$key]['color'] = '#5C97BF';
			// }
			$data['hei']['data'][$key]['y'] = $count;

			$data['hei']['data'][0]['name'] = 'Initiated on Treatment';
			$data['hei']['data'][1]['name'] = 'Dead';
			$data['hei']['data'][2]['name'] = 'Lost to Follow up';
			$data['hei']['data'][3]['name'] = 'Transferred out';
			$data['hei']['data'][4]['name'] = 'Adult Samples';
			$data['hei']['data'][5]['name'] = 'Other Reasons';

			$data['hei']['data'][0]['y'] = (int) $value['enrolled'];
			$data['hei']['data'][1]['y'] = (int) $value['dead'];
			$data['hei']['data'][2]['y'] = (int) $value['ltfu'];
			$data['hei']['data'][3]['y'] = (int) $value['transout'];
			$data['hei']['data'][4]['y'] = (int) $value['adult'];
			$data['hei']['data'][5]['y'] = (int) $value['other'];
		}

		$data['hei']['data'][0]['sliced'] = true;
		$data['hei']['data'][0]['selected'] = true;
		$data['hei']['data'][0]['color'] = '#1BA39C';
		$data['hei']['data'][1]['color'] = '#F2784B';
		$data['hei']['data'][2]['color'] = '#5C97BF';
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function age($year=null,$month=null,$county=null,$partner=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
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

		if ($partner) {
			$sql = "CALL `proc_get_eid_partner_age`('".$partner."','".$year."','".$month."')";
		} else {
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_eid_national_age`('".$year."','".$month."')";
			} else {
				$sql = "CALL `proc_get_eid_county_age`('".$county."','".$year."','".$month."')";
			}
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$count = 0;
				
		// echo "<pre>";print_r($result);die();
		$data['ageGnd'][0]['name'] = 'Positive';
		$data['ageGnd'][1]['name'] = 'Negative';

		$count = 0;
		
		$data["ageGnd"][0]["data"][0]	= $count;
		$data["ageGnd"][1]["data"][0]	= $count;
		$data['categories'][0]			= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][0] 			= '2M';
			$data['categories'][1] 			= '3-8M';
			$data['categories'][2] 			= '9-12M';
			$data['categories'][3] 			= 'Above 12M';
			// $data['categories'][4] 			= 'above18M';
			$data['categories'][4] 			= 'No Data';

			$data["ageGnd"][0]["data"][0]	=  (int) $value['sixweekspos'];
			$data["ageGnd"][1]["data"][0]	=  (int) $value['sixweeksneg'];
			$data["ageGnd"][0]["data"][1]	=  (int) $value['sevento3mpos'];
			$data["ageGnd"][1]["data"][1]	=  (int) $value['sevento3mneg'];
			$data["ageGnd"][0]["data"][2]	=  (int) $value['threemto9mpos'];
			$data["ageGnd"][1]["data"][2]	=  (int) $value['threemto9mneg'];
			$data["ageGnd"][0]["data"][3]	=  (int) $value['ninemto18mpos'];
			$data["ageGnd"][1]["data"][3]	=  (int) $value['ninemto18mneg'];
			// $data["ageGnd"][0]["data"][4]	=  (int) $value['above18mpos'];
			// $data["ageGnd"][1]["data"][4]	=  (int) $value['above18mneg'];
			$data["ageGnd"][0]["data"][4]	=  (int) $value['nodatapos'];
			$data["ageGnd"][1]["data"][4]	=  (int) $value['nodataneg'];
		}
		// die();
		$data['ageGnd'][0]['drilldown']['color'] = '#913D88';
		$data['ageGnd'][1]['drilldown']['color'] = '#96281B';

		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function entry_points($year=null,$month=null,$county=null,$partner=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
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

		if ($partner) {
			$sql = "CALL `proc_get_eid_partner_entry_points`('".$partner."','".$year."','".$month."')";
		} else {
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_eid_national_entry_points`('".$year."','".$month."')";
			} else {
				$sql = "CALL `proc_get_eid_county_entry_points`('".$county."','".$year."','".$month."')";
			}
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$count = 0;
				
		$data['entry'][0]['name'] = 'Positive';
		$data['entry'][1]['name'] = 'Negative';

		$count = 0;
		
		$data["entry"][0]["data"][0]	= $count;
		$data["entry"][1]["data"][0]	= $count;
		$data['categories'][0]			= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 		= $value['name'];

			$data["entry"][0]["data"][$key]	=  (int) $value['positive'];
			$data["entry"][1]["data"][$key]	=  (int) $value['negative'];
			
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function mprophylaxis($year=null,$month=null,$county=null,$partner=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
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

		if ($partner) {
			$sql = "CALL `proc_get_eid_partner_mprophylaxis`('".$partner."','".$year."','".$month."')";
		} else {
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_eid_national_mprophylaxis`('".$year."','".$month."')";
			} else {
				$sql = "CALL `proc_get_eid_county_mprophylaxis`('".$county."','".$year."','".$month."')";
			}
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$count = 0;
				
		$data['mprophilaxis'][0]['name'] = 'Positive';
		$data['mprophilaxis'][1]['name'] = 'Negative';

		$count = 0;
		
		$data["mprophilaxis"][0]["data"][0]	= $count;
		$data["mprophilaxis"][1]["data"][0]	= $count;
		$data['categories'][0]			= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 		= $value['name'];

			$data["mprophilaxis"][0]["data"][$key]	=  (int) $value['positive'];
			$data["mprophilaxis"][1]["data"][$key]	=  (int) $value['negative'];
			
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function iprophylaxis($year=null,$month=null,$county=null,$partner=null)
	{
		// Assigning the value of the county
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
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

		if ($partner) {
			$sql = "CALL `proc_get_eid_partner_iprophylaxis`('".$partner."','".$year."','".$month."')";
		} else {
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_eid_national_iprophylaxis`('".$year."','".$month."')";
			} else {
				$sql = "CALL `proc_get_eid_county_iprophylaxis`('".$county."','".$year."','".$month."')";
			}
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$count = 0;
				
		$data['iprophilaxis'][0]['name'] = 'Positive';
		$data['iprophilaxis'][1]['name'] = 'Negative';

		$count = 0;
		
		$data["iprophilaxis"][0]["data"][0]	= $count;
		$data["iprophilaxis"][1]["data"][0]	= $count;
		$data['categories'][0]			= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 		= $value['name'];

			$data["iprophilaxis"][0]["data"][$key]	=  (int) $value['positive'];
			$data["iprophilaxis"][1]["data"][$key]	=  (int) $value['negative'];
			
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function county_outcomes($year=null,$month=null,$pfil=null,$partner=null,$county=null)
	{
		//Initializing the value of the Year to the selected year or the default year which is current year
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		//Assigning the value of the month or setting it to the selected value
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		// Assigning the value of the county
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
		}

		if ($pfil==null || $pfil=='null') {
			$pfil = NULL;
		}
				
		// echo "PFil: ".$pfil." --Partner: ".$partner." -- County: ".$county;
		if ($county) {
			$sql = "CALL `proc_get_eid_county_sites_outcomes`('".$county."','".$year."','".$month."')";
		} else {
			if ($pfil||$pfil==1) {
				if ($partner) {
					$sql = "CALL `proc_get_eid_partner_sites_outcomes`('".$partner."','".$year."','".$month."')";
				} else {
					$sql = "CALL `proc_get_eid_partner_outcomes`('".$year."','".$month."')";
				}
			} else {
				$sql = "CALL `proc_get_eid_county_outcomes`('".$year."','".$month."')";
			}
		}
		// $sql = "CALL `proc_get_county_outcomes`('".$year."','".$month."')";
		// echo "<pre>";print_r($sql);echo "</pre>";die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$data['county_outcomes'][0]['name'] = 'Positive';
		$data['county_outcomes'][1]['name'] = 'Negative';

		$count = 0;
		
		$data["county_outcomes"][0]["data"][0]	= $count;
		$data["county_outcomes"][1]["data"][0]	= $count;
		$data['categories'][0]					= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data["county_outcomes"][0]["data"][$key]	=  (int) $value['positive'];
			$data["county_outcomes"][1]["data"][$key]	=  (int) $value['negative'];
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}
}
?>