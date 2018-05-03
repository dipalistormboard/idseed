<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Menu_class{
 	var $page_link = "";
	public function __construct(){		
		$CI =& get_instance();
		$this->page_link = $CI->uri->segment(1);
		if(empty($this->page_link))
		{
			$this->page_link="home";
		}
		elseif($this->page_link=="pages"){
			$this->page_link = $CI->uri->segment(2);
		}
		elseif($this->page_link=="draft" || $this->page_link=="draft_home"){
			$this->page_link = "home";
		}
                
                if($CI->session->userdata('language_version') == ''){
                    $newdata = array(
                        'language_version'  => 'english'
                    );

                    $CI->session->set_userdata($newdata);
                }
	}
        
	public function get_menu(){
		$CI =& get_instance();
		$CI->load->model('model_meta');
		$tot_banner = $CI->model_meta->count_cmspages();
		if($tot_banner){
			$cmspages_list = $CI->model_meta->get_list();
			$data=array();
			$TOP_NAV_MENU = '';
			$cms_menu = $this->generate_menu(0,$cmspages_list, $TOP_NAV_MENU, 0);		
			$CI->data['hooks_cmspages_list'] = $cms_menu;			
			$TOP_NAV_MENU = '';
			$cms_menuf = $this->generate_menuf(0,$cmspages_list, $TOP_NAV_MENU, 0);		
			$CI->data['hooks_footerpages_list'] = $cms_menuf;			
		}	
	}
	
	public function generate_menu($parent,$menus_array, &$TOP_NAV_MENU, $level_depth=0){
		$has_childs = false;
		$level_depth++;
		
		foreach($menus_array as $key => $value){
	    	if ($value['parent_id'] == $parent){       
    	    	if ($has_childs === false){
                	$has_childs = true;
					if($level_depth==1){$TOP_NAV_MENU .= "<ul class='nav'>\n";}					
					else{$TOP_NAV_MENU .= "<ul class=\"drop\">\n";}
            	}
				if($this->page_link==$value['page_link']){$cl="class='active'";}else{$cl="";}
				
				$liclass = "class='".$value['class']."'";
				
				if($value['page_link']=="home"){
					$TOP_NAV_MENU .= '<li '.$liclass.' ><a href="'.base_url().'" '.$cl.'>' . $value['title'] . '</a></li>';
				}else if($value['page_link']=="gallery"){
					$TOP_NAV_MENU .= '<li '.$liclass.' ><a href="'.site_url('gallery').'" '.$cl.'>' . $value['title'] . '</a></li>';
				}
				else if($value['page_link']=="factsheet"){
					$TOP_NAV_MENU .= '<li '.$liclass.' ><a href="'.site_url('factsheet/index').'" '.$cl.'>' . $value['title'] . '</a></li>';
				}
                                else if($value['page_link']=="keys"){
					$TOP_NAV_MENU .= '<li '.$liclass.' ><a href="'.site_url('keys').'" '.$cl.'>' . $value['title'] . '</a></li>';
				}
				/*else if($value['page_link']=="glossary"){
					$TOP_NAV_MENU .= '<li '.$liclass.' ><a href="'.site_url('fact/glossary').'" '.$cl.'>' . $value['title'] . '</a></li>';
				}	*/			
				else 
				{
										
						$TOP_NAV_MENU .= '<li '.$liclass.' ><a href="'.site_url('pages/'.$value['page_link']).'" '.$cl.'>' . $value['title'] . '</a>';
					
					if($level_depth<3){$this->generate_menu($key,$menus_array,$TOP_NAV_MENU,$level_depth);}
					$TOP_NAV_MENU .= "</li>\n";
				}
			}
    	}
    	if ($has_childs === true){$TOP_NAV_MENU .= "</ul>\n";}
	
		return $TOP_NAV_MENU;
	}
	
	public function generate_menuf($parent,$menus_array, &$TOP_NAV_MENU, $level_depth=0){
		$has_childs = false;
		$level_depth++;
		
		foreach($menus_array as $key => $value){
	    	if ($value['parent_id'] == $parent){       
    	    	if ($has_childs === false){
                	$has_childs = true;
					if($level_depth==1){$TOP_NAV_MENU .= "<ul>\n";}					
					else{$TOP_NAV_MENU .= "<ul>\n";}
            	}
				if($this->page_link==$value['page_link']){$cl="class='active'";}else{$cl="";}
					
				if($value['page_link']=="home"){
					$TOP_NAV_MENU .= '<li><a href="'.base_url().'" '.$cl.'>' . $value['title'] . '</a></li>';
				}else if($value['page_link']=="gallery"){
					$TOP_NAV_MENU .= '<li><a href="'.site_url('gallery').'" '.$cl.'>' . $value['title'] . '</a></li>';
				}	
				else if($value['page_link']=="factsheet"){
					$TOP_NAV_MENU .= '<li '.$liclass.' ><a href="'.site_url('factsheet/index').'" '.$cl.'>' . $value['title'] . '</a></li>';
				}
                                else if($value['page_link']=="keys"){
					$TOP_NAV_MENU .= '<li '.$liclass.' ><a href="'.site_url('keys').'" '.$cl.'>' . $value['title'] . '</a></li>';
				}
				/*else if($value['page_link']=="glossary"){
					$TOP_NAV_MENU .= '<li '.$liclass.' ><a href="'.site_url('fact/glossary').'" '.$cl.'>' . $value['title'] . '</a></li>';
				}*/			
				else{					
					$TOP_NAV_MENU .= '<li><a href="'.site_url('pages/'.$value['page_link']).'" '.$cl.'>' . $value['title'] . '</a>';					
					if($level_depth<1){$this->generate_menuf($key,$menus_array,$TOP_NAV_MENU,$level_depth);}
            		$TOP_NAV_MENU .= "</li>\n";					
				}		
							
			}
    	}
    	if ($has_childs === true){$TOP_NAV_MENU .= "</ul>\n";}
	
		return $TOP_NAV_MENU;
	}
	
	public function generate_menu_mob($parent,$menus_array, &$TOP_NAV_MENU, $level_depth=0){
		$has_childs = false;
		$level_depth++;
		foreach($menus_array as $key => $value){
	    	if ($value['parent_id'] == $parent){       
    	    	
				if($value['page_link']=="home"){
					$TOP_NAV_MENU .= '<option value="'.base_url().'">' . $value['title'] . '</option>';
				}
				elseif($value['page_link']=="services"){
					$TOP_NAV_MENU .= '<option value="'.site_url('services').'">&nbsp;&nbsp;&nbsp;&nbsp;' . $value['title'] . '</option>';
				}
				
				elseif($value['page_link']=="member_area"){
					$TOP_NAV_MENU .= '<option value="'.site_url('member_area').'">&nbsp;&nbsp;&nbsp;&nbsp;' . $value['title'] . '</option>';
				}
				
				elseif($value['page_link']=="benefits"){
					$TOP_NAV_MENU .= '<option value="'.site_url('benefits').'">&nbsp;&nbsp;&nbsp;&nbsp;' . $value['title'] . '</option>';
				}
				
				elseif($value['page_link']=="events"){
					$TOP_NAV_MENU .= '<option value="'.site_url('events').'">&nbsp;&nbsp;&nbsp;&nbsp;' . $value['title'] . '</option>';
				}
				elseif($value['page_link']=="careers"){
					$TOP_NAV_MENU .= '<option value="'.site_url('careers').'">&nbsp;&nbsp;&nbsp;&nbsp;' . $value['title'] . '</option>';
				}
				else{			
					if($level_depth>1)		
					{
						$TOP_NAV_MENU .= '<option value="'.site_url('pages/'.$value['page_link']).'">&nbsp;&nbsp;&nbsp;' . $value['title'] . '</option>';	
					}
					else
					{
						$TOP_NAV_MENU .= '<option value="'.site_url('pages/'.$value['page_link']).'">' . $value['title'] . '</option>';	
					}
				}		
				$this->generate_menu_mob($key,$menus_array,$TOP_NAV_MENU,$level_depth);
			}
    	}
    	if ($has_childs === true){$TOP_NAV_MENU .= "</ul>\n";}
		return $TOP_NAV_MENU;
	}
}