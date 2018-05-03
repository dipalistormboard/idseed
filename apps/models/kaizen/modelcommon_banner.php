<?php
class Modelcommon_banner extends CI_Model{

	var $id='';	
	var $contentdata=array();
	var $common_banner_title='';
	var $common_banner_url='';
	var $image_url='';
	var $common_banner_photo='';
	var $is_active='';
	var $display_order='';
	var	$site_id='';
	var	$content='';
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
	
	function getCountAll($curtable,$searchstring="",$pos=0){
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
		// --------------------------------------------------------------------

	/**
	 * FIND ALL THE RECORDS	 	 
	 *
	 * @access	public	
	 * @return	array
	 */
	
	function getSingleRecord($id){
		$sel_query = $this->db->get_where($this->db->dbprefix('common_banner'), array('id' => $id,'site_id'=>$this->site_id));
		if($sel_query->num_rows()>0)
		{		
			#$res=$sel_query->result();		
			return true;
		}
		else
		{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}	
		
	}	

	function getSingleRecordPageName($id){
		
		$sel_query=$this->db->where('site_id', $this->site_id); 
		$sel_query=$this->db->where_in('id', $id); 
		$sel_query=$this->db->select('*')->from($this->db->dbprefix('cms_pages'));
		$sel_query = $this->db->get();
		
		//$sel_query = $this->db->get_where($this->db->dbprefix('cms_pages'), array('id' => $id,'site_id'=>$this->site_id));
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
	
	function getSingleRecordPageName2(){
		$sel_query = $this->db->get_where($this->db->dbprefix('cms_pages'), array('site_id'=>$this->site_id));
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
	
	function getAllDetails($curtable,$limit = NULL, $offset = NULL, $searchstring="",$pos=0){
		$this->db->where('site_id', $this->site_id); 
		if(!empty($searchstring)){
			$this->db->like('title', $searchstring); 
		}
		$this->db->order_by('display_order > 0 desc,display_order asc');
		if(!empty($limit)){
			$sel_query = $this->db->get($this->db->dbprefix($curtable),$limit,$offset);	
		}
		else{
			$sel_query = $this->db->get($this->db->dbprefix($curtable));	
		}
		
		#echo $this->db->last_query();exit;
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
	
	function getDistinctPageDetails(){
		$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('cms_pages')."` WHERE `site_id`='".$this->site_id."' and `id` != 1");
		if($query->num_rows()>0){
			$res=$query->result();		
			return $res;	
		}
		
	}
	
	function getPageidcommon_banner(){
		$query = $this->db->query("Select page_id from ".$this->db->dbprefix('common_banner')."");
		if($query->num_rows()>0){
			$res=$query->result();		
			return $res;	
		}
		
	}
	
	function getpageName($pid){
		$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('cms_pages')."` WHERE `id`='".$pid."'");
		if($query->num_rows()>0){
			$res=$query->result();		
			return $res[0]->title;	
		}
		
	}
	

	
	function addDetails($uplod_img='')
	{	
		$this->common_banner_title		= $this->input->post('common_banner_title',TRUE);
		$this->is_active		= $this->input->post('is_active','');		
		$this->display_order	= $this->input->post('display_order',TRUE);
		//$this->page_id			= $this->input->post('page_id',TRUE);
		$selected_id=$this->input->post('selected_id');
		$this->page_id=implode(',',$selected_id).',';
		
		
		
		$add_data = array(
   					'title' 			=> $this->common_banner_title,
					'site_id' 			=> $this->site_id,
					'display_order' 	=> $this->display_order,
					'page_id' 			=> $this->page_id,
   					'common_banner_photo'  	=> $uplod_img,
					'is_active ' 		=> $this->is_active  					
					);

		if($this->db->insert($this->db->dbprefix('common_banner'), $add_data))
		{
			$cmsid=$this->db->insert_id();
			
						 
			return $cmsid;
		
		}else{
			log_message('error',": ".$this->db->_error_message() );
			
			return false;
		}
	}
	
	
	
	function editDetail($editid)
	{
		if($edit_query = $this->db->get_where($this->db->dbprefix('common_banner'), array('id' => $editid)))
		{
			$edit_res=$edit_query->row();		
			return $edit_res;
		}
		else
		{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}
		
	}
	

	
	function updateDetais($curid,$uplod_img='')
	{
			
		
		$this->common_banner_title	= $this->input->post('common_banner_title',TRUE);
		$this->is_active	= $this->input->post('is_active','');
		$this->display_order= $this->input->post('display_order',TRUE);
		//$this->page_id		= $this->input->post('page_id',TRUE);
		
		$selected_id=$this->input->post('selected_id');
		$this->page_id=implode(',',$selected_id).',';
	
		
		$upd_data = array(
   					'title' 			=> $this->common_banner_title,
					'site_id' 			=> $this->site_id,
					'page_id' 			=> $this->page_id,
					'display_order' 	=> $this->display_order,
   					'common_banner_photo ' 	=> $uplod_img,     					
					'is_active ' 		=> $this->is_active  					
					);
		//echo "<pre>";print_r($upd_data);exit;
		$where_cond=$this->db->where('id', $curid);
		
		if($this->db->update($this->db->dbprefix('common_banner'), $upd_data))
		{
			return true;
		}else{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}	
		
	}
	
	function delSingleRecord($id='',$curtable='',$curidname='')
	{			
		$sel_field=$this->db->select('common_banner_photo');		
		$status_query = $this->db->get_where($this->db->dbprefix('common_banner'), array('id' => $id));
		if($status_query->num_rows()>0)
		{
			$imagePath = file_upload_absolute_path()."common_banner_photo/";
			$data=array();		
			$res=$status_query->result();
			if($res[0]->common_banner_photo)
			{
				$imageName = $res[0]->common_banner_photo;			
					if($imageName)
					{
						$main_image = $imagePath.$imageName;					
						unlink($main_image);
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
	function changeStatus($id)
	{		
		
		$sel_field=$this->db->select('is_active');		
		$status_query = $this->db->get_where($this->db->dbprefix('common_banner'), array('id' => $id));
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
				if($this->db->update($this->db->dbprefix('common_banner'), $data))
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
				if($this->db->update($this->db->dbprefix('common_banner'), $data))
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
	
		// --------------------------------------------------------------------
	/**
	 * Dlete Image WITH THIS ID
	 *
	 * Can be passed as an int param
	 *
	 * @access	public
	 * @param	int
	 * @return	boolean
	 */
	 
	 
	 	
	function deleteImg($id)
	{		
		
		$sel_field=$this->db->select('common_banner_photo');		
		$status_query = $this->db->get_where($this->db->dbprefix('common_banner'), array('id' => $id));
		if($status_query->num_rows()>0)
		{
			$imagePath = file_upload_absolute_path()."common_banner_photo/";
			$data=array();		
			$res=$status_query->result();
			if($res[0]->common_banner_photo)
			{
				$imageName = $res[0]->common_banner_photo;			
					if($imageName)
					{
						$main_image = $imagePath.$imageName;					
						unlink($main_image);
					}	
				$data = array(
              				 'common_banner_photo' =>''
            				);
				$this->db->where('id', $id);
				if($this->db->update($this->db->dbprefix('common_banner'), $data))
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
	
	// --------------------------------------------------------------------
	/**
	 * CHANGE POSITION OF RECORD WITH THIS ID
	 *
	 * Can be passed as an int param
	 *
	 * @access	public
	 * @param	array	 
	 */	
	
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
	
}
?>