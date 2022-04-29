<?php
class Patient_model extends CI_Model {
	
	private $tbl_patient= 'patient_demographics';
	
	function __construct(){
		parent::__construct();
	}
	
	function list_all(){
		$this->db->order_by('id','asc');
		return $this->db->get($tbl_patient);
	}
	
	function count_all(){
		return $this->db->count_all($this->tbl_patient);
	}
	
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by('id','asc');
		return $this->db->get($this->tbl_patient, $limit, $offset);
	}
	
	function get_by_id($id){
		$this->db->where('patient_no', $id);
		return $this->db->get($this->tbl_patient);
	}
	
	function save($person){
		$this->db->insert($this->tbl_patient, $person);
		return $this->db->insert_id();
	}
	
	function update($id, $person){
		$this->db->where('id', $id);
		$this->db->update($this->tbl_patient, $person);
	}
	
	function delete($id){
		$this->db->where('id', $id);
		$this->db->delete($this->tbl_patient);
	}
}
?>