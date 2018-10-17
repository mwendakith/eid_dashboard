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

	public function positivity($year=null,$month=null,$to_year=null,$to_month=null,$type=null,$agency_id=null) {
		$data['trends'] = $this->agencies_model->positivity($year,$month,$to_year,$to_month,$type,$agency_id);
		$data['div_name'] = "funding_agencies_positivity";
		if (!($type == null || $type == 'null'))
			$data['div_name'] = "partner_funding_agencies_positivity";

		$this->load->view('trends_outcomes_view', $data);
	}
}

?>