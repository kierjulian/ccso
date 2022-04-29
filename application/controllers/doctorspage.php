<?php

	class DoctorsPage extends CI_Controller {
		public function index () {
			if(! $this->session->userdata("logged_in")){
				redirect(base_url() . "main/");
			}
			
			if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}

			$this->load->view('doctorspage_view.php', $data);
		}	
	}
?>
