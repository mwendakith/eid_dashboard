<?php 
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Sites extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('sites_model');
	}

	function site_outcomes($year=NULL,$month=NULL)
	{
		$data['outcomes'] = $this->sites_model->sites_outcomes($year,$month);

    	$this->load->view('site_outcomes_view',$data);
	}

	function site_trends($site=NULL,$year=NULL)
	{
		$obj = $this->sites_model->get_trends($site,$year);

		$data['trends'] = $obj['trends'];
		$data['title'] = "Test Trends (" . $obj['year'] . ")";
		$data['div'] = "#tests";
		$data['div_name'] = "tests";
		$data['suffix'] = " ";
		$data['yAxis'] = "Number of Tests";
		$this->load->view('site_trends_view', $data);
	}

	function site_positivity($site=NULL, $year=NULL){
		$data = $this->sites_model->get_positivity($site,$year);
		
		$this->load->view('site_positivity_view', $data);
	}

	function site_eid($site=NULL, $year=NULL, $month=NULL){
		$data = $this->sites_model->get_eid($site, $year, $month);
		$data['div'] = "eid_pie";
		$data['content'] = "eid_content";
		$data['title'] = "EID";
		$str = "Total Tests: " . $data['value'][0];
		$str .= "<br />Total Positives: " . $data['trend'][0]['y'] . "(" . $data['value'][1] . "%)";
		$str .= "<br />Total Negatives: " . $data['trend'][1]['y'] . "(" . $data['value'][2] . "%)";
		$str .= "<br />Total Rejected: " . $data['value'][3] . "(" . $data['value'][4] . "%)";
		$data['stats'] = $str;
		$this->load->view('sites_pie_chart_view', $data);
		//echo json_encode($data);

	}

	function site_hei($site=NULL, $year=NULL, $month=NULL){
		$data = $this->sites_model->get_hei($site, $year, $month);
		$data['div'] = "hei_pie";
		$data['content'] = "hei_content";
		$data['title'] = "HEI Follow Up";

		$str = "Enrolled: " . $data['trend'][0]['y'];
		$str .= "<br />Dead: " . $data['trend'][1]['y'];
		$str .= "<br />Lost to follow up: " . $data['trend'][2]['y'];
		$str .= "<br />Transferred out: " . $data['trend'][3]['y'];

		$data['stats'] = $str;
		
		$this->load->view('sites_pie_chart_view', $data);
		//echo json_encode($data);
	}

}
?>