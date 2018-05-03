<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery extends CI_Controller {
	var $data = array();
	public function __construct() {
	   parent::__construct();
	   // Set master content and sub-views
	   $this->load->vars( array(		  
		  'header' => 'templates/common/header',
		  'footer' => 'templates/common/footer'
		));
       $this->load->model('model_gallery');
	}

	
	public function index()	{
        $where_like = array();
        $length = $width = $breadth = '';
        $search = $this->input->get('search');
       
        if($search=='size'){
            $length = $this->input->get('length');
            $width = $this->input->get('width');
            $breadth = $this->input->get('breadth');
            if(!empty($length) || !empty($width) || !empty($breadth)){
                 if(!empty($length) && !empty($width) && !empty($breadth)){
                    $where_like =  array(
                        'size_length' => $length,
                        'size_width' => $width,
                        'size_breadth' => $breadth
                    );
                }elseif(!empty($length) && !empty($width)){
                    $where_like =  array(
                        'size_length' => $length,
                        'size_width' => $width
                    );
                }elseif(!empty($length) && !empty($breadth)){
                    $where_like =  array(
                        'size_length' => $length,
                        'size_breadth' => $breadth
                    );
                }else if(!empty($width) && !empty($breadth)){
                    $where_like =  array(
                        'size_width' => $width,
                        'size_breadth' => $breadth
                    );
                }elseif(!empty($length)){
                    $where_like =  array(
                        'size_length' => $length
                    );
                }elseif(!empty($width)){
                    $where_like =  array(
                        'size_width' => $width
                    );
                }elseif(!empty($breadth)){
                    $where_like =  array(
                        'size_breadth' => $breadth
                    );
                }/*else{                
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
                    'size_breadth' => $search_val,
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
        $this->data['breadth'] = $breadth;
		$where = array('is_active' =>1);
        $order_by = array('title'=>'asc','sub_title'=>'asc','gallery_photo'=>'asc');
		//$order_by = array('sub_title'=>'asc','gallery_photo'=>'asc');
		$this->db->set_dbprefix('is_');
		$this->data['gallery_list'] = $this->model_gallery->select_row('gallery',$where,$order_by,'',$where_like);
		$this->load->view('templates/gallery',$this->data);
	}
    public function details(){
       $id = $this->uri->segment(3);
       $where = array('id'=>$id);
       $gallery = $this->model_gallery->select_row('gallery',$where);
       $this->data['gallery'] = $gallery[0];
       $this->load->view('templates/gallery_details',$this->data);
    }
}
