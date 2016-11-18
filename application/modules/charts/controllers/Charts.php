<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Charts extends MY_Controller {

	
	public function index()
	{
		 if( $z <= 1) return true;

	    for( $elf = floor(sqrt($z)); $elf > 1; $elf--) { 
	        for( $rtk = ceil(log($z)/log($elf)); $rtk > 1; $rtk--) { 
	            if( pow($elf,$rtk) == $z) return true;
	            break;
	        }
	        
	    }
	    return false;
		
	}

	function excel_test()
	{
		$this->load->helper('download');
        $this->load->library('PHPReport/PHPReport');

		$data = array(array('ID' => 2,
						'Name' => 'Joshua',
						'Email' => 'baksajoshua@gmail.com',
						'year' => 2016));

		$template = 'Myexcel.xlsx';

	    //set absolute path to directory with template files
	    $templateDir = __DIR__ . "/";

	    //set config for report
	    $config = array(
	        'template' => $template,
	        'templateDir' => $templateDir
	    );


	      //load template
	    $R = new PHPReport($config);
	    
	    $R->load(array(
	            'id' => 'data',
	            'repeat' => TRUE,
	            'data' => $data   
	        )
	    );
	      
	      // define output directoy 
	    $output_file_dir = __DIR__ ."/tmp/";
	     // echo "<pre>";print_r("Still working");die();

	    $output_file_excel = $output_file_dir  . "Myexcel.xlsx";
	    //download excel sheet with data in /tmp folder
	    // $result = $R->render('excel', $output_file_excel);
	    force_download($output_file_excel, null);
	}

}
?>