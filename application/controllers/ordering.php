<?php

	class Ordering extends CI_Controller {
		function __construct() {
	        parent::__construct();

	        // load library
	        $this->load->library(array('table', 'form_validation'));

	        // load helper
	        $this->load->helper('url');

	        // load model
	        $this->load->model('Patient_model', '', TRUE);

	        $this->clear_cache();
	    }

	    function clear_cache() {
	        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
	        $this->output->set_header("Pragma: no-cache");
	    }

		public function index () {
			if(! $this->session->userdata("logged_in")){
				redirect(base_url() . "main/");
			}

			$sql = 'SELECT * FROM `products` WHERE `PRODUCT_ID` = 1';
			$sql = $this->db->query($sql) or die(mysql_error());
			
			$products= $sql->result();

			foreach ($products as $product) {
				$data['name'] = $product->PRODUCT_NAME;
				$data['desc'] = $product->PRODUCT_DESC;

			}
			

			$this->load->view('ordering_view.php', $data);
		}	
	}
?>
