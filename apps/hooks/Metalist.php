<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 class Metalist
 {
 	
 	public function get_meta()
 	{	
		$CI =& get_instance();
		$CI->load->model('model_meta');
		$tot_meta = $CI->model_meta->count_meta();
		
		$footer_logo = $CI->model_meta->footer_logo();		
		$CI->data['footer_logo']=$footer_logo;
        
		if($tot_meta)
		{			
			$meta_list = $CI->model_meta->meta_list();
			$data=array();
			$CI->data['hooks_meta'] = $meta_list;	
			$site_setting = $CI->model_meta->site_settings();
			$common_banner = $CI->model_meta->getCommonBanner($CI->data['hooks_meta']->id);
            $CI->data['common_banner'] = $common_banner;
			$CI->data['hooks_meta']=$meta_list;
			$CI->data['site_settings']=$site_setting;
			
		}
		else
		{
			$site_setting = $CI->model_meta->site_settings();
			//$data=array();
			$CI->data['hooks_meta'] = $site_setting;
			$CI->data['site_settings']=$site_setting;
			$common_banner = $CI->model_meta->getCommonBanner($CI->data['hooks_meta']->id);
            $CI->data['common_banner'] = $common_banner;
			$meta_list = $CI->model_meta->site_settings();
			$data=array();
				
			if(strstr(uri_string(),'member_area')){
				$CI->data['hooks_meta'] = array();
			}
			else
			{
				$CI->data['hooks_meta'] = $meta_list;
			}
			$CI->data['site_setting']=$meta_list;
		}
        
       
	}
	
	
 }