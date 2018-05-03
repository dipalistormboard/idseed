<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Glossary extends CI_Controller 
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
		  'left' => 'kaizen/common/glossary_left',
		  'footer' => 'kaizen/common/footer'
		));
		$this->load->library('pagination');
		$this->load->model('kaizen/modelglossary');
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
	 public function newcrop(){
		$image_id = $this->input->get("image_id");
		$image_val = $this->input->get("image_val");
		$folder_name = $this->input->get("folder_name");
		$img_sceen = $this->input->get("img_sceen");
		$prev_img = $this->input->get("prev_img");
		
		$height = $this->input->get("height");
		$width = $this->input->get("width");
        $controller = $this->input->get("controller");
		
		$data['image_id'] = $image_id;
		$data['folder_name'] = $folder_name;
		$data['img_sceen'] = $img_sceen;
		$data['prev_img'] = $prev_img;
		
        $data['height'] = $height;
		$data['image_val'] = $image_val;
		$data['width'] = $width;
        $data['controller'] = $controller;
		
		$this->load->view("kaizen/cropfinal",$data);	
	}
	 public function saveimage(){
		$imageData = $this->input->post("result_img");	
		$upload_dir = $this->input->post("folder_name");
		
		$bigimageData = $this->input->post("big_image");	
		
		$image_val = $this->input->post("image_val");	
			
		$filteredData=substr($imageData, strpos($imageData, ",")+1);
		$filteredData1=substr($bigimageData, strpos($bigimageData, ",")+1);
 
	  // Need to decode before saving since the data we received is already base64 encoded
	  $unencodedData=base64_decode($filteredData);
	   $unencodedData1=base64_decode($filteredData1);
	 
	  //echo "unencodedData".$unencodedData;
	 
	  // Save file. This example uses a hard coded filename for testing,
	  // but a real application can specify filename in POST variable
	  //$upload_dir = "gallery_photo/";
	 if(!empty($image_val)){
		$image_name = $image_val;
	}else{
	  $image_name = uniqid().'.jpg';
	}
	  
	  $fp = fopen(file_upload_absolute_path().$upload_dir.'/'.$image_name, 'wb' );
	  fwrite( $fp, $unencodedData);
	  fclose( $fp );
	  
	   if(empty($image_val) || !empty($bigimageData)){
	  $fp1 = fopen(file_upload_absolute_path().$upload_dir.'/resize_'.$image_name, 'wb' );
	  fwrite( $fp1, $unencodedData1);
	  fclose( $fp1 );
	 }
	  
	  
	  echo $image_name;
	}
	public function pagination($searchstring="",$total_row=0){
		$config['use_page_numbers'] = TRUE;		
		if(!empty($searchstring)){
			$config['uri_segment'] = 5;
			$config['base_url'] = site_url("kaizen/glossary/dosearch/".rawurlencode($searchstring)."/");
		}
		else{
			$config['uri_segment'] = 4;
			$config['base_url'] = site_url("kaizen/glossary/index/");
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
		$total_row = $this->modelglossary->getCountAll("glossary",$searchstring,$pos);
		$this->pagination($searchstring,$total_row);
		$data['q'] = $searchstring;
		
		$data_row = $this->modelglossary->getAllDetails("glossary",$this->limit,$this->offset,$searchstring,$pos);
		if(empty($data_row)){
			$data['empty_msg'] = $total_row."No record found.";
		}
		$data['total_records']= $total_row;
		$data['records']= $data_row;
		$data['pagination'] = $this->pagination->create_links();
		$this->load->view('kaizen/glossary_list',$data);		
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
		$glossary_id=$this->uri->segment(4);
		$data['details']->is_active = 1;
		$data['details']->id = $glossary_id;
		
		$data_row = $this->modelglossary->getAllDetails("glossary");
		$data['records']= $data_row;
		
		$this->load->view('kaizen/edit_glossary',$data);		
	}
	public function addedit()
	{
		$language = $this->input->post('language',TRUE);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('glossary_title', 'Title', 'trim|required|xss_clean');
		
		
		$this->form_validation->set_error_delimiters('<span class="validation_msg">', '</span>');
		$id=$this->input->post('glossary_id','');
		if($this->form_validation->run() == TRUE) // IF MENDATORY FIELDS VALIDATION TRUE(SERVER SIDE)  
		{	
			if($this->modelglossary->getSingleRecord($id)) 
			{
						
			
				if($this->modelglossary->updateDetais($id,$language)) // IF UPDATE PROCEDURE EXECUTE SUCCESSFULLY
				{
					$session_data = array("SUCC_MSG"  => "Glossary Updated Successfully.");
					$this->session->set_userdata($session_data);					
				}			
				else // IF UPDATE PROCEDURE NOT EXECUTE SUCCESSFULLY
				{	
					$session_data = array("ERROR_MSG"  => "Glossary Not Updated.");
					$this->session->set_userdata($session_data);				
				}
			}
			else 
			{
				$uplod_img = '';		
					
				//if(is_uploaded_file($_FILES['htmlfile']['tmp_name'])) // if image file upload at the updating
//				{				
//					$uplod_img=$this->uploadImage('htmlfile');
//				}
 				//$uplod_img = $this->input->post("glossary_image");
			
				$id = $this->modelglossary->addDetails();
				if($id) // IF UPDATE PROCEDURE EXECUTE SUCCESSFULLY
				{
					$session_data = array("SUCC_MSG"  => "Glossary Inserted Successfully.");
					$this->session->set_userdata($session_data);					
				}			
				else // IF UPDATE PROCEDURE NOT EXECUTE SUCCESSFULLY
				{	
					$session_data = array("ERROR_MSG"  => "Glossary Not Inserted.");
					$this->session->set_userdata($session_data);				
				}
				
			}
			$from=$this->input->post('from',TRUE); 
      $pgs = $this->input->post('pagenum');
			if($from!= 'edit'){
                redirect("kaizen/glossary/".$from,'refresh');
            }else{
				if(empty($language)){
					redirect("kaizen/glossary/doedit/".$id."?page=".$pgs,'refresh');
				}else{
					redirect("kaizen/glossary/doedit/".$id."?language=".$language."&page=".$pgs,'refresh');
				}
			redirect("kaizen/glossary/doedit/".$id,'refresh');
            }	
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
        $language = $this->input->get('language',TRUE);
		$data = array();
		$glossary_id=$this->uri->segment(4);
		$q = $this->modelglossary->editDetail($glossary_id,$language);		
		
		if($q){
			$data['details'] = $q;
		}
		else{
			$data['details']->is_active = 1;
			$data['details']->id = 0;
		}
		 $data['pgs']= $this->input->get('page');
		$data['language'] = $language;
		$data_row = $this->modelglossary->getAllDetails("glossary",$language);
		$data['records']= $data_row;
		
		$this->load->view('kaizen/edit_glossary',$data);		
		
	}
	public function dodelete(){		
		$del_id=$this->input->get('deleteid');
		$ref=rawurldecode($this->input->get('ref'));
		$tablename="glossary";
		$idname='id';
			
		$delrec=$this->modelglossary->delSingleRecord($del_id,$tablename,$idname);
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
		
						
		if((int)$status_id > 0 && $this->modelglossary->getSingleRecord($status_id))
		{ 
			if($this->modelglossary->changeStatus($status_id))
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
		//redirect("kaizen/glossary",'refresh');
		header('location:'.$_SERVER['HTTP_REFERER']);
	}	
	
	
	
	public function dodeleteimg() // CHANGE STATUS
	{
		
	    $id=$this->input->get('deleteid');
		 $glossary_image=$this->input->get('glossary_image');
		
			 $language=$this->input->get('language');			
		if((int)$id > 0 && $this->modelglossary->getSingleRecord($id))
		{ 
			if($this->modelglossary->deleteImg($id,$glossary_image,$language))
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
		 $data['language'] = $language;
		$data['details'] = $this->modelglossary->editDetail($id,$language);
		
		$this->load->view('kaizen/edit_glossary',$data);		
		
		
	}	
	
	
	function uploadImage($field='') 
    {		
		$upload_dir='glossary/';
		$field_name=$field;
		
		if(!is_dir(file_upload_absolute_path().$upload_dir)){
			$oldumask = umask(0); 
			mkdir(file_upload_absolute_path().$upload_dir, 0777); // or even 01777 so you get the sticky bit set 
			umask($oldumask);
		}
		
     	$config['upload_path'] = file_upload_absolute_path().$upload_dir;
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '20000';
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
	
	
	 public function statusChange(){
	  $fetch_class = $this->uri->segment(2, 0);
      $data_id = $this->uri->segment(4, 0);
      $table_name = $this->uri->segment(5, 0);
      if(!empty($data_id) && !empty($table_name)){
        $where = array(
                            'id' => $data_id
                        );
        $data_details = $this->modelglossary->select_row($table_name,$where);
        if(!empty($data_details[0])){
            if($data_details[0]->is_active == 1){
                $update_data = array(
                        'is_active' =>0
                       );
            }else{
                $update_data = array(
                        'is_active' =>1
                       );
            }
            $update_where = array('id' => $data_id);
            if($this->modelglossary->update_row($table_name,$update_data,$update_where)){
                $session_data = array("SUCC_MSG"  => "Status Changed Successfully.");
				$this->session->set_userdata($session_data);
            }else{
                $session_data = array("ERROR_MSG"  => "Status Not Changed Successfully.");
                $this->session->set_userdata($session_data);
            }
        }else{
                $session_data = array("ERROR_MSG"  => "Status Not Changed Successfully.");
                $this->session->set_userdata($session_data);
        }       
      }else
        {
                $session_data = array("ERROR_MSG"  => "Status Not Changed Successfully.");
                $this->session->set_userdata($session_data);
        }
      redirect("kaizen/".$this->router->fetch_class(),'refresh');
  }
  
	//=============== END IMAGE MANUPULATION==============//
}