      <!--main content start-->
<section id="main-content">
	<section class="wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header">Create New User</h3>
		</div>
	</div>
	  <!-- page start-->
	  
	<div class="panel panel-primary">
		
		<div class="panel-heading">
			<h3 class="">User Information</h3>	
		</div>
			
		<div class="panel-body">
			<form class="form-horizontal form-validate" method='post' id = "user_form">
			
				<div class="form-group">
					<label for="username" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-3">
							<input name='lname' class="form-control" placeholder="Last Name" required id = 'lname' value='<?php echo (set_value("lname") == false ? (isset($user->lName) ? $user->lName : "") : set_value("lname")); ?>' />
							<?php echo form_error('lname'); ?>
						</div>
						<div class="col-sm-3">
							<input name='fname' class="form-control" placeholder="First Name" required id = 'fname' value='<?php echo (set_value("fname") == false ? (isset($user->fName) ? $user->fName : "") : set_value("fname")); ?>'/>
							<?php echo form_error('fname'); ?>
						</div>
						<div class="col-sm-3">
							<input name='mname' class="form-control" placeholder="Middle Name" required id = 'mname' value='<?php echo (set_value("mname") == false ? (isset($user->mName) ? $user->mName : "") : set_value("mname")); ?>'/>
							<?php echo form_error('mname'); ?>
						</div>
				</div>		
				
				<div class="form-group">
					<label for="usersex" class="col-sm-2 control-label">Sex</label>
						<div class="col-sm-3">
							<select name='sex' class="form-control" required id = 'sex'>
								<option value=0 <?php echo (isset($user->sex) ? (($user->sex == 0) ? "selected='selected'" : "") : ((set_value('sex') == 0) ? "selected='selected'" : "")); ?> >Female</option>
								<option value=1 <?php echo (isset($user->sex) ? (($user->sex == 1) ? "selected='selected'" : "") : ((set_value('sex') == 1) ? "selected='selected'" : "")); ?> >Male</option>	
							</select>
						<?php echo form_error('sex'); ?>
						</div>
				</div>
				
				<div class="form-group">
					<label for="usercontact" class="col-sm-2 control-label">Contact Details:</label>
				</div>
				
				<div class="form-group">
					<label for="mailaddress" class="col-sm-2 control-label">Mailing Address</label>
						<div class="col-sm-7">
							<input name='haddr' class="form-control" placeholder="Mailing Address" id = 'haddr' value='<?php echo (set_value("haddr") == false ? (isset($user->hAddr) ? $user->hAddr : "") : set_value("haddr")); ?>' size=100/>
							<?php echo form_error('haddr'); ?>
						</div>
				</div>

				<div class="form-group">
					<label for="email" class="col-sm-2 control-label">Email Address</label>
						<div class="col-sm-3">
							<input name='eaddr' class="form-control" placeholder="Email Address" required id = 'eaddr' value='<?php echo (set_value("eaddr") == false ? (isset($user->eAddr) ? $user->eAddr : "") : set_value("eaddr")); ?>'/>
							<?php echo form_error('eaddr'); ?>
						</div>
				</div>

				<div class="form-group">
					<label for="contactnumber" class="col-sm-2 control-label">Contact Number</label>
						<div class="col-sm-3">
							<input name='cnum' class="form-control" placeholder="Contact Number" id = 'cnum' value='<?php echo (set_value("cnum") == false ? (isset($user->contactNo) ? $user->contactNo : "") : set_value("cnum")); ?>'/>
							<?php echo form_error('cnum'); ?>
						</div>
				</div>		

				<div class="form-group">
					<label for="profile" class="col-sm-2 control-label">PROFILE:</label>
				</div>
				
				<div class="form-group">
					<label for="userusername" class="col-sm-2 control-label">Username</label>
						<div class="col-sm-3">
							<input name='uname' class="form-control" placeholder="Username" required id = 'uname' value='<?php echo (set_value("uname") == false ? (isset($user->uName) ? $user->uName : "") : set_value("uname")); ?>'/>
							<?php echo form_error('uname'); ?>
						</div>
				</div>

				<div class="form-group">
					<label for="password" class="col-sm-2 control-label">Password</label>
						<div class="col-sm-3">
							<input type='password' name='pass' class="form-control" required id = 'pass' value='' <?php echo (isset($user->pWord) ? "disabled" : ""); ?>/>
							<?php echo form_error('pass'); ?>
						</div>
					<label for="confirmpassword" class="col-sm-2 control-label">Confirm Password</label>
						<div class="col-sm-3">
							<input type='password' name='cpass' class="form-control" required id = 'cpass' value='' <?php echo (isset($user->pWord) ? "disabled" : ""); ?>/>
							<?php echo form_error('cpass'); ?>
						</div>
				</div>

				<div class="form-group">
					<label for="jobposition" class="col-sm-2 control-label">Job Position</label>
						<div class="col-sm-3">
							<?php foreach($modules as $module){ 
								echo "<input type='radio' name='position[]' id='" . $module->job_id . "' value='" . $module->job_id . "'"; 
								if(set_value('position[]')){
									echo "checked='checked'";
								}else{
									if(isset($jobs)){
										foreach($jobs as $job){
											if($module->job_id == $job->job_id){
												echo "checked='checked'";
												break;
											}
										}
									}else{
										echo " ";
									}
								} 
								echo "> &nbsp" . $module->job_name . "<br>";
							} ?>
							<?php echo form_error('position[]'); ?>
						</div>
					<label for="dateofemployment" class="col-sm-2 control-label">Date of Employment</label>
						<div class="col-sm-3">
							<input type='date' name='doe' class="form-control" required id = 'doe' value='<?php echo (set_value("doe") == false ? (isset($user->doe) ? $user->doe : "") : set_value("doe")); ?>'/>
							<?php echo form_error('doe'); ?>
						</div>
				</div>						
							
				<div class="form-group">
					<label for="medicalposition" class="col-sm-2 control-label">Medical Position</label>
						<div class="col-sm-3">
							<input name='mpos' class="form-control" id = 'mpos' value='<?php echo (set_value("mpos") == false ? (isset($user->pos) ? $user->pos : "") : set_value("mpos")); ?>''/>
							<?php echo form_error('mpos'); ?>
						</div>
					<label for="prcnumber" class="col-sm-2 control-label">PRC Number</label>
						<div class="col-sm-3">
							<input name='prc' class="form-control" id = 'prc' value='<?php echo (set_value("prc") == false ? ((isset($user->prcNum) && $user->prcNum != 0) ? $user->prcNum : "") : set_value("prc")); ?>''/>
							<?php echo form_error('prc'); ?>
						</div>
				</div>		
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" name='submit' value='<?php echo ((isset($user->idDoc)) ? "Finish Edit" : "Add User"); ?>' class="btn btn-lg btn-primary pull-center" />
						<input type="reset" name='reset' value='Reset' class="btn btn-lg btn-success pull-center" />
					</div>	
				</div>
						
			</form>
		</div>
		</div>
	  <!-- page end-->
	</section>
</section>
      <!--main content end-->