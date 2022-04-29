 <!--main content start-->
<section id="main-content">
	<section class="wrapper">
	<br/>
	<br/>
	<script type = "text/javascript" src = '<?php echo base_url(); ?>assets/js/jquery-1.8.3.min.js'></script>
	<script type = "text/javascript">
		$(document).ready(function() {
			$("#id").keydown(function(event) {
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
	<div class = "panel panel-primary" style = "width: 100%;">
		<div class = "panel-heading">
			<h3> Search By ID </h3>
		</div>
		<div class = "panel-content">
			<form action = "displayBill" method = "post">
				<br/>
				<br/>
				<br/>
				<div class="col-xs-3">
					<b> Enter ID Here: </b> &nbsp &nbsp <input class="form-control" id="id" type="text" style = "text-align: center" name = "id"/> &nbsp &nbsp &nbsp
				</div>
				<br/>
				<br/>
				<b style = "margin-left: 10%"><button class="btn btn-primary" type="submit"> Search </button></b>
			</form>
		</div>
	</div>
	</section>
</section>
      <!--main content end-->