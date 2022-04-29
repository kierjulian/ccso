<section id="main-content">
	<script type = "text/javascript" src = '<?php echo base_url(); ?>assets/js/jquery-1.8.3.min.js'></script>
	<script type = "text/javascript">
		$("#new_bill").live("click", function(){ 
			$.ajax({
				url: '<?php echo base_url() ?>billing/createNewBill',
				type: 'POST',
				data: {
					id: $("#id").val()
				},
				success: function(data) {
					document.getElementById('code_section').innerHTML = data;
				}
			}); 
		});
		$("#old_bill").live("click", function(){ 
			$.ajax({
				url: '<?php echo base_url() ?>billing/showPendingBills',
				type: 'POST',
				data: {
					id: $("#id").val()
				},
				success: function(data) {
					document.getElementById('code_section').innerHTML = data;
				}
			}); 
		});
		$("#pay_new").live("click", function(){ 
			if($("#payment_required").val() == 0) {
				alert("We cannot bill something that does not have value!");
			}
			else {
				var pdfgenerator_url = '<?php echo base_url() ?>billing/generateInvoice' + '/' + $("#bill_no").val() + '/' + $("#id").val();
				$.ajax({
					url: '<?php echo base_url() ?>billing/recordNewBill',
					type: 'POST',
					data: {
						id: $("#id").val(),
						bill_no: $("#bill_no").val(),
						bill_year: $("#bill_year").val(),
						bill_encounter: $("#bill_encounter").val(),
						subtotal: $("#subtotal").val(),
						others: $("#others_text").val(),
						others_amount: $("#others_amount").val(), 
						discount: $("#discount").val(), 
						vat: $("#vat").val(), 
						payment_required: $("#payment_required").val(), 
					},
					success: function(data) {
						document.getElementById('code_section').innerHTML = "Go to the pending bills section to settle your balance";
					}
				});
				setTimeout(function(){ window.open(pdfgenerator_url) }, 2000);
			}
		});
		$(".pending").live("click", function(){ 
			$.ajax({
				url: '<?php echo base_url() ?>billing/showExistingBill',
				type: 'POST',
				data: {
					id: $("#id").val(), 
					bill_no: $(this).attr('id')
				},
				success: function(data) {
					document.getElementById('code_section').innerHTML = data;
				}
			}); 
		});
		
		$("#pay_old").live("click", function(){ 
			if(parseInt($("#payment_given").val()) > parseInt($("#balance").val())) {
				alert("The payment cannot exceed the balance!");
			}
			else if($("#payment_given").val() == 0) {
				alert("Payment must have value");
			}
			else {
				var pdfgenerator_url = '<?php echo base_url() ?>billing/generateAck' + '/' + $("#bill_no").val() + '/' + $("#id").val();
				$.ajax({
					url: '<?php echo base_url() ?>billing/recordOldBill',
					type: 'POST',
					data: {
						bill_no: $("#bill_no").val(),
						payment_given: $("#payment_given").val(),
						mode_of_payment: $("#mode_of_payment").val(),
						details: $("#details").val(), 
						company: $("#company").val(), 
						card_no: $("#card_no").val(), 
						exp_date: $("#exp_date").val(), 
						bank: $("#bank").val()
					},
					success: function(data) {
						document.getElementById('code_section').innerHTML = data;
					}
				});
				setTimeout(function(){ window.open(pdfgenerator_url) }, 2000);
			}
		});
		$("#mode_of_payment").live("click", function(){ 
			$.ajax({
				url: '<?php echo base_url() ?>billing/generateModeOfPayments',
				type: 'POST',
				data: {
					mode: $("#mode_of_payment").val()
				},
				success: function(data) {
					document.getElementById('payment_details').innerHTML = data;
				}
			}); 
		});
		$("#invoice").live("click", function(){ 
			var pdfgenerator_url = '<?php echo base_url() ?>billing/generateInvoice' + '/' + $("#bill_no").val() + '/' + $("#id").val();
			window.open(pdfgenerator_url);
		});
		$("#discount").live("input", function(){ 
			this.value = this.value.replace(/[^0-9\.]/g,'');
			var discount = this.value * 0.01;
			var subtotal = Number($("#orig_subtotal").val()) + Number($("#others_amount").val());
			var vat = $("#vat").val() * 0.01;
			var total = (subtotal - (subtotal * discount)) + ((subtotal - (subtotal * discount)) * vat);
			$("#payment_required").val(Math.ceil(total));
		});
		$("#vat").live("input", function(){ 
			this.value = this.value.replace(/[^0-9\.]/g,'');
			var subtotal = Number($("#orig_subtotal").val()) + Number($("#others_amount").val());
			var vat = this.value * 0.01;
			var discount = $("#discount").val() * 0.01;
			var total = (subtotal - (subtotal * discount)) + ((subtotal - (subtotal * discount)) * vat);
			$("#payment_required").val(Math.ceil(total));
		});
		$("#others_amount").live("input", function(){ 
			this.value = this.value.replace(/[^0-9\.]/g,'');
			var subtotal = Number($("#orig_subtotal").val()) + Number($("#others_amount").val());
			$("#subtotal").val(Math.ceil(subtotal));
			var vat = $("#vat").val() * 0.01;
			var discount = $("#discount").val() * 0.01;
			var total = (subtotal - (subtotal * discount)) + ((subtotal - (subtotal * discount)) * vat);
			$("#payment_required").val(Math.ceil(total));
		});
		$("#payment_given").live("input", function(){ 
			this.value = this.value.replace(/[^0-9\.]/g,'');
		});
		
	</script>
		<script type = "text/javascript">
	</script>
	<section class="wrapper">
	<br/>
	<br/>
	<div class = "panel panel-primary" style = "width: 100%;" >
		<div class = "panel-heading">
			<h3>Billing</h3>
		</div>
		<div class = "panel-content">
		<br/>
		<span> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <button class='btn btn-primary' id = "new_bill"> Generate Latest Bill </button>
		<span> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <button class='btn btn-primary' id = "old_bill"> See Pending Bills </button>
		<input type = "hidden" id = "id" value = <?php echo $id ?>>
		</div>
	</div>
	<div class = "panel panel-primary" style = "width: 100%;">
		<div class = "panel-content" id = "code_section">
			
		</div>
	</div>
	</section>
</section>

