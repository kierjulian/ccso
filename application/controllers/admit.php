<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	require_once "assets/classes/Patient.php";
	require_once "assets/classes/EmergencyContact.php";
	require_once "assets/classes/HealthCard.php";
	require_once "assets/classes/Appointment.php";
	require_once "assets/classes/ScheduledAppointment.php";
	require_once "assets/classes/ImageTableManager.php";
	require_once "assets/classes/Image.php";
	require_once "assets/classes/MessageManager.php";
	
	class Admit extends CI_Controller 
	{
		/* imageTableManager
		 *		- contains the TableManager that manages the image table of the database
		 */
		private $imageTableManager;
		
		/*	messageManager
		 *		- the object responsible for providing messages to be displayed on the site
		 */
		private $messageManager;
		
		
		/* constructor
		 */
		function __construct() {
			parent::__construct();
			$this -> imageTableManager 		= new ImageTableManager( $this, Image::TABLE_NAME, Patient::TRUE_ID);
			$this -> messageManager			= new MessageManager();
			
			$this -> load -> library('upload');
			$this -> load -> library('form_validation');
			$this -> load -> helper(array('form', 'url'));
		}
		public function index()
		{	
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
			
			redirect(base_url() . "admit/add");
		}
		
		public function add()
		{
			if(! $this->session->userdata("logged_in"))
			{
				redirect(base_url() . "main/");
			}		
			if(!$this->session->userdata("acsAdm"))
			{
					$this->load->view('header.php');
					$this->load->view('navbar.php');
					$this->load->view('home_sidebar.php');
					$this->load->view('footer.php');
					$this->load->view('access_denied.php');
					return;
			}

			echo $this->load->view('header.php', array(), true);
			echo $this->load->view('navbar.php', array(), true);
			echo $this->load->view('admit_sidebar.php', array(), true);
			echo $this->load->view('footer.php', array(), true);
			
		
			// --------------------------------------------- FORM VALIDATION -------------------------------------------------- //
		
			$this->form_validation->set_message('alpha_dash_space', 	$this -> messageManager -> getMessage('form_alphaspace'));
			$this->form_validation->set_message('valid_dob', 			$this -> messageManager -> getMessage('invalid_date'));
			$this->form_validation->set_message('validDate', 			$this -> messageManager -> getMessage('invalid_date'));
			
			$listSex['dataSex'] 		= $this -> input -> get('sex');
			$listEduc['dataEduc'] 		= $this -> input -> get('educattainment');
			$listPwd['dataPwd'] 		= $this -> input -> get('pwd');
			$listHealth['dataHealth'] 	= $this -> input -> get('healthcard');
			
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
				// Get all possible healthcards
				$cardListSQL = $this->db->get(HealthCard::LOOKUP_TABLE_NAME);
				$data = array
				(
					"cardList"		=> $cardListSQL->result(),
					"formaction"	=> "add"
				);
				
				$this->load->view('admit_form', $data);
				return;
			}
			
			// --------------------------------------------- FORM VALIDATION -------------------------------------------------- //
			
			// Set timezone to Manila
			date_default_timezone_set('Asia/Manila');
			
			$currentCount = 0;
			$currentDate = date("Y-m-d");
			
			// Get database metadata
			$meta = $this->db->get("metadata")->row();
			
			$data = array
			(
				"current_year"	=>	$meta->current_year,
				"current_count"	=>	$meta->current_count
			);
			
			// Update metadata
			if ($meta->current_year != date("Y"))
			{
				$this->db->where("current_year", $meta->current_year);
				
				$data->current_year = date("Y");		// Change year to current year
				$data->current_count = 0;				// Reset count to 0
			}
			else
				$currentCount = ++$data['current_count'];			
			$this->db->update("metadata", $data);
			
			// Data to be inserted to the Patients table
			$data = array
			(
				Patient::LAST_NAME 			=> 	htmlspecialchars( $this->input->post(Patient::LAST_NAME) ),
				Patient::FIRST_NAME 		=> 	htmlspecialchars( $this->input->post(Patient::FIRST_NAME) ),
				Patient::MIDDLE_NAME		=>	htmlspecialchars( $this->input->post(Patient::MIDDLE_NAME) ),
				Patient::SEX				=>	$this->input->post(Patient::SEX),
				Patient::BIRTHDAY			=>	$this->input->post(Patient::BIRTHDAY),
				Patient::CONTACT_NUM		=>	htmlspecialchars( $this->input->post(Patient::CONTACT_NUM) ),
				Patient::ADDRESS			=>	htmlspecialchars( $this->input->post(Patient::ADDRESS) ),
				Patient::PHYSICIAN			=>	htmlspecialchars( $this->input->post(Patient::PHYSICIAN) ),
				Patient::NATIONALITY		=>	htmlspecialchars( $this->input->post(Patient::NATIONALITY) ),
				Patient::EDUC_ATTAINMENT	=>	$this->input->post(Patient::EDUC_ATTAINMENT),
				Patient::PWD				=>	$this->input->post(Patient::PWD),
				Patient::CREATION_DATE		=>	$currentDate,
				Patient::CREATION_NUM		=>	$currentCount
			);
			
			
			if (!$this->validDate($data[Patient::BIRTHDAY], "Y-m-d"))
			{
				echo $this->load->view('admit_form', array("formaction" => "add"), true);
				echo form_error(Patient::BIRTHDAY);
				return;
			}
			

			// Success/error msgs
			$uploadID = "";
			if ($this->db->insert(Patient::TABLE_NAME, $data) == TRUE)
			{
				// Retrieve newly-created data
				$this->db->where(Patient::CREATION_DATE, $currentDate);	
				$this->db->where(Patient::CREATION_NUM, $currentCount);	
				
				$trueID 	= $this->db->get(Patient::TABLE_NAME)->row()->{Patient::TRUE_ID};
				$uploadID	= $trueID;
				
				// Add emergency contacts into the database
				for ($i = 0; $i < 3; $i++)
				{
					$contactName = $this->input->post(EmergencyContact::CONTACT_NAME . $i);
					$contactNum = $this->input->post(EmergencyContact::CONTACT_NUM . $i);
					if (!empty($contactName) && !empty($contactNum))
					{
						$data = array
						(
							EmergencyContact::TRUE_ID		=>	$trueID,
							EmergencyContact::CONTACT_NAME	=>	htmlspecialchars( $contactName ),
							EmergencyContact::CONTACT_NUM	=>	htmlspecialchars( $contactNum )
						);
						
						$this->db->insert(EmergencyContact::TABLE_NAME, $data);
					}
				}
				
				// Add healthcards into the database				
				for ($i = 0; $i < 2; $i++)
				{
					$cardType = $this->input->post(HealthCard::CARD_TYPE . $i);
					$cardNum = $this->input->post(HealthCard::CARD_NUMBER . $i);
					
					if ($cardType != 1 && !empty($cardNum))
					{
						$data = array
						(
							HealthCard::TRUE_ID		=>	$trueID,
							HealthCard::CARD_TYPE	=>	$cardType,
							HealthCard::CARD_NUMBER	=>	htmlspecialchars( $cardNum )
						);
						
						$this->db->insert(HealthCard::TABLE_NAME, $data);
					}
				}
				
				// ----- upload picture process start ----- 
				
				$dbManager 	= $this -> imageTableManager;
				$id			= $uploadID;
				
				// Get number of records (current image ID)
				$imageName 	= Image::getFilename();
				$dir 		= Image::getDirectory($id);
				
				// Create specific patient folder, if it doesnt exist
				if (!is_dir(".$dir")) {
					mkdir(".$dir", 0755, true);
				}
				
				// Set config attributes
				$config['upload_path'] 		= ".$dir";
				$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
				$config['file_name'] 		= "profilepic";
				
				$this->upload->initialize( $config );
				if ( $this->upload->do_upload( Image::HTML_FILE ) ) {
				
				// Set data to be inserted in the table
				$imagedata['title'] 	= "'Profile Picture'";
				$imagedata['content'] 	= "'Profile Picture uploaded via Add Profile'";
				$imagedata['path'] 		= "'" . "".base_url()."$dir" . ($this->upload->orig_name) . "'";
				$imagedata['category']	= IMAGE::PROFILEPICTURE;
				$imagedata['tags']		= "";
				
				// Insert data to the database
				$dbManager -> addImageRecord($imagedata, $id);
				
				} // if upload
				
				// ----- upload picture process end ----- 
				
				$data["message"] = sprintf
				(
					$this -> messageManager -> getMessage('add_success'),
					$trueID, PHP_EOL
				);
				
				// Insert success page here
				$this->load->view('success_page', $data);
			}
			else
			{
				$array = array(
						"message" 	=> $this -> messageManager -> getMessage('add_fail')
					);
				$this->load->view('error_page', $array);
			}
		}
		
		public function cards()
		{
			if(! $this->session->userdata("logged_in"))
			{
				redirect(base_url() . "main/");
			}		
			if(!$this->session->userdata("acsAdm"))
			{
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
					
			if ($this->input->post("delete"))			// delete healthcard
			{
				
				$type = $this->input->post("type");
				
				$query = sprintf
				(
					"SELECT *
					 FROM `%s`, `%s`
					 WHERE `%s`.`%s` = `%s`.`%s` AND
						   `%s`.`%s` = %d",
					 
					 HealthCard::TABLE_NAME, HealthCard::LOOKUP_TABLE_NAME,
					 
					 HealthCard::TABLE_NAME, HealthCard::CARD_TYPE, HealthCard::LOOKUP_TABLE_NAME, HealthCard::CARD_TYPE,
					 HealthCard::TABLE_NAME, HealthCard::CARD_TYPE, $type
				);
				
				if (count($this->db->query($query)->result()) != 0)
				{
					$this->load->view('error_page');
				}
				else
				{
					$this->db->where(HealthCard::CARD_TYPE, $type);
					$this->db->delete(HealthCard::LOOKUP_TABLE_NAME);
				
					$data["message"] = sprintf
					(
						"Successfully deleted a health card!%s
						 Click <a href='%s'>here</a> to create view all health cards.",
						 
						 PHP_EOL, "/~cngeneroso/CCSO/admit/cards"
					);
					
					// Insert success page here
					$this->load->view('success_page', $data);
				}
				

			}
			else if ($this->input->post("create"))	// create healthcard
			{
				$name = mysql_real_escape_string(htmlspecialchars($this->input->post("name")));
				
				if ($this->alpha_dash_space($name))
				{
					$data = array
					(
						HealthCard::CARD_NAME	=>	$name
					);
					
					$this->db->insert(HealthCard::LOOKUP_TABLE_NAME, $data);
					
					$data["message"] = sprintf
					(
						"Successfully created a health card!%s
						 Click <a href='%s'>here</a> to create view all health cards.",
						 
						PHP_EOL, "/~cngeneroso/CCSO/admit/cards"
					);
					
					// Insert success page here
					$this->load->view('success_page', $data);
				}
				else
				{
					$this->load->view('error_page');
				}
			}
			else
			{
				// Get health cards of patient
				$cardListSQL = $this->db->get(HealthCard::LOOKUP_TABLE_NAME);
				$data["cards"] = $cardListSQL->result();
					
				$this->load->view('admit_cards.php', $data);
			}
		}
			
		/**
		 * Displays the scheduled patients queue.
		 */
		
		function alpha_dash_space($str)
		{
			if(!$this->session->userdata("acsAdm")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}	
			return ( ! preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;
		} 
		
		function valid_dob($inputdate)
		{
			if(!$this->session->userdata("acsAdm")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}	
			$today = new DateTime();
			$dob = new DateTime($inputdate);
			$min = new DateTime("1901-12-15");
			
			if ($dob > $today || $dob < $min)
				return FALSE;
			else
				return TRUE;

		}
		
		function valid_sched($inputsched)
		{
			if(!$this->session->userdata("acsAdm")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}	
			$today = new DateTime();
			$sched = new DateTime($inputsched);
			
			
			if ($sched > $max || $sched < $min || $sched > $today)
				return FALSE;
			else
				return TRUE;
		}
		
		function validDate($date, $format = 'Y-m-d H:i:s')
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