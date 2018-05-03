<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Factsheet extends CI_Controller
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
			'left' => 'kaizen/common/factsheet_left',
			'footer' => 'kaizen/common/footer'
		));
		$this->load->library('pagination');
		$this->load->model('kaizen/modelfactsheet');
		$this->load->library('image_lib'); // LOAD IMAGE THUMB LIBRARY
	}

	public function index()
	{
		//$this->load->helper('security');
		$offsets = (($this->uri->segment(4)) ? $this->uri->segment(4) : 1);
		if($offsets>1){$this->offset = (($offsets - 1)*$this->limit);}else{$this->offset = ($offsets - 1);}
		$searchstring = xss_clean(rawurldecode($this->input->get('q')));
		$searchtype = xss_clean(rawurldecode($this->input->get('field')));
		$this->dolist($searchstring,$searchtype);
	}

	public function pagination($searchstring="",$total_row=0,$searchtype=""){
		$config['use_page_numbers'] = TRUE;
		if(!empty($searchstring)){
			$config['uri_segment'] = 5;
			$config['base_url'] = site_url("kaizen/factsheet/dosearch/".rawurlencode($searchstring)."/".rawurlencode($searchtype));
		}
		else{
			$config['uri_segment'] = 4;
			$config['base_url'] = site_url("kaizen/factsheet/index/");
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

	public function dolist($searchstring="",$searchtype=""){
		$data = array();
		$pos = $this->input->get('pos',TRUE);
		$total_row = $this->modelfactsheet->getCountAll("factsheet",$searchstring,$pos,$searchtype);
		$this->pagination($searchstring,$total_row,$searchtype);
		$data['q'] = $searchstring;
		$data['field'] = $searchtype;

		$data_row = $this->modelfactsheet->getAllDetails("factsheet",$this->limit,$this->offset,$searchstring,$pos,$searchtype);
		if(empty($data_row)){
			$data['empty_msg'] = $total_row."No record found.";
		}
		$data['total_records']= $total_row;
		$data['records']= $data_row;
		$data['pagination'] = $this->pagination->create_links();
		$this->load->view('kaizen/factsheet_list',$data);
	}
	public function dosearch(){
		//$this->load->helper('security');
		$offsets = (($this->uri->segment(5)) ? $this->uri->segment(5) : 1);
		if($offsets>1){$this->offset = (($offsets - 1)*$this->limit);}else{$this->offset = ($offsets - 1);}
		$searchstring = xss_clean(rawurldecode($this->uri->segment(4)));
		$searchtype = xss_clean(rawurldecode($this->uri->segment(5)));
		$this->dolist($searchstring,$searchtype);
	}
	public function doadd(){
		$data = array();
		$factsheet_id=$this->uri->segment(4);
		$data['details']->is_active = 1;
		$data['details']->id = $factsheet_id;


		$data_row = $this->modelfactsheet->getAllDetails("factsheet");
		$data['records']= $data_row;



		$data_row1 = $this->modelfactsheet->getRecords_gallery($factsheet_id);
		$data['details_gallery']= $data_row1;
		//$data_row2 = $this->modelfactsheet->getRecords_species($factsheet_id);
		//$data['details_species']= $data_row2;

		$this->load->view('kaizen/edit_factsheet',$data);
	}
	public function addedit()
	{

		$factsheet_image = '';
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');

		$language = $this->input->get('language',TRUE);
		$this->form_validation->set_error_delimiters('<span class="validation_msg">', '</span>');
		$id=$this->input->post('factsheet_id','');
		if($this->form_validation->run() == TRUE) // IF MENDATORY FIELDS VALIDATION TRUE(SERVER SIDE)
		{
			if($this->modelfactsheet->getSingleRecord($id,$language))
			{
				//echo "<pre>";


				if(!empty($language)){
					$this->db->set_dbprefix('is_french_');
				}

				if($this->modelfactsheet->updateDetais($id)) // IF UPDATE PROCEDURE EXECUTE SUCCESSFULLY
				{
					////////// Insert - Factsheet gallery Starts   //////////


					$this->modelfactsheet->delSingleRecord($id,'factsheet_image_gallery','factsheet_master_id');

					$factsheet_image ="";
					$main_image_gal = $this->input->post('main_image_gal',true);
					if(!empty($main_image_gal)){
						$factsheet_image = $this->input->post("factsheet_image_".$main_image_gal);
						$factsheet_caption = $this->input->post("factsheet_caption_".$main_image_gal);
						$factsheet_image_title = $this->input->post("factsheet_image_title_".$main_image_gal);
						if(!empty($factsheet_image)){

							$gallery_add_data1 = array(
								'factsheet_master_id' => $id,
								'factsheet_image' => $factsheet_image,
								'factsheet_image_title' => $factsheet_image_title,
								'factsheet_image_caption' => $factsheet_caption
							);

							$this->db->insert($this->db->dbprefix('factsheet_image_gallery'), $gallery_add_data1);

						}
					}
					$count_img_gal = $this->input->post('count_img_gal',true);
					$main_image_gal = $this->input->post('main_image_gal',true);

					if(!empty($count_img_gal)){

						if($count_img_gal >1){
							for($i =1;$i<$count_img_gal;$i++){
								if($i != $main_image_gal){

									$factsheet_image = $this->input->post("factsheet_image_".$i);
									$factsheet_caption = $this->input->post("factsheet_caption_".$i);
									$factsheet_image_title = $this->input->post("factsheet_image_title_".$i);
									if(!empty($factsheet_image)){
										$gallery_add_data1 = array(
											'factsheet_master_id' => $id,
											'factsheet_image' => $factsheet_image,
											'factsheet_image_title' => $factsheet_image_title,
											'factsheet_image_caption' => $factsheet_caption
										);

										$this->db->insert($this->db->dbprefix('factsheet_image_gallery'), $gallery_add_data1);
									}
								}


							}

						}
					}


					//echo $this->db->last_query();

					////////// Insert - Factsheet gallery Ends   //////////


					////////// Insert - Factsheet Species Starts   //////////

					/*					$this->modelfactsheet->delSingleRecord($id,'factsheet_similar_species_image','factsheet_master_id');
					$factsheet_caption_arr1 = $this->input->post('factsheet_similar_species_image_caption',TRUE);
					$hdn_factsheet_image_arr1 = $this->input->post('hdn_factsheet_similar_species_image',TRUE);
					$factsheet_image_arr1 =	$this->upload_files('factsheet_species_image/', $_FILES['factsheet_similar_species_image']);
					$product_img ="";
					$main_image = $this->input->post('main_image',true);
					if(!empty($main_image)){
					$product_img = $this->input->post("factsheet_similar_species_image_".$main_image);
					$species_title = $this->input->post("factsheet_similar_species_image_title_".$main_image);
					$species_caption = $this->input->post("factsheet_similar_species_image_caption_".$main_image);
					if(!empty($product_img)){
					$gallery_add_data1 = array(
					'factsheet_master_id' => $id,
					'factsheet_similar_species_image' => $product_img,
					'factsheet_similar_species_image_title' => $species_title,
					'factsheet_similar_species_image_caption' => $species_caption
				);

				$this->db->insert($this->db->dbprefix('factsheet_similar_species_image'), $gallery_add_data1);
			}
		}
		$count_img = $this->input->post('count_img',true);
		$main_image = $this->input->post('main_image',true);
		$gallerey= '';
		$gallery_arr_str ='';
		if(!empty($count_img)){
		$gallery_arr = array();
		if($count_img >1){
		for($i =1;$i<$count_img;$i++){
		if($i != $main_image){

		$product_img = $this->input->post("factsheet_similar_species_image_".$i);
		$species_title = $this->input->post("factsheet_similar_species_image_title_".$i);
		$species_caption = $this->input->post("factsheet_similar_species_image_caption_".$i);
		if(!empty($product_img)){
		$gallery_add_data1 = array(
		'factsheet_master_id' => $id,
		'factsheet_similar_species_image' => $product_img,
		'factsheet_similar_species_image_title' => $species_title,
		'factsheet_similar_species_image_caption' => $species_caption
	);

	$this->db->insert($this->db->dbprefix('factsheet_similar_species_image'), $gallery_add_data1);
}
}


}

}
}*/
$this->db->set_dbprefix('is_');
////////// Insert - Factsheet Species Ends   //////////

$session_data = array("SUCC_MSG"  => "factsheet Updated Successfully.");
$this->session->set_userdata($session_data);
}
else // IF UPDATE PROCEDURE NOT EXECUTE SUCCESSFULLY
{
	$session_data = array("ERROR_MSG"  => "factsheet Not Updated.");
	$this->session->set_userdata($session_data);
}
}
else
{
	$id = $this->modelfactsheet->addDetails();
	if($id) // IF UPDATE PROCEDURE EXECUTE SUCCESSFULLY
	{

		////////// Insert - Factsheet gallery Starts   //////////
		$language = $this->input->post('language',TRUE);

		$factsheet_image ="";
		$main_image_gal = $this->input->post('main_image_gal',true);
		if(!empty($main_image_gal)){
			$factsheet_image = $this->input->post("factsheet_image_".$main_image_gal);
			$factsheet_caption = $this->input->post("factsheet_caption_".$main_image_gal);
			$factsheet_image_title = $this->input->post("factsheet_image_title_".$main_image_gal);
			if(!empty($factsheet_image)){
				$gallery_add_data1 = array(
					'factsheet_master_id' => $id,
					'factsheet_image' => $factsheet_image,
					'factsheet_image_title' => $factsheet_image_title,
					'factsheet_image_caption' => $factsheet_caption
				);

				$this->db->insert($this->db->dbprefix('factsheet_image_gallery'), $gallery_add_data1);
				$this->db->insert($this->db->dbprefix('french_factsheet_image_gallery'), $gallery_add_data1);
			}
		}
		$count_img_gal = $this->input->post('count_img_gal',true);
		$main_image_gal = $this->input->post('main_image_gal',true);

		if(!empty($count_img_gal)){

			if($count_img_gal >1){
				for($i =1;$i<$count_img_gal;$i++){
					if($i != $main_image_gal){

						$factsheet_image = $this->input->post("factsheet_image_".$i);
						$factsheet_caption = $this->input->post("factsheet_caption_".$i);
						$factsheet_image_title = $this->input->post("factsheet_image_title_".$i);
						if(!empty($factsheet_image)){
							$gallery_add_data1 = array(
								'factsheet_master_id' => $id,
								'factsheet_image' => $factsheet_image,
								'factsheet_image_title' => $factsheet_image_title,
								'factsheet_image_caption' => $factsheet_caption
							);

							$this->db->insert($this->db->dbprefix('factsheet_image_gallery'), $gallery_add_data1);
							$this->db->insert($this->db->dbprefix('french_factsheet_image_gallery'), $gallery_add_data1);
						}
					}


				}

			}
		}




		/*$product_img ="";
		$main_image = $this->input->post('main_image',true);
		if(!empty($main_image)){
		$product_img = $this->input->post("factsheet_similar_species_image_".$main_image);
		$species_title = $this->input->post("factsheet_similar_species_image_title_".$main_image);
		$species_caption = $this->input->post("factsheet_similar_species_image_caption_".$main_image);
		if(!empty($product_img)){
		$gallery_add_data1 = array(
		'factsheet_master_id' => $id,
		'factsheet_similar_species_image' => $product_img,
		'factsheet_similar_species_image_title' => $species_title,
		'factsheet_similar_species_image_caption' => $species_caption
	);

	$this->db->insert($this->db->dbprefix('factsheet_similar_species_image'), $gallery_add_data1);
}
}
$count_img = $this->input->post('count_img',true);
$main_image = $this->input->post('main_image',true);
$gallerey= '';
$gallery_arr_str ='';
if(!empty($count_img)){
$gallery_arr = array();
if($count_img >1){
for($i =1;$i<$count_img;$i++){
if($i != $main_image){

$product_img = $this->input->post("factsheet_similar_species_image_".$i);
$species_title = $this->input->post("factsheet_similar_species_image_title_".$i);
$species_caption = $this->input->post("factsheet_similar_species_image_caption_".$i);
if(!empty($product_img)){
$gallery_add_data1 = array(
'factsheet_master_id' => $id,
'factsheet_similar_species_image' => $product_img,
'factsheet_similar_species_image_title' => $species_title,
'factsheet_similar_species_image_caption' => $species_caption
);

$this->db->insert($this->db->dbprefix('factsheet_similar_species_image'), $gallery_add_data1);
}
}


}

}
}*/

////////// Insert - Factsheet Species Ends   //////////


$session_data = array("SUCC_MSG"  => "factsheet Inserted Successfully.");
$this->session->set_userdata($session_data);
}
else // IF UPDATE PROCEDURE NOT EXECUTE SUCCESSFULLY
{
	$session_data = array("ERROR_MSG"  => "factsheet Not Inserted.");
	$this->session->set_userdata($session_data);
}

}
$from=$this->input->post('from',TRUE);
$pgs = $this->input->post('pagenum');
$language = $this->input->post('language',TRUE);
if($from!= 'edit'){
	redirect("kaizen/factsheet/".$from,'refresh');
}else{

	if(empty($language)){
		redirect("kaizen/factsheet/doedit/".$id."?page=".$pgs,'refresh');
	}else{
		redirect("kaizen/factsheet/doedit/".$id."?language=".$language."&page=".$pgs,'refresh');
	}
	redirect("kaizen/factsheet/doedit/".$id,'refresh');
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
	$language = $this->input->get('language',TRUE);
	$data['pgs']= $this->input->get('page');
	$factsheet_id=$this->uri->segment(4);
	$q = $this->modelfactsheet->editDetail($factsheet_id,$language);
	$data['language'] = $language;
	if($q){
		$data['details'] = $q;
	}
	else{
		$data['details']->is_active = 1;
		$data['details']->id = 0;
	}
	if(!empty($language)){
		$data_row = $this->modelfactsheet->getAllDetails("french_factsheet");
	}else{
		$data_row = $this->modelfactsheet->getAllDetails("factsheet");
	}


	$data['pgs']= $this->input->get('page');

	$data['records']= $data_row;
	$data_row1 = $this->modelfactsheet->getRecords_gallery($factsheet_id);
	$data['details_gallery']= $data_row1;

	$data_row2 = $this->modelfactsheet->getRecords_species($factsheet_id);
	$data['details_species']= $data_row2;

	$this->load->view('kaizen/edit_factsheet',$data);

}
public function dodelete(){
	$del_id=$this->input->get('deleteid');
	$ref=rawurldecode($this->input->get('ref'));
	$tablename="factsheet";
	$idname='id';


	$delrec=$this->modelfactsheet->delSingleRecord($del_id,$tablename,$idname);
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


	if((int)$status_id > 0 && $this->modelfactsheet->getSingleRecord($status_id,$language))
	{
		if($this->modelfactsheet->changeStatus($status_id))
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
	//redirect("kaizen/factsheet",'refresh');
	header('location:'.$_SERVER['HTTP_REFERER']);
}
public function add_species(){
	$data = array();
	$count = $this->input->post("count");
	$file = $this->input->post("file");
	$species_title = $this->input->post("species_title");
	$caption = $this->input->post("caption");

	$data['count'] = $count;
	$data['species_img'] = $file;
	$data['species_caption'] = $caption;
	$data['species_title'] = $species_title;


	$this->load->view('kaizen/image_gallery_div',$data);

}
public function add_gallery(){
	$data = array();
	$count = $this->input->post("count_gal");
	$file = $this->input->post("file");
	$caption = $this->input->post("caption");
	$title = $this->input->post("title");

	$data['count_gal'] = $count;
	$data['factsheet_image'] = $file;
	$data['factsheet_caption'] = $caption;
	$data['factsheet_image_title'] = $title;

	$this->load->view('kaizen/image_gallery_div_factsheet',$data);

}
public function newcrop(){
	$image_id = $this->input->get("image_id");
	$folder_name = $this->input->get("folder_name");
	$img_sceen = $this->input->get("img_sceen");
	$prev_img = $this->input->get("prev_img");
	$image_val = $this->input->get("image_val");

	$height = $this->input->get("height");
	$width = $this->input->get("width");
	$controller = $this->input->get("controller");

	$data['image_id'] = $image_id;
	$data['image_val'] = $image_val;
	$data['folder_name'] = $folder_name;
	$data['img_sceen'] = $img_sceen;
	$data['prev_img'] = $prev_img;

	$data['height'] = $height;
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
public function statusChange(){
	$fetch_class = $this->uri->segment(2, 0);
	$data_id = $this->uri->segment(4, 0);
	$table_name = $this->uri->segment(5, 0);
	if(!empty($data_id) && !empty($table_name)){
		$where = array(
			'id' => $data_id
		);
		$data_details = $this->modelfactsheet->select_row($table_name,$where);
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
			if($this->modelfactsheet->update_row($table_name,$update_data,$update_where)){
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

public function selectimagefactsheet(){
	$factid = $this->input->post("factid");
	$language = $this->input->post("language");
	if(!empty($language)){
		$factsheet_table = 'french_factsheet';
		$gallery_table = 'french_gallery';
	}else{
		$factsheet_table = 'factsheet';
		$gallery_table = 'gallery';
	}
	$prg_is_array=array();

	$page_id_B = $this->modelfactsheet->getPageidcommon_banner($factid,$factsheet_table);
	$selected_page_id = array();
	if(!empty($page_id_B)){
		foreach($page_id_B as $pval){
			$page_id_Arr=explode(',',$pval->gallery_id);
			foreach($page_id_Arr as $P_id){
				$selected_page_id[]=$P_id;
			}
		}
	}

	$where = array(
		'id' => $factid
	);
	$factsheet_detls = $this->modelfactsheet->select_row($factsheet_table,$where);
	$allgallery_list = $this->modelfactsheet->getDistinctGalleryDetails($gallery_table);
	$data['galleryList'] = $this->prfileprogramselectbox($allgallery_list,$selected_page_id,'1',$prg_is_array);
	//echo $this->db->last_query();

	//$iddsss = explode(',',$factsheet_detls[0]->gallery_id);
	$hdngalleryid = $this->input->post("hdngalleryid");
	$iddsss = explode(',',$hdngalleryid);
	$selected_pages_id = $iddsss;
	if(!empty($hdngalleryid)) {
		$pages_list = $this->modelfactsheet->getSingleRecordPageName($selected_pages_id,$gallery_table);
	}

	$data['selectedpages'] = $this->prfileprogramselectbox($pages_list,'','1',$prg_is_array);
	$this->load->view('kaizen/factsheet_selectimages',$data);


}


public function selectimagefactsheet_similar(){
	$factid = $this->input->post("factid");
	$language = $this->input->post("language");
	if(!empty($language)){
		$factsheet_table = 'french_factsheet';
		$gallery_table = 'french_gallery';
	}else{
		$factsheet_table = 'factsheet';
		$gallery_table = 'gallery';
	}
	$prg_is_array=array();

	$page_id_B = $this->modelfactsheet->getPageidcommon_banner($factid,$factsheet_table);
	$selected_page_id = array();
	if(!empty($page_id_B)){
		foreach($page_id_B as $pval){
			$page_id_Arr=explode(',',$pval->similar_species_id);
			foreach($page_id_Arr as $P_id){
				$selected_page_id[]=$P_id;
			}
		}
	}

	$where = array(
		'id' => $factid
	);
	$factsheet_detls = $this->modelfactsheet->select_row($factsheet_table,$where);
	$allgallery_list = $this->modelfactsheet->getDistinctGalleryDetails($gallery_table);
	$data['galleryList'] = $this->prfileprogramselectbox($allgallery_list,$selected_page_id,'1',$prg_is_array);
	//echo $this->db->last_query();

	//$iddsss = explode(',',$factsheet_detls[0]->gallery_id);
	$hdngalleryid = $this->input->post("hdngalleryid");
	$iddsss = explode(',',$hdngalleryid);
	$selected_pages_id = $iddsss;
	if(!empty($hdngalleryid)) {
		$pages_list = $this->modelfactsheet->getSingleRecordPageName($selected_pages_id,$gallery_table);
	}

	$data['selectedpages'] = $this->prfileprogramselectbox($pages_list,'','1',$prg_is_array);
	$this->load->view('kaizen/factsheet_selectimages',$data);


}




public function test2(){
	$str = '';
	$hdngalleryid = $this->input->get("hdngalleryid");
	$language = $this->input->get("language");
	if(!empty($language)){

		$gallery_table = 'french_gallery';
	}else{

		$gallery_table = 'gallery';
	}
	//$factsheet_id = $this->input->get("factsheet_id");
	$iddsss = explode(',',$hdngalleryid);
	$selected_pages_id = $iddsss;
	if(!empty($hdngalleryid)) {
		$pages_list = $this->modelfactsheet->getSingleRecordPageName($selected_pages_id,$gallery_table);
	}

	foreach($pages_list as $row_pages_list){
		$str .= '<li><img class="image_picker_image" src="'.base_url('public/uploads/gallery_photo/'.$row_pages_list->gallery_photo).'"><p>'.$row_pages_list->title.'</p></li>';
	}
	echo $str;

}

public function test2_similar(){
	$str = '';
	$hdngalleryid = $this->input->get("hdngalleryid");
	$language = $this->input->get("language");
	if(!empty($language)){

		$gallery_table = 'french_gallery';
	}else{

		$gallery_table = 'gallery';
	}
	//$factsheet_id = $this->input->get("factsheet_id");
	$iddsss = explode(',',$hdngalleryid);
	$selected_pages_id = $iddsss;
	if(!empty($hdngalleryid)) {
		$pages_list = $this->modelfactsheet->getSingleRecordPageName($selected_pages_id,$gallery_table);
	}

	foreach($pages_list as $row_pages_list){
		$str .= '<li><img class="image_picker_image" src="'.base_url('public/uploads/gallery_photo/'.$row_pages_list->gallery_photo).'"><p>'.$row_pages_list->title.'</p></li>';
	}
	echo $str;

}

public function upload_files($path, $files)
{
	$config = array(
		'upload_path'   => file_upload_absolute_path().$path,
		'allowed_types' => 'jpg|jpeg|gif|png',
	);

	$this->load->library('upload', $config);

	$images = array();


	foreach ($files['name'] as $key => $image) {
		if(!empty($files['name'][$key])){
			$_FILES['factsheet_image[]']['name']= $files['name'][$key];
			$_FILES['factsheet_image[]']['type']= $files['type'][$key];
			$_FILES['factsheet_image[]']['tmp_name']= $files['tmp_name'][$key];
			$_FILES['factsheet_image[]']['error']= $files['error'][$key];
			$_FILES['factsheet_image[]']['size']= $files['size'][$key];

			$fileName = $image;

			// $images[] = $fileName;
			$config['file_name'] = $fileName;

			$this->upload->initialize($config);

			if ($this->upload->do_upload('factsheet_image[]')) {
				$fInfo = $this->upload->data();
				$data['uploadInfo'] = $fInfo;

				$images[] = $fInfo['file_name'];

			} else {
				//print_r($this->upload->display_errors());
				return false;
			}
		}
	}

	return $images;
}

function prfileprogramselectbox($rs,$selected,$depth=0,$prg_is_array=array())
{

	$tab='';
	$str = "";

	if(!empty($rs))
	{
		foreach($rs as $category)
		{

			$count_subcategory 	= array();

			if(!in_array($category->id,$prg_is_array)){
				$img = $category->gallery_photo;
				$str .= "<option data-img-src=\"".site_url("public/uploads/gallery_photo/".$category->gallery_photo)."\"  value=\"".$category->id."\" ";


				if(is_array($selected))
				{
					foreach($selected as $val)
					{
						if($val == $category->id)
						$str .= " disabled='disabled'";
					}
				}
				else
				{
					if($selected == $category->id)
					$str .= " selected ";
				}


				$title_opt=$tab.$category->title.' ('.$category->excerpt.')';



				$str .= ">".$title_opt."</option>\n";

			}

		}

	}
	return $str;

}
//=============== END IMAGE MANUPULATION==============//
}
