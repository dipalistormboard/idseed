<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pages extends CI_Controller {
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
        $this->data['sub']='';
		if($this->data['hooks_meta']->id == 2){
			$this->data['hooks_meta']->parent_id  = $this->data['hooks_meta']->id;
		}
        $sub_page = $this->model_home->getSubPage($this->data['hooks_meta']->parent_id);
        $this->data["sub_page"] = $sub_page;
		if($this->data['hooks_meta']->page_link=="glossary")
		{
			$this->data["glossary_dist"] = $this->model_home->getdic("glossary");
			$this->load->view('templates/glossary',$this->data);
		}elseif($this->data['hooks_meta']->page_link=="contact"){
			$this->data["contact_list"] = $this->model_home->getcontact("contact");
			$this->load->view('templates/contact',$this->data);
		}elseif($this->data['hooks_meta']->page_link=="fact-sheets"){
			$this->load->view('templates/fact',$this->data);
                 
		}else{
              
			$this->load->view('templates/pages',$this->data);
		}
	}	
	
	
}