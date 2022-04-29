<?php
	
	require_once "assets/classes/MessageManager.php";
	require_once "assets/classes/Patient.php";

	class Search extends CI_Controller {
	
		private				$messageManager;
	
		function __construct() {
			parent::__construct();
			$this -> messageManager 	= new MessageManager();
		}
		
		public function index() {
			if(! $this->session->userdata("logged_in")){
				redirect(base_url() . "main/");
			}
			echo $this->load->view('header.php', array(), true);
			echo $this->load->view('navbar.php', array(), true);
			echo $this->load->view('admit_sidebar.php', array(), true);
			echo $this->load->view('footer.php', array(), true);
			// Base query (all patients)
			$query = sprintf
			(
				"SELECT `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`
				 FROM `%s`",
				
				Patient::TRUE_ID,
				Patient::LAST_NAME, Patient::FIRST_NAME, Patient::MIDDLE_NAME, 
				Patient::SEX, Patient::BIRTHDAY,
				Patient::CREATION_DATE, Patient::CREATION_NUM,
				Patient::TABLE_NAME
			);
			
			// Get query filters
			$name = htmlspecialchars($this->input->get("name"));
			$bday = htmlspecialchars($this->input->get("bday"));
			$sex = htmlspecialchars($this->input->get("sex"));

			// Name query
			if (!empty($name))
			{
				$query .= sprintf
				(
					" WHERE
					(`%s` LIKE '%%%s%%' OR `%s` LIKE '%%%s%%' OR `%s` LIKE '%%%s%%')",
					Patient::LAST_NAME, mysql_real_escape_string($name),
					Patient::FIRST_NAME, mysql_real_escape_string($name),
					Patient::MIDDLE_NAME, mysql_real_escape_string($name)
				);
			}
			
			// Birthday query
			if (!empty($bday))
			{
				if (!empty($name))
					$query .= " AND";
				else
					$query .= " WHERE";
				
				$query .= sprintf
				(
					" (`%s` = '%s')",
					Patient::BIRTHDAY, mysql_real_escape_string($bday)
				);	
			}

			
			// Sex query
			if (!empty($sex))
			{
				if (!empty($name) || !empty($bday))
					$query .= " AND";
				else
					$query .= " WHERE";
				
				$query .= sprintf
				(
					" (`%s` = %s)",
					Patient::SEX, mysql_real_escape_string($sex)
				);
			}
			
			$data["count"] 			= count($this->db->query($query)->result());
			
			// Page query
			$page 		= intval(htmlspecialchars($this->input->get("page")));
			if ($page != 0) {
				$page--;
			}
			$query 		= sprintf
			(
				"SELECT *
				 FROM (%s) SUB
				 LIMIT %d OFFSET %d",
				 $query, 30, $page*30
			);
			
			$patients = $this->db->query($query);
			$data["patients"] = $patients->result();
			
			$baseurl = base_url();
			
			$data["isPrintable"]	= false;
			$data["printableLink"]	= $this -> messageManager -> getMessage('get_printable');
			$data["printableHREF"]	= "".base_url()."search/printable?name=$name&bday=$bday&sex=$sex";
			
			$this->load->view("admit_search", $data);
		}
		
		public function printable() {
			if(! $this->session->userdata("logged_in")){
				redirect(base_url() . "main/");
			}
			$this->load->view('header.php');
			$this->load->view('footer.php');
			
			// Base query (all patients)
			$query = sprintf
			(
				"SELECT `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`, `%s`
				 FROM `%s`",
				
				Patient::TRUE_ID,
				Patient::LAST_NAME, Patient::FIRST_NAME, Patient::MIDDLE_NAME, 
				Patient::SEX, Patient::BIRTHDAY,
				Patient::CREATION_DATE, Patient::CREATION_NUM,
				Patient::TABLE_NAME
			);
			
			// Get query filters
			$name = htmlspecialchars($this->input->get("name"));
			$bday = htmlspecialchars($this->input->get("bday"));
			$sex = htmlspecialchars($this->input->get("sex"));

			// Name query
			if (!empty($name))
			{
				$query .= sprintf
				(
					" WHERE
					(`%s` LIKE '%%%s%%' OR `%s` LIKE '%%%s%%' OR `%s` LIKE '%%%s%%')",
					Patient::LAST_NAME, mysql_real_escape_string($name),
					Patient::FIRST_NAME, mysql_real_escape_string($name),
					Patient::MIDDLE_NAME, mysql_real_escape_string($name)
				);
			}
			
			// Birthday query
			if (!empty($bday))
			{
				if (!empty($name))
					$query .= " AND";
				else
					$query .= " WHERE";
				
				$query .= sprintf
				(
					" (`%s` = '%s')",
					Patient::BIRTHDAY, mysql_real_escape_string($bday)
				);	
			}

			// Sex query
			if (!empty($sex))
			{
				if (!empty($name) || !empty($bday))
					$query .= " AND";
				else
					$query .= " WHERE";
				
				$query .= sprintf
				(
					" (`%s` = %s)",
					Patient::SEX, mysql_real_escape_string($sex)
				);
			}
			
			$patients 			= $this->db->query($query);
			$data["patients"] 	= $patients->result();
			
			// Count all patients
			$query = sprintf
			(
				"SELECT *
				 FROM `%s`",
				 Patient::TABLE_NAME
			);
			$data["count"] 			= count($this->db->query($query)->result());
			$data["isPrintable"]	= true;
			
			$this->load->view("admit_search", $data);
		
		}
	
	
	}

?>