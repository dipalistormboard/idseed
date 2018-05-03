<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Factsheet extends CI_Controller {
	var $data;
	public function __construct() {
	   parent::__construct();
	   // Set master content and sub-views
	   $this->load->vars( array(
		  'header' => 'templates/common/header',
		  'footer' => 'templates/common/footer'
		));
		$this->load->model('model_home');
		$this->load->model('model_factsheet');
	}
	public function index()	{
       		$page_link = $this->uri->segment(2);

			if($page_link == "index"){

				$this->data['details_family'] = $this->model_factsheet->getfactsheets_family();
				$this->data['details_scientific'] = $this->model_factsheet->getfactsheets_sci();
				$this->data['details_comm'] = $this->model_factsheet->getfactsheets_comm();
				$this->data['details_all'] = $this->model_factsheet->getfactsheets_all();
				$this->load->view('templates/fact',$this->data);
			}else{
				$this->data["page_link"] = $page_link;
				$this->data['factsheet_detail'] = $this->model_factsheet->getfactsheet_detail($page_link);
				$factsheet_master_id = $this->data['factsheet_detail']->id;
				$this->data['factsheet_image_gallery'] = $this->model_factsheet->getfactsheet_image_gallery($factsheet_master_id);
				//$this->data['factsheet_species_images'] = $this->model_factsheet->getfactsheet_species_images($factsheet_master_id);

				$this->data["tabval"] = $this->uri->segment(3);
				if(($this->uri->segment(3) == 'tab_1')){
				$result4= $this->db->query("SELECT id,page_link FROM `".$this->db->dbprefix('factsheet')."` order by family asc");
				}
				else if(($this->uri->segment(3) == 'tab_2')){
				$result4= $this->db->query("SELECT id,page_link FROM `".$this->db->dbprefix('factsheet')."` order by title asc");
				}
				else if(($this->uri->segment(3) == 'tab_3')){
				$result4= $this->db->query("SELECT id,page_link FROM `".$this->db->dbprefix('factsheet')."` order by common_name asc");
				}
				else if(($this->uri->segment(3) == 'tab_4')){
				$result4= $this->db->query("SELECT id,page_link FROM `".$this->db->dbprefix('factsheet')."` order by regulation_keyword asc");
				}else{
					$result4= $this->db->query("SELECT id,page_link FROM `".$this->db->dbprefix('factsheet')."` order by family asc");
					}
				$arrresult = 	$result4->result_array();
				$key = array_search($factsheet_master_id, array_column($arrresult, 'id'));


				$this->data["nextval"] = $arrresult[$key+1]['page_link'];
				$this->data["prevval"] = $arrresult[$key-1]['page_link'];

				$this->load->view('templates/fact_details',$this->data);
			}


	}


}
