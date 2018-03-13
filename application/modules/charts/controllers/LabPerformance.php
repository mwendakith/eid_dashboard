<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class LabPerformance extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('performance_model');
	}

	function lab_performance_stats($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['stats'] = $this->performance_model->lab_performance_stat($year,$month,$to_year,$to_month);

		$link = $year . '/' . $month . '/' . $to_year . '/' . $to_month;

		$data['link'] = base_url('charts/LabPerformance/download_lab_performance_stats/' . $link) ;

		$this->load->view('lab_performance_stats_view', $data);
	}

	function download_lab_performance_stats($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL)
	{
		$this->performance_model->download_lab_performance_stat($year,$month,$to_year,$to_month);
	}

	function lab_testing_trends($year=NULL)
	{
		$obj['trends'] = $this->performance_model->lab_testing_trends($year);
		
		$data['trends'] = $obj['trends']['test_trends'];
		$data['title'] = "";
		$data['div'] = "#labs_test_trends";
		$data['div_name'] = "labs_test_trends";
		$data['suffix'] = "";
		$data['yAxis'] = "Number of Tests";

		// echo "<pre>";print_r($data);die();
		$this->load->view('lab_performance_view', $data);
	}

	function lab_positivity_trends($year=NULL)
	{
		$obj['trends'] = $this->performance_model->lab_testing_trends($year);
		
		$data['trends'] = $obj['trends']['positivity_trends'];
		$data['title'] = "";
		$data['div'] = "#positivity";
		$data['div_name'] = "positivity";
		$data['suffix'] = "%";
		$data['yAxis'] = "Positivity (%)";

		// echo "<pre>";print_r($data);die();
		$this->load->view('lab_performance_view', $data);
	}

	function lab_rejected_trends($year=NULL)
	{
		$obj['trends'] = $this->performance_model->lab_testing_trends($year);
		
		$data['trends'] = $obj['trends']['rejected_trends'];
		$data['title'] = "";
		$data['div'] = "#rejects";
		$data['div_name'] = "rejects";
		$data['suffix'] = "%";
		$data['yAxis'] = "Rejection (%)";

		// echo "<pre>";print_r($data);die();
		$this->load->view('lab_performance_view', $data);
	}

	function lab_outcomes($year=NULL, $month=NULL,$to_year=NULL,$to_month=NULL){
		$data['trends'] = $this->performance_model->lab_outcomes($year,$month,$to_year,$to_month);
		// echo json_encode($data);die();
		$this->load->view('lab_outcomes_view', $data);

	}

	function lab_turnaround($year=NULL, $month=NULL,$to_year=NULL,$to_month=NULL){
		$data = $this->performance_model->lab_turnaround($year,$month,$to_year,$to_month);
		//echo json_encode($data);

		foreach ($data as $key => $value) {
			$this->load->view('lab_turnaround_time_view', $value);
		}
		
		$this->load->view('lab_turnaround_key_view');

	}

	function lab_trends($lab=NULL){
		$obj = $this->performance_model->yearly_trends($lab);
		$data['class'] = "class='col-md-6'";
		// echo "<pre>";print_r($obj);echo "</pre>";die();
		$data['trends'] = $obj['test_trends'];
		$data['title'] = "Testing Trends";
		$data['div'] = "#tests2";
		$data['div_name'] = "tests2";
		$data['suffix'] = "";
		$data['yAxis'] = "Number of Tests";
		$this->load->view('lab_performance_view', $data);

		$data['trends'] = $obj['positivity_trends'];
		$data['title'] = "Positivity Trends";
		$data['div'] = "#positivity2";
		$data['div_name'] = "positivity2";
		$data['suffix'] = "%";
		$data['yAxis'] = "Positivity (%)";
		$this->load->view('lab_performance_view', $data);

		$data['trends'] = $obj['rejected_trends'];
		$data['title'] = "Rejection Rate Trends";
		$data['div'] = "#rejects2";
		$data['div_name'] = "rejects2";
		$data['suffix'] = "%";
		$data['yAxis'] = "Rejection (%)";
		$this->load->view('lab_performance_view', $data);

		$data['trends'] = $obj['tat4_trends'];
		$data['title'] = "Turn Around Time ( Collection - Dispatch )";
		$data['div'] = "#tat";
		$data['div_name'] = "tat";
		$data['suffix'] = "";
		$data['yAxis'] = "TAT(Days)";
		$this->load->view('lab_performance_view', $data);

		//echo json_encode($obj);
		//echo "<pr>";print_r($obj);die;

	}

	function summary($lab=NULL, $year=NULL){
		$data['trends'] = $this->performance_model->yearly_summary($lab, $year);
		$data['div_name'] = "lab_trends_2";
		//$data['trends'] = $this->positivity_model->yearly_summary();
		//echo json_encode($data);
		// echo "<pre>";print_r($data);die();
		$this->load->view('trends_outcomes_view', $data);
	}

	function rejections($lab=NULL, $year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['trends'] = $this->performance_model->rejections($lab, $year,$month,$to_year,$to_month);
		$data['div_name'] = "total_lab_rejections";
		
		$this->load->view('trends_outcomes_view', $data);
	}

	function lab_mapping($lab=NULL, $year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data = $this->performance_model->lab_mapping($lab, $year,$month,$to_year,$to_month);
		$data['div_name'] = "lab_map_div";
		
		$this->load->view('map_view', $data);
	}


}