<?php
class Model_banner extends CI_Model{
	var $page_link = "";
	var $site_id='';
	public function __construct(){
		parent::__construct();	
		if($this->session->userdata('language_version') == "french"){
					$this->db->set_dbprefix('is_french_');
				}
		$this->site_id=$this->config->item("SITE_ID");
		$this->page_link = xss_clean($this->uri->segment(1));
		$page_arr = array('news');
		if(empty($this->page_link)){
			$this->page_link = "home";
		}
		elseif(in_array($this->page_link,$page_arr)){
			$this->page_link = xss_clean($this->uri->segment(1));
		}
		elseif($this->page_link=="pages"){
			$this->page_link = xss_clean($this->uri->segment(2));
		}
		elseif($this->page_link=="draft" || $this->page_link=="draft_home"){
			$this->page_link = "home";
		}
		elseif($this->page_link=="category" || $this->page_link=="product"){
			$this->page_link = "products";
		}
	}

	public function cmspages_list(){
		if($query = $this->db->query("(SELECT `id`,`title`,`parent_id`,`page_link` FROM `".$this->db->dbprefix('cms_pages')."` WHERE `is_active`=1  and `site_id`='".$this->site_id."' order by `display_order`>0 desc, `display_order` asc)"))
		{
			#echo $this->db->last_query();exit;
			return $query->result();	
		}
		else
		{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}
	}

	
	public function getTree($rootid)
	{
		$rootid2=$this->parent_id_zero($rootid);
		
		$cmsmenu = $this->cmspages_list();
		$menus_array = array();
		foreach ($cmsmenu as $rs_menu_id){
		  $menus_array[$rs_menu_id->id] = array('id' => $rs_menu_id->id,'title' => $rs_menu_id->title,'parent_id' => $rs_menu_id->parent_id,'page_link' => $rs_menu_id->page_link);	
		}
		$TOP_NAV_MENU = '';
		$cms_menu2 = $this->generate_menu_tree($rootid2,$menus_array, $TOP_NAV_MENU, 0);
		
		return $cms_menu2;
	
	}

	
	public function generate_menu_tree($parent,$menus_array, &$TOP_NAV_MENU, $level_depth=0)
	{
		$has_childs = false;
		$level_depth++;
		
		foreach($menus_array as $key => $value){
			if ($value['parent_id'] == $parent){       
				if ($has_childs === false){
					$has_childs = true;
					if($level_depth==1){$TOP_NAV_MENU .= "<ul>\n";}
					else{$TOP_NAV_MENU .= "<ul>\n";}
				}
				if($this->page_link==$value['page_link']){$cl="class='active'";$cl2=" active";}else{$cl="";$cl2="";}
				
				if($value['page_link']=="blog"){
					$TOP_NAV_MENU .= '<li><a href="'.site_url("blog").'" '.$cl.'>' . $value['title'] . '</a>';
				}
				elseif($value['page_link']=="where_does_it_go"){
					$TOP_NAV_MENU .= '<li><a href="'.site_url("where_does_it_go").'" '.$cl.'>' . $value['title'] . '</a>';
				}
				elseif($value['page_link']=="locations"){
					$TOP_NAV_MENU .= '<li><a href="'.site_url("locations").'" '.$cl.' > ' . $value['title'] . '</a>';
				}
				elseif($value['page_link']=="home2"){
					$TOP_NAV_MENU .= '<li><a href="'.base_url().'" '.$cl.'>' . $value['title'] . '</a>';
				}
				else{
					$TOP_NAV_MENU .= '<li><a href="'.base_url('pages/'.$value['page_link']).'" '.$cl.'>' . $value['title'] . '</a>';					
				}
				if($level_depth<2){$this->generate_menu_tree($key,$menus_array,$TOP_NAV_MENU,$level_depth);}
				//call function again to generate nested list for subcategories belonging to this category
				$TOP_NAV_MENU .= "</li>\n";
			}
		}
		if ($has_childs === true){$TOP_NAV_MENU .= "</ul>\n";}
	
		return $TOP_NAV_MENU;
	}
	 
	public function parent_id_zero($rootid)
	{
			
			$query = $this->db->query("SELECT `parent_id`,`id` FROM `".$this->db->dbprefix('cms_pages')."` WHERE `id`='".$rootid."' and `site_id`='".$this->site_id."'  LIMIT 0,1");
			#echo $this->db->last_query();
			if($query->num_rows()>0){
				$val=$query->row();	
				if($val->parent_id>0)
				{
					 $id=$this->parent_id_zero($val->parent_id);
				}
				else
				{
					$id=$val->id;
				}
			}
			else{		
				$id=$rootid;
			}
			return $id;
	}

}
?>