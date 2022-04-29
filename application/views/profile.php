<?php

	require_once "ImageTableManager.php";
	require_once "Image.php";	
	require_once "Patient.php";
	require_once "EmergencyContact.php";
	require_once "HealthCard.php";
	require_once "Appointment.php";	
	require_once "ScheduledAppointment.php";
	require_once "MessageManager.php";	
			
	class Profile extends CI_Controller
	{
		/* imageTableManager
		 *		- contains the TableManager that manages the image table of the database
		 */
		private $imageTableManager;
		
		
		/* patientTableManager
		 *		- contains the TableManager that manages the patient table of the database
		 */
		private $patientTableManager;
		
		/*	messageManager
		 *		- the object responsible for providing messages to be displayed to the site
		 */
		private $messageManager;
		
		
		/* constructor
		 */
		function __construct() {
			parent::__construct();
			$this -> imageTableManager 		= new ImageTableManager( $this, Image::TABLE_NAME, Patient::TRUE_ID);
			$this -> patientTableManager 	= new TableManager( $this, Patient::TABLE_NAME );
			$this -> messageManager			= new MessageManager();
			
			$this -> load -> helper(array('form', 'url'));
			
			$this -> load -> library('upload');
			$this -> load -> library('form_validation');
		}
		
		 
		/**
		 * Views a specific profile of a patient by his/her ID.
		 */
		function view($id)
		{
			$this->load->view('header.php');
			$this->load->view('navbar.php');
			$this->load->view('admit_sidebar.php');
			$this->load->view('footer.php');
			
			// Load error page if profile does not exist
			$array = array( Patient::TRUE_ID => $id );
			if( $this -> patientTableManager -> getNumOfRecords($array) == 0 ) {
				$this->load->view('error_page');
				return;
			}

			// Retrieve patient data 
			$this->db->where(Patient::TRUE_ID, $id);			
			$patientSQL = $this->db->get(Patient::TABLE_NAME);
			
			$data = array
			(
				"patient"		=> 	$patientSQL->row(),
				"contacts"		=>	array(),
				"healthcards"	=>	array(),
				"images"		=>	null,
				"dp"			=> 	null
			);
			
			// Get emergency contacts of patient
			$this->db->where(Patient::TRUE_ID, $id);	
			$sql = $this->db->get(EmergencyContact::TABLE_NAME);
			foreach ($sql->result() as $row)
			{
				$contact = new EmergencyContact($row);
				array_push($data["contacts"], $contact);
			}
			
			// Get health cards of patient
			$this->db->where(Patient::TRUE_ID, $id);	
			$sql = $this->db->get(HealthCard::TABLE_NAME);
			foreach ($sql->result() as $row)
			{
				$healthcard = new HealthCard($row);
				array_push($data["healthcards"], $healthcard);
			}
			
			// Get profile picture of patient
			$query = sprintf
			(
				"SELECT `%s`, `%s` 
				FROM `%s`
				WHERE `%s` = %d AND `%s` = %s",
				Image::TABLE_PROFILEID, Image::TABLE_IMAGEPATH,
				Image::TABLE_NAME,
				Image::TABLE_PROFILEID, $id,
				Image::TABLE_CATEGORY, Image::PROFILEPICTURE
			);
			$data["dp"] = $this->db->query($query)->row();
			
			// Get images of patient
			$query = sprintf
			(
				"SELECT *
				FROM `%s`
				WHERE `%s` = %d AND `%s` != %s",
				Image::TABLE_NAME,
				Image::TABLE_PROFILEID, $id,
				Image::TABLE_CATEGORY, Image::PROFILEPICTURE
			);
			$data["images"] = $this->db->query($query)->result();
			
			// Get schedules of patient
			$query = sprintf
			(
				"SELECT `%s`, `%s`, `%s`.`%s`
				 FROM `%s`, `%s`
				 WHERE `%s`.`%s` = `%s`.`%s` AND `%s`.`%s` = %d",
				 ScheduledAppointment::SCHEDULE_DATE, ScheduledAppointment::SCHEDULE_TIME, 
				 ScheduledAppointment::TABLE_NAME, ScheduledAppointment::STATUS,
				 ScheduledAppointment::TABLE_NAME, Patient::TABLE_NAME,
				 ScheduledAppointment::TABLE_NAME, ScheduledAppointment::TRUE_ID,
				 Patient::TABLE_NAME, Patient::TRUE_ID,
				 Patient::TABLE_NAME, Patient::TRUE_ID, $id
			);
			$data["schedules"] = $this->db->query($query)->result();
			
			// Get order IDs per visit num
			$query = sprintf
			(
				"SELECT `%s`, `%s`, `%s`
				 FROM `%s`, `%s`
				 WHERE 
					`%s`.`%s` = `%s`.`%s` AND
					`%s`.`%s` = %d",
					
				"order_date", "order_md", "order_id",
				
				"order_list", Appointment::TABLE_NAME,
				
				"order_list", "visit_num", Appointment::TABLE_NAME, Appointment::VISIT_NUMBER,
				Appointment::TABLE_NAME, Appointment::TRUE_ID, $id
			);
			$data["order_lists"] = $this->db->query($query)->result();
		
			// Get package IDs per orderID
			$query = sprintf
			(
				"SELECT DISTINCT `%s`.`%s`, `%s`.`%s`, `%s`, `%s`
				 FROM `%s`, `%s`, `%s`, `%s`
				 WHERE
					`%s`.`%s` = `%s`.`%s` AND
					`%s`.`%s` = `%s`.`%s` AND
					`%s`.`%s` = `%s`.`%s` AND
					`%s`.`%s` = %d",
					
				"order_list", "order_id", "order_line", "package_id", "quantity", "package_name",
				
				"packages", "order_line", "order_list", Appointment::TABLE_NAME,
				
				"packages", "package_id", "order_line", "package_id",
				"order_line", "order_id", "order_list", "order_id",
				"order_list", "visit_num", Appointment::TABLE_NAME, Appointment::VISIT_NUMBER,
				Appointment::TABLE_NAME, Appointment::TRUE_ID, $id
			);
			$data["packages"] = $this->db->query($query)->result();
			
			// Get products per package ID
			$query = sprintf
			(
				"SELECT DISTINCT `%s`.`%s`, `%s`, `%s`, `%s`.`%s`
				 FROM `%s`, `%s`, `%s`, `%s`, `%s`
				 WHERE
					`%s`.`%s` = `%s`.`%s` AND
					`%s`.`%s` = `%s`.`%s` AND
					`%s`.`%s` = `%s`.`%s` AND
					`%s`.`%s` = `%s`.`%s` AND
					`%s`.`%s` = %d",
					
				"package_products", "package_id", "product_name", "product_price", "package_products", "quantity",
				
				"products", "package_products", "order_line", "order_list", Appointment::TABLE_NAME,
				
				
				"products", "product_id", "package_products", "product_id",
				"package_products", "package_id", "order_line", "package_id",
				"order_line", "order_id", "order_list", "order_id",
				"order_list", "visit_num", Appointment::TABLE_NAME, Appointment::VISIT_NUMBER,
				Appointment::TABLE_NAME, Appointment::TRUE_ID, $id
			);
			$data["products"] = $this->db->query($query)->result();
			
			// Get past billings
			$query = sprintf
			(
				"SELECT `%s`, `%s`, `%s`
				 FROM `%s`, `%s`
				 WHERE
					`%s`.`%s` = `%s`.`%s` AND
					`%s`.`%s` = %d",
					
				"installment_no", "amout_deposited", "installment_date",
				
				"billing_archive", "patient_bills",
				
				"billing_archive", "bill_no", "patient_bills", "bill_no",
				"patient_bills", "true_id", $id
			);
			$data["billings"] = $this->db->query($query)->result();
				
			// Display patient profile
			$this->load->view('admit_view', $data);			
		}		
		
		/**
		 * Edits a specific profile of a patient by his/her ID.
		 */
		function edit($id)
		{
			$this->load->view('header.php');
			$this->load->view('navbar.php');
			$this->load->view('admit_sidebar.php');
			$this->load->view('footer.php');
			
			// Implies the patient ID does not exist
			$id = intval($id);
			$array = array( Patient::TRUE_ID => $id );
			if( $this -> patientTableManager -> getNumOfRecords($array) == 0 ) {
				$param = array( 
						"message" 	=> $this -> messageManager -> getMessage('invalid_record'),
						"linkName"	=> "Search Patient",
						"linkPath"	=> "".base_url()."search"
							);
				$this->load->view('error_page', $param);
				return;
			}
			
			$this->form_validation->set_message('alpha_dash_space', $this -> messageManager -> getMessage('form_alphaspace') );
			$this->form_validation->set_message('valid_dob', $this -> messageManager -> getMessage('invalid_date'));
			
			$listSex['dataSex'] = $this->input->get('sex');
			$listEduc['dataEduc'] = $this->input->get('educattainment');
			$listPwd['dataPwd'] = $this->input->get('pwd');
			$listHealth['dataHealth'] = $this->input->get('healthcard');
			
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
			
			// Implies the user has yet to submit a form
			if ($this->input->post("newCardSubmit") || $this->form_validation->run() == FALSE)
			{
				if ($this->input->post("newCardSubmit"))
				{
					$data = array
					(
						HealthCard::CARD_NAME	=>	$this->input->post(HealthCard::CARD_NAME)
					);
					
					$this->db->insert(HealthCard::LOOKUP_TABLE_NAME, $data);
				}
				
				// Get patient data
				$this->db->where(Patient::TRUE_ID, $id);			
				$patientSQL = $this->db->get(Patient::TABLE_NAME);
				$patient = $patientSQL->row();
		
				// Get emergency contacts of patient
				$this->db->where(EmergencyContact::TRUE_ID, $id);	
				$contactSQL = $this->db->get(EmergencyContact::TABLE_NAME);
				
				// Get health cards of patient
				$this->db->where(HealthCard::TRUE_ID, $id);	
				$healthSQL = $this->db->get(HealthCard::TABLE_NAME);
				
				// Get editable fields
				$data = array
				(
					"patient"	=> $patientSQL->row(),
					"contacts"	=> $contactSQL->result(),
					"cards"		=> $healthSQL->result(),
					"formaction"=> "$id"
				);
				
				// Display edit form
				$this->load->view('admit_form', $data);
				return;
			}
			
			// Get form values				
			$data = array
			(
				Patient::LAST_NAME			=>	htmlspecialchars( $this->input->post(Patient::LAST_NAME) ),
				Patient::FIRST_NAME			=>	htmlspecialchars( $this->input->post(Patient::FIRST_NAME) ),
				Patient::MIDDLE_NAME		=>	htmlspecialchars( $this->input->post(Patient::MIDDLE_NAME) ),
				Patient::SEX				=>	$this->input->post(Patient::SEX),
				Patient::BIRTHDAY			=>	htmlspecialchars( $this->input->post(Patient::BIRTHDAY) ),
				Patient::CONTACT_NUM		=>	htmlspecialchars( $this->input->post(Patient::CONTACT_NUM) ),
				Patient::ADDRESS			=>	htmlspecialchars( $this->input->post(Patient::ADDRESS) ),
				Patient::PHYSICIAN			=>	htmlspecialchars( $this->input->post(Patient::PHYSICIAN) ),
				Patient::NATIONALITY		=>	htmlspecialchars( $this->input->post(Patient::NATIONALITY) ),
				Patient::PWD				=>	$this->input->post(Patient::PWD),
				Patient::EDUC_ATTAINMENT	=>	$this->input->post(Patient::EDUC_ATTAINMENT)
			);
			
			// Set to update a certain patient record
			$this->db->where(Patient::TRUE_ID, $id);
			if ($this->db->update(Patient::TABLE_NAME, $data) == true)
			{
				// Delete old emergency contacts of patient
				$this->db->where(EmergencyContact::TRUE_ID, $id);
				$this->db->delete(EmergencyContact::TABLE_NAME);

				// Add emergency contacts into the database
				for ($i = 0; $i < 3; $i++)
				{
					$contactName = $this->input->post(EmergencyContact::CONTACT_NAME . $i);
					$contactNum = $this->input->post(EmergencyContact::CONTACT_NUM . $i);
					if (!empty($contactName) && !empty($contactNum))
					{
						$data = array
						(
							EmergencyContact::TRUE_ID		=>	$id,
							EmergencyContact::CONTACT_NAME	=>	htmlspecialchars( $contactName ),
							EmergencyContact::CONTACT_NUM	=>	htmlspecialchars( $contactNum )
						);
						
						$this->db->insert(EmergencyContact::TABLE_NAME, $data);
					}
				}
				
				// Delete old health cards of patient
				$this->db->where(HealthCard::TRUE_ID, $id);
				$this->db->delete(HealthCard::TABLE_NAME);
				
				// Add healthcards into the database				
				for ($i = 0; $i < 2; $i++)
				{
					$cardType = $this->input->post(HealthCard::CARD_TYPE . $i);
					$cardNum = $this->input->post(HealthCard::CARD_NUMBER . $i);
					
					if ($cardType != HealthCard::NONE && !empty($cardNum))
					{
						$data = array
						(
							HealthCard::TRUE_ID		=>	$id,
							HealthCard::CARD_TYPE	=>	$cardType,
							HealthCard::CARD_NUMBER	=>	htmlspecialchars( $cardNum )
						);
						
						$this->db->insert(HealthCard::TABLE_NAME, $data);
					}
				}
				
				$data["message"] = sprintf
				(
					$this -> messageManager -> getMessage('edit_success'),
					$id, PHP_EOL, $id
				);
				
				// ----- upload picture process start ----- 
				$dbManager 	= $this -> imageTableManager;
				
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
				$config['overwrite'] 		= true;
				
				$this->upload->initialize( $config );
				if ( $this->upload->do_upload( Image::HTML_FILE ) ) {
				
					$columns		= array(
											Image::TABLE_CATEGORY
										);
					$restrictions	= array(
											Image::TABLE_CATEGORY 	=> Image::PROFILEPICTURE,
											Image::TABLE_PROFILEID	=> $id
										);
					$resultQuery 	= $dbManager -> retrieveRecord($columns, $restrictions);
					
					$imagepath 		= "'" . "".base_url()."$dir" . ($this->upload->orig_name) . "'";
					if ( $resultQuery -> num_rows() > 0 ) {
						$updatedData		= array (
													Image::TABLE_IMAGEPATH 	=> $imagepath
												);
						
						$dbManager -> updateRecord($updatedData, $restrictions);
					} else {
						// Set data to be inserted in the table
						$imagedata['title'] 	= "'Profile Picture'";
						$imagedata['content'] 	= "'Profile Picture uploaded via Add Profile'";
						$imagedata['path'] 		= $imagepath;
						$imagedata['category']	= IMAGE::PROFILEPICTURE;
						$imagedata['tags']		= "";
						
						// Insert data to the database
						$dbManager -> addImageRecord($imagedata, $id);
					}
				
				}
				// ----- upload picture process end ----- 
				
				// Insert success page here
				$this->load->view('success_page', $data);
			}
			else
			{
				$array = array(
						"message"		=> $this -> messageManager -> getMessage('edit_fail'),
						"linkName"		=> "Go Back to Profile",
						"linkPath"		=> "".base_url()."profile/view/$id"
					);
				$this->load->view('error_page');
			}
		}
		
		/**
		 * Adds a specific patient to the consultation queue.
		 */
		function enqueue($id)
		{	
			$this->load->view('header.php');
			$this->load->view('navbar.php');
			$this->load->view('admit_sidebar.php');
			$this->load->view('footer.php');			
			
			// Retrieve patient data
			$this->db->where(Patient::TRUE_ID, $id);			
			$sql = $this->db->get("patients")->row();
			
			if ($sql != null)		// If patient with such ID exists
			{
				// Check if there's already an appointment entry with the same true ID
				$this->db->where(Patient::TRUE_ID, $id);			
				$sql = $this->db->get(Appointment::TABLE_NAME)->row();

				if ($sql == null)
				{
					// Set timezone to Manila
					date_default_timezone_set('Asia/Manila');
					
					// Get admit entry related data
					$data = array
					(
						Appointment::TRUE_ID			=>	$id,
						Appointment::APPOINTMENT_DATE	=>	date("Y-m-d"),
						Appointment::TIME_IN			=>	date("G:i:s")
					);
					
					// Add new queue entry
					if ($this->db->insert(Appointment::TABLE_NAME, $data))
					{												
						$data["message"] = sprintf
						(
							$this -> messageManager -> getMessage('queue_success'),
							PHP_EOL, $id
						);
						
						// Insert success page here
						$this->load->view('success_page', $data);
					}
					else
					{
						$array = array(
								"message" 		=> $this -> messageManager -> getMessage('queue_add_fail'),
								"linkName"		=> $this -> messageManager -> getMessage('go_back_to_profile'),
								"linkPath"		=> "".base_url()."profile/view/$id"
							);
						$this->load->view('error_page', $array);
					}
				}
				else
				{
					$array = array(
							"message" 		=> $this -> messageManager -> getMessage('patient_is_in_queue'),
							"linkName"		=> $this -> messageManager -> getMessage('go_back_to_profile'),
							"linkPath"		=> "".base_url()."profile/view/$id"
						);
					$this->load->view('error_page', $array);
				}
			}
			else
			{
				$array = array(
						"message" 		=> $this -> messageManager -> getMessage('invalid_record'),
					);
				$this->load->view('error_page', $array);
			}	
		}
		
		/**
		 *	Removes a specific patient from the consultation queue.
		 *
		 *	Not performing a proper discharge would entail that the
		 *	current appointment would not be archived.
		 */
		function dequeue($id)
		{	
			$this->load->view('header.php');
			$this->load->view('navbar.php');
			$this->load->view('admit_sidebar.php');
			$this->load->view('footer.php');
			
			// Get appointment data
			$this->db->where(Patient::TRUE_ID, $id);			
			$sql = $this->db->get(Appointment::TABLE_NAME)->row();
			
			
			if ($sql != null)		// If patient with such ID exists
			{				
				// Delete said appointment data
				$this->db->where(Patient::TRUE_ID, $id);
				if ($this->db->delete(Appointment::TABLE_NAME) == TRUE)
				{						
					$data["message"] = sprintf
					(
						$this -> messageManager -> getMessage('queue_success'),
						PHP_EOL, $id
					);
					
					$this->load->view("success_page", $data);
				}
				else
				{
					$array = array(
						'message' 	=> $this -> messageManager -> getMessage('queue_remove_fail'),
						'linkName'	=> "Go Back to Profile",
						'linkPath'	=> "".base_url()."profile/view/$id"
							);
					$this->load->view('error_page', $array);
				}
			}
			else
			{
				$array = array(
					'message' => $this -> messageManager -> getMessage('invalid_record')
						);
				$this->load->view('error_page', $array);
			}	
		}
		
		/**
		 *	Schedule an appointment for the patient.
		 */
		function schedule($id)
		{
			$this->load->view('header.php');
			$this->load->view('navbar.php');
			$this->load->view('admit_sidebar.php');
			$this->load->view('footer.php');
			
			if ($this->input->post("submit") != false)	// If user has yet to submit a form
			{
				// Get form values				
				$data = array
				(
					ScheduledAppointment::TRUE_ID		=>	$id,
					ScheduledAppointment::SCHEDULE_DATE	=>	htmlspecialchars( $this->input->post(ScheduledAppointment::SCHEDULE_DATE) ),
					ScheduledAppointment::SCHEDULE_TIME	=>	htmlspecialchars( $this->input->post(ScheduledAppointment::SCHEDULE_TIME) ),
					ScheduledAppointment::REMARKS		=>	htmlspecialchars( $this->input->post(ScheduledAppointment::REMARKS) )
				);
				
				
				if (!$this->valid_sched($data[ScheduledAppointment::SCHEDULE_DATE]))
				{
					$array = array(
						'message' 		=> $this -> messageManager -> getMessage('invalid_date'),
						'linkName'		=> $this -> messageManager -> getMessage('go_back_to_profile'),
						'linkPath' 		=> "".base_url()."profile/view/$id"
							);
					$this->load->view('error_page', $array);
					return;
				}
				
				
				if ($this->db->insert(ScheduledAppointment::TABLE_NAME, $data) == TRUE)
				{					
					$data["message"] = sprintf
					(
						$this -> messageManager -> getMessage('schedule_success'),
						PHP_EOL, $id
					);
					
					$this->load->view("success_page", $data);
				}
				else
				{
					$array = array(
						'message' 		=> $this -> messageManager -> getMessage('schedule_fail'),
						'linkName'		=> "Go Back to Profile",
						'linkPath' 		=> "".base_url()."profile/view/$id"
							);
					$this->load->view('error_page', $array);
				}	
			}
			else
			{
				$array = array(
					'message' 		=> $this -> messageManager -> getMessage('invalid_date'),
					'linkName'		=> "Go Back to Profile",
					'linkPath' 		=> "".base_url()."profile/view/$id"
						);
				$this->load->view('error_page', $array);
			}			
		}
		
		/**
		 *	Cancel a scheduled appointment of the patient.
		 */
		public function unschedule($schedID)
		{	
			$this->load->view('header.php');
			$this->load->view('navbar.php');
			$this->load->view('admit_sidebar.php');
			$this->load->view('footer.php');
			
			// Get scheduled appointment data
			$this->db->where(ScheduledAppointment::SCHEDULE_ID, $schedID);			
			$sql = $this->db->get(ScheduledAppointment::TABLE_NAME)->row();
			
			
			if ($sql != null)		// If patient with such ID exists
			{				
				// Get patient true ID
				$id = $sql->{ScheduledAppointment::TRUE_ID};
				$this->db->where(ScheduledAppointment::SCHEDULE_ID, $schedID);
		
				$status = ScheduledAppointment::getStatus($sql->{ScheduledAppointment::STATUS}, $sql->{ScheduledAppointment::SCHEDULE_DATE});
				if ($status == ScheduledAppointment::OVERDUE)
				{
					$this->db->delete(ScheduledAppointment::TABLE_NAME);
				}
				else
				{
					// Update schedule
					$data = array
					(
						ScheduledAppointment::STATUS	=>	ScheduledAppointment::CANCELLED
					);
					
					$this->db->update(ScheduledAppointment::TABLE_NAME, $data);
				}
				
				$data["message"] = sprintf
				(
					$this -> messageManager -> getMessage('schedule_success'),
					PHP_EOL, $id
				);
				
				$this->load->view("success_page", $data);
			}
			else
			{
				$array = array(
					'message' 		=> $this -> messageManager -> getMessage('schedule_fail'),
					'linkName'		=> $this -> messageManager -> getMessage('go_back_to_profile'),
					'linkPath' 		=> "".base_url()."profile/view/$id"
						);
				$this->load->view('error_page', $array);
			}
		}
		
		public function upload($id)
		{
			$this->load->view('header.php');
			$this->load->view('navbar.php');
			$this->load->view('admit_sidebar.php');
			$this->load->view('footer.php');
			
			if ( $this -> input -> post( Image::HTML_SUBMITBUTTON ) == false ) {
				$array = array(
					'message' 		=> $this -> messageManager -> getMessage('no_direct_access'),
						);
				$this->load->view('error_page', $array);
				return;
			}
			
			$dbManager = $this -> imageTableManager;
				
			// Get number of records (current image ID)
			$imageName = Image::getFilename();
			$dir = Image::getDirectory($id);
			
			// Create specific patient folder, if it doesnt exist
			if (!is_dir(".$dir")) {
				mkdir(".$dir", 0755, true);
			}
			
			// Set config attributes
			$config['upload_path'] 		= ".$dir";
			$config['allowed_types'] 	= 'gif|jpg|png';
			$config['file_name'] 		= $imageName;
			
			$this->upload->initialize( $config );			
			if ( $this->upload->do_upload( Image::HTML_FILE ) ) 
			{
				// Set data to be inserted in the table
				$imagedata['title'] 	= "'" . htmlspecialchars( $this -> input -> post( Image::HTML_TITLE ) ) 	. "'";
				$imagedata['content'] 	= "'" . htmlspecialchars( $this -> input -> post( Image::HTML_CONTENT ) )	. "'";
				$imagedata['path'] 		= "'" . "".base_url()."$dir" . ($this->upload->orig_name) 							. "'";
				$imagedata['category']	= $this -> input -> post( Image::HTML_CATEGORY );
				$imagedata['tags']		= $this -> input -> post( Image::HTML_TAGS );
				
				// Insert data to the database
				$dbManager -> addImageRecord($imagedata, $id);
				
				$data["message"] = sprintf
				(
					$this -> messageManager -> getMessage('upload_success'),
					$id, PHP_EOL, $id
				);
				$this->load->view("success_page", $data);
			}
			else
			{
				$array = array(
					'message' 		=> $this -> messageManager -> getMessage('upload_fail'),
					'linkName'		=> "Go Back to Profile",
					'linkPath'		=> "".base_url()."profile/view/$id"
						);
				$this->load->view('error_page', $array);
			}
		}
		
		function alpha_dash_space($str)
		{
			return ( ! preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;
		} 
		
		function valid_dob($inputdate)
		{
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
			$today = new DateTime();
			$sched = new DateTime($inputsched);
			
			$max = new DateTime("2038-01-19");
			
			if ($sched > $max || $sched < $today)
				return FALSE;
			else
				return TRUE;

		}
		
		function validDate($date, $format = 'Y-m-d H:i:s')
		{
			$d = DateTime::createFromFormat($format, $date);
			
			$min = new DateTime("1901-12-14");
			$max = new DateTime("2038-01-20");
			return $d && $d->format($format) == $date && ($d > $min && $d < $max);
		}
	}
?>