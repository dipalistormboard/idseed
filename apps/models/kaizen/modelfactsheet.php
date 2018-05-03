<?php
class Modelfactsheet extends CI_Model{

	var $id='';	
	var $contentdata=array();
	var $factsheet_title='';
	var $factsheet_photo='';
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
	
	
	function getCountAll($curtable,$searchstring="",$pos=0,$searchtype=""){
		if(!empty($searchtype)){
                    if($searchtype=='active'){
                        $this->db->where('is_active',1);
                    }elseif($searchtype=='inactive'){
                        $this->db->where('is_active',0);
                    }else{
                        $this->db->like($searchtype, $searchstring);
                    }
                    #$this->db->like($searchtype, $searchstring);
                }else{
                    if(!empty($searchstring)){
                            $this->db->like('title', $searchstring); 
                            $this->db->or_like('family', $searchstring); 
                            $this->db->or_like('synonyms', $searchstring); 
                            $this->db->or_like('common_name', $searchstring); 
                            $this->db->or_like('general_info', $searchstring); 
                            $this->db->or_like('seed_type', $searchstring); 
                            $this->db->or_like('duration_of_lifecycle', $searchstring); 
                            $this->db->or_like('distribution_worldwide', $searchstring); 
                            $this->db->or_like('distribution_canadian', $searchstring); 
                            $this->db->or_like('other_seed_features', $searchstring); 
                            $this->db->or_like('seed_surface_texture', $searchstring); 
                            $this->db->or_like('seed_shape', $searchstring);
                    }
                }

		$this->db->where('site_id', $this->site_id); 
		$this->db->select('id')->from($this->db->dbprefix($curtable));
		$q = $this->db->get();
		$no_record=$q->num_rows();
		//echo $this->db->last_query();	
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
	
	function getSingleRecord($id,$language){
		if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
		$sel_query = $this->db->get_where($this->db->dbprefix('factsheet'), array('id' => $id,'site_id'=>$this->site_id));
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
	function getRecords_gallery($master_id){
		$language = $this->input->get('language',TRUE);
		if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
		$sel_query = $this->db->get_where($this->db->dbprefix('factsheet_image_gallery'), array('factsheet_master_id' => $master_id));
		//echo $this->db->last_query();
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
	function getRecords_species($master_id){
		$language = $this->input->get('language',TRUE);
		if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
		$sel_query = $this->db->get_where($this->db->dbprefix('factsheet_similar_species_image'), array('factsheet_master_id' => $master_id));
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
	function get_factsheet_gallery($gallery_id){
		$language = $this->input->get('language',TRUE);
		if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
		$sel_query = $this->db->get_where($this->db->dbprefix('gallery'), array('id' => $gallery_id));
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
	
	
	function getAllDetails($curtable,$limit = NULL, $offset = NULL, $searchstring="",$pos=0,$searchtype=""){
		$this->db->set_dbprefix('is_');
		$this->db->where('site_id', $this->site_id); 
                if(!empty($searchtype)){
                    if($searchtype=='active'){
                        $this->db->where('is_active',1);
                    }elseif($searchtype=='inactive'){
                        $this->db->where('is_active',0);
                    }else{
                        $this->db->like($searchtype, $searchstring);
                    }
                }else{
                    if(!empty($searchstring)){
                            $this->db->like('title', $searchstring); 
                            $this->db->or_like('family', $searchstring); 
                            $this->db->or_like('synonyms', $searchstring); 
                            $this->db->or_like('common_name', $searchstring); 
                            $this->db->or_like('general_info', $searchstring); 
                            $this->db->or_like('seed_type', $searchstring); 
                            $this->db->or_like('duration_of_lifecycle', $searchstring); 
                            $this->db->or_like('distribution_worldwide', $searchstring); 
                            $this->db->or_like('distribution_canadian', $searchstring); 
                            $this->db->or_like('other_seed_features', $searchstring); 
                            $this->db->or_like('seed_surface_texture', $searchstring); 
                            $this->db->or_like('seed_shape', $searchstring);
                    }
                }
		/*if(!empty($searchstring)){
			$this->db->like('title', $searchstring); 
		}*/
		if(!empty($limit)){
			$sel_query = $this->db->get($this->db->dbprefix($curtable),$limit,$offset);	
		}
		else{
			$sel_query = $this->db->get($this->db->dbprefix($curtable));	
		}
		
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
	

	
	function addDetails()
	{		
		$data=$this->contentdata;	
		
		$this->title		= $this->input->post('title',TRUE);		
		$this->page_link		=trim($this->input->post('title',''));
		$this->is_active		= $this->input->post('is_active','');
		$this->gallery_id = $this->input->post('hdngalleryid',TRUE);	
		$this->family			= $this->input->post('family',TRUE);
		$this->synonyms			= $this->input->post('synonyms',TRUE);
		$this->common_name			= $this->input->post('common_name',TRUE);
		$regulation_keyword  = $this->input->post('regulation_keyword',TRUE); 
		
		$regulation_keyword_imp = implode(',',$regulation_keyword);
		$this->average_seed_size			= $this->input->post('average_seed_size',TRUE);
		$this->seed_shape			= $this->input->post('seed_shape',TRUE);
		$this->seed_surface_texture			= $this->input->post('seed_surface_texture',TRUE);
		$this->seed_colour			= $this->input->post('seed_colour',TRUE);
		$this->other_seed_features			= $this->input->post('other_seed_features',TRUE);
		$this->regulation			= $this->input->post('regulation',TRUE);
		$this->distribution_canadian			= $this->input->post('distribution_canadian',TRUE);
		$this->distribution_worldwide			= $this->input->post('distribution_worldwide',TRUE);
		$this->duration_of_lifecycle			= $this->input->post('duration_of_lifecycle',TRUE);
		$this->seed_type			= $this->input->post('seed_type',TRUE);
		$this->habitat_and_corp_association			= $this->input->post('habitat_and_corp_association',TRUE);
		$this->general_info			= $this->input->post('general_info',TRUE);
		$this->similar_species			= $this->input->post('similar_species',TRUE);
		$this->similar_species_id = $this->input->post('hdngalleryid_similar',TRUE);	

		
		$add_data = array(
   					'title' 			=> $this->title,
					'page_link' 		=> $this->name_replaceCat($this->page_link),
					'site_id' 			=> $this->site_id,
					'gallery_id' => $this->gallery_id,
					'family' 			=> $this->family,
					'synonyms'   		=> $this->synonyms,
					'regulation_keyword' => $regulation_keyword_imp,
					'common_name' 			=> $this->common_name,
					'average_seed_size' 			=> $this->average_seed_size,
					'seed_shape' 			=> $this->seed_shape,
					'seed_surface_texture' 			=> $this->seed_surface_texture,
					'seed_colour' 			=> $this->seed_colour,
					'other_seed_features' 			=> $this->other_seed_features,
					'regulation' 			=> $this->regulation,
					'distribution_canadian' 			=> $this->distribution_canadian,
					'distribution_worldwide' 			=> $this->distribution_worldwide,
					'duration_of_lifecycle' 			=> $this->duration_of_lifecycle,
					'seed_type' 			=> $this->seed_type,
					'habitat_and_corp_association' 			=> $this->habitat_and_corp_association,
					'general_info' 			=> $this->general_info,
					'similar_species'      => $this->similar_species,				
          'similar_species_id'      => $this->similar_species_id,			
					'is_active ' 		=> $this->is_active
					);

		if($this->db->insert($this->db->dbprefix('factsheet'), $add_data))
		{
			$cmsid=$this->db->insert_id();
			
			
			$add_data['id'] = $cmsid;
			$add_data['gallery_id'] = '';
				$this->db->set_dbprefix('is_french_');
				if($this->db->insert($this->db->dbprefix('factsheet'), $add_data)){
					$this->db->set_dbprefix('is_');
					return $cmsid;
					}
		
						 
			return $cmsid;
		
		}else{
			log_message('error',": ".$this->db->_error_message() );
			
			return false;
		}
	}
	
	
	
	function editDetail($editid,$language){
		if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
		if($edit_query = $this->db->get_where($this->db->dbprefix('factsheet'), array('id' => $editid)))
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
	
	function name_replaceCat($string)
	{    
		$string = strip_tags(outputEscapeString($string));
		$string = preg_replace('/[^A-Za-z0-9\s\s]/', '', $string);
		$cat_replace = str_replace(" ","-",$string);
		$query = $this->db->query("SELECT `id` FROM `".$this->db->dbprefix('factsheet')."` WHERE page_link like '%".$cat_replace."'");
		$count=$query->num_rows();
		if($query->num_rows()>0){
			$cat_replace=$cat_replace.($count+1);
		}
		return strtolower($cat_replace);
	}
	
	function getPageidcommon_banner($factid,$tablenm){
		$query = $this->db->query("Select gallery_id from ".$this->db->dbprefix($tablenm)." where id = '".$factid."'");
		if($query->num_rows()>0){
			$res=$query->result();		
			return $res;	
		}
		
	}
	
	function updateDetais($curid){
		$language = $this->input->post('language',TRUE);
		if(!empty($language)){
			$this->db->set_dbprefix('is_french_');
		}
		
		$this->title		= $this->input->post('title',TRUE);	
		$this->gallery_id = $this->input->post('hdngalleryid',TRUE);	
    $this->similar_species_id = $this->input->post('hdngalleryid_similar',TRUE);	
		$this->page_link		=trim($this->input->post('title',''));	
		$this->is_active		= $this->input->post('is_active','');
		$this->family			= $this->input->post('family',TRUE);
		$this->synonyms			= $this->input->post('synonyms',TRUE);
		$this->common_name			= $this->input->post('common_name',TRUE);
		$regulation_keyword  = $this->input->post('regulation_keyword',TRUE); 
		
		$regulation_keyword_imp = implode(',',$regulation_keyword);
		
		$this->average_seed_size			= $this->input->post('average_seed_size',TRUE);
		$this->seed_shape			= $this->input->post('seed_shape',TRUE);
		$this->seed_surface_texture			= $this->input->post('seed_surface_texture',TRUE);
		$this->seed_colour			= $this->input->post('seed_colour',TRUE);
		$this->other_seed_features			= $this->input->post('other_seed_features',TRUE);
		$this->regulation			= $this->input->post('regulation',TRUE);
		$this->distribution_canadian			= $this->input->post('distribution_canadian',TRUE);
		$this->distribution_worldwide			= $this->input->post('distribution_worldwide',TRUE);
		$this->duration_of_lifecycle			= $this->input->post('duration_of_lifecycle',TRUE);
		$this->seed_type			= $this->input->post('seed_type',TRUE);
		$this->habitat_and_corp_association			= $this->input->post('habitat_and_corp_association',TRUE);
		$this->general_info			= $this->input->post('general_info',TRUE);
		$this->similar_species			= $this->input->post('similar_species',TRUE);
		
		
		$upd_data = array(
   					'title' 			=> $this->title,
					//'page_link' 		=> $this->name_replaceCat($this->page_link),
					'site_id' 			=> $this->site_id,
					'gallery_id' => $this->gallery_id,
					'family' 			=> $this->family,
					'regulation_keyword' => $regulation_keyword_imp,
					'synonyms'   		=> $this->synonyms,
					'common_name' 		=> $this->common_name,
					'average_seed_size' => $this->average_seed_size,
					'seed_shape' 		=> $this->seed_shape,
					'seed_surface_texture' => $this->seed_surface_texture,
					'seed_colour' 			=> $this->seed_colour,
					'other_seed_features' 			=> $this->other_seed_features,
					'regulation' 			=> $this->regulation,
					'distribution_canadian' 			=> $this->distribution_canadian,
					'distribution_worldwide' 			=> $this->distribution_worldwide,
					'duration_of_lifecycle' 			=> $this->duration_of_lifecycle,
					'seed_type' 			=> $this->seed_type,
					'habitat_and_corp_association' 			=> $this->habitat_and_corp_association,
					'general_info' 			=> $this->general_info,
					'similar_species'      => $this->similar_species,		
          'similar_species_id'      => $this->similar_species_id,						
					'is_active ' 		=> $this->is_active		
					);
		
		$where_cond=$this->db->where('id', $curid);
		
		if($this->db->update($this->db->dbprefix('factsheet'), $upd_data))
		{
			return true;
		}else{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}	
		
	}
	function getDistinctGalleryDetails($tablenm){
		$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix($tablenm)."` WHERE `site_id`='".$this->site_id."' and is_active = '1' order by title asc ");
		if($query->num_rows()>0){
			$res=$query->result();		
			return $res;	
		}
		
	}
	function delSingleRecord($id='',$curtable='',$curidname='')
	{	
		//$this->db->set_dbprefix('is_');
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
		$status_query = $this->db->get_where($this->db->dbprefix('factsheet'), array('id' => $id));
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
				if($this->db->update($this->db->dbprefix('factsheet'), $data))
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
				if($this->db->update($this->db->dbprefix('factsheet'), $data))
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
	function getSingleRecordPageName($id,$tablenm){
		
		$sel_query=$this->db->where_in('id', $id); 
		$sel_query=$this->db->select('*')->from($tablenm);
		$sel_query = $this->db->get();
		
		if($sel_query->num_rows()>0)
		{		
			$res=$sel_query->result();		
			return $res;
		}
		else
		{
			
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
	
}
?>