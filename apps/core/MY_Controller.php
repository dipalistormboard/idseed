<?php 
/**
* Base Controller - All controllers should extend this one.
* @author Raul Chedrese
*/
class MY_Controller extends CI_Controller {

  public $data = array();

  function __construct() {
    parent::__construct();
    $this->data['errors'] = array();
    $this->data['site_name'] = config_item('site_name');
  }
  
  public function authenticate() {
		if($this->session->userdata('web_admin_logged_in')!=TRUE) {
  		$data['error'] = "Please login with your credentials";

  		$this->load->view('kaizen/login_page', $data);
      redirect('kaizen/welcome');
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
        $data_details = $this->model_common->select_row($table_name,$where);
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
            if($this->model_common->update_row($table_name,$update_data,$update_where)){
				
			    if($data_details[0]->is_active ==0 && $fetch_class=='home_user_service')
				{
					$this->activeinactive($data_id,1,$table_name);
				}
				 elseif($data_details[0]->is_active ==0 && $fetch_class=='banner')
				{
					$this->activeinactive($data_id,'-2','banner');
				}
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
			$activedata = $this->model_common->getAllActivedata($table);
			foreach($activedata as $data){
				$update_data  = array('is_active'=>0);  
				$update_where = array('id' => $data->id);
				if($data->id != $id){
				   if(!empty($limit))
				   {
					   if(!empty($data->is_active))
					   {
								if($count > $limit){
										$this->model_common->update_row($table,$update_data,$update_where);
								}
						$count++;
					   }
				   }
				   else
				   {
					   $this->model_common->update_row($table,$update_data,$update_where);
				   }
				}
			}
			
	}
  
}