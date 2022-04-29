<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{	
		if(! $this->session->userdata("logged_in")){
		redirect(base_url() . "main/");
		}

		$this->load->view('header.php');
		$this->load->view('navbar.php');
		$this->load->view('home_sidebar.php');
		$this->load->view('about.php');
		$this->load->view('footer.php');
	}

	public function about()
	{	
		if(! $this->session->userdata("logged_in")){
			redirect(base_url() . "main/");
		}
		$this->load->view('header.php');
		$this->load->view('navbar.php');
		$this->load->view('home_sidebar.php');
		$this->load->view('about.php');
		$this->load->view('footer.php');
	}

	public function contacts()
	{
		if(! $this->session->userdata("logged_in")){
			redirect(base_url() . "main/");
		}
		$this->load->view('header.php');
		$this->load->view('navbar.php');
		$this->load->view('home_sidebar.php');
		$this->load->view('contacts.php');
		$this->load->view('footer.php');
	}

	public function help()
	{
		if(! $this->session->userdata("logged_in")){
			redirect(base_url() . "main/");
		}
		$this->load->view('header.php');
		$this->load->view('navbar.php');
		$this->load->view('home_sidebar.php');
		$this->load->view('usermanual.php');
		$this->load->view('footer.php');
	}
}