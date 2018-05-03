<?php
class Model_gallery extends MY_Model{
	
	var $site_id='';
	public function __construct(){
		parent::__construct();	
		$this->site_id=$this->config->item("SITE_ID");	
		if($this->session->userdata('language_version') == "french"){
			$this->db->set_dbprefix('is_french_');
		}
		
	}
	
	public function gallery_list($offset=0,$limit=15,$like)
	{
		$offset 	= (int) $offset;
		$limit 		= (int) $limit;
		
		$qu = "SELECT * FROM `".$this->db->dbprefix('gallery')."` where is_active = '1'  ";
		
		
		if(!empty($like)){
		$i = 0;
        foreach($like as $key => $val){
			if(empty($i)){
			$qu .= " and (".$key." like '%".$val."%'";	
            	//$this->db->like($key, $val);
			}else{
				$qu .= " or ".$key." like '%".$val."%'";	
				//$this->db->or_like($key, $val); 
			}
			
			$i++;
			if(count($like) == $i){$qu .= ")";}
        }
   	 } 
		
		$qu .= " order by title asc LIMIT {$offset},{$limit}";
		$query = $this->db->query($qu);
		
		return $query->result();
	}
	public function total_gallery_list($like)
	{
		
		$qu = "SELECT * FROM `".$this->db->dbprefix('gallery')."` where is_active = '1'  ";
		
		
		if(!empty($like)){
		$i = 0;
        foreach($like as $key => $val){
			if(empty($i)){
			$qu .= " and (".$key." like '%".$val."%'";	
            	//$this->db->like($key, $val);
			}else{
				$qu .= " or ".$key." like '%".$val."%'";	
				//$this->db->or_like($key, $val); 
			}
			
			$i++;
			if(count($like) == $i){$qu .= ")";}
        }
   	 } 
		
		$qu .= " order by title asc ";
				
		$query = $this->db->query($qu);
		#echo $this->db->last_query();
		//echo count($query->result());
		return count($query->result());
	}
	
}
?>