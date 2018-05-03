<?php
class Modelother_cms extends CI_Model{

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
	
	function getCountAll($curtable,$searchstring=""){	
		if(!empty($searchstring)){
			$this->db->like('title', $searchstring); 
		}
		$this->db->where('site_id', $this->site_id); 
		$this->db->select('id')->from($this->db->dbprefix($curtable));
		$q = $this->db->get();
		$no_record=$q->num_rows();
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
		
		$sel_query = $this->db->get_where($this->db->dbprefix('other_cms_pages'), array('id' => $id,'site_id'=>$this->site_id));
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
	
	function getAllParentDetails(){
		$this->db->where('site_id', $this->site_id); 
		$this->db->select('id, title,parent_id,page_link');
		$this->db->from($this->db->dbprefix('other_cms_pages'));
		$edit_query = $this->db->get();
		#echo $this->db->last_query();exit;
		if($edit_query)
		{
			$edit_res=$edit_query->result();		
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
	
	function getAllDetails($curtable,$limit = NULL, $offset = NULL, $searchstring=""){
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
		$edit_query=$this->db->get_where($this->db->dbprefix('other_cms_pages'), array('site_id' => $this->site_id,'id'=>$cms_id));
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
	
	function addDetails($uplod_img='')
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
		$this->banner_text		=outputEscapeString($this->input->post('banner_text',''));
		$this->banner_url		=$this->input->post('banner_url','');
		$this->is_active		=$this->input->post('is_active',TRUE); 
		
		if($this->is_active===false){$this->is_active='1';}
		if(empty($this->meta_title)){$this->meta_title=$this->title;}
						
		$add_data = array(
   					'parent_id' 		=> $this->parent_id,
					'site_id' 			=> $this->site_id,
   					'meta_title' 		=> $this->meta_title,				
					'meta_keyword'		=> $this->meta_keyword,   					
					'meta_description' 	=> $this->meta_description,  
					'title' 			=> $this->title,
   					'content'			=> inputEscapeString($this->content),				
					'display_order' 	=> $this->display_order, 
					'banner_photo' 		=> $uplod_img,
					'banner_text' 		=> $this->banner_text, 		
					'banner_url' 		=> $this->banner_url,
					'page_link' 		=> $this->name_replaceCat($this->page_link),
					'is_active' 		=> $this->is_active  					
					);
		
		if($this->db->insert($this->db->dbprefix('other_cms_pages'), $add_data))
		{
			$cmsid=$this->db->insert_id();
			
			
			if($this->session->userdata('prefered_language') == "french"){
				$this->db->set_dbprefix('is_');
				if($this->db->insert($this->db->dbprefix('other_cms_pages'), $add_data)){
					$this->db->set_dbprefix('is_french_');
					return $cmsid;
					}
			}else{
				$this->db->set_dbprefix('is_french_');
				if($this->db->insert($this->db->dbprefix('other_cms_pages'), $add_data)){
					$this->db->set_dbprefix('is_');
					return $cmsid;
					}
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
	
	function editDetail($editid)
	{
		if($edit_query = $this->db->get_where($this->db->dbprefix('other_cms_pages'), array('id' => $editid,'site_id'=>$this->site_id)))
		{
			$edit_res=$edit_query->row();
			/*if($edit_res->page_link=="blog"){
				redirect("blog/wp-admin/");
			}*/
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
	
	function updateDetais($curid,$uplod_img='')
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
		$this->banner_text		=outputEscapeString($this->input->post('banner_text',''));
		$this->is_active		=$this->input->post('is_active',TRUE); 
		$this->banner_url		=$this->input->post('banner_url','');
		if($this->is_active===false){$this->is_active='1';}
		if(empty($this->meta_title)){$this->meta_title=$this->title;}
		
		$this->save_draft		=$this->input->post('save_draft',TRUE);
		
		$upd_data = array(
   					'parent_id' 		=> $this->parent_id,
					'site_id' 			=> $this->site_id,
   					'meta_title' 		=> $this->meta_title,				
					'meta_keyword'		=> $this->meta_keyword,   					
					'meta_description' 	=> $this->meta_description,  
					'title' 			=> $this->title,
   					'banner_url' 		=> $this->banner_url,
					'banner_photo' 		=> $uplod_img,     	
					'banner_text' 		=> $this->banner_text,
					'banner_url' 		=> $this->banner_url,
   					'display_order' 	=> $this->display_order, 
					'is_active' 		=> $this->is_active  					
					);
		if($this->save_draft==1){
			$draft_data = array(
   					'cms_id' 			=> $curid ,
   					'contents'			=> inputEscapeString($this->content)	
					);
			$this->db->insert($this->db->dbprefix('other_cms_draft'), $draft_data);
		}
		else{
			$upd_data['content'] = inputEscapeString($this->content);
		}
		
		$where_cond=$this->db->where('id', $curid);
		
		if($this->db->update($this->db->dbprefix('other_cms_pages'), $upd_data))
		{
			#echo $this->db->last_query();exit();
			return true;
		}
		else{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}	
		
	}
	
		
	// --------------------------------------------------------------------
	/**
	 * DELETE SINGLE RECORD WITH THIS ID
	 *
	 * Can be passed as an mixed param
	 * Image File Also Deleted
	 * @access	public
	 * @param	array
	 * @return	boolean
	 */
	function delSingleRecord($id='',$curtable='',$curidname='')
	{			
	
		$sel_field=$this->db->select('banner_photo');		
		$status_query = $this->db->get_where($this->db->dbprefix('other_cms_pages'), array('id' => $id));
		if($status_query->num_rows()>0)
		{
			
			$data=array();		
			$res=$status_query->result();
			if($res[0]->banner_photo)
			{
				if(is_file(file_upload_absolute_path()."other_cmspages/".$res[0]->banner_photo)){
					@unlink(file_upload_absolute_path()."other_cmspages/".$res[0]->banner_photo);
				}
			}
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
	
	
	// --------------------------------------------------------------------
	/**
	 * CHANGE STATUS OF RECORD WITH THIS ID
	 *
	 * Can be passed as an int param
	 *
	 * @access	public
	 * @param	int
	 * @return	boolean
	 */	

	
function setPublish($id=0)
	{
		$query = "UPDATE ".$this->db->dbprefix('other_cms_pages')." SET is_active = if(is_active=1,0,1) WHERE id = '".$id."'";
		$return = $this->db->query($query);
		if(!$return)
		{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}
		return true;
	}

	// --------------------------------------------------------------------
	/**
	 * CREATE PAGE URL WITH ID
	 *
	 * Can be passed as an int param
	 *
	 * @access	public
	 * @param	array	 
	 */	
	function name_replaceCat($string)
	{    
		$string = strip_tags(outputEscapeString($string));
		$string = preg_replace('/[^A-Za-z0-9\s\s]/', '', $string);
		$cat_replace = str_replace(" ","-",$string);
		$query = $this->db->query("SELECT `id` FROM `".$this->db->dbprefix('other_cms_pages')."` WHERE page_link like '%".$cat_replace."'");
		$count=$query->num_rows();
		if($query->num_rows()>0){
			$cat_replace=$cat_replace.($count+1);
			$query = $this->db->query("SELECT `id` FROM `".$this->db->dbprefix('cms_pages')."` WHERE page_link like '%".$cat_replace."'");
		$count=$query->num_rows();
		if($query->num_rows()>0){
			$cat_replace=$cat_replace.($count+1);
		}
		}
		else
		{
			$query = $this->db->query("SELECT `id` FROM `".$this->db->dbprefix('cms_pages')."` WHERE page_link like '%".$cat_replace."'");
		$count=$query->num_rows();
		if($query->num_rows()>0){
			$cat_replace=$cat_replace.($count+1);
		}
		}
		return strtolower($cat_replace);
	}
	

	
	public function getDraft($id=""){
		$this->db->order_by("draft_dt desc");
		$this->db->limit(1);
		$sel_query = $this->db->get_where($this->db->dbprefix('other_cms_draft'), array('cms_id' => $id));
		#echo $this->db->last_query();
		if($sel_query->num_rows()>0){		
			#$res=$sel_query->result();		
			return $sel_query->row();
		}
		else{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}
	}
	
	public function getFirstRecordId($curtable){
		$sel_query = $this->db->query("SELECT id FROM ".$this->db->dbprefix($curtable)."  where `site_id`='".$this->site_id."' LIMIT 0,1");	
		
		#echo $this->db->last_query();
		if($sel_query->num_rows()>0)
		{		
			$res=$sel_query->result();
			$id = $res[0]->id;				
			return $id;	
		}
		else
		{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}
	}
	
function deleteImg($id)
	{		
		
		$sel_field=$this->db->select('banner_photo');		
		$status_query = $this->db->get_where($this->db->dbprefix('other_cms_pages'), array('id' => $id));
		if($status_query->num_rows()>0)
		{
			
			$data=array();		
			$res=$status_query->result();
			if($res[0]->banner_photo)
			{
				if(is_file(file_upload_absolute_path()."other_cmspages/".$res[0]->banner_photo)){
					unlink(file_upload_absolute_path()."other_cmspages/".$res[0]->banner_photo);
				}
				$data = array(
              				 'banner_photo' =>''
            				);
				$this->db->where('id', $id);
				if($this->db->update($this->db->dbprefix('other_cms_pages'), $data))
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
}
?>