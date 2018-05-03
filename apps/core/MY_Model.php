<?php
/**
* Base Model - All models should extend this one.
* @author Raul Chedrese
**/
class MY_Model extends CI_Model {

  protected $_table_name = '';
  protected $_primary_key = 'id';
  protected $_primary_filter = 'intval';
  protected $_order_by = '';
  public $_rules = array();
  protected $_timestamps = FALSE;
  
  function __construct() {
    parent::__construct();
  }
  
  
  /**
   * Fetches a record of the database with a matching $id.
   * Will return a single record or list of records.
   **/
  public function get($id = NULL, $single = FALSE) {
    if ($id != NULL) {
      $filter = $this->_primary_filter;
      $id = $filter($id);
      $this->db->where($this->_primary_key, $id);
      $method = 'row';
    } elseif ($single == TRUE) {
      $method = 'row';
    } else {
      $method = 'result';
    }

    if (!count($this->db->ar_orderby)) {
      $this->db->order_by($this->_order_by);
    }

    return $this->db->get($this->_table_name)->$method();
  }

  /**
   * Gets records that match the requriments of $where.
   * If $single is set to TRUE only a single record will be returned.
   **/
  public function get_by($where, $single = FALSE) {
    $this->db->where($where);
    return $this->get(NULL, $single);
  }
  
  /**
   * Fetches the first X records from the database 
   * if $limit is not set it returns only the first record.
   **/
  public function get_first($limit = 1) {
    return $this->db->get($this->_table_name, $limit)->result();
  }
  
  /**
   * Inserts $data to the database.
   **/
  public function save($data, $id = NULL) {
    // Set timestamps
    if ($this->_timestamps == TRUE) {
      $now = date('Y-m-d H:i:s');
      $id || $data['created'] = $now;
      $data['modified'] = $now;
    }

    // Insert
    if ($id == NULL) {
      !isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
      $this->db->set($data);
      $this->db->insert($this->_table_name);
      $id = $this->db->insert_id();
    } else {  // Update
      $filter = $this->_primary_filter;
      $id = $filter($id);
      $this->db->set($data);
      $this->db->where($this->_primary_key, $id);
      $this->db->update($this->_table_name);
    }

    return $id;

  }
  
  /**
   * deletes record with the primary key of $id from the database.
   */
  public function delete($id) {
    $filter = $this->_primary_filter;
    $id = $filter($id);

    if (!$id) {
      return FALSE;
    }

    $this->db->where($this->_primary_key, $id);
    $this->db->limit(1);
    $this->db->delete($this->_table_name);
  }
  
  
	public function array_from_post($fields){
		$data = array();
		foreach ($fields as $field) {
			$data[$field] = $this->input->post($field);
		}
		return $data;
	}
    function select_row($table_name,$update_where=array(),$order_by =  array(),$limit='',$like=array()){
		$where_cond = '';
    if(!empty($update_where)){
      foreach($update_where as $key => $val){
          $this->db->where($key, $val);
      }
      /* Added By Bishweswar End*/
    }else{
        $where_cond = array();
    }
    
	if(!empty($like)){
		$i = 0;
        foreach($like as $key => $val){
			if(empty($i)){
            	$this->db->like($key, $val);
			}else{
				$this->db->or_like($key, $val); 
			}
			$i++;
        }
    } 
	if(!empty($order_by)){
        foreach($order_by as $key => $val){
            $this->db->order_by($key, $val);
        }
    }
	if(!empty($limit)){
		 	$this->db->limit($limit, 0);
    }
    $query = $this->db->get($table_name);
	
    if($query->row()){
		
			return $query->result();
		}else{
			return false;
		}
	}
    function insert_row($table_name,$insert_data){
		$this->db->insert($this->db->dbprefix($table_name), $insert_data);
		return 	$this->db->insert_id();
	}
    function update_row($table_name,$update_data,$update_where){
		$where_cond = '';
    if(empty($update_where))
      return false;

    $where_cond = implode(' AND ', array_map(function ($value, $key) { 
      return $key . " ='" . $value . "'"; }, $update_where, array_keys($update_where))
    ); // do not change anything in this string.
    
    $this->db->where($where_cond);
    if($this->db->update($table_name,$update_data)){
			return true;
		}else{
			return false;
		}
	}
}
