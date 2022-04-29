      <!--main content start-->
<section id="main-content">
	<section class="wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header">Create New User</h3>
		</div>
	</div>
	  <!-- page start-->
	  <form method = "post" action = "<?php echo base_url();?>createuser">
	  	Name: <br>
	  	First Name: <input type = "text" name = "fname"> <br>
	  	Middle Name: <input type = "text" name = "mname"> <br>
	  	Last Name: <input type = "text" name = "lname"> <br>
	  	
	  	Sex:
	  	<input type = "radio" name = "sex" value = "m"> Male
	  	<input type = "radio" name = "sex" value = "f"> Female

	  	Contact Details <br>
	  	Mailing Address: <input type = "text" name = "haddr"> <br>
	  	Email Address: <input type = "text" name = "eaddr"> <br>
	  	Contact Number: <input type = "text" name = "cnum"> <br> 

	  	Profile: <br>
	  	Username: <input type = "text" name = "uname"> <br>
	  	Password: <input type = "password" name = "pass"> <br>
	  	Position: 
	  		<select name = "position">
	  			<option value = "1">Super User</option>
	  			<option value = "2">Doctor</option>
	  			<option value = "3">Physician's Assistant</option>
	  			<option value = "4">Secretary</option>
	  			<option value = "5">Cashier</option>
	  			<option value = "6">Research Assistant</option>
	  			<option value = "7">Accountant</option>
	  		</select> <br>
	  	Date of Employment: <input type = "date" name = "doe"> <br>
	  	PRC Number:  <input type = "text" name = "uname"> <br>

	  	<input type = "submit" value = "Add User">
	  </form>
	  <!-- page end-->
	</section>
</section>
      <!--main content end-->