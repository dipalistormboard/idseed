<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Keys extends CI_Controller 
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
		  'left' => 'kaizen/common/keys_left',
		  'footer' => 'kaizen/common/footer'
		));
		$this->load->library('pagination');
		$this->load->model('kaizen/modelkeys');
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
			$config['base_url'] = site_url("kaizen/keys/dosearch/".rawurlencode($searchstring)."/");
		}
		else{
			$config['uri_segment'] = 4;
			$config['base_url'] = site_url("kaizen/keys/index/");
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
		$total_row = $this->modelkeys->getCountAll("keys",$searchstring,$pos);
		$this->pagination($searchstring,$total_row);
		$data['q'] = $searchstring;
		
		$data_row = $this->modelkeys->getAllDetails("keys",$this->limit,$this->offset,$searchstring,$pos);
		if(empty($data_row)){
			$data['empty_msg'] = $total_row."No record found.";
		}
		$data['total_records']= $total_row;
		$data['records']= $data_row;
		$data['pagination'] = $this->pagination->create_links();
		$this->load->view('kaizen/keys_list',$data);		
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
		$banner_id=$this->uri->segment(4);
		$data['details']->is_active = 1;
		$data['details']->id = $banner_id;
		
		$data_row = $this->modelkeys->getAllDetails("keys");
		$data['records']= $data_row;
		
		$this->load->view('kaizen/edit_keys',$data);		
	}
	public function addedit()
	{
		$language = $this->input->post('language',TRUE);
		
		$this->is_active		=$this->input->post('is_active',TRUE); 
		$this->load->library('form_validation');
		$this->form_validation->set_rules('keys_title', 'Title', 'trim|required|xss_clean');
		
		
		$this->form_validation->set_error_delimiters('<span class="validation_msg">', '</span>');
		$id=$this->input->post('keys_id','');
		if($this->form_validation->run() == TRUE) // IF MENDATORY FIELDS VALIDATION TRUE(SERVER SIDE)  
		{	
			if($this->modelkeys->getSingleRecord($id)) 
			{
			
				$uplod_img ="";			
				$getFile=$this->modelkeys->editDetail($id,$language);
				
			
				
			  
			
			
				if($this->modelkeys->updateDetais($id,$language)) // IF UPDATE PROCEDURE EXECUTE SUCCESSFULLY
				{
					
					$session_data = array("SUCC_MSG"  => "Keys Updated Successfully.");
					$this->session->set_userdata($session_data);					
				}			
				else // IF UPDATE PROCEDURE NOT EXECUTE SUCCESSFULLY
				{	
					$session_data = array("ERROR_MSG"  => "Keys Not Updated.");
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
				$id = $this->modelkeys->addDetails($uplod_img);
				if($id) // IF UPDATE PROCEDURE EXECUTE SUCCESSFULLY
				{ 
					$session_data = array("SUCC_MSG"  => "Keys Inserted Successfully.");
					$this->session->set_userdata($session_data);					
				}			
				else // IF UPDATE PROCEDURE NOT EXECUTE SUCCESSFULLY
				{	
					$session_data = array("ERROR_MSG"  => "Keys Not Inserted.");
					$this->session->set_userdata($session_data);				
				}
				
			}
			//redirect("kaizen/keys/doedit/".$id,'refresh');	
			if(empty($language)){
				redirect("kaizen/keys/doedit/".$id,'refresh');
			}else{
				redirect("kaizen/keys/doedit/".$id."?language=".$language,'refresh');
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
		$data = array();
		$banner_id=$this->uri->segment(4);
		
		$language = $this->input->get('language',TRUE);
		
		$q = $this->modelkeys->editDetail($banner_id,$language);		
		
		if($q){
			$data['details'] = $q;
		}
		else{
			$data['details']->is_active = 1;
			$data['details']->id = 0;
		}
		$data['language'] = $language;
		$data_row = $this->modelkeys->getAllDetails("keys",$language);
		$data['records']= $data_row;
		
		$this->load->view('kaizen/edit_keys',$data);		
		
	}
	public function dodelete(){		
		$del_id=$this->input->get('deleteid');
		$ref=rawurldecode($this->input->get('ref'));
		$tablename="keys";
		$idname='id';
			
		$delrec=$this->modelkeys->delSingleRecord($del_id,$tablename,$idname);
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
		
						
		if((int)$status_id > 0 && $this->modelkeys->getSingleRecord($status_id))
		{ 
			if($this->modelkeys->changeStatus($status_id))
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
	

		//=============== START IMAGE MANUPULATION==============// 
	
	
   
	//=============== END IMAGE MANUPULATION==============//
  public function statusChange(){
	  $fetch_class = $this->uri->segment(2, 0);
      $data_id = $this->uri->segment(4, 0);
      $table_name = $this->uri->segment(5, 0);
      if(!empty($data_id) && !empty($table_name)){
        $where = array(
                            'id' => $data_id
                        );
        $data_details = $this->modelkeys->select_row($table_name,$where);
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
            if($this->modelkeys->update_row($table_name,$update_data,$update_where)){
				
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
   function activeinactive($id,$limit,$table){
			$count = 0;
			$activedata = $this->modelkeys->getAllActivedata($table);
			foreach($activedata as $data){
				$update_data  = array('is_active'=>0);  
				$update_where = array('id' => $data->id);
				if($data->id != $id){
				   if(!empty($limit))
				   {
					   if(!empty($data->is_active))
					   {
								if($count > $limit){
										$this->modelkeys->update_row($table,$update_data,$update_where);
								}
						$count++;
					   }
				   }
				   else
				   {
					   $this->modelkeys->update_row($table,$update_data,$update_where);
				   }
				}
			}
			
	}
}