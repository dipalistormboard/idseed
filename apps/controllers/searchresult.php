<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Searchresult extends CI_Controller {
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
			$search = $this->input->post("search");
			$this->data['search'] = $search;
			if(!empty($search)){
				$this->data['search_result'] = $this->model_home->getallsearchdata($search);
			}
			$this->load->view('templates/searchresult',$this->data);
		
	}	
	
	
}