<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends CI_Controller {
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
		  'left' => 'kaizen/common/left',
		  'footer' => 'kaizen/common/footer'
		));
		$this->load->library('pagination');
		$this->load->model('kaizen/modelcms');
	}

	public function index(){
		$language = $this->input->get('language',TRUE);		
		$offsets = (($this->uri->segment(4)) ? $this->uri->segment(4) : 1);
		if($offsets>1){$this->offset = (($offsets - 1)*$this->limit);}else{$this->offset = ($offsets - 1);}
		$searchstring = xss_clean(rawurldecode($this->input->get('q')));
		$this->dolist($searchstring,$language);	
	}
	
	public function pagination($searchstring="",$total_row=0,$listing=""){
		$config['use_page_numbers'] = TRUE;		
		if(!empty($searchstring) && empty($listing)){
			$config['uri_segment'] = 5;
			$config['base_url'] = site_url("kaizen/cms/dosearch/".rawurlencode($searchstring)."/");
		}
		elseif(!empty($searchstring) && !empty($listing)){
			$config['uri_segment'] = 5;
			$config['base_url'] = site_url("kaizen/cms/listing/".rawurlencode($searchstring)."/");
		}
		else{
			$config['uri_segment'] = 4;
			$config['base_url'] = site_url("kaizen/cms/index/");
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
	
	public function dolist($searchstring="",$language){
		$data = array();
		$total_row = $this->modelcms->getCountAll("cms_pages",$searchstring,$language);
		$this->pagination($searchstring,$total_row);
		$data['q'] = $searchstring;
		$data_row = $this->modelcms->getAllDetails("cms_pages",$this->limit,$this->offset,$searchstring,$language);
		if(empty($data_row)){
			$data['empty_msg'] = $total_row." record found.";
		}
		$data['total_records']= $total_row;
		$data['records']= $data_row;
		$data['pagination'] = $this->pagination->create_links();
		$this->load->view('kaizen/cms_list',$data);		
	}
	public function dosearch(){
		$offsets = (($this->uri->segment(5)) ? $this->uri->segment(5) : 1);
		if($offsets>1){$this->offset = (($offsets - 1)*$this->limit);}else{$this->offset = ($offsets - 1);}
		$searchstring = xss_clean(rawurldecode($this->uri->segment(4)));
		$this->dolist($searchstring);	
	}
	public function doadd(){
		$data = array();
		$cms_id=$this->uri->segment(4);
		$data['details']->is_active = 1;
		$data['details']->id = $cms_id;

		$data['cms_list']=$this->modelcms->getAllParentDetails();
		$data['hooks_cmsmenu']=$this->get_cms_menu();
		
		$this->load->view('kaizen/edit_cms',$data);		
	}
	public function addedit(){
		$language = $this->input->post('language',TRUE);
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('page_title', 'Title', 'trim|required|xss_clean');
		$this->form_validation->set_error_delimiters('<span class="validation_msg">', '</span>');
		$parent_id=$this->input->post('parent_id','');
		$id=$this->input->post('cms_id','');
		if($this->form_validation->run() == TRUE) // IF MENDATORY FIELDS VALIDATION TRUE(SERVER SIDE)  
		{	
			if($this->modelcms->getSingleRecord($id,$language)) 
			{			
				$getFile=$this->modelcms->editDetail($id,$language);
			
			
		
						
				if($this->modelcms->updateDetais($id,$language))
				{
					$session_data = array("SUCC_MSG"  => "Page updated successfully.");
					$this->session->set_userdata($session_data);					
				}			
				else // IF UPDATE PROCEDURE NOT EXECUTE SUCCESSFULLY
				{	
					$session_data = array("ERROR_MSG"  => "Page Not Updated.");
					$this->session->set_userdata($session_data);				
				}
			}
			else 
			{
			$id = $this->modelcms->addDetails();
				if($id) // IF UPDATE PROCEDURE EXECUTE SUCCESSFULLY
				{
					
					$session_data = array("SUCC_MSG"  => "Page Inserted SUCCESSFULLY.");
					#$this->session->set_userdata($session_data);					
				}			
				else // IF UPDATE PROCEDURE NOT EXECUTE SUCCESSFULLY
				{	
					$session_data = array("ERROR_MSG"  => "Page Not Inserted.");
					$this->session->set_userdata($session_data);				
				}
			}
			//redirect("kaizen/cms/doedit/".$id,'refresh');
			if(empty($language)){
				redirect("kaizen/cms/doedit/".$id,'refresh');
			}else{
				redirect("kaizen/cms/doedit/".$id."?language=".$language,'refresh');
			}
		}
		else{
			$this->load->view('kaizen/edit_cms/'.$id);
		}
	}
	public function doedit(){
		$data = array();
		$cms_id=$this->uri->segment(4);
		$language = $this->input->get('language',TRUE);
		$data['details'] = $this->modelcms->editDetail($cms_id,$language);		
		$data['cms_list']=$this->modelcms->getAllParentDetails($language);
		$data['hooks_cmsmenu']=$this->get_cms_menu($language);
		$this->load->view('kaizen/edit_cms',$data);				
	}
	
	
	public function doeditajax(){
		
			$data = array();
		$cms_id=$this->uri->segment(4);
		
		$language = $this->input->get('language',TRUE);
		
		
		$q	= $this->modelcms->editDetail($cms_id,$language);
		
		
		if($q){
			$data['details'] = $q;
		}
		else{
			$data['details']->is_active = 1;
			$data['details']->id = $cms_id;
		}
		$data['language'] = $language;
				
		$data['cms_list']=$this->modelcms->getAllParentDetails($language);
		$data['hooks_cmsmenu']=$this->get_cms_menu($language);
		$this->load->view('kaizen/edit_cms_ajax',$data);	
		
	}
	public function dodelete(){
		
		$del_id=$this->input->get('deleteid');
		$ref=rawurldecode($this->input->get('ref'));
		$tablename="cms_pages";
		$idname='id';
			
		$delrec=$this->modelcms->delSingleRecord($del_id,$tablename,$idname);
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
	
	public function do_changestatus() // CHANGE STATUS
	{
		
	    $status_id=$this->uri->segment(4, 0); // STATUS CHANGE RECORD ID
		
						
		if((int)$status_id > 0 && $this->modelcms->getSingleRecord($status_id))
		{ 
			if($this->modelcms->changeStatus($status_id))
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
		//redirect("kaizen/cms",'refresh');
		header('location:'.$_SERVER['HTTP_REFERER']);
	}	
	
	public function get_cms_menu($language){		
		$this->load->model('kaizen/model_cms_menu');	
		if($this->model_cms_menu->count_menu()){
			//$where=" where `parent_id`='0' ";
			if(!empty($language)){
				$this->db->set_dbprefix('is_french_');
			}
			$where=" where `site_id`='".$this->session->userdata('SITE_ID')."'";
			$cmsmenu = $this->model_cms_menu->cms_menu($where);
			
			$menus_array = array();
			foreach ($cmsmenu as $rs_menu_id){
			  $menus_array[$rs_menu_id->id] = array('id' => $rs_menu_id->id,'title' => $rs_menu_id->title,'parent_id' => $rs_menu_id->parent_id,'page_link' => $rs_menu_id->page_link);	
			}
			$TOP_NAV_MENU = '';
			$cms_menu = $this->generate_menu(0,$menus_array, $TOP_NAV_MENU, 0);
			if(!empty($language)){
				$this->db->set_dbprefix('is_');
			}
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
					$TOP_NAV_MENU .= '<li id="cms'.$value['id'].'" onclick="changecls(\'cms'.$value['id'].'\')"><a href="javascript:void(0);" onclick="javascript:openpage(\''.site_url("kaizen/cms/doeditajax/".$value['id']).'\');">' . $value['title'] . '</a>';			
				}
				elseif(in_array($value['page_link'],$static_menu_array)){
					$TOP_NAV_MENU .= '<li><a href="javascript:void(0);" >' . $value['title'] . '</a>';
				}
				else{
				
					$TOP_NAV_MENU .= '<li id="cms'.$value['id'].'" onclick="changecls(\'cms'.$value['id'].'\')"><a href="javascript:void(0);" onclick="javascript:openpage(\''.site_url("kaizen/cms/doeditajax/".$value['id']).'\');">' . $value['title'] . '</a>';		
							
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

		if($this->modelcms->setPublish($id))
		{
			echo "Status Changed Successfully.";
		}
		else
		{
			echo "Status Not Changed Successfully.";
		}
	}
		

	//=============== START IMAGE MANUPULATION==============// 
	
	function uploadImage($field='') 
    {		
		$upload_dir='cmspages/';
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
	
	public function dodeleteimg() // CHANGE STATUS
	{
		
	    $id=$this->input->get('deleteid');
		
						
		if((int)$id > 0 && $this->modelcms->getSingleRecord($id))
		{ 
			if($this->modelcms->deleteImg($id))
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
		$data['details'] = $this->modelcms->editDetail($id);	
		$data['cms_list']=$this->modelcms->getAllParentDetails();
		$data['hooks_cmsmenu']=$this->get_cms_menu();
		$this->load->view('kaizen/edit_cms',$data);		
		
		
	}			
	//=============== END IMAGE MANUPULATION==============//
}