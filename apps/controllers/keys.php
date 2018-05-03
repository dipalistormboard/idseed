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
                        $keys = $this->model_home->gettablecontent("keys");
                        $this->data['keys'] = $keys;
			$this->load->view('templates/keys',$this->data); 
		
	}	
        public function details(){
            $page_link = $this->uri->segment(3);
            $keys_details = $this->model_home->getcontent("keys",$page_link);
            $this->data['keys_details'] = $keys_details;
            $this->load->view('templates/keys_details',$this->data); 
        }
	
	
}