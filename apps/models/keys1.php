<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Keys extends CI_Controller {
	var $data;
	public function __construct() {
	   parent::__construct();
	   // Set master content and sub-views
	   $this->load->vars( array(
		  'header' => 'templates/common/header',
		  'footer' => 'templates/common/footer'
		));
		$this->load->model('model_home');	
	}
	public function index()	{
			$this->load->view('templates/pages',$this->data);
		
	}	
	
	
}