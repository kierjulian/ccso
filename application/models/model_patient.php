<?php
	class Model_patient extends CI_Model {
		function __construct() {
			
			parent::__construct(); //get the model consturctor
		}	
		
		function getPatients() { //get everything
			$query = $this->db->query('SELECT * FROM patient_list');
			
			if ($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		}
		
		function getPatient($patientID) {
			$query = $this->db->query("SELECT birthday, sex, first_name, last_name, middle_name FROM patients WHERE true_id = '$patientID'");
			if ($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}		
		}
	}
?>