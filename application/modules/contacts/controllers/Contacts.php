<?php
defined('BASEPATH') or exit('No direct script access allowed!');
require_once('phpmailer/class.phpmailer.php');
define('GUSER', 'nascop.eid.eic@gmail.com'); // Gmail username
define('GPWD', 'masaiboy'); // Gmail password
/**
* 
*/
class Contacts extends MY_Controller
{
	public $data = array();
	
	//comment to demo
	function __construct()
	{
		parent::__construct();
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','custom')));
		$this->data['contacts'] = TRUE;
		// $this->load->library('phpmailer/class.phpmailer');
	}

	function index()
	{
		$this->data['content_view'] = 'contacts/contacts_view';
		// echo "<pre>";print_r($this->data);die();
		$this -> template($this->data);
	}

	function submit()
	{
		print_r($this->input->post());die();
		require_once __DIR__ . '/../../../libraries/autoload.php';
		$secret = '6LfymQsUAAAAAFay69bbyGSjTH4ofVgFxv7kyuGQ';
		$recaptcha = new \ReCaptcha\ReCaptcha($secret);
		$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
		print_r($resp);die();

		$data = array();
		$name = $this->input->post('cname');
		$email = $this->input->post('cemail');
		$subject = $this->input->post('csubject');
		$message = $this->input->post('cmessage')."\n\n".$name." ".$this->input->post('cphone');

		$responce = $this->smtpmailer($email, $name, $subject, $message);
		if ($responce) {
			$sent = 1;
		} else {
			$sent = 0;
		}
		
		echo $sent;
	}

	function smtpmailer($from, $from_name, $subject, $body) { 
		global $error;
		$mail = new PHPMailer();  // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true;  // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465; 
		$mail->Username = GUSER;  
		$mail->Password = GPWD;           
		$mail->From($from);
		$mail->FromName($from_name);
		$mail->AddReplyTo($from, $from_name);
		$mail->Subject = 'EID DASHBOARD: '.$subject;
		$mail->Body = $body;
		// $mail->AddAddress('jbatuka@usaid.gov');
		// $mail->AddAddress('jhungu@clintonhealthaccess.org');
		// $mail->AddAddress('aaron.mbowa@dataposit.co.ke');
		// $mail->AddAddress('jlusike@clintonhealthaccess.org');
		// $mail->AddAddress('tngugi@clintonhealthaccess.org');
		$mail->AddAddress('baksajoshua09@gmail.com');
		$mail->AddAddress('joelkith@gmail.com');
		if(!$mail->Send()) {
			$error = 'Mail error: '.$mail->ErrorInfo; 
			return false;
		} else {
			$error = 'Message sent!';
			return true;
		}
	}

	function validate_email($email=null)
	{
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		  echo 1;
		} else {
		  echo 0;
		}
	}
}
?>