<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Other_cms extends CI_Controller {
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
		  'left' => 'kaizen/common/other_cms_left',
		  'footer' => 'kaizen/common/footer'
		));
		$this->load->library('pagination');
		$this->load->model('kaizen/modelother_cms');
		$this->load->library('image_lib'); // LOAD IMAGE THUMB LIBRARY	
	}

	public function index(){		
		$searchstring = xss_clean(rawurldecode($this->input->get('q')));
		$this->dolist($searchstring);	
	}
	
		
	public function dolist($searchstring="")
	{
		$data = array();
		$data_id = $this->modelother_cms->getFirstRecordId("other_cms_pages");
		if(empty($data_id)){
			$data['empty_msg'] = "0 record found.";
		}
		if($data_id > 0)
		{
			redirect("kaizen/other_cms/doedit/".$data_id,'refresh');
		}
		else
		{
			redirect("kaizen/other_cms/doadd/0",'refresh');
		}
				
	}
	
	
	public function doadd(){
		$data = array();
		$cms_id=$this->uri->segment(4);
		$data['details']->is_active = 1;
		$data['details']->id = $cms_id;
		$data['cms_list']=$this->modelother_cms->getAllParentDetails();
		$data['hooks_cmsmenu']=$this->get_cms_menu();
		$this->load->view('kaizen/edit_other_cms',$data);		
	}
	public function addedit(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('page_title', 'Title', 'trim|required|xss_clean');
		$this->form_validation->set_error_delimiters('<span class="validation_msg">', '</span>');
		$id=$this->input->post('cms_id','');
		if($this->form_validation->run() == TRUE) // IF MENDATORY FIELDS VALIDATION TRUE(SERVER SIDE)  
		{	
			if($this->modelother_cms->getSingleRecord($id)) 
			{
			
			$uplod_img ="";			
				$getFile=$this->modelother_cms->editDetail($id);
				$orgimgpath=$getFile->banner_photo;
			
			if(is_uploaded_file($_FILES['htmlfile']['tmp_name'])) // if image file upload at the updating
			{
						
				if(!empty($orgimgpath) && is_file(file_upload_absolute_path().'other_cmspages/'.$orgimgpath)){
					unlink(file_upload_absolute_path().'other_cmspages/'.$orgimgpath);
				}			
				
				$uplod_img=$this->uploadImage('htmlfile');
				if(empty($uplod_img) || $uplod_img==false)
				{
					$session_data = array("ERROR_MSG"  => "Error in image uploading.");
					$this->session->set_userdata($session_data);	
					redirect("kaizen/other_cms/doedit/".$id,'refresh');
				}
			}	
			else
			{
				$uplod_img=$orgimgpath;
			}
			
			
				if($this->modelother_cms->updateDetais($id,$uplod_img)) // IF UPDATE PROCEDURE EXECUTE SUCCESSFULLY
				{
					$session_data = array("SUCC_MSG"  => "Other CMS Page Updated SUCCESSFULLY.");
					#$this->session->set_userdata($session_data);					
				}			
				else // IF UPDATE PROCEDURE NOT EXECUTE SUCCESSFULLY
				{	
					$session_data = array("ERROR_MSG"  => "Other CMS Page Not Updated.");
					$this->session->set_userdata($session_data);				
				}
			}
			else 
			{
			$uplod_img ="";			
						
			if(is_uploaded_file($_FILES['htmlfile']['tmp_name'])) // if image file upload at the updating
			{
				
				$uplod_img=$this->uploadImage('htmlfile');
				if(empty($uplod_img) || $uplod_img==false)
				{
					$session_data = array("ERROR_MSG"  => "Error in image uploading.");
					$this->session->set_userdata($session_data);	
					redirect("kaizen/other_cms/doedit/".$id,'refresh');
				}
			}				
			
			$id = $this->modelother_cms->addDetails($uplod_img);
				if($id) // IF UPDATE PROCEDURE EXECUTE SUCCESSFULLY
				{
					$session_data = array("SUCC_MSG"  => "Other CMS Page Inserted SUCCESSFULLY.");
					#$this->session->set_userdata($session_data);					
				}			
				else // IF UPDATE PROCEDURE NOT EXECUTE SUCCESSFULLY
				{	
					$session_data = array("ERROR_MSG"  => "Other CMS Page Not Inserted.");
					$this->session->set_userdata($session_data);				
				}
			}
			redirect("kaizen/other_cms/doedit/".$id,'refresh');
		}
		else{
			$this->load->view('kaizen/edit_other_cms/'.$id);
		}
	}
	public function doedit(){
		$data = array();
		$cms_id=$this->uri->segment(4);
		$data['details'] = $this->modelother_cms->editDetail($cms_id);		
		$data['draft_content'] = $this->modelother_cms->getDraft($cms_id);		
		$data['cms_list']=$this->modelother_cms->getAllParentDetails();
		$data['hooks_cmsmenu']=$this->get_cms_menu();
		$this->load->view('kaizen/edit_other_cms',$data);				
	}
	
	
	public function doeditajax(){
		$data = array();
		$cms_id=$this->uri->segment(4);
		$q	= $this->modelother_cms->editDetail($cms_id);
		if($q){
			$data['details'] = $q;		
			$data['draft_content'] = $this->modelother_cms->getDraft($cms_id);
		}
		else{
			$data['details']->is_active = 1;
			$data['details']->id = $cms_id;
		}
				
		$data['cms_list']=$this->modelother_cms->getAllParentDetails();
		$data['hooks_cmsmenu']=$this->get_cms_menu();

		$this->load->view('kaizen/edit_other_cms_ajax',$data);		
		
	}
	public function dodelete(){
		
		$del_id=$this->input->get('deleteid');
		$ref=rawurldecode($this->input->get('ref'));
		$tablename="other_cms_pages";
		$idname='id';
			
		$delrec=$this->modelother_cms->delSingleRecord($del_id,$tablename,$idname);
		if($delrec===true){
			$session_data = array("SUCC_MSG"  => "Deleted Successfully");
			#$this->session->set_userdata($session_data);
		}
		else{
			$session_data = array("ERROR_MSG"  => "Some problem occureed, please try again.");
			$this->session->set_userdata($session_data);
		}
		
		redirect($ref,'refresh');
	}
	
	
	public function get_cms_menu(){		
		$this->load->model('kaizen/model_other_cms_menu');	
		if($this->model_other_cms_menu->count_menu()){
			//$where=" where `parent_id`='0' ";
			$where=" where `site_id`='".$this->session->userdata('SITE_ID')."'";
			$cmsmenu = $this->model_other_cms_menu->cms_menu($where);
			
			$menus_array = array();
			foreach ($cmsmenu as $rs_menu_id){
			  $menus_array[$rs_menu_id->id] = array('id' => $rs_menu_id->id,'title' => $rs_menu_id->title,'parent_id' => $rs_menu_id->parent_id,'page_link' => $rs_menu_id->page_link);	
			}
			$TOP_NAV_MENU = '';
			$cms_menu = $this->generate_menu(0,$menus_array, $TOP_NAV_MENU, 0);
			return $cms_menu;						
				
		}	
	}
	
	public function generate_menu($parent,$menus_array, &$TOP_NAV_MENU, $level_depth=0){
		$has_childs = false;
		$level_depth++;
		$static_menu_array = array("sid-buckwold-theatre","convection-centre");
		
		foreach($menus_array as $key => $value){
	    	if ($value['parent_id'] == $parent){       
    	    	if ($has_childs === false){
                	$has_childs = true;
					if($level_depth==1){$TOP_NAV_MENU .= "<ul class='topnav'>\n";}
					else{$TOP_NAV_MENU .= "<ul>\n";}
            	}
				if($value['page_link']=="blog"){
					$TOP_NAV_MENU .= '<li><a href="'.site_url("blog/wp-admin/").'" target="_blank">' . $value['title'] . '</a>';
				}
				elseif(in_array($value['page_link'],$static_menu_array)){
					$TOP_NAV_MENU .= '<li><a href="javascript:void(0);" >' . $value['title'] . '</a>';
				}
				else{
					$TOP_NAV_MENU .= '<li><a href="javascript:void(0);" onclick="javascript:openpage(\''.site_url("kaizen/other_cms/doeditajax/".$value['id']).'\');">' . $value['title'] . '</a>';					
				}
				if($level_depth<3){$this->generate_menu($key,$menus_array,$TOP_NAV_MENU,$level_depth);}
            	//call function again to generate nested list for subcategories belonging to this category
            	$TOP_NAV_MENU .= "</li>\n";
			}
    	}
    	if ($has_childs === true){$TOP_NAV_MENU .= "</ul>\n";}
	
		return $TOP_NAV_MENU;
	}
    
  public function set_publish() // CHANGE STATUS
	{
	    $id = $this->input->post('id','');

		if($this->modelother_cms->setPublish($id))
		{
			echo "Status Changed Successfully.";
		}
		else
		{
			echo "Status Not Changed Successfully.";
		}
	}	
	
	function uploadImage($field='') 
    {		
		$upload_dir='other_cmspages/';
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
		
						
		if((int)$id > 0 && $this->modelother_cms->getSingleRecord($id))
		{ 
			if($this->modelother_cms->deleteImg($id))
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
		$data = array();
		$cms_id=$this->uri->segment(4);
		$data['details'] = $this->modelother_cms->editDetail($id);
		$data['draft_content'] = $this->modelother_cms->getDraft($cms_id);		
		$data['cms_list']=$this->modelother_cms->getAllParentDetails();
		$data['hooks_cmsmenu']=$this->get_cms_menu();
		$this->load->view('kaizen/edit_other_cms',$data);		
		
		
	}	
	//=============== END IMAGE MANUPULATION==============//
}