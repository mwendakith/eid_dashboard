<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class Subcounties_model extends MY_Model
{
	function __construct()
	{
		parent:: __construct();;
	}

	function subcounties_outcomes($year=null,$month=null)
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

		$sql = "CALL `proc_get_eid_top_subcounty_outcomes`('".$year."','".$month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

		$data['sub_county_outcomes'][0]['name'] = 'Positive';
		$data['sub_county_outcomes'][1]['name'] = 'Negative';

		$count = 0;
		
		$data["sub_county_outcomes"][0]["data"][0]	= $count;
		$data["sub_county_outcomes"][1]["data"][0]	= $count;
		$data['categories'][0]					= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data["sub_county_outcomes"][0]["data"][$key]	=  (int) $value['positive'];
			$data["sub_county_outcomes"][1]["data"][$key]	=  (int) $value['negative'];
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function get_eid($subcounty=null, $year=null, $month=null){

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}

		$data['title'] = "EID Outcome (" . $year . ", " . $this->resolve_month($month) . ")";

		
		
		// if ($site==null || $site=='null') {
		// 	$site = $this->session->userdata('site_filter');
		// }

		if ($month==null || $month=='null') {
			$data['title'] = "EID Outcome (" . $year . ")";
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		
		$sql = "CALL `proc_get_eid_subcounty_eid`('".$year."', '".$month."', '".$subcounty."')";

		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
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
		    		<td>'.(int) $value['adultsPOS'].'('.@round((((int) $value['adultsPOS']/(int) $value['adults'])*100),1).'%)</td>
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

	function get_hei($subcounty=null, $year=null, $month=null){


		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		
		$data['title'] = "HEI Follow Up (" . $year . ", " . $this->resolve_month($month) . ")";

		// if ($site==null || $site=='null') {
		// 	$site = $this->session->userdata('site_filter');
		// }

		if ($month==null || $month=='null') {
			$data['title'] = "HEI Follow Up (" . $year . ")";
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		
		$sql = "CALL `proc_get_eid_subcounty_hei_follow_up`('".$year."', '".$month."', '".$subcounty."')";

		$result = $this->db->query($sql)->row();
		// echo "<pre>";print_r($result);die();
		$data['trend'][0]['name'] = "Initiated On Treatment";
		$data['trend'][1]['name'] = "Dead";
		$data['trend'][2]['name'] = "Lost to Follow Up";
		$data['trend'][3]['name'] = "Transferred Out";
		$data['trend'][4]['name'] = "Adult Samples";
		$data['trend'][5]['name'] = "Other Reasons";

		$per = (int) ($result->enrolled + $result->dead + $result->ltfu + $result->transout + $result->adult + $result->other);

		$data['trend'][0]['y'] = (int) $result->enrolled;
		$data['trend'][1]['y'] = (int) $result->dead;
		$data['trend'][2]['y'] = (int) $result->ltfu;
		$data['trend'][3]['y'] = (int) $result->transout;
		$data['trend'][4]['y'] = (int) $result->adult;
		$data['trend'][5]['y'] = (int) $result->other;

		$data['trend'][0]['sliced'] = true;
		$data['trend'][0]['selected'] = true;

		$data['trend'][0]['color'] = '#1BA39C';
		$data['trend'][1]['color'] = '#F2784B';
		$data['trend'][2]['color'] = '#5C97BF';

		$data['other'][0] = (int) $result->adult;
		$data['other'][1] = (int) $result->other;

		$data['per'][0] = (int) ($result->enrolled / $per * 100);
		$data['per'][1] = (int) ($result->dead / $per * 100);
		$data['per'][2] = (int) ($result->ltfu / $per * 100);
		$data['per'][3] = (int) ($result->transout / $per * 100);
		$data['per'][4] = (int) ($result->adult / $per * 100);
		$data['per'][5] = (int) ($result->other / $per * 100);

		$str = "Initiated On Treatment: " . $data['trend'][0]['y'] . " <b>(" . $data['per'][0] . "%)</b>";
		$str .= "<br />Lost to Follow Up: " . $data['trend'][2]['y'] . " <b>(" . $data['per'][2] . "%)</b>";
		$str .= "<br />Dead: " . $data['trend'][1]['y'] . " <b>(" . $data['per'][1] . "%)</b>";
		$str .= "<br />Adult Samples: " . $data['other'][0] . " <b>(" . $data['per'][4] . "%)</b>";
		$str .= "<br />Transferred out: " . $data['trend'][3]['y'] . " <b>(" . $data['per'][3] . "%)</b>";
		$str .= "<br />Other Reasons(e.g denial): " . $data['other'][1] . " <b>(" . $data['per'][5] . "%)</b>";

		$str = '<li>Initiated On Treatment: '.(int) $data['trend'][0]['y'].' <strong>('.(int) $data['per'][0].'%)</strong></li>';
		$str .= '<li>Lost to Follow Up: '.$data['trend'][2]['y'].' <strong>('.(int) $data['per'][2].'%)</strong></li>';
		$str .= '<li>Dead: '.(int) $data['trend'][1]['y'].' <strong>('.(int) $data['per'][1].'%)</strong></li>';
		$str .= '<li>Adult Samples: '.$data['other'][0].' <strong>('.(int) $data['per'][4].'%)</strong></li>';
		$str .= '<li>Transferred Out: '.$data['trend'][3]['y'].' <strong>('.(int) $data['per'][3].'%)</strong></li>';
		$str .= '<li>Other Reasons(e.g denial): '.$data['other'][1].' <strong>('.(int) $data['per'][5].'%)</strong></li>';

		$data['stats'] = $str;


		$data['div'] = "hei_pie";
		$data['content'] = "hei_content";
		
		

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

	function subcounty_sites_outcomes($year=NULL,$month=NULL,$subcounty=NULL)
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

		$sql = "CALL `proc_get_eid_subcounty_sites_details`('".$subcounty."','".$year."','".$month."')";
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
			$table .= '<td>'.$value['firstdna'].'</td>';
			$table .= '<td>'.$value['confirmdna'].'</td>';
			$table .= '<td>'.$value['positive'].'</td>';
			$table .= '<td>'.$value['negative'].'</td>';
			$table .= '<td>'.$value['redraw'].'</td>';
			$table .= '<td>'.$value['adults'].'</td>';
			$table .= '<td>'.$value['adultspos'].'</td>';
			$table .= '<td>'.$value['medage'].'</td>';
			$table .= '<td>'.$value['rejected'].'</td>';
			$table .= '<td>'.$value['infantsless2m'].'</td>';
			$table .= '<td>'.$value['infantsless2mpos'].'</td>';
			$table .= '</tr>';
			$count++;
		}
		

		return $table;
	}

	function subcounty_sites_outcomes_download($year=NULL,$month=NULL,$subcounty=NULL)
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

		$sql = "CALL `proc_get_eid_subcounty_sites_details`('".$subcounty."','".$year."','".$month."')";
		// echo "<pre>";print_r($sql);die();
		$data = $this->db->query($sql)->result_array();

		$this->load->helper('download');
        $this->load->library('PHPReport/PHPReport');

        ini_set('memory_limit','-1');
	    ini_set('max_execution_time', 900);


        $template = 'partner_sites.xlsx';

	    //set absolute path to directory with template files
	    $templateDir = __DIR__ . "/";
	    
	    //set config for report
	    $config = array(
	        'template' => $template,
	        'templateDir' => $templateDir
	    );


	      //load template
	    $R = new PHPReport($config);
	    
	    $R->load(array(
	            'id' => 'data',
	            'repeat' => TRUE,
	            'data' => $data   
	        )
	    );
	      
	      // define output directoy 
	    $output_file_dir = __DIR__ ."/tmp/";
	     // echo "<pre>";print_r("Still working");die();

	    $output_file_excel = $output_file_dir  . "subcounty_sites.xlsx";
	    //download excel sheet with data in /tmp folder
	    $result = $R->render('excel', $output_file_excel);
	    force_download($output_file_excel, null);		
		
	}
	
	
}
?>