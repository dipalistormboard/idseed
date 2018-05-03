<?php
class Modelcms extends CI_Model{

	var $id='';	
	var $contentdata=array();
	var $parent_id='';	
	var $meta_title='';
	var $meta_keyword='';
	var $meta_description='';
	var $title='';
	var $content='';
	var $display_order='';
	var $page_link='';
	var $is_active='';
	var	$site_id='';
	var $banner_url='';
	var $banner_text='';
	
	public function __construct()
    {
        parent::__construct();
				$this->site_id=$this->session->userdata('SITE_ID');	
				
    }
	
	
	/**
	 * FIND ALL NO OF RECORDS	 	 
	 *
	 * @access	public	
	 * @return	int
	 */
	
	function getCountAll($curtable,$searchstring="",$language){
		if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}	
		if(!empty($searchstring)){
			$this->db->like('title', $searchstring); 
		}
		$this->db->where('site_id', $this->site_id); 
		$this->db->select('id')->from($this->db->dbprefix($curtable));
		$q = $this->db->get();
		$no_record=$q->num_rows();
		if(!empty($language)){
			$this->db->set_dbprefix('is_');
		}
		#echo $this->db->last_query();exit;	
		if($no_record){				
			return $no_record;	
		}
		else
		{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}
	
	}
	/**
	 * FIND ALL NO OF child RECORDS  with parents
	 *
	 * @access	public	
	 * @return	int
	 */
	function getCountAllById($curtable,$cms_id)
	{
			$where_cond=$this->db->where('parent_id',$cms_id);
			$this->db->where('site_id', $this->site_id); 
			$this->db->select('id')->from($this->db->dbprefix($curtable));
			$q = $this->db->get();
			$no_record=$q->num_rows()+1;
			#echo $this->db->last_query();exit;	
			if($no_record){				
				return $no_record;	
			}
			else
			{
				log_message('error',": ".$this->db->_error_message() );
				return false;
			}
	
	}
		// --------------------------------------------------------------------

	/**
	 * FIND ALL THE RECORDS	 	 
	 *
	 * @access	public	
	 * @return	array
	 */
	
	function getSingleRecord($id){
		
		$sel_query = $this->db->get_where($this->db->dbprefix('cms_pages'), array('id' => $id,'site_id'=>$this->site_id));
		if($sel_query->num_rows()>0){		
			#$res=$sel_query->result();		
			return true;
		}
		else{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}	
		
	}	
	
	
	// --------------------------------------------------------------------

	/**
	 * FIND ALL THE RECORDS	 	 
	 *
	 * @access	public	
	 * @return	array
	 */
	
	function getAllParentDetails($language){
		if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
		$this->db->where('site_id', $this->site_id); 
		$this->db->select('id, title,parent_id,page_link');
		$this->db->from($this->db->dbprefix('cms_pages'));
		$edit_query = $this->db->get();
		#echo $this->db->last_query();exit;
		if($edit_query)
		{
			$edit_res=$edit_query->result();	
			if(!empty($language)){
				$this->db->set_dbprefix('is_');
			}	
			return $edit_res;
		}
		else
		{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}
		
	}	
	
	
	// --------------------------------------------------------------------

	/**
	 * FIND ALL THE RECORDS	 	 
	 *
	 * @access	public	
	 * @return	array
	 */
	
	function getAllDetails($curtable,$limit = NULL, $offset = NULL, $searchstring="",$language){
		if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
		if(!empty($searchstring)){
			$this->db->like('title', $searchstring); 
		}
		$this->db->where('site_id', $this->site_id); 
		$this->db->order_by("display_order >0 desc, display_order asc");
		$sel_query = $this->db->get($this->db->dbprefix($curtable),$limit,$offset);	
		
		#echo $this->db->last_query();
		if($sel_query->num_rows()>0)
		{		
			$res=$sel_query->result();
			if(!empty($language)){
				$this->db->set_dbprefix('is_');
			}		
			return $res;	
		}
		else
		{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}	
		
	}	
	
	
	function getAllDetailsById($curtable,$cms_id,$limit = NULL, $offset = NULL, $searchstring=""){
		if($offset=='0')
		{
		$edit_query=$this->db->get_where($this->db->dbprefix('cms_pages'), array('site_id' => $this->site_id,'id'=>$cms_id));
		$res1=$edit_query->result();		
		}
		else
		{
		$res1=array();
		}
		$this->db->order_by("display_order >0 desc, display_order asc");
		$sel_query = $this->db->get_where($this->db->dbprefix($curtable), array('site_id' => $this->site_id),$limit,$offset);	
		
	
		if($sel_query->num_rows()>0 || count($res1))
		{	
			if(count($res1))
			{
				$res2=$sel_query->result();	
				$res=array_merge($res1,$res2);
			}
			else
			{
				$res=$sel_query->result();	
			}
			return $res;	
		}
		else
		{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}	
		
	}	
	
	
	// --------------------------------------------------------------------

	/**
	 * ADD RECORDS	 	 
	 *
	 * @access	public	
	 * @return	boolean
	 */
	
	function addDetails()
	{		
		$data=$this->contentdata;	
		
		$this->parent_id		=$this->input->post('parent_id','');
		$this->meta_title		=$this->input->post('meta_title',TRUE);
		$this->meta_keyword		=$this->input->post('meta_keyword','');
		$this->meta_description	=$this->input->post('meta_desc','');
		$this->title			=$this->input->post('page_title',TRUE);
		$this->content			=outputEscapeString($this->input->post('content',''));
		$this->display_order	=$this->input->post('display_order',TRUE);
		$this->page_link		=trim($this->input->post('page_title',''));
		$this->is_active		=$this->input->post('is_active',TRUE);
		if($this->is_active===false){
			$this->is_active='1';
		}
		if(empty($this->meta_title)){$this->meta_title=$this->title;}
						
		$add_data = array(
   					'parent_id' 		=> $this->parent_id ,
					'site_id' 				=> $this->site_id ,
   					'meta_title' 		=> $this->meta_title ,				
					'meta_keyword'		=> $this->meta_keyword,   					
					'meta_description' 	=> $this->meta_description,  
					'title' 			=> $this->title,
   					'content'			=> inputEscapeString($this->content),
					'display_order'		=> $this->display_order,
					'page_link' 		=> $this->name_replaceCat($this->page_link),
					'is_active' 		=> $this->is_active  					
					);
		
		if($this->db->insert($this->db->dbprefix('cms_pages'), $add_data))
		{ 
			$cmsid=$this->db->insert_id();
			#$this->reorder($this->db->dbprefix('cms_pages'),"display_order","id",$cmsid,'0',$this->display_order,$this->parent_id);
			
			
				$this->db->set_dbprefix('is_french_');
				if($this->db->insert($this->db->dbprefix('cms_pages'), $add_data)){
					$this->db->set_dbprefix('is_');
					return $cmsid;
					}
			
			
			return $cmsid;
		
		}else{
			log_message('error',": ".$this->db->_error_message() );
			
			return false;
		}
	}
	
	
	// --------------------------------------------------------------------
	/**
	 * EDIT RECORD WITH THIS ID
	 *
	 * Can be passed as an int param
	 *
	 * @access	public
	 * @param	int
	 * @return	mixed
	 */
	
	function editDetail($editid,$language)
	{
		if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
		if($edit_query = $this->db->get_where($this->db->dbprefix('cms_pages'), array('id' => $editid,'site_id'=>$this->site_id)))
		{
			$edit_res=$edit_query->row();
			if(!empty($language)){
				$this->db->set_dbprefix('is_');
			}
			return $edit_res;
		}
		else
		{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}
		
	}
	
		
	// --------------------------------------------------------------------
	/**
	 * UPDATE RECORD WITH THIS ID
	 *
	 * Can be passed as an int param
	 *
	 * @access	public
	 * @param	int
	 * @return	boolean
	 */
	
	function updateDetais($curid,$language)
	{
		$data=$this->contentdata;	
		
		$this->parent_id		=$this->input->post('parent_id','');
		$this->meta_title		=$this->input->post('meta_title',TRUE);
		$this->meta_keyword		=$this->input->post('meta_keyword','');
		$this->meta_description	=$this->input->post('meta_desc','');
		$this->title			=$this->input->post('page_title',TRUE);
		$this->content			=outputEscapeString($this->input->post('content',''));
		$this->display_order	=$this->input->post('display_order',TRUE);
		$this->page_link		=trim($this->input->post('page_title',''));
		$this->is_active		=$this->input->post('is_active',TRUE); 
		if($this->is_active===false){$this->is_active='1';}
		if(empty($this->meta_title)){$this->meta_title=$this->title;}
		
		
		$upd_data = array(
   					'parent_id' 		=> $this->parent_id,
					'site_id' 			=> $this->site_id,
   					'meta_title' 		=> $this->meta_title,				
					'meta_keyword'		=> $this->meta_keyword,   					
					'meta_description' 	=> $this->meta_description,  
					'title' 			=> $this->title,
   					'display_order' 	=> $this->display_order, 
					'is_active' 		=> $this->is_active  					
					);
			$upd_data['content'] = inputEscapeString($this->content);
		if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
		$where_cond=$this->db->where('id', $curid);
		
		if($this->db->update($this->db->dbprefix('cms_pages'), $upd_data))
		{
			if(!empty($language)){
				$this->db->set_dbprefix('is_');
			}
			
			return true;
		}
		else{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}	
		
	}
	
	function delSingleRecord($id='',$curtable='',$curidname='')
	{			
	
		// $sel_field=$this->db->select('banner_photo');		
		$status_query = $this->db->get_where($this->db->dbprefix('cms_pages'), array('id' => $id));
		if($status_query->num_rows()>0)
		{
			
			$data=array();		
			$res=$status_query->result();
			//if($res[0]->banner_photo)
//			{
//				if(is_file(file_upload_absolute_path()."cmspages/".$res[0]->banner_photo)){
//					@unlink(file_upload_absolute_path()."cmspages/".$res[0]->banner_photo);
//				}
//			}
		}
		
		$where_cond=$this->db->where($curidname,$id);
		if($this->db->delete($this->db->dbprefix($curtable))) // RECORD DELETED
		{				
			return true;
		} 
		else{
			return false;
		}		
	}	 	
	
	function changeStatus($id)
	{		
		
		$sel_field=$this->db->select('is_active');		
		$status_query = $this->db->get_where($this->db->dbprefix('cms_pages'), array('id' => $id));
		if($status_query->num_rows()>0)
		{
			$data=array();		
			$res=$status_query->result();
			if($res[0]->is_active==1)
			{
				$data = array(
              				 'is_active' =>0
            				);
				$this->db->where('id', $id);
				if($this->db->update($this->db->dbprefix('cms_pages'), $data))
				{
					return true; 
				}
				else
				{
					log_message('error',": ".$this->db->_error_message() );
					return false;
				} 			
			}
			else
			{
				$data = array(
              				 'is_active' =>1
            				);
				$this->db->where('id', $id);
				if($this->db->update($this->db->dbprefix('cms_pages'), $data))
				{
					return true; 
				}
				else
				{
					log_message('error',": ".$this->db->_error_message() );
					return false;
				}
			}			
		}
		else
		{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}	
	}
	
	
	function changepos($updateRecordsArray)
	{
	
		$listingCounter = 1;
		
		foreach ($updateRecordsArray as $recordIDValue) {		
			
			$data = array(
              				'listing_pos' =>$listingCounter
            			);
				$this->db->where('id', $recordIDValue);
				
				if($this->db->update($this->db->dbprefix('category_master'), $data))
				{
					$listingCounter = $listingCounter + 1;		
					
				}
				else
				{
					log_message('error',": ".$this->db->_error_message() );
					
					return false;
				}
		}		
		
	}
	
	function name_replaceCat($string)
	{    
		$string = strip_tags(outputEscapeString($string));
		$string = preg_replace('/[^A-Za-z0-9\s\s]/', '', $string);
		$cat_replace = str_replace(" ","-",$string);
		$query = $this->db->query("SELECT `id` FROM `".$this->db->dbprefix('cms_pages')."` WHERE page_link like '%".$cat_replace."'");
		$count=$query->num_rows();
		if($query->num_rows()>0){
			$cat_replace=$cat_replace.($count+1);
		}
		return strtolower($cat_replace);
	}
	function setPublish($id=0)
	{
		$query = "UPDATE ".$this->db->dbprefix('cms_pages')." SET is_active = if(is_active=1,0,1) WHERE id = '".$id."'";
		$return = $this->db->query($query);
		if(!$return)
		{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}
		return true;
	}
	function deleteImg($id)
	{		
		
		$sel_field=$this->db->select('banner_photo');		
		$status_query = $this->db->get_where($this->db->dbprefix('cms_pages'), array('id' => $id));
		if($status_query->num_rows()>0)
		{
			
			$data=array();		
			$res=$status_query->result();
			if($res[0]->banner_photo)
			{
				if(is_file(file_upload_absolute_path()."cmspages/".$res[0]->banner_photo)){
					unlink(file_upload_absolute_path()."cmspages/".$res[0]->banner_photo);
				}
				$data = array(
              				 'banner_photo' =>''
            				);
				$this->db->where('id', $id);
				if($this->db->update($this->db->dbprefix('cms_pages'), $data))
				{
					return true; 
				}
				else
				{
					log_message('error',": ".$this->db->_error_message() );
					return false;
				} 			
			}
						
		}
		else
		{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}	
	}
	
	function reorder($table,$orderfield,$idfield,$id=null,$pos=null,$newpos=null,$parent_id=0) {
		if($pos!=$newpos) {
			if($newpos>$pos) {
				
				$this->db->query($sql = "UPDATE ".$table." SET ".$orderfield."=".$orderfield."-1 WHERE ".$orderfield.">= '".$pos."' AND  ".$orderfield."<= '".$newpos."' AND $idfield<>'".$id."' and parent_id='".$parent_id."'");
			 
			} else {
				$this->db->query($sql = "UPDATE ".$table." SET ".$orderfield."=".$orderfield."+1 WHERE ".$orderfield."<= '".$pos."' AND ".$orderfield.">= '".$newpos."' AND $idfield<>'".$id."' and parent_id='".$parent_id."'");
			   
			}
			
			 $this->db->query($sql = "UPDATE ".$table." SET ".$orderfield."=".$newpos." WHERE  $idfield='".$id."' and parent_id='".$parent_id."'");
		}
		
		if($pos!=$newpos || ($pos==null && $newpos == null && $id==null) ) {
			$rs = $this->db->query($sql = "SELECT $orderfield,$idfield FROM ".$table." where  parent_id='".$parent_id."' ORDER BY ".$orderfield." ASC");
			$p = 0;
			if($rs->num_rows() > 0)
			{
				foreach($rs->result_array() as $r) {
				$p++;
				
				$this->db->query($sql = "UPDATE ".$table." SET ".$orderfield."='".$p."' WHERE ".$idfield."= '".$r[$idfield]."'");
				}
			}
		}
	
	}	
}
?>