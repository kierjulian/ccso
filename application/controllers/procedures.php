<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procedures extends CI_Controller 
{
	// num of records per page
    private $limit = 10;
	private $procedure_price = 0;
	
	function __construct()
	{
		parent::__construct();
		
		// load library
        $this->load->library(array('table', 'form_validation', 'session'));

        // load helper
        $this->load->helper('url');
		
		$tmpl = array ('table_open'  => '<table class="table table-striped table-advance table-hover table-condensed">');
		$this->table->set_template($tmpl);

        // load model
        $this->load->model('Procedure_model', '', TRUE);

        $this->clear_cache();
	}
	
	function clear_cache() {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }
	
	public function index($visit_num, $offset = 0)
	{	
		$this->session->set_userdata("visit", $visit_num);
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
		
		if($this->session->userdata('procedure_package') == NULL){
			$this->session->set_userdata('procedure_package', array());
			$this->session->set_userdata('procedure_order', array());
			$this->session->set_userdata('procedure_price', 0);
		}
		
		$procedure = new stdClass();
        // offset
        $uri_segment = 4;
        $offset = $this->uri->segment($uri_segment);

        // load data
        $procedures = $this->Procedure_model->get_paged_list($this->limit, $offset)->result();
		
        // generate pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('procedures/index/'.$visit_num.'/');
        $config['total_rows'] = $this->Procedure_model->count_all();
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        // generate table data
        $this->load->library('table');
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('RVS Code', 'Description', 'Case Rate', 'Professional Fee', 'Health Care Institution Fee', 'Action');
        foreach ($procedures as $procedure) {
            $this->table->add_row($procedure->rvs_code, $procedure->description, $procedure->case_rate, $procedure->professional_fee,$procedure->hic_fee , anchor('/procedures/add_procedures/'.$visit_num.'/'.$procedure->rvs_code, 'Add', ''));
        }
		
        $data['table'] = $this->table->generate();
		$data['procedure_price'] = $this->session->userdata('procedure_price');
		$data['procedure_package'] = $this->fetch_procedure_for_manage('manage', $visit_num);

        // load view
		$data['visit_num'] = $visit_num;
		$this->load_views();
		$this->load->view('doc_sidebar.php', $data);
		$this->load->view('procedure_page.php', $data);
	}

	function success($visit_num) {
		$sql = "SELECT fName, lName from `doctors_list` where uName = '".$this->session->userdata('username')."'";
		$sql = $this->db->query($sql) or die(mysql_error());
		$doc = $sql->result()[0];
		$docname = $doc->fName." ".$doc->lName;
		
		$sql = "INSERT INTO `order_list` (VISIT_NUM, ORDER_MD) VALUES (".$visit_num.", '".mysql_real_escape_string($docname)."')";
		$sql = $this->db->query($sql) or die(mysql_error());

		$order_id = $this->db->insert_id();
		foreach ($this->session->userdata('procedure_order') as $packprod) {
		    $sql = "INSERT INTO `order_line` VALUES (".$order_id.", ".$packprod[0].", ".$packprod[2].")";
			$sql = $this->db->query($sql) or die(mysql_error());
		}

    	$data['message'] = "Outside procedures finalized.";
    	$data['redir'] = anchor('/procedures/index/'.$visit_num.'/', 'Add more outside procedures', '');
		
		$this->session->unset_userdata('procedure_package');
		$this->session->unset_userdata('procedure_order');
		$this->session->unset_userdata('procedure_price');

		$this->load_views();
		$data['visit_num'] = $visit_num;
		$this->load->view('doc_sidebar.php', $data);
		$this->load->view('procedure_success.php', $data);
	}
	
	function load_views() {
		$this->load->view('header.php');			
		$this->load->view('navbar.php');
		$this->load->view('footer.php');
	}
	
	function add_procedures($visit_num, $rvs){
		$query = $rvs;

		$sql = "SELECT * FROM `packages` where PACKAGE_TYPE='P' and PACKAGE_NAME=".$query;
		$sql = $this->db->query($sql) or die(mysql_error());
		$procedure_ord = $sql->result()[0];

		if ($this->is_in_order($procedure_ord->PACKAGE_ID)==-1) {
			$temp_pack = $this->session->userdata('procedure_package');

			$sql = "SELECT * FROM `outside_procedures` where rvs_code=".$query;
			$sql = $this->db->query($sql) or die(mysql_error());
			$procedure = $sql->result()[0];

			array_push($temp_pack, array($procedure->rvs_code, $procedure->description,$procedure->case_rate,$procedure->professional_fee,$procedure->hic_fee));

			$this->session->set_userdata('procedure_package', $temp_pack);
			$this->session->set_userdata('procedure_price', $this->get_proc_price());

			$temp_order = $this->session->userdata('procedure_order');

			array_push($temp_order, array($procedure_ord->PACKAGE_ID,$procedure_ord->PACKAGE_NAME,1,$procedure_ord->PACKAGE_PRICE));
			$this->session->set_userdata('procedure_order', $temp_order);
		}

		
		/* table making gawin mo na lang na unction later */
		$procedure = new stdClass();
        // offset
        $uri_segment = 5;
        $offset = $this->uri->segment($uri_segment);

        // load data
        $procedures = $this->Procedure_model->get_paged_list($this->limit, $offset)->result();

        // generate pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('procedures/index/'.$visit_num.'/');
        $config['total_rows'] = $this->Procedure_model->count_all();
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        // generate table data
        $this->load->library('table');
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('RVS Code', 'Description', 'Case Rate', 'Professional Fee', 'Health Care Institution Fee', 'Action');
        foreach ($procedures as $procedure) {
            $this->table->add_row($procedure->rvs_code, $procedure->description, $procedure->case_rate, $procedure->professional_fee,$procedure->hic_fee,  anchor('/procedures/add_procedures/'.$visit_num.'/'.$procedure->rvs_code, 'Add', ''));
        }
		
        $data['table'] = $this->table->generate();
		//till here
		
		
		$data['procedure_price'] = $this->session->userdata('procedure_price');
		$data['procedure_package'] = $this->fetch_procedure_for_manage('manage', $visit_num);
		$data['visit_num'] = $visit_num;
		$this->load_views();
		$this->load->view('doc_sidebar.php', $data);
		$this->load->view('procedure_page.php', $data);
	}

    function is_in_order ($id) {
    	$temp_order = $this->session->userdata('procedure_order');
    	$ret = -1;
    	for ($ctr=0;$ctr<count($temp_order);$ctr++) {
    		if ($temp_order[$ctr][0]==$id) {
    			$ret = $ctr;
    		}
    	}
    	return $ret;
    }	

	function remove_procedure($visit_num, $rvs){
		$temp_pack = $this->session->userdata('procedure_package');
		$new_pack = array();
		foreach ($temp_pack as $product) {
			if ($product[0]!=$rvs) {
				array_push($new_pack, $product);
			}
		}
		
		$this->session->set_userdata('procedure_package', $new_pack);

		$temp_order = $this->session->userdata('procedure_order');
		$new_order = array();
		foreach ($temp_pack as $product) {
			if ($product[1]!=$rvs) {
				array_push($new_order, $product);
			}
		}
		
		$this->session->set_userdata('procedure_order', $new_order);
		
		$procedure = new stdClass();
        // offset
        $uri_segment = 5;
        $offset = $this->uri->segment($uri_segment);

        // load data
        $procedures = $this->Procedure_model->get_paged_list($this->limit, $offset)->result();

        // generate pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('procedures/index/remove_procedure/'.$visit_num.'/');
        $config['total_rows'] = $this->Procedure_model->count_all();
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        // generate table data
        $this->load->library('table');
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('RVS Code', 'Description', 'Case Rate', 'Professional Fee', 'Health Care Institution Fee','Action');
        foreach ($procedures as $procedure) {
            $this->table->add_row($procedure->rvs_code, $procedure->description, $procedure->case_rate, $procedure->professional_fee,$procedure->hic_fee, anchor('/procedures/add_procedures/'.$visit_num.'/'.$procedure->rvs_code, 'Add', ''));
        }
		
        $data['table'] = $this->table->generate();
		
		$this->session->set_userdata('procedure_price', $this->get_proc_price());
		$data['procedure_price'] = $this->session->userdata('procedure_price');

		$data['procedure_package'] = $this->fetch_procedure_for_manage('manage', $visit_num);
        
		$data['visit_num'] = $visit_num;
		$this->load_views();
		$this->load->view('doc_sidebar.php', $data);
		$this->load->view('procedure_page.php', $data);
		
	}
	
	function fetch_procedure_for_manage($mode, $visit_num) {
		if (($this->session->userdata('procedure_package'))) {
			$this->table->set_empty("&nbsp;");
			$temp_proc = $this->session->userdata('procedure_package');
			if($mode=='manage') {
		        $this->table->set_heading('RVS Code', 'Description', 'Case Rate', 'Professional Fee', 'HIC Fee', 'Actions');
		        foreach ($temp_proc as $product) {
		        	$this->table->add_row($product[0], $product[1], $product[2], $product[3], $product[4], anchor('/procedures/remove_procedure/'.$visit_num.'/'.$product[0], 'remove', ''));
		        }
			} elseif ($mode=='confirm') {
				$this->table->set_heading('RVS Code', 'Description', 'Case Rate', 'Professional Fee', 'HIC Fee', 'Actions');
		        foreach ($temp_proc as $product) {
		        	$this->table->add_row($product[0], $product[1], $product[2], $product[3], $product[4]);
		        }
			}
	        return $this->table->generate();
		} else {
			return '<i class="fa fa-dropbox"></i><span>Add items to package</span>';
		}
    		
    }
	
	function get_proc_price() {
    	$price = 0;
		$temp = $this->session->userdata('procedure_package');
		
		if(($this->session->userdata('procedure_package'))!= ''){
			foreach ($temp as $packprod) {
				$temp_price = $packprod[2];
				if(preg_match("/^[0-9,]+$/", $temp_price)) $temp_price = str_replace(',', '', $temp_price);
				$price += $temp_price;
			}
		}
		return $price;
    }
	
	function cancel_procedure($visit_num) {
	    $data['message'] = "Addition of procedures is cancelled.";
	    $data['redir'] = anchor("/procedures/index/".$visit_num, 'Back to Outside Procedures', '');

    	$this->session->unset_userdata('procedure_package');
    	$this->session->unset_userdata('procedure_price');
		$data['visit_num'] = $visit_num;
		$this->load_views();
		$this->load->view('doc_sidebar.php', $data);
		$this->load->view('procedure_cancel.php', $data);
  	}
	
	public function search($visit_num)
	{
		// Starting query w/ no restrictions
		$sql = "SELECT distinct * FROM `outside_procedures`";
		
		// If a query is submitted by the user (may not be all users)
		if ($this->input->post('submit_search') != FALSE)	
		{
			// Get query filters
			$input = $this->input->POST('search_query');
			$queryType = $this->input->POST('searchType');
			
			// Update SQL query string
			$sql = $sql . " WHERE `$queryType` LIKE '%$input%'";
		}
		
		$procedure = new stdClass();
        // offset
        $uri_segment = 4;
        $offset = $this->uri->segment($uri_segment);

        // load data
		$sql = $this->db->query($sql) or die(mysql_error());
        $procedures = $sql->result();

        // generate pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('procedures/index/'.$visit_num.'/');
        $config['total_rows'] = $this->Procedure_model->count_all();
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        // generate table data
        $this->load->library('table');
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('RVS Code', 'Description', 'Case Rate', 'Professional Fee', 'Health Care Institution Fee','Action');
        foreach ($procedures as $procedure) {
            $this->table->add_row($procedure->rvs_code, $procedure->description, $procedure->case_rate, $procedure->professional_fee,$procedure->hic_fee,anchor('/procedures/add_procedures/'.$visit_num.'/'.$procedure->rvs_code, 'Add', ''));
        }
        $data['table'] = $this->table->generate();
		
		$this->session->set_userdata('procedure_price', $this->get_proc_price());
		$data['procedure_price'] = $this->get_proc_price();

		$data['procedure_package'] = $this->fetch_procedure_for_manage('manage', $visit_num);
		// load view
		$data['visit_num'] = $visit_num;
		$this->load_views();
		$this->load->view('doc_sidebar.php', $data);
		$this->load->view('procedure_page.php', $data);

	}
	
    function confirm_procedure($visit_num) {
		$data['procedure_price'] = $this->get_proc_price();
		$data['procedure_package'] = $this->fetch_procedure_for_manage('manage', $visit_num);
		$data['visit_num'] = $visit_num;
		$this->load_views();
		$this->load->view('doc_sidebar.php', $data);
		$this->load->view('procedure_confirm.php', $data);
    }

    function other($visit_num) {
    	if ($this->input->post('doc')==NULL||$this->input->post('pfa')==NULL||$this->input->post('surgeon')==NULL||$this->input->post('pfs')==NULL||$this->input->post('other')==NULL) {
    		if($this->input->post('doc')!=NULL||$this->input->post('pfa')!=NULL||$this->input->post('surgeon')!=NULL||$this->input->post('pfs')!=NULL||$this->input->post('other')!=NULL) {
    			$data['bad_input'] = TRUE;
    		}
    		$this->load_views();
			$data['visit_num'] = $visit_num;
			$this->load->view('doc_sidebar.php', $data);
    		$this->load->view('additional_cost_form.php', $data);
    	} else {
			$this->form_validation->set_rules('surgeon', 'surgeon', 'trim|required');
	    	$this->form_validation->set_rules('pfs', 'pfs', 'trim|required|greater_than[0]');
	    	$this->form_validation->set_rules('doc', 'doc', 'trim|required');
	    	$this->form_validation->set_rules('pfa', 'pfa', 'trim|required|greater_than[0]');
			$this->form_validation->set_rules('other', 'other', 'trim|required|greater_than[0]');
	    	if($this->form_validation->run()==FALSE) {
    			$data['bad_input'] = TRUE;    		
	    		$data['visit_num'] = $visit_num;
	    		$this->load_views();
				$this->load->view('doc_sidebar.php', $data);
	    		$this->load->view('additional_cost_form.php', $data);
    		} else {
    			$sql = "INSERT INTO `additional_costs` (visit_num, su_incharge, su_cost, an_incharge, an_cost, other_cost) VALUES (
					".$visit_num.", '".mysql_real_escape_string($this->input->post('surgeon'))."', ".$this->input->post('pfs').",
									'".mysql_real_escape_string($this->input->post('doc'))."', ".$this->input->post('pfa').",
									".$this->input->post('other').")";
				$sql = $this->db->query($sql) or die(mysql_error());

    			$data['message'] = "Additional costing request finalized.";
    			$data['redir'] = anchor('/doctor/index/'.$visit_num, "Visit this patient's charts" ,'');

	    		$this->load_views();
				$data['visit_num'] = $visit_num;
				$this->load->view('doc_sidebar.php', $data);
	    		$this->load->view('clinical_success.php', $data);
    		}
    	}
    }
}

/* End of file procedures.php */
/* Location: ./application/controllers/procedures.php */