<?php
	class Model_discpresc extends CI_Model {
		function __construct() {
			parent::__construct(); //get the model consturctor
			$this->load->library('session');
		}	
		
		function getDischargeInfos() { //get everything
			$query = $this->db->query('SELECT * FROM tbl_discharge');
			
			if ($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		}
		
		function getPatientDischargeInfos($patient_id) { //get everything
			$query = $this->db->query("SELECT * FROM tbl_discharge WHERE patient_id = '$patient_id'");
			
			if ($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		}
		
		function getPatientPrescInfos($patient_id) {
			$query = $this->db->query("SELECT * FROM tbl_prescription WHERE patient_id = '$patient_id'");
			if ($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		}
		
		function getPrescInfos($patient_id, $prescDate) {
			$query = $this->db->query("SELECT * FROM tbl_prescription WHERE patient_id = '$patient_id' and presc_date = '$prescDate'");
			if ($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		}
		
		function updateFiles($file){	
			$newFile = array( 'filename' =>mysql_real_escape_string($file));
			
			$result = $this->db->insert('files',$newFile);
		}
		
		function updatePatientInfos($info){
			//update precription table
			$prescArgs = array(
				'presc_date' => mysql_real_escape_string($info['pdate']), 
				'patient_id' => mysql_real_escape_string($info['patientID']),
				'visit_num' => mysql_real_escape_string($info['vNum'])
				);
			$result1 = $this->db->insert('tbl_prescription', $prescArgs);
			
			//update eye table
			$prescEye = $info['prescEye'];
			$eyeArgs = array(
				'total_distancePD' => mysql_real_escape_string($prescEye['totald']),
				'total_nearPD' => mysql_real_escape_string($prescEye['totaln']),
			);
			$this->db->where('visit_no', $info['vNum']);
			$this->db->update('recommendation_eyeglass', $eyeArgs);
			
			//update recommendation_medication
			$meds = $info['meds'];
			$qty = $info['medQty'];
			$cnt = 1;
			if($meds != NULL){
				foreach ($meds as $med){
					$query = 'UPDATE recommendation_medication SET 
								MED_QUANTITY="'.$qty[$cnt].'" 
								where MED_GENERIC = "'.$med->MED_GENERIC.'" AND 
								VISIT_NO = ' . $info['vNum'];

					$this->db->query($query);
					$cnt++;
				}
			}
			
			//update discharge
			$discArgs = array(
				'patient_id' => mysql_real_escape_string($info['patientID']),
				'visit_num' => mysql_real_escape_string($info['vNum']),
				'consultation_date' => mysql_real_escape_string($info['cDate']),
				'hospital_no' => mysql_real_escape_string($info['hospitalNum']), 
				'proc_performed' => mysql_real_escape_string($info['procPerf']),
				'diagnostic_proc_perf' => implode("\n",$info['dProcPer']),
				'diagnostic_instr'=> mysql_real_escape_string($info['diagIns']),
				'followup_instr' => mysql_real_escape_string($info['follow'])
				);
	        $result = $this->db->insert('tbl_discharge', $discArgs);
		}

		function getVnum($patientID){
			$query = "SELECT visit_num FROM appointments
						WHERE appoint_date IN (
							SELECT max(appoint_date)
							FROM appointments
							GROUP BY true_id
							)
							AND true_id = ".$patientID;
			
			$vNum = $this->db->query($query);
			if($vNum->num_rows() > 0){
				return $vNum->result();
			} else {
				return NULL;
			}
		}
		
		function getMeds($vNum){
			$query = $this->db->query("SELECT * FROM recommendation_medication WHERE VISIT_NO = ".$vNum);
			if ($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		}

		function getEye($vNum){
			$query = $this->db->query("SELECT * FROM recommendation_eyeglass WHERE VISIT_NO = ".$vNum);
			if ($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		}

		function getDCodes($vNum){
			$query = $this->db->query("SELECT * FROM diagnosis WHERE VISIT_NO = ".$vNum);
			if ($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}	
		}

		function getDischargeDiagnosis(){
			$query = $this->db->query("SELECT DISTINCT * FROM discharge_diag WHERE 1");
			if ($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		}
		
		function updateTimeOut($patientID){
			$curTime = date('H:i:s', time());
			$query = 'UPDATE appointments SET time_out="'.$curTime.'" where true_id = '.$patientID.'';
			$this->db->query($query);
		}

		function getptr(){
			$docName = $this->session->userdata("username");
			$query = $this->db->query('SELECT ptrNum FROM doctors_list where uName = "'.$docName.'"');
			if ($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		}
		
		function updateptr($newptr){
			$docName = $this->session->userdata("username");
			$this->db->query('UPDATE doctors_list SET ptrNum = '.$newptr.' WHERE uName = "'.$docName.'"');
		}
		
		function getdocname(){
			$docName = $this->session->userdata("username");
			$query = $this->db->query('SELECT fName, lName, mName, pos FROM doctors_list where uName = "'.$docName.'"');
			if ($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		}
		
		function getFile(){
			$query = $this->db->query("SELECT filename FROM files WHERE 1");
			if ($query->num_rows() > 0){
				return $query->result();
			} else {
				return NULL;
			}
		}

	}
?>