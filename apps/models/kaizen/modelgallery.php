<?php
class Modelgallery extends CI_Model{

	var $id='';	
	var $contentdata=array();
	var $gallery_title='';
	var $gallery_photo='';
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
    $this->db->where('is_active ', '1'); 
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
		$sel_query = $this->db->get_where($this->db->dbprefix('gallery'), array('id' => $id,'site_id'=>$this->site_id));
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
		//$this->db->where('is_active', '1'); 
		if(!empty($searchstring)){
				$this->db->where("(title like '%".$searchstring."%' OR sub_title like '%".$searchstring."%')");
		
			//$this->db->or_like('excerpt', $searchstring); 
		}
    $this->db->where('is_active ', '1');
		$this->db->order_by("sub_title", "asc");
		$this->db->order_by("title", "asc"); 
		if(!empty($limit)){
			$sel_query = $this->db->get($this->db->dbprefix($curtable),$limit,$offset);	
		}
		else{
			$sel_query = $this->db->get($this->db->dbprefix($curtable));	
		}
		
		
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
	

	
	function addDetails($uplod_img='',$uplod_gif='')
	{		
		$data=$this->contentdata;	
		
		$this->gallery_title		= $this->input->post('gallery_title',TRUE);		
		$this->is_active		= $this->input->post('is_active','');
		$this->photo_gif		= $this->input->post('photo_gif','');
        $this->description	= $this->input->post('description','');
		$this->excerpt	= $this->input->post('excerpt','');
		$this->display_order	= $this->input->post('display_order',TRUE);
		$this->content			= $this->input->post('content',TRUE);
		$this->sub_title			= $this->input->post('sub_title',TRUE);
		$this->size_length = $this->input->post('size_length',TRUE);
		$this->size_width = $this->input->post('size_width',TRUE);
		$this->size_breadth = $this->input->post('size_breadth',TRUE);
		$this->shape = $this->input->post('shape',TRUE);
		$this->colour = $this->input->post('colour',TRUE);
		
        
		
		$add_data = array(
   					'title' 			=> $this->gallery_title,
					'site_id' 			=> $this->site_id,
					'description' 			=> $this->description,
					'excerpt' 			=> $this->excerpt,
					'display_order' 	=> $this->display_order,
					'sub_title' 	=> $this->sub_title, 
   					'gallery_photo'  	=> $uplod_img,
                    'gif_image'  	=> $uplod_gif,
					'size_length'    => $this->size_length,
					'size_width'    => $this->size_width,
					'size_breadth'    => $this->size_breadth,
					'shape'    => $this->shape,
					'colour'    => $this->colour,
					'photo_gif' 		=> $this->photo_gif,
					'is_active' 		=> $this->is_active
					);

		if($this->db->insert($this->db->dbprefix('gallery'), $add_data))
		{
           
			$cmsid=$this->db->insert_id();
			$add_data['id'] = $cmsid;
			$add_data['gallery_photo'] =  '';
			$add_data['gif_image'] =  '';
				$this->db->set_dbprefix('is_french_');
				if($this->db->insert($this->db->dbprefix('gallery'), $add_data)){
					$this->db->set_dbprefix('is_');
					return $cmsid;
					}
			
			
			
//			if($this->session->userdata('prefered_language') == "french"){
//				$this->db->set_dbprefix('is_');
//				if($this->db->insert($this->db->dbprefix('gallery'), $add_data)){
//					$this->db->set_dbprefix('is_french_');
//					return $cmsid;
//					}
//			}else{
//				$this->db->set_dbprefix('is_french_');
//				if($this->db->insert($this->db->dbprefix('gallery'), $add_data)){
//					$this->db->set_dbprefix('is_');
//					return $cmsid;
//					}
//			}
				
						 
			return $cmsid;
		
		}else{
			log_message('error',": ".$this->db->_error_message() );
			
			return false;
		}
	}
	
	
	
	function editDetail($editid,$language)
	{
        if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
		if($edit_query = $this->db->get_where($this->db->dbprefix('gallery'), array('id' => $editid)))
		{
			#echo $this->db->last_query();
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
	

	
	function updateDetais($curid,$uplod_img='',$uplod_gif='',$language)
	{
		$data=$this->contentdata;	
		
		$this->gallery_title	= $this->input->post('gallery_title',TRUE);	
		$this->is_active	= $this->input->post('is_active','');
		$this->photo_gif	= $this->input->post('photo_gif','');
		$this->description	= $this->input->post('description','');
		$this->excerpt	= $this->input->post('excerpt','');
		$this->display_order= $this->input->post('display_order',TRUE);
		$this->sub_title			= $this->input->post('sub_title',TRUE);
		$this->size_length = $this->input->post('size_length',TRUE);
		$this->size_width = $this->input->post('size_width',TRUE);
		$this->size_breadth = $this->input->post('size_breadth',TRUE);
		$this->shape = $this->input->post('shape',TRUE);
		$this->colour = $this->input->post('colour',TRUE);
		
		$upd_data = array(
   					'title' 			=> $this->gallery_title,
					'site_id' 			=> $this->site_id,
					'display_order' 	=> $this->display_order,
					'excerpt' 	=> $this->excerpt,
					'description' 	=> $this->description,
					'sub_title' 	=> $this->sub_title, 
   					'gallery_photo ' 	=> $uplod_img, 
                    'gif_image'  	=> $uplod_gif,
					'size_length'    => $this->size_length,
					'size_width'    => $this->size_width,
					'size_breadth'    => $this->size_breadth,
					'shape'    => $this->shape,
					'colour'    => $this->colour,    					
					'photo_gif' 		=> $this->photo_gif,		
					'is_active' 		=> $this->is_active		
					);
		
		$where_cond=$this->db->where('id', $curid);
		if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
		if($this->db->update($this->db->dbprefix('gallery'), $upd_data))
		{
            if(!empty($language)){
				$this->db->set_dbprefix('is_');
			}
			return true;
		}else{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}	
		
	}
	
	function delSingleRecord($id='',$curtable='',$curidname='')
	{			
		$sel_field=$this->db->select('gallery_photo');		
		$status_query = $this->db->get_where($this->db->dbprefix($curtable), array('id' => $id));
		if($status_query->num_rows()>0)
		{
			$imagePath = file_upload_absolute_path()."gallery_photo/";
			$data=array();		
			$res=$status_query->result();
			if($res[0]->gallery_photo)
			{
				$imageName = $res[0]->gallery_photo;			
					if($imageName)
					{
						$main_image = $imagePath.$imageName;					
						unlink($main_image);
					}	
			}
		 }		
		
		$where_cond=$this->db->where($curidname,$id);
		$upd_data=array('is_active' => '0');
		if($this->db->update($this->db->dbprefix($curtable),$upd_data)) // RECORD updated to status 0
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
		$status_query = $this->db->get_where($this->db->dbprefix('gallery'), array('id' => $id));
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
				if($this->db->update($this->db->dbprefix('gallery'), $data))
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
				if($this->db->update($this->db->dbprefix('gallery'), $data))
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
	 function update_row($table_name,$update_data,$update_where){ // echo $table_name; echo $update_data; echo $update_where; echo "SUNIL";
		$where_cond = '';
    if(empty($update_where))
      return false;
    $where_cond = implode(' AND ', array_map(function ($value, $key) { 
      return $key . " ='" . $value . "'"; }, $update_where, array_keys($update_where))
    ); 
    
    $this->db->where($where_cond);
    if($this->db->update($table_name,$update_data)){
			return true;
		}else{
			return false;
		}
	}
	 
	 
	function select_row($table_name,$update_where=array(),$order_by =  array(),$limit=''){
	$where_cond = '';
    if(!empty($update_where)){
      foreach($update_where as $key => $val){
          $this->db->where($key, $val);
      }
      /* Added By Bishweswar End*/
    }else{
        $where_cond = array();
    }
    if(!empty($order_by)){
        foreach($order_by as $key => $val){
            $this->db->order_by($key, $val);
        }
    }
	if(!empty($limit)){
		 	$this->db->limit($limit, 0);
    }
    $query = $this->db->get($table_name);
    if($query->row()){
			return $query->result();
		}else{
			return false;
		}
	}

	
	function deleteImg($id,$db_val,$language)
	{
        if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
		
		$sel_field=$this->db->select($db_val);		
		$status_query = $this->db->get_where($this->db->dbprefix('gallery'), array('id' => $id));
		if($status_query->num_rows()>0)
		{
			$imagePath = file_upload_absolute_path()."gallery_photo/";
			$data=array();		
			$res=$status_query->result();
			if($res[0]->$db_val)
			{
				$imageName = $res[0]->$db_val;			
					if($imageName)
					{
						$main_image = $imagePath.$imageName;					
						unlink($main_image);
					}	
				$data = array(
              				 $db_val =>''
            				);
				$this->db->where('id', $id);
				if($this->db->update($this->db->dbprefix('gallery'), $data))
				{
					if(!empty($language)){
					$this->db->set_dbprefix('is_');
					}
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