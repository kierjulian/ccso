 <!--main content start-->
<section id="main-content">
	<section class="wrapper">
	<br/>
	<br/>
	<div class = "panel panel-success" style = "width: 100%;">
		<div class = "panel-heading">
			<h3> Results </h3>
		</div>
		<div class = "panel-content">
		<br/>
		<br/>
		<?php foreach($results as $result) { ?>
				<form action = "displayBill" method = "post">
					<b> First Name: </b>  &nbsp  <input type = "text" name = "first_name" style="text-align: center" readonly = "true" value = "<?php echo $result[0] ?>"/> &nbsp &nbsp &nbsp
					<b> Last Name: </b>  &nbsp  <input type = "text" name = "last_name" style="text-align: center" readonly = "true" value = "<?php echo $result[1] ?>"/> &nbsp &nbsp &nbsp
					<b> ID: </b>  &nbsp <input type = "text" name = "id" readonly = "true" style="text-align: center" value = "<?php echo $result[2] ?>"/> &nbsp &nbsp &nbsp
					<button class="btn btn-primary" type="submit">Select Patient</button>
				</form>
		<?php } ?>
			</div>
		</div>
	</section>
</section>
      <!--main content end-->