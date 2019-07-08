<?php
defined('BASEPATH') or exit('No direct script acceess allowed!');

/**
 * 
 */
class Agencies extends MY_Controller
{
	
	function __construct() {
		parent::__construct();
		$this->load->model('agencies_model');
	}

	public function testing_trends($year=null,$type=null,$agency_id=null) {
		$data['trends'] = $this->agencies_model->test_trends($year,$type,$agency_id);
		$data['div_name'] = "funding_agency_yearly_summary";
		$data['export'] = TRUE;
		$link = $year . '/' . $agency_id;

		$data['link'] = base_url('charts/agencies_model/download_testing_trends/' . $link);

		$this->load->view('trends_outcomes_view', $data);
	}

	public function positivity($year=null,$month=null,$to_year=null,$to_month=null,$type=null,$agency_id=null) {
		$data['trends'] = $this->agencies_model->positivity($year,$month,$to_year,$to_month,$type,$agency_id);
		$data['div_name'] = "funding_agencies_positivity";
		if (!($type == null || $type == 'null'))
			$data['div_name'] = "partner_funding_agencies_positivity";

		$this->load->view('trends_outcomes_view', $data);
	}

	public function outcomes($year=null,$month=null,$to_year=null,$to_month=null,$type=null,$agency_id=null) {
		$data['outcomes'] =$this->agencies_model->outcomes($year,$month,$to_year,$to_month,$type,$agency_id);

		$this->load->view('eid_outcomes_view', $data);
	}

	function hei_validation($year=null,$month=null,$to_year=null,$to_month=null,$type=null,$agency_id=null)
	{
		$data['outcomes'] =$this->agencies_model->hei_validation($year,$month,$to_year,$to_month,$type,$agency_id);

		$this->load->view('hei_validation_pie', $data);
	}

	function hei_follow($year=null,$month=null,$to_year=null,$to_month=null,$type=null,$agency_id=null)
	{
		$data['outcomes'] =$this->agencies_model->hei_follow($year,$month,$to_year,$to_month,$type,$agency_id);

		$this->load->view('hei_view', $data);
	}

	function agegroup($year=null,$month=null,$to_year=null,$to_month=null,$type=null,$agency_id=null)
	{
		$data['outcomes'] =$this->agencies_model->age2($year,$month,$to_year,$to_month,$type,$agency_id);

		$this->load->view('agegroup_view', $data);
	}

	function tests_analysis($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL,$type=0,$agency_id=null)
	{
		if ($type == 0 || $type == '0'){ $title = 'Agencies'; $type = 4; $data['div_name'] = 'funding_agencies'; }
		if ($type == 1 || $type == '1'){ $title = 'Partners'; $type = 4; $data['div_name'] = 'partner_funding_agencies'; }
		if ($type == 2 || $type == '2'){ $title = 'Sub-countys'; }
		if ($type == 3 || $type == '3'){ $title = 'Facilitys'; }
		$data['th']	= '<tr class="colhead">
							<th>#</th>
							<th>'.$title.'</th>
							<th>Total Tests</th>
							<th>Initial PCR</th>
							<th>&lt;=2M</th>
							<th>&lt;=2M(% of Initial PCR)</th>
							<th>2nd/3rd PCR</th>
							<th>% 2nd/3rd PCR</th>
							<th>Confirmatory PCR</th>
							<th>% Confirmatory PCR</th>
						</tr>';
		$data['outcomes'] = $this->agencies_model->tests_analysis($year,$month,$to_year,$to_month,$type,$agency_id);
		$this->load->view('counties_details_view',$data);
	}

	function test_trends_analysis($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL,$type=0,$agency_id=null) {
		$data['trends'] = $this->agencies_model->test_analysis_trends($year,$month,$to_year,$to_month,$type,$agency_id);
		$data['div_name'] = "funding_agency_testing_trends_analysis";
		if (!($type == null || $type == 'null'))
			$data['div_name'] = "partner_funding_agencies_testing_trends_analysis";

		$this->load->view('trends_outcomes_view', $data);
	}
}

?>