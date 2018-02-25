<?php
defined("BASEPATH") or exit("No direct script access allowed");

/**
* 
*/
class Trends_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();;
	}

	function yearly_trends($county=NULL){

		if($county == NULL || $county == 48){
			$county = 0;
		}

		if ($county == 0) {
			$sql = "CALL `proc_get_eid_national_yearly_tests`();";
		} else {
			$sql = "CALL `proc_get_eid_yearly_tests`(" . $county . ");";
		}
		
		$result = $this->db->query($sql)->result_array();
		
		$year;
		$i = 0;
		$b = true;

		$data;

		$cur_year = date('Y');

		foreach ($result as $key => $value) {

			if((int) $value['year'] > $cur_year || (int) $value['year'] < 2008){

			}
			else{
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
					($value['rejected'] / $value['tests'] * 100);
				}

				$data['positivity_trends'][$i]['name'] = $value['year'];

				if ($value['positive'] == 0){
					$data['positivity_trends'][$i]['data'][$month] = 0;
				}else{
					$data['positivity_trends'][$i]['data'][$month] = (int) 
					($value['positive'] / ($value['positive'] + $value['negative']) * 100 );
				}

				$data['infant_trends'][$i]['name'] = $value['year'];
				$data['infant_trends'][$i]['data'][$month] = (int) $value['infants'];

				$data['tat4_trends'][$i]['name'] = $value['year'];
				$data['tat4_trends'][$i]['data'][$month] = (int) $value['tat4'];
			}

		}
		

		return $data;
	}

	function yearly_summary($county=NULL){

		if($county == NULL || $county == 48){
			$county = 0;
		}
		
		if($county==0){
			$sql = "CALL `proc_get_eid_national_yearly_summary`();";
		} else {
			$sql = "CALL `proc_get_eid_yearly_summary`(" . $county . ");";
		}
		// echo "<pre>";print_r($sql);die();
		
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$year = date("Y");
		$i = 0;

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
			if($value['year'] != 2007){
				$data['categories'][$i] = $value['year'];
			
				$data['outcomes'][0]['data'][$i] = (int) $value['redraws'];
				$data['outcomes'][1]['data'][$i] = (int) $value['positive'];
				$data['outcomes'][2]['data'][$i] = (int) $value['negative'];
				$data['outcomes'][3]['data'][$i] = round(((int) $value['positive']*100)/((int) $value['negative']+(int) $value['positive']+(int) $value['redraws']),1);
				$i++;
			}
			
		}
		$data['outcomes'][0]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][1]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][2]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][3]['tooltip'] = array("valueSuffix" => ' %');

		$data['title'] = "Outcomes (Initial PCR)";

		return $data;
	}

	function quarterly_trends($county=NULL){

		if($county == NULL || $county == 48){
			$county = 0;
		}

		if ($county == 0) {
			$sql = "CALL `proc_get_eid_national_yearly_tests`();";
		} else {
			$sql = "CALL `proc_get_eid_yearly_tests`(" . $county . ");";
		}
		
		$result = $this->db->query($sql)->result_array();
		
		$year;
		$i = 0;
		$b = true;
		$limit = 0;
		$quarter = 1;
		$month;

		$data;

		foreach ($result as $key => $value) {

			if($b){
				$b = false;
				$year = (int) $value['year'];
			}

			$y = (int) $value['year'];
			$name = $y . ' Q' . $quarter;
			if($value['year'] != $year){
				$year--;
				if($month != 2){
					$i++;
				}
			}

			$m = (int) $value['month'];
			$modulo = ($m % 3);

			$month = $modulo-1;

			if($modulo == 0){
				$month = 2;
			}			

			$data['test_trends'][$i]['name'] = $name;
			$data['test_trends'][$i]['data'][$month] = (int) $value['tests'];

			$data['rejected_trends'][$i]['name'] = $name;

			if($value['tests'] == 0){
				$data['rejected_trends'][$i]['data'][$month] = 0;
			}else{
				$data['rejected_trends'][$i]['data'][$month] = (int)
				($value['rejected'] / $value['tests'] * 100);
			}

			$data['positivity_trends'][$i]['name'] = $name;

			if ($value['positive'] == 0){
				$data['positivity_trends'][$i]['data'][$month] = 0;
			}else{
				$data['positivity_trends'][$i]['data'][$month] = (int) 
				($value['positive'] / ($value['positive'] + $value['negative']) * 100 );
			}

			$data['infant_trends'][$i]['name'] = $name;
			$data['infant_trends'][$i]['data'][$month] = (int) $value['infants'];

			$data['tat4_trends'][$i]['name'] = $name;
			$data['tat4_trends'][$i]['data'][$month] = (int) $value['tat4'];

			if($modulo == 0){
				$i++;
				$quarter++;
				$limit++;
			}
			if($quarter == 5){
				$quarter = 1;
			}
			if ($limit == 8) {
				break;
			}



		}
		

		return $data;
	}

	function quarterly_outcomes($county=NULL){

		if($county == NULL || $county == 48){
			$county = 0;
		}

		if ($county == 0) {
			$sql = "CALL `proc_get_eid_national_yearly_tests`();";
		} else {
			$sql = "CALL `proc_get_eid_yearly_tests`(" . $county . ");";
		}
		
		$result = $this->db->query($sql)->result_array();
		
		$year;
		$prev_year = date('Y') - 1;
		$cur_month = date('m');

		// $columns =  ceil($cur_month / 3);
		// $columns += 8;
		// $i = $columns-1;
		$b = true;
		$limit = 0;
		$quarter = 1;

		$prev_year = date('Y') - 1;
		$cur_month = date('m');

		$extra =  ceil($cur_month / 3);

		if($extra == 4){
			$i = 4;
			$columns = 8;
		}
		else{
			$i = 8;
			$columns = 8 + $extra;
		}
		
		// $year;
		// $i = 8;
		// $b = true;
		// $limit = 0;
		// $quarter = 1;

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

		$data['title'] = "Outcomes (Initial PCR)";

		$data['categories'] = array_fill(0, $columns, "Null");
		$data['outcomes'][0]['data'] = array_fill(0, $columns, 0);
		$data['outcomes'][1]['data'] = array_fill(0, $columns, 0);
		$data['outcomes'][2]['data'] = array_fill(0, $columns, 0);
		$data['outcomes'][3]['data'] = array_fill(0, $columns, 0);


		foreach ($result as $key => $value) {

			if($b){
				$b = false;
				$year = (int) $value['year'];
			}

			$y = (int) $value['year'];
			$name = $y . ' Q' . $quarter;
			if($value['year'] != $year){
				$year--;

				if($year == $prev_year && $extra != 4){
					$data['outcomes'][3]['data'][$i] += round(@(( $data['outcomes'][1]['data'][$i]*100)/
					($data['outcomes'][0]['data'][$i]+$data['outcomes'][1]['data'][$i]+$data['outcomes'][2]['data'][$i])),1);
					$i = 4;
					$quarter=1;
					$limit++;

				}
			}

			$month = (int) $value['month'];
			$modulo = ($month % 3);

			$data['categories'][$i] = $name;

			$data['outcomes'][0]['data'][$i] += (int) $value['redraw'];
			$data['outcomes'][1]['data'][$i] += (int) $value['positive'];
			$data['outcomes'][2]['data'][$i] += (int) $value['negative'];			

			if($modulo == 0){
				$data['outcomes'][3]['data'][$i] += round(@(( $data['outcomes'][1]['data'][$i]*100)/
					($data['outcomes'][0]['data'][$i]+$data['outcomes'][1]['data'][$i]+$data['outcomes'][2]['data'][$i])),1);

				$i++;
				$quarter++;
				$limit++;

			}
			if($quarter == 5){
				$quarter = 1;
				$i = 0;
			}	

			if ($limit == $columns) {
				break;
			}


		}

		return $data;

	}

	

	function alltests($county=NULL){
		return $this->any_quarterly('allpositive', 'allnegative', 'Outcomes (All Tests)', $county);
	}

	function rtests($county=NULL){
		return $this->any_quarterly('rpos', 'rneg', 'Outcomes (Repeat Tests)', $county);
	}

	function infant_tests($county=NULL){
		return $this->any_quarterly('infantspos', 'infants', 'Outcomes (Infants <2m)', $county);
	}



	function any_quarterly($pos_c, $neg_c, $title, $county=NULL){

		if($county == NULL || $county == 48){
			$county = 0;
		}

		if ($county == 0) {
			$sql = "CALL `proc_get_eid_national_yearly_tests`();";
		} else {
			$sql = "CALL `proc_get_eid_yearly_tests`(" . $county . ");";
		}
		
		$result = $this->db->query($sql)->result_array();
		
		$year;
		$prev_year = date('Y') - 1;
		$cur_month = date('m');

		// $columns =  ceil($cur_month / 3);
		// $columns += 8;
		// $i = $columns-1;
		$b = true;
		$limit = 0;
		$quarter = 1;

		$extra =  ceil($cur_month / 3);

		if($extra == 4){
			$i = 4;
			$columns = 8;
		}
		else{
			$i = 8;
			$columns = 8 + $extra;
		}

		$data['outcomes'][0]['name'] = "Positive";
		$data['outcomes'][1]['name'] = "Negative";
		$data['outcomes'][2]['name'] = "Positivity";

		$data['outcomes'][0]['color'] = '#E26A6A';
		$data['outcomes'][1]['color'] = '#257766';
		$data['outcomes'][2]['color'] = '#913D88';

		$data['outcomes'][0]['type'] = "column";
		$data['outcomes'][1]['type'] = "column";
		$data['outcomes'][2]['type'] = "spline";

		$data['outcomes'][0]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][1]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][2]['tooltip'] = array("valueSuffix" => ' %');

		$data['outcomes'][0]['yAxis'] = 1;
		$data['outcomes'][1]['yAxis'] = 1;

		$data['title'] = $title;

		$data['categories'] = array_fill(0, $columns, "Null");
		$data['outcomes'][0]['data'] = array_fill(0, $columns, 0);
		$data['outcomes'][1]['data'] = array_fill(0, $columns, 0);
		$data['outcomes'][2]['data'] = array_fill(0, $columns, 0);


		foreach ($result as $key => $value) {

			if($b){
				$b = false;
				$year = (int) $value['year'];
			}

			$y = (int) $value['year'];
			$name = $y . ' Q' . $quarter;

			if($value['year'] != $year){
				$year--;

				if($year == $prev_year && $extra != 4){
					$data['outcomes'][2]['data'][$i] = round(@(( $data['outcomes'][0]['data'][$i]*100)/
					( $data['outcomes'][0]['data'][$i] + $data['outcomes'][1]['data'][$i] )),1);
					$i = 4;
					$quarter=1;
					$limit++;

				}

			}

			$month = (int) $value['month'];
			$modulo = ($month % 3);

			$data['categories'][$i] = $name;

			$data['outcomes'][0]['data'][$i] += (int) $value[$pos_c];
			$data['outcomes'][1]['data'][$i] += (int) $value[$neg_c];

			if($neg_c == "infants"){
				$data['outcomes'][1]['data'][$i] -= (int) $value[$pos_c];
			}
			

			if($modulo == 0){
				$data['outcomes'][2]['data'][$i] = round(@(( $data['outcomes'][0]['data'][$i]*100)/
				( $data['outcomes'][0]['data'][$i]+$data['outcomes'][1]['data'][$i] )),1);

				$i++;
				$quarter++;
				$limit++;
			}

			if($quarter == 5){
				$quarter = 1;
				$i = 0;
			}

			if ($limit == $columns) {
				break;
			}

		}
		return $data;
	}



	function ages_2m_quarterly($county=NULL){

		if($county == NULL || $county == 48){
			$county = 0;
		}

		if ($county == 0) {
			$sql = "CALL `proc_get_eid_national_yearly_tests_age`();";
		} else {
			$sql = "CALL `proc_get_eid_yearly_tests`(" . $county . ");";
		}
		
		$result = $this->db->query($sql)->result_array();
		
		$year;
		$prev_year = date('Y') - 1;
		$cur_month = date('m');

		// $columns =  ceil($cur_month / 3);
		// $columns += 8;
		// $i = $columns-1;
		$b = true;
		$limit = 0;
		$quarter = 1;

		$extra =  ceil($cur_month / 3);

		if($extra == 4){
			$i = 4;
			$columns = 8;
		}
		else{
			$i = 8;
			$columns = 8 + $extra;
		}

		$data['outcomes'][0]['name'] = "No Data";
		$data['outcomes'][1]['name'] = ">24m";
		$data['outcomes'][2]['name'] = "12-24m";
		$data['outcomes'][3]['name'] = "9-12m";
		$data['outcomes'][4]['name'] = "2-9m";
		$data['outcomes'][5]['name'] = "<2m";
		$data['outcomes'][6]['name'] = "<2m contribution";

		$data['outcomes'][0]['type'] = "column";
		$data['outcomes'][1]['type'] = "column";
		$data['outcomes'][2]['type'] = "column";
		$data['outcomes'][3]['type'] = "column";
		$data['outcomes'][4]['type'] = "column";
		$data['outcomes'][5]['type'] = "column";
		$data['outcomes'][6]['type'] = "spline";

		$data['outcomes'][0]['yAxis'] = 1;
		$data['outcomes'][1]['yAxis'] = 1;
		$data['outcomes'][2]['yAxis'] = 1;
		$data['outcomes'][3]['yAxis'] = 1;
		$data['outcomes'][4]['yAxis'] = 1;
		$data['outcomes'][5]['yAxis'] = 1;

		$data['outcomes'][0]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][1]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][2]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][3]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][4]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][5]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][6]['tooltip'] = array("valueSuffix" => ' %');

		$data['title'] = "Less 2m Contribution (Initial PCR)";

		$data['categories'] = array_fill(0, $columns, "Null");
		$data['outcomes'][0]['data'] = array_fill(0, $columns, 0);
		$data['outcomes'][1]['data'] = array_fill(0, $columns, 0);
		$data['outcomes'][2]['data'] = array_fill(0, $columns, 0);
		$data['outcomes'][3]['data'] = array_fill(0, $columns, 0);
		$data['outcomes'][4]['data'] = array_fill(0, $columns, 0);
		$data['outcomes'][5]['data'] = array_fill(0, $columns, 0);
		$data['outcomes'][6]['data'] = array_fill(0, $columns, 0);

		foreach ($result as $key => $value) {

			if($b){
				$b = false;
				$year = (int) $value['year'];
			}

			$y = (int) $value['year'];
			$name = $y . ' Q' . $quarter;

			if($value['year'] != $year){
				$year--;

				if($year == $prev_year && $extra != 4){

					$total = $data['outcomes'][0]['data'][$i] + $data['outcomes'][1]['data'][$i] + $data['outcomes'][2]['data'][$i] + $data['outcomes'][3]['data'][$i] + $data['outcomes'][4]['data'][$i] + $data['outcomes'][5]['data'][$i];

					$data['outcomes'][6]['data'][$i] = round(@( $data['outcomes'][5]['data'][$i]*100 / $total ),1);

					$i = 4;
					$quarter=1;
					$limit++;
				}
			}

			$age_range = (int) $value['age_range_id'];
			$month = (int) $value['month'];
			$modulo = ($month % 3);

			$data['categories'][$i] = $name;

			// $data['outcomes'][$age_range]['data'][$i] += ((int) $value['pos'] + (int) $value['neg']);

			switch ($age_range) {
				case 0:
					$data['outcomes'][0]['data'][$i] += (int) $value['pos'] + (int) $value['neg'];
					break;
				case 1:
					$data['outcomes'][5]['data'][$i] += (int) $value['pos'] + (int) $value['neg'];
					break;
				case 2:
					$data['outcomes'][4]['data'][$i] += (int) $value['pos'] + (int) $value['neg'];
					break;
				case 3:
					$data['outcomes'][3]['data'][$i] += (int) $value['pos'] + (int) $value['neg'];
					break;
				case 4:
					$data['outcomes'][2]['data'][$i] += (int) $value['pos'] + (int) $value['neg'];
					break;
				case 5:
					$data['outcomes'][1]['data'][$i] += (int) $value['pos'] + (int) $value['neg'];
					break;
				default:
					break;
			}
			

			if($modulo == 0 && $age_range == 5){
				$total = $data['outcomes'][0]['data'][$i] + $data['outcomes'][1]['data'][$i] + $data['outcomes'][2]['data'][$i] + $data['outcomes'][3]['data'][$i] + $data['outcomes'][4]['data'][$i] + $data['outcomes'][5]['data'][$i];

				$data['outcomes'][6]['data'][$i] = round(@( $data['outcomes'][5]['data'][$i]*100 / $total ),1);

				$i++;
				$quarter++;
				$limit++;
			}

			if($quarter == 5){
				$quarter = 1;
				$i = 0;
			}

			if ($limit == $columns) {
				break;
			}
		}
		return $data;
	}



	function ages_quarterly($county=NULL){

		if($county == NULL || $county == 48){
			$county = 0;
		}

		if ($county == 0) {
			$sql = "CALL `proc_get_eid_national_yearly_tests_age`();";
		} else {
			$sql = "CALL `proc_get_eid_yearly_tests`(" . $county . ");";
		}
		
		$result = $this->db->query($sql)->result_array();
		
		$year;
		$i = 8;
		$b = true;
		$limit = 0;
		$quarter = 1;

		$data;

		$data['outcomes'][0]['name'] = "No Data POS";
		$data['outcomes'][1]['name'] = "No Data NEG";
		$data['outcomes'][2]['name'] = "<2m POS";
		$data['outcomes'][3]['name'] = "<2m NEG";
		$data['outcomes'][4]['name'] = "2-9m POS";
		$data['outcomes'][5]['name'] = "2-9m NEG";
		$data['outcomes'][6]['name'] = "9-12m POS";
		$data['outcomes'][7]['name'] = "9-12m NEG";
		$data['outcomes'][8]['name'] = "12-24m POS";
		$data['outcomes'][9]['name'] = "12-24m NEG";
		$data['outcomes'][10]['name'] = ">24m POS";
		$data['outcomes'][11]['name'] = ">24m NEG";

		$data['title'] = $title;

		$data['categories'] = array_fill(0, 9, "Null");
		$data['outcomes'][0]['data'] = array_fill(0, 9, 0);
		$data['outcomes'][1]['data'] = array_fill(0, 9, 0);
		$data['outcomes'][2]['data'] = array_fill(0, 9, 0);
		$data['outcomes'][3]['data'] = array_fill(0, 9, 0);
		$data['outcomes'][4]['data'] = array_fill(0, 9, 0);
		$data['outcomes'][5]['data'] = array_fill(0, 9, 0);
		$data['outcomes'][6]['data'] = array_fill(0, 9, 0);
		$data['outcomes'][7]['data'] = array_fill(0, 9, 0);
		$data['outcomes'][8]['data'] = array_fill(0, 9, 0);
		$data['outcomes'][9]['data'] = array_fill(0, 9, 0);
		$data['outcomes'][10]['data'] = array_fill(0, 9, 0);
		$data['outcomes'][11]['data'] = array_fill(0, 9, 0);


		foreach ($result as $key => $value) {

			if($b){
				$b = false;
				$year = (int) $value['year'];
			}

			$y = (int) $value['year'];
			$name = $y . ' Q' . $quarter;

			if($value['year'] != $year){
				$year--;

				if($year == 2017){
					$i = 4;
					$quarter=1;
					$limit++;

				}

			}

			$age_range = (int) $value['age_range_id'];
			$month = (int) $value['month'];
			$modulo = ($month % 3);

			$data['categories'][$i] = $name;

			switch ($age_range) {
				case 0:
					$data['outcomes'][0]['data'][$i] += (int) $value[$pos];
					$data['outcomes'][1]['data'][$i] += (int) $value[$neg];
					break;
				case 1:
					$data['outcomes'][2]['data'][$i] += (int) $value[$pos];
					$data['outcomes'][3]['data'][$i] += (int) $value[$neg];
					break;
				case 2:
					$data['outcomes'][4]['data'][$i] += (int) $value[$pos];
					$data['outcomes'][5]['data'][$i] += (int) $value[$neg];
					break;
				case 3:
					$data['outcomes'][6]['data'][$i] += (int) $value[$pos];
					$data['outcomes'][7]['data'][$i] += (int) $value[$neg];
					break;
				case 4:
					$data['outcomes'][8]['data'][$i] += (int) $value[$pos];
					$data['outcomes'][9]['data'][$i] += (int) $value[$neg];
					break;
				case 5:
					$data['outcomes'][10]['data'][$i] += (int) $value[$pos];
					$data['outcomes'][11]['data'][$i] += (int) $value[$neg];
					break;
				default:
					break;
			}
			

			if($modulo == 0){

				$i++;
				$quarter++;
				$limit++;

				if($i == 8){
					$i == 0;
				}

			}

			if($quarter == 5){
				$quarter = 1;
				$i = 0;
			}


			if ($limit == 9) {
				break;
			}


		}

		return $data;

	}


}


?>