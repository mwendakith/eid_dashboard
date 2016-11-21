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

	function unsupported_sites(){
		$sql = "CALL `proc_get_eid_unsupported_facilities`()";

		$result = $this->db->query($sql)->result_array();

		$ul = '';
		foreach ($result as $key => $value) {
			$ul .= "<tr>
				<td>" . ($key+1) . "</td>
				<td>" . $value['facilitycode'] . "</td>
				<td>" . $value['DHIScode'] . "</td>
				<td>" . $value['name'] . "</td>
				<td>" . $value['county'] . "</td>
				<td>" . $value['subcounty'] . "</td>
			</tr>";
		}

		return $ul;

	}

	function download_unsupported_sites(){
		$sql = "CALL `proc_get_eid_unsupported_facilities`()";

		$data = $this->db->query($sql)->result_array();

		$this->load->helper('download');
        $this->load->library('PHPReport/PHPReport');


        $template = 'unsupported_sites_template.xlsx';

	    //set absolute path to directory with template files
	    $templateDir = __DIR__ . "/";
	    
	    //set config for report
	    $config = array(
	        'template' => $template,
	        'templateDir' => $templateDir
	    );

	    ini_set('memory_limit','-1');
	    ini_set('max_execution_time', 900);


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

	    $output_file_excel = $output_file_dir  . "unsupported_sites.xlsx";
	    //download excel sheet with data in /tmp folder
	    $result = $R->render('excel', $output_file_excel);
	    force_download($output_file_excel, null);

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

	function partner_sites_outcomes_download($year=NULL,$month=NULL,$partner=NULL)
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

		$sql = "CALL `proc_get_eid_partner_sites_details`('".$partner."','".$year."','".$month."')";
		// echo "<pre>";print_r($sql);die();
		$data = $this->db->query($sql)->result_array();

		$this->load->helper('download');
        $this->load->library('PHPReport/PHPReport');


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

	    $output_file_excel = $output_file_dir  . "partner_sites.xlsx";
	    //download excel sheet with data in /tmp folder
	    $result = $R->render('excel', $output_file_excel);
	    force_download($output_file_excel, null);		
		
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
		$data['trends'][0][0] = 0;
		$data['trends'][1][0] = 0;

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
		$data['title'] = "Positivity (" . $year . ")";
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function get_eid($site=null, $year=null, $month=null){

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}

		$data['title'] = "EID Outcome (" . $year . ", " . $this->resolve_month($month) . ")";

		
		
		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}

		if ($month==null || $month=='null') {
			$data['title'] = "EID Outcome (" . $year . ")";
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		
		$sql = "CALL `proc_get_eid_sites_eid`('".$year."', '".$month."', '".$site."')";

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

	function get_hei($site=null, $year=null, $month=null){


		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		
		$data['title'] = "HEI Follow Up (" . $year . ", " . $this->resolve_month($month) . ")";

		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}

		if ($month==null || $month=='null') {
			$data['title'] = "HEI Follow Up (" . $year . ")";
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		
		$sql = "CALL `proc_get_eid_sites_hei_follow_up`('".$year."', '".$month."', '".$site."')";

		$result = $this->db->query($sql)->row();

		$data['trend'][0]['name'] = "Initiated On Treatment";
		$data['trend'][1]['name'] = "Dead";
		$data['trend'][2]['name'] = "Lost to Follow Up";
		$data['trend'][3]['name'] = "Transferred Out";

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

		$str = "Initiated On Treatment: " . $data['trend'][0]['y'] . " <b>(" . $data['per'][0] . "%)</b>";
		$str .= "<br />Dead: " . $data['trend'][1]['y'] . " <b>(" . $data['per'][1] . "%)</b>";
		$str .= "<br />Lost to Follow Up: " . $data['trend'][2]['y'] . " <b>(" . $data['per'][2] . "%)</b>";
		$str .= "<br />Transferred out: " . $data['trend'][3]['y'] . " <b>(" . $data['per'][3] . "%)</b>";
		$str .= "<br />Adults: " . $data['other'][0] . " <b>(" . $data['per'][4] . "%)</b>";
		$str .= "<br />Other: " . $data['other'][1] . " <b>(" . $data['per'][5] . "%)</b>";

		$data['stats'] = $str;


		$data['div'] = "hei_pie";
		$data['content'] = "hei_content";
		
		

		return $data;
	}

	
}
?>