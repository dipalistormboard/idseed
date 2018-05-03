<?php
class Modelbanner extends CI_Model{

	var $id='';	
	var $contentdata=array();
	var $banner_title='';
	var $banner_photo='';
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
		$sel_query = $this->db->get_where($this->db->dbprefix('banner'), array('id' => $id,'site_id'=>$this->site_id));
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
	
	
	function getAllDetails($curtable,$limit = NULL, $offset = NULL, $searchstring="",$pos=0){
		$this->db->where('site_id', $this->site_id); 
		if(!empty($searchstring)){
			$this->db->like('title', $searchstring); 
		}
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
	

	
	function addDetails($uplod_img='')
	{		
		$data=$this->contentdata;	
		
		$this->banner_title		= $this->input->post('banner_title',TRUE);
		$this->banner_url		= $this->input->post('banner_url',TRUE);
		$this->banner_url_title	= $this->input->post('banner_url_title',TRUE);		
		$this->is_active		= $this->input->post('is_active','');
		
		$this->display_order	= $this->input->post('display_order',TRUE);
		$this->banner_url		= $this->input->post('banner_url',TRUE);
		$this->content			= $this->input->post('content',TRUE);
		

		
		$add_data = array(
   					'title' 			=> $this->banner_title,
					'site_id' 			=> $this->site_id,
					'display_order' 	=> $this->display_order,
					'banner_url' 		=> $this->banner_url,
					'banner_url_title'  => $this->banner_url_title,
					'content' 			=> $this->content,
   					'banner_photo'  	=> $uplod_img,
					'is_active ' 		=> $this->is_active
					);

		if($this->db->insert($this->db->dbprefix('banner'), $add_data))
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
		if($edit_query = $this->db->get_where($this->db->dbprefix('banner'), array('id' => $editid)))
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
		$data=$this->contentdata;	
		
		$this->banner_title	= $this->input->post('banner_title',TRUE);
		$this->banner_url	= $this->input->post('banner_url',TRUE);
		$this->banner_url_title	= $this->input->post('banner_url_title',TRUE);		
		$this->is_active	= $this->input->post('is_active','');
		
		$this->display_order= $this->input->post('display_order',TRUE);
		$this->banner_url	= $this->input->post('banner_url',TRUE);
		$this->content			= $this->input->post('content',TRUE);
		
		$upd_data = array(
   					'title' 			=> $this->banner_title,
					'site_id' 			=> $this->site_id,
					'display_order' 	=> $this->display_order,
					'banner_url_title'  => $this->banner_url_title,
					'banner_url' 		=> $this->banner_url,
					'content' 			=> $this->content,
   					'banner_photo ' 	=> $uplod_img,     					
					'is_active ' 		=> $this->is_active		
					);
		
		$where_cond=$this->db->where('id', $curid);
		
		if($this->db->update($this->db->dbprefix('banner'), $upd_data))
		{
			return true;
		}else{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}	
		
	}
	
	function delSingleRecord($id='',$curtable='',$curidname='')
	{			
		$sel_field=$this->db->select('banner_photo');		
		$status_query = $this->db->get_where($this->db->dbprefix('banner'), array('id' => $id));
		if($status_query->num_rows()>0)
		{
			$imagePath = file_upload_absolute_path()."banner_photo/";
			$data=array();		
			$res=$status_query->result();
			if($res[0]->banner_photo)
			{
				$imageName = $res[0]->banner_photo;			
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
		$status_query = $this->db->get_where($this->db->dbprefix('banner'), array('id' => $id));
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
				if($this->db->update($this->db->dbprefix('banner'), $data))
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
				if($this->db->update($this->db->dbprefix('banner'), $data))
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
		
		$sel_field=$this->db->select('banner_photo');		
		$status_query = $this->db->get_where($this->db->dbprefix('banner'), array('id' => $id));
		if($status_query->num_rows()>0)
		{
			$imagePath = file_upload_absolute_path()."banner_photo/";
			$data=array();		
			$res=$status_query->result();
			if($res[0]->banner_photo)
			{
				$imageName = $res[0]->banner_photo;			
					if($imageName)
					{
						$main_image = $imagePath.$imageName;					
						unlink($main_image);
					}	
				$data = array(
              				 'banner_photo' =>''
            				);
				$this->db->where('id', $id);
				if($this->db->update($this->db->dbprefix('banner'), $data))
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