<?php
class Model_home extends MY_Model{
	
	var $site_id='';
	public function __construct(){
		parent::__construct();	
		$this->site_id=$this->config->item("SITE_ID");	
		if($this->session->userdata('language_version') == "french"){
			$this->db->set_dbprefix('is_french_');
		}
	}
	
	public function gethomebanner(){
		if($query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('banner')."` WHERE  `is_active`='1' order by display_order > 0 desc,display_order asc "))
		{
			return $query->result();	
		}
		else{
			return false;
		}
	}
	
	public function getcontent($curtable,$url){
		$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix($curtable)."` WHERE  `is_active`='1' AND `site_id`='".$this->site_id."' AND `page_link`='".$url."'");
		#echo $this->db->last_query();
		if($query)
		{
			return $query->row();	
		}
		else{
			return false;
		}
	}	
	
	public function getglossarycontent($title){
		$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix("glossary")."` WHERE `title` like '".$title."%' AND  `is_active`='1'  AND `site_id`='".$this->site_id."' ORDER BY `title` ASC");
		#echo $this->db->last_query();
		if($query)
		{
			return $query->result();	
		}
		else{
			return false;
		}
	}	
	
	public function getdic($curtable){
		$query = $this->db->query("SELECT DISTINCT LEFT(title, 1) as letter FROM `".$this->db->dbprefix($curtable)."` WHERE  `is_active`='1' AND `site_id`='".$this->site_id."' ORDER BY letter ASC");
		#echo $this->db->last_query();
		if($query)
		{
			return $query->result();	
		}
		else{
			return false;
		}
	}	
	public function getcontact($curtable){
		$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix($curtable)."` WHERE  `is_active`='1' AND `site_id`='".$this->site_id."'");
		#echo $this->db->last_query();
		if($query)
		{
			return $query->row();	
		}
		else{
			return false;
		}
	}
        public function gettablecontent($curtable){
		$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix($curtable)."` WHERE  `is_active`='1' order by display_order > 0 desc,display_order asc ");
		#echo $this->db->last_query();
		if($query)
		{
			return $query->result();	
		}
		else{
			return false;
		}
	}
    public function getSubPage($parent_id){
        $query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('cms_pages')."` WHERE `is_active`='1' AND `parent_id`='".$parent_id."'");
		#echo $this->db->last_query();
		if($query){
			#echo $this->db->last_query();
			return $query->result();	
		}
		else{
			
				return false;
			
			
		}
    }
	public function getallsearchdata($search){
		$main_result_arr = array();
		$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('cms_pages')."`WHERE `is_active`='1' and `id` != '1' and (`title` like '%".$search."%' or `content` like '%".$search."%' ) ");
		
		if($query){
			if ($query->num_rows() > 0)
			{
				$main_result_arr["pages"] = $query->result();
			}
		}
		
		
		$query_gal = $this->db->query("SELECT DISTINCT id,gallery_photo,title,sub_title,excerpt FROM `".$this->db->dbprefix('gallery')."` WHERE `is_active`='1' and (`title` like '%".$search."%' or `sub_title` like '%".$search."%' or `excerpt` like '%".$search."%' or `description` like '%".$search."%' ) ");
		
		if($query_gal){
			if ($query_gal->num_rows() > 0)
			{
				$main_result_arr["gallery"] = $query_gal->result();
			}
		}
		
		return $main_result_arr;
	}
	
}
?>