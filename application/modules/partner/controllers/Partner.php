<?php
defined('BASEPATH') or exit('No direct script access allowed!');
/**
* 
*/
class Partner extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->module('summaries');
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','custom','select2','tablecloth')));
		$this->session->unset_userdata('county_filter');
		$this->data['part'] = TRUE;
	}

	function index()
	{
		$this->clear_all_session_data();
		$this->session->unset_userdata('partner_filter');
		$this->load->module('charts/partner_summaries');
		
		$this->data['content_view'] = 'partner/partner_summary_view';
		$this -> template($this->data);
	}

	function trends()
	{
		$this->clear_all_session_data();
		$this->session->unset_userdata('partner_filter');
		$this->load->module('charts/partnertrends');
		
		$this->data['content_view'] = 'partner/partner_trends_view';
		$this -> template($this->data);
		
	}

	function sites()
	{
		$this->clear_all_session_data();
		$this->session->unset_userdata('partner_filter');
		$this->load->module('charts/sites');

		$this->data['content_view'] = 'partner/partner_sites_view';
		// echo "<pre>";print_r($this->data);die();
		$this -> template($this->data);
	}

	function counties()
	{
		$this->clear_all_session_data();
		$this->session->unset_userdata('partner_filter');
		$this->load->module('charts/partner_summaries');

		$this->data['content_view'] = 'partner/partner_counties_view';
		// echo "<pre>";print_r($this->data);die();
		$this -> template($this->data);
	}

	function heivalidation()
	{
		$this->clear_all_session_data();
		$this->data['content_view'] = 'partner/partner_hei_validation_view';
		// echo "<pre>";print_r($this->data);die();
		$this -> template($this->data);
	}

	function tat()
	{
		$this->clear_all_session_data();
		$this->data['content_view'] = 'partner/partner_tat_view';

		$this->template($this->data);
	}

	function agencies() {
		$this->clear_all_session_data();
		$this->data['content_view'] = 'partner/partner_agencies_view';
		$this->data['agencies_flag'] = TRUE;
		$this->template($this->data);
	}

	public function get_selected_partner()
	{
		if ($this->session->userdata('partner_filter')) {
			$partner = $this->session->userdata('partner_filter');
		} else {
			$partner = 1;
		}
		 echo $partner;
	}

	public function check_partner_select()
	{
		if ($this->session->userdata('partner_filter')) {
			$partner = $this->session->userdata('partner_filter');
		} else {
			$partner = 0;
		}
		echo json_encode($partner);
	}

	function excel_test($partner=null)
	{
		header('Content-type: application/excel');
		$filename = 'filename.xls';
		header('Content-Disposition: attachment; filename='.$filename);
		$this->load->module('charts/sites');

		$conc = $this->sites->partner_sites_excel($partner);
		// echo "<pre>";print_r($conc);die();

		$data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
		<head>
		    <!--[if gte mso 9]>
		    <xml>
		        <x:ExcelWorkbook>
		            <x:ExcelWorksheets>
		                <x:ExcelWorksheet>
		                    <x:Name>Sheet 1</x:Name>
		                    <x:WorksheetOptions>
		                        <x:Print>
		                            <x:ValidPrinterInfo/>
		                        </x:Print>
		                    </x:WorksheetOptions>
		                </x:ExcelWorksheet>
		            </x:ExcelWorksheets>
		        </x:ExcelWorkbook>
		    </xml>
		    <![endif]-->
		</head>

		<body>
		   <table>
				<thead>
					<tr class="colhead">
						<th rowspan="2">#</th>
						<th rowspan="2">MFL Code</th>
						<th rowspan="2">Name</th>
						<th rowspan="2">County</th>
						<th rowspan="2">Tests</th>
						<th rowspan="2">1st DNA PCR</th>
						<th rowspan="2">Confirmed PCR</th>
						<th rowspan="2">+</th>
						<th rowspan="2">-</th>
						<th rowspan="2">Redraws</th>
						<th colspan="2">Adults</th>
						<th rowspan="2">Median Age</th>
						<th rowspan="2">Rejected</th>
						<th rowspan="2">Infants &lt;2M</th>
						<th rowspan="2">Infants &lt;2M +</th>
					</tr>
					<tr>
						<th>Tests</th>
						<th>+</th>
					</tr>
				</thead>
				<tbody>
					'.$conc.'
				</tbody>
			</table>
		</body></html>';

		echo $data;
	}
}
?>