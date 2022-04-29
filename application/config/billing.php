<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Billing extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
	}
	
	/*
	 * Index function for displaying the billing main page
	 *
     */
	public function index() {
		$this->load->view('header.php');
		$this->load->view('navbar.php');
		$this->load->view('billing_sidebar.php');
		$this->generateBillingTables();
		$this->load->view('bill_result.php');
		$this->load->view('footer.php');
	}
	
	/*
	 * Function for generating the tables in used exclusively for billing
	 *
     */
	private function generateBillingTables() {
		$sql = "CREATE TABLE IF NOT EXISTS `patient_bills` (
					`true_id` int(20) DEFAULT NULL,
					`bill_no` int(10) DEFAULT NULL,
					`curr_year` int(4) DEFAULT NULL,
					`bill_encounter` int(6) DEFAULT NULL,
					`date_inserted` timestamp DEFAULT CURRENT_TIMESTAMP,
					`isPaid` int(1) DEFAULT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$this->db->query($sql);
		$sql = "CREATE TABLE IF NOT EXISTS `bill_recordables` (
					`bill_no` int(10) DEFAULT NULL,
					`others_field` varchar(250) DEFAULT NULL,
					`others_amount` int(10) DEFAULT NULL,
					`subtotal` int(10) DEFAULT NULL,
					`discount` int(10) DEFAULT NULL,
					`vat` int(2) DEFAULT NULL,
					`total_payment_required` int(10) DEFAULT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$this->db->query($sql);
		$sql = "CREATE TABLE IF NOT EXISTS `payment_details` (
					`bill_no` int(10) DEFAULT NULL,
					`installment_no` int(10) DEFAULT NULL,
					`mode_of_payment` varchar(20) DEFAULT NULL,
					`details` varchar(250) DEFAULT NULL,
					`bank` varchar(250) DEFAULT NULL,
					`expiration_date` datetime DEFAULT NULL,
					`card_no` int(20) DEFAULT NULL,
					`company` varchar(250) DEFAULT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$this->db->query($sql);
		$sql = "CREATE TABLE IF NOT EXISTS `packages_per_bill` (
					`bill_no` int(10) DEFAULT NULL,
					`order_id` int(11) DEFAULT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$this->db->query($sql);	
		$sql = "CREATE TABLE IF NOT EXISTS `anesthesias_per_bill` (
					`bill_no` int(10) DEFAULT NULL,
					`anreq_id` int(11) DEFAULT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$this->db->query($sql);	
		$sql = "CREATE TABLE IF NOT EXISTS `billing_archive` (
					`bill_no` int(10) DEFAULT NULL,
					`installment_no` int(10) DEFAULT NULL,
					`amount_deposited` int(10) DEFAULT NULL,
					`installment_date` timestamp DEFAULT CURRENT_TIMESTAMP
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$this->db->query($sql);
	}
	
	/*
	 * Function for querying the database and returning the resultant array
     * $field must always just be a single field
	 * $table is the table from which you will get the data
	 * $criteria is the conditions that must be satisfied
	 */
	private function queryDatabase($field, $table, $criteria) {
		$sql = "SELECT $field FROM $table WHERE $criteria;";
		$sql = $this->db->query($sql) or die(mysql_error());
		$result_array = array();
		if($sql->num_rows() > 0) {
			$counter = 0;
			foreach($sql->result() as $result) {
				$result_array[$counter] = $result->$field;
				$counter = $counter + 1;
			}
		}
		return $result_array;
	}
	
	public function searchByName() {
		$this->load->view('header.php');
		$this->load->view('navbar.php');
		$this->load->view('billing_sidebar.php');
		if(isset($_GET['searched'])) {
			$counter = 0;
			$options = array();
			$last_name = "";
			$first_name = "";
			
			if(isset($_GET['last_name'])) { $last_name = $_GET['last_name']; }
			if(isset($_GET['first_name'])) { $first_name = $_GET['first_name']; }
			
			
			$ids = $this->queryDatabase("true_id", "patients", "last_name LIKE '%$last_name%' AND first_name LIKE '%$first_name%' AND true_id IN (SELECT true_id FROM `appointments`)");
			if($ids != null) {
				$fnames = $this->queryDatabase("first_name", "patients", "true_id IN (" . implode(" ,", $ids ) . ")");
				$lnames = $this->queryDatabase("last_name", "patients", "true_id IN (" . implode(" ,", $ids ) . ")");
				
				for($i = 0; $i < count($fnames); $i++) {
					$options[$i][0] = $fnames[$i];
					$options[$i][1] = $lnames[$i];
					$options[$i][2] = $ids[$i];
				}
				
				$data = new stdClass();
				$data->results = $options;
				$this->load->view('displayMatches.php', $data);
			}
			else {
				$this->load->view('billing_result_not_found.php');
			} 
			$this->load->view('footer.php');
		}
		else {
			$this->load->view('searchByName.php');
			$this->load->view('footer.php');
		}
	}
	
	public function searchByID() {
		$this->load->view('header.php');
		$this->load->view('navbar.php');
		$this->load->view('billing_sidebar.php');
		$this->load->view('searchByID.php');
		$this->load->view('footer.php');
	}
	
	public function displayBill() {
		$this->load->view('header.php');
		$this->load->view('navbar.php');
		$this->load->view('billing_sidebar.php');
		$data = new stdClass();
		$data->id = "";
		if(isset($_POST['id'])) {
			$data->id = $_POST['id'];
			$ids = $this->queryDatabase("true_id", "appointments", "true_id LIKE '%%'");
			if($ids != null) {
				if(in_array($_POST['id'], $ids)) {
					$this->load->view('bill_frame.php', $data);
				}
				else {
					$this->load->view('billing_result_not_found.php');
				}
			}
			else {
				$this->load->view('billing_result_not_found.php');
			}
		}
		$this->load->view('footer.php');
	}
	
	/*
	 * Create a the UI for the unbilled items
	 */
		public function createNewBill() {
		$id = "";
		if(isset($_POST['id'])) {
			$id = $_POST['id'];
		}
		
// - - - - - - - -  - - - - - - - -  - - - - - - - - gui part for personal & receiptual info - - - - - - - -  - - - - - - - -  - - - - - - - -  - - - - - - - 
		$bill_no = $this->generateBillNumber();
		$name = $this->queryDatabase("last_name", "patients", "true_id = '$id'")[0] . ", " . 
				$this->queryDatabase("first_name", "patients", "true_id = '$id'")[0] . " " . 
				$this->queryDatabase("middle_name", "patients", "true_id = '$id'")[0];
		$address = $this->queryDatabase("address", "patients", "true_id = '$id'")[0];
		$sex = $this->queryDatabase("sex", "patients", "true_id = '$id'")[0];
		if($sex == 0) { $sex = "Female"; }
		else { $sex = "Male"; }
		$birthdate = $this->queryDatabase("birthday", "patients", "true_id = '$id'")[0];
		$healthcard_type = $this->queryDatabase("card_type", "healthcards", "true_id = '$id'");
		$healthcard_num = $this->queryDatabase("card_num", "healthcards", "true_id = '$id'");
		$transaction_info = " 
							<div class = 'panel-content'>
								<div class='col-xs-2' style = 'float: right;'>
								<b>Bill No: </b><input type = 'text' class = 'form-control' id = 'bill_no' value = '$bill_no[0]'  readonly = 'true' style = 'text-align: center; font-weight:bold;'> 
							</div>
							</br>
							</br>
							</br>
							</br>
							<input type = 'hidden' id = 'bill_year' value = '$bill_no[1]'>
							  <input type = 'hidden' id = 'bill_encounter' value = '$bill_no[2]'>
							<div class='col-xs-4'>
							   <b>Name: </b><input type = 'text' class = 'form-control' id = 'bill_no' value = '$name' readonly = 'true' style = 'text-align: center; font-weight:bold;'> 
							  </div>
							  <div class='col-xs-2' style = 'margin-left: 10%;' >
							   <b>Birthdate: </b><input type = 'text'  class = 'form-control' id = 'bill_no' value = '$birthdate' readonly = 'true' style = 'text-align: center; font-weight:bold;'> 
							  </div>
							  <br/>
							  <br/>
							  <br/>
							  <br/>
							 <div class='col-xs-4'>
							   <b>Address: </b><input type = 'text' class = 'form-control' id = 'bill_no' value = '$address' readonly = 'true' style = 'text-align: center; font-weight:bold;'> 
							  </div>
							  <div class='col-xs-2' style = 'margin-left: 10%;' >
							  <b>Sex: </b><input type = 'text' class = 'form-control' id = 'bill_no' value = '$sex' readonly = 'true' style = 'text-align: center; font-weight:bold;'> 
							  </div>
							  <br/>
							  <br/>
							  <br/>
							  <br/>
						    ";
		if($healthcard_type != null ) {
			if($healthcard_type[0] == 1) {
			$transaction_info = $transaction_info . " <div class ='col-xs-4'>
														<b>Philhealth: </b><input type = 'text' class = 'form-control' id = 'bill_no' value = '$healthcard_num[0]' readonly = 'true' style = 'text-align: center; font-weight:bold;'>
													  </div>
													  <div class ='col-xs-2' style = 'margin-left: 10%;' >
													  <b>HMO: </b><input type = 'text' class = 'form-control' id = 'bill_no' value = 'N/A' readonly = 'true' style = 'text-align: center; font-weight:bold;'>
													  </div>";
			}
			else {
				$transaction_info = $transaction_info . " <div class ='col-xs-4'>
														<b>Philhealth: </b><input type = 'text' class = 'form-control' id = 'bill_no' value = 'N/A' readonly = 'true' style = 'text-align: center; font-weight:bold;'>
													  </div>
													  <div class ='col-xs-2' style = 'margin-left: 10%;' >
													  <b>HMO: </b><input type = 'text' class = 'form-control' id = 'bill_no' value = '$healthcard_num[0]' readonly = 'true' style = 'text-align: center; font-weight:bold;'> 
													  </div>";
			}
		}
		else {
			$transaction_info = $transaction_info . " <div class ='col-xs-4'>
														<b>Philhealth: </b><input type = 'text' class = 'form-control' id = 'bill_no' value = 'N/A' readonly = 'true' style = 'text-align: center; font-weight:bold;'>
													  </div>
													  <div class ='col-xs-2' style = 'margin-left: 10%;' >
													  <b>HMO: </b><input type = 'text' class = 'form-control' id = 'bill_no' value = 'N/A' readonly = 'true' style = 'text-align: center; font-weight:bold;'>
													  </div>";
		}
		
		$subtotal = 0;
		$vat = 12;
		
// - - - - -  - - - - - - - - - - - - - - - -  -gui part for packages - - - - -  - - - - - - - - - - - - - - - - - - - - -  - - - - - - - - - - - - - - - - - -
		$visit_num = $this->queryDatabase("visit_num", "appointments", "true_id = '$id'");
		$order_ids = $this->queryDatabase("order_id", "order_list", "visit_num IN (" . implode(" ,", $visit_num) . ") AND order_id NOT IN (SELECT order_id FROM `packages_per_bill`)");
		$products = "";
		
		if(count($order_ids) > 0) {
			$package['id'] = $this->queryDatabase("package_id", "order_line", "order_id IN (" . implode(" ,", $order_ids) . ")");
			$package['qty'] = $this->queryDatabase("quantity", "order_line", "order_id IN (" . implode(" ,", $order_ids) . ")");
			$package['name'] = $this->queryDatabase("package_name", "packages", "package_id IN (" . implode(" ,", $package['id']) . ")");
			$package['price'] = $this->queryDatabase("package_price", "packages", "package_id IN (" . implode(" ,", $package['id']) . ")");
			$package['type'] = $this->queryDatabase("package_type", "packages", "package_id IN (" . implode(" ,", $package['id']) . ")");
			$package['case_rate'] = array();
			for($i = 0; $i < count($package['name']); $i++) {
				$package['case_rate'][$i] = 0;
				if($healthcard_type != null) {
					if($healthcard_type[0] == 1) {
						if($package['type'][$i] == "P") {
							$package_name = $package['name'][$i];
							$package['case_rate'][$i] = $this->queryDatabase("case_rate", "outside_procedures", "$package_name = rvs_code")[0];
						}
					}
				}
			}
			$package['professional_fee'] = $this->queryDatabase("package_pf", "packages", "package_id IN (" . implode(" ,", $package['id']) . ")");
			
			$products = $products . "
								<br/><br/> <br/> <br/> <br/> <br/><div class = 'container'>
					<table class = 'table table-bordered table-hover'>
								<thead>"
						. "<tr class=success>
							<th><center> Procedure Name </center></th> 
							<th><center> Procedure Price </center></th>
							<th><center> Professional Fee </center></th>
							<th><center> Numbers of Procedures Done </center></th>
							<th><center> Procedure Case Rate </center></th>
							<th><center> Total Procedural Cost </center></th>
						  </tr>
						  </thead>
						  <tbody>";
			for($i = 0; $i < count($package['name']); $i++) {
				if($package['type'][$i] == "P") {
					$products = $products . "<tr>" .
												"<td><center>" . $package['name'][$i] . "</center></td>" .
												"<td><center>" . $package['price'][$i] . "</center></td>" .
												"<td><center>" . 0 . "</center></td>" .
												"<td><center>" . $package['qty'][$i] . "</center></td>" .
												"<td><center>" . (str_replace(',', '', $package['case_rate'][$i])) . "</center></td>" .
												"<td><center>" . ($package['price'][$i] - (str_replace(',', '', $package['case_rate'][$i]))) * $package['qty'][$i] . "</center></td>" .
											"</tr>";
					$subtotal = $subtotal + (($package['price'][$i] - (str_replace(',', '', $package['case_rate'][$i]))) * $package['qty'][$i]);
				}
				else if($package['type'][$i] == "M") {
					
					$products = $products . "<tr>" .
												"<td><center>" . $package['name'][$i] . "</center></td>" .
												"<td><center>" . $package['price'][$i] . "</center></td>" .
												"<td><center>" . $package['professional_fee'][$i] . "</center></td>" .
												"<td><center>" . $package['qty'][$i] . "</center></td>" .
												"<td><center>" . 0 . "</center></td>" .
												"<td><center>" . ($package['price'][$i] + $package['professional_fee'][$i]) * $package['qty'][$i] . "</center></td>" .
											"</tr>";
					$subtotal = $subtotal + (($package['price'][$i] + $package['professional_fee'][$i]) * $package['qty'][$i]);
				}
			}
			$products = $products . "
			</tbody>
			</table>
			</div>";
			
			$products = $products . "<div class = 'container'>
					<table class = 'table table-bordered table-hover'>
								<thead>"
						. "<tr class=success>
							<th><center> Item Name </center></th> 
							<th><center> Item Price </center></th>
							<th><center> Item Quantity </center></th>
							<th><center> Total Procedural Cost </center></th>
						  </tr>
						  </thead>
						  <tbody>";
			for($i = 0; $i < count($package['name']); $i++) {
				if($package['type'][$i] == "S") {
					$products = $products . "<tr>" .
												"<td><center>" . $package['name'][$i] . "</center></td>" .
												"<td><center>" . $package['price'][$i] . "</center></td>" .
												"<td><center>" . $package['qty'][$i] . "</center></td>" .
												"<td><center>" . $package['price'][$i] * $package['qty'][$i]. "</center></td>" .
											"</tr>";
					$subtotal = $subtotal + ($package['price'][$i] * $package['qty'][$i]);
				}
			}
			$products = $products . "
			</tbody>
			</table>
			</div>";
		}
		
		$an_cost = array_sum($this->queryDatabase("an_cost", "additional_costs", "visit_num IN (" . implode(" ,", $visit_num) . ") AND anreq_id NOT IN (SELECT anreq_id FROM anesthesias_per_bill)"));
		$other_cost = array_sum($this->queryDatabase("other_cost", "additional_costs", "visit_num IN (" . implode(" ,", $visit_num) . ") AND anreq_id NOT IN (SELECT anreq_id FROM anesthesias_per_bill)"));
		
		$subtotal = round($subtotal + $an_cost + $other_cost);
		
		$products = $products . "<br/><br/><br/><br/><div class = 'panel' style = 'margin-right : 25%;'>
									<div class = 'panel-heading'>
										<b><h4>Miscellaneous</h4></b>
									</div>
							    <div class = 'panel-content'><div class='col-xs-4'><b>Total Anesthesia Cost: </b><input type = 'text' class = 'form-control' id = 'an_cost' value = '$an_cost' readonly = 'true' style = 'text-align: center; font-weight:bold;'></div>		";
		$products = $products . "<div class='col-xs-4' style = 'margin-left: 10%;'><b>Other Costs: </b><input type = 'text' class = 'form-control' id = 'an_cost' value = '$other_cost' readonly = 'true' style = 'text-align: center; font-weight:bold;'></div></div> <br/> <br/><br/><br/> ";
		
		$discount = 0;
		$bday = $this->queryDatabase("birthday","patients","true_id = $id" ); //added this
		$date = new DateTime($bday[0]);
		$now = new DateTime();
		$age = $now->diff($date);
		if($age->y>=60){
			$discount = 20;
		} //until here
		
		$total = round((($subtotal - ($subtotal * $discount * 0.01)) * $vat * 0.01) + ($subtotal - ($subtotal * $discount * 0.01)));
// - - - - - - - -  - - - - - - - - gui part for recordables  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 	
		$recordables = "<div class='col-xs-4'>
						<b>Others: </b><input type = 'text' class = 'form-control' id = 'others_text' value = '' placeholder = 'Enter other items here' style = 'text-align: center; font-weight:bold;'> 
						</div>
						<div class='col-xs-2' style = 'margin-left: 10%;'>
						<b>Amount: PHP </b><input type = 'text' class = 'form-control' id = 'others_amount' value = '' style = 'text-align: center; font-weight:bold;' placeholder = '0'>
						</div></div>
						</br>
						</br>
						<div class = 'col-xs-3' style = 'float:right'>
						 <b>Subtotal: PHP</b><input type = 'text' class = 'form-control' id = 'subtotal' value = '$subtotal' readonly= 'true' style = 'text-align: center; font-weight:bold;'>
						 <input type = 'hidden' class = 'form-control' id = 'orig_subtotal' value = '$subtotal'> 
						 </div>
						 </br>
						 </br>
						 </br>
						 </br>
						 <div class = 'panel' style = 'margin-right : 25%;'>
									<div class = 'panel-heading'>
										<b><h4>Discount & Vat</h4></b>
									</div>
								<div class = 'panel-content'>
						 <div class='col-xs-4'>
						<b>Discount: Percent </b><input type = 'text' class = 'form-control' id = 'discount' value = '$discount' maxlength = '2' style = 'text-align: center; font-weight:bold;'>  
						</div>
						 <div class='col-xs-2' style = 'margin-left : 10%;'>
						<b>VAT: Percent </b><input type = 'text' class = 'form-control' id = 'vat' value = '$vat' maxlength = '2' style = 'text-align: center; font-weight:bold;'>
						 </div>
						</div>	</div>
						 <div class = 'col-xs-4' style = 'float:right'>
						<b> Total Payment Required: PHP </b><input type = 'text' class = 'form-control' id = 'payment_required' value = '$total'  readonly = 'true' style = 'text-align: center; font-weight:bold;'>
						</div>
						</div><br/><br/><br/>
					   ";
		$pay_button = "<span> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <button class='btn btn-primary'  id = 'pay_new'> Confirm Bill </button> ";
		
		echo $transaction_info . $products . $recordables . $pay_button;
	}
	
	public function generateModeOfPayments() {
		$mode = $_POST['mode'];
		if($mode == "Check") {
			
			echo "  <div class='col-xs-4' style = 'margin-left: 1%;' >  <br><br><b>Transaction through Check:</b></div><br/><br/><br/><br/>
				     <div class='col-xs-2' style = 'margin-left: 1%;' ><b> Details: </b><textarea id = 'details' class = 'form-control' style = 'text-align: center; font-weight:bold;'> </textarea> </div><br/><br/><br/><br/>
				   <div class='col-xs-2' style = 'margin-left: 1%;' ><b> Bank: </b><input type = 'text' id = 'bank' class = 'form-control' style = 'text-align: center; font-weight:bold;'> </input></div> ";
		}
		else if($mode == "Card") {
			echo "   <div class='col-xs-4' style = 'margin-left: 1%;' >  <br><br><b>Transaction through Card:</b></div><br/><br/><br/><br/>
				     <div class='col-xs-2' style = 'margin-left: 1%;' ><b> Details: </b><textarea id = 'details' class = 'form-control' style = 'text-align: center; font-weight:bold;'> </textarea> </div><br/><br/><br/><br/>
				       <div class='col-xs-2' style = 'margin-left: 1%;' ><b> Card No: </b><input type = 'text' id = 'card_no' class = 'form-control' style = 'text-align: center; font-weight:bold;'> </input>  </div><br/><br/><br/><br/>
				     <div class='col-xs-2' style = 'margin-left: 1%;' ><b>  Expiration Date: </b><input type = 'text' id = 'exp_date' class = 'form-control' style = 'text-align: center; font-weight:bold;'> </input> </div> ";
		}
		else if($mode == "Charge") {
			echo "   <div class='col-xs-4' style = 'margin-left: 1%;' >  <br><br><b>Transaction through Charge:</b></div><br/><br/><br/><br/>
				     <div class='col-xs-2' style = 'margin-left: 1%;' ><b> Details: </b><textarea id = 'details' class = 'form-control' style = 'text-align: center; font-weight:bold;'> </textarea> </div><br/><br/><br/><br/>
				     <div class='col-xs-2' style = 'margin-left: 1%;' ><b>  Company: </b><input type = 'text' id = 'company' class = 'form-control' style = 'text-align: center; font-weight:bold;'> </input></div>  ";
		}
	}
	
	/**
	 *	Function for generating the bill number
	 *
	 */
	private function generateBillNumber() {
		$bill_no = array();
		$bill_no[0] = date("Y") . "" . str_pad(1, 6, "0", STR_PAD_LEFT);
		$bill_no[1] = date("Y");
		$bill_no[2] = str_pad(1, 6, "0", STR_PAD_LEFT);
		$encounter = $this->queryDatabase("bill_encounter", "patient_bills", "date_inserted = (SELECT max(date_inserted) as date_inserted FROM patient_bills)");
		if($encounter != null) {
			$curr_year = $this->queryDatabase("curr_year", "patient_bills", "bill_encounter = '$encounter[0]'");
			if($curr_year[0] == date("Y") ) {
				$bill_no[0] = date("Y") . "" . str_pad($encounter[0] + 1, 6, "0", STR_PAD_LEFT);
				$bill_no[1] = date("Y");
				$bill_no[2] = str_pad($encounter[0] + 1, 6, "0", STR_PAD_LEFT);
			}
		}
		return $bill_no;
	}
	
	/**
	 *	Function for recording the items used in the bill to the database for later reading
	 *
	 */
	public function recordNewBill() {
		// fill up the patient bills table
		// 1 for paid
		$id = $_POST['id'];
		$bill_no = $_POST['bill_no'];
		$curr_year = $_POST['bill_year'];
		$bill_encounter = $_POST['bill_encounter'];
		$sql = "INSERT INTO `patient_bills` (`true_id`, `bill_no`, `curr_year`, `bill_encounter`, `isPaid`)
				VALUES ('$id', '$bill_no', '$curr_year', '$bill_encounter', '0');";
		$sql = $this->db->query($sql) or die(mysql_error());
		
		// fill up the bill recordables table
		$others_field = $_POST['others'];
		$others_amount = $_POST['others_amount'];
		$subtotal = $_POST['subtotal'];
		$discount = $_POST['discount'];
		$vat = $_POST['vat'];
		$total_payment_required = $_POST['payment_required'];
		$sql = "INSERT INTO `bill_recordables` (`bill_no`, `others_field`, `others_amount`,`subtotal`,`discount`,`vat`, `total_payment_required`)
			    VALUES ('$bill_no', '$others_field', '$others_amount', '$subtotal', '$discount', '$vat', '$total_payment_required');";
		$sql = $this->db->query($sql) or die(mysql_error());
		
		//fill up the packages per bill table
		$visit_num = $this->queryDatabase("visit_num", "appointments", "true_id = '$id'");
		$order_ids = $this->queryDatabase("order_id", "order_list", "visit_num IN (" . implode(" ,", $visit_num) . ") AND order_id NOT IN (SELECT order_id FROM `packages_per_bill`)");
		for($i = 0; $i < count($order_ids); $i++) {
			$order_id = $order_ids[$i];
			$sql = "INSERT INTO `packages_per_bill` (`bill_no`, `order_id`) 
					VALUES ('$bill_no', '$order_id');";
			$sql = $this->db->query($sql) or die(mysql_error());
		}
		
		// fill the additional_costs table
		$anreq_ids = $this->queryDatabase("anreq_id", "additional_costs", "visit_num IN (" . implode(" ,", $visit_num) . ") AND anreq_id NOT IN (SELECT anreq_id FROM anesthesias_per_bill)");
		for($i = 0; $i < count($anreq_ids); $i++) {
			$anreq_id = $anreq_ids[$i];
			$sql = "INSERT INTO `anesthesias_per_bill` (`bill_no`, `anreq_id`) 
					VALUES ('$bill_no', '$anreq_id');";
			$sql = $this->db->query($sql) or die(mysql_error());
		}
		
		/*if($bill_no != null){
			$this->generateInvoice($bill_no, $id); //added
		}*/
	}
	
	/**
	 *	Function for displaying the bill numbers of the unpayed (fully) bills
	 *
	 */
	public function showPendingBills() {

		$id = "";
		if(isset($_POST['id'])) { $id = $_POST['id']; }
		$bill_nos = $this->queryDatabase("bill_no", "patient_bills", "true_id = '$id' AND isPaid = '0'");
		$buttons = "";
		for($i = 0; $i < count($bill_nos); $i++) {
			$bill_no = $bill_nos[$i];
			$buttons = $buttons . "<button class='btn btn-primary pending' id = '$bill_no'> $bill_no </button> ";
		}
		echo $buttons;
	}
	
	/**
	 *	Function for showing the UI of the bill
	 *
	 */
	public function showExistingBill() {
		$id = "";
		$bill_no = "";
		if(isset($_POST['id'])) { $id = $_POST['id']; }
		if(isset($_POST['bill_no'])) { $bill_no = $_POST['bill_no']; }
		
// - - - - - - - -  - - - - - - - -  - - - - - - - - gui part for personal & receiptual info - - - - - - - -  - - - - - - - -  - - - - - - - -  - - - - - - - 
		$name = $this->queryDatabase("last_name", "patients", "true_id = '$id'")[0] . ", " . 
				$this->queryDatabase("first_name", "patients", "true_id = '$id'")[0] . " " . 
				$this->queryDatabase("middle_name", "patients", "true_id = '$id'")[0];
		$address = $this->queryDatabase("address", "patients", "true_id = '$id'")[0];
		$sex = $this->queryDatabase("sex", "patients", "true_id = '$id'")[0];
		if($sex == 0) { $sex = "Female"; }
		else { $sex = "Male"; }
		$birthdate = $this->queryDatabase("birthday", "patients", "true_id = '$id'")[0];
		$healthcard_type = $this->queryDatabase("card_type", "healthcards", "true_id = '$id'");
		$healthcard_num = $this->queryDatabase("card_num", "healthcards", "true_id = '$id'");
		$transaction_info = " 
							<div class = 'panel-content'>
								<div class='col-xs-2' style = 'float: right;'>
								<b>Bill No: </b><input type = 'text' class = 'form-control' id = 'bill_no' value = '$bill_no' readonly = 'true' style = 'text-align: center; font-weight:bold;'> 
							</div>
							</br>
							</br>
							</br>
							</br>
							<div class='col-xs-4'>
							   <b>Name: </b><input type = 'text' class = 'form-control' id = 'bill_no' value = '$name' readonly = 'true' style = 'text-align: center; font-weight:bold;'> 
							  </div>
							  <div class='col-xs-2' style = 'margin-left: 10%;'>
							   <b>Birthdate: </b><input type = 'text'  class = 'form-control' id = 'bill_no' value = '$birthdate' readonly = 'true' style = 'text-align: center; font-weight:bold;'> 
							  </div>
							  <br/>
							  <br/>
							  <br/>
							  <br/>
							 <div class='col-xs-4'>
							   <b>Address: </b><input type = 'text' class = 'form-control' id = 'bill_no' value = '$address' readonly = 'true' style = 'text-align: center; font-weight:bold;'> 
							  </div>
							  <div class='col-xs-2' style = 'margin-left: 10%;' >
							  <b>Sex: </b><input type = 'text' class = 'form-control' id = 'bill_no' value = '$sex' readonly = 'true' style = 'text-align: center; font-weight:bold;'> 
							  </div>
							  <br/>
							  <br/>
							  <br/>
							  <br/>
						    ";
		if($healthcard_type != null ) {
			if($healthcard_type[0] == 1) {
			$transaction_info = $transaction_info . " <div class ='col-xs-4'>
														<b>Philhealth: </b><input type = 'text' class = 'form-control' id = 'bill_no' value = '$healthcard_num[0]' readonly = 'true' style = 'text-align: center; font-weight:bold;'>
													  </div>
													  <div class ='col-xs-2' style = 'margin-left: 10%;' >
													  <b>HMO: </b><input type = 'text' class = 'form-control' id = 'bill_no' value = 'N/A' readonly = 'true' style = 'text-align: center; font-weight:bold;'>
													  </div>";
			}
			else {
				$transaction_info = $transaction_info . " <div class ='col-xs-4'>
														<b>Philhealth: </b><input type = 'text' class = 'form-control' id = 'bill_no' value = 'N/A' readonly = 'true' style = 'text-align: center; font-weight:bold;'>
													  </div>
													  <div class ='col-xs-2' style = 'margin-left: 10%;' >
													  <b>HMO: </b><input type = 'text' class = 'form-control' id = 'bill_no' value = '$healthcard_num[0]' readonly = 'true' style = 'text-align: center; font-weight:bold;'>
													  </div>";
			}
		}
		else {
			$transaction_info = $transaction_info . " <div class ='col-xs-4'>
														<b>Philhealth: </b><input type = 'text' class = 'form-control' id = 'bill_no' value = 'N/A' readonly = 'true' style = 'text-align: center; font-weight:bold;'>
													  </div>
													  <div class ='col-xs-2' style = 'margin-left: 10%;' >
													  <b>HMO: </b><input type = 'text' class = 'form-control' id = 'bill_no' value = 'N/A' readonly = 'true' style = 'text-align: center; font-weight:bold;'>
													  </div>";
		}
// - - - - -  - - - - - - - - - - - - - - - -  -gui part for packages - - - - -  - - - - - - - - - - - - - - - - - - - - -  - - - - - - - - - - - - - - - - - -
		$order_ids = $this->queryDatabase("order_id", "packages_per_bill", "bill_no = '$bill_no'");
		$products = "";
		if(count($order_ids) > 0) {
			$package['id'] = $this->queryDatabase("package_id", "order_line", "order_id IN (" . implode(" ,", $order_ids) . ")");
			$package['qty'] = $this->queryDatabase("quantity", "order_line", "order_id IN (" . implode(" ,", $order_ids) . ")");
			$package['name'] = $this->queryDatabase("package_name", "packages", "package_id IN (" . implode(" ,", $package['id']) . ")");
			$package['price'] = $this->queryDatabase("package_price", "packages", "package_id IN (" . implode(" ,", $package['id']) . ")");
			$package['type'] = $this->queryDatabase("package_type", "packages", "package_id IN (" . implode(" ,", $package['id']) . ")");
			$package['case_rate'] = array();
			for($i = 0; $i < count($package['name']); $i++) {
				$package['case_rate'][$i] = 0;
				if($healthcard_type != null) {
					if($healthcard_type[0] == 1) {
						if($package['type'][$i] == "P") {
							$package_name = $package['name'][$i];
							$package['case_rate'][$i] = $this->queryDatabase("case_rate", "outside_procedures", "$package_name = rvs_code")[0];
						}
					}
				}
			}
			$package['professional_fee'] = $this->queryDatabase("package_pf", "packages", "package_id IN (" . implode(" ,", $package['id']) . ")");
			
			$products = $products . "
								<br/><br/> <br/> <br/> <br/> <br/><div class = 'container'>
					<table class = 'table table-bordered table-hover'>
								<thead>"
						. "<tr class=success>
							<th><center> Procedure Name </center></th> 
							<th><center> Procedure Price </center></th>
							<th><center> Professional Fee </center></th>
							<th><center> Numbers of Procedures Done </center></th>
							<th><center> Procedure Case Rate </center></th>
							<th><center> Total Procedural Cost </center></th>
						  </tr>
						  </thead>
						  <tbody>";
			for($i = 0; $i < count($package['name']); $i++) {
				if($package['type'][$i] == "P") {
					$products = $products . "<tr>" .
												"<td><center>" . $package['name'][$i] . "</center></td>" .
												"<td><center>" . $package['price'][$i] . "</center></td>" .
												"<td><center>" . 0 . "</center></td>" .
												"<td><center>" . $package['qty'][$i] . "</center></td>" .
												"<td><center>" . (str_replace(',', '', $package['case_rate'][$i])) . "</center></td>" .
												"<td><center>" . ($package['price'][$i] - (str_replace(',', '', $package['case_rate'][$i]))) * $package['qty'][$i] . "</center></td>" .
											"</tr>";
				}
				else if($package['type'][$i] == "M") {
					
					$products = $products . "<tr>" .
												"<td><center>" . $package['name'][$i] . "</center></td>" .
												"<td><center>" . $package['price'][$i] . "</center></td>" .
												"<td><center>" . $package['professional_fee'][$i] . "</center></td>" .
												"<td><center>" . $package['qty'][$i] . "</center></td>" .
												"<td><center>" . 0 . "</center></td>" .
												"<td><center>" . ($package['price'][$i] + $package['professional_fee'][$i]) * $package['qty'][$i] . "</center></td>" .
											"</tr>";
				}
			}
			$products = $products . "
			</tbody>
			</table>
			</div>";
			
			
			$products = $products . "<div class = 'container'>
					<table class = 'table table-bordered table-hover'>
								<thead>"
						. "<tr class= success>
							<th><center> Item Name </center></th> 
							<th><center> Item Price </center></th>
							<th><center> Item Quantity </center></th>
							<th><center> Total Procedural Cost </center></th>
						  </tr>";
			for($i = 0; $i < count($package['name']); $i++) {
				if($package['type'][$i] == "S") {
					$products = $products . "<tr>" .
												"<td><center>" . $package['name'][$i] . "</center></td>" .
												"<td><center>" . $package['price'][$i] . "</center></td>" .
												"<td><center>" . $package['qty'][$i] . "</center></td>" .
												"<td><center>" . $package['price'][$i] * $package['qty'][$i]. "</center></td>" .
											"</tr>";
				}
			}
			$products = $products . "
			</tbody>
			</table>
			</div>";
		}
		
		$an_cost = array_sum($this->queryDatabase("an_cost", "additional_costs", "anreq_id IN (SELECT anreq_id FROM anesthesias_per_bill WHERE bill_no = '$bill_no')"));
		$other_cost = array_sum($this->queryDatabase("other_cost", "additional_costs", "anreq_id IN (SELECT anreq_id FROM anesthesias_per_bill WHERE bill_no = '$bill_no')"));
		
		$products = $products . "<br/> <br/><div class = 'panel' style = 'margin-right : 25%;'>
									<div class = 'panel-heading'>
										<b><h4>Miscellaneous</h4></b>
									</div><br/>
									<div class='col-xs-4'><b> Total Anesthesia Cost: </b><input type = 'text' class = 'form-control' id = 'an_cost' value = '$an_cost' readonly= 'true' style = 'text-align: center; font-weight:bold;'></div>";
		$products = $products . "<div class='col-xs-4' style = 'margin-left: 10%;'><b> Other Costs: </b><input type = 'text' class = 'form-control' id = 'an_cost' value = '$other_cost' readonly= 'true' style = 'text-align: center; font-weight:bold;'></div></div> <br/> <br/><br/><br/>";
		
// - - - - - - - -  - - - - - - - - gui part for recordables  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 	
		$others = $this->queryDatabase("others_field", "bill_recordables", "bill_no = '$bill_no'")[0];
		$others_amount = $this->queryDatabase("others_amount", "bill_recordables", "bill_no = '$bill_no'")[0];
		$subtotal = $this->queryDatabase("subtotal", "bill_recordables", "bill_no = '$bill_no'")[0];
		$discount = $this->queryDatabase("discount", "bill_recordables", "bill_no = '$bill_no'")[0];
		$vat = $this->queryDatabase("vat", "bill_recordables", "bill_no = '$bill_no'")[0];
		$total_payment_required = $this->queryDatabase("total_payment_required", "bill_recordables", "bill_no = '$bill_no'")[0];
		
	$recordables = "<div class='col-xs-4'>
						 <b>Others: </b><input type = 'text' class = 'form-control' id = 'others_text' value = '$others' readonly = 'true' style = 'text-align: center; font-weight:bold;'> 
						</div>
						<div class='col-xs-2' style = 'margin-left: 10%;'>
						<b>Amount: PHP </b><input type = 'text' class = 'form-control' id = 'others_amount' value = '$others_amount' readonly = 'true' style = 'text-align: center; font-weight:bold;'>
						</div></div>
						</br>
						</br>
						<div class = 'col-xs-3' style = 'float:right'>
						 <b>Subtotal: PHP </b><input type = 'text' class = 'form-control' id = 'subtotal' value = '$subtotal' readonly = 'true' style = 'text-align: center; font-weight:bold;'> 
						  </div>
						 </br>
						 </br>
						 </br>
						 </br>
						 <div class = 'panel' style = 'margin-right : 25%;'>
									<div class = 'panel-heading'>
										<b><h4>Discount & Vat</h4></b>
									</div>
								<div class = 'panel-content'>
						 <div class='col-xs-4'>
						<b>Discount: Percent </b><input type = 'text' class = 'form-control' id = 'discount' value = '$discount' readonly = 'true' maxlength = '2' style = 'text-align: center; font-weight:bold;'>  
						</div>
						<div class='col-xs-2' style = 'margin-left : 10%;'>
						<b>VAT: Percent </b><input type = 'text' class = 'form-control' id = 'vat' value = '$vat' readonly = 'true' maxlength = '2' style = 'text-align: center; font-weight:bold;'>
						 </div></div></div>
						  <div class='col-xs-4' style = 'float:right'>
						<b>Total Payment Required: PHP </b><input type = 'text' class = 'form-control' id = 'payment_required' value = '$total_payment_required' readonly = 'true' style = 'text-align: center; font-weight:bold;'> 
						</div>
						</br>
						 </br>
						 </br>
						 </br>
						 </div>
						 </br>
						 </br>
						 </br>
						 </br>
						 <div class = 'panel' style = 'margin-right : 25%;'>
									<div class = 'panel-heading'>
										<b><h4>Payment and Transaction</h4></b>
									</div>
								<div class = 'panel-content'>
								<br/><br/>
								<div class='col-xs-4'>
							<b>Total Payment Given: PHP </b><input type = 'text' class = 'form-control' id = 'payment_given' value = '' placeholder = '0' style = 'text-align: center; font-weight:bold;'> 
							</div>
							</br>
							</br>
							</br>
							</br>
							<div class='col-xs-4'>
							<b>Mode of Payment: </b><select id = 'mode_of_payment'>
												<option value='Cash'> Cash </option>
												<option value='Check'> Check </option>
												<option value='Card'> Card </option>
												<option value='Charge'> Charge </option>
											</select>
							</div>
						<div id = 'payment_details'> </div>
						</div>
						</div>
					   ";
					   
// --- previous transactions
		$prev_deposits['amount'] = $this->queryDatabase("amount_deposited", "billing_archive", "bill_no = '$bill_no'");
		$total_deposit = array_sum($prev_deposits['amount']);
		$prev_deposits['installment_no'] = $this->queryDatabase("installment_no", "billing_archive", "bill_no = '$bill_no'");
		$prev_deposits['installment_date'] = $this->queryDatabase("installment_date", "billing_archive", "bill_no = '$bill_no'");
		$deposit_table =  "<br/><br/><br/><br/><br/><div class = 'container'>
					<table class = 'table table-bordered table-hover'>
								<thead>";
		$deposit_table = $deposit_table . "<tr class=success>" .
										"<th><center> Installment Number </center></th>" .
										"<th><center> Amount Deposited </center></th>" .
										"<th><center> Date Deposited </center></th>" .
									"</tr>";
		for($i = 0; $i < count($prev_deposits['amount']); $i++) {
			$deposit_table = $deposit_table . "<tr>" .
										"<td><center>" . $prev_deposits['installment_no'][$i] . "</center></td>" .
										"<td><center>" . $prev_deposits['amount'][$i] . "</center></td>" .
										"<td><center>" . $prev_deposits['installment_date'][$i] . "</center></td>" .
									"</tr>";
		}
		$deposit_table = $deposit_table . "
			</tbody>
			</table>
			</div>";
			
		$balance = $total_payment_required - $total_deposit;
		$pending_balance = "<br/><br/><br/><br/><div class='col-xs-3' style: 'float: right;'><b> Total Pending Balance: </b><input type = 'text' class = 'form-control' id = 'balance' value = '$balance' readonly = 'true' style = 'text-align: center; font-weight:bold;'> </div><br/><br/><br/><br/>";
		
		$pay_button = "<span> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <button class='btn btn-primary'  id = 'invoice'> Generate Invoice </button> <span> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <button class='btn btn-primary'  id = 'pay_old'> Pay </button> ";
		
		echo $transaction_info . $products . $recordables . $deposit_table .$pending_balance . $pay_button;
	}
	
	/**
	 *	Function for recording installments in the pending bill
	 *
	 */
	public function recordOldBill() {
		
		$bill_no = "";
		if(isset($_POST['bill_no'])) { $bill_no = $_POST['bill_no']; }
		
		$payment_given = $_POST['payment_given'];
		
		$total_payment_deposited = array_sum($this->queryDatabase("amount_deposited", "billing_archive", "bill_no = '$bill_no'")) + $payment_given;
		$total_payment_required = $this->queryDatabase("total_payment_required", "bill_recordables", "bill_no = '$bill_no'")[0];
		
		// store to billing archive table
		$installments = $this->queryDatabase("installment_no", "billing_archive", "bill_no = '$bill_no'");
		array_push($installments, 0);
		$installment_no = max($installments) + 1;
		$payment_given = $_POST['payment_given'];
		$sql = "INSERT INTO `billing_archive` (`bill_no`, `installment_no`, `amount_deposited`)
				VALUES ('$bill_no', '$installment_no', '$payment_given')";
		$sql = $this->db->query($sql) or die(mysql_error());
		
		// store to payment details table
		$mode_of_payment = "";
		if(isset($_POST['mode_of_payment'])) { $mode_of_payment = $_POST['mode_of_payment']; }
		$details = "";
		if(isset($_POST['details'])) { $details = $_POST['details']; }
		$bank = "";
		if(isset($_POST['bank'])) { $bank = $_POST['bank']; }
		$exp_date = "";
		if(isset($_POST['exp_date'])) { $exp_date = $_POST['exp_date']; }
		$card_no = "";
		if(isset($_POST['card_no'])) { $card_no = $_POST['card_no']; }
		$company = "";
		if(isset($_POST['company'])) { $company = $_POST['company']; }
		$sql = "INSERT INTO `payment_details` (`bill_no`, `installment_no`, `mode_of_payment`, `details`, `bank`, `expiration_date`, `card_no`, `company`)
				VALUES ('$bill_no', '$installment_no', '$mode_of_payment', '$details', '$bank', '$exp_date', '$card_no', '$company');";
		$sql = $this->db->query($sql) or die(mysql_error());
		
		echo "DEPOSIT: &nbsp $total_payment_deposited &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp COST: &nbsp $total_payment_required";
		
		if($total_payment_deposited == $total_payment_required) {
			$sql = "UPDATE `patient_bills` SET isPaid = '1' WHERE bill_no = '$bill_no';";
			$sql = $this->db->query($sql) or die(mysql_error());
		}
	}
	
	public function truncateBillingTables() {
		if(! $this->session->userdata("logged_in")){
			redirect(base_url() . "main/");
		}

		if(!$this->session->userdata("acsBil")){
			$this->load->view('header.php');
			$this->load->view('navbar.php');
			$this->load->view('home_sidebar.php');
			$this->load->view('access_denied.php');
			$this->load->view('footer.php');
			return;
		}

		$sql = "DROP TABLE `patient_bills`;";
		$this->db->query($sql);
		$sql = "DROP TABLE `bill_recordables`;";
		$this->db->query($sql);
		$sql = "DROP TABLE `payment_details`;";
		$this->db->query($sql);
		$sql = "DROP TABLE `packages_per_bill`;";
		$this->db->query($sql);	
		$sql = "DROP TABLE `anesthesias_per_bill`;";
		$this->db->query($sql);	
		$sql = "DROP TABLE `billing_archive`;";
		$this->db->query($sql);
	}
	
	public function generateInvoice($newdata, $newdata2){
		
		$bill_no = $newdata;
		$id = $newdata2;
		$lastname = $this->queryDatabase("last_name", "patients", "true_id = '$id'")[0];
		
		$name = $this->queryDatabase("last_name", "patients", "true_id = '$id'")[0] . ", " . 
				$this->queryDatabase("first_name", "patients", "true_id = '$id'")[0] . " " . 
				$this->queryDatabase("middle_name", "patients", "true_id = '$id'")[0];
		$address = $this->queryDatabase("address", "patients", "true_id = '$id'")[0];
		$sex = $this->queryDatabase("sex", "patients", "true_id = '$id'")[0];
		if($sex == 0) { $sex = "Female"; }
		else { $sex = "Male"; }
		$birthdate = $this->queryDatabase("birthday", "patients", "true_id = '$id'")[0];
		$healthcard_type = $this->queryDatabase("card_type", "healthcards", "true_id = '$id'");
		$healthcard_num = $this->queryDatabase("card_num", "healthcards", "true_id = '$id'");
		
		if($healthcard_type != null) {
			if($healthcard_type[0] == 1) {
				$pin = 	$healthcard_num[0];									
				$hmo = "N/A";
			}
			else {
				$pin = "N/A";
				$hmo = $healthcard_num[0];
			}
		}
		else {
			$pin = "N/A";
			$hmo = "N/A";
		}
		
		
		//pdf magic happens here
		$this->load->library('Pdf');
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Computerised_Clinic_System_for_Opthalmology');
		$pdf->SetTitle('Patient Invoice');
		$pdf->SetFont('helvetica', '', 10, '', true);
		$pdf->AddPage();
		
		$html = '<p align = "center"><h4> Alvina Pauline D. Santiago, M.D.</h4><br/>
		 Pediatric Opthalmology and Adult Strabismus <br/>
		 St Lukes Medical Center &nbsp &nbsp &nbsp &nbsp The Medical City &nbsp &nbsp &nbsp &nbsp Manila Doctors Hospital <br/>
		 Telephone # (632) 727 8382 &nbsp &nbsp &nbsp &nbsp &nbsp (636) 636 2827 </p> <hr>';
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->writeHTMLCell(0,0,89,45,'<b>Patient&#39;s Invoice</b>',0, 0, 0, true, '', true);
		$pdf->writeHTMLCell(0,0,160,45,'<b>Bill No:  </b>'.$bill_no,0,0,0, true, '', true);
		$pdf->writeHTMLCell(0,0,160,50,'<b>Date:  </b>'.date('m-d-Y'),0,0,0,true,'',true);
		$pdf->writeHTMLCell(0,0,'',55,'<b>Name:  </b>'.$name,0,0,0,true,'',true);
		$pdf->writeHTMLCell(0,0,120,55,'<b>Birthdate:  </b>'.$birthdate,0,0,0,true,'',true);
		$pdf->writeHTMLCell(0,0,'',60,'<b>Address: </b>'.$address,0,0,0,true,'',true);
		$pdf->writeHTMLCell(0,0,120,60,'<b>Sex: </b>'.$sex,0,0,0,true,'',true);
		$pdf->writeHTMLCell(0,0,'',65,'<b>PhilHealth No: </b>'.$pin,0,0,0,true,'',true);
		$pdf->writeHTMLCell(0,0,120,65,'<b>HMO: </b>'.$hmo,0,0,0,true,'',true);
		$html = '<br/><br/><br/><hr><br/> Breakdown of Procedure/Treatments/Item(s)<hr>';
		$pdf->writeHTML($html, true, false, true, false, '');
		
		$order_ids = $this->queryDatabase("order_id", "packages_per_bill", "bill_no = '$bill_no'");
		$products = "";
		if(count($order_ids) > 0) {
			$package['id'] = $this->queryDatabase("package_id", "order_line", "order_id IN (" . implode(" ,", $order_ids) . ")");
			$package['qty'] = $this->queryDatabase("quantity", "order_line", "order_id IN (" . implode(" ,", $order_ids) . ")");
			$package['name'] = $this->queryDatabase("package_name", "packages", "package_id IN (" . implode(" ,", $package['id']) . ")");
			$package['price'] = $this->queryDatabase("package_price", "packages", "package_id IN (" . implode(" ,", $package['id']) . ")");
			$package['type'] = $this->queryDatabase("package_type", "packages", "package_id IN (" . implode(" ,", $package['id']) . ")");
			$package['case_rate'] = array();
			for($i = 0; $i < count($package['name']); $i++) {
				$package['case_rate'][$i] = 0;
				if($healthcard_type != null) {
					if($healthcard_type[0] == 1) {
						if($package['type'][$i] == "P") {
							$package_name = $package['name'][$i];
							$package['case_rate'][$i] = $this->queryDatabase("case_rate", "outside_procedures", "$package_name = rvs_code")[0];
						}
					}
				}
			}
			$package['professional_fee'] = $this->queryDatabase("package_pf", "packages", "package_id IN (" . implode(" ,", $package['id']) . ")");
		
			$html1 = '<table border = "1" cellpadding = "4">
					<tr> <th align = "center"> Name </th>
						 <th align = "center"> Price (PHP) </th>
						 <th align = "center"> Professional Fee (PHP)</th>
						 <th align = "center"> Quantity </th>
						 <th align = "center"> (Case Rate) </th>
						 <th align = "center"> Amount (PHP) </th>
					</tr>';
			$html2 = "";
			
			for($i = 0; $i < count($package['name']); $i++) {
				if($package['type'][$i] == "P") { 
				
					$nametemp = $package['name'][$i];
					$pricetemp = number_format($package['price'][$i], 2);
					$profeetemp = number_format(0,2);
					$quantemp = $package['qty'][$i];
					$casetemp = number_format((str_replace(',', '', $package['case_rate'][$i])),2);
					$amountemp = number_format(($package['price'][$i] - (str_replace(',', '', $package['case_rate'][$i]))) * $package['qty'][$i],2);
					
					$html2 .= '<tr> 
						<td>' .$nametemp. '</td>
						<td align = "right"> '. $pricetemp. '</td>
						<td align = "right"> '. $profeetemp.'</td>
						<td align = "center">'. $quantemp. '</td>
						<td align = "right">'. $casetemp.' </td>
						<td align = "right">'. $amountemp.' </td>
					</tr>';
				}
				else if($package['type'][$i] == "M") {
					
					$nametemp = $package['name'][$i];
					$pricetemp = number_format($package['price'][$i], 2);
					$profeetemp = number_format($package['professional_fee'][$i],2);
					$quantemp = $package['qty'][$i];
					$casetemp = number_format(0,2);
					$amountemp = number_format(($package['price'][$i] + $package['professional_fee'][$i]) * $package['qty'][$i],2);
					
					$html2 .= '<tr> 
						<td>' .$nametemp. '</td>
						<td align = "right"> '. $pricetemp. '</td>
						<td align = "right"> '. $profeetemp.'</td>
						<td align = "center">'. $quantemp. '</td>
						<td align = "center">'. $casetemp.' </td>
						<td align = "right">'. $amountemp.' </td>
					</tr>';
				}	
			}
			for($i = 0; $i < count($package['name']); $i++) {
				if($package['type'][$i] == "S") {
					
					$nametemp = $package['name'][$i];
					$pricetemp = number_format($package['price'][$i], 2);
					$quantemp = $package['qty'][$i];
					$amountemp = number_format(($package['price'][$i] + $package['professional_fee'][$i]) * $package['qty'][$i],2);
					
					$html2 .= '<tr> 
						<td>' .$nametemp. '</td>
						<td align = "right"> '. $pricetemp. '</td>
						<td align = "center">  N/A </td>
						<td align = "center">'. $quantemp. '</td>
						<td align = "center">  N/A </td>
						<td align = "right">'. $amountemp.' </td>
					</tr>';
				}		
			}
			
			$html3 = '</table>';
			$pdf->writeHTML($html1 . $html2 . $html3, true, false, true, false, '');
			
		}
		
		
		$an_cost = array_sum($this->queryDatabase("an_cost", "additional_costs", "anreq_id IN (SELECT anreq_id FROM anesthesias_per_bill WHERE bill_no = '$bill_no')"));
		$other_cost = array_sum($this->queryDatabase("other_cost", "additional_costs", "anreq_id IN (SELECT anreq_id FROM anesthesias_per_bill WHERE bill_no = '$bill_no')"));
		$others = $this->queryDatabase("others_field", "bill_recordables", "bill_no = '$bill_no'")[0];
		$others_amount = $this->queryDatabase("others_amount", "bill_recordables", "bill_no = '$bill_no'")[0];
		$subtotal = $this->queryDatabase("subtotal", "bill_recordables", "bill_no = '$bill_no'")[0];
		$discount = $this->queryDatabase("discount", "bill_recordables", "bill_no = '$bill_no'")[0];
		$vat = $this->queryDatabase("vat", "bill_recordables", "bill_no = '$bill_no'")[0];
		$total_payment_required = $this->queryDatabase("total_payment_required", "bill_recordables", "bill_no = '$bill_no'")[0];
		
		$html4 = '<table border = "1" cellpadding = "4">
				<tr>
					<td> Total Anesthesia Cost: </td>
					<td align = "right">'.number_format($an_cost,2) .'</td>
				</tr>
				<tr>
					<td> Other Costs: </td>
					<td align = "right">'.number_format($other_cost,2) .'</td>
				</tr>
				<tr>
					<td> ' . $others . '</td>		
					<td align = "right">' . number_format($others_amount, 2) . '</td>
				</tr>
				</table>';
				
		$html5 = '<table border = "1" cellpadding = "4">
				<tr>
					<td align = "right"> Subtotal: </td>
					<td align = "right">'.number_format($subtotal,2) .'</td>
				</tr>
				<tr>
					<td align = "right"> Discount: </td>
					<td align = "right"> ' . $discount .'%</td>
				</tr>
				<tr>
					<td align = "right"> Vat: </td>
					<td align = "right">'.$vat. ' %</td>
				</tr>
				</table>';
				
		$html6 = '<table border = "1" cellpadding = "4">
				<tr>
					<td align = "right"><b> Total Payment: (PHP) </b></td>
					<td align = "right">'.number_format($total_payment_required,2).'</td>
				</tr>
				</table>';
				
		$pdf->writeHTML($html4, true, false, true, false, '');
		$pdf->writeHTML($html5, true, false, true, false, '');
		$pdf->writeHTML($html6, true, false, true, false, '');
		
		$pdf->writeHTMLCell(0,0,'',270,'Keep this invoice for verification purposes. Thank you',0, 0, 0, true, '', true);
		
		$pdf->Output($bill_no . '_' . $lastname.'_Invoice.pdf', 'D');
	}
	
	public function generateAck($newdata, $newdata2){
		
		$bill_no = $newdata;
		$id = $newdata2;
		
		$lastname = $this->queryDatabase("last_name", "patients", "true_id = '$id'")[0];
		
		$name = $this->queryDatabase("last_name", "patients", "true_id = '$id'")[0] . ", " . 
				$this->queryDatabase("first_name", "patients", "true_id = '$id'")[0] . " " . 
				$this->queryDatabase("middle_name", "patients", "true_id = '$id'")[0];
		$address = $this->queryDatabase("address", "patients", "true_id = '$id'")[0];
		$sex = $this->queryDatabase("sex", "patients", "true_id = '$id'")[0];
		if($sex == 0) { $sex = "Female"; }
		else { $sex = "Male"; }
		$birthdate = $this->queryDatabase("birthday", "patients", "true_id = '$id'")[0];
		$healthcard_type = $this->queryDatabase("card_type", "healthcards", "true_id = '$id'");
		$healthcard_num = $this->queryDatabase("card_num", "healthcards", "true_id = '$id'");
		
		if($healthcard_type != null) {
			if($healthcard_type[0] == 1) {
				$pin = 	$healthcard_num[0];									
				$hmo = "N/A";
			}
			else {
				$pin = "N/A";
				$hmo = $healthcard_num[0];
			}
		}
		else {
			$pin = "N/A";
			$hmo = "N/A";
		}
		$amount = "";
		$install = "";
		$date = "";
		
		$installments = $this->queryDatabase("installment_no", "billing_archive", "bill_no = '$bill_no'");
		array_push($installments, 0);
		$install = max($installments);
		
		$amount = $this->queryDatabase("amount_deposited", "billing_archive", "bill_no = '$bill_no' AND installment_no = '$install'")[0];
		$date = $this->queryDatabase("amount_deposited", "billing_archive", "bill_no = '$bill_no' AND installment_no = '$install'")[0];
		
		//pdf magic happens here
		$this->load->library('Pdf');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Computerised_Clinic_System_for_Opthalmology');
		$pdf->SetTitle('Acknowledgement Receipt');
		$pdf->SetFont('helvetica', '', 10, '', true);
		$pdf->AddPage();
		
		$html = '<p align = "center"><h4> Alvina Pauline D. Santiago, M.D.</h4><br/>
		 Pediatric Opthalmology and Adult Strabismus <br/>
		 St Lukes Medical Center &nbsp &nbsp &nbsp &nbsp The Medical City &nbsp &nbsp &nbsp &nbsp Manila Doctors Hospital <br/>
		 Telephone # (632) 727 8382 &nbsp &nbsp &nbsp &nbsp &nbsp (636) 636 2827 </p> <hr>';
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->writeHTMLCell(0,0,80,45,'<b>Acknowledgement Slip</b>',0, 0, 0, true, '', true);
		$pdf->writeHTMLCell(0,0,155,50,'<b>Acknowledgement No:  </b>',0,0,0, true, '', true);
		$pdf->writeHTMLCell(0,0,160,55,$bill_no .'<b> - </b>'. $install,0,0,0, true, '', true);
		$pdf->writeHTMLCell(0,0,160,65,'<b>Date:  </b>'.date('m-d-Y'),0,0,0,true,'',true);
		$pdf->writeHTMLCell(0,0,'',70,'<b>Payor:  </b>'.$name,0,0,0,true,'',true);
		$pdf->writeHTMLCell(0,0,120,70,'<b>Birthdate:  </b>'.$birthdate,0,0,0,true,'',true);
		$pdf->writeHTMLCell(0,0,'',75,'<b>Address: </b>'.$address,0,0,0,true,'',true);
		$pdf->writeHTMLCell(0,0,120,75,'<b>Sex: </b>'.$sex,0,0,0,true,'',true);
		$pdf->writeHTMLCell(0,0,'',80,'<b>PhilHealth No: </b>'.$pin,0,0,0,true,'',true);
		$pdf->writeHTMLCell(0,0,120,80,'<b>HMO: </b>'.$hmo,0,0,0,true,'',true);
		
		$html = '<br/><br/><br/><hr><br/> Total Payment Received<hr>';
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->writeHTMLCell(0,0,'',100,'<b>Amount(PHP): </b>',0, 0, 0, true, '', true);
		
		$pdf->writeHTMLCell(0,0,40,110,'<b>P </b>'.number_format($amount,2) ,0, 0, 0, true, '', true);
		
		//$pdf->writeHTMLCell(0,0,40,120, $date ,0, 0, 0, true, '', true);
		
		$mode_of_payment = $this->queryDatabase("mode_of_payment", "payment_details", "installment_no = '$install' AND bill_no = '$bill_no'")[0];
		$details  = $this->queryDatabase("details", "payment_details", "installment_no = '$install' AND bill_no = '$bill_no'")[0];
		$bank = $this->queryDatabase("bank", "payment_details", "installment_no = '$install' AND bill_no = '$bill_no'")[0];
		$exp_date = $this->queryDatabase("expiration_date", "payment_details", "installment_no = '$install' AND bill_no = '$bill_no'")[0];
		$card_no = $this->queryDatabase("card_no", "payment_details", "installment_no = '$install' AND bill_no = '$bill_no'")[0];
		$company = $this->queryDatabase("company", "payment_details", "installment_no = '$install' AND bill_no = '$bill_no'")[0];
		
		$pdf->writeHTMLCell(0,0,20,130,'<b>Mode of Payment: </b>' .$mode_of_payment ,0, 0, 0, true, '', true);
		
		if ($mode_of_payment == "Check"){
			$pdf->writeHTMLCell(0,0,35,135,'<b>Details: </b>'.$details,0, 0, 0, true, '', true);
			$pdf->writeHTMLCell(0,0,35,140,'<b>Bank: </b>'.$bank,0, 0, 0, true, '', true);		
		}
		
		if ($mode_of_payment == "Card"){
			$pdf->writeHTMLCell(0,0,35,135,'<b>Details: </b>'.$details,0, 0, 0, true, '', true);
			$pdf->writeHTMLCell(0,0,35,140,'<b>Expiration Date: </b>'.$exp_date,0, 0, 0, true, '', true);
			$pdf->writeHTMLCell(0,0,35,145,'<b>Card No: </b>'.$card_no,0, 0, 0, true, '', true);
		}
		
		if ($mode_of_payment == "Charge"){
			$pdf->writeHTMLCell(0,0,35,135,'<b>Details: </b>'.$details,0, 0, 0, true, '', true);
			$pdf->writeHTMLCell(0,0,35,140,'<b>Company/Organization: </b>'.$company,0, 0, 0, true, '', true);
		}
		
		$pdf->writeHTMLCell(0,0,'',270,'Keep this slip for verification purposes. Thank you',0, 0, 0, true, '', true);
		
		$pdf->Output($bill_no. '-' . $install . '_' . $lastname.'_AckSlip.pdf', 'D');
		
		echo $install;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>