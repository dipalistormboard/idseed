<?php
class Modelsettings extends MY_Model{

	var $id='';	
	var $contentdata=array();
	var $site_name				= '';	
	var $contact_email			= '';		
	var $url					= '';		
	var $copy_right				= '';						
	var $meta_title				= '';		
	var $meta_keyword			= '';
	var $meta_description		= '';
	var $address				= '';
	var $pwd_hint				= '';
	var $phone					= '';
	var $fax					= '';
	var $toll_free 				= "";
	var $contact_message 		= '';
	var $comment_message 		= '';
	var $registration_alert		= '';
	
	public function __construct()
    {
        $this->site_id=$this->session->userdata('SITE_ID');	
		parent::__construct();	
		
    }

	/**
	 * FIND ALL THE RECORDS	 	 
	 *
	 * @access	public	
	 * @return	array
	 */
	
	function getSingleRecord($language)
	{
		if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
		$sel_query = $this->db->get_where($this->db->dbprefix('site_settings'), array('id' => $this->site_id));
		if($sel_query->num_rows()>0)
		{		
			if(!empty($language)){
			$this->db->set_dbprefix('is_');
		}
			$res=$sel_query->row();
			return $res;
		}
		else
		{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}	
	}
		
	function getpwdhint()
	{
		$sel_query = $this->db->get_where($this->db->dbprefix('admin'), array('id' => $this->session->userdata('web_admin_user_id')));
		if($sel_query->num_rows()>0)
		{		
			$res = $sel_query->row();
			$pwd_hint = $res->pwd_hint;
			return $pwd_hint;
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
	
	function updateDetais($uplod_file)
	{
		$data=$this->contentdata;	
		$language = $this->input->post('language',TRUE);
		$this->site_name					= $this->input->post('site_name',TRUE);	
		$this->contact_email				= $this->input->post('contact_email',TRUE);	
		$this->email				= $this->input->post('email',TRUE);	
		$this->url							= $this->input->post('url',TRUE);						
		$this->meta_title					= $this->input->post('meta_title',TRUE);		
		$this->meta_keyword					= $this->input->post('meta_keyword');
		$this->meta_description				= $this->input->post('meta_desc');
		$this->copyright				= $this->input->post('copyright');
                $this->analytics_code				= $this->input->post('analytics_code');
                $this->site_verification				= $this->input->post('site_verification');
		$this->edition				= $this->input->post('edition');
		$this->pwd_hint						= $this->input->post('pwd_hint',TRUE);
		
		$this->language						= $this->input->post('language',TRUE);
		if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
		
		$upd_data = array(
   						'site_name' 				=> $this->site_name ,
						'contact_email' 			=> $this->contact_email,
						'email'						=> $this->email,
						'url' 						=> $this->url,
						'logo'					=> $uplod_file ,
						'meta_title' 				=> $this->meta_title,				
						'edition' 				=> $this->edition,
                                                'analytics_code' 				=> $this->analytics_code,
                                                'site_verification' 				=> $this->site_verification,
						'copyright' 				=> $this->copyright,				
						'meta_keyword '				=> $this->meta_keyword,   					
						'meta_description ' 		=> $this->meta_description
						);

		$where_cond=$this->db->where('id',$this->site_id);
		if($this->db->update($this->db->dbprefix('site_settings'), $upd_data))
		{
			if(!empty($language)){
				$this->db->set_dbprefix('is_');
			}
            $count = $this->input->post("count");
				if(!empty($count)){
					for($i=1;$i<=$count;$i++){
						$social_menus_id = $this->input->post("predifine_link_".$i);
						$url = $this->input->post("url_".$i);
						$sequence = $this->input->post("sequence_".$i);
						$social_settings_id = $this->input->post("social_settings_id_".$i);
						
						if(!empty($social_menus_id) && !empty($url) && !empty($sequence)){
							$social_arr = array(
											'social_menus_id' => $social_menus_id,
											'link' => $url,
											'site_id' => 1,
											'sequence' => $sequence
							);
							if(!empty($social_settings_id)){
								$update_where = array('id' => $social_settings_id);
								parent::update_row('social_settings',$social_arr,$update_where);
							}else{
								
								 parent::insert_row('social_settings',$social_arr);
							}
						}
					}
				}
			$upd_data = array(
						'pwd_hint'	=> $this->pwd_hint,
						'pwd' 		=> SHA1($this->pwd_hint)
						);
			$where_cond=$this->db->where('id',$this->session->userdata('web_admin_user_id'));
			if($this->db->update($this->db->dbprefix('admin'), $upd_data))
			{
				return true;
			}
			return true;
		}
		else
		{
			log_message('error',": ".$this->db->_error_message());
			return false;
		}	
	}
	
	function getAllDetails($curtable){
		$this->db->order_by("id", "asc");
		$sel_query = $this->db->get($this->db->dbprefix($curtable));	
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
	public function count_site($curtable){
		
		$this->db->order_by("id", "asc");
		$sel_query = $this->db->get($this->db->dbprefix($curtable));
			
		$count_sites=$sel_query->num_rows();
		if($count_sites>0){
			return $count_sites;
		}
		else{		
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}
	}
	function getAllDetailsById($curtable,$id){
		$this->db->where(array("id",$id));
		$sel_query = $this->db->get($this->db->dbprefix($curtable));	
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
	
	function deleteImg($id)
	{		
		
		$sel_field=$this->db->select('logo');		
		$status_query = $this->db->get_where($this->db->dbprefix('site_settings'), array('id' =>$this->site_id));
		if($status_query->num_rows()>0)
		{
			
			$data=array();		
			$res = $status_query->row();
			if($res->logo)
			{
				if(is_file(file_upload_absolute_path()."settings/".$res->logo)){
					unlink(file_upload_absolute_path()."settings/".$res->logo);
				}
				$data = array(
              				 'logo' =>''
            				);
				$this->db->where('id',$this->site_id);
				if($this->db->update($this->db->dbprefix('site_settings'), $data))
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
	
	
	function editDetail($language)
	{
		if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
		
		if($edit_query = $this->db->get_where($this->db->dbprefix('site_settings'), array('id' => $this->site_id)))
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
	
}
