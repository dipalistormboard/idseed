<?php 
/**
* Base Controller - All controllers should extend this one.
* @author Raul Chedrese
*/
class MY_Controller extends CI_Controller {

  public $data = array();

  function __construct() {
    parent::__construct();
    $this->data['errors'] = array();
    $this->data['site_name'] = config_item('site_name');
  }
  
  public function authenticate() {
		if($this->session->userdata('web_admin_logged_in')!=TRUE) {
  		$data['error'] = "Please login with your credentials";

  		$this->load->view('kaizen/login_page', $data);
      redirect('kaizen/welcome');
		}	
  }
  
}