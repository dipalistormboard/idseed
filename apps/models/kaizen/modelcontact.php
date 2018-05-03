<?php
class Modelcontact extends CI_Model{

	var $id='';	
	var $contentdata=array();
	var $address='';
	var $phone='';
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
		$sel_query = $this->db->get_where($this->db->dbprefix('contact'), array('id' => $id,'site_id'=>$this->site_id));
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
		
		$this->phone		= $this->input->post('phone',TRUE);		
		$this->address			= $this->input->post('address',TRUE); 
		
		$this->is_active		=$this->input->post('is_active',TRUE); 
        if($this->is_active===false){$this->is_active='1'; }
		

		
		$add_data = array(
   					'phone' 			=> $this->phone,
					'site_id' 			=> $this->site_id,
					'address' 			=> $this->address,
					
					'is_active ' 		=> $this->is_active
					);

		if($this->db->insert($this->db->dbprefix('contact'), $add_data))
		{
			$cmsid=$this->db->insert_id();
			if($this->session->userdata('prefered_language') == "french"){
				$this->db->set_dbprefix('is_');
				if($this->db->insert($this->db->dbprefix('contact'), $add_data)){
					$this->db->set_dbprefix('is_french_');
					return $cmsid;
					}
			}else{
				$this->db->set_dbprefix('is_french_');
				if($this->db->insert($this->db->dbprefix('contact'), $add_data)){
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
	
	
	
	function editDetail($editid,$language)
	{
		if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
		if($edit_query = $this->db->get_where($this->db->dbprefix('contact'), array('id' => $editid)))
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
		
		$this->phone		= $this->input->post('phone',TRUE);
		$this->email		= $this->input->post('email');		
		$this->address			= $this->input->post('address',TRUE);
		
		$this->is_active		=$this->input->post('is_active',TRUE); 
        if($this->is_active===false){$this->is_active='1'; }
		
		$upd_data = array(
   					'phone' 			=> $this->phone,
					'site_id' 			=> $this->site_id,
					'address' 			=> $this->address,
					'email'				=> $this->email,
					'is_active ' 		=> $this->is_active		
					);
		if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
		$where_cond=$this->db->where('id', $curid);
		
		if($this->db->update($this->db->dbprefix('contact'), $upd_data))
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
		$status_query = $this->db->get_where($this->db->dbprefix('contact'), array('id' => $id));
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
				if($this->db->update($this->db->dbprefix('contact'), $data))
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
				if($this->db->update($this->db->dbprefix('contact'), $data))
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
	
}
?>