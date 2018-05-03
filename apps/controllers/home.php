<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	var $data = array();
	public function __construct() {
	   parent::__construct();
	   // Set master content and sub-views
	   $this->load->vars( array(		  
		  'header' => 'templates/common/header',
		  'footer' => 'templates/common/footer'
		));
	}

	
	public function index()	{
		$this->load->model('model_home');
		
		$this->data['banner'] = $this->model_home->gethomebanner();
		
		$this->load->view('templates/home',$this->data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */