<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Factsheet extends CI_Controller {
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
       		$page_link = $this->uri->segment(2);
			if($page_link == "index"){
				$this->load->view('templates/fact',$this->data);
			}else{
				$this->data["page_link"] = $page_link;
				$this->load->view('templates/fact_details',$this->data);
			}
                 
		
	}	
	
	
}