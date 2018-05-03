<?php 
function pre($data){
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}
function resizingImage($fileName='',$upload_rootdir='',$img_width='',$img_height='',$img_prefix = ''){
	
        $CI =& get_instance();
        if(!is_dir(file_upload_absolute_path().$upload_rootdir)){
                $oldumask = umask(0); 
                mkdir(file_upload_absolute_path().$upload_rootdir, 0777); // or even 01777 so you get the sticky bit set 
                umask($oldumask);
        }
		
        $config['image_library'] = 'gd2';		
     	$config['source_image'] = file_upload_absolute_path().$upload_rootdir.$fileName; 
        $config['new_image']	= file_upload_absolute_path().$upload_rootdir.$img_prefix.$fileName;
        
        $config['maintain_ratio'] = FALSE;
        $config['width'] = $img_width;
        $config['height'] = $img_height;
	$CI->load->library('image_lib', $config);
       	$CI->image_lib->initialize($config); 
      	if(!$CI->image_lib->resize()){
            echo $CI->image_lib->display_errors();			
        }
        else{
                return false;
        }       

}
function socialLinks(){
        $CI =& get_instance();
        $CI->load->model("model_home");
        $where = array(
            'site_id' => 1
        );
        $order_by = array(
            'sequence' => 'asc'
        );
        $social_settings = $CI->model_home->select_row("social_settings",$where,$order_by);
        $default = array(
            1   => 'fb',
            2   => 'twit',
            3   => 'in',
            6   => 'inst',
            5   => 'utube',
            8   => 'pint',
			4   => 'google'        
        );
        $html = '';
        if(!empty($social_settings)){
            foreach($social_settings as $sos){
                $class = '';
                if($default[$sos->social_menus_id]){
                    $class = $default[$sos->social_menus_id];
                }
				$html .= '<li >
                    	<a href="'.$sos->link.'" class="'.$class.'" target="_blank"></a>
                    </li>';
            }
        }
        echo $html;
        
}
function getOptionValueByGroupId($id,$table){
    $CI =& get_instance();
    $query = $CI->db->query("SELECT * from `".$table."` WHERE `ref_id`='".$id."'");
         if($query){
					return $query->result();
         }else{
					log_message('error',": ".$this->db->_error_message());
					return false;
		}
}
?>