<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
* 
*/
class Template extends MY_Controller
{
	
	public function index($data)
	{
		$this->load_template($data);
	}

	public function all_sess()
	{print_r($this->session->all_userdata());}

	public function load_template($data)
	{
		$this->load->model('template_model');

		$data['filter'] = $this->template_model->get_counties_dropdown();
		$data['partner'] = $this->template_model->get_partners_dropdown();
		$data['sites'] = $this->template_model->get_site_dropdown();
		$data['subCounty'] = $this->template_model->get_sub_county_dropdown();
		// $data['breadcrum'] = $this->breadcrum();
		// echo "<pre>";print_r($data);die();
		$this->load->view('template_view',$data);
	}

	function filter_county_data()
	{
		
		$data = array(
				'county' => $this->input->post('county')
			);

		$this->filter_regions($data);

		echo $this->session->userdata('county_filter');
		
	}

	function filter_sub_county_data()
	{
		
		$data = array(
				'sub_county' => $this->input->post('subCounty')
			);
		// echo "<pre>";print_r($data);die();
		$this->filter_sub_county($data);

		echo $this->session->userdata('sub_county_filter');
		
	}

	function filter_partner_data()
	{
		
		$data = array(
				'partner' => $this->input->post('partner')
			);
		
		$this->filter_partners($data);

		echo $this->session->userdata('partner_filter');
		
	}
	function filter_site_data()
	{
		$data = array(
				'site' => $this->input->post('site')
			);
		
		$this->filter_site($data);

		echo $this->session->userdata('site_filter');
	}

	function filter_date_data()
	{
		$data = array(
				'year' => $this->input->post('year'),
				'month' => $this->input->post('month')
			);
		
		echo $this->set_filter_date($data);
	}

	function breadcrum($data=null,$partner=NULL,$site=NULL,$sub_county=NULL)
	{
		if ($partner=='null'||$partner==null) {
			$partner = NULL;
		}
		if ($site=='null'||$site==null) {
			$site = NULL;
		}
		if ($data=='null'||$data==null) {
			$data = NULL;
		}
		$this->load->model('template_model');
		// echo "<pre>";print_r($data."<___>".$partner."<___>".$site."<___>".$sub_county);die();
		if ($partner) {
			if (!$data) {
				if (!$this->session->userdata('partner_filter')) {
					echo "<a href='javascript:void(0)' class='alert-link'><strong>All Partners</strong></a>";
				} else {
					$partner = $this->template_model->get_partner_name($this->session->userdata('partner_filter'));
					echo "<a href='javascript:void(0)' class='alert-link'><strong>".$partner."</strong></a>";
				}
			} else {
				$partner = $this->template_model->get_partner_name($data);
				echo "<a href='javascript:void(0)' class='alert-link'><strong>".$partner."</strong></a>";
			}
		} else if ($site) {
			if (!$data) {
				if (!$this->session->userdata('site_filter')) {
					echo "<a href='javascript:void(0)' class='alert-link'><strong>All Sites</strong></a>";
				} else {
					$site = $this->template_model->get_site_name($this->session->userdata('site_filter'));
					echo "<a href='javascript:void(0)' class='alert-link'><strong>".$site."</strong></a>";
				}
			} else {
				$site = $this->template_model->get_site_name($data);
				echo "<a href='javascript:void(0)' class='alert-link'><strong>".$site."</strong></a>";
			}
			
		} else if ($sub_county) {
			if (!$data) {
				if (!$this->session->userdata('site_filter')) {
					echo "<a href='javascript:void(0)' class='alert-link'><strong>All Sub-Counties</strong></a>";
				} else {
					$sub_county = $this->template_model->get_sub_county_name($this->session->userdata('site_filter'));
					echo "<a href='javascript:void(0)' class='alert-link'><strong>".$sub_county."</strong></a>";
				}
			} else {
				$sub_county = $this->template_model->get_sub_county_name($data);
				echo "<a href='javascript:void(0)' class='alert-link'><strong>".$sub_county."</strong></a>";
			}
			
		} else {
			if (!$data) {
				if (!$this->session->userdata('county_filter')) {
					echo "<a href='javascript:void(0)' class='alert-link'><strong>Kenya</strong></a>";
				} else {
					$county = $this->template_model->get_county_name($this->session->userdata('county_filter'));
					echo "Kenya / <a href='javascript:void(0)' class='alert-link'><strong>".$county."</strong></a>";
				}
			} else {
				if ($data == '48' || $data == 48) {
					echo "<a href='javascript:void(0)' class='alert-link'><strong>Kenya</strong></a>";
				} else {
					$county = $this->template_model->get_county_name($data);
					echo "Kenya / <a href='javascript:void(0)' class='alert-link'><strong>".$county."</strong></a>";
				}
			}
		}
	}

	function dates()
	{
		$data = array(
					'prev_year' => ($this->session->userdata('filter_year')-1),
					'year' => $this->session->userdata('filter_year'),
					'month' => $this->session->userdata('filter_month'));
		echo json_encode($data);
	}
}
?>