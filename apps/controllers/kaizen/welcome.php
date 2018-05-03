<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {	
	
	public function __construct() {
	   parent::__construct();
	   // Set master content and sub-views
	   $this->load->vars( array(
		  'global' => 'Available to all views',
		  'header' => 'kaizen/common/header_login',
		  'footer' => 'kaizen/common/footer_login'
		));
	}

	public function index(){
		if($this->session->userdata('web_admin_logged_in')==TRUE) {
			redirect('kaizen/main','refresh');
		}
		$data['error'] = "Please login with your credentials";
		
		
		$this->load->view('kaizen/login_page', $data);
	}
	
	public function authentication(){
		
		if($this->session->userdata('prefered_language')) {
			
		}else{
			$prefered_language	= "english";
		}
		$this->load->helper('security');
		$username = xss_clean($this->input->post('uname'));
		$password = xss_clean($this->input->post('pwd'));
		
		if($username == "" || $password == "")
		{
			$data['error'] = "Invalid Username/Password";
			$this->load->view('kaizen/login_page', $data);
		}
		else
		{
			$this->load->model('kaizen/model_login');
			$result = $this->model_login->login($username, $password);

			if($result) 
			{
				if($result->id == '1' || $result->id == '2')
				{				
					
					$session_data = array(
					   "web_admin_user_name"  => $username, 
					   "web_admin_user_id"  => $result->id,   
					   "web_admin_logged_in" => TRUE,
					   "prefered_language"	=> $prefered_language
					);
					
					$this->model_login->update($result->id,$username);		
	
					$this->session->set_userdata($session_data);
					redirect('kaizen/main');
				}
				else
				{
					$this->model_login->update($result->id,$username);
					$data['error'] = "Access Denied for Usergroup";
					$this->load->view('kaizen/login_page', $data);
				}
			}
			else
			{
				$this->model_login->update(0,$username);
				$data['error'] = "Invalid Username/Password";
				$this->load->view('kaizen/login_page', $data);
			}
		}
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */