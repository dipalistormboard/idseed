<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_login extends CI_Model {

	public function __construct(){
		parent::__construct();
		//$this->db->set_dbprefix('is_french_');
	}

	public function login($username, $password){
		$query = $this->db->query("SELECT * FROM `".$this->db->dbprefix('admin')."` 
									WHERE `user_name` = ".$this->db->escape($username)." 
									AND `pwd` = '".SHA1($password)."' 
									AND `approved` = '1'");
	
		if ($query->num_rows()) {return $query->row();}
		else{ return false;}
	}
	
	public function update($admin_id="",$username=""){
		$this->load->library('user_agent');
		$thirty_days_ago = date("Y-m-d H:i:s", mktime(0,0,0,date("m"), (date("j")-30), date("Y")));
			
		$log_del_sql = "DELETE FROM `".$this->db->dbprefix('admin_log')."` WHERE `dt`<'".$thirty_days_ago."'";
		$this->db->query($log_del_sql);
			
		$query = $this->db->query("INSERT INTO ".$this->db->dbprefix('admin_log')." 
									SET `admin_id`	= '".$admin_id."',
									`username`		= ".$this->db->escape($username).",
									`ip`			= ".$this->db->escape($this->input->ip_address()).",
									`user_agent`	= ".$this->db->escape($this->agent->agent_string()).",
									`ref`			= ".$this->db->escape($this->agent->referrer()).",
									`login_status`	= 1,
									`dt`			= NOW()");
									
		return true;
	}
	
}