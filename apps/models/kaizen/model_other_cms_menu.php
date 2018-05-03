<?php
class Model_other_cms_menu extends CI_Model{

	var	$site_id='';
	
	public function __construct(){
		parent::__construct();	
		$this->site_id=$this->session->userdata('SITE_ID');		
	}
	
	public function count_menu(){
		
		$query = $this->db->query("SELECT `id` FROM `".$this->db->dbprefix('other_cms_pages')."` where `site_id`='".$this->site_id."' LIMIT 0,1");
		#echo $this->db->last_query();exit;
		if($query->num_rows()>0){
			return true;
		}
		else{		
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}
	}
	
	public function cms_menu($where=''){
		if($query = $this->db->query("SELECT `id`,`parent_id`,`title`,`page_link`,`display_order` FROM `".$this->db->dbprefix('other_cms_pages')."` ".$where." ORDER BY `parent_id`,`display_order` ASC"))
		{
			return $query->result();	
		}
		else
		{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}
	}

}
?>