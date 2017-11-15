<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends MY_Controller {

	public $data = array();

	function __construct()
	{
		parent::__construct();
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','custom','select2')));
		$this->data['contacts'] = TRUE;
	}

	public function index()
	{
		$this->data['content_view'] = 'survey/details_view';
		$this -> template($this->data);
	}

	public function submit()
	{
		$data = array(
			'facility' => $this->input->post('facility'),
			'county' => $this->input->post('county'),
			'poc' => $this->input->post('poc'),
			'name' => $this->input->post('name'),
			'survey_date' => $this->input->post('dos')
		);

		$this->db->insert('survey', $data);

		$id = $this->db->insert_id();

		redirect('/survey/survey_details/' . $id);
	}

	public function survey_details($survey_id=NULL)
	{
		$this->data['content_view'] = 'survey/survey_view';
		$this->data['survey_id'] = $survey_id;
		$this -> template($this->data);
	}

	public function details()
	{
		$data = array(
			'survey_id' => $this->input->post('survey_id'),
			'date-of-birth' => $this->input->post('dob'),
			'gender' => $this->input->post('gender'),
			'entrypoint' => $this->input->post('entry'),
			'date-of-visit' => $this->input->post('dov'),
			'date-collected' => $this->input->post('doc'),
			'date-tested' => $this->input->post('dot'),
			'date-dispatch' => $this->input->post('dor'),
			'result' => $this->input->post('result'),
			'art-initiated' => $this->input->post('art'),
			'date-art' => $this->input->post('do-art')
		);

		$this->db->insert('survey_details', $data);

		redirect('/survey/survey_details/' . $this->input->post('survey_id'));
	}


}