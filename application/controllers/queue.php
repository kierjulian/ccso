<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	require_once "assets/classes/Patient.php";
	require_once "assets/classes/EmergencyContact.php";
	require_once "assets/classes/HealthCard.php";
	require_once "assets/classes/Appointment.php";
	require_once "assets/classes/ScheduledAppointment.php";
	require_once "assets/classes/MessageManager.php";
	require_once "assets/classes/TableManager.php";
	
	class Queue extends CI_Controller 
	{
		
		private			$messageManager;
		
		private			$queueTableManager;
		
		function __construct() {
			parent::__construct();
			$this -> messageManager 	= new MessageManager();
			$this -> queueTableManager	= new TableManager($this, Appointment::TABLE_NAME);
		}
		
		/**
		 * Displays the admitted patients queue.
		 */
		public function index()
		{	
			if(! $this->session->userdata("logged_in")){
				redirect(base_url() . "main/");
			}
			
			$this->load->view('header.php');
			$this->load->view('navbar.php');
			$this->load->view('footer.php');
			
			// Set timezone to Manila
			date_default_timezone_set('Asia/Manila');
			
			$query = sprintf
			(
				"SELECT `%s`.`%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`
				 FROM `%s`, `%s` 
				 WHERE (`%s`.`%s` = `%s`.`%s`) AND (`%s` <= '%s') AND (`%s` IS NULL)
				 ORDER BY `%s`",
				 
				Patient::TABLE_NAME, Patient::TRUE_ID,
				Patient::CREATION_DATE, Patient::CREATION_NUM,
				Patient::LAST_NAME, Patient::FIRST_NAME, Patient::MIDDLE_NAME, 
				Patient::SEX, Patient::BIRTHDAY,
				Appointment::VISIT_NUMBER, Appointment::TIME_IN, Appointment::APPOINTMENT_DATE,
				
				Patient::TABLE_NAME, Appointment::TABLE_NAME,
				
				Patient::TABLE_NAME, Patient::TRUE_ID,
				Appointment::TABLE_NAME, Appointment::TRUE_ID,
				Appointment::APPOINTMENT_DATE, date("Y-m-d"),
				Appointment::TIME_OUT,
				Appointment::VISIT_NUMBER
			);
			// Count patients that have an appointment today
			$data["count"] = count($this->db->query($query)->result());
			
			// Page query
			$page = (empty(htmlspecialchars($this->input->get("page")))? 1 : htmlspecialchars($this->input->get("page")));
			
			$pageVal = (intval($page)? intval($page) : 0) - 1;
			$query = sprintf
			(
				"SELECT *
				 FROM (%s) SUB
				 LIMIT %d OFFSET %d",
				 $query, 30, $pageVal*30
			);
			$data["patients"] = $this->db->query($query)->result();
			
			// Count recently discharged patients
			$query = sprintf
			(
				"SELECT `%s`, `%s` 
				 FROM %s 
				 WHERE `%s` = '%s' AND `%s` IS NOT NULL",
				Appointment::APPOINTMENT_DATE,
				Appointment::TIME_OUT,
				
				Appointment::TABLE_NAME,			
				Appointment::APPOINTMENT_DATE, date("Y-m-d"),
				Appointment::TIME_OUT
			);			
			$discharged = $this->db->query($query);
			$data["discharged"] 	= count($discharged->result());
			$data["isPrintable"] 	= false;
			
			$printMessage			= $this -> messageManager -> getMessage("get_printable");
			$data["printableLink"]	= "<a href = '".base_url()."queue/printable/'> $printMessage </a>";
			
			
			// Count patients that have been discharged
			// (i.e. with Time-in and Time-out)
			$timeOut = sprintf("%s IS NOT NULL", Appointment::TIME_OUT);
			
		
			$this->load->view("admit_queue", $data);
		}
		
		public function printable() {
		
			if(! $this->session->userdata("logged_in")){
				redirect(base_url() . "main/");
			}
			
			date_default_timezone_set('Asia/Manila');
		
			$this->load->view('header.php');
			$this->load->view('footer.php');
			
			$query = sprintf
			(
				"SELECT `%s`.`%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`
				 FROM `%s`, `%s` 
				 WHERE (`%s`.`%s` = `%s`.`%s`) AND (`%s` <= '%s') AND (`%s` IS NULL)
				 ORDER BY `%s`",
				 
				Patient::TABLE_NAME, Patient::TRUE_ID,
				Patient::CREATION_DATE, Patient::CREATION_NUM,
				Patient::LAST_NAME, Patient::FIRST_NAME, Patient::MIDDLE_NAME, 
				Patient::SEX, Patient::BIRTHDAY,
				Appointment::VISIT_NUMBER, Appointment::TIME_IN, Appointment::APPOINTMENT_DATE,
				
				Patient::TABLE_NAME, Appointment::TABLE_NAME,
				
				Patient::TABLE_NAME, Patient::TRUE_ID,
				Appointment::TABLE_NAME, Appointment::TRUE_ID,
				Appointment::APPOINTMENT_DATE, date("Y-m-d"),
				Appointment::TIME_OUT,
				Appointment::VISIT_NUMBER
			);
			// Count patients that have an appointment today
			$rawquery			= $this -> db -> query($query);
			$data["patients"] 	= $rawquery -> result();
			$data["count"] 		= $rawquery -> num_rows();
			
			// Count recently discharged patients
			$query = sprintf
			(
				"SELECT `%s`, `%s` 
				 FROM %s 
				 WHERE `%s` = '%s' AND `%s` IS NOT NULL",
				Appointment::APPOINTMENT_DATE,
				Appointment::TIME_OUT,
				
				Appointment::TABLE_NAME,			
				Appointment::APPOINTMENT_DATE, date("Y-m-d"),
				Appointment::TIME_OUT
			);			
			$discharged = $this->db->query($query);
			$data["discharged"] 	= count($discharged->result());
			$data["isPrintable"] 	= true;
		
			// Count patients that have been discharged
			// (i.e. with Time-in and Time-out)
			$timeOut = sprintf("%s IS NOT NULL", Appointment::TIME_OUT);
		
			$this->load->view("admit_queue", $data);
		}
		
		public function addpoll() {
			if(! $this->session->userdata("logged_in")){
				redirect(base_url() . "main/");
			}
			
			if ( $this -> input -> post('ajax_queue_poll') == false ) {
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('footer.php');
				
				$array 	= array (
						'message' 	=> $this -> messageManager -> getMessage('no_direct_access')
					);
				$this->load->view('error_page.php', $array);
				return;
			}
			
			$queueLength	= $this -> input -> post('queue_length');
			$lastVisitNum	= $this -> input -> post('last_visitnum');
			
			$query 			= sprintf (
				"SELECT `%s`.`%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`
				 FROM `%s`, `%s` 
				 WHERE (`%s`.`%s` = `%s`.`%s`) AND (`%s` > %d) AND (`%s` IS NULL)
				 ORDER BY `%s`",
				 
				Patient::TABLE_NAME, Patient::TRUE_ID,
				Patient::CREATION_DATE, Patient::CREATION_NUM,
				Patient::LAST_NAME, Patient::FIRST_NAME, Patient::MIDDLE_NAME, 
				Patient::SEX, Patient::BIRTHDAY,
				Appointment::VISIT_NUMBER, Appointment::TIME_IN, Appointment::APPOINTMENT_DATE,
				
				Patient::TABLE_NAME, Appointment::TABLE_NAME,
				
				Patient::TABLE_NAME, Patient::TRUE_ID,
				Appointment::TABLE_NAME, Appointment::TRUE_ID,
				Appointment::VISIT_NUMBER, $lastVisitNum,
				Appointment::TIME_OUT,
				Appointment::VISIT_NUMBER
			);
			$rawquery		= $this -> db -> query($query);
			$queryResult	= $rawquery -> result();
			$numRows		= $rawquery -> num_rows(); 
			
			$responseText	= "";
			for ( 	$loop = $queueLength, $index = 0; 
					$loop <= 30 && $index < $numRows; 
					$loop++, $index++) {
					
				$patient	= $queryResult[$index];
				$visitNo	= $patient->{Appointment::VISIT_NUMBER};
				$patientID	= $patient->{Patient::TRUE_ID};
				
				$rowID		= Patient::getPatientID($patient->{Patient::CREATION_DATE}, $patient->{Patient::CREATION_NUM});
				$rowName	= Patient::getFullName($patient->{Patient::LAST_NAME}, $patient->{Patient::FIRST_NAME}, $patient->{Patient::MIDDLE_NAME});;
				$rowSex		= Patient::getSex($patient->{Patient::SEX});
				$rowBday	= Patient::getBirthday($patient->{Patient::BIRTHDAY});
				$rowTimeIn	= Appointment::getTime($patient->{Appointment::TIME_IN});
				
				$responseText 	.= 
					"<row>
						<visitno> $visitNo </visitno>
						<dateid> $rowID </dateid>
						<name> $rowName </name>
						<sex> $rowSex </sex>
						<bday> $rowBday </bday>
						<time> $rowTimeIn </time>
						<trueid> $patientID </trueid>
					</row>
					";
			}
			$responseText 	.= "
					<count> $numRows </count>
				";
			$response 	= "<?xml version='1.0' encoding='UTF-8'?><root> $responseText </root>";
			
			$this -> output -> set_output($response);
		}
		
		public function removepoll() {
			if(! $this->session->userdata("logged_in")){
				redirect(base_url() . "main/");
			}

			if ( $this -> input -> post('ajax_queue_poll') == false ) {
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('footer.php');
				
				$array 	= array (
						'message' 	=> $this -> messageManager -> getMessage('no_direct_access')
					);
				$this->load->view('error_page.php', $array);
				return;
			}
			
			$visitNumString		= $this -> input -> post('visit_nums');
			$delimiter			= $this -> input -> post('delimiter');
			
			$tokenString		= strtok($visitNumString, $delimiter);
			$returnedVal		= "";
			while ($tokenString !== false) {
				$restrictions = array( Appointment::VISIT_NUMBER => intval($tokenString) );
				if ( $this -> queueTableManager -> getNumOfRecords($restrictions) == 0 ) {
					$returnedVal	.= "$tokenString;";
				}
				$tokenString	= strtok($delimiter);
			}
			$this -> output -> set_output($returnedVal);
		}
		
		public function dequeue() {
			if(! $this->session->userdata("logged_in")){
				redirect(base_url() . "main/");
			}
			
			if ( $this -> input -> post('ajax_queue_remove') == false ) {
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('footer.php');
				
				$array 	= array (
						'message' 	=> $this -> messageManager -> getMessage('no_direct_access')
					);
				$this->load->view('error_page.php', $array);
				return;
			}
			
			$id		= $this -> input -> post('patient_id');
			
			$this -> db -> where(Patient::TRUE_ID, $id);			
			$sql 	= $this -> db -> get(Appointment::TABLE_NAME)->row();
			
			if ($sql != null) {				
	
				$this->db->where(Patient::TRUE_ID, $id);
				$this->db->delete(Appointment::TABLE_NAME);
									
				$data["message"] = sprintf (
					$this -> messageManager -> getMessage('queue_success'),
					PHP_EOL, $id
				);
	
			}
			
		}
		
		
	}