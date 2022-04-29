<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clinicalorder extends CI_Controller 
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
			$this->load->view('footer.php');
			$this->load->view('access_denied.php');
			return;
		}

		$this->load_views();

		if($this->input->post('selected_final')==NULL && $this->session->userdata('patient_name')==NULL) {
			$data['select_table'] = $this->fetch_admitted_pats();
			
			if($this->input->post('selected')!=NULL) {
				$sql = "SELECT first_name, middle_name, last_name FROM `patients`, `appointments` where patients.true_id=appointments.true_id and appointments.visit_num=".$this->input->post('selected');
				$sql = $this->db->query($sql) or die(mysql_error());
				$patient = $sql->result()[0];
				$data['selected_name'] = $patient->last_name.", ".$patient->first_name." ".$patient->middle_name;
				$data['selected'] = $this->input->post('selected');
			}

			if ($this->input->post('psearch')!=NULL) {
				$data['select_table'] = $this->fetch_admitted_pats($this->input->post('psearch'));
			}

			$data['header'] = '<i class="fa fa-bars"></i>Clinical Ordering';

			$data['next'] = 'clinicalorder';
			$data['prompt'] = 'Create an order for';
			$data['placeholder'] = 'Patient';

			$this->load->view('clinical_select.php', $data);
		} else {
			if ($this->session->userdata('patient_name')==NULL) {
				$this->session->set_userdata('patient_id', $this->input->post('selected_final'));
				$this->session->set_userdata('patient_name', $this->input->post('selected_name'));
				$this->session->set_userdata('order_cart', array());

				$sql = "SELECT fName, lName from `doctors_list` where uName = '".$this->session->userdata('username')."'";
				$sql = $this->db->query($sql) or die(mysql_error());
				$doc = $sql->result()[0];
				$this->session->set_userdata('ordermd', $doc->fName." ".$doc->lName);
			}

			$data['packages'] = $this->fetch_packages('order');
			$data['products'] = $this->fetch_products_for_order();
			$data['orders'] = $this->fetch_orders();

			$data['header'] = 'Clinical Ordering for '.$this->session->userdata('patient_name');
			$data['order_total'] = $this->get_order_total();
    		$data['ordermd'] = htmlspecialchars($this->session->userdata('ordermd'), ENT_QUOTES);
    		$data['pack_name'] = 'View Package';
    		$data['pack_prods'] = '<center><i class="fa fa-cube"></i>Products here</center>';

			$this->load->view('clinical_cart.php', $data);				
		}
	}

	// SUBMODULE: ORDERING FUNCTIONS
	function order ($id) {
		$this->form_validation->set_rules('qty', 'quantity', 'trim|required|greater_than[0]');
		$valid = $this->form_validation->run()==TRUE;
		if($valid) {
			$qty = $this->input->post('qty');
		} elseif ($this->is_in_order($id)==-1) {
			$qty = 1;
		}

		if ($this->is_in_order($id)==-1) {
			$temp_order = $this->session->userdata('order_cart');

			$sql = 'SELECT * FROM `packages` where PACKAGE_ID='.$id ;
			$sql = $this->db->query($sql) or die(mysql_error());
			
			$package= $sql->result()[0];
			array_push($temp_order, array($id,$package->PACKAGE_NAME,$qty,$package->PACKAGE_PRICE,$package->PACKAGE_TYPE));

			$this->session->set_userdata('order_cart', $temp_order);			
		}

		if($valid) {
			$data['packages'] = $this->fetch_packages('order');
			$data['products'] = $this->fetch_products_for_order();
			$data['orders'] = $this->fetch_orders();

			$data['header'] = 'Clinical Ordering for '.$this->session->userdata('patient_name');
			$data['order_total'] = $this->get_order_total();
	    	$data['ordermd'] = htmlspecialchars($this->session->userdata('ordermd'), ENT_QUOTES);
			$data['pack_name'] = 'View Package';
	    	$data['pack_prods'] = '<center><i class="fa fa-cube"></i>Products here</center>';

			$this->load_views();
			$this->load->view('clinical_cart.php', $data);
		} else {
			$this->edit($id);
		}
    }

    function is_in_order ($id) {
    	$temp_order = $this->session->userdata('order_cart');
    	$ret = -1;
    	for ($ctr=0;$ctr<count($temp_order);$ctr++) {
    		if ($temp_order[$ctr][0]==$id) {
    			$ret = $ctr;
    		}
    	}
    	return $ret;
    }

    function remove ($id) {
		$temp_order = $this->session->userdata('order_cart');
		$new_order = array();
		foreach ($temp_order as $package) {
			if ($package[0]!=$id) {
				array_push($new_order, $package);
			}
		}
		$this->session->set_userdata('order_cart', $new_order);

		$data['packages'] = $this->fetch_packages('order');
		$data['products'] = $this->fetch_products_for_order();
		$data['orders'] = $this->fetch_orders();
		
		$data['header'] = 'Clinical Ordering for '.$this->session->userdata('patient_name');
		$data['order_total'] = $this->get_order_total();			
    	$data['ordermd'] = htmlspecialchars($this->session->userdata('ordermd'), ENT_QUOTES);
		$data['pack_name'] = 'View Package';
    	$data['pack_prods'] = '<center><i class="fa fa-cube"></i>Products here</center>';
		
		$this->load_views();
		$this->load->view('clinical_cart.php', $data);
    }

    function try_edit($editid) {
		$data['packages'] = $this->fetch_packages('order');
		$data['products'] = $this->fetch_products_for_order();
		$data['orders'] = $this->fetch_orders_for_edit($editid);

		$data['header'] = 'Clinical Ordering for '.$this->session->userdata('patient_name');
		$data['order_total'] = $this->get_order_total();
    	$data['ordermd'] = htmlspecialchars($this->session->userdata('ordermd'), ENT_QUOTES);
		$data['pack_name'] = 'View Package';
    	$data['pack_prods'] = '<center><i class="fa fa-cube"></i>Products here</center>';
		
		$this->load_views();
		$this->load->view('clinical_cart.php', $data);
    }

    function edit ($editid) {
    	$this->form_validation->set_rules('qty', 'quantity', 'trim|required|greater_than[0]');
    	if ($this->form_validation->run()==FALSE) {
    		$data['bad_qty'] = TRUE;
    		$data['orders'] = $this->fetch_orders_for_edit($editid);
    	} else {
    		$newqty = $this->input->post('qty');
    		$temp_order = $this->session->userdata('order_cart');
    		$temp_order[$this->is_in_order($editid)][2] = $newqty;

    		$this->session->set_userdata('order_cart', $temp_order);
    		$data['orders'] = $this->fetch_orders();
    	}

		$data['packages'] = $this->fetch_packages('order');
		$data['products'] = $this->fetch_products_for_order();

		$data['header'] = 'Clinical Ordering for '.$this->session->userdata('patient_name');
		$data['order_total'] = $this->get_order_total();
    	$data['ordermd'] = htmlspecialchars($this->session->userdata('ordermd'), ENT_QUOTES);
		$data['pack_name'] = 'View Package';
    	$data['pack_prods'] = '<center><i class="fa fa-cube"></i>Products here</center>';
		
		$this->load_views();
		$this->load->view('clinical_cart.php', $data);
    }

	function viewpackage($id) {
    	$sql = "SELECT * FROM `packages` where PACKAGE_ID=".$id;
		$sql = $this->db->query($sql) or die(mysql_error());
		$package = $sql->result()[0];

    	$data['pack_name'] = $package->PACKAGE_NAME;
    	$data['pack_prods'] = $this->fetch_package($id);

    	$data['packages'] = $this->fetch_packages('order');
		$data['products'] = $this->fetch_products_for_order();
		$data['orders'] = $this->fetch_orders($this->session->userdata('order_id'));

		$data['header'] = 'Clinical Ordering for '.$this->session->userdata('patient_name');
		$data['order_total'] = $this->get_order_total();
    	$data['ordermd'] = htmlspecialchars($this->session->userdata('ordermd'), ENT_QUOTES);

		$this->load_views();
		$this->load->view('clinical_cart.php', $data);
    }

    function editmd() {
		if ($this->input->post('inputMD')!=NULL) {
			$this->session->set_userdata('ordermd', $this->input->post('inputMD'));
		}
		$data['packages'] = $this->fetch_packages('order');
		$data['products'] = $this->fetch_products_for_order();
		$data['orders'] = $this->fetch_orders();

		$data['header'] = 'Clinical Ordering for '.$this->session->userdata('patient_name');
		$data['order_total'] = $this->get_order_total();
		$data['ordermd'] = htmlspecialchars($this->session->userdata('ordermd'), ENT_QUOTES);
		$data['pack_name'] = 'View Package';
		$data['pack_prods'] = '<center><i class="fa fa-cube"></i>Products here</center>';

		$this->load_views();
		$this->load->view('clinical_cart.php', $data);	
    }

    function searchByPackage () {
		$sql = "SELECT * FROM `packages` WHERE PACKAGE_TYPE='M'";
		if ($this->input->post('submit') != FALSE)	
		{
			$input = mysql_real_escape_string($this->input->POST('package'));
			$sql = $sql . " AND `package_name` LIKE '%$input%'";
		}
		
		$package = new stdClass();
		$sql = $this->db->query($sql) or die(mysql_error());
        $packages = $sql->result();
		
		
		$this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'Name', 'Description', 'Price', 'Actions');
        $i = 0;
        foreach ($packages as $package) {
			$action =  anchor('/clinicalorder/viewpackage/'.$package->PACKAGE_ID, 'view', '')." "." <a style='cursor: pointer;' onclick='order_qty(".$package->PACKAGE_ID."); '>order</a>";
        	$this->table->add_row(++$i, $package->PACKAGE_NAME, $package->PACKAGE_DESC, $package->PACKAGE_PRICE, $action);
        }
        $data['packages'] = $this->table->generate();
		$data['products'] = $this->fetch_products_for_order();
		$data['orders'] = $this->fetch_orders();

		$data['header'] = 'Clinical Ordering for '.$this->session->userdata('patient_name');
		$data['order_total'] = $this->get_order_total();
    	$data['ordermd'] = htmlspecialchars($this->session->userdata('ordermd'), ENT_QUOTES);
    	$data['pack_name'] = 'View Package';
    	$data['pack_prods'] = '<center><i class="fa fa-cube"></i>Products here</center>';
			
		$this->load_views();
		$this->load->view('clinical_cart.php', $data);
    }

    function searchByProduct () {
		$sql = 'SELECT * FROM `packages` WHERE PACKAGE_TYPE="S"';
		if ($this->input->post('submit') != FALSE)	
		{
			$input = mysql_real_escape_string($this->input->POST('product'));
			$sql = $sql . " AND `package_name` LIKE '%$input%'";
		}
		
		$sql = $this->db->query($sql) or die(mysql_error());
        $packages = $sql->result();
		
		$this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'Name', 'Description', 'Price', 'Actions');
        $i = 0;
        foreach ($packages as $package) {
        	if ($this->is_in_order($package->PACKAGE_ID)==-1) {
				$this->table->add_row(++$i, $package->PACKAGE_NAME, $package->PACKAGE_DESC, $package->PACKAGE_PRICE, " <a style='cursor: pointer;' onclick='order_qty(".$package->PACKAGE_ID."); '>order</a>");
        	}
        }
		$data['products'] = $this->table->generate();
        $data['packages'] = $this->fetch_packages('order');
		$data['orders'] = $this->fetch_orders();

		$data['header'] = 'Clinical Ordering for '.$this->session->userdata('patient_name');
		$data['order_total'] = $this->get_order_total();
    	$data['ordermd'] = htmlspecialchars($this->session->userdata('ordermd'), ENT_QUOTES);
    	$data['pack_name'] = 'View Package';
    	$data['pack_prods'] = '<center><i class="fa fa-cube"></i>Products here</center>';
			
		$this->load_views();
		$this->load->view('clinical_cart.php', $data);
    }

    function cancel_order() {
    	$data['message'] = "Order for ". $this->session->userdata('patient_name') . " is cancelled.";
    	$data['redir'] = anchor('/clinicalorder', 'Create an order', '');

    	$this->session->unset_userdata('patient_id');
    	$this->session->unset_userdata('patient_name');
    	$this->session->unset_userdata('order_cart');

		$this->load_views();
		$this->load->view('clinical_cancel.php', $data);
    }

    function confirm_order() {
    	$data['mode'] = 'order';
    	$data['table_header'] = 'ORDER CART';
		$data['confirm_table'] = $this->fetch_orders_for_confirm();

		$data['prev'] = ''.base_url().'clinicalorder/';
		$data['header'] = 'Clinical Ordering for '.$this->session->userdata('patient_name');
		$data['total'] = $this->get_order_total();			
    	$data['ordermd'] = htmlspecialchars($this->session->userdata('ordermd'), ENT_QUOTES);

		$this->load_views();
		$this->load->view('clinical_confirm.php', $data);
    }

	function success() {
		$sql = "INSERT INTO `order_list` (VISIT_NUM, ORDER_MD) VALUES (".$this->session->userdata('patient_id').", '".mysql_real_escape_string($this->session->userdata('ordermd'))."')";
		$sql = $this->db->query($sql) or die(mysql_error());

		$order_id = $this->db->insert_id();
		foreach ($this->session->userdata('order_cart') as $packprod) {
		    $sql = "INSERT INTO `order_line` VALUES (".$order_id.", ".$packprod[0].", ".$packprod[2].")";
			$sql = $this->db->query($sql) or die(mysql_error());
		}

		$sql = "SELECT patients.true_id FROM `patients`, `appointments` WHERE appointments.visit_num = ".$this->session->userdata('patient_id')." and appointments.true_id = patients.true_id";
		$sql = $this->db->query($sql) or die(mysql_error());
		$pat_id = $sql->result()[0]->true_id;

    	$data['message'] = "Order for ". $this->session->userdata('patient_name') . " is finalized.";
    	$data['redir'] = "<form method='GET' action='".site_url("clinicalorder/")."'><input type='submit' class='btn-link' value='Create another order'></form><form method='POST' action='".site_url("billing/displayBill/")."'><input type='submit' class='btn-link' value='View Bill'></input><input type='hidden' name='id' value=".$pat_id."></input></form>";


		$this->session->unset_userdata('patient_id');
    	$this->session->unset_userdata('patient_name');
    	$this->session->unset_userdata('order_cart');

		$this->load_views();
		$this->load->view('clinical_success.php', $data);
    }

	function load_views() {
		$this->load->view('header.php');			
		$this->load->view('navbar.php');
		$this->load->view('clinical_sidebar.php');
		$this->load->view('footer.php');
	}

	function get_order_total() {
    	$price = 0;
	    foreach ($this->session->userdata('order_cart') as $packprod) {
			$price += $packprod[2] * $packprod[3];
		}
		return $price;
    }

	function fetch_admitted_pats ($query = "") {
		$date_arr = getdate();
		$date_str = $date_arr['year']."-".$date_arr['mon']."-".$date_arr['mday'];
		$query = mysql_real_escape_string($query);
    	$sql = "SELECT * FROM `patients`, `appointments` where ( last_name LIKE ? or first_name LIKE ? or middle_name LIKE ? ) and appoint_date = ? and patients.true_id = appointments.true_id and time_out is null";
		$sql = $this->db->query($sql, array("%".$query."%","%".$query."%","%".$query."%",$date_str)) or die(mysql_error());
		$patients = $sql->result();

		$this->table->set_empty("&nbsp;");
        $this->table->set_heading('<i class="icon_profile"></i> Patient ID', '<i class="icon_profile"></i> Name', '<i class="icon_cogs"></i> Action');
        $i = 0;
        foreach ($patients as $patient) {
        	$this->table->add_row(++$i, $patient->last_name.", ".$patient->first_name." ".$patient->middle_name, "<form method='POST' action='http://". $_SERVER['SERVER_NAME']. $_SERVER['REQUEST_URI']."'><input type='submit' value='Select' class='btn btn-primary'/><input type='hidden' name='selected' value='{$patient->visit_num}'/></form>");
        }

        return $this->table->generate();
    }

    function fetch_products_for_order () {
    	$sql = 'SELECT * FROM `packages` where PACKAGE_TYPE="S"' ;
		$sql = $this->db->query($sql) or die(mysql_error());
		
		$packages= $sql->result();

        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'Name', 'Description', 'Price', 'Actions');
        $i = 0;
        foreach ($packages as $package) {
        	if($this->is_in_order($package->PACKAGE_ID)==-1) {
        		$this->table->add_row(++$i, $package->PACKAGE_NAME, $package->PACKAGE_DESC, $package->PACKAGE_PRICE, " <a style='cursor: pointer;' onclick='order_qty(".$package->PACKAGE_ID."); '>order</a>");
        	}
        }

        return $this->table->generate();
    }

    function fetch_packages ($mode) {
    	$sql = 'SELECT * FROM `packages` where PACKAGE_TYPE="M"' ;
		$sql = $this->db->query($sql) or die(mysql_error());
		
		$packages= $sql->result();

		$this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'Name', 'Description', 'Price', 'Actions');
        $i = 0;
        foreach ($packages as $package) {
		    if ($mode=='select') {
				$action = "<form method='POST' action='http://". $_SERVER['SERVER_NAME']. $_SERVER['REQUEST_URI']."'><input type='submit' value='Select' class='btn btn-primary'/><input type='hidden' name='selected' value='".$package->PACKAGE_ID."'/></form>";
			} else if ($mode=='order') {
				$action =  anchor('/clinicalorder/viewpackage/'.$package->PACKAGE_ID, 'view', '');
				if ($this->is_in_order($package->PACKAGE_ID)==-1) {
					$action.= " <a style='cursor: pointer;' onclick='order_qty(".$package->PACKAGE_ID."); '>order</a>";
				}
			}
        	$this->table->add_row(++$i, $package->PACKAGE_NAME, $package->PACKAGE_DESC, $package->PACKAGE_PRICE, $action);
        }
        return $this->table->generate();
    }

    function fetch_orders() {
		if (count($this->session->userdata('order_cart'))>0) {
			$temp_order = $this->session->userdata('order_cart'); 

	        $this->table->set_empty("&nbsp;");
	        $this->table->set_heading('No', 'Name', 'Quantity', 'Price Per Unit', 'Subtotal', 'Actions');
	        $i = 0;
	        foreach ($temp_order as $product) {
	        	$id = $product[0];
	        	$name = $product[1];
	        	$qty = $product[2];
	        	$price = $product[3];
	        	if ($product[4]=='M') {
	        		$this->table->add_row(++$i, $name, $qty, $price, $price*$qty, anchor('/clinicalorder/try_edit/'.$id, 'edit', '') .'   '.anchor('/clinicalorder/remove/'.$id, 'remove', ''));
	        	}
	        }
	        foreach ($temp_order as $product) {
	        	$id = $product[0];
	        	$name = $product[1];
	        	$qty = $product[2];
	        	$price = $product[3];
	        	if ($product[4]=='S') {
	        		$this->table->add_row(++$i, $name, $qty, $price, $price*$qty, anchor('/clinicalorder/try_edit/'.$id, 'edit', '') .'   '.anchor('/clinicalorder/remove/'.$id, 'remove', ''));
	        	}
	        }
	        
	        return $this->table->generate();
		} else {
			return '<i class="fa fa-shopping-cart"></i><span>Add items to cart</span>';
		}
    }

    function fetch_package($id) {
    	$sql = "SELECT * FROM `package_products` where PACKAGE_ID=".$id;
		$sql = $this->db->query($sql) or die(mysql_error());
		$package = $sql->result();

		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('No', 'Product Name', 'Quantity');

        $i = 0;
        foreach ($package as $product) {
        	$sql = "SELECT * FROM `products` where PRODUCT_ID=".$product->PRODUCT_ID;
			$sql = $this->db->query($sql) or die(mysql_error());
			$product_dets = $sql->result()[0];
			$this->table->add_row(++$i, $product_dets->PRODUCT_NAME, $product->QUANTITY);
        }

        return $this->table->generate();
    }

    function fetch_orders_for_edit ($editid) {
		$temp_order = $this->session->userdata('order_cart'); 

        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'Name', 'Quantity', 'Price Per Unit', 'Subtotal', 'Actions');
        $i = 0;
        foreach ($temp_order as $product) {
        	$id = $product[0];
        	$name = $product[1];
        	$qty = $product[2];
        	$price = $product[3];

        	if ($product[4]=='M') {
				if($id==$editid) {
					$form = "
						<div class='row'>
							<form action='".site_url("clinicalorder/edit/".$id)."' method=POST class='form-inline'>
								<div class='form-group'>
									<input type='text' name='qty' class='form-control col-md-4' value='".$qty."'/>
								</div> 
								<input type='submit' class='btn btn-default' value='confirm'/>
							</form>
						</div>
					";
					$this->table->add_row(++$i, $name, $form, $price, $price*$qty, anchor('/clinicalorder/remove/'.$id, 'remove', ''));
				} else {
		            $this->table->add_row(++$i, $name, $qty, $price, $price*$qty, anchor('/clinicalorder/try_edit/'.$id, 'edit', '') .' '.anchor('/clinicalorder/remove/'.$id, 'remove', ''));
				}        		
        	}
        }
         foreach ($temp_order as $product) {
        	$id = $product[0];
        	$name = $product[1];
        	$qty = $product[2];
        	$price = $product[3];

        	if ($product[4]=='S') {
				if($id==$editid) {
					$form = "
						<div class='row'>
							<form action='".site_url("clinicalorder/edit/".$id)."' method=POST class='form-inline'>
								<div class='form-group'>
									<input type='text' name='qty' class='form-control col-md-4' value='".$qty."'/>
								</div> 
								<input type='submit' class='btn btn-default' value='confirm'/>
							</form>
						</div>
					";
					$this->table->add_row(++$i, $name, $form, $price, $price*$qty, anchor('/clinicalorder/remove/'.$id, 'remove', ''));
				} else {
		            $this->table->add_row(++$i, $name, $qty, $price, $price*$qty, anchor('/clinicalorder/try_edit/'.$id, 'edit', '') .' '.anchor('/clinicalorder/remove/'.$id, 'remove', ''));
				}        		
        	}
        }
        return $this->table->generate();
    }

    function fetch_orders_for_confirm() {
    	$temp_order = $this->session->userdata('order_cart'); 

        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'Name', 'Quantity', 'Price Per Unit', 'Subtotal');
        $i = 0;
        foreach ($temp_order as $product) {
        	$name = $product[1];
        	$qty = $product[2];
        	$price = $product[3];

            $this->table->add_row(++$i, $name, $qty, $price, $price*$qty);
        }
	        
	    return $this->table->generate();
    }
}
?>