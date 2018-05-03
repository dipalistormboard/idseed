<?php
class Model_meta extends CI_Model{
	var $page_link = "";
	var $site_id='';
	var $membership_id;
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('language_version') == "french"){
					$this->db->set_dbprefix('is_french_');
				}
		$this->site_id=$this->config->item("SITE_ID");
		$this->membership_id=$this->session->userdata('membership_id');		
		if(strstr(uri_string(),'member_area')){
			$this->page_link = xss_clean($this->uri->segment(2));
			if(empty($this->page_link)){
				$this->cond=" and page_link !='' and `parent_id`='0'";
				
			}
			elseif($this->page_link=="pages"){
				$this->page_link = xss_clean($this->uri->segment(3));
				if($this->page_link=='changepassword')
				{
					$this->cond=" and page_link !='' and `parent_id`='0'";
				}
				else
				{	$this->cond=" and page_link = '".$this->page_link."'"; }
			}
			else
			{
				$this->page_link = xss_clean($this->uri->segment(2));
				if($this->page_link=='changepassword')
				{
					$this->cond=" and page_link !='' and `parent_id`='0'";
				}
				else
				{	$this->cond=" and page_link = '".$this->page_link."'"; }
			}
		}else
		{	
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
	}
	
	public function count_meta(){
			if(strstr(uri_string(),'member_area')){
		$page_ids=$this->pagesIdByMembership();
		$query = $this->db->query("SELECT `id` FROM `".$this->db->dbprefix('member_pages')."` WHERE is_active= 1 ".$this->cond." and `id` IN (".$page_ids.") order by `display_order`>0 desc,`display_order` asc LIMIT 0,1");
		#echo $this->db->last_query();
		if($query->num_rows()>0){
			return true;
		}
		else{		
			$query = $this->db->query("SELECT `id` FROM `".$this->db->dbprefix('member_inner_pages')."` WHERE is_active= 1 ".$this->cond."  order by `display_order`>0 desc,`display_order` asc LIMIT 0,1");
					#echo $this->db->last_query();
					if($query->num_rows()>0){
						return true;
					}
					else{		
						log_message('error',": ".$this->db->_error_message() );
						return false;
					}
		}
		}
		else{
		$query = $this->db->query("SELECT `id` FROM `".$this->db->dbprefix('cms_pages')."` WHERE page_link='".$this->page_link."' and `site_id`='".$this->site_id."' LIMIT 0,1");
		if($query->num_rows()>0){
			return true;
		}
		else{
			$query = $this->db->query("SELECT `id` FROM `".$this->db->dbprefix('other_cms_pages')."` WHERE page_link='".$this->page_link."' and `site_id`='".$this->site_id."' LIMIT 0,1");
			if($query->num_rows()>0){
				return true;
			}
			else{		
				return false;
			}
		}
		}
	}
	
	public function meta_list(){
	if(strstr(uri_string(),'member_area')){
		$page_ids=$this->pagesIdByMembership();
			$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('member_pages')."`WHERE is_active= 1 ".$this->cond." and `id` IN (".$page_ids.")  order by `display_order`>0 desc,`display_order` asc LIMIT 0,1");
			#echo $this->db->last_query();exit;
			$row_rs=$query->row();
			if(count($row_rs)>0){
				return $row_rs;	
			}
			else
			{
					if($query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('member_inner_pages')."`WHERE is_active= 1 ".$this->cond." and `site_id`='".$this->site_id."'  order by `display_order`>0 desc,`display_order` asc LIMIT 0,1"))
					{
						#echo $this->db->last_query();exit;
						return $query->row();	
					}
					else
					{
						log_message('error',": ".$this->db->_error_message() );
						return false;
					}
			}
		}
		else
		{
		$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('cms_pages')."`WHERE page_link='".$this->page_link."' and `site_id`='".$this->site_id."' LIMIT 0,1");
		if($query->num_rows()>0){
			return $query->row();	
		}
		else{
			$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('other_cms_pages')."` WHERE page_link='".$this->page_link."' and `site_id`='".$this->site_id."' LIMIT 0,1");
			if($query->num_rows()>0){
				
				return $query->row();
			}
			else{		
				return false;
			}
		}
		}
	}
    public function getCommonBanner($page_id){
        $query = $this->db->query("SELECT * FROM `is_common_banner` WHERE `page_id` like '%".$page_id."%' ");
		if($query){
			return $query->row();	
		}
		else{
			return false;
		}
    }

    public function site_settings(){
		$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('site_settings')."`WHERE `id`=1 ");
		if($query){
			return $query->row();	
		}
		else{
			return false;
		}
	}
	public function footer_logo(){
		$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('footer_logo')."`WHERE `is_active`=1 ");
		if($query){
			
			return $query->result();	
		}
		else{
			return false;
		}
	}
	
	public function count_cmspages(){
		$query = $this->db->query("SELECT `id` FROM `".$this->db->dbprefix('cms_pages')."` WHERE `parent_id`=0 and `site_id`='".$this->site_id."' LIMIT 0,10");
		#echo $this->db->last_query();exit;
		if($query->num_rows()>0){
			return true;
		}
		else{		
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}
	}
	
	public function cmspages_list($conds=""){		
		$query = $this->db->query("SELECT `id`,`title`,`parent_id`,`page_link` ,`class` FROM `".$this->db->dbprefix('cms_pages')."` WHERE `is_active`=1  and `site_id`='".$this->site_id."' ".$conds." order by `display_order`>0 desc, `display_order` asc");
		if($query){
			return $query->result();	
		}
		else{
			return false;
		}
	}
	
	public function get_list() {
    	$cmsmenu = $this->cmspages_list();
		$menus_array = array();
		foreach ($cmsmenu as $rs_menu_id){
		  $menus_array[$rs_menu_id->id] = array('id' => $rs_menu_id->id,'title' => $rs_menu_id->title,'parent_id' => $rs_menu_id->parent_id,'page_link' => $rs_menu_id->page_link,'class' => $rs_menu_id->class);	
		}		
		return $menus_array;
	}
	
	public function getTree($rootid){
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
	
	public function generate_menu_tree($parent,$menus_array, &$TOP_NAV_MENU, $level_depth=0){
		$has_childs = false;
		$level_depth++;
		
		foreach($menus_array as $key => $value){
	    	if ($value['parent_id'] == $parent){       
    	    	if ($has_childs === false){
                	$has_childs = true;
					$TOP_NAV_MENU .= "<ul>\n";
            	}
				
				$TOP_NAV_MENU .= '<li><a href="'.base_url('pages/'.$value['page_link']).'">' . $value['title'] . '</a>';
				if($level_depth<3){$this->generate_menu_tree($key,$menus_array,$TOP_NAV_MENU,$level_depth);}
				//call function again to generate nested list for subcategories belonging to this category
				$TOP_NAV_MENU .= "</li>\n";
				
				
			}
    	}
    	if ($has_childs === true){$TOP_NAV_MENU .= "</ul>\n";}
	
		return $TOP_NAV_MENU;
	}
	
	public function parent_id_zero($rootid){
  		
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

/**************************** ************************/

public function getParentMemberPagesList()
	{
		$page_ids=$this->pagesIdByMembership();
		
		if(empty($page_ids))
		{
			$page_ids='1';
		}
		$resultList	=	array();
		$query 		= 	$this->db->query("SELECT * FROM `".$this->db->dbprefix('member_pages')."`WHERE is_active = '1' and parent_id = '0' and `id` IN (".$page_ids.") order by `display_order`>0,`display_order` asc");
		if($query)
		{
			$resultList = $query->result();
		}
		else
		{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}
		return $resultList;
	}
	public function getSubMemberPagesList()
	{
		$parentList =   array();
		$page_ids=$this->pagesIdByMembership();
		if(empty($page_ids))
		{
			$page_ids='1';
		}
		$parentList =   $this->getParentMemberPagesList();
		$resultList	=	array();
		if(is_array($parentList) && count($parentList)>0)
		{
			for($i=0;$i<count($parentList);$i++)
			{
				$parent_id = $parentList[$i]->id;
				$query 		= 	$this->db->query("SELECT * FROM `".$this->db->dbprefix('member_pages')."`WHERE is_active = '1' and parent_id = '".$parent_id."' and `id` IN (".$page_ids.")  order by `display_order`>0,`display_order` asc");
				if($query)
				{
					$subList = array();
					$subList = $query->result();
					$resultList[$parent_id] = $subList;
				}
				else
				{
					log_message('error',": ".$this->db->_error_message() );
					return false;
				}				
			}
		}
		return $resultList;
	}
	
	public function pagesIdByMembership()
	{
		$query 		= 	$this->db->query("SELECT `page_id` FROM `".$this->db->dbprefix('member_page_cat')."`WHERE membership_type IN (".$this->membership_id.")");
		$page_ids='';
				if($query)
				{
					$subList = $query->result_array();
					if(isset($subList) && count($subList)>0 && !empty($subList))
					{
						foreach($subList as $kry)
							$page_ids.=$kry['page_id'].',';
					}
					return substr($page_ids,0,-1);
				}
				else
				{
					log_message('error',": ".$this->db->_error_message() );
					return false;
				}			
	}
	
	
		public function getSubPagesArr()
	{
		$finalResultArr	=	array();
		if($query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('cms_pages')."` 
		WHERE parent_id = '0' AND `is_active` = '1' and `site_id`='".$this->site_id."'"))
		{
			$parentArray	=	array();
			$parentArray	=	$query->result_array();
			if(is_array($parentArray) && count($parentArray))
			{
				for($i=0;$i<count($parentArray);$i++)
				{
					if($queryp = $this->db->query("SELECT * FROM `".$this->db->dbprefix('cms_pages')."` 
		WHERE parent_id = '".$parentArray[$i]['id']."' AND `is_active` = '1' and `site_id`='".$this->site_id."'"))
					{
						$subArray	=	array();
						$subArray	=	$queryp->result_array();
						if(is_array($subArray) && count($subArray))
						{
							for($k=0;$k<count($subArray);$k++)
							{
								if($querys = $this->db->query("SELECT * FROM `".$this->db->dbprefix('cms_pages')."` 
		WHERE parent_id = '".$subArray[$k]['id']."' AND `is_active` = '1' and `site_id`='".$this->site_id."'"))
								{
									$ssubArray	=	array();
									$ssubArray	=	$querys->result_array();
									$finalResultArr[$subArray[$k]['id']]	=	$ssubArray;
								}
							}
						}
					}
				}
			}
		}
		else
		{
			log_message('error',": ".$this->db->_error_message() );
			return false;
		}
		return $finalResultArr;
	}
	
}
?>