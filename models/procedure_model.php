<?php
class Procedure_model extends CI_Model {
	
	private $procedure= 'procedure';
	
	function __construct(){
		parent::__construct();
	}
	
	function count_all(){
		return $this->db->count_all($this->procedure);
	}
	
	function get_paged_list($limit = 10, $offset = 0){
		return $this->db->get($this->procedure, $limit, $offset);
	}
	
}
?>