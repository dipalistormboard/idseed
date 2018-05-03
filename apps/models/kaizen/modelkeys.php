<?php
class Modelkeys extends CI_Model{

	var $id='';	
	var $contentdata=array();
	var $keys_title='';
	var $is_active='';
	var $display_order='';
	var	$site_id='';
	var	$content='';
	public function __construct()
    {
        parent::__construct();	
		$this->site_id=$this->session->userdata('SITE_ID');	
		if($this->session->userdata('prefered_language') == "french"){
					$this->db->set_dbprefix('is_french_');
				}	
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
		$sel_query = $this->db->get_where($this->db->dbprefix('keys'), array('id' => $id,'site_id'=>$this->site_id));
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
	
	
	function getAllDetails($curtable,$limit = NULL, $offset = NULL, $searchstring="",$pos=0,$language){
		if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
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
	

	
	function addDetails()
	{		
		$data=$this->contentdata;	
		
		$this->keys_title		= $this->input->post('keys_title',TRUE);
		$this->banner_url		= $this->input->post('banner_url',TRUE);
		$this->banner_url_title	= $this->input->post('banner_url_title',TRUE);		
		$this->is_active		= $this->input->post('is_active','');
		
		$this->display_order	= $this->input->post('display_order',TRUE);
		$this->banner_url		= $this->input->post('banner_url',TRUE);
		$this->content			= $this->input->post('content',TRUE);
                
                $this->embeded_script			= $this->input->post('embeded_script',TRUE);
		

		
		$add_data = array(
   					'title' 			=> $this->keys_title,
					'site_id' 			=> $this->site_id,
					'display_order' 	=> $this->display_order,
					'button_url' 		=> $this->banner_url,
					'button_text'  => $this->banner_url_title,
					'content' 			=> $this->content,
					'is_active ' 		=> $this->is_active,
                                        'page_link' 		=> $this->name_replaceCat($this->keys_title),
                                        'embeded_script'        => $this->embeded_script
					);

		if($this->db->insert($this->db->dbprefix('keys'), $add_data))
		{
			$cmsid=$this->db->insert_id();
			
			if($this->session->userdata('prefered_language') == "french"){
				$this->db->set_dbprefix('is_');
				if($this->db->insert($this->db->dbprefix('keys'), $add_data)){
					$this->db->set_dbprefix('is_french_');
					return $cmsid;
					}
			}else{
				$this->db->set_dbprefix('is_french_');
				if($this->db->insert($this->db->dbprefix('keys'), $add_data)){
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
	
	function name_replaceCat($string)
	{    
		$string = strip_tags(outputEscapeString($string));
		$string = preg_replace('/[^A-Za-z0-9\s\s]/', '', $string);
		$cat_replace = str_replace(" ","-",$string);
		$query = $this->db->query("SELECT `id` FROM `".$this->db->dbprefix('keys')."` WHERE page_link like '%".$cat_replace."%'");
		$count=$query->num_rows();
		if($query->num_rows()>0){
			$cat_replace=$cat_replace.($count+1);
		}
		return $cat_replace;
	}
	
	function editDetail($editid,$language)
	{
		if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
		if($edit_query = $this->db->get_where($this->db->dbprefix('keys'), array('id' => $editid)))
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
	

	
	function updateDetais($curid,$language)
	{
		$data=$this->contentdata;	
		
		$this->keys_title	= $this->input->post('keys_title',TRUE);
		$this->banner_url	= $this->input->post('banner_url',TRUE);
		$this->banner_url_title	= $this->input->post('banner_url_title',TRUE);		
		$this->is_active	= $this->input->post('is_active','');
		
		$this->display_order= $this->input->post('display_order',TRUE);
		$this->banner_url	= $this->input->post('banner_url',TRUE);
		$this->content			= $this->input->post('content',TRUE);
		$this->embeded_script			= $this->input->post('embeded_script',TRUE);
                
		$upd_data = array(
   					'title' 			=> $this->keys_title,
					'site_id' 			=> $this->site_id,
					'display_order' 	=> $this->display_order,
					'button_text'  => $this->banner_url_title,
					'button_url' 		=> $this->banner_url,
					'content' 			=> $this->content,					
					'is_active ' 		=> $this->is_active,
                                        
                                        'embeded_script'        => $this->embeded_script
					);
		if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
		$where_cond=$this->db->where('id', $curid);
		
		if($this->db->update($this->db->dbprefix('keys'), $upd_data))
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
		$status_query = $this->db->get_where($this->db->dbprefix('keys'), array('id' => $id));
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
				if($this->db->update($this->db->dbprefix('keys'), $data))
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
				if($this->db->update($this->db->dbprefix('keys'), $data))
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

function update_row($table_name,$update_data,$update_where){
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
  function getAllActivedata($table){
		$sel_query = $this->db->get_where($this->db->dbprefix($table), array('is_active'=>1));
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

}
?>