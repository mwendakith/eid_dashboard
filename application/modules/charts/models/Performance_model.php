<?php
defined("BASEPATH") or exit("No direct script access allowed");

/**
* 
*/
class Performance_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();;
	}

	function lab_performance_stat($year=NULL,$month=NULL)
	{
		// echo round(3.6451895227869, 2, PHP_ROUND_HALF_UP);die();
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

		$sql = "CALL `proc_get_eid_lab_performance_stats`('".$year."','".$month."');";

		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);echo "</pre>";die();
		$ul = '';
		foreach ($result as $key => $value) {
			$ul .= "<tr>
						<td>".($key+1)."</td>
						<td>".$value['name']."</td>
						<td>".(int) $value['sitesending']."</td>
						<td>".(int) $value['received']."</td>
						<td>".(int) $value['rejected'] . " (" . 
							round(@(($value['rejected']*100)/$value['tests']), 2, PHP_ROUND_HALF_UP)."%)</td>
						<td>".(int) $value['redraw']."</td>

						<td>".(int) $value['alltests']."</td>
						<td>".(int) $value['tests']."</td>
						<td>".((int) $value['confirmdna'] + (int) $value['repeatspos'])."</td>
						<td>".(int) $value['eqa']."</td>
						<td>".((int) $value['alltests'] + (int) $value['eqa'] + (int) $value['confirmdna'] + (int) $value['repeatspos'])."</td>
						<td>".(int) $value['pos']."</td>
						<td>".round(@(($value['pos']*100)/$value['tests']), 2, PHP_ROUND_HALF_UP)."</td>
						<td>".(int) $value['neg']."</td>
						<td>".round(@(($value['neg']*100)/$value['tests']), 2, PHP_ROUND_HALF_UP)."</td>
						<td>".(int) $value['redraw']."</td>
						<td>".round(@(($value['redraw']*100)/$value['tests']), 2, PHP_ROUND_HALF_UP)."</td>
					</tr>";
		}

		return $ul;
	}


	function download_lab_performance_stat($year=NULL,$month=NULL)
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

		$sql = "CALL `proc_get_eid_lab_performance_stats`('".$year."','".$month."');";

		

		$this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "lab_performance.csv";

        $result = $this->db->query($sql)->result_array();

		$data;

		foreach ($result as $key => $value) {

			$data[$key]['name'] = $value['name']; 
			$data[$key]['sitesending'] = (int) $value['sitesending']; 
			$data[$key]['received'] = $value['received'];
			$data[$key]['rejected'] = $value['rejected']. " (" . 
							round(@(($value['rejected']*100)/$value['tests']), 2, PHP_ROUND_HALF_UP)."%)"; 
			$data[$key]['redrawal'] =  $value['redraw'];
			$data[$key]['alltests'] = $value['alltests'];
			$data[$key]['tests'] = $value['tests'];  
			$data[$key]['confirms'] = (int) $value['confirmdna'] + (int) $value['repeatspos'];  
			$data[$key]['eqa'] = $value['eqa']; 
			$data[$key]['total_tests'] = (int) $value['alltests'] + (int) $value['eqa'] + (int) $value['confirmdna'] + (int) $value['repeatspos']; 
			$data[$key]['pos'] = $value['pos']; 
			$data[$key]['pos_percentage'] = round(@(($value['pos']*100)/$value['tests']), 2, PHP_ROUND_HALF_UP); 
			$data[$key]['neg'] = $value['neg']; 
			$data[$key]['neg_percentage'] = round(@(($value['neg']*100)/$value['tests']), 2, PHP_ROUND_HALF_UP); 
			$data[$key]['redraw'] = $value['redraw']; 
			$data[$key]['redraw_percentage'] = round(@(($value['redraw']*100)/$value['tests']), 2, PHP_ROUND_HALF_UP); 
		}

		// $this->load->helper('download');
  //       $this->load->library('PHPReport/PHPReport');

  //       ini_set('memory_limit','-1');
	 //    ini_set('max_execution_time', 900);

  //       $template = 'lab_performance_template.xlsx';

	 //    //set absolute path to directory with template files
	 //    $templateDir = __DIR__ . "/";
	    
	 //    //set config for report
	 //    $config = array(
	 //        'template' => $template,
	 //        'templateDir' => $templateDir
	 //    );


	 //      //load template
	 //    $R = new PHPReport($config);
	    
	 //    $R->load(array(
	 //            'id' => 'data',
	 //            'repeat' => TRUE,
	 //            'data' => $data   
	 //        )
	 //    );
	      
	 //      // define output directoy 
	 //    $output_file_dir = __DIR__ ."/tmp/";
	 //     // echo "<pre>";print_r("Still working");die();

	 //    $output_file_excel = $output_file_dir  . "lab_performance.xlsx";
	 //    //download excel sheet with data in /tmp folder
	 //    $result = $R->render('excel', $output_file_excel);
	 //    force_download($output_file_excel, null);

		

        /** open raw memory as file, no need for temp files, be careful not to run out of memory thought */
	    $f = fopen('php://memory', 'w');
	    /** loop through array  */

	    $b = array('Testing Lab', 'Facilities Served', 'Total Samples Received', 'Rejected Samples (on receipt at lab)', 'Redraws (after testing)', 'All Samples Run', 'Valid Test Results', 'Confirmatory Repeat Tests', 'EQA QA/IQC Tests', 'Total Tests Performed', 'Positives', 'Positives(%)', 'Negatives', 'Negatives(%)', 'Redraws', 'Redraws(%)');

	    fputcsv($f, $b, $delimiter);

	    foreach ($data as $line) {
	        /** default php csv handler **/
	        fputcsv($f, $line, $delimiter);
	    }
	    /** rewrind the "file" with the csv lines **/
	    fseek($f, 0);
	    /** modify header to be downloadable csv file **/
	    header('Content-Type: application/csv');
	    header('Content-Disposition: attachement; filename="lab_performance.csv";');
	    /** Send file to browser for download */
	    fpassthru($f);

	}

	function lab_testing_trends($year=NULL)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}

		$data['year'] = $year;

		$sql = "CALL `proc_get_eid_lab_performance`('".$year."')";

		$result = $this->db->query($sql)->result_array();

		$categories = array();
		foreach ($result as $key => $value) {

			$month = (int) $value['month'];
			$month--;

			$lab = (int) $value['ID'];
			$lab--;

			$data['test_trends'][$lab]['name'] = $value['name'];
			$data['test_trends'][$lab]['data'][$month] = (int) $value['tests'];

			$data['rejected_trends'][$lab]['name'] = $value['name'];
			if($value['tests'] == 0){
				$data['rejected_trends'][$lab]['data'][$month] = 0;
			}else{
				$data['rejected_trends'][$lab]['data'][$month] =  
				 round(($value['rejected'] / $value['tests'] * 100), 2);
			}

			$data['positivity_trends'][$lab]['name'] = $value['name'];
			if($value['pos'] == 0){
				$data['positivity_trends'][$lab]['data'][$month] = 0;
			}else{
				$data['positivity_trends'][$lab]['data'][$month] = (int) 
				(($value['pos']/ ($value['pos'] + $value['neg'])) * 100);
			}

		}

		$this->db->close();

		$sql2 = "CALL `proc_get_eid_average_rejection`('".$year."')";
		$result2 = $this->db->query($sql2)->result_array();
			$i = count($data['rejected_trends']);
		$count = 0;
		foreach ($result2 as $key => $value) {
					
			$data['rejected_trends'][$i]['name'] = 'National Rejection Rate';
			$data['rejected_trends'][$i]['data'][$count] = round(@((int) $value['rejected'] * 100 / (int) $value['tests']), 2);
			$count++;
		}

		//echo "<pre>";print_r($data);die();

		return $data;
	}

	function lab_outcomes($year=NULL, $month=NULL){
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
		
		$sql = "CALL `proc_get_eid_lab_outcomes`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$data;
		if($month == 0){
			$data['title'] = "Outcomes (" . $year . ")";
		}
		else{
			$data['title'] = "Outcomes (" . $year . ", " . $this->resolve_month($month) . ")";
		}

		
		foreach ($result as $key => $value) {

			$lab = (int) $value['ID'];
			$lab--;

			$data['categories'][$lab] = $value['name'];

			$data['outcomes'][0]['name'] = "Positive";
			$data['outcomes'][0]['data'][$lab] = (int) $value['pos'];


			$data['outcomes'][1]['name'] = "Negative";
			$data['outcomes'][1]['data'][$lab] = (int) $value['neg'];

			$data['outcomes'][2]['name'] = "Redraws";
			$data['outcomes'][2]['data'][$lab] = (int) $value['redraw'];

		}
		 // echo "<pre>";print_r($data);die();
		return $data;
	}

	function lab_turnaround($year=NULL, $month=NULL){
		$title = null;
		if($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}

		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
				$title = " (" . $year . ")";
			}else {
				$month = $this->session->userdata('filter_month');
				//$title += " (" . $year . ", " . $this->resolve_month($month) . ")";
			}

		}

		if(!$title){
			$title = " (" . $year . ", " . $this->resolve_month($month) . ")";
		}
		 
		

		$sql = "CALL `proc_get_eid_lab_tat`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$data;
		foreach ($result as $key => $value) {
			$lab = (int) $value['ID'];
			$lab--;

			$data[$lab]['div'] = "#container" . ($lab+1);	
			$data[$lab]['div_name'] = "container" . ($lab+1);	
			$data[$lab]['name'] = $value['name'] . $title;	
			$data[$lab]['tat1'] = (int) $value['tat1'];	
			$data[$lab]['tat2'] = (int) $value['tat2'] + $data[$lab]['tat1'];	
			$data[$lab]['tat3'] = (int) $value['tat3'] + $data[$lab]['tat2'];	
			$data[$lab]['tat4'] = (int) $value['tat4'];	
			
		}
		 // echo "<pre>";print_r($data);die();
		return $data;		
	}


}