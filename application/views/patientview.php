<!--ORIGINAL-->
<!--main content start-->

<section id="main-content">
	<section class="wrapper">
	
	<?php
		require_once "Patient.php";
		require_once "EmergencyContact.php";
		require_once "ScheduledAppointment.php";
		require_once "HealthCard.php";
		require_once "Image.php";
	?>
	<div class="row">
	</div>
	<div class="row">
		<!-- profile-widget -->
		<div class="col-lg-12">
			<div class="profile-widget profile-widget-info">
				<div class="panel-body">
					<div class="col-lg-2 col-sm-2">
						<h4><?php echo ucwords(strtolower($patient->{Patient::FIRST_NAME})); ?></h4>               
						<div class="follow-ava">
							<img src="<?php echo ($dp != null ? $dp->{Image::TABLE_IMAGEPATH} : ""); ?>" alt="">
						</div>
						<h6>Patient</h6>
						<div class="btn-group-vertical">
							<!-- add if statements here-->
							
						<?php
							if ($patient->{Patient::PWD} == Patient::IS_PWD)
							{
						?>
								<div class="follow-ava">
									<img style="height:25px; width: 25px;"src="<?php echo base_url(); ?>assets/img/pwd.png" alt="" title="PWD">
								</div>
						<?php
							}
						?>
						
						<?php
							if (Patient::isSrCitizen($patient->{Patient::BIRTHDAY}))
							{
						?>
								<!-- add if statements here-->
								<div class="follow-ava">
									<img style="height:25px; width: 25px;"src="<?php echo base_url(); ?>assets/img/senior.png" alt="" title="Senior Citizen">
								</div>
						<?php
							}
						?>
						
						<?php
							if (Patient::isSuki($patient->{Patient::CREATION_DATE}))
							{
						?>
								<!-- add if statements here-->
								<div class="follow-ava">
									<img style="height:25px; width: 25px;"src="<?php echo base_url(); ?>assets/img/loyal.png" alt="" title="Loyalty">
								</div>
						<?php
							}
						?>
							</div>
							
							<br /><br /><br />
							
					</div>
					<div class="col-lg-10 col-sm-10 ">
						<section class="">

								<h5><?php echo Patient::getPatientID($patient->{Patient::CREATION_DATE}, $patient->{Patient::CREATION_NUM}); ?></h5>
								<h4><?php echo Patient::getFullName($patient->{Patient::LAST_NAME}, $patient->{Patient::FIRST_NAME}, $patient->{Patient::MIDDLE_NAME}) ?></h4>

							
						</section>
					</div>
					<div>&nbsp;</div>
					<div class="col-lg-10 col-sm-10 ">
						<div class="btn-group">
							<a href='<?php echo base_url(); ?>profile/enqueue/<?php echo $patient->{Patient::TRUE_ID}; ?>' class="btn btn-default"><i class='icon_plus_alt'></i>&nbsp;&nbsp;Add to Queue</a>
							<a href='<?php echo base_url(); ?>profile/edit/<?php echo $patient->{Patient::TRUE_ID}; ?>' class="btn btn-default"><i class='icon_pencil'></i>&nbsp;&nbsp;Edit</a>
							<a href='#uploadModal' data-toggle="modal" class="btn btn-default"><i class='icon_cloud'></i>&nbsp;&nbsp;Upload</a>
							<a href='#schedModal' data-toggle="modal" class="btn btn-default"><i class='icon_clock'></i>&nbsp;&nbsp;Set Schedule</a>
							</div>
							<!--Popup schedule-->
							<div class="panel-body">
								<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="1" id="schedModal" class="modal fade">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
												<h4 class="modal-title">Set Schedule</h4>
											</div>
											<div class="modal-body">
											<!-- Edit profile form (not working)-->
												<form method="post" class="form-validate form-horizontal"  action="<?php echo base_url(); ?>profile/schedule/<?php echo $patient->{Patient::TRUE_ID}; ?>" >
												  <!-- Date -->
													<div class="form-group">
														<label class="control-label col-lg-2" for="date">Date</label>
														<div class="col-lg-10">
															<input name="<?php echo ScheduledAppointment::SCHEDULE_DATE; ?>" type="date" class="form-control" required />
														</div>
													</div>  
												  
												  <!-- Time -->
													<div class="form-group">
														<label class="control-label col-lg-2" for="time">Time</label>
														<div class="col-lg-10">
															<input name="<?php echo ScheduledAppointment::SCHEDULE_TIME; ?>" type="time" class="form-control" required />
														</div>
													</div>  
												  
												  <!-- Remarks -->
													<div class="form-group">
														<label class="control-label col-lg-2" for="remarks">Remarks</label>
														<div class="col-lg-10">
															<input name="<?php echo ScheduledAppointment::REMARKS; ?>" type="text" class="form-control" maxlength="20"></textarea>
														</div>
													</div>  
												  
												  <!-- Buttons -->
													<div class="form-group">
													 <!-- Buttons -->
														<div class="col-lg-offset-2 col-lg-9">
															<input type="submit" class="btn btn-primary" name="submit" value="Submit" />
															<input type="reset" class="btn btn-default" value="Reset" />
														</div>
													</div>
												  
												</form>
											</div>										  
										</div>
									</div>
								</div>
							</div>
							<!--end of popup schedule-->
							<div class="panel-body">
							<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="0" id="uploadModal" class="modal fade">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
											<h4 class="modal-title">Upload</h4>
										</div>
										<div class="modal-body">
										<!-- Edit profile form (not working)-->
											<form method="post" class="form-validate form-horizontal"  action="<?php echo base_url(); ?>profile/upload/<?php echo $patient->{Patient::TRUE_ID}; ?>" enctype="multipart/form-data" accept-charset="utf-8">												  
												<div class="form-group">
													<label class="control-label col-lg-2" for="title">Title</label>
													<div class="col-lg-10"> 
														<input type="text" class="form-control" name = "<?php echo Image::HTML_TITLE; ?>">
													</div>
												</div>   
											  <!-- Content -->
												<div class="form-group">
													<label class="control-label col-lg-2" for="content">Content</label>
													<div class="col-lg-10">
														<textarea class="form-control" name = "<?php echo Image::HTML_CONTENT; ?>"></textarea>
													</div>
												</div>
												
											  <!-- Cateogry -->
												<div class="form-group">
													<label class="col-lg-2">Category</label>
													<div class="col-lg-10">                               
														<select class="form-control" name = "<?php echo Image::HTML_CATEGORY; ?>">
															<option value="<?php echo Image::RESULT ?>">Result</option>
															<option value="<?php echo Image::PROFILEPICTURE ?>">Profile Picture</option>
															<option value="<?php echo Image::OTHERS ?>">Others</option>
														</select>  
													</div>
												</div>
												
											  <!-- Tags -->
												<div class="form-group">
													<label class="control-label col-lg-2" for="tags">Tags</label>
													<div class="panel-body">
														<input id="tagsinput" name="<?php echo Image::HTML_TAGS; ?>" class="tagsinput" value="" />
													</div>
												</div>
		
												<div class="form-group">
													<label for="exampleInputFile" class="col-sm-2 control-label">Photo</label>
													<div class="col-sm-10">
														<input type="file" name="<?php echo Image::HTML_FILE; ?>" class = 'btn btn-primary' >
													</div>
												</div>
											  
											  <!-- Buttons -->
												<div class="form-group">
												 <!-- Buttons -->
													<div class="col-lg-offset-2 col-lg-9">
														<input type="submit" class="btn btn-primary" value = 'Submit' name = "<?php echo Image::HTML_SUBMITBUTTON; ?>" />
														<button type="reset" class="btn btn-default">Reset</button>
													</div>
												</div>
												
											  
											</form>
										</div>										  
									</div>
								</div>
							</div>
							</div>
							<!-- end of upload popup -->
						
						<!--Popup -->
										
					</div>					
				</div>	
					
					
			</div>
		</div>
	</div>
	  <!-- page start-->
	<div class="">
		<div class="">
			<section class="panel">
				<header class="panel-heading tab-bg-info">
					<ul class="nav nav-tabs">
						<li class="active">
							<a data-toggle="tab" href="#patientinfo">
								<i class="icon-home"></i>
								Patient Info
							</a>
						</li>
						<li>
							<a data-toggle="tab" href="#doctorspage">
								<i class="icon-home"></i>
								Diagnoses
							</a>
						</li>
						<li>
							<a data-toggle="tab" href="#clinicalordering">
								<i class="icon-user"></i>
								Clinical Orders
							</a>
						</li>
						<li class="">
							<a data-toggle="tab" href="#results">
								<i class="icon-envelope"></i>
								Scanned Documents
							</a>
						</li>
					</ul>
				</header>
				<div class="panel-body">
					<div class="tab-content">
						<div id="patientinfo" class="tab-pane active">
							<div class="col-lg-10 col-sm-10 ">
						<section class="panel">
							<table class="table">
								<tbody>
									<!--<tr class="">
										<th class="warning" colspan=4>Patient Information</th>
										
									</tr>-->
									<tr class="">
										<th class="success">Name</th>
										<th colspan="3"><?php echo Patient::getFullName($patient->{Patient::LAST_NAME}, $patient->{Patient::FIRST_NAME}, $patient->{Patient::MIDDLE_NAME}) ?></th>										
									</tr>
									<tr class="">
										<th class="success">Patient ID</th>
										<th><?php echo Patient::getPatientID($patient->{Patient::CREATION_DATE}, $patient->{Patient::CREATION_NUM}); ?></th>
										<th class="success">Sex</th>
										<th><?php echo Patient::getSex($patient->{Patient::SEX}); ?></th>
									</tr>

									<tr class="">                                
										<th class="success">Birthday</th>
										<th><?php echo Patient::getBirthday($patient->{Patient::BIRTHDAY}); ?></th>
										
										<th class="success">Age</th>
										<th><?php echo Patient::getAge($patient->{Patient::BIRTHDAY}); ?></th>	
										
									</tr>                                                                                   
									<tr class="">
										<th class="success">Address</th>
										<th colspan = '3'><?php echo $patient->{Patient::ADDRESS}; ?></th>
									</tr>
									<tr class="">
										<th class="success">Contact No.</th>
										<th class=><?php echo $patient->{Patient::CONTACT_NUM}; ?></th>

										<th class="success">Nationality</th>
										<th><?php echo $patient->{Patient::NATIONALITY}; ?></th>
									</tr>
									<tr class="">
										<th class="success">Educational Attainment</th>
										<th><?php echo Patient::getEducAttainment($patient->{Patient::EDUC_ATTAINMENT}); ?></th>
										
										<th class="success">Physician In Charge</th>
										<th><?php echo $patient->{Patient::PHYSICIAN} ?></th>
									</tr>
									
									<tr class="">
										<th class="warning" >Health Cards</th>
										<th></th>
										<th class="warning">Emergency Contacts</th>
										<th></th>
									</tr>

									
						<?php	
								$j = count($healthcards);
								$k = count($contacts);
								
								for ($i = 0; $i < ($j >= $k ? $j : $k); $i++)
								{	
						?>
									<tr class=''>
										<th class='<?php echo (isset($healthcards[$i]) ? "success" : ""); ?>'><?php if (isset($healthcards[$i])) echo $healthcards[$i]->getCardType(); ?></th>
										<th><?php if (isset($healthcards[$i])) echo $healthcards[$i]->get(HealthCard::CARD_NUMBER); ?></th>
											
										<th class='<?php echo (isset($contacts[$i]) ? "success" : ""); ?>'><?php if (isset($contacts[$i])) echo $contacts[$i]->get(EmergencyContact::CONTACT_NAME); ?></th> 
										<th><?php if (isset($contacts[$i])) echo $contacts[$i]->get(EmergencyContact::CONTACT_NUM); ?></th>
											
									</tr>		
						<?php
								}	
						?>
								</tbody>
							</table>
						</section>
					</div>
						</div>
						<div id="doctorspage" class="tab-pane">
							<div class="panel panel-danger">
								<div class="panel-heading">
									<h2 class="">Previous Assesment</h3>			
								</div>		
								 
								<div class="panel-body">
									Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris nec venenatis nulla. Duis sed eleifend ante. Pellentesque ex urna, commodo molestie nisi ac, ultrices vestibulum erat. Mauris eu fermentum lectus. Mauris semper ipsum ac sapien lacinia imperdiet. Morbi vulputate posuere diam vel blandit. Donec felis nisi, ullamcorper eu metus nec, interdum lacinia felis.
								</div>
							</div>
						</div>
						  <!-- profile -->
						<div id="clinicalordering" class="tab-pane">
							<div class="profile-activity">                                          
								<div class="act-time">                                      
									<div class="activity-body act-in">
										<span class="arrow"></span>
										<div class="text">											  
											<p class="attribution"><a>Dr. Damian Fadri</a> at 4:25pm, 30th October 2014</p>
											<p>Requested for patient's X-ray</p>
										</div>
									</div>
								</div>
								<div class="act-time">                                      
									<div class="activity-body act-in">
										<span class="arrow"></span>
										<div class="text">											  
											<p class="attribution"><a>Dr. Chico Psy</a> at 4:25pm, 13th November 2014</p>
											<p>Requested for patient's CBC</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						  <!-- edit-profile -->
						<div id="results" class="tab-pane">
							<section id="portfolio">
								<div class="container">
									<!-- Page Header -->
									<div class="row">
										<div class="col-lg-12 text-center">
											<hr class="star-primary">
										</div>
									</div>
									<!-- /.row -->

					
						<!-- Image previews -->	
					<?php	
							$i = 0;
							foreach ($images as $image)
							{
								if ($i % 3 == 0)
									echo "<div class='row'>";
					?>
											
										<div class='col-md-4 portfolio-item' >
											<a href='<?php printf("#imageModal%d", $image->{Image::TABLE_IMAGEID}); ?>' class='portfolio-link' data-toggle='modal'>
												<div class='caption'>
													<div class='caption-content'>
														<i class='fa fa-search-plus fa-3x'></i>
													</div>
												</div>
												<img src='<?php echo $image->{Image::TABLE_IMAGEPATH}; ?>' class='img-responsive ' style='width: 300px; height: 200px;' />
											<h3><?php echo Image::trimTitle( $image->{Image::TABLE_TITLE} ); ?></h3>
											</a>
										</div>
										
					<?php		
								if ($i++ % 3 == 2)
									echo "</div>";
							}
							if ($i % 3 != 0)
								echo "</div>";
					?>
					<!-- End of image previews -->				
									<hr>

									<!-- /.row -->
								</div>
							</section>
						</div>
					
					<!-- Start of image modals -->
			<?php		
				foreach ($images as $image)
				{
			?>
					<div class='portfolio-modal modal fade' id='<?php printf("imageModal%d", $image->{Image::TABLE_IMAGEID}); ?>' tabindex='-1' role='dialog' aria-hidden='true'>
						<div class='modal-content'>
							<div class='close-modal' data-dismiss='modal'>
								<div class='lr'>
									<div class='rl'>
									</div>
								</div>
							</div>
							<div class='container'>
								<div class='row'>
									<div class='col-lg-8 col-lg-offset-2'>
										<div class='modal-body'>
											<h2><?php echo $image->{ Image::TABLE_TITLE }; ?></h2> 
											<hr class='star-primary'>
											<img src='<?php echo $image->{ Image::TABLE_IMAGEPATH } ?>' class='img-responsive img-centered' />
											<p><?php echo $image->{ Image::TABLE_CONTENT }; ?></p>
											<ul class='list item-details'>
												<li>
													Category: 
													<strong><?php echo Image::getCategory( $image -> {Image::TABLE_CATEGORY} ); ?></strong>
												</li>
												<li>
												
												<?php
													$token = strtok($image -> {Image::TABLE_IMAGETAGS}, ", ");
													while ($token !== false) {
														echo '<span class="label label-info" style="font-size: 14px;">' . $token . '</span>';
														$token = strtok(", ");
													}
												?>
													
												</li>
											</ul>
											<button type='button' class='btn btn-default' data-dismiss='modal'><i class='fa fa-times'></i> Close</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			<?php		
				}
			?>
			<!--End of image modals-->
					
					</div>
				</div>
			</section>
		</div>
	</div>
	
	  <!-- page end-->
	</section>
</section>
<!--main content end-->