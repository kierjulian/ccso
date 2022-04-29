<?php 

class Control extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{	
		redirect(base_url() . "main/");
	}
}
/* End of file control.php */
/* Location: ./application/controllers/control.php */