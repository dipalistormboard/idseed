<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common extends CI_Controller {
	
	public function __construct() {
	   parent::__construct();
	   
	}
	public function index()	{
		
	} 
	
        public function changelanguage(){
			
            $language_version = $this->uri->segment(3);
            $newdata = array(
                        'language_version'  => $language_version
                    );

            $this->session->set_userdata($newdata);
            $current_url = $this->input->get("current_url");
            redirect($current_url, 'refresh');
        }

        

        public function contact_form(){
        
		$name	=	$this->input->post('name',TRUE);
		$email		=	$this->input->post('email',TRUE);
		$phone		=	$this->input->post('phone',TRUE);
		$subject	=	$this->input->post('subject',TRUE);
		$comments	=	$this->input->post('message',TRUE);
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');
		
		$this->form_validation->set_error_delimiters('');
		if($this->form_validation->run() == TRUE)
		{
	         $this->load->library('email');
			 $config['wordwrap'] = TRUE;
			 $config['validate'] = TRUE;
			 $config['mailtype'] = 'html';
			 $this->email->initialize($config);
			$message ='<!DOCTYPE HTML>
					<html>
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<title>'.$this->config->item("COMPANY_NAME").'</title>
					</head>					
					<body>
					<table align="center" width="600" border="1" cellpadding="4" cellspacing="0">'; 
			if(!empty($name)){
                $message.='<tr><td><b>Name:</b></td><td>'.$name.'</td></tr>';
            }
			if(!empty($phone)){
                $message.='<tr><td><b>Phone No:</b></td><td>'.$phone.'</td></tr>';
            }
			if(!empty($subject)){
                $message.='<tr><td><b>Subject:</b></td><td>'.$subject.'</td></tr>';
            }
			if(!empty($comments)){
                $message.='<tr><td><b>Message:</b></td><td>'.$comments.'</td></tr>';
            }
            $message.='</table>
					</body>
					</html>';
            $this->email->from($email, stripslashes($this->config->item("COMPANY_NAME")));
            $this->email->to($this->data['site_settings']->contact_email);
            $this->email->subject('Contact from '.outputEscapeString($this->config->item("COMPANY_NAME")));
            $this->email->message($message);
			$this->email->send();
            $err =  '';
				echo json_encode($err);
		}
			else{
			 $err['name'] = form_error('name');
			 $err['email'] = form_error('email');
			 $err['message'] = form_error('message');
			 echo json_encode($err);
			}
	}
	
	
}