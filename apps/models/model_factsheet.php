<?php
class Model_factsheet extends MY_Model{
	
	var $site_id='';
	public function __construct(){
		parent::__construct();	
		$this->site_id=$this->config->item("SITE_ID");	
		if($this->session->userdata('language_version') == "french"){
			$this->db->set_dbprefix('is_french_');
		}
	}
	
	
    
	function get_factsheet_gallery($gallery_id){
		$sel_query = $this->db->get_where($this->db->dbprefix('gallery'), array('id' => $gallery_id));
			//echo $this->db->last_query();
		if($sel_query->num_rows()>0)
		{		
			$res=$sel_query->row();		
			return $res;
		}
		else
		{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}	
		
	}	
	 
	
	 public function getfactsheets_family(){
			$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('factsheet')."` WHERE  `is_active`='1' and site_id = '".$this->site_id."' group by family order by family asc ");
	//	echo $this->db->last_query();
		if($query)
		{
			return $query->result();	
		}
		else{
			return false;
		}
	}
	public function getfactsheets_family_title($family){
			$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('factsheet')."` WHERE  `is_active`='1' and site_id = '".$this->site_id."' and  family like '".$family."' order by title asc ");
	//	echo $this->db->last_query();
		if($query)
		{
			return $query->result();	
		}
		else{
			return false;
		}
	}
	  public function getfactsheets_sci(){
			$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('factsheet')."` WHERE  `is_active`='1' and site_id = '".$this->site_id."' order by title asc ");
		//echo $this->db->last_query();
		if($query)
		{
			return $query->result();	
		}
		else{
			return false;
		}
	}
	 public function getfactsheets_comm(){
			$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('factsheet')."` WHERE  `is_active`='1' and site_id = '".$this->site_id."' order by common_name asc ");
		//echo $this->db->last_query();
		if($query)
		{
			return $query->result();	
		}
		else{
			return false;
		}
	}
	public function getfactsheets_reg($id){
			$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('factsheet')."` WHERE  `is_active`='1' and regulation_keyword in('".$id."') and  site_id = '".$this->site_id."' order by regulation_keyword asc ");
		echo $this->db->last_query();
		if($query)
		{
			return $query->result();	
		}
		else{
			return false;
		}
	}
	public function getfactsheets_all(){
			$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('factsheet')."` WHERE  `is_active`='1' and site_id = '".$this->site_id."' order by regulation_keyword asc ");
		//echo $this->db->last_query();
		if($query)
		{
			return $query->result();	
		}
		else{
			return false;
		}
	}
	
	  public function getfactsheet_detail($page_link){
			$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('factsheet')."` WHERE  page_link = '".$page_link."' ");
	//	echo $this->db->last_query();
		if($query)
		{
			return $query->row();	
		}
		else{
			return false;
		}
	}
	
	public function getfactsheet_image_gallery($factsheet_master_id){
		//$this->db->set_dbprefix('is_');
		if($this->session->userdata('language_version') == "french"){
			$this->db->set_dbprefix('is_french_');
		}
		else{
		  $this->db->set_dbprefix('is_');
		}
			$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('factsheet_image_gallery')."`  WHERE factsheet_master_id = '".$factsheet_master_id."' ");
		//echo $this->db->last_query();
		if($query)
		{
			return $query->result();	
		}
		else{
			return false;
		}
	}
   public function getfactsheet_species_images($factsheet_master_id){
		$this->db->set_dbprefix('is_');
			$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('factsheet_similar_species_image')."`  WHERE factsheet_master_id = '".$factsheet_master_id."' ");
		//echo $this->db->last_query();
		if($query)
		{
			return $query->result();	
		}
		else{
			return false;
		}
	}
	
}
?>