	<!--main content start-->

<section id="main-content">
	<section class="wrapper">
	<!-- Page Heading -->
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header"><i class="fa fa fa-bars"></i> PATIENT FORM</h2>
			<ol class="breadcrumb">
				<li><i class="fa fa-home"></i><a href='<?php echo base_url();?>home/'>Home</a></li>
				<li><i class="fa fa-table"></i><a href="">Add/Edit</a></li>
			</ol>
		</div>
	</div>
	
		<div class="row">			
		</div>
		<div class="panel panel-primary">
		
			<div class="panel-heading">
				<h2 class="">Patient Information</h3>	
			</div>
			
			<div class="panel-body">
				<form class="form-horizontal form-validate" method='post' id = "patient_form" enctype="multipart/form-data" accept-charset="utf-8" action = "<?php echo $_SERVER["REQUEST_URI"]; ?>">
					<div class="form-group">
						<label for="patientname" class="col-sm-2 control-label">Name <span class="required">*</span></label>
						<div class="col-sm-3">
							<input name='<?php echo Patient::LAST_NAME; ?>' class="form-control" placeholder="Last Name" required id = 'lname' value="<?php echo (set_value(Patient::LAST_NAME) == false? (isset($patient->{Patient::LAST_NAME})? $patient->{Patient::LAST_NAME} : ""): set_value(Patient::LAST_NAME)); ?>" />
							<?php echo form_error(Patient::LAST_NAME); ?>
						</div>
						
						<!--<label for="patientname" class="col-sm-2 control-label">First</label>-->
						<div class="col-sm-3">
							<input name='<?php echo Patient::FIRST_NAME; ?>' class="form-control" placeholder="First Name" required id = 'fname' value="<?php echo (set_value(Patient::FIRST_NAME) == false? (isset($patient->{Patient::FIRST_NAME})? $patient->{Patient::FIRST_NAME} : ""): set_value(Patient::FIRST_NAME)); ?>" />
							<?php echo form_error(Patient::FIRST_NAME); ?>
						</div>
						
						<!--<label for="patientname" class="col-sm-2 control-label">Middle</label>-->
						<div class="col-sm-2">
							<input name='<?php echo Patient::MIDDLE_NAME; ?>' class="form-control" placeholder="Middle Name" id = 'mlname' value="<?php echo (set_value(Patient::MIDDLE_NAME) == false? (isset($patient->{Patient::MIDDLE_NAME})? $patient->{Patient::MIDDLE_NAME} : ""): set_value(Patient::MIDDLE_NAME)); ?>" />
							<?php echo form_error(Patient::MIDDLE_NAME); ?>
						</div>
							
						
					</div>
					<div class="form-group">
					<label for="patientsex" class="col-sm-2 control-label">Sex <span class="required">*</span></label>
						<div class="col-sm-3">
							<select name='<?php echo Patient::SEX; ?>' class="form-control" required id = 'sex'>
								<option value='<?php echo Patient::MALE; ?>' <?php echo set_select(Patient::SEX, Patient::MALE, ( (!empty($dataSex) && $data == Patient::MALE) || (isset($patient->{Patient::SEX}) && $patient->{Patient::SEX} == Patient::MALE)? TRUE : FALSE )); ?>>Male</option>
								<option value='<?php echo Patient::FEMALE; ?>' <?php echo set_select(Patient::SEX, Patient::FEMALE, ( (!empty($dataSex) && $data == Patient::FEMALE) || (isset($patient->{Patient::SEX}) && $patient->{Patient::SEX} == Patient::FEMALE)? TRUE : FALSE )); ?>>Female</option>
							</select>
						<?php echo form_error(Patient::SEX); ?>
						</div>
						<label for="patientbirth" class="col-sm-2 control-label">Birthday <span class="required">*</span></label>
						<div class="col-sm-3">
							<input name='<?php echo Patient::BIRTHDAY; ?>' value="<?php echo (set_value(Patient::BIRTHDAY) == false? (isset($patient->{Patient::BIRTHDAY})? $patient->{Patient::BIRTHDAY} : ""): set_value(Patient::BIRTHDAY)); ?>" type="date" class="form-control" required id = 'bdate' />
						<?php echo form_error(Patient::BIRTHDAY); ?>
						</div>
					</div>
					
					<div class="form-group">
						<label for="patientaddress" class="col-sm-2 control-label">Address</label>			
						<div class="col-sm-8">
							<input name='<?php echo Patient::ADDRESS; ?>' value="<?php echo (set_value(Patient::ADDRESS) == false? (isset($patient->{Patient::ADDRESS})? $patient->{Patient::ADDRESS} : " ") : set_value(Patient::ADDRESS)); ?>" class="form-control" id = 'address' />
						<?php echo form_error(Patient::ADDRESS); ?>
						</div>
				
							
					</div>

					<div class="form-group">
						<label for="patienteduc" class="col-sm-2 control-label" >Educational Attainment<span class="required">*</span></label>
						
						<div class="col-sm-3">
							<select name='<?php echo Patient::EDUC_ATTAINMENT; ?>' class="form-control" required id = 'educ'>
								<option value='<?php echo Patient::NONE; ?>' <?php echo set_select(Patient::EDUC_ATTAINMENT, Patient::NONE, ( (!empty($dataEduc) && $data == Patient::NONE) || (isset($patient->{Patient::EDUC_ATTAINMENT}) && $patient->{Patient::EDUC_ATTAINMENT} == Patient::NONE)? TRUE : FALSE )); ?> >No Grade Completed</option>
								
								<option value='<?php echo Patient::ELEM_UNDERGRAD; ?>' <?php echo set_select(Patient::EDUC_ATTAINMENT, Patient::ELEM_UNDERGRAD, ( (!empty($dataEduc) && $data == Patient::ELEM_UNDERGRAD) || (isset($patient->{Patient::EDUC_ATTAINMENT}) && $patient->{Patient::EDUC_ATTAINMENT} == Patient::ELEM_UNDERGRAD)? TRUE : FALSE )); ?> >Elementary Undergraduate</option>
								
								<option value='<?php echo Patient::ELEM_GRAD; ?>' <?php echo set_select(Patient::EDUC_ATTAINMENT, Patient::ELEM_GRAD, ( (!empty($dataEduc) && $data == Patient::ELEM_GRAD) || (isset($patient->{Patient::EDUC_ATTAINMENT}) && $patient->{Patient::EDUC_ATTAINMENT} == Patient::ELEM_GRAD)? TRUE : FALSE )); ?> >Elementary Graduate</option>
								
								<option value='<?php echo Patient::HS_UNDERGRAD; ?>' <?php echo set_select(Patient::EDUC_ATTAINMENT, Patient::HS_UNDERGRAD, ( (!empty($dataEduc) && $data == Patient::HS_UNDERGRAD) || (isset($patient->{Patient::EDUC_ATTAINMENT}) && $patient->{Patient::EDUC_ATTAINMENT} == Patient::HS_UNDERGRAD)? TRUE : FALSE )); ?> >High School Undergraduate</option>
								
								<option value='<?php echo Patient::HS_GRAD; ?>' <?php echo set_select(Patient::EDUC_ATTAINMENT, Patient::HS_GRAD, ( (!empty($dataEduc) && $data == Patient::HS_GRAD) || (isset($patient->{Patient::EDUC_ATTAINMENT}) && $patient->{Patient::EDUC_ATTAINMENT} == Patient::HS_GRAD)? TRUE : FALSE )); ?> >High School Graduate</option>
								
								<option value='<?php echo Patient::COLL_UNDERGRAD; ?>' <?php echo set_select(Patient::EDUC_ATTAINMENT, Patient::COLL_UNDERGRAD, ( (!empty($dataEduc) && $data == Patient::COLL_UNDERGRAD) || (isset($patient->{Patient::EDUC_ATTAINMENT}) && $patient->{Patient::EDUC_ATTAINMENT} == Patient::COLL_UNDERGRAD)? TRUE : FALSE )); ?>
								<?php if (isset($patient->{Patient::EDUC_ATTAINMENT}) && ($patient->{Patient::EDUC_ATTAINMENT}) == Patient::COLL_UNDERGRAD) echo "selected"; ?>>College Undergraduate</option>
								
								<option value='<?php echo Patient::COLL_GRAD; ?>' <?php echo set_select(Patient::EDUC_ATTAINMENT, Patient::COLL_GRAD, ( (!empty($dataEduc) && $data == Patient::COLL_GRAD) || (isset($patient->{Patient::EDUC_ATTAINMENT}) && $patient->{Patient::EDUC_ATTAINMENT} == Patient::COLL_GRAD)? TRUE : FALSE )); ?>
								<?php if (isset($patient->{Patient::EDUC_ATTAINMENT}) && ($patient->{Patient::EDUC_ATTAINMENT}) == Patient::COLL_GRAD) echo "selected"; ?>>College Graduate</option>
							</select>
						<?php echo form_error(Patient::EDUC_ATTAINMENT); ?>
						</div>
						
						<label for="patientnationality" class="col-sm-2 control-label" >Nationality</label>			
						<div class="col-sm-3">
							<input name='<?php echo Patient::NATIONALITY; ?>' value="<?php echo (set_value(Patient::NATIONALITY) == false? (isset($patient->{Patient::NATIONALITY})? $patient->{Patient::NATIONALITY} : "Filipino"): set_value(Patient::NATIONALITY)); ?>" class="form-control" id = 'nationality' />
						<?php echo form_error(Patient::NATIONALITY); ?>
						</div>
							
					</div>						  
				  
					<div class="form-group">
						<label for="patientcontact" class="col-sm-2 control-label" >Contact No. <span class="required">*</span></label>
						<div class="col-sm-3">
							<input name='<?php echo Patient::CONTACT_NUM; ?>' value="<?php echo (set_value(Patient::CONTACT_NUM) == false? (isset($patient->{Patient::CONTACT_NUM})? $patient->{Patient::CONTACT_NUM} : ""): set_value(Patient::CONTACT_NUM)); ?>" id = 'contact' class="form-control" />
						<?php echo form_error(Patient::CONTACT_NUM); ?>
						</div>
						
						
					</div>	
						
					<div class="form-group">
						<label for="patientphysician" class="col-sm-2 control-label">Physician In Charge</label>
						<div class="col-sm-3">
							<input name='<?php echo Patient::PHYSICIAN; ?>' value="<?php echo (set_value(Patient::PHYSICIAN) == false? (isset($patient->{Patient::PHYSICIAN})? $patient->{Patient::PHYSICIAN} : ""): set_value(Patient::PHYSICIAN)); ?>" class="form-control" id = 'physician' placeholder="Physician" />
						<?php echo form_error(Patient::PHYSICIAN); ?>
						</div>
						
						<label for="patientpwd" class="col-sm-2 control-label">Person-with-disability? <span class="required">*</span></label>
						<div class="col-sm-3">
						  <label class="label_radio" for="radio-01">
							  <input name="<?php echo Patient::PWD; ?>" value="<?php echo Patient::IS_PWD; ?>" <?php echo set_radio(Patient::PWD, '1', ( (!empty($dataPwd) && $data == Patient::IS_PWD) || (isset($patient->{Patient::PWD}) && $patient->{Patient::PWD} == Patient::IS_PWD ) ? TRUE : FALSE )); ?> required type="radio" id = 'pwd' />YES &nbsp;&nbsp;&nbsp;
						  </label>
						  <label class="label_radio" for="radio-02">
							   <input name="<?php echo Patient::PWD; ?>" value="<?php echo Patient::NOT_PWD; ?>" <?php echo set_radio(Patient::PWD, '0', ( (!empty($dataPwd) && $data != Patient::IS_PWD) || (isset($patient->{Patient::PWD}) && $patient->{Patient::PWD} == Patient::NOT_PWD )) ? TRUE : FALSE ); ?> required type="radio" id = 'pwd' />NO
						  </label>
						<?php echo form_error(Patient::PWD); ?>
					  </div>
					</div>
					
					<label for="patientcontact" class="control-label col-lg-2">Contact Persons</label>
					<div class='form-horizontal form-group'>	
					
		<?php	
				for ($i = 0; $i < 3; $i++)
				{	
					$contact = (isset($contacts[$i]) ? $contacts[$i] : null);
					$tempName = EmergencyContact::CONTACT_NAME . $i;
					$tempNum = EmergencyContact::CONTACT_NUM . $i;
		?>
						<div class='col-sm-10'>
							<label for='patientcontact' class='col-sm-2 control-label'>Name</label>
							<div class='col-sm-3'>
								<input name='<?php echo $tempName; ?>' 
								value="<?php echo ( set_value($tempName) == false? ($contact != null? $contact->{EmergencyContact::CONTACT_NAME} : "") : set_value($tempName) ); ?>"
								class='form-control' placeholder='Name' id = 'patientcontact' />
								
								<?php echo form_error($tempName); ?>	
							</div>
							
							<label for='patientcontact' class='col-sm-2 control-label'>Contact No.</label>
							<div class='col-sm-3'>
								<input name='<?php echo $tempNum; ?>' 
								value="<?php echo ( set_value($tempNum) == false? ($contact != null? $contact->{EmergencyContact::CONTACT_NUM} : "") : set_value($tempNum) ); ?>"
								class='form-control' id = 'patientcontactnum' />
								
								<?php echo form_error($tempNum); ?>
							</div>
						</div>
		<?php
				}	
		?>
				
					</div>
					
					<label for="patienthealthcard" class="control-label col-lg-2">Health Cards</label>
					<div class='col-lg-2'>
							<a href='<?php echo base_url() . "admit/cards"; ?>' class="btn btn-sm btn-default"><i class='icon_plus_alt'></i>&nbsp;&nbsp;<b>Manage health cards</b></a>
						</div>
					
					<div class='form-horizontal form-group'>
					
					
			<?php	for ($i = 0; $i < 2; $i++)
					{	
						$card = (isset($cards[$i]) ? $cards[$i] : null);
						$tempType = HealthCard::CARD_TYPE . $i;
						$tempNum = HealthCard::CARD_NUMBER . $i;
						
			?>
						<div class='col-sm-10'>
							<label for='patienthealthcard' class='control-label col-lg-2'>Health Card</label>
							<div class='col-sm-3'>
								<select name='<?php echo $tempType; ?>' class='form-control' id = 'healthcard'>
									
							<?php
								foreach ($cardList as $cardElt)
								{
										$cardEltType = $cardElt->{HealthCard::CARD_TYPE};
										echo $cardEltType;
							?>
									<option value='<?php echo $cardEltType; ?>'	
									<?php echo set_select($tempType, $cardEltType, ( (!empty($dataHealth) && $data == $cardEltType) || ($card != null && $card->{HealthCard::CARD_TYPE} == $cardEltType)? TRUE : FALSE )); ?>
									><?php echo $cardElt->{HealthCard::CARD_NAME}; ?></option>
							<?php	
								}
							?>
								</select>
							<?php 
		
							echo form_error($tempType); 
							?>
							</div>
						
							<label for='patienthealthcard' class='col-sm-2 control-label'>Health Card Number</label>
							<div class='col-sm-3'>
								<input name='<?php echo $tempNum; ?>'
								value="<?php echo ( set_value($tempNum) == false? ($card != null? $card->{HealthCard::CARD_NUMBER} : "") : set_value($tempNum) ); ?>" class='form-control' placeholder='Name' id = 'patientcontact' />
							</div>
							<?php 
								echo form_error($tempNum); 
							?>
						</div>
			<?php	}	?>
						
					</div>
					
					<div class="form-group">
						<label for="exampleInputFile" class="col-sm-2 control-label">Photo</label>
					   <div class="col-sm-10">
					  <input type="file" name="<?php echo Image::HTML_FILE; ?>" class = 'btn btn-primary'>
					  </div>
				    </div>

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" name='submit' value='Submit' class="btn btn-lg btn-primary pull-center" />
							<input type="reset" name='rese' value='Reset' class="btn btn-lg btn-success pull-center" />
						</div>
						
					</div>
				</form>						                       
			</div>
		</div>
	</section>
</section>
<!--main content end-->