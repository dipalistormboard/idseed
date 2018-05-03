<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_banner extends CI_Controller 
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
		  'left' => 'kaizen/common/common_banner_left',
		  'footer' => 'kaizen/common/footer'
		));
		$this->load->library('pagination');
		$this->load->model('kaizen/modelcommon_banner');
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
			$config['base_url'] = site_url("kaizen/common_banner/dosearch/".rawurlencode($searchstring)."/");
		}
		else{
			$config['uri_segment'] = 4;
			$config['base_url'] = site_url("kaizen/common_banner/index/");
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
		$total_row = $this->modelcommon_banner->getCountAll("common_banner",$searchstring,$pos);
		$this->pagination($searchstring,$total_row);
		$data['q'] = $searchstring;
		
		$data_row = $this->modelcommon_banner->getAllDetails("common_banner",$this->limit,$this->offset,$searchstring,$pos);
		if(empty($data_row)){
			$data['empty_msg'] = $total_row."No record found.";
		}
		if(!empty($data_row)){
			$data['page_list'] = $this->modelcommon_banner->getSingleRecordPageName($data_row[0]->page_id);
		}
		//$data['page_list'] = $this->modelcommon_banner->getSingleRecordPageName2($data_row[0]->page_id);
		//echo "<pre>";print_r($data_row);exit;
		$data['total_records']= $total_row;
		$data['records']= $data_row;
		$data['pagination'] = $this->pagination->create_links();
		$this->load->view('kaizen/common_banner_list',$data);		
	}
	public function dosearch(){
		//$this->load->helper('security');
		$offsets = (($this->uri->segment(5)) ? $this->uri->segment(5) : 1);
		if($offsets>1){$this->offset = (($offsets - 1)*$this->limit);}else{$this->offset = ($offsets - 1);}
		$searchstring = xss_clean(rawurldecode($this->uri->segment(4)));
		$this->dolist($searchstring);	
	}
	
	function prfileprogramselectbox($rs,$selected,$depth=0,$prg_is_array=array())
	{

		$tab='';
		for($k=0;$k<$depth;$k++)
			$tab .=	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		if($depth > 0)
			$tab .=	"-->";	
		$str = "";

		if(!empty($rs))
		{	
			foreach($rs as $category)
			{
			
			  $count_subcategory 	= array();

			     if(!in_array($category->id,$prg_is_array)){
							
							$str .= "<option value=\"".$category->id."\" ";
				
							if(is_array($selected))
							{
								foreach($selected as $val)
								{
									if($val == $category->id)
										$str .= " disabled ";
				
								}
							}
							else
							{
								if($selected == $category->id)
									$str .= " selected ";
							
							}
							$title_opt=$tab.$category->title;
							
						 if($category->parent_id!=0){ $title_opt = $tab.trim($this->modelcommon_banner->getpageName($category->parent_id)) .' >> '.$category->title ;}
						 
							$str .= ">".$title_opt."</option>\n";	
							
				 }
				
			}
			
		}
		return $str;
	   
	}
	
	public function doadd(){
		$data = array();
		
		$data['details']= new stdClass;
		$common_banner_id=$this->uri->segment(4);
		$data['details']->is_active = 1;
		$data['details']->id = $common_banner_id;
		//$data['page_list'] = $this->modelcommon_banner->getAllDetails('pages');
		$page_list = $this->modelcommon_banner->getDistinctPageDetails();
		$data['page_list'] = $page_list;
		
		$data_row = $this->modelcommon_banner->getAllDetails("common_banner");
		$prg_is_array=array();
		
		$page_id_B = $this->modelcommon_banner->getPageidcommon_banner();
		$selected_page_id = array();
		if(!empty($page_id_B)){
		foreach($page_id_B as $pval){
			$page_id_Arr=explode(',',$pval->page_id);
			foreach($page_id_Arr as $P_id){
			$selected_page_id[]=$P_id;
			}
			}
		}
		
		
		$data['pageList'] = $this->prfileprogramselectbox($page_list,$selected_page_id,'1',$prg_is_array);
		$data['records']= $data_row;
		
		$this->load->view('kaizen/edit_common_banner',$data);		
	}
	public function addedit()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('common_banner_title', 'Title', 'trim|required|xss_clean');
		$page_id = $this->input->post('page_id',TRUE);
		
			
		$this->form_validation->set_error_delimiters('<span class="validation_msg">', '</span>');
		$id=$this->input->post('common_banner_id','');
		if($this->form_validation->run() == TRUE) // IF MENDATORY FIELDS VALIDATION TRUE(SERVER SIDE)  
		{	
			if($this->modelcommon_banner->getSingleRecord($id)) 
			{
			
				$uplod_img ="";			
				$getFile=$this->modelcommon_banner->editDetail($id);
				$orgimgpath=$getFile->common_banner_photo;
			
			if(is_uploaded_file($_FILES['htmlfile']['tmp_name'])) // if image file upload at the updating
			{
					
				
				if(!empty($orgimgpath) && is_file(file_upload_absolute_path().'common_banner_photo/'.$orgimgpath)){
					unlink(file_upload_absolute_path().'common_banner_photo/'.$orgimgpath);
				}
				if(!empty($orgimgpath) && is_file(file_upload_absolute_path().'common_banner_photo/thumb_'.$orgimgpath)){
					unlink(file_upload_absolute_path().'common_banner_photo/thumb_'.$orgimgpath);
				}
				
				
								
				$uplod_img=$this->uploadImage('htmlfile','common_banner_photo/');
				//resizingImage($uplod_img,$upload_rootdir='common_banner_photo/',$img_width='2000',$img_height='250',$img_prefix = 'thumb_');
				if(empty($uplod_img) || $uplod_img==false)
				{
					$session_data = array("ERROR_MSG"  => "Error in image uploading.");
					$this->session->set_userdata($session_data);	
					redirect("kaizen/common_banner",'refresh');
				}
			}	
			else
			{
				$uplod_img=$orgimgpath;
			}
				
			
			
			
				if($this->modelcommon_banner->updateDetais($id,$uplod_img)) // IF UPDATE PROCEDURE EXECUTE SUCCESSFULLY
				{
					$session_data = array("SUCC_MSG"  => "Common Banner Updated Successfully.");
					$this->session->set_userdata($session_data);					
				}			
				else // IF UPDATE PROCEDURE NOT EXECUTE SUCCESSFULLY
				{	
					$session_data = array("ERROR_MSG"  => "Common Banner Not Updated.");
					$this->session->set_userdata($session_data);				
				}
			}
			else 
			{
				$uplod_img = '';		
					
			if(is_uploaded_file($_FILES['htmlfile']['tmp_name'])) // if image file upload at the updating
			{				
				$uplod_img=$this->uploadImage('htmlfile','common_banner_photo/');
				//resizingImage($uplod_img,$upload_rootdir='common_banner_photo/',$img_width='2000',$img_height='250',$img_prefix = 'thumb_');
			}
				$id = $this->modelcommon_banner->addDetails($uplod_img);
				if($id) // IF UPDATE PROCEDURE EXECUTE SUCCESSFULLY
				{
					$session_data = array("SUCC_MSG"  => "Common Banner Inserted Successfully.");
					$this->session->set_userdata($session_data);					
				}			
				else // IF UPDATE PROCEDURE NOT EXECUTE SUCCESSFULLY
				{	
					$session_data = array("ERROR_MSG"  => "Common Banner Not Inserted.");
					$this->session->set_userdata($session_data);				
				}
				
			}
			redirect("kaizen/common_banner/doedit/".$id,'refresh');			
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
    function uploadImage($field='') 
    {		
		$upload_dir='common_banner_photo/';
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
	public function doedit()
	{
		$data = array();
		$common_banner_id=$this->uri->segment(4);
		$q = $this->modelcommon_banner->editDetail($common_banner_id);		
		
		if($q){
			$data['details'] = $q;
		}
		else{
			$data['details']->is_active = 1;
			$data['details']->id = 0;
		}
		
		$selected_page_id=explode(',',$data['details']->page_id);
		
		$page_list = $this->modelcommon_banner->getSingleRecordPageName($selected_page_id);
		$data['page_list'] =$page_list;
		//echo "<pre>";print_r($data['page_list']);exit;
		//$data['page_list'] = $this->modelcommon_banner->getDistinctPageDetails();
		$data_row = $this->modelcommon_banner->getAllDetails("common_banner");
		$data['records']= $data_row;
		
		$allpage_list = $this->modelcommon_banner->getDistinctPageDetails();
		
		$prg_is_array=array();
		$page_id_B = $this->modelcommon_banner->getPageidcommon_banner();
		
		if(!empty($page_id_B)){
		foreach($page_id_B as $pval){
			$page_id_Arr=explode(',',$pval->page_id);
			foreach($page_id_Arr as $P_id){
			$selected_page_id[]=$P_id;
			}
			}
		}
		$data['pageList'] = $this->prfileprogramselectbox($allpage_list,$selected_page_id,'1',$prg_is_array);
		
		
		$data['selectedprg'] = $this->prfileprogramselectbox($page_list,'','1',$prg_is_array);
		
		#echo "<pre>";print_r($data['page_list']);exit;
		$this->load->view('kaizen/edit_common_banner',$data);		
		
	}
	public function dodelete(){		
		$del_id=$this->input->get('deleteid');
		$ref=rawurldecode($this->input->get('ref'));
		$tablename="common_banner";
		$idname='id';
		$data['page_list'] = $this->modelcommon_banner->getDistinctPageDetails();	
		$delrec=$this->modelcommon_banner->delSingleRecord($del_id,$tablename,$idname);
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
		
						
		if((int)$status_id > 0 && $this->modelcommon_banner->getSingleRecord($status_id))
		{ 
			if($this->modelcommon_banner->changeStatus($status_id))
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
		redirect("kaizen/common_banner",'refresh');
		
	}	
	
	public function dodeleteimg() // CHANGE STATUS
	{
		
	    $id=$this->input->get('deleteid');
		
						
		if((int)$id > 0 && $this->modelcommon_banner->getSingleRecord($id))
		{ 
			if($this->modelcommon_banner->deleteImg($id))
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
		$data['details'] = $this->modelcommon_banner->editDetail($id);
		//$this->load->view('kaizen/edit_common_banner',$data);	
		redirect("kaizen/common_banner/doedit/".$id,'refresh');		
		
		
	}	
		
}