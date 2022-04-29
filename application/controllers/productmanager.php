<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProductManager extends CI_Controller 
{
	function __construct() {
        parent::__construct();

        $this->load->library(array('table', 'form_validation', 'session'));

        $this->load->helper('url');

		$tmpl = array ('table_open'  => '<table class="table table-striped table-advance table-hover table-condensed">');
		$this->table->set_template($tmpl);

    }

    public function index()
	{	
		if(! $this->session->userdata("logged_in")){
			redirect(base_url() . "main/");
		}

		if(!$this->session->userdata("acsCO")){
			$this->load->view('header.php');
			$this->load->view('navbar.php');
			$this->load->view('home_sidebar.php');
			$this->load->view('access_denied.php');
			$this->load->view('footer.php');
			return;
		}

		$this->load_views();
	}

	function success($mode, $inner_mode=NULL) {
    	if ($mode=='package' && $inner_mode=='add') {
    		$price = $this->get_pack_price();
    		$sql = "INSERT INTO `packages` (PACKAGE_NAME, PACKAGE_DESC, PACKAGE_PRICE, PACKAGE_PF, PACKAGE_TYPE) VALUES ('".mysql_real_escape_string($this->session->userdata('pkg_name'))."','".mysql_real_escape_string($this->session->userdata('pkg_desc'))."',".$price.", ".$this->session->userdata('pkg_pf').", 'M')";
			$sql = $this->db->query($sql) or die(mysql_error());

			$pack_id = $this->db->insert_id();
			foreach ($this->session->userdata('pkg') as $packprod) {
			    $sql = "INSERT INTO `package_products` VALUES (".$pack_id.", ".$packprod[0].", ".$packprod[2].")";
    			$sql = $this->db->query($sql) or die(mysql_error());
    		}

    		$data['message'] = "Package ". $this->session->userdata('pkg_name') . " is finalized.";
	    	$data['redir'] = anchor('/productmanager/addpkg', 'Add another package', '');

	    	$this->session->unset_userdata('pkg');
	    	$this->session->unset_userdata('pkg_name');
	    	$this->session->unset_userdata('pkg_desc');
	    	$this->session->unset_userdata('pkg_pf');
	    	$this->session->unset_userdata('pkg_mode');
    	} elseif ($mode=='package' && $inner_mode=='edit') {
    		$price = $this->get_pack_price();
    		$sql = "UPDATE `packages` SET PACKAGE_NAME='".mysql_real_escape_string($this->session->userdata('pkg_name'))."', PACKAGE_DESC='".mysql_real_escape_string($this->session->userdata('pkg_desc'))."', PACKAGE_PRICE=".$price.", PACKAGE_PF=".$this->session->userdata('pkg_pf')." WHERE PACKAGE_ID=".$this->session->userdata('pkg_id');
    		$sql = $this->db->query($sql) or die(mysql_error());

    		$sql = "DELETE FROM `package_products` WHERE PACKAGE_ID=".$this->session->userdata('pkg_id');
    		$sql = $this->db->query($sql) or die(mysql_error());

			foreach ($this->session->userdata('pkg') as $packprod) {
			    $sql = "INSERT INTO `package_products` VALUES (".$this->session->userdata('pkg_id').", ".$packprod[0].", ".$packprod[2].")";
    			$sql = $this->db->query($sql) or die(mysql_error());
    		}

    		$data['message'] = "Package ". $this->session->userdata('pkg_name') . " is finalized.";
	    	$data['redir'] = anchor('/productmanager/editpkg', 'Edit another package', '');

	    	$this->session->unset_userdata('pkg_id');
	    	$this->session->unset_userdata('pkg');
	    	$this->session->unset_userdata('pkg_name');
	    	$this->session->unset_userdata('pkg_desc');
	    	$this->session->unset_userdata('pkg_pf');
	    	$this->session->unset_userdata('pkg_mode');
	    	$this->session->unset_userdata('orig_pack_name');
    	} elseif ($mode=='product'&&$inner_mode=='add') {
    		$product = array(mysql_real_escape_string($this->input->post('name1')),mysql_real_escape_string($this->input->post('desc1')),$this->input->post('price1'));
    		$sql = "INSERT INTO `products` (PRODUCT_NAME, PRODUCT_DESC, PRODUCT_PRICE) VALUES ('".$product[0]."', '".$product[1]."', ".$product[2].")";
			$sql = $this->db->query($sql) or die(mysql_error());

    		$sql = "INSERT INTO `packages` (PACKAGE_NAME, PACKAGE_DESC, PACKAGE_PRICE, PACKAGE_TYPE) VALUES ('".$product[0]."', '".$product[1]."', ".$product[2].", 'S')";
			$sql = $this->db->query($sql) or die(mysql_error());
			
			$data['message'] = "Product ". htmlspecialchars_decode($this->input->post('name1'))." successfully added.";
	    	$data['redir'] = anchor('/productmanager/addprod', 'Add more products', '');
    	} elseif ($mode=='product'&&$inner_mode=='edit') {
    		$product = array(mysql_real_escape_string($this->input->post('name1')),mysql_real_escape_string($this->input->post('desc1')),$this->input->post('price1'));
			$sql = "UPDATE `products` SET PRODUCT_NAME ='".$product[0]."', PRODUCT_DESC='".$product[1]."', PRODUCT_PRICE='".$product[2]."' where PRODUCT_ID = ".$this->session->userdata('prod_id');
			$sql = $this->db->query($sql) or die(mysql_error());

			$sql = "UPDATE `packages` SET PACKAGE_NAME ='".$product[0]."', PACKAGE_DESC='".$product[1]."', PACKAGE_PRICE='".$product[2]."' where PACKAGE_ID = ".$this->session->userdata('pack_s_id');
			$sql = $this->db->query($sql) or die(mysql_error());  		

    		$sql = "SELECT PACKAGE_ID FROM `package_products` where PRODUCT_ID=".$this->session->userdata('prod_id');
			$sql = $this->db->query($sql) or die(mysql_error());

			$package_ids = $sql->result();
    		foreach ($package_ids as $package_id) {
    			$sql = "SELECT PRODUCT_PRICE, QUANTITY FROM `package_products`, `products` where package_products.PACKAGE_ID = ".$package_id->PACKAGE_ID." and products.PRODUCT_ID = package_products.PRODUCT_ID";
				$sql = $this->db->query($sql) or die(mysql_error());

				$prices = $sql->result();
				$price = 0;

				foreach ($prices as $p) {
					$price += $p->PRODUCT_PRICE *$p->QUANTITY;
				}

	    		$sql = "UPDATE `packages` SET PACKAGE_PRICE=".$price." where PACKAGE_ID=".$package_id->PACKAGE_ID;
				$sql = $this->db->query($sql) or die(mysql_error());
    		}

    		$data['message'] = "Product ". htmlspecialchars_decode($this->input->post('name1'))." successfully edited.";
	    	$data['redir'] = anchor('/productmanager/editprod', 'Edit another product', '');
    		$this->session->unset_userdata('prod_id');
			$this->session->unset_userdata('orig_prod_name');
			$this->session->unset_userdata('pack_s_id');
    	}
		$this->load_views();
		$this->load->view('clinical_success.php', $data);
    }

    //SUBMODULE: MANAGE PACKAGES FUNCTIONS
    function addpkg($mode=NULL) {
    	if ($this->session->userdata('pkg_mode')!='add') {
	    	$this->session->unset_userdata('pkg');
	    	$this->session->unset_userdata('pkg_id');
	    	$this->session->unset_userdata('pkg_name');
	    	$this->session->unset_userdata('pkg_desc');
	    	$this->session->unset_userdata('pkg_pf');
			$this->session->unset_userdata('pkg_price');
    	}
    	if ($mode==NULL && $this->session->userdata('pkg')==NULL) {
			$count = $this->db->count_all_results('packages') + 1;
			$this->session->set_userdata('pkg_name', 'Package_'.$count);
			$this->session->set_userdata('pkg_desc', 'New package desc');
			$this->session->set_userdata('pkg_pf', 0);
			$this->session->set_userdata('pkg', array());
			$this->session->set_userdata('pkg_mode', 'add');
			$this->session->set_userdata('pkg_price', 0);
		}
		$data['pkg_name'] = $this->session->userdata('pkg_name');
		$data['name_mode'] = 'display';
		$data['pkg_desc'] = $this->session->userdata('pkg_desc');
		$data['desc_mode'] = 'display';
		$data['pkg_pf'] = $this->session->userdata('pkg_pf');
		$data['pf_mode'] = 'display';
		$data['pkg_price'] = $this->session->userdata('pkg_price');
    	
		$data['mode'] = $this->session->userdata('pkg_mode');
		$data['package'] = $this->fetch_package_for_manage('manage');
		$data['products'] = $this->fetch_products_for_manage();

    	$data['header'] = '<i class="fa fa-plus"></i></i>Add package';

		$this->load_views();
		$this->load->view('clinical_package.php', $data);
    }

    function searchByProduct ($offset = 0)
	{
		// Starting query w/ no restrictions
		$sql = 'SELECT * FROM `products`';
		
		// If a query is submitted by the user (may not be all users)
		if ($this->input->post('submit') != FALSE)	
		{
			// Get query filters
			$input = mysql_real_escape_string($this->input->POST('product'));
			
			// Update SQL query string
			$sql = $sql . " WHERE `product_name` LIKE '%$input%'";
		}
		
		$product = new stdClass();
		$sql = $this->db->query($sql) or die(mysql_error());
        $products = $sql->result();
		
		
		$this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'Name', 'Description', 'Price', 'Actions');
        $i = 0;
        foreach ($products as $product) {
        	if ($this->is_in_package($product->PRODUCT_ID)==-1) {
				$this->table->add_row(++$i, $product->PRODUCT_NAME, $product->PRODUCT_DESC, $product->PRODUCT_PRICE, "<a style='cursor: pointer;' onclick='add_qty(".$product->PRODUCT_ID."); '>add</a>");
        	}
        }
		$data['products'] = $this->table->generate();
        $data['package'] = $this->fetch_package_for_manage('manage');

		$data['pkg_name'] = htmlspecialchars($this->session->userdata('pkg_name'), ENT_QUOTES);
		$data['name_mode'] = 'display';
		$data['pkg_desc'] = htmlspecialchars($this->session->userdata('pkg_desc'), ENT_QUOTES);
		$data['desc_mode'] = 'display';
		$data['pkg_pf'] = $this->session->userdata('pkg_pf');
		$data['pf_mode'] = 'display';

		if ($this->session->userdata('pkg_mode')=='add') {
    		$data['header'] = '<i class="fa fa-plus"></i></i>Add package';
		} else {
			$data['header'] = '<i class="fa fa-pencil"></i></i>Edit package';
		}
		$data['mode'] = $this->session->userdata('pkg_mode');
		$data['pkg_price'] = $this->session->userdata('pkg_price');
			
		$this->load_views();
		$this->load->view('clinical_package.php', $data);
    }

	function load_views() {
		$this->load->view('header.php');			
		$this->load->view('navbar.php');
		$this->load->view('clinical_sidebar.php');
		$this->load->view('footer.php');
	}

    function editpkg() {
    	if ($this->session->userdata('pkg_mode')!='edit') {
	    	$this->session->unset_userdata('pkg');
	    	$this->session->unset_userdata('pkg_id');
	    	$this->session->unset_userdata('pkg_name');
	    	$this->session->unset_userdata('pkg_desc');
	    	$this->session->unset_userdata('pkg_pf');
			$this->session->unset_userdata('pkg_price');
			$this->session->unset_userdata('orig_pack_name');			
    	}
    	$data['header'] = '<i class="fa fa-pencil-square-o"></i>Edit package';
		$this->load_views();
		
		$data['select_table'] = $this->fetch_packages();

    	if($this->input->post('selected_final')==NULL && $this->session->userdata('pkg_name')==NULL) {
			if($this->input->post('selected')!=NULL) {
				$sql = "SELECT PACKAGE_NAME FROM `packages` where PACKAGE_ID=".$this->input->post('selected');
				$sql = $this->db->query($sql) or die(mysql_error());
				$data['selected_name'] = htmlspecialchars($sql->result()[0]->PACKAGE_NAME, ENT_QUOTES);
				$data['selected'] = $this->input->post('selected');
			}

			if ($this->input->post('psearch')!=NULL) {
				$data['select_table'] = $this->fetch_packages($this->input->post('psearch'));
			}

			$data['next'] = 'editpkg';
			$data['prompt'] = 'Select package to edit';
			$data['placeholder'] = 'Package name';

			$this->load->view('clinical_select.php', $data);
		} else {
			if ($this->session->userdata('pkg_name')==NULL) {
				$this->session->set_userdata('pkg_id', $this->input->post('selected_final'));
				$this->session->set_userdata('pkg', array());

				$sql = "SELECT * FROM `packages` where PACKAGE_ID=".$this->input->post('selected_final');
				$sql = $this->db->query($sql) or die(mysql_error());
				$this->session->set_userdata('pkg_name', $sql->result()[0]->PACKAGE_NAME);
				$this->session->set_userdata('pkg_desc', $sql->result()[0]->PACKAGE_DESC);
				$this->session->set_userdata('pkg_pf', $sql->result()[0]->PACKAGE_PF);
				$this->session->set_userdata('pkg_price', $sql->result()[0]->PACKAGE_PRICE);
				$this->session->set_userdata('pkg_mode', 'edit');
				$this->session->set_userdata('pkg', $this->fetch_init_package($this->session->userdata('pkg_id')));
				$this->session->set_userdata('orig_pack_name', $sql->result()[0]->PACKAGE_NAME);
			}


			$data['mode'] = $this->session->userdata('pkg_mode');
			$data['products'] = $this->fetch_products_for_manage();
			$data['pkg_name'] = htmlspecialchars($this->session->userdata('pkg_name'), ENT_QUOTES);
			$data['name_mode'] = 'display';
			$data['pkg_desc'] = htmlspecialchars($this->session->userdata('pkg_desc'), ENT_QUOTES);
			$data['desc_mode'] = 'display';
			$data['pkg_pf'] = $this->session->userdata('pkg_pf');
			$data['pf_mode'] = 'display';
			$data['pkg_price'] = $this->session->userdata('pkg_price');
			$data['package'] = $this->fetch_package_for_manage('manage');
			$this->load->view('clinical_package.php', $data);
		}
    }

  	function cancel_package($mode) {
    	if ($mode=='add') {
	    	$data['message'] = "Addition of package ". $this->session->userdata('pkg_name') . " is cancelled.";
	    	$data['redir'] = anchor('/productmanager/addpkg', 'Add a package', '');
    	} elseif ($mode=='edit') {
	    	$data['message'] = "Editing of package ". $this->session->userdata('pkg_name') . " is cancelled.";
	    	$data['redir'] = anchor('/productmanager/editpkg', 'Edit a package', '');    		
    	}

    	$this->session->unset_userdata('pkg');
    	$this->session->unset_userdata('pkg_id');
    	$this->session->unset_userdata('pkg_name');
    	$this->session->unset_userdata('pkg_desc');
    	$this->session->unset_userdata('pkg_pf');
    	$this->session->unset_userdata('pkg_price');

		$this->load_views();
		$this->load->view('clinical_cancel.php', $data);
  	}

    function confirm_package($mode) {
    	if(count($this->session->userdata('pkg'))>0) {
	    	$data['mode'] = 'package';
	    	$data['table_header'] = htmlspecialchars($this->session->userdata('pkg_name'), ENT_QUOTES);
	    	$data['description'] = htmlspecialchars($this->session->userdata('pkg_desc'), ENT_QUOTES);
			$data['pkg_pf'] = $this->session->userdata('pkg_pf');
			$data['confirm_table'] = $this->fetch_package_for_manage('confirm');
			$data['total'] = $this->get_pack_price();

			$data['header'] = 'Confirm Package';
			if ($mode=='add') {
				$data['prev'] =''.base_url().'productmanager/addpkg';
			} elseif ($mode=='edit')  {
				$data['prev'] =''.base_url().'productmanager/editpkg';
			}

			$this->load_views();
			$this->load->view('clinical_confirm.php', $data);
    	} elseif (count($this->session->userdata('pkg'))==0 )  {
    		if ($this->session->userdata('pkg_mode')=='add') {
    			redirect(base_url() . '/productmanager/addpkg');
    		} elseif ($this->session->userdata('pkg_mode')=='edit') {
    			redirect(base_url() . '/productmanager/editpkg');
    		}
    	}
    }

    function add_to_pkg ($id) {
		$data['pkg_name'] = htmlspecialchars($this->session->userdata('pkg_name'), ENT_QUOTES);
		$data['name_mode'] = 'display';
		$data['pkg_desc'] = htmlspecialchars($this->session->userdata('pkg_desc'), ENT_QUOTES);
		$data['desc_mode'] = 'display';
		$data['pkg_pf'] = $this->session->userdata('pkg_pf');
		$data['pf_mode'] = 'display';

		$this->form_validation->set_rules('qty', 'quantity', 'trim|required|greater_than[0]');
		$valid = $this->form_validation->run()==TRUE;
		if($valid) {
			$qty = $this->input->post('qty');
		} elseif ($this->is_in_package($id)==-1) {
			$qty = 1;
		}

		if ($this->is_in_package($id)==-1) {
			$temp_pack = $this->session->userdata('pkg');

			$sql = "SELECT * FROM `products` where PRODUCT_ID=".$id;
			$sql = $this->db->query($sql) or die(mysql_error());
			$product = $sql->result()[0];

			array_push($temp_pack, array($id,$product->PRODUCT_NAME,$qty,$product->PRODUCT_PRICE));

			$this->session->set_userdata('pkg', $temp_pack);
		}

		if($valid) {
			$this->session->set_userdata('pkg_price', $this->get_pack_price());
			$data['pkg_price'] = $this->session->userdata('pkg_price');

			$data['mode'] = $this->session->userdata('pkg_mode');
			$data['package'] = $this->fetch_package_for_manage('manage');
			$data['products'] = $this->fetch_products_for_manage();

			if ($this->session->userdata('pkg_mode')=='add') {
	    		$data['header'] = '<i class="fa fa-plus"></i></i>Add package';
			} else {
				$data['header'] = '<i class="fa fa-pencil"></i></i>Edit package';
			}

			$this->load_views();
			$this->load->view('clinical_package.php', $data);
		} else {
			$this->edit_pkg_qty($id);
		}
    }

    function remove_from_pkg ($id) {
		$data['pkg_name'] = htmlspecialchars($this->session->userdata('pkg_name'), ENT_QUOTES);
		$data['name_mode'] = 'display';
		$data['pkg_desc'] = htmlspecialchars($this->session->userdata('pkg_desc'), ENT_QUOTES);
		$data['desc_mode'] = 'display';
		$data['pkg_pf'] = $this->session->userdata('pkg_pf');
		$data['pf_mode'] = 'display';

    	$temp_pack = $this->session->userdata('pkg');
		$new_pack = array();
		foreach ($temp_pack as $product) {
			if ($product[0]!=$id) {
				array_push($new_pack, $product);
			}
		}
		$this->session->set_userdata('pkg', $new_pack);

		$this->session->set_userdata('pkg_price', $this->get_pack_price());
		$data['pkg_price'] = $this->session->userdata('pkg_price');

		$data['mode'] = $this->session->userdata('pkg_mode');
		$data['package'] = $this->fetch_package_for_manage('manage');
		$data['products'] = $this->fetch_products_for_manage();

		if ($this->session->userdata('pkg_mode')=='add') {
    		$data['header'] = '<i class="fa fa-plus"></i></i>Add package';
		} else {
			$data['header'] = '<i class="fa fa-pencil"></i></i>Edit package';
		}

		$this->load_views();
		$this->load->view('clinical_package.php', $data);
    }

    function try_edit_pkg_qty ($id) {
		$data['pkg_name'] = htmlspecialchars($this->session->userdata('pkg_name'), ENT_QUOTES);
		$data['name_mode'] = 'display';
		$data['pkg_desc'] = htmlspecialchars($this->session->userdata('pkg_desc'), ENT_QUOTES);
		$data['desc_mode'] = 'display';
		$data['pkg_pf'] = $this->session->userdata('pkg_pf');
		$data['pf_mode'] = 'display';
		$data['pkg_price'] = $this->session->userdata('pkg_price');

		$data['mode'] = $this->session->userdata('pkg_mode');
		$data['package'] = $this->fetch_package_for_edit($id);
		$data['products'] = $this->fetch_products_for_manage();

		if ($this->session->userdata('pkg_mode')=='add') {
    		$data['header'] = '<i class="fa fa-plus"></i></i>Add package';
		} else {
			$data['header'] = '<i class="fa fa-pencil"></i></i>Edit package';
		}

		$this->load_views();
		$this->load->view('clinical_package.php', $data);
    }

    function edit_pkg_qty ($editid) {
		$data['pkg_name'] = htmlspecialchars($this->session->userdata('pkg_name'), ENT_QUOTES);
		$data['name_mode'] = 'display';
		$data['pkg_desc'] = htmlspecialchars($this->session->userdata('pkg_desc'), ENT_QUOTES);
		$data['desc_mode'] = 'display';
		$data['pkg_pf'] = $this->session->userdata('pkg_pf');
		$data['pf_mode'] = 'display';

		$this->form_validation->set_rules('qty', 'quantity', 'trim|required|greater_than[0]');
    	if ($this->form_validation->run()==FALSE) {
    		$data['bad_qty'] = TRUE;
			$data['package'] = $this->fetch_package_for_edit($editid);
    	} else {
    		$newqty = $this->input->post('qty');
    		$temp_pack = $this->session->userdata('pkg');
    		$temp_pack[$this->is_in_package($editid)][2] = $newqty;

    		$this->session->set_userdata('pkg', $temp_pack);
    		$data['package'] = $this->fetch_package_for_manage('manage');
    	}
    	$this->session->set_userdata('pkg_price', $this->get_pack_price());
		$data['pkg_price'] = $this->session->userdata('pkg_price');

		$data['mode'] = $this->session->userdata('pkg_mode');
		$data['products'] = $this->fetch_products_for_manage();

		if ($this->session->userdata('pkg_mode')=='add') {
    		$data['header'] = '<i class="fa fa-plus"></i></i>Add package';
		} else {
			$data['header'] = '<i class="fa fa-pencil"></i></i>Edit package';
		}

		$this->load_views();
		$this->load->view('clinical_package.php', $data);
    }

    function edit_pkg_name() {
		$data['pkg_name'] = htmlspecialchars($this->session->userdata('pkg_name'), ENT_QUOTES);
		$data['pkg_desc'] = htmlspecialchars($this->session->userdata('pkg_desc'), ENT_QUOTES);
		$data['desc_mode'] = 'display';
		$data['pkg_price'] = $this->session->userdata('pkg_price');
		$data['pkg_pf'] = $this->session->userdata('pkg_pf');
		$data['pf_mode'] = 'display';

		$this->form_validation->set_rules('pack_name', 'Package Name', 'trim|required|callback_packname_is_taken['.$this->session->userdata('pkg_mode').']');

    	if ($this->input->post('success')==NULL) {
			$data['name_mode'] = 'edit';
    	} elseif ($this->form_validation->run()==TRUE) {
    		$this->session->set_userdata('pkg_name', $this->input->post('pack_name'));
			$data['pkg_name'] = htmlspecialchars($this->session->userdata('pkg_name'), ENT_QUOTES);
    		$data['name_mode'] = 'display';
    	} elseif ($this->form_validation->run()==FALSE) {
    		$data['bad_name'] = TRUE;
    		if($this->input->post('pack_name')==NULL) {
    			$data['bad_name'] = FALSE;
    		}
    		$data['name_mode'] = 'edit';
    	}

		$data['mode'] = $this->session->userdata('pkg_mode');
		$data['package'] = $this->fetch_package_for_manage('manage');
		$data['products'] = $this->fetch_products_for_manage();

		if ($this->session->userdata('pkg_mode')=='add') {
    		$data['header'] = '<i class="fa fa-plus"></i></i>Add package';
		} else {
			$data['header'] = '<i class="fa fa-pencil"></i></i>Edit package';
		}

		$this->load_views();
		$this->load->view('clinical_package.php', $data);
    }

    function edit_pkg_desc($mode=NULL) {
		$data['pkg_name'] = htmlspecialchars($this->session->userdata('pkg_name'), ENT_QUOTES);
		$data['name_mode'] = 'display';
		$data['pkg_desc'] = htmlspecialchars($this->session->userdata('pkg_desc'), ENT_QUOTES);
		$data['pkg_price'] = $this->session->userdata('pkg_price');
		$data['pkg_pf'] = $this->session->userdata('pkg_pf');
		$data['pf_mode'] = 'display';

		$this->form_validation->set_rules('pack_desc', 'Package Description', 'trim|required');
    	if ($this->input->post('success')==NULL) {
			$data['desc_mode'] = 'edit';
    	} elseif ($this->form_validation->run()==TRUE) {
    		$this->session->set_userdata('pkg_desc', $this->input->post('pack_desc'));
			$data['pkg_desc'] = htmlspecialchars($this->session->userdata('pkg_desc'), ENT_QUOTES);
			$data['desc_mode'] = 'display';
    	} elseif ($this->form_validation->run()==FALSE) {
    		$data['bad_desc'] = TRUE;
			$data['desc_mode'] = 'edit';
    	}
    	
		$data['mode'] = $this->session->userdata('pkg_mode');
		$data['package'] = $this->fetch_package_for_manage('manage');
		$data['products'] = $this->fetch_products_for_manage();

		if ($this->session->userdata('pkg_mode')=='add') {
    		$data['header'] = '<i class="fa fa-plus"></i></i>Add package';
		} else {
			$data['header'] = '<i class="fa fa-pencil"></i></i>Edit package';
		}

		$this->load_views();
		$this->load->view('clinical_package.php', $data);
    }

    function edit_pkg_pf($mode=NULL) {
		$data['pkg_name'] = htmlspecialchars($this->session->userdata('pkg_name'), ENT_QUOTES);
		$data['name_mode'] = 'display';
		$data['pkg_desc'] = htmlspecialchars($this->session->userdata('pkg_desc'), ENT_QUOTES);
		$data['desc_mode'] = 'display';
		$data['pkg_price'] = $this->session->userdata('pkg_price');
		$data['pkg_pf'] = $this->session->userdata('pkg_pf');

		$this->form_validation->set_rules('pack_pf', 'Professional Fee', 'trim|required|greater_than_equal_to[0]');
    	if ($this->input->post('success')==NULL) {
			$data['pf_mode'] = 'edit';
    	} elseif ($this->form_validation->run()==TRUE) {
    		$this->session->set_userdata('pkg_pf', $this->input->post('pack_pf'));
			$data['pkg_pf'] = $this->session->userdata('pkg_pf');
			$data['pf_mode'] = 'display';
    	} elseif ($this->form_validation->run()==FALSE) {
    		$data['bad_pf'] = TRUE;
			$data['pf_mode'] = 'edit';
    	}
    	
		$data['mode'] = $this->session->userdata('pkg_mode');
		$data['package'] = $this->fetch_package_for_manage('manage');
		$data['products'] = $this->fetch_products_for_manage();

		if ($this->session->userdata('pkg_mode')=='add') {
    		$data['header'] = '<i class="fa fa-plus"></i></i>Add package';
		} else {
			$data['header'] = '<i class="fa fa-pencil"></i></i>Edit package';
		}

		$this->load_views();
		$this->load->view('clinical_package.php', $data);
    }

    function get_pack_price() {
    	$price = 0;
	    foreach ($this->session->userdata('pkg') as $packprod) {
			$price += $packprod[2] * $packprod[3];
		}
		return $price;
    }

    function is_in_package($prod_id) {
    	$ret = -1;
    	$package = $this->session->userdata('pkg');
    	for ($ctr=0;$ctr<count($package);$ctr++) {
    		if ($package[$ctr][0]==$prod_id) {
    			$ret = $ctr;
    		}
    	}
    	return $ret;
    }

    function fetch_packages ($query='') {
    	$sql = 'SELECT * FROM `packages` where PACKAGE_TYPE="M" and PACKAGE_NAME like ?' ;
		$sql = $this->db->query($sql, array("%".mysql_real_escape_string($query)."%")) or die(mysql_error());
		
		$packages= $sql->result();

		$this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'Name', 'Description', 'Price', 'Professional Fee', 'Actions');
        $i = 0;
        foreach ($packages as $package) {
			$action = "<form method='POST' action='http://". $_SERVER['SERVER_NAME']. $_SERVER['REQUEST_URI']."'><input type='submit' value='Select' class='btn btn-primary'/><input type='hidden' name='selected' value='".$package->PACKAGE_ID."'/></form>";
        	$this->table->add_row(++$i, $package->PACKAGE_NAME, $package->PACKAGE_DESC, $package->PACKAGE_PRICE, $package->PACKAGE_PF, $action);
        }
        return $this->table->generate();
    }

    function fetch_package_for_edit ($editid) {
    	$temp_pack = $this->session->userdata('pkg'); 

        $this->table->set_empty("&nbsp;");
		$this->table->set_heading('No', 'Name', 'Quantity', 'Price', 'Subtotal', 'Actions');
        $i = 0;

        foreach ($temp_pack as $product) {
        	$id = $product[0];
        	$name = $product[1];
        	$qty = $product[2];
        	$price = $product[3];

			if($id==$editid) {
				$form = "
					<div class='row'>
						<form action='".site_url("productmanager/edit_pkg_qty/".$id)."' method=POST class='form-inline'>
							<div class='form-group'>
								<input type='text' name='qty' class='form-control col-md-4' value='".$qty."'/>
							</div> 
							<input type='submit' class='btn btn-default' value='confirm'/>
						</form>
					</div>
				";
				$this->table->add_row(++$i, $name, $form, $price, $price*$qty, anchor('/productmanager/remove_from_pkg/'.$id, 'remove', ''));
			} else {
	            $this->table->add_row(++$i, $name, $qty, $price, $price*$qty, anchor('/productmanager/try_edit_pkg_qty/'.$id, 'edit', '') .' '.anchor('/productmanager/remove_from_pkg/'.$id, 'remove', ''));
			}

        }
        return $this->table->generate();
    }

    function fetch_init_package($id) {
    	$sql = "SELECT * FROM `packages` where PACKAGE_ID=".$id;
		$sql = $this->db->query($sql) or die(mysql_error());
		$package_dets = $sql->result()[0];

		$this->session->set_userdata('pkg_name', $package_dets->PACKAGE_NAME);
		$this->session->set_userdata('pkg_desc', $package_dets->PACKAGE_DESC);

    	$sql = "SELECT * FROM `package_products` where PACKAGE_ID=".$id;
		$sql = $this->db->query($sql) or die(mysql_error());
		$package = $sql->result();

		$arr = array();

        $i = 0;
        foreach ($package as $packprod) {
	    	$sql = "SELECT * FROM `products` where PRODUCT_ID=".$packprod->PRODUCT_ID;
			$sql = $this->db->query($sql) or die(mysql_error());
			$product = $sql->result()[0];

        	$subarr = array($product->PRODUCT_ID, $product->PRODUCT_NAME, $packprod->QUANTITY, $product->PRODUCT_PRICE);
			array_push($arr, $subarr);
        }
        return $arr;
    }

    function fetch_package_for_manage($mode) {
    	if (count($this->session->userdata('pkg'))>0) {
			$this->table->set_empty("&nbsp;");
			if($mode=='manage') {
		        $this->table->set_heading('No', 'Name', 'Quantity', 'Price', 'Subtotal', 'Actions');
		        $i = 0;
		        foreach ($this->session->userdata('pkg') as $product) {
		        	$this->table->add_row(++$i, $product[1], $product[2], $product[3], $product[2]*$product[3], anchor('/productmanager/try_edit_pkg_qty/'.$product[0], 'edit', '') .' '.anchor('/productmanager/remove_from_pkg/'.$product[0], 'remove', ''));
		        }
			} elseif ($mode=='confirm') {
				$this->table->set_heading('No', 'Name', 'Quantity', 'Price', 'Subtotal');
		        $i = 0;
		        foreach ($this->session->userdata('pkg') as $product) {
		        	$this->table->add_row(++$i, $product[1], $product[2], $product[3], $product[2]*$product[3]);
		        }
			}
	        return $this->table->generate();
    	} else {
			return '<i class="fa fa-dropbox"></i><span>Add items to package</span>';
		}	
    }

    function fetch_products_for_manage () {
    	$sql = 'SELECT * FROM `products`' ;
		$sql = $this->db->query($sql) or die(mysql_error());
		
		$products= $sql->result();

        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'Name', 'Description', 'Price', 'Actions');
        $i = 0;
        foreach ($products as $product) {
        	if($this->is_in_package($product->PRODUCT_ID)==-1) {
        		$this->table->add_row(++$i, $product->PRODUCT_NAME, $product->PRODUCT_DESC, $product->PRODUCT_PRICE, "<a style='cursor: pointer;' onclick='add_qty(".$product->PRODUCT_ID."); '>add</a>");
        	}
        }
        return $this->table->generate();
    }

    public function packname_is_taken($input, $mode) {
    	if(! $this->session->userdata("logged_in")){
			redirect(base_url() . "main/");
		}

		if(!$this->session->userdata("acsCO")){
			$this->load->view('header.php');
			$this->load->view('navbar.php');
			$this->load->view('home_sidebar.php');
			$this->load->view('access_denied.php');
			$this->load->view('footer.php');
			return;
		}
    	
        $query = "SELECT * FROM `packages` WHERE `PACKAGE_NAME` = ?";
        $arg = array(mysql_real_escape_string($input));
        $exec = $this->db->query($query, $arg) or die(mysql_error());
        if ($exec->num_rows() > 0) {
        	if ($mode=='edit' && $exec->result()[0]->PACKAGE_NAME == $this->session->userdata('orig_pack_name')) {
        		return TRUE;
        	}
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //SUBMODULE: MANAGE PRODUCTS FUNCTIONS
    function addprod() {
    	$this->session->unset_userdata('prod_id');
		$this->session->unset_userdata('orig_prod_name');
		$this->session->unset_userdata('pack_s_id');

    	if ($this->input->post('cancelprod')!=NULL || ($this->input->post('name1')==NULL && $this->input->post('desc1')==NULL && $this->input->post('price1')==NULL)) {
    		$this->session->unset_userdata('new_prod');
	    	$data['header'] = '<i class="fa fa-plus"></i></i>Add product';
	    	$data['mode'] = 'Add';

	    	$data['self'] = ''.base_url().'productmanager/addprod';
	    	$data['next'] = ''.base_url().'productmanager/confirm_product/add';

	    	$data['name_init'] = '';
	    	$data['desc_init'] = '';
	    	$data['price_init'] = '';

	    	$this->load_views();
	    	$this->load->view('clinical_product.php', $data);
    	} else {
			if($this->input->post('name1')==NULL) {
				$data['bad_name'] = FALSE;
			} elseif (!$this->prodname_is_taken($this->input->post('name1'),'add')) {
				$data['bad_name'] = TRUE;
			}
			if ($this->input->post('desc1')==NULL) {
				$data['bad_desc'] = TRUE;
			}
			if ($this->input->post('price1')==NULL) {
				$data['bad_price'] = FALSE;
			} elseif (!is_numeric($this->input->post('price1')) || $this->input->post('price1')<=0) {
				$data['bad_price'] = TRUE;
			}
    		$data['header'] = '<i class="fa fa-plus"></i>Add product';
	    	$data['mode'] = 'Add';

	    	$data['self'] = ''.base_url().'productmanager/addprod';
	    	$data['next'] = ''.base_url().'productmanager/confirm_product/add';

	    	$data['name_init'] = htmlspecialchars($this->input->post('name1'), ENT_QUOTES);
	    	$data['desc_init'] = htmlspecialchars($this->input->post('desc1'), ENT_QUOTES);
	    	$data['price_init'] = htmlspecialchars($this->input->post('price1'), ENT_QUOTES);

	    	$this->load_views();
	    	$this->load->view('clinical_product.php', $data);
    	}
    }

    function confirm_product($mode) {
    	if ($mode=='add') {
    		$this->form_validation->set_rules('name1', 'name', 'trim|required|callback_prodname_is_taken[add]');
    	} elseif ($mode=='edit') {
    		$this->form_validation->set_rules('name1', 'name', 'trim|required|callback_prodname_is_taken[edit]');
    	}
		$this->form_validation->set_rules('desc1', 'desc', 'trim|required');
		$this->form_validation->set_rules('price1', 'price', 'trim|required|greater_than[0]');

    	if ($this->form_validation->run()==TRUE) {
    		$data['name_conf'] = htmlspecialchars($this->input->post('name1'), ENT_QUOTES);
    		$data['desc_conf'] = htmlspecialchars($this->input->post('desc1'), ENT_QUOTES);
    		$data['price_conf'] = htmlspecialchars($this->input->post('price1'), ENT_QUOTES);
	    	if ($mode=='add') {
	    		$data['header'] = '<i class="fa fa-plus"></i>Confirm new product';
				$data['prev'] = ''.base_url().'productmanager/addprod';
				$data['next'] = ''.base_url().'productmanager/success/product/add';
	    	} elseif ($mode=='edit') {
	    		$data['header'] = '<i class="fa fa-pencil"></i>Confirm product edit';
				$data['prev'] = ''.base_url().'productmanager/editprod';
				$data['next'] = ''.base_url().'productmanager/success/product/edit';
	    	}

			$data['mode'] = 'product';
	    	$this->load_views();
	    	$this->load->view('clinical_prconfirm.php', $data);	
    	} else {
    		$action = ($mode=='add'?''.base_url().'productmanager/addprod':''.base_url().'productmanager/editprod');
    		echo "<form class='form-horizontal' method='post' id='myform' action='".$action."'>
				    <input type='hidden' name='name1' value=".$this->input->post('name1').">
				    <input type='hidden' name='desc1' value=".$this->input->post('desc1').">
				    <input type='hidden' name='price1' value=".$this->input->post('price1').">
				  </form>
				  <script type='text/javascript'>document.forms['myform'].submit();</script>
			";
    	}
    }

    function prodname_is_taken ($input, $mode) {
    	$query = "SELECT * FROM `products` WHERE `PRODUCT_NAME` = ?";
        $arg = array(mysql_real_escape_string($input));
        $exec = $this->db->query($query, $arg) or die(mysql_error());
        if ($exec->num_rows() > 0) {
        	if ($mode=='edit' && $exec->result()[0]->PRODUCT_NAME == $this->session->userdata('orig_prod_name')) {
        		return TRUE;
        	}
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function editprod() {
    	$data['header'] = '<i class="fa fa-pencil-square-o"></i>Edit product';
		$this->load_views();
    	if(($this->input->post('selected_final')==NULL && $this->session->userdata('prod_id')==NULL && $this->input->post('submitprod')==NULL) || $this->input->post('cancelprod')!=NULL) {
			$this->session->unset_userdata('prod_id');
			$this->session->unset_userdata('orig_prod_name');
			$this->session->unset_userdata('pack_s_id');

			$data['select_table'] = $this->fetch_products_for_edit();

			if($this->input->post('selected')!=NULL) {
				$sql = "SELECT PRODUCT_NAME FROM `products` where PRODUCT_ID=".$this->input->post('selected');
				$sql = $this->db->query($sql) or die(mysql_error());
				$data['selected_name'] = htmlspecialchars($sql->result()[0]->PRODUCT_NAME, ENT_QUOTES);
				$data['selected'] = $this->input->post('selected');
			}

			if ($this->input->post('psearch')!=NULL) {
				$data['select_table'] = $this->fetch_products_for_edit($this->input->post('psearch'));
			}

			$data['next'] = 'editprod';
			$data['prompt'] = 'Select product to edit';
			$data['placeholder'] = 'Product name';

			
			$this->load->view('clinical_select.php', $data);
		} else {
			if ($this->session->userdata('prod_id')==NULL || ($this->input->post('name1')==NULL && $this->input->post('desc1')==NULL && $this->input->post('price1')==NULL)) {
				if ($this->session->userdata('prod_id')==NULL) {
					$this->session->set_userdata('prod_id', $this->input->post('selected_final'));
				}
				
				$sql = 'SELECT PACKAGE_ID FROM `products`, `packages` where PRODUCT_ID ='.$this->session->userdata('prod_id'). ' and PACKAGE_NAME = PRODUCT_NAME';
				$sql = $this->db->query($sql) or die(mysql_error());

				$this->session->set_userdata('pack_s_id', $sql->result()[0]->PACKAGE_ID);

				$sql = 'SELECT * FROM `products` where PRODUCT_ID ='.$this->session->userdata('prod_id');
				$sql = $this->db->query($sql) or die(mysql_error());
				
				$product= $sql->result()[0];
				$name = $product->PRODUCT_NAME;
				$desc = $product->PRODUCT_DESC;
				$price = $product->PRODUCT_PRICE;

				$this->session->set_userdata('orig_prod_name', $name);
			} else {
				if($this->input->post('name1')==NULL) {
					$data['bad_name'] = FALSE;
				} elseif (!$this->prodname_is_taken($this->input->post('name1'),'edit')) {
					$data['bad_name'] = TRUE;
				}
				if ($this->input->post('desc1')==NULL) {
					$data['bad_desc'] = TRUE;
				}
				if ($this->input->post('price1')==NULL) {
					$data['bad_price'] = FALSE;
				} elseif (!is_numeric($this->input->post('price1')) || $this->input->post('price1')<=0) {
					$data['bad_price'] = TRUE;
				}

				$name = $this->input->post('name1');
				$desc = $this->input->post('desc1');
				$price = $this->input->post('price1');
			}


	    	$data['header'] = '<i class="fa fa-pencil"></i></i>Edit product';
	    	$data['mode'] = 'Edit';

	    	$data['name_init'] = htmlspecialchars($name, ENT_QUOTES);
	    	$data['desc_init'] = htmlspecialchars($desc, ENT_QUOTES);
	    	$data['price_init'] = htmlspecialchars($price, ENT_QUOTES);

	    	$data['self'] = ''.base_url().'productmanager/editprod';
	    	$data['next'] = ''.base_url().'productmanager/confirm_product/edit';

	    	$this->load->view('clinical_product.php', $data);
    	}
    }

    function fetch_products_for_edit($query='') {
    	$sql = 'SELECT * FROM `products` WHERE PRODUCT_NAME like ?';
		$sql = $this->db->query($sql, array("%".mysql_real_escape_string($query)."%")) or die(mysql_error());
		
		$products= $sql->result();

		$this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'Name', 'Description', 'Price', 'Actions');
        $i = 0;
        foreach ($products as $product) {
			$action = "<form method='POST' action='http://". $_SERVER['SERVER_NAME']. $_SERVER['REQUEST_URI']."'><input type='submit' value='Select' class='btn btn-primary'/><input type='hidden' name='selected' value='".$product->PRODUCT_ID."'/></form>";
        	$this->table->add_row(++$i, $product->PRODUCT_NAME, $product->PRODUCT_DESC, $product->PRODUCT_PRICE, $action);
        }
        return $this->table->generate();
    }


}
?>