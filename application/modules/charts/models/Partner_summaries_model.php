<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Partner_summaries_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();
	}


	function test_trends($year=null,$partner=null)
	{
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
		}

		if ($year==null || $year=='null') {
			$to = $this->session->userdata('filter_year');
		}else {
			$to = $year;
		}
		$from = $to-1;
		
		$sql = "CALL `proc_get_eid_partner_testing_trends`('".$partner."','".$from."','".$to."')";
			// $sql2 = "CALL `proc_get_partner_sitessending`('".$partner."','".$year."','".$month."')";
		
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

	function eid_outcomes($year=null,$month=null,$partner=null,$to_year=null,$to_month=null)
	{
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
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}

		$sql = "CALL `proc_get_eid_partner_eid_outcomes`('".$partner."','".$year."','".$to_year."')";
		
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
		    	<tr>
		    		<td>Actual Tests With Valid Results:</td>
		    		<td>'.(int) $value['tests'].'</td>
		    		<td>Positive Outcomes:</td>
		    		<td>'.(int) $value['pos'].'('.round((((int) $value['pos']/(int) $value['tests'])*100),1).'%)</td>
		    	</tr>

		    	<tr>
		    		<td>First DNA PCR With Valid Results:</td>
		    		<td>'. (int) $value['firstdna']  .'</td>
		    		<td></td>
		    		<td></td>
		    	</tr>

		    	<tr>
		    		<td>Repeat Confirmatory Tests:</td>
		    		<td>'. ((int) $value['confirmdna'] + (int) $value['repeatspos']) .'</td>
		    		<td>Repeat Confirmatory Tests POS</td>
		    		<td>'. number_format((int) $value['confirmpos']) .'('. round(((int) $value['confirmpos'])/((int) $value['confirmdna'] + (int) $value['repeatspos'])*100,1) .'%)</td>
		    	</tr>

		    	<tr>
		    		<td></td>
		    		<td></td>
		    		<td></td>
		    		<td></td>
		    	</tr>

		    	<tr>
		    		<td>Actual Infants Tested:</td>
		    		<td>'.(int) $value['actualinfants'].'</td>
		    		<td>Positive Outcomes:</td>
		    		<td>'.(int) $value['actualinfantspos'].'('. round((((int) $value['actualinfantspos']/(int) $value['actualinfants'])*100),1)  .'%)</td>
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
		    		<td></td>
		    		<td></td>
		    		<td></td>
		    		<td></td>
		    	</tr>
		    	

		    	<tr>
		    		<td>Rejected Samples:</td>
		    		<td>'.(int) $value['rejected'].'</td>
		    		<td>% Rejection:</td>
		    		<td>'.round((((int) $value['rejected']/(int) $value['alltests'])*100),1).'%</td>
		    	</tr>


		    	<tr>
		    		<td>Median Age of Testing:</td>
		    		<td>'.round($value['medage']).'</td>
		    		<td>Average Sites sending:</td>
		    		<td>'.(int) $value['sitessending'].'</td>
		    	</tr>';
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

	function hei_validation($year=null,$month=null,$partner=null,$to_year=null,$to_month=null)
	{
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
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}

		if ($month == 0) {
			$sql = "CALL `proc_get_eid_partner_yearly_hei_validation`('".$partner."','".$year."')";
		} else {
			$sql = "CALL `proc_get_eid_partner_hei_validation`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$data['hei']['name'] = 'Validation';
		$data['hei']['colorByPoint'] = true;

		$count = 0;
		$data['ul'] = '';

		$data['hei']['data'][0]['name'] = 'No Data';
		$data['hei']['data'][0]['y'] = $count;

		foreach ($result as $key => $value) {
			// echo "<pre>";print_r($value);die();
			// $data['ul'] .= '<tr>
   //              <td>Validated Positives:</td>
   //                  <td>'.number_format((int) $value['followup_positives']).'<b>('.round((((int) $value['followup_positives']/(int) $value['positives'])*100),1).'%)</b></td>
   //                  <td></td>
   //                  <td></td>
   //              </tr>
 
   //              <tr>
   //                  <td>Confirmed Actual positive Infants:</td>
   //                  <td>'.number_format((int) $value['Confirmed Positive']).'<b>('.round((((int) $value['Confirmed Positive']/(int) $value['true_tests'])*100),1).'%)</b></td>
   //                  <td></td>
   //                  <td></td>
   //              </tr>';
				$data['ul'] .= '<tr>
                 <td>Positve Outcomes Actual Infants:</td>
                     <td>'.number_format((int) $value['positives']).'</td>
                     <td></td>
                     <td></td>
                </tr><tr>
                 <td>Followed Up HEIs:</td>
                     <td>'.number_format((int) $value['followup_hei']).'<b>('.round((((int) $value['followup_hei']/(int) $value['positives'])*100),1).'%)</b></td>
                     <td></td>
                     <td></td>
                </tr>
               	<tr>
                   <td>Confirmed Positives:</td>
                     <td>'.number_format((int) $value['Confirmed Positive']).'<b>('.round((((int) $value['Confirmed Positive']/(int) $value['true_tests'])*100),1).'%)</b></td>
                     <td></td>
                     <td></td>
                 </tr>';
			$data['hei']['data'][0]['name'] = 'Confirmed Positive';
			$data['hei']['data'][1]['name'] = 'Repeat Test';
			$data['hei']['data'][2]['name'] = 'Viral Load';
			$data['hei']['data'][3]['name'] = 'Adult';
			$data['hei']['data'][4]['name'] = 'Unknown Facility';

			$data['hei']['data'][0]['y'] = (int) $value['Confirmed Positive'];
			$data['hei']['data'][1]['y'] = (int) $value['Repeat Test'];
			$data['hei']['data'][2]['y'] = (int) $value['Viral Load'];
			$data['hei']['data'][3]['y'] = (int) $value['Adult'];
			$data['hei']['data'][4]['y'] = (int) $value['Unknown Facility'];

			$count++;
		}
		$data['hei']['data'][0]['sliced'] = true;
		$data['hei']['data'][0]['selected'] = true;
		$data['hei']['data'][0]['color'] = '#1BA39C';
		$data['hei']['data'][1]['color'] = '#F2784B';
		$data['hei']['data'][2]['color'] = '#5C97BF';
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function hei_follow($year=null,$month=null,$partner=null,$to_year=null,$to_month=null)
	{
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
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}

		if ($month == 0) {
			$sql = "CALL `proc_get_eid_partner_yearly_hei`('".$partner."','".$year."')";
		} else {
			$sql = "CALL `proc_get_eid_partner_hei`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
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

	function age($year=null,$month=null,$partner=null,$to_year=null,$to_month=null)
	{
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
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}

		$sql = "CALL `proc_get_eid_partner_age`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		
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
			$data['categories'][0] 			= 'No Data';
			$data['categories'][1] 			= '2M';
			$data['categories'][2] 			= '3-8M';
			$data['categories'][3] 			= '9-12M';
			$data['categories'][4] 			= 'Above 12M';
			// $data['categories'][4] 			= 'above18M';

			$data["ageGnd"][0]["data"][0]	=  (int) $value['nodatapos'];
			$data["ageGnd"][1]["data"][0]	=  (int) $value['nodataneg'];
			$data["ageGnd"][0]["data"][1]	=  (int) $value['sixweekspos'];
			$data["ageGnd"][1]["data"][1]	=  (int) $value['sixweeksneg'];
			$data["ageGnd"][0]["data"][2]	=  (int) $value['sevento3mpos'];
			$data["ageGnd"][1]["data"][2]	=  (int) $value['sevento3mneg'];
			$data["ageGnd"][0]["data"][3]	=  (int) $value['threemto9mpos'];
			$data["ageGnd"][1]["data"][3]	=  (int) $value['threemto9mneg'];
			$data["ageGnd"][0]["data"][4]	=  (int) $value['ninemto18mpos'];
			$data["ageGnd"][1]["data"][4]	=  (int) $value['ninemto18mneg'];
			// $data["ageGnd"][0]["data"][4]	=  (int) $value['above18mpos'];
			// $data["ageGnd"][1]["data"][4]	=  (int) $value['above18mneg'];
		}
		// die();
		$data['ageGnd'][0]['drilldown']['color'] = '#913D88';
		$data['ageGnd'][1]['drilldown']['color'] = '#96281B';

		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function entry_points($year=null,$month=null,$partner=null,$to_year=null,$to_month=null)
	{
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
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}

		$sql = "CALL `proc_get_eid_partner_entry_points`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		
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

	function mprophylaxis($year=null,$month=null,$partner=null,$to_year=null,$to_month=null)
	{
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
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}

		$sql = "CALL `proc_get_eid_partner_mprophylaxis`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		
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

	function iprophylaxis($year=null,$month=null,$partner=null,$to_year=null,$to_month=null)
	{
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
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}

		$sql = "CALL `proc_get_eid_partner_iprophylaxis`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		
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

	function partner_outcomes($year=null,$month=null,$partner=null,$to_year=null,$to_month=null)
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
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}

		
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
		}

		if ($partner) {
			$sql = "CALL `proc_get_eid_partner_sites_outcomes`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_eid_partner_outcomes`('".$year."','".$month."','".$to_year."','".$to_month."')";
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

	function partner_counties($year=NULL,$month=NULL,$partner=NULL,$to_year=null,$to_month=null)
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
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}

		$sql = "CALL `proc_get_eid_partner_county_details`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
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
			
				$data['categories'][$key] = $value['county'];

				$data["testing_trends"][0]["data"][$key]	= (int) $value['positive'];
				$data["testing_trends"][1]["data"][$key]	= (int) $value['negative'];
			
		}
		// echo "<pre>";print_r($data);die();
		return $data;

	}

	function partner_counties_outcomes($year=NULL,$month=NULL,$partner=NULL,$to_year=null,$to_month=null)
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
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}

		$sql = "CALL `proc_get_eid_partner_county_details`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($sql);die();
		foreach ($result as $key => $value) {
			$table .= '<tr>';
			$table .= '<td>'.$count.'</td>';

			$table .= '<td>'.$value['county'].'</td>';
			$table .= '<td>'.$value['facilities'].'</td>';
			$table .= '<td>'.number_format($value['tests']).'</td>';
			$table .= '<td>'.number_format($value['firstdna']).'</td>';
			$table .= '<td>'.number_format($value['confirmdna']).'</td>';
			$table .= '<td>'.number_format($value['positive']).'</td>';
			$table .= '<td>'.number_format($value['negative']).'</td>';
			$table .= '<td>'.number_format($value['redraw']).'</td>';
			$table .= '<td>'.number_format($value['adults']).'</td>';
			$table .= '<td>'.number_format($value['adultspos']).'</td>';
			$table .= '<td>'.round($value['medage']).'</td>';
			$table .= '<td>'.number_format($value['rejected']).'</td>';
			$table .= '<td>'.number_format($value['infantsless2m']).'</td>';
			$table .= '<td>'.number_format($value['infantsless2mpos']).'</td>';
			$table .= '</tr>';
			$count++;
		}
		

		return $table;
	}

	function partner_counties_download($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
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
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}

		$sql = "CALL `proc_get_eid_partner_county_details`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$data = $this->db->query($sql)->result_array();

		$this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";

	    /** open raw memory as file, no need for temp files, be careful not to run out of memory thought */
	    $f = fopen('php://memory', 'w');
	    /** loop through array  */

	    $b = array('County', 'Facilities', 'Tests', '1st DNA PCR', 'Confirmed PCR', '+', '-', 'Redraws', 'Adults Tests', 'Adults Tests Positives', 'Median Age', 'Rejected', 'Infants < 2m', 'Infants < 2m +');

	    fputcsv($f, $b, $delimiter);

	    foreach ($data as $line) {
	        /** default php csv handler **/
	        fputcsv($f, $line, $delimiter);
	    }
	    /** rewrind the "file" with the csv lines **/
	    fseek($f, 0);
	    /** modify header to be downloadable csv file **/
	    header('Content-Type: application/csv');
	    header('Content-Disposition: attachement; filename="eid_partner_sites.csv";');
	    /** Send file to browser for download */
	    fpassthru($f);


	}
}
?>