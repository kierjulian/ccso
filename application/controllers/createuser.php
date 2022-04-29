<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Createuser extends CI_Controller 
	{
		public function index()
		{	
			if(! $this->session->userdata("logged_in")){
				redirect(base_url() . "main/");
			}
			
			if($this->session->userdata("isSuper") == 0){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
			
			$this->load->view('header.php');
			$this->load->view('navbar.php');
			$this->load->view('createuserview.php');
			$this->load->view('footer.php');
			
			$config = array(
				   array(
						 'field'   => Patient::LAST_NAME, 
						 'label'   => 'Last Name', 
						 'rules'   => 'required|max_length[20]|trim|callback_alpha_dash_space'
					  ),
				   array(
						 'field'   => Patient::FIRST_NAME, 
						 'label'   => 'First Name', 
						 'rules'   => 'required|max_length[20]|trim|callback_alpha_dash_space'
					  ),
				   array(
						 'field'   => Patient::MIDDLE_NAME, 
						 'label'   => 'Middle Name', 
						 'rules'   => 'required|max_length[20]|trim|callback_alpha_dash_space'
					  ),   
				   array(
						 'field'   => Patient::SEX, 
						 'label'   => 'Sex', 
						 'rules'   => 'required'
					  ),
					array(
						 'field'   => Patient::BIRTHDAY, 
						 'label'   => 'Birthday', 
						 'rules'   => 'required|callback_valid_dob'
					  ),
					array(
						 'field'   => Patient::ADDRESS, 
						 'label'   => 'Address', 
						 'rules'   => 'max_length[75]'
					  ),
					array(
						 'field'   => Patient::EDUC_ATTAINMENT, 
						 'label'   => 'Educational Attainment', 
						 'rules'   => 'required'
					  ),
					array(
						 'field'   => Patient::NATIONALITY, 
						 'label'   => 'Nationality', 
						 'rules'   => 'max_length[20]'
					  ),
					array(
						 'field'   => Patient::CONTACT_NUM, 
						 'label'   => 'Contact Number', 
						 'rules'   => 'required|numeric|max_length[20]'
					  ),
					array(
						 'field'   => Patient::PHYSICIAN, 
						 'label'   => 'Physician', 
						 'rules'   => 'max_length[50]'
					  ),
					array(
						 'field'   => Patient::PWD, 
						 'label'   => 'PWD', 
						 'rules'   => 'required'
					  ),
					array(
						 'field'   => 'emer_contact_name0', 
						 'label'   => 'Emergency Contact', 
						 'rules'   => 'max_length[60]'
					  ),
					array(
						 'field'   => 'emer_contact_name1', 
						 'label'   => 'Emergency Contact', 
						 'rules'   => 'max_length[60]'
					  ),
					  array(
						 'field'   => 'emer_contact_name2', 
						 'label'   => 'Emergency Contact', 
						 'rules'   => 'max_length[60]'
					  ),
					array(
						 'field'   => 'emer_contact_num0', 
						 'label'   => 'Contact Person Number', 
						 'rules'   => 'max_length[20]|numeric'
					  ),
					array(
						 'field'   => 'emer_contact_num1', 
						 'label'   => 'Contact Person Number', 
						 'rules'   => 'max_length[20]|numeric'
					  ),
					array(
						 'field'   => 'emer_contact_num2', 
						 'label'   => 'Contact Person Number', 
						 'rules'   => 'max_length[20]|numeric'
					  ),
					array(
						 'field'   => 'card_type0', 
						 'label'   => 'Healthcard', 
						 'rules'   => ''
					  ),
					array(
						 'field'   => 'card_type1', 
						 'label'   => 'Healthcard', 
						 'rules'   => ''
					  ),
					array(
						 'field'   => 'card_num0', 
						 'label'   => 'HealthCard Number', 
						 'rules'   => 'max_length[20]'
					  ),
					array(
						 'field'   => 'card_num1', 
						 'label'   => 'Healthcard Number', 
						 'rules'   => 'max_length[20]'
					  )
				);
				
				
			$this->form_validation->set_rules($config);
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('patientform');
				return;
			}

			$query = "INSERT INTO doctors_list (uName, pWord, fName, mName, lName, hAddr, eAddr, sex, contactNo, pos, doe, prcNum)
					 VALUES()" 
			
			$patientSQL = $this->db->query($query);
			$data["patients"] = $patientSQL->result();
			
			$query = sprintf
			(
				"SELECT `%s`, `%s` " .
				"FROM %s " .
				"WHERE `%s` = '%s' AND `%s` IS NOT NULL",
				Appointment::APPOINTMENT_DATE,
				Appointment::TIME_OUT,
				
				Appointment::TABLE_NAME,			
				Appointment::APPOINTMENT_DATE, date("Y-m-d"),
				Appointment::TIME_OUT
			);
			
			$discharged = $this->db->query($query);
			
			// Count patients that have an appointment today
			$data["total"] = count($data["patients"]);
			$data["discharged"] = count($discharged->result());
			
			// Count patients that have been discharged
			// (i.e. with Time-in and Time-out)
			$timeOut = sprintf("%s IS NOT NULL", Appointment::TIME_OUT);
			
		
			$this->load->view("patientqueue", $data);
		}
	}