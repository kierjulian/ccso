<!--main content start-->
<section id="main-content">
	<script type = "text/javascript" src = '<?php echo base_url(); ?>assets/js/jquery-1.8.3.min.js'></script>
	<script type = "text/javascript">
		$(document).ready(function() {
			$('input[name="others_amount"]').keyup(function(event) {
				event.preventDefault();
				$.ajax({
					url: '<?php echo base_url() ?>billing/calculate_subtotal',
					type: 'POST',
					data: {
						subtotal: $('#real_subtotal').val(),
						others: $('input[name="others_amount"]').val(),
					},
					success: function(data) {
						document.getElementById('subtotal').value = data;
						$.ajax({
							url: '<?php echo base_url() ?>billing/calculate_total',
							type: 'POST',
							data: {
							subtotal: $('input[name="subtotal"]').val(),
							discount: $('input[name="discount"]').val(),
							vat: $('input[name="vat"]').val(),
						},
						success: function(data) {
							document.getElementById('total').value = data;
						}
						});
					}
				});
			});
			$('input[name="discount"]').keyup(function(event) {
				event.preventDefault();
				$.ajax({
					url: '<?php echo base_url() ?>billing/calculate_total',
					type: 'POST',
					data: {
						subtotal: $('input[name="subtotal"]').val(),
						discount: $('input[name="discount"]').val(),
						vat: $('input[name="vat"]').val(),
					},
					success: function(data) {
						document.getElementById('total').value = data;
					}
				});
			});
			$('input[name="vat"]').keyup(function(event) {
				event.preventDefault();
				$.ajax({
					url: '<?php echo base_url() ?>billing/calculate_total',
					type: 'POST',
					data: {
						subtotal: $('input[name="subtotal"]').val(),
						discount: $('input[name="discount"]').val(),
						vat: $('input[name="vat"]').val(),
					},
					success: function(data) {
						document.getElementById('total').value = data;
					}
				});
			});
			$('input[name="[philhealth]"]').keyup(function(event) {
				event.preventDefault();
				$.ajax({
					url: '<?php echo base_url() ?>billing/calculate_total',
					type: 'POST',
					data: {
						subtotal: $('input[name="subtotal"]').val(),
						discount: $('input[name="discount"]').val(),
						vat: $('input[name="vat"]').val(),
					},
					success: function(data) {
						document.getElementById('total').value = data;
					}
				});
			});
			$('input[name="OR"]').keyup(function(event) {
				document.getElementById('OR_NUMBER').value = document.getElementById('OR').value;
			});
			$("#mode_of_payment").change(function(event) {
				alert($("#mode_of_payment").val());
				event.preventDefault();
				$.ajax({
					url: '<?php echo base_url() ?>billing/mode_of_payment',
					type: 'POST',
					data: {
						mode_of_payment: $("#mode_of_payment").val(),
					},
					success: function(data) {
						document.getElementById('payment_details').innerHTML = data;
					}
				});
			});
			$("#pay_button").click(function(event) {
				event.preventDefault();
				if($("#OR").val() > 0) {
					$.ajax({
						url: '<?php echo base_url() ?>billing/add_to_archive',
						type: 'POST',
						data: {
							true_id: $("#true_id").val(),
							or_no: $("#OR").val(),
							mode_of_payment: $("#mode_of_payment").val(),
							total_bill: $("#total").val(),
						},
						success: function(data) {
							alert("BILL RECORDED! THANK YOU!");
							document.getElementById('payment_details').innerHTML = data;
							window.location.href = "<?php echo base_url(); ?>billing/perform_payment";
						}
					});
				}
				else {
					alert("There are missing fields.");
				}
			});
			$("#OR").keydown(function(event) {
                if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 
                    || event.keyCode == 27 || event.keyCode == 13 
                    || (event.keyCode == 65 && event.ctrlKey === true) 
                    || (event.keyCode >= 35 && event.keyCode <= 39)){
                        return;
                }else {
                    // If it's not a number stop the keypress
                    if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                        event.preventDefault(); 
                    }   
                }
            });
			$("#others_amount").keydown(function(event) {
                if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 
                    || event.keyCode == 27 || event.keyCode == 13 
                    || (event.keyCode == 65 && event.ctrlKey === true) 
                    || (event.keyCode >= 35 && event.keyCode <= 39)){
                        return;
                }else {
                    // If it's not a number stop the keypress
                    if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                        event.preventDefault(); 
                    }   
                }
            });
			$("#discount").keydown(function(event) {
                if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 
                    || event.keyCode == 27 || event.keyCode == 13 
                    || (event.keyCode == 65 && event.ctrlKey === true) 
                    || (event.keyCode >= 35 && event.keyCode <= 39)){
                        return;
                }else {
                    // If it's not a number stop the keypress
                    if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                        event.preventDefault(); 
                    }   
                }
            });
			$("#vat").keydown(function(event) {
                if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 
                    || event.keyCode == 27 || event.keyCode == 13 
                    || (event.keyCode == 65 && event.ctrlKey === true) 
                    || (event.keyCode >= 35 && event.keyCode <= 39)){
                        return;
                } else {
                    // If it's not a number stop the keypress
                    if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                        event.preventDefault(); 
                    }   
					if ($("#vat").val().length > 1) {
						event.preventDefault(); 
					} 
                }
            });
		});
	</script>
	<section class="wrapper">
	<br/>
	<br/>
	<div class = "panel panel-primary" style = "width: 100%;">
		<div class = "panel-heading">
			<h3>Billing</h3>
		</div>
		<div class = "panel-content">
			<form action = "displayBill" method = "post" style = "margin-left: 10%; margin-right: 10%;"><!--added-->
				<div class="col-xs-2" style = "float: right;">
					<b> OR NO: </b> <input class = "form-control" type = "text" name = "OR" id = "OR" style = "align: right; text-align: center; font-weight:bold;" value = ""/> </br>
				</div>
				</br>
				</br>
				</br>
				</br>
				<div class="col-xs-4">
					<b> PATIENT NAME: </b><input class = "form-control" type = "text" name = "patient_name" style = "text-align: center; font-weight:bold;" readonly = "true" value = "<?php echo $last_name . ', ' . $first_name . ' ' . $middle_name?>"/> 
				</div>
				<div class="col-xs-2" style = "margin-left: 10%;" >
					<b> BIRTH DATE: </b><input class = "form-control" type = "text" name = "birthdate" readonly = "true" style = "text-align: center; font-weight:bold;" value = "<?php echo $birthday ?>"/>
				</div>
				</br>
				</br>
				</br>
				</br>
				<div class="col-xs-4">
					<b> ADDRESS: </b><input class = "form-control" type = "text" name = "address" readonly = "true" style = "text-align: center; font-weight:bold;" value = "<?php echo $address ?>"/>
				</div>
				<div class="col-xs-2" style = "margin-left: 10%;" >
					<b> SEX: </b><input class = "form-control" type = "text" name = "sex" readonly = "true" style = "text-align: center; font-weight:bold;"value = "<?php echo $sex ?>"/>
				</div>
				</br>
				</br>
				</br>
				</br>
				<div class ="col-xs-4">
					<b> PHILHEALTH NO: </b><input class = "form-control"  type = "text" readonly = "true" name = "pin" style = "text-align: center; font-weight:bold;" value = "<?php echo $pin ?>"/>
				</div>
				<div class ="col-xs-2" style = "margin-left: 10%;" >
					<b> HMO: </b><input class = "form-control" type = "text" style = "text-align: center; font-weight:bold;" value = "" readonly = "true" name = "HMO" value =  "<?php echo $hmo ?>"/>
				</div>
				</br>
				</br>
				</br>
				</br>
				</br>
				</br>
				<div class = "container">
					<table class = "table table-bordered table-hover">
						<thead>
							<tr class = "success">
								<th><center>PROCEDURE(S)</center></th>
								<th><center>QUANTITY(S)</center></th>
								<th><center>PRICE(S)</center></th>
								<th><center>(CASE RATE)</center></th>
								<th><center>AMOUNT</center></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$subtotal = 0;
								$amount = 0;
								foreach($billables as $billable) { 
								if($billable[2] == "P") {
							?>
							<tr>
								<td><?php echo $billable[0]; ?> </td>
								<td><center><?php echo $billable[4]; ?> </center></td> 
								<td><center><?php echo $billable[1] ?>  </center></td> 
								<td><center><?php if($pin != "N/A") { echo $billable[5]; } else { echo 0; }?> </center></td>
								<?php 
									$amount = 0;
									if($pin != "N/A") {
										$amount = $billable[4] * ($billable[1] - $billable[5]);
									}
									else {
										$amount = $billable[4] * $billable[1];
									}
									$subtotal = $subtotal + $amount;
								?>
								<td><center><?php echo $amount ?></center></td>
							</tr>
							<?php 	
									} 
								}
							?>
						</tbody>
					</table>
				</div>
				</br>
				</br>
				<div class = "container">
					<table class = "table table-bordered table-hover">
						<thead>
							<tr class = "success">
								<th><center>PACKAGE(S)</center></th>
								<th><center>QUANTITY(S)</center></th>
								<th><center>PRICE(S)</center></th>
								<th><center>(CASE RATE)</center></th>
								<th><center>AMOUNT</center></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$amount = 0;
								foreach($billables as $billable) { 
									if($billable[2] == "M") {
							?>
							<tr>
								<td><?php echo $billable[0]; ?> </td>
								<td><center><?php echo $billable[4]; ?> </center></td> 
								<td><center><?php echo $billable[1] ?>  </center></td> 
								<td><center><?php if($pin != "N/A") { echo $billable[5]; } else { echo 0; }?> </center></td>
							<?php 
								$amount = 0;
								if($pin != "N/A") {
									$amount = $billable[4] * ($billable[1] - $billable[5]);
								}
								else {
									$amount = $billable[4] * $billable[1];
								}
								$subtotal = $subtotal + $amount;
							?>
								<td><center><?php echo $amount ?></center></td>
							</tr>
							<?php 	
									} 
								}
							?>
						</tbody>
					</table>
				</div>
				</br>
				</br>
				<div class = "container">
					<table class = "table table-bordered table-hover">
						<thead>
							<tr class = "success">
								<th><center>PRODUCT(S)</center></th>
								<th><center>QUANTITY(S)</center></th>
								<th><center>PRICE(S)</center></th>
								<th><center>(CASE RATE)</center></th>
								<th><center>AMOUNT</center></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$amount = 0;
								foreach($billables as $billable) { 
									if($billable[2] == "S" || $billable[2] == "A") {
							?>
							<tr>
								<td><?php echo $billable[0]; ?> </td>
								<td><center><?php echo $billable[4]; ?> </center></td> 
								<td><center><?php echo $billable[1] ?>  </center></td> 
								<td><center><?php if($pin != "N/A") { echo $billable[5]; } else { echo 0; }?> </center></td>
							<?php 
								$amount = 0;
								if($pin != "N/A") {
									$amount = $billable[4] * ($billable[1] - $billable[5]);
								}
								else {
									$amount = $billable[4] * $billable[1];
								}
								$subtotal = $subtotal + $amount;
							?>
								<td><center><?php echo $amount ?></center></td>
							</tr>
							<?php 	
									} 
								}
							?>
						</tbody>
					</table>
				</div>
		</form>
		
		<form action = "generatePdf" method = "post" style = "margin-left: 10%; margin-right: 10%;">
			
			</br>
			</br>
			</br>
			<div class="col-xs-7">
				<b><i> OTHER(S):</i><input class = "form-control" id = "others_field" name="others_field" placeholder = " Enter other billables here.. " > </b>
			</div>
			<div class="col-xs-2" style = "float: right">
				<b> PHP <input class = "form-control" id = "others_amount" name = "others_amount" type = "text" style = "text-align: center;" value = "" placeholder = "Price"> </b>
			</div>
			</br>
			</br>
			</br>
			</br>
			</br>
			<input type = "hidden" id = "real_subtotal" value = <?php echo $subtotal ?>/>
			<div class = "col-xs-3" style = "float:right">
				<b> <i> SUBTOTAL: </i> </b> &nbsp &nbsp <b> (PHP) </b> <input class = "form-control" type = "text" id = "subtotal" name = "subtotal" style = "text-align: center; font-weight: bold;" readonly = "true" value = <?php echo $subtotal ?>  /> 
			</div>
			</br>
			</br>
			</br>
			</br>
			<div class = "panel" style = "margin-right : 50%;">
				<div class = "panel-heading">
					<b><h4>Discount</h4></b>
				</div>
				<div class = "panel-content">
					<div class = "col-xs-4">
						<b> PHP </b> <input class = "form-control" type = "text" id = "discount" style = "text-align: center;" name = "discount" value = "0"/> 
					</div>
				</div>
			</div>
			</br>
			<div class = "panel" style = "margin-right : 50%;">
				<div class = "panel-heading">
					<b><h4>Vat</h4></b>
				</div>
				<div class = "panel-content">
					<div class = "col-xs-4">
						<b></span><input class = "form-control" type = "text" name = "vat" id = "vat" style = "text-align: center;" value = "12"/></b>
					</div>
					<b>%</b>
				</div>
			</div>
			</br>
			</br>
			<?php
				$discount = 0;	
				$total = 0;
				$total = $subtotal + ($subtotal * 12 * 0.01) - $discount;
			?>
			<div class = "col-xs-4" style = "float:right">
				<b> TOTAL PAYMENT REQUIRED: &nbsp &nbsp (PHP) </b> <input class = "form-control" type = "text" name = "total" id = "total" style = "text-align: center; font-weight: bold;" readonly = "true" value = "<?php echo $total ?>" /> 
			</div>
			</br>
			</br>
			</br>
			<div class = "panel" style = "margin-right : 50%;">
				<div class = "panel-heading">
					<b><h4>Mode of Payment</h4></b>
				</div>
				<div class = "panel-content">
						<select id = "mode_of_payment" name = "mode_of_payment">
							<option value="Cash">Cash</option>
							<option value="Check">Check</option>
							<option value="Card">Card</option>
							<option value="Charge">Charge</option>
						</select>		
				</div>
			</div>
			<span id = "payment_details"> </span>
			</br>
			</br>
			<span> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <button class="btn btn-primary" type="submit"> Generate Receipt </button>
			<input type = "hidden" name = "id" id = "true_id" value = <?php echo $id; ?>>
			<input type = "hidden" name = "OR_NUMBER" id = "OR_NUMBER" value = "0">
		</form>
	
		<!-- hidden part !-->
		<span style = "float: right; margin-right: 10%;"> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <button class="btn btn-primary" id = "pay_button"> Pay </button> </span>
		<br/>
		<br/>
		</div>
	</div>
	</section>
</section>
      <!--main content end-->