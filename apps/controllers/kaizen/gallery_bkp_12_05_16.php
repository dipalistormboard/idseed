<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery extends CI_Controller 
{
	private $limit = 20;
	var $offset = 0;
	function __construct()
	{
		parent::__construct();		 
		
		if( ! $this->session->userdata('web_admin_logged_in')) {
			redirect('kaizen/welcome','refresh');
		}
		$this->load->vars( array(
		  'global' => 'Available to all views',
		  'header' => 'kaizen/common/header',
		  'left' => 'kaizen/common/gallery_left',
		  'footer' => 'kaizen/common/footer'
		));
		$this->load->library('pagination');
		$this->load->model('kaizen/modelgallery');
		$this->load->library('image_lib'); // LOAD IMAGE THUMB LIBRARY	
	}

	public function index()
	{		
		//$this->load->helper('security');
		$offsets = (($this->uri->segment(4)) ? $this->uri->segment(4) : 1);
		if($offsets>1){$this->offset = (($offsets - 1)*$this->limit);}else{$this->offset = ($offsets - 1);}
		$searchstring = xss_clean(rawurldecode($this->input->get('q')));
		$this->dolist($searchstring);	
	}
	
	public function pagination($searchstring="",$total_row=0){
		$config['use_page_numbers'] = TRUE;		
		if(!empty($searchstring)){
			$config['uri_segment'] = 5;
			$config['base_url'] = site_url("kaizen/gallery/dosearch/".rawurlencode($searchstring)."/");
		}
		else{
			$config['uri_segment'] = 4;
			$config['base_url'] = site_url("kaizen/gallery/index/");
		}
		$config['total_rows'] = $total_row;
		$config['per_page'] = $this->limit;
		$config['first_link'] = FALSE;
		$config['last_link'] = FALSE;
		$config['next_link'] = '&gt;';
		$config['prev_link'] = '&lt;';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';	
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		return $config;
	}
	
	public function dolist($searchstring=""){
		$data = array();
		$pos = $this->input->get('pos',TRUE);
		$total_row = $this->modelgallery->getCountAll("gallery",$searchstring,$pos);
		$this->pagination($searchstring,$total_row);
		$data['q'] = $searchstring;
		
		$data_row = $this->modelgallery->getAllDetails("gallery",$this->limit,$this->offset,$searchstring,$pos);
		if(empty($data_row)){
			$data['empty_msg'] = $total_row."No record found.";
		}
		$data['total_records']= $total_row;
		$data['records']= $data_row;
		$data['pagination'] = $this->pagination->create_links();
		$this->load->view('kaizen/gallery_list',$data);		
	}
	public function dosearch(){
		//$this->load->helper('security');
		$offsets = (($this->uri->segment(5)) ? $this->uri->segment(5) : 1);
		if($offsets>1){$this->offset = (($offsets - 1)*$this->limit);}else{$this->offset = ($offsets - 1);}
		$searchstring = xss_clean(rawurldecode($this->uri->segment(4)));
		$this->dolist($searchstring);	
	}
	public function doadd(){
		$data = array();
		$gallery_id=$this->uri->segment(4);
		$data['details']->is_active = 1;
		$data['details']->id = $gallery_id;
		
		$data_row = $this->modelgallery->getAllDetails("gallery");
		$data['records']= $data_row;
		
		$this->load->view('kaizen/edit_gallery',$data);		
	}
	public function addedit()
	{		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('gallery_title', 'Title', 'trim|required|xss_clean');				
		$this->form_validation->set_error_delimiters('<span class="validation_msg">', '</span>');
		$id=$this->input->post('gallery_id','');
		if($this->form_validation->run() == TRUE) // IF MENDATORY FIELDS VALIDATION TRUE(SERVER SIDE)  
		{	
			if($this->modelgallery->getSingleRecord($id)) 
			{			
				$uplod_img ="";			
				$getFile=$this->modelgallery->editDetail($id);
				$orgimgpath=$getFile->gallery_photo;
				
			
			if(is_uploaded_file($_FILES['htmlfile']['tmp_name'])) // if image file upload at the updating
			{
									
				if(!empty($orgimgpath) && is_file(file_upload_absolute_path().'gallery_photo/'.$orgimgpath)){
					unlink(file_upload_absolute_path().'gallery_photo/'.$orgimgpath);
				}								
								
				$uplod_img=$this->uploadImage('htmlfile');
				if(empty($uplod_img) || $uplod_img==false)
				{
					$session_data = array("ERROR_MSG"  => "Error in image uploading.");
					$this->session->set_userdata($session_data);	
					redirect("kaizen/gallery",'refresh');
				}
			}	
			else
			{
				$uplod_img=$orgimgpath;
			}
			
			
			if($this->modelgallery->updateDetais($id,$uplod_img)) // IF UPDATE PROCEDURE EXECUTE SUCCESSFULLY
				{
					$session_data = array("SUCC_MSG"  => "Gallery Updated Successfully.");
					$this->session->set_userdata($session_data);					
				}			
				else // IF UPDATE PROCEDURE NOT EXECUTE SUCCESSFULLY
				{	
					$session_data = array("ERROR_MSG"  => "Gallery Not Updated.");
					$this->session->set_userdata($session_data);				
				}
			}
			else 
			{
				$uplod_img = '';		
					
			if(is_uploaded_file($_FILES['htmlfile']['tmp_name'])) // if image file upload at the updating
			{				
				$uplod_img=$this->uploadImage('htmlfile');
			}
				$id = $this->modelgallery->addDetails($uplod_img);
				if($id) // IF UPDATE PROCEDURE EXECUTE SUCCESSFULLY
				{
					$session_data = array("SUCC_MSG"  => "Gallery Inserted Successfully.");
					$this->session->set_userdata($session_data);					
				}			
				else // IF UPDATE PROCEDURE NOT EXECUTE SUCCESSFULLY
				{	
					$session_data = array("ERROR_MSG"  => "Gallery Not Inserted.");
					$this->session->set_userdata($session_data);				
				}				
			}
			redirect("kaizen/gallery/doedit/".$id,'refresh');			
		}
		else{
			if(!empty($id)){
			$this->doedit();
			}
			else{
				$this->doadd();
			}
		}
	}
	public function doedit()
	{
		$data = array();
		$gallery_id=$this->uri->segment(4);
		$q = $this->modelgallery->editDetail($gallery_id);		
		
		if($q){
			$data['details'] = $q;
		}
		else{
			$data['details']->is_active = 1;
			$data['details']->id = 0;
		}
		
		$data_row = $this->modelgallery->getAllDetails("gallery");
		$data['records']= $data_row;		
		$this->load->view('kaizen/edit_gallery',$data);		
		
	}
	public function dodelete(){		
		$del_id=$this->input->get('deleteid');
		$ref=rawurldecode($this->input->get('ref'));
		$tablename="gallery";
		$idname='id';
			
		$delrec=$this->modelgallery->delSingleRecord($del_id,$tablename,$idname);
		if($delrec===true){
			$session_data = array("SUCC_MSG"  => "Deleted Successfully");
			$this->session->set_userdata($session_data);
		}
		else{
			$session_data = array("ERROR_MSG"  => "Some problem occureed, please try again.");
			$this->session->set_userdata($session_data);
		}
		redirect($ref,'refresh');
	}
	
	public function do_changestatus() // CHANGE STATUS
	{
		
	    $status_id=$this->uri->segment(4, 0); // STATUS CHANGE RECORD ID
		
						
		if((int)$status_id > 0 && $this->modelgallery->getSingleRecord($status_id))
		{ 
			if($this->modelgallery->changeStatus($status_id))
			{				
				
				$session_data = array("SUCC_MSG"  => "Status Changed Successfully.");
				#$this->session->set_userdata($session_data);
			}
			else
			{
				$session_data = array("ERROR_MSG"  => "Status Not Changed Successfully.");
				$this->session->set_userdata($session_data);
			}
		}	
		else
		{
			$session_data = array("ERROR_MSG"  => "Status Not Changed Successfully.");
			$this->session->set_userdata($session_data);
		}
		
		header('location:'.$_SERVER['HTTP_REFERER']);
	}	
	
	public function dodeleteimg() // CHANGE STATUS
	{
		
	    $id=$this->input->get('deleteid');		
						
		if((int)$id > 0 && $this->modelgallery->getSingleRecord($id))
		{ 
			if($this->modelgallery->deleteImg($id))
			{				
				
				$session_data = array("SUCC_MSG"  => "Image deleted Successfully.");
				$this->session->set_userdata($session_data);
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
		$data = array();
		$cms_id=$this->uri->segment(4);
		$data['details'] = $this->modelgallery->editDetail($id);		
		$this->load->view('kaizen/edit_gallery',$data);				
		
	}	
		//=============== START IMAGE MANUPULATION==============// 
	
	function uploadImage($field='') 
    {		
		$upload_dir='gallery_photo/';
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
 
 public function popup()
	{
		$count =  $this->uri->segment(4);
		$this->data['folder_name'] = $count;
		$this->data['imgwidth'] = '44';
		$this->data['imgheight'] = '66';
		$this->data['session'] = $this->uri->segment(5); 
		$this->load->view('upload_crop',$this->data);
	}  
	//=============== END IMAGE MANUPULATION==============//
}