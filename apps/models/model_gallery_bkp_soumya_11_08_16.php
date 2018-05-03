<?php
class Model_gallery extends MY_Model{
	
	var $site_id='';
	public function __construct(){
		parent::__construct();	
		$this->site_id=$this->config->item("SITE_ID");	
//		if($this->session->userdata('language_version') == "french"){
//					$this->db->set_dbprefix('is_french_');
//				}
        $this->db->set_dbprefix('is_');
	}
}
?>