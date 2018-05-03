<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if( ! $this->session->userdata('web_admin_logged_in')) {
			redirect('kaizen/welcome','refresh');
		}
		$this->load->vars( array(
		  'global' => 'Available to all views',
		  'header' => 'kaizen/common/header',
		  'left' => 'kaizen/common/left',
		  'footer' => 'kaizen/common/footer'
		));
		$this->load->model('kaizen/modelsettings');
	}

	public function index()
	{
		$language = $this->input->get('language',TRUE);
		
		
		$data = array();
		$data['language'] = $language;
		$data['details'] = $this->modelsettings->getSingleRecord($language);
		//print_r($data['details']);
		
		$data['pwd_hint'] = $this->modelsettings->getpwdhint();		
        $where_social = array(
					'site_id' => 1
				);
		$order_by = array('sequence' =>'desc');
		$social_settings_arr = $this->modelsettings->select_row('social_settings',$where_social,$order_by);
		$data['social_settings_arr'] = $social_settings_arr;
		
		$this->load->view('kaizen/settings',$data);
	}

	public function save()
	{
		$language = $this->input->post('language',TRUE);
		$data = array();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('site_name', 'Site Name', 'trim|required|xss_clean');

		$this->form_validation->set_error_delimiters('<span class="validation_msg">', '</span>');
		if($this->form_validation->run() == TRUE) // IF MENDATORY FIELDS VALIDATION TRUE(SERVER SIDE)
		{
		
			$uplod_img ="";
			
			$getFile=$this->modelsettings->editDetail($language);
			
			$orgimgpath=$getFile->logo;
			
			if(is_uploaded_file($_FILES['htmlfile']['tmp_name'])) // if image file upload at the updating
			{
						
				if(!empty($orgimgpath) && is_file(file_upload_absolute_path().'settings/'.$orgimgpath)){
					unlink(file_upload_absolute_path().'settings/'.$orgimgpath);
				}			
				
				$uplod_img=$this->uploadImage('htmlfile');				
			}	
			else
			{
				$uplod_img=$orgimgpath;
			}		
						
				
			$return = $this->modelsettings->updateDetais($uplod_img);
			$session_data = array("SUCC_MSG"  => "Settings Updation Is Successfully Completed.");
			//$this->session->set_userdata($session_data);
			
			if(empty($language)){
				redirect("kaizen/settings/index/",'refresh');
			}else{
				redirect("kaizen/settings?language=".$language,'refresh');
			}
		}
		else
		{
			$this->index();
		}
	}
	
	
	function uploadImage($field='') 
    {		
		$upload_dir='settings/';
		$field_name=$field;
		
		if(!is_dir(file_upload_absolute_path().$upload_dir)){
			$oldumask = umask(0); 
			mkdir(file_upload_absolute_path().$upload_dir, 0777); // or even 01777 so you get the sticky bit set 
			umask($oldumask);
		}
		
     	$config['upload_path'] = file_upload_absolute_path().$upload_dir;
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '5000';
        $config['max_width'] = '5000';
        $config['max_height'] = '5000'; 
		                     
        
        $this->load->library('upload', $config); // LOAD FILE UPLOAD LIBRARY
        
        if($this->upload->do_upload($field_name)) // CREATE ORIGINAL IMAGE
		{						
			$fInfo = $this->upload->data();					
			$data['uploadInfo'] = $fInfo;            
			
			return $fInfo['file_name']; // RETURN ORIGINAL IMAGE NAME
		}
        else // IF ORIGINAL IMAGE NOT UPLOADED
        {			
			return false; // RETURN ORIGINAL IMAGE NAME              
        }
    }
	
	public function dodeleteimg() // CHANGE STATUS
	{
		
	    $id=$this->input->get('deleteid');
						
		if((int)$id > 0 && $this->modelsettings->getSingleRecord($id))
		{ 
			if($this->modelsettings->deleteImg($id))
			{				
				
				$session_data = array("SUCC_MSG"  => "Image deleted Successfully.");
				#$this->session->set_userdata($session_data);
			}
			else
			{
				$session_data = array("ERROR_MSG"  => "Image Not deleted Successfully.");
				$this->session->set_userdata($session_data);
			}
		}	
		else
		{
			$session_data = array("ERROR_MSG"  => "Image Not deleted Successfully.");
			$this->session->set_userdata($session_data);
		}
	
		$this->index();	
		
	}	


	/*
	function uploadImage($field='') 
    {		
		$upload_dir='settings/';
		$field_name=$field;
		
		if(!is_dir(file_upload_absolute_path().$upload_dir)){
			$oldumask = umask(0); 
			mkdir(file_upload_absolute_path().$upload_dir, 0777); // or even 01777 so you get the sticky bit set 
			umask($oldumask);
		}
		
     		$config['upload_path'] = file_upload_absolute_path().$upload_dir;
				$config['allowed_types'] = 'pdf';
        $config['max_size'] = '5000';
		                     
        
        $this->load->library('upload', $config); // LOAD FILE UPLOAD LIBRARY
        $this->upload->initialize($config);
        if($this->upload->do_upload($field_name)) // CREATE ORIGINAL IMAGE
					{						
						$fInfo = $this->upload->data();					
						$data['uploadInfo'] = $fInfo;            
						
						return $fInfo['file_name']; // RETURN ORIGINAL IMAGE NAME
					}
							else // IF ORIGINAL IMAGE NOT UPLOADED
							{			
						return false; // RETURN ORIGINAL IMAGE NAME              
							}
	}
	*/
    
	public function add_file(){
		$data = array();
		
		$count = $this->input->post("count");
		$url = $this->input->post("url");
		$predifine_link = $this->input->post("predifine_link");
		$sequence = $this->input->post("sequence");
		$social_settings_id = $this->input->post("social_settings_id");
		
		$data['count'] = $count;
		$data['url'] = $url;
		$data['predifine_link'] = $predifine_link;
		$data['social_settings_id'] = $social_settings_id;
		$data['sequence'] = $sequence;
		$where = array(
                            'site_id' => 1,
                            'is_active' =>1
                        );
                $social_menus_arr = $this->modelsettings->select_row('social_menus',$where);
                $data['social_menus_arr'] = $social_menus_arr;
                
                if(empty($social_settings_id)){
                    $where_social = array(
                                'site_id' => 1
                            );
                }else{
                    $where_social = array(
                                'site_id' => 1,
                                'id !=' => $social_settings_id
                            );
                }
                $social_settings_arr = $this->modelsettings->select_row('social_settings',$where_social);
                $data['social_settings_arr'] = $social_settings_arr;
                
                
                
		$this->load->view('kaizen/file_div_settings',$data);		
	}	
	
	 public function deleteSocial(){
        $id = $this->input->post('social_settings_id');
        $this->db->where('id', $id);
        $this->db->delete('social_settings'); 
    }
	
}