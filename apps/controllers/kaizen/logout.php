<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->session->unset_userdata('web_admin_user_name');
		$this->session->unset_userdata('web_admin_user_id');
		$this->session->unset_userdata('web_admin_logged_in');
		$this->session->sess_destroy();
		redirect('kaizen/welcome','refresh');
	}
}