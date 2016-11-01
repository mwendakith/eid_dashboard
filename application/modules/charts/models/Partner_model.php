<?php
defined("BASEPATH") or exit("No direct script access allowed");

/**
* 
*/
class Partner_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();;
	}

	function yearly_trends($partner=NULL){

		if($partner == NULL || $partner == 0){
			$partner = 0;
		}

		$sql = "CALL `proc_get_eid_partner_performance`(" . $partner . ");";

		$result = $this->db->query($sql)->result_array();

		$i = 0;

		$b = true;
		$year;

		$data;

		foreach ($result as $key => $value) {
			if($b){
				$b = false;
				$year = (int) $value['year'];
			}


			$y = (int) $value['year'];
			if($value['year'] != $year){
				$i++;
				$year--;
			}

			$month = (int) $value['month'];
			$month--;


			$data['test_trends'][$i]['name'] = $value['year'];
			$data['test_trends'][$i]['data'][$month] = (int) $value['tests'];

			$data['rejected_trends'][$i]['name'] = $value['year'];

			if($value['tests'] == 0){
				$data['rejected_trends'][$i]['data'][$month] = 0;
			}else{
				$data['rejected_trends'][$i]['data'][$month] = (int)
				($value['rej'] / $value['tests'] * 100);
			}

			$data['positivity_trends'][$i]['name'] = $value['year'];

			if ($value['pos'] == 0){
				$data['positivity_trends'][$i]['data'][$month] = 0;
			}else{
				$data['positivity_trends'][$i]['data'][$month] = (int) 
				($value['pos'] / ($value['pos'] + $value['neg']) * 100 );
			}

			$data['infant_trends'][$i]['name'] = $value['year'];
			$data['infant_trends'][$i]['data'][$month] = (int) $value['infants'];
			
		}
		

		return $data;
	}

	function yearly_summary($partner=NULL){

		if($partner == NULL){
			$partner = 0;
		}

		$sql = "CALL `proc_get_eid_partner_year_summary`(" . $partner . ");";

		$result = $this->db->query($sql)->result_array();

		
		$i = 0;

		$data;

		$data['outcomes'][0]['name'] = "Redraws";
		$data['outcomes'][1]['name'] = "Positive";
		$data['outcomes'][2]['name'] = "Negative";
		$data['outcomes'][3]['name'] = "Positivity";

		$data['outcomes'][0]['color'] = '#52B3D9';
		$data['outcomes'][1]['color'] = '#E26A6A';
		$data['outcomes'][2]['color'] = '#257766';
		$data['outcomes'][3]['color'] = '#913D88';

		$data['outcomes'][0]['type'] = "column";
		$data['outcomes'][1]['type'] = "column";
		$data['outcomes'][2]['type'] = "column";
		$data['outcomes'][3]['type'] = "spline";

		$data['outcomes'][0]['yAxis'] = 1;
		$data['outcomes'][1]['yAxis'] = 1;
		$data['outcomes'][2]['yAxis'] = 1;

		foreach ($result as $key => $value) {
			$data['categories'][$i] = $value['year'];

			$data['outcomes'][0]['data'][$i] = (int) $value['redraws'];
			$data['outcomes'][1]['data'][$i] = (int) $value['positive'];
			$data['outcomes'][2]['data'][$i] = (int) $value['negative'];
			$data['outcomes'][3]['data'][$i] = round(((int) $value['positive']*100)/((int) $value['negative']+(int) $value['positive']+(int) $value['redraws']),1);
			$i++;
		}
		$data['outcomes'][0]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][1]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][2]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][3]['tooltip'] = array("valueSuffix" => ' %');
		
		$data['title'] = "Outcomes";

		return $data;
	}




}