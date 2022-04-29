<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class User extends CI_Controller 
	{
		public function index()
		{	
			if(! $this->session->userdata("logged_in")){
				redirect(base_url() . "main/");
			}
			
			if(!$this->session->userdata("acsUse")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		
			$this->load->view('header.php');
			$this->load->view('navbar.php');
			$this->load->view('user_sidebar.php');
			$this->load->view('footer.php');
			
			$config = array(
				    'fname' => array(
						 'field'   => 'fname', 
						 'label'   => 'First Name', 
						 'rules'   => 'required|max_length[20]|trim|callback_alpha_dash_space'
					  ),
				    'mname' => array(
						 'field'   => 'mname', 
						 'label'   => 'Middle Name', 
						 'rules'   => 'required|max_length[20]|trim|callback_alpha_dash_space'
					  ),
					'lname' => array(
						 'field'   => 'lname', 
						 'label'   => 'Last Name', 
						 'rules'   => 'required|max_length[20]|trim|callback_alpha_dash_space'
					  ),
				    'sex' => array(
						 'field'   => 'sex', 
						 'label'   => 'Sex', 
						 'rules'   => 'required'
					  ),
					'haddr' => array(
						 'field'   => 'haddr', 
						 'label'   => 'Mailing Address', 
						 'rules'   => 'max_length[75]'
					  ),
					'eaddr' => array(
					     'field' => "eaddr",
						 'label' => 'Email',
						 'rules' => 'required|valid_email|callback_email_is_taken'
					  ),
					'cnum' => array(
						 'field'   => 'cnum', 
						 'label'   => 'Contact Number', 
						 'rules'   => 'required|numeric|max_length[20]'
					  ),
					'uname' => array(
					     'field' => 'uname',
						 'label' => 'Username',
						 'rules' => 'required|max_length[20]|min_length[6]|callback_username_is_taken'
					  ),
					'pass' => array(
						 'field' => 'pass',
						 'label' => 'Password',
					     'rules' => 'required|max_length[20]|min_length[6]'
					  ),
					'cpass' => array(
						 'field' => 'cpass',
						 'label' => 'Confirm Password',
					     'rules' => 'required|matches[pass]'
					  ),
					'position' => array(
						 'field' => 'position[]',
						 'label' => 'Job Position',
					     'rules' => 'required'
					  ),
					'doe' => array(
						 'field'   => 'doe', 
						 'label'   => 'Date of Employment', 
						 'rules'   => 'required|callback_valid_dob'
					  ),
					'mpos' => array(
						 'field' => 'mpos',
						 'label' => 'Medical Position',
					     'rules' => 'max_length[20]'
					  ),
					'prc' => array(
						 'field'   => 'prc', 
						 'label'   => 'PRC Number', 
						 'rules'   => 'numeric|max_length[5]|min_length[5]'
					  ),
				);
				
				
			$this->form_validation->set_rules($config);
			
			if ($this->form_validation->run() == FALSE)
			{
				$query = "SELECT * FROM job_module";
				$moduleSQL = $this->db->query($query);
				$data["modules"] = $moduleSQL->result();
			
				$this->load->view('userform.php', $data);
				return;
			} else{
				$form = array();
				$form['fName'] = $this->input->post("fname");
				$form['mName'] = $this->input->post("mname");
				$form['lName'] = $this->input->post("lname");
				$form['sex'] = $this->input->post("sex");
				$form['hAddr'] = $this->input->post("haddr");
				$form['eAddr'] = $this->input->post("eaddr");
				$form['contactNo'] = $this->input->post("cnum");
				$form['uName'] = $this->input->post("uname");
					$md5Pass = $this->input->post("pass");
					$md5Pass = md5($md5Pass);
				$form['pWord'] = $md5Pass;				
				$form['doe'] = $this->input->post("doe");
				$form['pos'] = $this->input->post("mpos");
				$form['prcNum'] = $this->input->post("prc");
				
				if ($this->db->insert('doctors_list', $form) == TRUE){
					$this->db->where('uName', $form['uName']);			
					$userSQL = $this->db->get('doctors_list');
					$user = $userSQL->row(); 
					
					$form2 = array();
					$form2['idDoc'] = $user->idDoc;
					foreach($this->input->post("position") as $position){
						$form2['job_id'] = $position;
						$this->db->insert('user_job', $form2);
					}
					$data["message"] = sprintf("User %s is added. Redirecting to View Users.", $form['uName']);
					$data["url"] = base_url().'user/view_users';
					$this->load->view('user_success', $data);
				} else{
					$this->load->view('error_page');
				}
			}
		}
		
		function alpha_dash_space($str)
		{
			return ( ! preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;
		} 
		
		public function username_is_taken($input) {
			$query = "SELECT * FROM `doctors_list` WHERE `uName` = ?";
			$arg = array($input);
			$exec = $this->db->query($query, $arg) or die(mysql_error());
			if ($exec->num_rows() > 0) {
			//username is taken
				$this->form_validation->set_message('username_is_taken', 'Sorry, the username ' . $input . ' is already assigned to someone else.');
            return FALSE;
			} else {
			//username is available
				return TRUE;
			}
		}

		public function email_is_taken($input) {
			$query = "SELECT * FROM `doctors_list` WHERE `eAddr` = ?";
			$arg = array($input);
			$exec = $this->db->query($query, $arg) or die(mysql_error());
			if ($exec->num_rows() > 0) {
			//email is taken
				$this->form_validation->set_message('email_is_taken', 'Sorry, the email ' . $input . ' is already assigned to someone else.');
				return FALSE;
			} else {
			//email is available
            return TRUE;
			}
		}
		
		public function job_name_already_exist($input) {
			$query = "SELECT * FROM `job_module` WHERE `job_name` = ?";
			$arg = array($input);
			$exec = $this->db->query($query, $arg) or die(mysql_error());
			if ($exec->num_rows() > 0) {
			//jobname is taken
				$this->form_validation->set_message('job_name_already_exist', 'Sorry, the job name ' . $input . ' is already declared.');
				return FALSE;
			} else {
			//jobname is available
            return TRUE;
			}
		}
		
		function valid_dob($inputdate)
		{
			$today = new DateTime();
			$dob = new DateTime($inputdate);
			
			if ($dob > $today)
				return FALSE;
			else
				return TRUE;

		} 
		
		public function view_users(){
			if(! $this->session->userdata("logged_in")){
				redirect(base_url() . "main/");
			}
			
			if(!$this->session->userdata("acsUse")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
			
			$this->load->view('header.php');
			$this->load->view('navbar.php');
			$this->load->view('user_sidebar.php');
			$this->load->view('footer.php');
			
			$query = "SELECT * FROM doctors_list";
			$userSQL = $this->db->query($query);
			$users = $userSQL->result();
			
			$item = array();
			
			foreach($users as $user){
				$query = "SELECT user_job.job_id, job_name FROM user_job, job_module WHERE user_job.job_id = job_module.job_id AND idDoc=" . $user->idDoc;
				$jobSQL = $this->db->query($query);
				$jobs = $jobSQL->result();
				$item[$user->idDoc] = array('user' => $user, 'jobs' => $jobs);
			}
			
			$data['users'] = $item;
			
			$this->load->view("userlist.php", $data);
		}
		
		public function delete_user($id){
			if(! $this->session->userdata("logged_in")){
				redirect(base_url() . "main/");
			}
			
			if(!$this->session->userdata("acsUse")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
			
			$this->load->view('header.php');
			$this->load->view('navbar.php');
			$this->load->view('user_sidebar.php');
			$this->load->view('footer.php');
			
			
			if($this->session->userdata("id") == $id){
				$this->load->view('error_page');
				return;
			}
			
			$query = "SELECT * FROM user_job WHERE job_id = 1";
			$userSQL = $this->db->query($query);
			$users = $userSQL->result();
			$issuper = false;
			foreach($users as $user){
				if($user->idDoc == $id){
					$issuper = true;
				}
			}
			if(count($users) > 1 || !$issuper){
				$query = "DELETE FROM doctors_list WHERE idDoc = " . $id;
				if($this->db->query($query) == true){
					$data["message"] = sprintf("User number: %s is deleted from the users list. Redirecting to View Users.", $id);
					$data["url"] = base_url().'user/view_users';
					$this->load->view('user_success', $data);
				} else{
					$this->load->view('error_page');
				}
			} else{
				$this->load->view('error_page');
			}
		}
		
		public function edit_user($id)
		{	
			if(! $this->session->userdata("logged_in")){
				redirect(base_url() . "main/");
			}
			
			$this->load->view('header.php');
			$this->load->view('navbar.php');
			$this->load->view('user_sidebar.php');
			$this->load->view('footer.php');
			
			$config = array(
				    'fname' => array(
						 'field'   => 'fname', 
						 'label'   => 'First Name', 
						 'rules'   => 'required|max_length[20]|trim|callback_alpha_dash_space'
					  ),
				    'mname' => array(
						 'field'   => 'mname', 
						 'label'   => 'Middle Name', 
						 'rules'   => 'required|max_length[20]|trim|callback_alpha_dash_space'
					  ),
					'lname' => array(
						 'field'   => 'lname', 
						 'label'   => 'Last Name', 
						 'rules'   => 'required|max_length[20]|trim|callback_alpha_dash_space'
					  ),
				    'sex' => array(
						 'field'   => 'sex', 
						 'label'   => 'Sex', 
						 'rules'   => 'required'
					  ),
					'haddr' => array(
						 'field'   => 'haddr', 
						 'label'   => 'Mailing Address', 
						 'rules'   => 'max_length[75]'
					  ),
					'eaddr' => array(
					     'field' => "eaddr",
						 'label' => 'Email',
						 'rules' => 'required|valid_email'
					  ),
					'cnum' => array(
						 'field'   => 'cnum', 
						 'label'   => 'Contact Number', 
						 'rules'   => 'required|numeric|max_length[20]'
					  ),
					'uname' => array(
					     'field' => 'uname',
						 'label' => 'Username',
						 'rules' => 'required|max_length[20]|min_length[6]'
					  ),
					'position' => array(
						 'field' => 'position[]',
						 'label' => 'Job Position',
					     'rules' => 'required'
					  ),
					'doe' => array(
						 'field'   => 'doe', 
						 'label'   => 'Date of Employment', 
						 'rules'   => 'required|callback_valid_dob'
					  ),
					'mpos' => array(
						 'field' => 'mpos',
						 'label' => 'Medical Position',
					     'rules' => 'max_length[20]'
					  ),
					'prc' => array(
						 'field'   => 'prc', 
						 'label'   => 'PRC Number', 
						 'rules'   => 'numeric|max_length[5]|min_length[5]'
					  ),
				);
				
				
			$this->form_validation->set_rules($config);
			
			$query = "SELECT * FROM `doctors_list` WHERE `idDoc` = ?";
			$arg = array($id);
			$exec = $this->db->query($query, $arg) or die(mysql_error());
			if ($exec->num_rows() <= 0){	
				$this->load->view('error_page');
				return;
			}
				
			if ($this->form_validation->run() == FALSE){
				$this->db->where('idDoc', $id);			
				$userSQL = $this->db->get('doctors_list');
				$data['user'] = $userSQL->row();
				
				$query = "SELECT * FROM job_module";
				$moduleSQL = $this->db->query($query);
				$data["modules"] = $moduleSQL->result();
				
				$this->db->where('idDoc', $id);			
				$jobSQL = $this->db->get('user_job');
				$data['jobs'] = $jobSQL->result();
				
				$this->load->view('userform.php', $data);
				return;
			}
			
			$form = array();
			$form['fName'] = $this->input->post("fname");
			$form['mName'] = $this->input->post("mname");
			$form['lName'] = $this->input->post("lname");
			$form['sex'] = $this->input->post("sex");
			$form['hAddr'] = $this->input->post("haddr");
			$form['eAddr'] = $this->input->post("eaddr");
			$form['contactNo'] = $this->input->post("cnum");
			$form['uName'] = $this->input->post("uname");
				$md5Pass = $this->input->post("pass");
				$md5Pass = md5($md5Pass);
			$form['doe'] = $this->input->post("doe");
			$form['pos'] = $this->input->post("mpos");
			$form['prcNum'] = $this->input->post("prc");
			foreach($this->input->post("position") as $position){
	
			}
			
			
			if ($this->db->where('idDoc', $id) && $this->db->update('doctors_list', $form) == TRUE){
				$form2 = array();
				$form2['idDoc'] = $id;
				
				$query = "DELETE FROM user_job WHERE idDoc = " . $id;
				
				if($this->db->query($query) == true){
					foreach($this->input->post("position") as $position){
						$form2['job_id'] = $position;
						$this->db->insert('user_job', $form2);
					}
					$data["message"] = sprintf("User %s is updated. Redirecting to View Users.", $form['uName']);
					$data["url"] = base_url().'user/view_users';
				} else{
					$this->load->view('error_page');
					return;
				}
				
				if($this->session->userdata("id") == $id){
					$this->session->set_userdata("username", $form['uName']);
				}
				
				$this->load->view('user_success', $data);
			} else{
				$this->load->view('error_page');
				return;
			}
		}
		
		public function job()
		{	
			if(! $this->session->userdata("logged_in")){
				redirect(base_url() . "main/");
			}
			
			if(!$this->session->userdata("acsUse")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
			
			$this->load->view('header.php');
			$this->load->view('navbar.php');
			$this->load->view('user_sidebar.php');
			$this->load->view('footer.php');
			
			$config = array(
				    'jobname' => array(
						 'field'   => 'jname', 
						 'label'   => 'Job Name', 
						 'rules'   => 'required|max_length[30]|trim|callback_alpha_dash_space|callback_job_name_already_exist'
					  ),
					'module' => array(
						 'field'   => 'module[]', 
						 'label'   => 'Module', 
						 'rules'   => 'required'
					  ),
				);
				
				
			$this->form_validation->set_rules($config);
			
			if ($this->form_validation->run() == FALSE){
				$this->load->view('jobform.php');
				return;
			}
			
			$form = array();
			$form['job_name'] = $this->input->post("jname");
			$form['acsAdm'] = 0;
			$form['acsDP'] = 0;
			$form['acsCO'] = 0;
			$form['acsBil'] = 0;
			$form['acsDis'] = 0;
			foreach($this->input->post("module") as $module){
				switch($module){
					case 'admission': $form['acsAdm'] = 1;
						break;
					case 'doctorsPage': $form['acsDP'] = 1;
						break;
					case 'clinicalOrder': $form['acsCO'] = 1;
						break;
					case 'discharge': $form['acsDis'] = 1;
						break;
					case 'billing': $form['acsBil'] = 1;
						break;
				}
			}
			
			if ($this->db->insert('job_module', $form) == TRUE){
				$data["message"] = sprintf("Job %s is added. Redirecting to View Users.", $form['job_name']);
				$data["url"] = base_url().'user/view_users';
				
				$this->load->view('user_success', $data);
			} else{
				$this->load->view('error_page');
			}
		}
				
	}