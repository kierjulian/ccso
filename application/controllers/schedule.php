<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	require_once "assets/classes/ScheduledAppointment.php";
	require_once "assets/classes/Patient.php";
	require_once "assets/classes/MessageManager.php";

	class Schedule extends CI_Controller {
	
		private			$messageManager;
		
		function __construct() {
			parent::__construct();
			$this -> messageManager 	= new MessageManager();
		}

		public function index() {	
			
			if(! $this->session->userdata("logged_in")){
				redirect(base_url() . "main/");
			}
			if(!$this->session->userdata("acsAdm")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}	
			
			
			$this->load->view('header.php');
			$this->load->view('navbar.php');
			$this->load->view('admit_sidebar.php');
			$this->load->view('footer.php');

			// Get all entries (base query)	
			$query = sprintf
			(
				"SELECT `%s`.`%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s` " .
				"FROM `%s`, `%s` " .
				"WHERE `%s`.`%s` = `%s`.`%s` AND `%s`.`%s` = %d",
				Patient::TABLE_NAME, Patient::TRUE_ID,
				Patient::LAST_NAME, Patient::FIRST_NAME, Patient::MIDDLE_NAME,
				Patient::CREATION_DATE, Patient::CREATION_NUM,
				ScheduledAppointment::SCHEDULE_ID, ScheduledAppointment::REMARKS,
				ScheduledAppointment::SCHEDULE_DATE, ScheduledAppointment::SCHEDULE_TIME,
				
				Patient::TABLE_NAME, ScheduledAppointment::TABLE_NAME,
				Patient::TABLE_NAME, Patient::TRUE_ID,
				ScheduledAppointment::TABLE_NAME, ScheduledAppointment::TRUE_ID,
				ScheduledAppointment::TABLE_NAME, ScheduledAppointment::STATUS, ScheduledAppointment::UPCOMING
			);
			
			$name = htmlspecialchars($this->input->get("name"));
			$from = $this->input->get("from");
			$to = $this->input->get("to");
			$page = $this->input->get("page");
			
			// Name query
			if (!empty($name))
			{
				$query .= sprintf
				(
					" AND
					(`%s` LIKE '%%%s%%' OR `%s` LIKE '%%%s%%' OR `%s` LIKE '%%%s%%')",
					Patient::LAST_NAME, mysql_real_escape_string($name),
					Patient::FIRST_NAME, mysql_real_escape_string($name),
					Patient::MIDDLE_NAME, mysql_real_escape_string($name)
				);
			}
			
			// From query
			if (!empty($from) && $this->validDate($from, "Y-m-d"))
			{
				$query .= sprintf
				(
					" AND (`%s` >= '%s')",
					ScheduledAppointment::SCHEDULE_DATE, mysql_real_escape_string($from)
				);	
			}
			
			// To query
			if (!empty($to) && $this->validDate($to, "Y-m-d"))
			{
				$query .= sprintf
				(
					" AND (`%s` <= '%s')",
					ScheduledAppointment::SCHEDULE_DATE, mysql_real_escape_string($to)
				);	
			}
			$data["count"] = count($this->db->query($query)->result());
			
			// Page query
			if (!empty($page))
			{
				$pageVal = (intval($page)? intval($page) : 0) - 1;
				$query = sprintf
				(
					"SELECT *
					 FROM (%s) SUB
					 LIMIT %d OFFSET %d",
					 $query, 30, $pageVal*30
				);
			}
		
			$patientSQL = $this->db->query($query);
			$data["patients"] = $patientSQL->result();
			
			// Set timezone to Manila
			date_default_timezone_set('Asia/Manila');
			$date = date("Y-m-d");
			
			// Count patients with scheduled appointments
			// Get all entries (base query)	
			$query = sprintf
			(
				"SELECT *
				 FROM `%s`
				 WHERE `%s` = %d",
				 
				ScheduledAppointment::TABLE_NAME,
				ScheduledAppointment::STATUS, ScheduledAppointment::UPCOMING
			);
			$data["total"] = count($this->db->query($query)->result());
				
			// Count patients with scheduled appointments for this month
			$query = sprintf
			(
				"SELECT `%s` " .
				"FROM `%s` " .
				"WHERE year(`%s`) = %s AND month(`%s`) = %s AND `%s` = %d",
				ScheduledAppointment::SCHEDULE_DATE,
				ScheduledAppointment::TABLE_NAME,
				ScheduledAppointment::SCHEDULE_DATE, date("Y", strtotime($date)),
				ScheduledAppointment::SCHEDULE_DATE, date("m", strtotime($date)),
				ScheduledAppointment::STATUS, ScheduledAppointment::UPCOMING
			);		
			$data["month"] = count($this->db->query($query)->result());
			
			// Count patients with overdue scheduled appointments
			$query = sprintf
			(
				"SELECT `%s` " .
				"FROM `%s` " .
				"WHERE `%s` < %s",
				ScheduledAppointment::SCHEDULE_DATE,
				ScheduledAppointment::TABLE_NAME,
				ScheduledAppointment::SCHEDULE_DATE, $date
			);
			$data["overdue"] 		= count($this->db->query($query)->result());
			$data["isPrintable"]	= false;
			
			$printMessage			= $this -> messageManager -> getMessage("get_printable");
			$data["printableLink"]	= "<a href = '".base_url()."schedule/printable/'> $printMessage </a>";
			
			
			$this->load->view("admit_schedule", $data);			
		}
		
		public function printable() {
			if(! $this->session->userdata("logged_in")){
				redirect(base_url() . "main/");
			}

			if(!$this->session->userdata("acsAdm")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}	
			
			$this->load->view('header.php');
			$this->load->view('footer.php');

			// Get all entries (base query)	
			$query = sprintf
			(
				"SELECT `%s`.`%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s` " .
				"FROM `%s`, `%s` " .
				"WHERE `%s`.`%s` = `%s`.`%s` AND `%s`.`%s` = %d",
				Patient::TABLE_NAME, Patient::TRUE_ID,
				Patient::LAST_NAME, Patient::FIRST_NAME, Patient::MIDDLE_NAME,
				Patient::CREATION_DATE, Patient::CREATION_NUM,
				ScheduledAppointment::SCHEDULE_ID, ScheduledAppointment::REMARKS,
				ScheduledAppointment::SCHEDULE_DATE, ScheduledAppointment::SCHEDULE_TIME,
				
				Patient::TABLE_NAME, ScheduledAppointment::TABLE_NAME,
				Patient::TABLE_NAME, Patient::TRUE_ID,
				ScheduledAppointment::TABLE_NAME, ScheduledAppointment::TRUE_ID,
				ScheduledAppointment::TABLE_NAME, ScheduledAppointment::STATUS, ScheduledAppointment::UPCOMING
			);
			
			$patientSQL = $this->db->query($query);
			$data["patients"] = $patientSQL->result();
			
			// Set timezone to Manila
			date_default_timezone_set('Asia/Manila');
			$date = date("Y-m-d");
			
			// Count patients with scheduled appointments
			// Get all entries (base query)	
			$query = sprintf
			(
				"SELECT *
				 FROM `%s`
				 WHERE `%s` = %d",
				 
				ScheduledAppointment::TABLE_NAME,
				ScheduledAppointment::STATUS, ScheduledAppointment::UPCOMING
			);
			$data["count"] = count($this->db->query($query)->result());
				
			// Count patients with scheduled appointments for this month
			$query = sprintf
			(
				"SELECT `%s` " .
				"FROM `%s` " .
				"WHERE year(`%s`) = %s AND month(`%s`) = %s AND `%s` = %d",
				ScheduledAppointment::SCHEDULE_DATE,
				ScheduledAppointment::TABLE_NAME,
				ScheduledAppointment::SCHEDULE_DATE, date("Y", strtotime($date)),
				ScheduledAppointment::SCHEDULE_DATE, date("m", strtotime($date)),
				ScheduledAppointment::STATUS, ScheduledAppointment::UPCOMING
			);		
			$data["month"] = count($this->db->query($query)->result());
			
			// Count patients with overdue scheduled appointments
			$query = sprintf
			(
				"SELECT `%s` " .
				"FROM `%s` " .
				"WHERE `%s` < %s",
				ScheduledAppointment::SCHEDULE_DATE,
				ScheduledAppointment::TABLE_NAME,
				ScheduledAppointment::SCHEDULE_DATE, $date
			);
			$data["overdue"] 		= count($this->db->query($query)->result());
			$data["isPrintable"]	= true;
			
			$this->load->view("admit_schedule", $data);			
		
		}
		
		private function validDate($date, $format = 'Y-m-d H:i:s')
		{
			if(!$this->session->userdata("acsAdm")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}	
			$d = DateTime::createFromFormat($format, $date);
			
			$min = new DateTime("1901-12-15");
			$max = new DateTime("2038-01-19");
			return $d && $d->format($format) == $date && ($d >= $min && $d <= $max);
		}


	}
	
?>