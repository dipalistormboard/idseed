<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {
	var $data;
	public function __construct() {
	   parent::__construct();	  
	   	
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function captcha_check()	{
		$cc = FALSE;
	 	$captcha = $this->input->post('captcha',TRUE);
	 	$valid_captcha = $this->session->userdata('wasif_captcha');
		if ($captcha == $valid_captcha){
			$cc = TRUE;
		}
		else{
			$this->form_validation->set_message('captcha_check', 'Please use correct captcha');			
			$cc = FALSE;
		}
		#unset captcha
		$array_items = array('wasif_captcha' => '');
		$this->session->unset_userdata($array_items);			
		return $cc;
	}

	
	public function contact_form(){
		
		$full_name	=	$this->input->post('name',TRUE);
		$email		=	$this->input->post('email',TRUE);
		$phone		=	$this->input->post('phone',TRUE);			
		$comments	=	$this->input->post('comment',TRUE);
				
		$this->data['details']->full_name 	= $full_name;
		$this->data['details']->email 		= $email;
		$this->data['details']->phone 		= $phone;
		$this->data['details']->comments 	= $comments;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');		
		$this->form_validation->set_rules('comment', 'Comments', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');
		$this->form_validation->set_rules('captcha', 'Captcha', 'trim|required|xss_clean|callback_captcha_check');
		
		$this->form_validation->set_error_delimiters('<div style="font-weight:bold;color:#B00;text-align:center" align="center">', '</div>');
		$err = array();
		if($this->form_validation->run() == TRUE){
			
					$this->load->library('email');
					$config['protocol'] 	= 'smtp';
					$config['smtp_host'] 	= 'smtp.emailsrvr.com';
					$config['smtp_user'] 	= 'noreply@sfnfci.ca';
					$config['smtp_pass'] 	= 'FnF!2014';
					$config['smtp_port'] 	= '25';
					$config['wordwrap'] 	= TRUE;
					$config['validate'] 	= TRUE;
					$config['mailtype'] 	= 'html';
					$config['newline'] 		= "\r\n";
					$this->email->initialize($config);

					$message ='<!DOCTYPE HTML>
					<html>
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<title>'.$this->config->item("COMPANY_NAME").'</title>
					</head>					
					<body>
					<table align="center" width="600" border="1" cellpadding="4" cellspacing="0">
					<tr><td><b>Name</b></td><td>'.stripslashes($full_name).'</td></tr>
					<tr><td><b>Email</b></td><td>'.$email.'</td></tr>
					<tr><td><b>Phone</b></td><td>'.$phone.'</td></tr>
					<tr><td valign="top"><b>Comments</b></td><td>'.nl2br(strip_tags(stripslashes($comments))).'</td></tr>
					</table>
					</body>
					</html>';
					$cont_name	=	$this->input->post('name',TRUE);
					$cont_email =	$this->input->post('email',TRUE);
					$this->email->from('noreply@sfnfci.ca');
					$this->email->to($this->data['site_settings']->contact_email);
					#$this->email->bcc('sangeeta@2webdesign.com');
					$this->email->reply_to($email);
					$this->email->subject('Contact Request from '.$this->config->item("COMPANY_NAME"));
					$this->email->message($message);
					$this->email->send();
					echo json_encode($err);
			
		}
		else 
		{
			 $err['full_name'] = form_error('fullname');
			 $err['comments'] = form_error('comments');
			 $err['email'] = form_error('email');
			 $err['captcha'] = form_error('captcha');
			/* $err['phone'] = form_error('phone');*/
			 echo json_encode($err);
		}
		
	}
	
	public function mailbox_form(){
		
		 $email		=	$this->input->post('mailbox_email',TRUE);
		 $url = base_url()."public/constantcontact/examples/addOrUpdateContact.php";
		 $curl = curl_init();
 
		 curl_setopt($curl, CURLOPT_URL, $url);
		 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		 curl_setopt($curl, CURLOPT_HEADER, false);
		 $pparams = '&email='.$email.'&first_name=&last_name=&list=1350125458&';
		 $pparams .= urlencode($pparams);
		 curl_setopt($curl, CURLOPT_POSTFIELDS,  $pparams);
		 curl_setopt($curl,	CURLOPT_POST, 1);
		 $str = curl_exec($curl);
	
		 curl_close($curl);
		 echo $succ_msg = "Thank you for the subscription!";
	}
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */