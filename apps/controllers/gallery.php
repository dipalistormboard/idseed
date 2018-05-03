<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery extends CI_Controller {
	var $data = array();
	private $limit = 12;
	public function __construct() {
	   parent::__construct();
	   // Set master content and sub-views
	   $this->load->vars( array(		  
		  'header' => 'templates/common/header',
		  'footer' => 'templates/common/footer'
		));
		
       $this->load->model('model_gallery');
	    $this->load->library('pagination');
	}

	
	public function index()	{
        $where_like = array();
        $length = $width = '';
		//$breadth = '';
        $search = $this->input->get('search');
		
		 $offsets = $this->input->get('per_page',TRUE);
		if($offsets>1){$this->offset = (($offsets - 1)*$this->limit);}	
		$page_cat = xss_clean($this->uri->segment(1));	
		$request_type 			  			    = xss_clean($this->input->get('type', TRUE));
		
		
       
        if($search=='size'){
            $length = $this->input->get('length');
            $width = $this->input->get('width');
           // $breadth = $this->input->get('breadth');
            if(!empty($length) || !empty($width) ){
                 if(!empty($length) && !empty($width) ){
                    $where_like =  array(
                        'size_length' => $length,
                        'size_width' => $width						
                       // ,'size_breadth' => $breadth
                    );
                }/*elseif(!empty($length) && !empty($width)){
                    $where_like =  array(
                        'size_length' => $length,
                        'size_width' => $width
                    );
                }*/
				elseif(!empty($length)){
                    $where_like =  array(
                        'size_length' => $length
						//,'size_breadth' => $breadth
                    );
                }else if(!empty($width)){
                    $where_like =  array(
                        'size_width' => $width
						//,'size_breadth' => $breadth
                    );
                }/*elseif(!empty($length)){
                    $where_like =  array(
                        'size_length' => $length
                    );
                }elseif(!empty($width)){
                    $where_like =  array(
                        'size_width' => $width
                    );
                }*/
				/*elseif(!empty($breadth)){
                    $where_like =  array(
                        'size_breadth' => $breadth
                    );
                }*//*else{                
                    $where_like =  array(
                        'size_length' => $length,
                        'size_width' => $width,
                        'size_breadth' => $breadth
                    );
                }*/
            }
        }elseif($search!='size' && !empty ($search)){
            $search_val = $this->input->get('search_val');
            if($search=='keyword'){
                $where_like =  array(
                    'title' => $search_val,
                    'sub_title' => $search_val,
                    'size_length' => $search_val,
                    'size_width' => $search_val,
                   /* 'size_breadth' => $search_val,*/
                    'shape' => $search_val,
                    'colour' => $search_val,
                    'excerpt' => $search_val,
                    'description' => $search_val
                );
            }else{
                $where_like =  array(
                    $search => $search_val
                );
            }
        }
        $this->data['search'] = $search;
        $this->data['search_val'] = $search_val;
        $this->data['length'] = $length;
        $this->data['width'] = $width;
        //$this->data['breadth'] = $breadth;
		$where = array('is_active' =>1);
        $order_by = array('title'=>'asc','sub_title'=>'asc','gallery_photo'=>'asc');
		//$order_by = array('sub_title'=>'asc','gallery_photo'=>'asc');
		
    
		if($this->session->userdata('language_version') == "french"){
			$this->db->set_dbprefix('is_french_');
		}
		else{
		  $this->db->set_dbprefix('is_');
		}
		
		 $total_row = $this->model_gallery->total_gallery_list($where_like);
		
		$this->data['gallery_list'] = $this->model_gallery->gallery_list($this->offset,$this->limit,$where_like);
		
		
		
		 $this->pagination($total_row,'',$search,$search_val,$length,$width);
		 
		 
		$this->data['total_records']= $total_row;
		$this->data['pagination'] = $this->pagination->create_links();	
		
		
		if($request_type == 'ajax')
		{
			$this->load->view('templates/ajax-pagination-data',$this->data);
		}	
		else
		{
			$this->load->view('templates/gallery',$this->data);
		}
    
    
		//$this->data['gallery_list'] = $this->model_gallery->select_row('gallery',$where,$order_by,'',$where_like);
		//$this->load->view('templates/gallery',$this->data);
	}
	
	
	
	
	public function pagination($total_row=0,$cs='index',$search,$search_val,$length,$width){
		$config['use_page_numbers'] = TRUE;		
		$config['page_query_string'] = TRUE;
		$config['uri_segment'] = 3;
		$search_url = '';
    
		
    
		$config['base_url'] = base_url("gallery/".$cs)."/?type=ajax&search=".$search."&search_val=".$search_val."&length=".$length."&width=".$width;
		$config['total_rows'] = $total_row;
		$config['per_page'] = $this->limit;
		$config['first_link'] = '<<';
		$config['last_link'] = '>>';
		$config['next_link'] = 'Next Page';
		$config['prev_link'] = 'Previous Page';
		$config['first_tag_open'] = '<li class="jp-first">';
		$config['first_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="jp-current"><a class="active">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';	
		$config['next_tag_open'] = '<li class="jp-next">';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="jp-previous">';
		$config['prev_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="jp-last">';
		$config['last_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		return $config;
	}
	
	
    public function details(){
       $id = $this->uri->segment(3);
       $where = array('id'=>$id);
       $gallery = $this->model_gallery->select_row('gallery',$where);
       $this->data['gallery'] = $gallery[0];
       $this->load->view('templates/gallery_details',$this->data);
    }
}
