<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends MY_Controller {

	public $data = array();

	function __construct()
	{
		parent::__construct();
		$this->data	= array_merge($this->data,$this->load_libraries(array('material','custom','select2')));
		$this->data['contacts'] = TRUE;
	}

	public function login($errors=NULL)
	{
		$this->data['content_view'] = 'survey/login_view';
		if($errors == 1){
			$this->data['errors'] = "Credentials do not match that of any user.";			
		}
		$this -> template($this->data);
	}

	public function logger()
	{
		$password = sha1($this->input->post('password') . "kasdhf9879%@#4a");
		$username = $this->input->post('username');

		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$user = $this->db->get('surveyors')->row();

		if(isset($user)){
			$this->session->set_userdata('user_id', $user->id);
			$this->session->set_userdata('user_type', $user->admin);
			if($user->admin == 1){
				redirect('/survey/create_user');
			}
			redirect('/survey/surveys');
		}
		else{
			redirect('/survey/login/1');
		}
	}

	public function logout(){
		$this->session->unset_userdata(['user_id', 'user_type', 'survey_id']);
		redirect('/survey/login');
	}

	public function create_user()
	{
		$this->check_auth(1);
		$this->data['content_view'] = 'survey/create_user';
		$this -> template($this->data);
	}

	public function save_user()
	{
		$this->check_auth(1);

		$data = array(
			'name' => $this->input->post('name'),
			'username' => $this->input->post('username'),
			'password' => sha1($this->input->post('password') . "kasdhf9879%@#4a"),
			'admin' => $this->input->post('admin')
		);		

		$db1 = $this->load->database('eid_survey', true);

		$db1->insert('surveyors', $data);
		redirect('/survey/create_user');
	}

	public function index()
	{
		$this->check_auth();
		$this->data['content_view'] = 'survey/details_view';
		$this -> template($this->data);
	}

	public function submit()
	{
		$this->check_auth();
		$data = array(
			'facility' => $this->input->post('facility'),
			'poc' => $this->input->post('poc'),
			'survey_date' => $this->input->post('dos'),
			'surveyor_id' => $this->session->userdata('user_id')
		);		

		$db1 = $this->load->database('eid_survey', true);

		$db1->insert('survey', $data);

		$id = $db1->insert_id();

		$this->session->set_userdata('survey_id', $id);

		redirect('/survey/survey_details/' . $id);
	}

	public function surveys()
	{
		$this->check_auth();
		$this->data['content_view'] = 'survey/survey_details_view';

		$this->db->select('survey.*, view_facilitys.name, view_facilitys.countyname, count(survey_details.id) as my_count');
		$this->db->join('view_facilitys', 'view_facilitys.id = survey.facility');
		$this->db->join('survey_details', 'survey.id = survey_details.survey_id');
		$this->db->where('survey.surveyor_id', $this->session->userdata('user_id'));
		$this->db->group_by("survey.id");
		$surveys = $this->db->get('survey')->result_array();

		$ul = "";

		foreach ($surveys as  $key => $value) {
			$ul .= "<tr>";
			$ul .= "<td>" . $value['name'] . "</td>";
			$ul .= "<td>" . $value['countyname'] . "</td>";
			$ul .= "<td>" . $this->resolve_poc($value['poc']) . "</td>";
			$ul .= "<td>" . $value['survey_date'] . "</td>";
			$ul .= "<td>" . $value['my_count'] . "</td>";
			$ul .= "<td> <a href='" . base_url('survey/survey_details/' . $value['id']) . "'> Add Survey</a> </td>";
			$ul .= "<td> <a href='" . base_url('survey/delete_survey_det/' . $value['id']) . "'> Delete</a> </td>";
			$ul .= "</tr>";
		}

		$this->data['surveys'] = $ul;
		$this -> template($this->data);
	}

	public function delete_survey_det($id=NULL)
	{
		$this->check_auth();
		$db1 = $this->load->database('eid_survey', true);
		$db1->delete('survey', array('id' => $id));
		redirect('/survey/surveys/');
	}



	public function survey_details($survey_id=NULL)
	{
		$this->check_auth();
		$this->data['content_view'] = 'survey/survey_view';
		$this->data['survey_id'] = $survey_id;

		// $surveys = $this->db->get_where('survey_details', array('survey_id' => $survey_id));
		$this->data['entrypoints'] = $this->db->get('entry_points');

		$this->db->where('survey_id', $survey_id);
		$surveys = $this->db->get('survey_details')->result_array();

		$ul = "";

		foreach ($surveys as  $key => $value) {
			$ul .= "<tr>";
			$ul .= "<td>" . $value['date-of-birth'] . "</td>";
			$ul .= "<td>" . $this->resolve_gender($value['gender']) . "</td>";
			$ul .= "<td>" . $this->resolve_entry($value['entrypoint']) . "</td>";
			$ul .= "<td>" . $value['date-of-visit'] . "</td>";
			$ul .= "<td>" . $value['date-collected'] . "</td>";
			$ul .= "<td>" . $value['date-tested'] . "</td>";
			$ul .= "<td>" . $value['date-dispatch'] . "</td>";
			$ul .= "<td>" . $this->resolve_result($value['result']) . "</td>";
			$ul .= "<td>" . $this->resolve_art($value['art-initiated']) . "</td>";
			$ul .= "<td>" . $value['date-art'] . "</td>";
			$ul .= "<td> <a href='" . base_url('survey/edit_survey/' . $value['id']) . "'> Edit</a> </td>";
			$ul .= "<td> <a href='" . base_url('survey/delete_survey/' . $value['id']) . "'> Delete</a> </td>";
			$ul .= "</tr>";
		}

		$this->data['surveys'] = $ul;
		$this -> template($this->data);
	}

	public function details()
	{
		$this->check_auth();
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

		$db1 = $this->load->database('eid_survey', true);

		$db1->insert('survey_details', $data);

		redirect('/survey/survey_details/' . $this->input->post('survey_id'));
	}

	public function edit_survey($id){
		$this->check_auth();
		$this->data['content_view'] = 'survey/survey_view_edit';
		$this->data['entrypoints'] = $this->db->get('entry_points')->result_array();

		$this->db->where('id', $id);
		$survey = $this->db->get('survey_details')->result_array();
		$this->data['survey'] = $survey[0];
		$this->data['survey_id'] = $survey[0]['survey_id'];
		$this -> template($this->data);
	}

	public function update_survey($id)
	{
		$this->check_auth();
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

		$db1 = $this->load->database('eid_survey', true);

		$db1->set($data);
		$db1->where('id', $id);
		$db1->update('survey_details');

		redirect('/survey/survey_details/' . $this->input->post('survey_id'));

	}

	public function delete_survey($id)
	{
		$this->check_auth();
		$db1 = $this->load->database('eid_survey', true);
		$db1->delete('survey_details', array('id' => $id));
		redirect('/survey/survey_details/' . $this->session->userdata('survey_id'));
	}

	public function view_users(){
		$this->check_auth(1);
		$sql = "SELECT surveyors.*, COUNT(survey_details.id) AS surveys_done ";
		$sql .= "FROM surveyors LEFT JOIN survey ON surveyors.id = survey.surveyor_id ";
		$sql .= "LEFT JOIN survey_details ON survey.id = survey_details.survey_id ";
		$sql .= "GROUP BY surveyors.id";

		$result = $this->db->query($sql)->result_array();

		$ul = "";

		foreach ($result as  $key => $value) {
			$ul .= "<tr>";
			$ul .= "<td>" . $value['name'] . "</td>";
			$ul .= "<td>" . $this->resolve_user($value['admin']) . "</td>";
			$ul .= "<td>" . $value['surveys_done'] . "</td>";
			$ul .= "<td>" . $value['username'] . "</td>";
			$ul .= "<td> <a href='" . base_url('survey/delete_user/' . $value['id']) . "'> Delete</a> </td>";
			$ul .= "</tr>";
		}

		$this->data['surveys'] = $ul;
		$this->data['content_view'] = 'survey/user';
		$this -> template($this->data);


	}

	public function view_surveys(){
		$this->check_auth();
		// $sql = "SELECT * ";
		// $sql .= "FROM surveyors LEFT JOIN survey ON surveyors.id = survey.surveyor_id ";
		// $sql .= "LEFT JOIN survey_details ON survey.id = survey_details.survey_id ";
		// $sql .= "LEFT JOIN survey_details ON survey.id = survey_details.survey_id ";

		// $result = $this->db->query($sql)->result_array();


		$this->db->select('survey.*, survey_details.*, surveyors.*, view_facilitys.name as facility_name, view_facilitys.countyname');
		$this->db->join('survey_details', 'survey.id = survey_details.survey_id');
		$this->db->join('view_facilitys', 'view_facilitys.id = survey.facility');
		$this->db->join('surveyors', 'surveyors.id = survey.surveyor_id');

		$this->data['admin'] = true;

		if ($this->session->userdata('user_type') != 1) {
			$this->db->where('survey.surveyor_id', $this->session->userdata('user_id'));
			$this->data['admin'] = false;
		}

		$result = $this->db->get('survey')->result_array();

		$ul = "";

		foreach ($result as  $key => $value) {
			$ul .= "<tr>";
			$ul .= "<td>" . $value['facility_name'] . "</td>";
			$ul .= "<td>" . $value['countyname'] . "</td>";
			$ul .= "<td>" . $this->resolve_poc($value['poc']) . "</td>";
			$ul .= "<td>" . $value['survey_date'] . "</td>";

			$ul .= "<td>" . $value['name'] . "</td>";

			$ul .= "<td>" . $value['date-of-birth'] . "</td>";
			$ul .= "<td>" . $this->resolve_gender($value['gender']) . "</td>";
			$ul .= "<td>" . $this->resolve_entry($value['entrypoint']) . "</td>";
			$ul .= "<td>" . $value['date-of-visit'] . "</td>";
			$ul .= "<td>" . $value['date-collected'] . "</td>";
			$ul .= "<td>" . $value['date-tested'] . "</td>";
			$ul .= "<td>" . $value['date-dispatch'] . "</td>";
			$ul .= "<td>" . $this->resolve_result($value['result']) . "</td>";
			$ul .= "<td>" . $this->resolve_art($value['art-initiated']) . "</td>";
			$ul .= "<td>" . $value['date-art'] . "</td>";

			$ul .= "</tr>";
		}

		$this->data['surveys'] = $ul;
		$this->data['content_view'] = 'survey/view_surveys';
		$this -> template($this->data);


	}



	public function delete_user($id=NULL)
	{
		$this->check_auth(1);
		$db1 = $this->load->database('eid_survey', true);
		$db1->delete('surveyors', array('id' => $id));
		redirect('/survey/view_users/');
	}

	private function check_auth($admin = null){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_id == null){
			redirect('/survey/login');
		}
		if($admin == 1 && ($user_type == null || $this->session->userdata('user_type') != 1)){
			redirect('/survey/login');
		}
	}

	private function resolve_entry($id){
		$id = (int) $id;
		$entry;
		switch ($id) {
			case 1:
				$entry = "OPD";
				break;
			case 2:
				$entry = "Paediatric Ward";
				break;
			case 3:
				$entry = "MCH/PMTCT";
				break;
			case 4:
				$entry = "CCC/PSC";
				break;
			case 5:
				$entry = "Maternity";
				break;
			case 6:
				$entry = "Other";
				break;
			case 7:
				$entry = "No Data";
				break;			
			default:
				$entry = "OPD";
				break;
		}
		return $entry;
	}

	private function resolve_gender($id){
		if($id == "M"){
			return "Male";
		}else{
			return "Female";
		}
	}

	private function resolve_user($id){
		if($id == 1){
			return "Administrator";
		}else{
			return "Data Clerk";
		}
	}

	private function resolve_poc($id){
		if($id == 1){
			return "POC";
		}else{
			return "Non POC";
		}
	}

	private function resolve_result($id){
		$id = (int) $id;
		if($id == 1){
			return "Negative";
		}else{
			return "Positive";
		}
	}

	private function resolve_art($id){
		$id = (int) $id;
		if($id == 1){
			return "Yes";
		}else{
			return "No";
		}
	}


}