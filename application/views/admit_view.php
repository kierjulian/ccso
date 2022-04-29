<!--ORIGINAL-->
<!--main content start-->

<!DOCTYPE html>
<style>

	#tagsinput_tag {
		width: 100px;
	}
	
	select option[disabled]
	{
		display: none;
	}
	
</style>

<section id="main-content">
	<section class="wrapper">
	
	<div class="row">
	</div>
	<div class="row">
		<!-- profile-widget -->
		<div class="col-lg-12">
			<div class="profile-widget profile-widget-info">
				<div class="panel-body">
					<div class="col-lg-2 col-sm-2">
						<h4><b><?php echo ucwords(strtolower($patient->{Patient::FIRST_NAME})); ?></b></h4>               
						<div class="follow-ava">
							<img src="<?php echo ($dp != null ? $dp->{Image::TABLE_IMAGEPATH} : ""); ?>" alt="">
						</div>
						<h6><b>Patient</b></h6>
						<div class="btn-group-vertical">
							<!-- add if statements here-->
							
						<?php
							if ($patient->{Patient::PWD} == Patient::IS_PWD)
							{
						?>
								<div class="follow-ava">
									<img style="height:25px; width: 25px;"src="<?php echo base_url();?>assets/img/pwd.png" alt="" title="PWD">
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
									<img style="height:25px; width: 25px;"src="<?php echo base_url();?>assets/img/senior.png" alt="" title="Senior Citizen">
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
									<img style="height:25px; width: 25px;"src="<?php echo base_url();?>assets/img/loyal.png" alt="" title="Loyalty">
								</div>
						<?php
							}
						?>
							</div>
							
							<br /><br /><br />
							
					</div>
					<div class="col-lg-10 col-sm-10 ">
						<section class="">

								<h5><b><?php echo Patient::getBirthday($patient->{Patient::BIRTHDAY}); ?></b></h5>
								<h4><b><?php echo Patient::getFullName($patient->{Patient::LAST_NAME}, $patient->{Patient::FIRST_NAME}, $patient->{Patient::MIDDLE_NAME}) ?></b></h4>

							
						</section>
					</div>
					<div>&nbsp;</div>
					<div class="col-lg-10 col-sm-10 ">
						<div class="btn-group">
							<a href='<?php echo base_url();?>profile/enqueue/<?php echo $patient->{Patient::TRUE_ID}; ?>' class="btn btn-default"><i class='icon_plus_alt'></i>&nbsp;&nbsp;<b>Add to Queue</b></a>
							<a href='<?php echo base_url();?>profile/edit/<?php echo $patient->{Patient::TRUE_ID}; ?>' class="btn btn-default"><i class='icon_pencil'></i>&nbsp;&nbsp;<b>Edit</b></a>
							<a href='#uploadModal' data-toggle="modal" class="btn btn-default"><i class='icon_cloud'></i>&nbsp;&nbsp;<b>Upload</b></a>
							<a href='#schedModal' data-toggle="modal" class="btn btn-default"><i class='icon_clock'></i>&nbsp;&nbsp;<b>Set Schedule</b></a>
							</div>
							
							<!--Popup schedule-->
							<div class="panel-body">
								<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="1" id="schedModal" class="modal fade">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
												<h4 class="modal-title"><b>Set Schedule</b></h4>
											</div>
											<div class="modal-body">
											<!-- Edit profile form (not working)-->
												<form id="schedForm" method="post" class="form-validate form-horizontal"  action="<?php echo base_url();?>profile/schedule/<?php echo $patient->{Patient::TRUE_ID}; ?>" >
												  <!-- Date -->
													<div class="form-group">
														<label class="control-label col-lg-2" for="date"><a style="color:#688a7e; font-weight:bold">Date</a></label>
														<div class="col-lg-10">
															<input name="<?php echo ScheduledAppointment::SCHEDULE_DATE; ?>" type="date" class="form-control" required />
															<?php echo form_error(ScheduledAppointment::SCHEDULE_DATE); ?>
														</div>
													</div>  
												  
												  <!-- Time -->
													<div class="form-group">
														<label class="control-label col-lg-2" for="time"><a style="color:#688a7e; font-weight:bold">Time</a></label>
														<div class="col-lg-10">
															<input name="<?php echo ScheduledAppointment::SCHEDULE_TIME; ?>" type="time" class="form-control" required />
														</div>
													</div>  
												  
												  <!-- Remarks -->
													<div class="form-group">
														<label class="control-label col-lg-2" for="remarks"><a style="color:#688a7e; font-weight:bold">Remarks</a></label>
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
							
							<!--Popup upload-->
							<div class="panel-body">
							<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="0" id="uploadModal" class="modal fade">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
											<h4 class="modal-title"><b>Upload</b></h4>
										</div>
										<div class="modal-body">
										<!-- Edit profile form (not working)-->
											<form method="post" class="form-validate form-horizontal"  action="<?php echo base_url(); ?>profile/upload/<?php echo $patient->{Patient::TRUE_ID}; ?>" enctype="multipart/form-data" accept-charset="utf-8">												  
												<div class="form-group">
													<label class="control-label col-lg-2" for="title"><a style="color:#688a7e; font-weight:bold">Title</a></label>
													<div class="col-lg-10"> 
														<input type="text" class="form-control" name = "<?php echo Image::HTML_TITLE; ?>" required>
													</div>
												</div>   
											  <!-- Content -->
												<div class="form-group">
													<label class="control-label col-lg-2" for="content"><a style="color:#688a7e; font-weight:bold">Content</a></label>
													<div class="col-lg-10">
														<textarea id="pangtrylang" class="form-control" name = "<?php echo Image::HTML_CONTENT; ?>"></textarea>
													</div>
												</div>
												
												<script>
													function onClickButton()
													{
														var TheTextBox = document.getElementById("tagsinput_tag");
														var text = $('#tagsChoices :selected').val();
														
														if ((TheTextBox.value).indexOf(text) == -1)
														{
															document.getElementById("tagsinput_addTag").click();															
															TheTextBox.value = TheTextBox.value + text;
															
															var e = jQuery.Event("keypress");
															e.which = 13; //choose the one you want
															e.keyCode = 13;
															$("#tagsinput_tag").trigger(e);
														}
													};
													
													function changeTags(a)
													{
														
														if (a == 3)			// eye
														{
															// Revert all "eye" classes to visible
															b = document.getElementsByClassName("eye");
															for (i = 0; i < b.length; i++)
															{
																b[i].disabled = false;
															}
															
															// Change all "anc" classes to hidden
															b = document.getElementsByClassName("anc");
															for (i = 0; i < b.length; i++)
															{
																b[i].disabled = true;
															}
														}
														else if (a == 4)			// anc
														{
															// Revert all "anc" classes to visible
															b = document.getElementsByClassName("anc");
															for (i = 0; i < b.length; i++)
															{
																b[i].disabled = false;
															}
															
															// Change all "eye" classes to hidden
															b = document.getElementsByClassName("eye");
															for (i = 0; i < b.length; i++)
															{
																b[i].disabled = true;
															}
														}
														else
														{
															// Revert all "eye" classes to visible
															b = document.getElementsByClassName("eye");
															for (i = 0; i < b.length; i++)
															{
																b[i].disabled = false;
															}
															
															// Revert all "anc" classes to visible
															b = document.getElementsByClassName("anc");
															for (i = 0; i < b.length; i++)
															{
																b[i].disabled = false;
															}
														}		
													};
												</script>
											  <!-- Category -->
												<div class="form-group">
													<label class="col-lg-2"><a style="color:#688a7e; font-weight:bold">Category</a></label>
													<div class="col-lg-10">                               
														<select id="image_category" class="form-control" name = "<?php echo Image::HTML_CATEGORY; ?>" onChange="changeTags(this.value)">
															<option value="<?php echo Image::RESULT ?>">Result</option>
															<option id="eye" value="<?php echo Image::EYE_EXAM ?>">Eye Exam</option>
															<option id="anc" value="<?php echo Image::ANCILLARY_TEST ?>">Ancillary Test</option>
															<option value="<?php echo Image::OTHERS ?>">Others</option>
															
														</select>  
															
													</div>
												</div>
														
														
												<div class="form-group">
													<label class="col-lg-2"><a style="color:#688a7e; font-weight:bold">Choices</a></label>
													
													<div align="left" >
														<input type="button" class="btn btn-primary" style="font-weight:bold;" onclick='onClickButton();' value = 'Add Tag' name = "<?php echo Image::HTML_ADDTAGBUTTON; ?>" />
													
														<div float="center" class="col-md-8"> 
															<select class="form-control" id="tagsChoices">
																<option>---</option>
																<option class="eye" value="<?php echo Image::GROSS ?>">Gross</option>
																<option class="eye" value="<?php echo Image::POST_POLES ?>">Posterior Poles</option>
																<option class="eye" value="<?php echo Image::PUPIL_EXAM ?>">Pupil Exam</option>
																<option class="eye" value="<?php echo Image::STEREOACUITY ?>">Stereoacuity</option>
																<option class="eye" value="<?php echo Image::REFRACTION ?>">Refraction</option>
																<option class="eye" value="<?php echo Image::SLIT_LAMP ?>">Slit Lamp</option>
																<option class="eye" value="<?php echo Image::STRAB_DUCTION ?>">Strabismus Duction</option>
																<option class="eye" value="<?php echo Image::STRAB_FUS_AMPLITUDE ?>">Strabismus Fusional Amplitude</option>
																<option class="eye" value="<?php echo Image::STRAB_MEASUREMENT ?>">Strabismus Measurement</option>
																<option class="eye" value="<?php echo Image::STRAB_VERSION ?>">Strabismus Version</option>
																<option class="eye" value="<?php echo Image::VISUAL_ACUITY ?>">Visual Acuity</option>
																
																<option class="anc" value="<?php echo Image::COLOR ?>" >Color</option>																
																<option class="anc" value="<?php echo Image::INTRA_PRESS ?>">Intraoccular Pressure</option>
																<option class="anc" value="<?php echo Image::NT_EOG ?>">Neurophysiologic Test: EOG</option>
																<option class="anc" value="<?php echo Image::NT_VER ?>">Neurophysiologic Test: VER</option>
																<option class="anc" value="<?php echo Image::OCC_ULTRA ?>">Occular Ultrasound</option>
																<option class="anc" value="<?php echo Image::OCT_DISC ?>">OCT DISC</option>
																<option class="anc" value="<?php echo Image::OCT_MACULA ?>">OCT Macula</option>
																<option class="anc" value="<?php echo Image::OCT_OTHER ?>">OCT Other</option>
																<option class="anc" value="<?php echo Image::RET_IMAGING ?>">Retina Imaging</option>
																<option class="anc" value="<?php echo Image::VISUAL_FIELDS ?>">Visual Fields</option>
																<option class="anc" value="<?php echo Image::AT_OTHERS ?>">Others</option>
																
																
																
																
																
																
																						
															</select>  
														</div>
													</div>
												</div>
												
											  <!-- Tags -->
												<div class="form-group">
													<label class="control-label col-lg-2" for="tags"><a style="color:#688a7e; font-weight:bold; width:100px;">Tags</a></label>
												
													<input id="tagsinput" name="<?php echo Image::HTML_TAGS; ?>" class="tagsinput" />		
												</div>
												
												
		
												<div class="form-group">
													<label for="exampleInputFile" class="col-sm-2 control-label"><a style="color:#688a7e; font-weight:bold">Photo</a></label>
													<div class="col-sm-10">
														<input type="file" name="<?php echo Image::HTML_FILE; ?>" class = 'btn btn-primary' >
													</div>
												</div>
											  
											  <!-- Buttons -->
												<div class="form-group">
												 <!-- Buttons -->
													<div class="col-lg-offset-2 col-lg-9">
														<input type="submit" class="btn btn-primary" style="font-weight:bold;" value = 'Submit' name = "<?php echo Image::HTML_SUBMITBUTTON; ?>" />
														<button type="reset" class="btn btn-default" onclick="reset();"><b>Reset</b></button>
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
							<a data-toggle="tab" href="#medhistory">
								<i class="icon-user"></i>
								Medical History
							</a>
						</li>
						<li>
							<a data-toggle="tab" href="#billings">
								<i class="icon-home"></i>
								Past Billings
							</a>
						</li>
						<li>
							<a data-toggle="tab" href="#clinicalordering">
								<i class="icon-user"></i>
								Past Clinical Orders
							</a>
						</li>
						
						<li>
							<a data-toggle="tab" href="#appointments">
								<i class="icon-user"></i>
								Appointments
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
												<th class='<?php echo (isset($healthcards[$i]) ? "success" : ""); ?>'><?php if (isset($healthcards[$i])) echo $healthcards[$i]->{HealthCard::CARD_NAME}; ?></th>
												<th><?php if (isset($healthcards[$i])) echo $healthcards[$i]->{HealthCard::CARD_NUMBER}; ?></th>
													
												<th class='<?php echo (isset($contacts[$i]) ? "success" : ""); ?>'><?php if (isset($contacts[$i])) echo $contacts[$i]->{EmergencyContact::CONTACT_NAME}; ?></th> 
										<th><?php if (isset($contacts[$i])) echo $contacts[$i]->{EmergencyContact::CONTACT_NUM}; ?></th>
													
											</tr>		
								<?php
										}	
								?>
										</tbody>
									</table>
								</section>
							</div>
						</div>
						
						<div id="medhistory" class="tab-pane">
							<div id="historylist" class="panel panel-primary">

				<?php 
					
						foreach ($visits as $visit)
						{

				?>
							<div class="panel panel-default">
								<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#historylist" href="#collapseHistory<?php echo $visit->visit_num; ?>">
										<div class = 'panel panel-info'>
										<div class = "panel-heading">
											<b><?php echo $visit->appoint_date; ?></b>
										</div>
										</div>
									</a>
								</h4>
									
								<div id="collapseHistory<?php echo $visit->visit_num; ?>" class="panel-collapse collapse">
									<div class="panel">
										<div class="panel-heading">
											<h2>EYE EXAMINATION</h2>	
										</div>
										<div class = "panel-body">
											<div class="panel-group m-bot20" id="accordion">
											
												<!--VA-->
												<div class="panel panel-default">				
													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseVA<?php echo $visit->visit_num; ?>">
															<div class = 'panel panel-info'>
															<div class = "panel-heading">
																<b>Visual Acuity</b>
															</div></div>
														</a>
													</h4>
													
										<?php 
											foreach ($eye_exam_va as $i)
											{
												if ($i->VISIT_NO == $visit->visit_num)
												{
										?>												
													<div id="collapseVA<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
														<div class="panel-body">
															<div class="col-lg-12">
																<table class="table table-bordered">
																	<tbody>																
																		<tr>
																			<th class = "active"></th>
																			<th class = "success"><center>RIGHT VA</center></th>
																			<th class = "warning"><center>LEFT VA</center></th>
																		</tr>
																		<tr>
																			<th>VA without correction</th>
																			<td><input name = 'va_NoCorrect_r' class="form-control" placeholder="Right VA without correction" value = "<?php echo $i->VA_OD_SC; ?>" disabled></td>
																			<td><input name = 'va_NoCorrect_l' class="form-control" placeholder="Left VA without correction" value = "<?php echo $i->VA_OS_SC; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>VA without correction with pinhole</th>
																			<td><input name = 'va_NoCorrect_pin_r' class="form-control" placeholder="Right VA w/o correction with pinhole" value = "<?php echo $i->VA_OD_SC_PH; ?>" disabled></td>
																			<td><input name = 'va_NoCorrect_pin_l' class="form-control" placeholder="Left VA w/o correction with pinhole" value = "<?php echo $i->VA_OS_SC_PH; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Best Correction</th>
																			<td><input name = 'BestCorrect_r' class="form-control" placeholder="Right VA best correction" value = "<?php echo $i->VA_OD_BESTCORRECTION; ?>" disabled></td>
																			<td><input name = 'BestCorrect_l' class="form-control" placeholder="Left VA best correction" value = "<?php echo $i->VA_OS_BESTCORRECTION; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Best Correction (distance)</th>
																			<td><input name = 'BestCorrect_dist_r' class="form-control" placeholder="Right VA best correction (distance)" value = "<?php echo $i->OD_BESTCORRECTION_DISTANCE; ?>" disabled></td>
																			<td><input name = 'BestCorrect_dist_l' class="form-control" placeholder="Left VA best correction (distance)" value = "<?php echo $i->OS_BESTCORRECTION_DISTANCE; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Best Correction (near)</th>
																			<td><input name = 'BestCorrect_near_r' class="form-control" placeholder="Right VA best correction (near)" value = "<?php echo $i->OD_BESTCORRECTION_NEAR; ?>" disabled></td>
																			<td><input name = 'BestCorrect_near_l' class="form-control" placeholder="Left VA best correction (near)" value = "<?php echo $i->OS_BESTCORRECTION_NEAR; ?>" disabled></td>
																		</tr>
																	</tbody>
																</table>
																
																<!--BOTH EYES TABLE -->
																<table class="table table-bordered">
																	<tbody>
																		<tr>
																			<th class="active"><center>Both Eyes VA</center></th>
																			<th class = "success"><center>Remarks</center></th>
																		</tr>
																		<tr>
																			<th>Forced Primary (Distance)</th>
																			<td><input name = 'ForcedPrimary_dist' class="form-control" placeholder="Forced Primary (Distance)" value = "<?php echo $i->VA_OU_DISTANCE_FORCED1; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Forced Primary (Near)</th>
																			<td><input name = 'ForcedPrimary_near' class="form-control" placeholder="Forced Primary (Near)" value = "<?php echo $i->VA_OU_FORCED1_NEAR; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Downgaze (Reading)</th>
																			<td><input name = 'va_downgaze' class="form-control" placeholder="Downgaze (Reading)" value = "<?php echo $i->VA_OU_DOWNGAZE_NEAR; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Anomalous Head Posture (Distance)</th>
																			<td><input name = 'ahp_dist' class="form-control" placeholder="Anomalous Head Posture (Distance)" value = "<?php echo $i->AHP_DISTANCE; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Anomalous Head Posture (Near)</th>
																			<td><input name = 'ahp_near' class="form-control" placeholder="Anomalous Head Posture (Near)" value = "<?php echo $i->AHP_NEAR; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>VA Anomalous Head Posture (Near)</th>
																			<td><input name = 'va_ou_ahp_near' class="form-control" placeholder="Anomalous Head Posture (Near)" value = "<?php echo $i->VA_OU_AHP_NEAR; ?>" disabled></td>
																		</tr>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
										<?php
												}
											}
										?>
												</div>
												<!--REFRACTION-->
												<div class="panel panel-default">													
													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseRefrac<?php echo $visit->visit_num; ?>">
															<div class = 'panel panel-info'>
															<div class = "panel-heading">
																<b>Refraction</b>
															</div></div>
														</a>
													</h4>
										<?php
											foreach ($eye_exam_refraction as $i)
											{
												if ($i->VISIT_NO == $visit->visit_num)
												{
										?>		
													<div id="collapseRefrac<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
														<div class="panel-body">
															<div class="col-lg-12">
																<table class="table table-bordered">
																	<tbody>															
																		<tr>
																			<th></th>
																			<th class = "success">RIGHT</th>
																			<th class = "warning">LEFT</th>
																		</tr>
																		<tr>
																			<th>Dry Autorefraction</th>
																			<td><input name = 'DryAutoRef_r' class="form-control" placeholder="Right Dry Autorefraction" value = "<?php echo $i->RIGHT_DRY_AUTOREFRACTION; ?>" disabled></td>
																			<td><input name = 'DryAutoRef_l' class="form-control" placeholder="Left Dry Autorefraction" value = "<?php echo $i->LEFT_DRY_AUTOREFRACTION; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Dry Objective Refraction</th>
																			<td><input name = 'ObjRef_r'  class="form-control" placeholder="Right Dry Objective Refraction" value = "<?php echo $i->RIGHT_DRY_OBJ_REFRACTION; ?>" disabled></td>
																			<td><input name = 'ObjRef_l'  class="form-control" placeholder="Left Dry Objective Refraction" value = "<?php echo $i->LEFT_DRY_OBJ_REFRACTION; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>VA with Objective Refraction</th>
																			<td><input name = 'va_ObjRef_r' class="form-control" placeholder="Right VA with Objective Refraction" value = "<?php echo $i->RIGHT_VA_OBJECTIVE; ?>" disabled></td>
																			<td><input name = 'va_ObjRef_l' class="form-control" placeholder="Left VA with Objective Refraction" value = "<?php echo $i->LEFT_VA_OBJECTIVE; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Manifest Refraction</th>
																			<td><input name = 'ManRef_r' class="form-control" placeholder="Right Manifest Refraction" value = "<?php echo $i->RIGHT_MANIFEST_REFRACTION; ?>" disabled></td>
																			<td><input name = 'ManRef_l' class="form-control" placeholder="Left Manifest Refraction" value = "<?php echo $i->LEFT_MANIFEST_REFRACTION; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>VA with Manifest Refraction</th>
																			<td><input name = 'va_ManRef_r' class="form-control" placeholder="Right VA with Manifest Refraction" value = "<?php echo $i->RIGHT_VA_MANIFEST; ?>" disabled></td>
																			<td><input name = 'va_ManRef_l' class="form-control" placeholder="Left VA with Manifest Refraction" value = "<?php echo $i->LEFT_VA_MANIFEST; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Cycloplegic Refraction</th>
																			<td><input name = 'CycloRef_r' class="form-control" placeholder="Right Cycloplegic Refraction" value = "<?php echo $i->RIGHT_CYCLO_REFRACTION; ?>" disabled></td>
																			<td><input name = 'CycloRef_l' class="form-control" placeholder="Left Cycloplegic Refraction" value = "<?php echo $i->LEFT_CYCLO_REFRACTION; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>VA with Cycloplegic Refraction</th>
																			<td><input name = 'va_CycloRef_r' class="form-control" placeholder="Right VA with Cycloplegic Refraction" value = "<?php echo $i->RIGHT_VA_CYCLO; ?>" disabled></td>
																			<td><input name = 'va_CycloRef_l' class="form-control" placeholder="Left VA with Cycloplegic Refraction" value = "<?php echo $i->LEFT_VA_CYCLO; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Cycloplegic Agent</th>
																			<td><input name = 'CycloAgent_r' class="form-control" placeholder="Right Cycloplegic Agent" value = "<?php echo $i->RIGHT_CYCLOPLEGIC; ?>" disabled></td>
																			<td><input name = 'CycloAgent_l' class="form-control" placeholder="Left Cycloplegic Agent" value = "<?php echo $i->LEFT_CYCLOPLEGIC; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Tolerated Refraction</th>
																			<td><input name = 'TolRef_r' class="form-control" placeholder="Right Tolerated Refraction" value = "<?php echo $i->RIGHT_TOLERATED_REFRACTION; ?>" disabled></td>
																			<td><input name = 'TolRef_l' class="form-control" placeholder="Left Tolerated Refraction" value = "<?php echo $i->LEFT_TOLERATED_REFRACTION; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>VA with Tolerated Refraction</th>
																			<td><input name = 'va_TolRef_r' class="form-control" placeholder="Right VA with Tolerated Refraction" value = "<?php echo $i->RIGHT_VA_TOLERATED; ?>" disabled></td>
																			<td><input name = 'va_TolRef_l' class="form-control" placeholder="Left VA with Tolerated Refraction" value = "<?php echo $i->LEFT_VA_TOLERATED; ?>" disabled></td>
																		</tr>
																		<tr>
																			<td colspan=3></td>
																		</tr>
																		<tr>
																			<th class = "success">Refraction Remarks</th>
																			<td colspan=2>
																			<input name = "ref_remarks" class = "form-control" rows = 1 maxlength = 100 style = "overflow:auto;resize:none" placeholder = 'Refraction Remarks' value="<?php echo $i->REFRACTION_REMARKS; ?>"disabled>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
										<?php
												}
											}
										?>
												</div>
												<!--PUPILS-->
												<div class="panel panel-default">												
													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapsePupil<?php echo $visit->visit_num; ?>">
															<div class = 'panel panel-info'>
															<div class = "panel-heading">
																<b>Pupils</b>
															</div></div>
														</a>
													</h4>
										<?php
											foreach ($eye_exam_pupils as $i)
											{
												if ($i->VISIT_NO == $visit->visit_num)
												{
										?>
													<div id="collapsePupil<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
														<div class="panel-body">
															<div class="col-lg-12">
																<table class="table table-bordered">
																	<tbody>
																		<tr>
																			<th class="active"><center>Pupil's General Information</center></th>
																			<th class = "success">RIGHT</th>
																			<th class = "warning">LEFT</th>
																		</tr>
																		<tr>
																			<th>Color</th>
																			<td><input name = 'PupilColor_r' class="form-control" placeholder="Right Pupil Color" value = "<?php echo $i->OD_PUPIL_COLOR; ?>" disabled></td>
																			<td><input name = 'PupilColor_l' class="form-control" placeholder="Left Pupil Color" value = "<?php echo $i->OS_PUPIL_COLOR; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Shape</th>
																			<td><input name = 'PupilShape_r'  class="form-control" placeholder="Right Pupil Shape" value = "<?php echo $i->OD_PUPIL_SHAPE; ?>" disabled></td>
																			<td><input name = 'PupilShape_l'  class="form-control" placeholder="Left Pupil Shape" value = "<?php echo $i->OS_PUPIL_SHAPE; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Size (ambient)</th>
																			<td><input name = 'PupilSize_amb_r' class="form-control" placeholder="Right Pupil Size (ambient)" value = "<?php echo $i->OD_PUPIL_SIZE_AMBIENT; ?>" disabled></td>
																			<td><input name = 'PupilSize_amb_l' class="form-control" placeholder="Left Pupil Size (ambient)" value = "<?php echo $i->OS_PUPIL_SIZE_AMBIENT; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Size (dark room)</th>
																			<td><input name = 'PupilSize_dark_r' class="form-control" placeholder="Right Pupil Size (dark room)" value = "<?php echo $i->OD_PUPIL_SIZE_DARK; ?>" disabled></td>
																			<td><input name = 'PupilSize_dark_l' class="form-control" placeholder="Left Pupil Size (dark room)" value = "<?php echo $i->OS_PUPIL_SIZE_DARK; ?>" disabled></td>
																		</tr>
																	</tbody>
																</table>
																
																<table class="table table-bordered">
																	<tbody>
																		<tr>
																			<th class="active"><center>Pupils Reactivity to Light</center></th>
																			<th class = "success">RIGHT</th>
																			<th class = "warning">LEFT</th>
																		</tr>
																		<tr>
																			<th>Reaction to light (ambient light)</th>
																			<td><input name = 'LightRxn_amb_r' class="form-control" placeholder="Right Reaction to Light (ambient)" value = "<?php echo $i->OD_PUPIL_RTL_AMBIENT; ?>" disabled></td>
																			<td><input name = 'LightRxn_amb_l' class="form-control" placeholder="Left Reaction to Light (ambient)" value = "<?php echo $i->OS_PUPIL_RTL_AMBIENT; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Reaction to light (dark room)</th>
																			<td><input name = 'LightRxn_dark_r' class="form-control" placeholder="Right Reaction to Light (dark room)" value = "<?php echo $i->OD_PUPIL_RTL_DARK; ?>" disabled></td>
																			<td><input name = 'LightRxn_dark_l' class="form-control" placeholder="Left Reaction to Light (dark room)" value = "<?php echo $i->OS_PUPIL_RTL_DARK; ?>" disabled></td>
																		</tr>
																	</tbody>
																</table>
																
																<table class="table table-bordered">
																	<tbody>
																		<tr>
																			<th class="active"></th>
																			<th class = "success">RIGHT</th>
																			<th class = "warning">LEFT</th>
																		</tr>
																		<tr>
																			<th>Relative Afferent Pupillary Defect</th>
																			<td><input name = 'relAPD_r' class="form-control" placeholder="Right Relative Afferent Pupillary Defect" value = "<?php echo $i->OD_RAPD; ?>" disabled></td>
																			<td><input name = 'relAPD_l' class="form-control" placeholder="Left Relative Afferent Pupillary Defect" value = "<?php echo $i->OS_RAPD; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Other Observation</th>
																			<td><input name = 'pupil_other_r' class="form-control" placeholder="Right Pupil (Other Observations)" value = "<?php echo $i->OD_PUPIL_OTHERS_1; ?>" disabled></td>
																			<td><input name = 'pupil_other_l' class="form-control" placeholder="Left Pupil (Other Observations)" value = "<?php echo $i->OS_PUPIL_OTHERS_2; ?>" disabled></td>
																		</tr>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
										<?php
												}
											}
										?>
												</div>
												<!--GROSS-->
												<div class="panel panel-default">											
													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseGross<?php echo $visit->visit_num; ?>">
															<div class = 'panel panel-info'>
															<div class = "panel-heading">
																<b>Gross</b>
															</div></div>
														</a>
													</h4>
										
										<?php					
											foreach ($eye_exam_gross as $i)
											{					
												if ($i->VISIT_NO == $visit->visit_num)
												{
										?>					
													<div id="collapseGross<?php echo $visit->visit_num; ?>" class="panel-collapse collapse collapse">
														<div class="panel-body">
															<div class="col-lg-12">
																<table class="table table-bordered">
																	<tbody>																		
																		<tr>
																			<th class = "active"></th>
																			<th class = "success"><center>RIGHT</center></th>
																			<th class = "warning"><center>LEFT</center></th>
																		</tr>
																		<tr>
																			<th>Eyebrows</th>
																			<td><input name = 'eyebrows_r' class="form-control" placeholder="Right Eyebrow" value = "<?php echo $i->RIGHT_EYEBROW; ?>" disabled></td>
																			<td><input name = 'eyebrows_l' class="form-control" placeholder="Left Eyebrow" value = "<?php echo $i->LEFT_EYEBROW; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Adnexae</th>
																			<td><input name = 'adnexae_r' class="form-control" placeholder="Right Adnexae" value = "<?php echo $i->RIGHT_ADNEXAE; ?>" disabled></td>
																			<td><input name = 'adnexae_l' class="form-control" placeholder="Left Adnexae" value = "<?php echo $i->LEFT_ADNEXAE; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Lid Fissure (vertical HT)</th>
																			<td><input name = 'lidFissure_r' class="form-control" placeholder="Right Lid Fissure (vertical HT)" value = "<?php echo $i->RIGHT_LIDFISSURE_HT; ?>" disabled></td>
																			<td><input name = 'lidFissure_l' class="form-control" placeholder="Left Lid Fissure (vertical HT)" value = "<?php echo $i->LEFT_LIDFISSURE_HT; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th class>Cornea Gross</th>
																			<td><input name = 'corneaGross_r' class="form-control" placeholder="Right Cornea (gross)" value = "<?php echo $i->RIGHT_CORNEA; ?>" disabled></td>
																			<td><input name = 'corneaGross_l' class="form-control" placeholder="Left Cornea (gross)" value = "<?php echo $i->LEFT_CORNEA; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th class>Sclera Gross</th>
																			<td><input name = 'scleraGross_r' class="form-control" placeholder="Right Sclera (gross)" value = "<?php echo $i->RIGHT_SCLERA; ?>" disabled></td>
																			<td><input name = 'scleraGross_l' class="form-control" placeholder="Left Sclera (gross)" value = "<?php echo $i->LEFT_SCLERA; ?>" disabled></td>
																		</tr>	
																		<tr>
																			<th>Photograph</th>
																			<td><input name = 'gross_img_r' class="form-control" placeholder="Right Photograph (gross)" value = "<?php echo $i->RIGHT_PHOTOGRAPH; ?>" disabled></td>
																			<td><input name = 'gross_img_l' class="form-control" placeholder="Left Photograph (gross)" value = "<?php echo $i->LEFT_PHOTOGRAPH; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Others</th>
																			<td><input name = 'gross_other_r' class="form-control" placeholder="Right Gross (others)" value = "<?php echo $i->RIGHT_OTHERS; ?>" disabled></td>
																			<td><input name = 'gross_other_l' class="form-control" placeholder="Left Gross (others)" value = "<?php echo $i->LEFT_OTHERS; ?>" disabled></td>
																		</tr>
																	</tbody>
																</table>																
															</div>
														</div>
													</div>
										<?php
												}
											}
										?>
												</div>
												<!--SLIT LAMP-->
												<div class="panel panel-default">													
													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseSlit<?php echo $visit->visit_num; ?>">
															<div class = 'panel panel-info'>
															<div class = "panel-heading">
																<b>Slit Lamp</b>
															</div></div>
														</a>
													</h4>
										<?php
											foreach ($eye_exam_slitlamp as $i)
											{
												if ($i->VISIT_NO == $visit->visit_num)
												{
										?>
													<div id="collapseSlit<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
														<div class="panel-body">
															<div class="col-lg-12">
																<table class="table table-bordered">
																	<tbody>																	
																	<tr>
																		<th></th>
																		<th class = "success">RIGHT</th>
																		<th class = "warning">LEFT</th>
																	</tr>
																	<tr>
																		<th>Lids Upper</th>
																		<td><input name = 'lidsUp_r' class="form-control" placeholder="Right Lids Upper" value = "<?php echo $i->RIGHT_LIDS_UPPER; ?>" disabled></td>
																		<td><input name = 'lidsUp_l' class="form-control" placeholder="Left Lids Upper" value = "<?php echo $i->LEFT_LIDS_UPPER; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th>Lids Lower</th>
																		<td><input name = 'lidsLow_r' class="form-control" placeholder="Right Lids Lower" value = "<?php echo $i->RIGHT_LIDS_LOWER; ?>" disabled></td>
																		<td><input name = 'lidsLow_l' class="form-control" placeholder="Left Lids Lower" value = "<?php echo $i->LEFT_LIDS_LOWER; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th>Conjunctiva (Palpebral)</th>
																		<td><input name = 'conj_palp_r' class="form-control" placeholder="Right Conjuctiva (Palpebral)" value = "<?php echo $i->RIGHT_CONJ_PALPEBRAL; ?>" disabled></td>
																		<td><input name = 'conj_palp_l' class="form-control" placeholder="Left Conjuctiva (Palpebral)" value = "<?php echo $i->LEFT_CONJ_PALPEBRAL; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th>Conjunctiva (Bulbar)</th>
																		<td><input name = 'conj_bulb_r' class="form-control" placeholder="Right Conjuctiva (Bulbar)" value = "<?php echo $i->RIGHT_CONJ_BULBAR; ?>" disabled></td>
																		<td><input name = 'conj_bulb_l' class="form-control" placeholder="Left Conjuctiva (Bulbar)" value = "<?php echo $i->LEFT_CONJ_BULBAR; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th>Sclera SL</th>
																		<td><input name = 'sl_sclera_r' class="form-control" placeholder="Right Sclera (slit lamp)" value = "<?php echo $i->RIGHT_SCLERA_SL; ?>" disabled></td>
																		<td><input name = 'sl_sclera_l' class="form-control" placeholder="Left Sclera (slit lamp)" value = "<?php echo $i->LEFT_SCLERA_SL; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th>Limbus</th>
																		<td><input name = 'limbus_r' class="form-control" placeholder="Right Limbus" value = "<?php echo $i->RIGHT_LIMBUS_SL; ?>" disabled></td>
																		<td><input name = 'limbus_l' class="form-control" placeholder="Left Limbus" value = "<?php echo $i->LEFT_LIMBUS_SL; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th>Cornea SL</th>
																		<td><input name = 'sl_cornea_r' class="form-control" placeholder="Right Cornea (slit lamp)" value = "<?php echo $i->RIGHT_CORNEA_SL; ?>" disabled></td>
																		<td><input name = 'sl_cornea_l' class="form-control" placeholder="Left Cornea (slit lamp)" value = "<?php echo $i->LEFT_CORNEA_SL; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th>Angles/Trabecular Meshwork</th>
																		<td><input name = 'AnglesMesh_r' class="form-control" placeholder="Right Angles/Trabecular Meshwork" value = "<?php echo $i->RIGHT_ANGLES_TM; ?>" disabled></td>
																		<td><input name = 'AnglesMesh_l' class="form-control" placeholder="Left Angles/Trabecular Meshwork" value = "<?php echo $i->LEFT_ANGLES_TM; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th>Anterior Chamber</th>
																		<td><input name = 'anterior_r' class="form-control" placeholder="Right Anterior Chamber" value = "<?php echo $i->RIGHT_AC; ?>" disabled></td>
																		<td><input name = 'anterior_l' class="form-control" placeholder="Left Anterior Chamber" value = "<?php echo $i->LEFT_AC; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th>Iris</th>
																		<td><input name = 'iris_r' class="form-control" placeholder="Right Iris" value = "<?php echo $i->RIGHT_IRIS_SL; ?>" disabled></td>
																		<td><input name = 'iris_l' class="form-control" placeholder="Left Iris" value = "<?php echo $i->LEFT_IRIS_SL; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th>Lens</th>
																		<td><input name = 'lens_r' class="form-control" placeholder="Right Lens" value = "<?php echo $i->RIGHT_LENS_SL; ?>" disabled></td>
																		<td><input name = 'lens_l' class="form-control" placeholder="Left Lens" value = "<?php echo $i->LEFT_LENS_SL; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th>Vitreous (SL)</th>
																		<td><input name = 'sl_vitreous_r' class="form-control" placeholder="Right Vitreous (slit lamp)" value = "<?php echo $i->RIGHT_VITREOUS_SL; ?>" disabled></td>
																		<td><input name = 'sl_vitreous_l' class="form-control" placeholder="Left Vitreous (slit lamp)" value = "<?php echo $i->LEFT_VITREOUS_SL; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th>Nerve (SL)</th>
																		<td><input name = 'sl_nerve_r' class="form-control" placeholder="Right Nerve (slit lamp)" value = "<?php echo $i->RIGHT_OPTIC_NERVE_SL; ?>" disabled></td>
																		<td><input name = 'sl_nerve_l' class="form-control" placeholder="Left Nerve (slit lamp)" value = "<?php echo $i->LEFT_OPTIC_NERVE_SL; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th>Retinal arcade/vessels (SL)</th>
																		<td><input name = 'sl_retinal_r' class="form-control" placeholder="Right Retinal Arcade/Vessels (slit lamp)" value = "<?php echo $i->RIGHT_RETINAL_ARCADE_VESSELS_SL; ?>" disabled></td>
																		<td><input name = 'sl_retinal_l' class="form-control" placeholder="Left Retinal Arcade/Vessels (slit lamp)" value = "<?php echo $i->LEFT_RETINAL_ARCADE_VESSELS_SL; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th>Macula (SL)</th>
																		<td><input name = 'sl_macula_r' class="form-control" placeholder="Right Macula (slit lamp)" value = "<?php echo $i->RIGHT_MACULA_SL; ?>" disabled></td>
																		<td><input name = 'sl_macula_l' class="form-control" placeholder="Left Macula (slit lamp)" value = "<?php echo $i->LEFT_MACULA_SL; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th>Posterior Pole Others (SL)</th>
																		<td><input name = 'sl_posterior_r' class="form-control" placeholder="Right Posterior Pole (slit lamp)" value = "<?php echo $i->RIGHT_POSTERIOR_OTHERS; ?>" disabled></td>
																		<td><input name = 'sl_posterior_l' class="form-control" placeholder="Left Posterior Pole (slit lamp)" value = "<?php echo $i->LEFT_POSTERIOR_OTHERS; ?>" disabled></td>
																	</tr>
																	</tbody>
																</table>											
															</div>
														</div>
													</div>
										<?php
												}
											}
										?>
				
												</div>
												<!-- STRABISMUS-->
												<div class="panel panel-default">
													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseStrab<?php echo $visit->visit_num; ?>">
															<div class = 'panel panel-info'>
															<div class = "panel-heading">
																<b>Strabismus</b>
															</div></div>
														</a>
													</h4>										
										
													<div id="collapseStrab<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
														<div class="panel-body">
															<div class = "col-lg-12">
																<div class="panel-group m-bot20" id="accordion3">
																<!--STRABDUC-->
																<div class="panel panel-default">																	
																	<h4 class="panel-title">
																		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseStrabDuc<?php echo $visit->visit_num; ?>">
																			<div class = 'panel panel-info'>
																			<div class = "panel-heading">
																				<b>Duction</b>
																			</div></div>
																		</a>
																	</h4>
														<?php
															foreach ($eye_exam_strab_duction as $i)
															{
																if ($i->VISIT_NO == $visit->visit_num)
																{
														?>  
																	<div id="collapseStrabDuc<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
																		<div class="panel-body">
																			<div class = "col-lg-12">
																				<table class="table table-bordered">
																					<tbody>																						
																						<tr>
																							<th></th>
																							<th class = "success"><center>RIGHT</center></th>
																							<th class = "warning"><center>LEFT</center></th>
																						</tr>
																						<tr>
																							<th>MR (Primary)</th>
																							<td><input name = 'mr_add_r' class="form-control" placeholder="Right MR (primary)" value = "<?php echo $i->RMR_ADDUCTION; ?>" disabled></td>
																							<td><input name = 'mr_add_l' class="form-control" placeholder="Left MR (primary)" value = "<?php echo $i->LMR_ADDUCTION; ?>" disabled></td>
																						</tr>
																						<tr>
																							<th>LR (Primary)</th>
																							<td><input name = 'lr_abd_r' class="form-control" placeholder="Right LR (primary)" value = "<?php echo $i->RLR_ABDUCTION; ?>" disabled></td>
																							<td><input name = 'lr_abd_l' class="form-control" placeholder="Left LR (primary)" value = "<?php echo $i->LLR_ABDUCTION; ?>" disabled></td>
																						</tr>
																						<!-- IR -->
																						<tr>
																							<td colspan = 3 ></td>
																						</tr>
																						<tr>
																							<th class="active"><center>IR</center></th>
																							<th class = "success"><center>RIGHT</center></th>
																							<th class = "warning"><center>LEFT</center></th>
																						</tr>
																						<tr>
																							<th>Depression</th>
																							<td><input name = 'ir_dep_r' class="form-control" placeholder="Right IR (depression)" value = "<?php echo $i->RIR_DEPRESSION; ?>" disabled></td>
																							<td><input name = 'ir_dep_l' class="form-control" placeholder="Left IR (depression)" value = "<?php echo $i->LIR_DEPRESSION; ?>" disabled></td>
																						</tr>
																						<tr>
																							<th>Adduction</th>
																							<td><input name = 'ir_add_r' class="form-control" placeholder="Right IR (abduction)" value = "<?php echo $i->RIR_ADDUCTION; ?>" disabled></td>
																							<td><input name = 'ir_add_l' class="form-control" placeholder="Left IR (depression)" value = "<?php echo $i->LIR_ADDUCTION; ?>" disabled></td>
																						</tr>
																						<tr>
																							<th>Excyclotorsion</th>
																							<td><input name = 'ir_excyc_r' class="form-control" placeholder="Right IR (excyclotorsion)" value = "<?php echo $i->RIR_EXCYCLO; ?>" disabled></td>
																							<td><input name = 'ir_excyc_l' class="form-control" placeholder="Left IR (excyclotorsion)" value = "<?php echo $i->LIR_EXCYCLO; ?>" disabled></td>
																						</tr>
																						
																						<!-- IO -->
																						<tr>
																							<td colspan = 3 ></td>
																						</tr>
																						<tr>
																							<th class="active"><center>IO</center></th>
																							<th class = "success"><center>RIGHT</center></th>
																							<th class = "warning"><center>LEFT</center></th>
																						</tr>
																						<tr>
																							<th>Excyclotorsion</th>
																							<td><input name = 'io_excyc_r' class="form-control" placeholder="Right IO (excyclotorsion)" value = "<?php echo $i->RIO_EXCYCLO; ?>" disabled></td>
																							<td><input name = 'io_excyc_l' class="form-control" placeholder="Left IO (excyclotorsion)" value = "<?php echo $i->LIO_EXCYCLO; ?>" disabled></td>
																						</tr>
																						<tr>
																							<th>Upgaze</th>
																							<td><input name = 'io_upgaze_r' class="form-control" placeholder="Right IO (upgaze)" value = "<?php echo $i->RIO_UPGAZE; ?>" disabled></td>
																							<td><input name = 'io_upgaze_l' class="form-control" placeholder="Left IO (upgaze)" value = "<?php echo $i->LIO_UPGAZE; ?>" disabled></td>
																						</tr>
																						<tr>
																							<th>Abduction</th>
																							<td><input name = 'io_abd_r' class="form-control" placeholder="Right IO (abduction)" value = "<?php echo $i->RIO_ABDUCTION; ?>" disabled></td>
																							<td><input name = 'io_abd_l' class="form-control" placeholder="Left IO (abduction)" value = "<?php echo $i->LIO_ABDUCTION; ?>" disabled></td>
																						</tr>
																						<!-- SR -->
																						<tr>
																							<td colspan = 3></td>
																						</tr>
																						<tr>
																							<th class="active"><center>SR</center></th>
																							<th class = "success"><center>RIGHT</center></th>
																							<th class = "warning"><center>LEFT</center></th>
																						</tr>
																						<tr>
																							<th>Upgaze</th>
																							<td><input name = 'sr_upgaze_r' class="form-control" placeholder="Right SR (upgaze)" value = "<?php echo $i->RSR_UPGAZE; ?>" disabled></td>
																							<td><input name = 'sr_upgaze_l' class="form-control" placeholder="Left SR (upgaze)" value = "<?php echo $i->LSR_UPGAZE; ?>" disabled></td>
																						</tr>
																						<tr>
																							<th>Adduction</th>
																							<td><input name = 'sr_add_r' class="form-control" placeholder="Right SR (abduction)" value = "<?php echo $i->RSR_ADDUCTION; ?>" disabled></td>
																							<td><input name = 'sr_add_l' class="form-control" placeholder="Left SR (abduction)" value = "<?php echo $i->LSR_ADDUCTION; ?>" disabled></td>
																						</tr>
																						<tr>
																							<th>Incyclotorsion</th>
																							<td><input name = 'sr_incyc_r' class="form-control" placeholder="Right SR (incyclotorsion)" value = "<?php echo $i->RSR_INCYCLO; ?>" disabled></td>
																							<td><input name = 'sr_incyc_l' class="form-control" placeholder="Left SR (incyclotorsion)" value = "<?php echo $i->LSR_INCYCLO; ?>" disabled></td>
																						</tr>
																						<!-- SO -->
																						<tr>
																							<td colspan = 3></td>
																						</tr>
																						<tr>
																							<th class="active"><center>SO</center></th>
																							<th class = "success"><center>RIGHT</center></th>
																							<th class = "warning"><center>LEFT</center></th>
																						</tr>
																						<tr>
																							<th>Incyclotorsion</th>
																							<td><input name = 'so_incyc_r' class="form-control" placeholder="Right SO (intorsion)" value = "<?php echo $i->RSO_INCYCLO; ?>" disabled></td>
																							<td><input name = 'so_incyc_l' class="form-control" placeholder="Left SO (intorsion)" value = "<?php echo $i->LSO_INCYCLO; ?>" disabled></td>
																						</tr>
																						<tr>
																							<th>Downgaze</th>
																							<td><input name = 'so_downgaze_r' class="form-control" placeholder="Right SO (downgaze)" value = "<?php echo $i->RSO_DOWNGAZE; ?>" disabled></td>
																							<td><input name = 'so_downgaze_l' class="form-control" placeholder="Left SO (downgaze)" value = "<?php echo $i->LSO_DOWNGAZE; ?>" disabled></td>
																						</tr>
																						<tr>
																							<th>Abduction</th>
																							<td><input name = 'so_abd_r' class="form-control" placeholder="Right SO (abduction)" value = "<?php echo $i->RSO_ABDUCT; ?>" disabled></td>
																							<td><input name = 'so_abd_l' class="form-control" placeholder="Left SO (abduction)" value = "<?php echo $i->LSO_ABDUCT; ?>" disabled></td>
																						</tr>
																					</tbody>
																				</table>
																			</div>
																		</div>
																	</div>
														<?php
															}
														}
														?>
																</div>
																<!--STRABFUSAMP-->
																<div class="panel panel-default">												
																	<h4 class="panel-title">
																		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseStrabFusAmp<?php echo $visit->visit_num; ?>">
																			<div class = 'panel panel-info'>
																			<div class = "panel-heading">
																				<b>Fusional Amplitude</b>
																			</div></div>
																		</a>
																	</h4>
														
														<?php
															foreach ($eye_exam_strab_fusional_amplitudes as $i)
															{
																if ($i->VISIT_NO == $visit->visit_num)
																{
														?>  
																	<div id="collapseStrabFusAmp<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
																		<div class="panel-body">
																		   <div class="col-lg-12">
																				<table class="table table-bordered">
																					<tbody>																					
																					<tr>
																						<th>Divergence Distance (Base In)</th>
																						<td><input name = 'div_dist' class="form-control" placeholder = "Divergence Distance (Base In)" value =  "<?php echo $i->DIVERGENCE_DIST_BI; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>Convergence Distance (Base Out)</th>
																						<td><input name = 'conv_dist' class="form-control" placeholder = "Convergence Distance (Base Out)" value =  "<?php echo $i->CONVERGENCE_DIST_BO; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>Sursumvergence (Base Up)</th>
																						<td><input name = 'sursumverge' class="form-control" placeholder = "Sursumvergence (Base Up)" value = "<?php echo $i->SURSUMVERGENCE; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>Cyclovergence (Extorsion)</th>
																						<td><input name = 'cyclover_ext' class="form-control" placeholder = "Cyclovergence (Extorsion)" value =  "<?php echo $i->CYCLOVERGENCE_EXTORTION; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>Divergence Near (Base In)</th>
																						<td><input name = 'div_near' class="form-control" placeholder = "Divergence Near (Base In)" value = "<?php echo $i->DIVERGENCE_NEAR_BI; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>Convergence Near (Base Out)</th>
																						<td><input name = 'conv_near' class="form-control" placeholder = "Convergence Near (Base Out)" value = "<?php echo $i->CONVERGENCE_NEAR_BO; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>Deosursumvergence (Base Down)</th>
																						<td><input name = 'deosursumverge' class="form-control" placeholder = "Deosursumvergence (Base Down)" value = "<?php echo $i->DEOSURSUMVERGENCE; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>Cyclovergence (Intorsion)</th>
																						<td><input name = 'cyclover_int' class="form-control" placeholder = "Cyclovergence (Intorsion)" value =  "<?php echo $i->CYCLOVERGENCE_INTORSION; ?>" disabled></td>
																					</tr>
																					</tbody>
																				</table>
																			</div>
																		</div>
																	</div>
														<?php
																}
															}
														?>  
																</div>
																<!--STRABMEA-->
																<div class="panel panel-default">															
																	<h4 class="panel-title">
																		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseStrabMea<?php echo $visit->visit_num; ?>">
																			<div class = 'panel panel-info'>
																			<div class = "panel-heading">
																				<b>Measurements</b>
																			</div></div>
																		</a>
																	</h4>
														
														<?php
															foreach ($eye_exam_strab_measurements as $i)
															{
																if ($i->VISIT_NO == $visit->visit_num)
																{
														?>  
																	<div id="collapseStrabMea<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
																		<div class="panel-body">
																		   <div class="col-lg-12">
																				<table class="table table-bordered">
																				<tbody>																					
																					<tr>
																						<th></th>
																						<th class = "success"><center> Remarks </center></th>
																					</tr>
																					<tr>
																						<th>1 Version (Up and Right)</th>
																						<td><input name = 'strabM1' class="form-control" placeholder="1 Version (Up and Right)" value = "<?php $a = "1_STRAB_UP&R"; echo $i->$a; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>2 Version (Straight Up)</th>
																						<td><input name = 'strabM2' class="form-control" placeholder="2 Version (Straight Up)" value = "<?php $a = "2_STRAB_UP"; echo $i->$a; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>3 Version (Up and Left)</th>
																						<td><input name = 'strabM3' class="form-control" placeholder="3 Version (Up and Left)" value = "<?php $a = "3_STRAB_UP&L"; echo $i->$a; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>4 Version (Right)</th>
																						<td><input name = 'strabM4' class="form-control" placeholder="4 Version (Right)" value = "<?php $a = "4_STRAB_R"; echo $i->$a; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>5 Version (Straight)</th>
																						<td><input name = 'strabM5' class="form-control" placeholder="5 Version (Straight)" value = "<?php $a = "5_STRAB_STRAIGHT"; echo $i->$a; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>6 Version (Left)</th>
																						<td><input name = 'strabM6' class="form-control" placeholder="6 Version (Left)" value = "<?php $a = "6_STRAB_L"; echo $i->$a; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>7 Version (Down and Right)</th>
																						<td><input name = 'strabM7' class="form-control" placeholder="7 Version (Down and Right)" value = "<?php $a = "7_STRAB_DOWN&R"; echo $i->$a; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>8 Version (Straight Down)</th>
																						<td><input name = 'strabM8' class="form-control" placeholder="8 Version (Straight Down)" value = "<?php $a = "8_STRAB_DOWN"; echo $i->$a; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>9 Version (Down and Left)</th>
																						<td><input name = 'strabM9' class="form-control" placeholder="9 Version (Down and Left)" value = "<?php $a = "9_STRAB_DOWN&L"; echo $i->$a; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>Right Tilt</th>
																						<td><input name = 'Mtilt_r' class="form-control" placeholder="Right Tilt" value = "<?php echo $i->STRAB_MEAST_RIGHT_TILT; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>Left Tilt</th>
																						<td><input name = 'Mtilt_l' class="form-control" placeholder="Left Tilt" value = "<?php echo $i->STRAB_MEAST_LEFT_TILT; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>Strabismus Measurement in AHP (distance)</th>
																						<td><input name = 'strabM_ahp_dist' class="form-control" placeholder="Strabismus Measurement in AHP (distance)" value = "<?php echo $i->STRAB_MEAST_AHP_DISTANCE; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>Strabismus Measurement Primary Distance</th>
																						<td><input name = 'strabM_primaryDist' class="form-control" placeholder="Strabismus Measurement Forced" value = "<?php echo $i->STRAB_MEAST_DISTANCE_PRIMARY; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>Strabismus Measurement in AHP (near)</th>
																						<td><input name = 'strabM_ahp_near' class="form-control" placeholder="Strabismus Measurement in AHP (near)" value = "<?php echo $i->STRAB_MEAST_AHP_NEAR; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>Strabismus Measurement Primary Near</th>
																						<td><input name = 'strabM_primaryNear' class="form-control" placeholder="Strabismus Measurement Primary Gaze" value = "<?php echo $i->STRAB_MEAST_NEAR_PRIMARY; ?>" disabled></td>
																					</tr>
																					<tr>
																						<th>Strabismus Measurement Downgaze Near</th>
																						<td><input name = 'strabM_downgazeNear' class="form-control" placeholder="Strabismus Measurement Downgaze Near" value = "<?php echo $i->STRAB_MEAST_NEAR_DOWNGAZE; ?>" disabled></td>
																					</tr>
																					<tr>
																						<td colspan=3></td>
																					</tr>
																					</tbody>
																				</table>
																			</div>
																		</div>
																	</div>
														<?php
																}
															}
														?> 
																</div>
																<!--STRABVer-->
																<div class="panel panel-default">																
																	<h4 class="panel-title">
																		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseStrabVer<?php echo $visit->visit_num; ?>">
																			<div class = 'panel panel-info'>
																			<div class = "panel-heading">
																				<b>Version</b>
																			</div></div>
																		</a>
																	</h4>
																	
														<?php
															foreach ($eye_exam_strab_version as $i)
															{
																if ($i->VISIT_NO == $visit->visit_num)
																{
														?>  													
																	<div id="collapseStrabVer<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
																		<div class="panel-body">
																		   <div class="col-lg-12">
																				<table class="table table-bordered" colspan = "5">
																					<tbody>																
																					<tr>
																						<th></th>
																						<th class = "success" colspan = 4><center> Remarks </center></th>
																					</tr>
																					<tr>
																						<th>Near Point of Convergence</th>
																						<td colspan = 2><input name = 'nearPOC' class="form-control" placeholder="Near Point of Convergence" value = "<?php echo $i->NEAR_POINT_CONVERGENCE; ?>" disabled></td>
																					</tr>													
																					</tbody>
																				</table>																		
																			</div>
																		</div>
																	</div>
														<?php
																}
															}
														?> 
																</div>
																</div>
															</div>
														</div>
													</div><!--END COLLAPSE STRAB-->
												</div>
												
												<!--STEREO-->
												<div class="panel panel-default">
													<form class="form-horizontal" method='post' >
													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseStereo<?php echo $visit->visit_num; ?>">
															<div class = 'panel panel-info'>
															<div class = "panel-heading">
																<b>Stereoacuity</b>
															</div></div>
														</a>
													</h4>
										<?php
											foreach ($eye_exam_stereoacuity as $i)
											{
												if ($i->VISIT_NO == $visit->visit_num)
												{
										?>  	
													<div id="collapseStereo<?php echo $visit->visit_num; ?>" class="panel-collapse collapse collapse">
														<div class="panel-body">
														   <div class="col-lg-12">
																<table class="table table-bordered">
																	<tbody>																	
																	<tr>
																		<th class = "success">Distance Stereo Test</th>
																		<td class = "success"><input name = 'stereo_dist_test' class="form-control" placeholder = "Stereo Distance Test" value = "<?php echo $i->STEREO_DIST_USED; ?>" disabled></td>

																		<th class = "success">Result Distance</th>
																		<td class = "success"><input name = 'stereo_dist_result' class="form-control" placeholder = "Distance Test Result" value = "<?php echo $i->STEREO_DIST_RESULT; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th class = "warning">Near Stereo Test</th>
																		<td class = "warning"><input name = 'stereo_near_test' class="form-control" placeholder = "Stereo Near Test" value = "<?php echo $i->STEREO_NEAR_TEST; ?>" disabled></td>
																		<th class = "warning">
																		Result Near Stereo</th>
																		<td class = "warning">
																		<input name = 'stereo_near_result' class="form-control" placeholder = "Near Test Result" value = "<?php echo $i->STEREO_NEAR_RESULT; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th class = "">Stereoacuity</th>
																		<td colspan = 3><input name = "stereoacuity" class = "form-control" rows = 1 maxlength = 500  style = "overflow:auto;resize:none" placeholder = 'Stereoacuity' value="<?php echo $i->INTERPRETATION; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th class = "success">Remarks</th>
																		<td colspan = 3>
																		<input name = "stereo_remarks" class = "form-control" rows = 1 maxlength = 100  style = "overflow:auto;resize:none" placeholder = 'Stereo Remarks' value="<?php echo $i->STEREO_REMARKS; ?>" disabled>
																		</td>
																	</tr>
																	</tbody>
																</table>
															 </div>
														</div>
													</div>
											
										<?php
												}
											}
										?> 
												</div>
												<!--POSTPOLE-->
												<div class="panel panel-default">											
													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapsePostPole<?php echo $visit->visit_num; ?>">
															<div class = 'panel panel-info'>
															<div class = "panel-heading">
																<b>Posterior Pole</b>
															</div></div>
														</a>
													</h4>
													
										<?php
											foreach ($eye_exam_posterior as $i)
											{
												if ($i->VISIT_NO == $visit->visit_num)
												{
										?>  
													<div id="collapsePostPole<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
														<div class="panel-body">
														   <div class="col-lg-12">
																<table class="table table-bordered">
																	<tbody>																	
																	<tr>
																		<th class = "success">Instrument</th>
																		<td colspan=2><input name = 'PostPoleInstrument' class="form-control" placeholder = "Posterior Pole Instrument" value = "<?php echo $i->EYE_EXAM_POSTERIOR_INSTRUMENT; ?>" disabled></td>
																	</tr>
																	</tbody>
																</table>
																
																<table class="table table-bordered">
																	<tbody>
																		<tr>
																			<th class="active"><center>Zone 1</center></th>
																			<th class = "success">RIGHT</th>
																			<th class = "warning">LEFT</th>
																		</tr>
																		<tr>
																			<th>Optic Nerve</th>
																			<td><input name = 'zone1_optic_r' class="form-control" placeholder="Right Zone 1 Optic Nerve" value = "<?php echo $i->RIGHT_Z1_OPTICNERVE; ?>" disabled></td>
																			<td><input name = 'zone1_optic_l' class="form-control" placeholder="Left Zone 1 Optic Nerve" value = "<?php echo $i->LEFT_Z1_OPTICNERVE; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Retinal Arcade</th>
																			<td><input name = 'zone1_retinal_r' class="form-control" placeholder="Right Zone 1 Retinal Arcade" value = "<?php echo $i->RIGHT_Z1_RETINAL_ARCADE_VESSELS; ?>" disabled></td>
																			<td><input name = 'zone1_retinal_l' class="form-control" placeholder="Left Zone 1 Retinal Arcade" value = "<?php echo $i->LEFT_Z1_RETINAL_ARCADE_VESSELS; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Macula</th>
																			<td><input name = 'zone1_macula_r' class="form-control" placeholder="Right Zone 1 Macula" value = "<?php echo $i->RIGHT_Z1_MACULA; ?>" disabled></td>
																			<td><input name = 'zone1_macula_l' class="form-control" placeholder="Left Zone 1 Macula" value = "<?php echo $i->LEFT_Z1_MACULA; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Vitreous</th>
																			<td><input name = 'zone1_vitreous_r' class="form-control" placeholder="Right Zone 1 Vitreous" value = "<?php echo $i->RIGHT_Z1_VITREOUS; ?>" disabled></td>
																			<td><input name = 'zone1_vitreous_l' class="form-control" placeholder="Left Zone 1 Vitreous" value = "<?php echo $i->LEFT_Z1_VITREOUS; ?>" disabled></td>
																		</tr>
																	</tbody>
																</table>
																
																<table class="table table-bordered">
																	<tbody>
																		<tr>
																			<th class="active"><center>Zone 2</center></th>
																			<th class = "success">RIGHT</th>
																			<th class = "warning">LEFT</th>
																		</tr>
																		<tr>
																			<th>Branching</th>
																			<td><input name = 'zone2_branch_r' class="form-control" placeholder="Right Zone 2 Branching" value = "<?php echo $i->RIGHT_Z2_BRANCHING; ?>" disabled></td>
																			<td><input name = 'zone2_branch_l' class="form-control" placeholder="Left Zone 2 Branching" value = "<?php echo $i->LEFT_Z2_BRANCHING; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Artery</th>
																			<td><input name = 'zone2_artery_r' class="form-control" placeholder="Right Zone 2 Artery" value = "<?php echo $i->RIGHT_Z2_ARTERIES; ?>" disabled></td>
																			<td><input name = 'zone2_artery_l' class="form-control" placeholder="Left Zone 2 Artery" value = "<?php echo $i->LEFT_Z2_ARTERIES; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Veins</th>
																			<td><input name = 'zone2_veins_r' class="form-control" placeholder="Right Zone 2 Veins" value = "<?php echo $i->RIGHT_Z2_VEINS; ?>" disabled></td>
																			<td><input name = 'zone2_veins_l' class="form-control" placeholder="Left Zone 2 Veins" value = "<?php echo $i->LEFT_Z2_VEINS; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Vortex Veins</th>
																			<td><input name = 'zone2_vortex_r' class="form-control" placeholder="Right Zone 2 Vortex Veins" value = "<?php echo $i->RIGHT_Z2_VORTEX; ?>" disabled></td>
																			<td><input name = 'zone2_vortex_l' class="form-control" placeholder="Left Zone 2 Vortex Veins" value = "<?php echo $i->LEFT_Z2_VORTEX; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Vitreous</th>
																			<td><input name = 'zone2_vitreous_r' class="form-control" placeholder="Right Zone 2 Vitreous" value = "<?php echo $i->RIGHT_Z2_VITREOUS; ?>" disabled></td>
																			<td><input name = 'zone2_vitreous_l' class="form-control" placeholder="Left Zone 2 Vitreous" value = "<?php echo $i->LEFT_Z2_VITREOUS; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Retinal Arcade</th>
																			<td><input name = 'zone2_retinal_r' class="form-control" placeholder="Right Zone 2 Retinal Arcade" value = "<?php echo $i->RIGHT_Z2_RETINAL_ARCADE_VESSELS; ?>" disabled></td>
																			<td><input name = 'zone2_retinal_l' class="form-control" placeholder="Left Zone 2 Retinal Arcade" value = "<?php echo $i->LEFT_Z2_RETINAL_ARCADE_VESSELS; ?>" disabled></td>
																		</tr>
																	</tbody>
																</table>
																
																<table class="table table-bordered">
																	<tbody>
																		<tr>
																			<th class="active"><center>Zone 3</center></th>
																			<th class = "success">RIGHT</th>
																			<th class = "warning">LEFT</th>
																		</tr>
																		<tr>
																			<th>Retina</th>
																			<td><input name = 'zone3_retina_r' class="form-control" placeholder="Right Zone 3 Retina" value = "<?php echo $i->RIGHT_Z3_RETINA; ?>" disabled></td>
																			<td><input name = 'zone3_retina_l' class="form-control" placeholder="Left Zone 3 Retina" value = "<?php echo $i->LEFT_Z3_RETINA; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Vessels</th>
																			<td><input name = 'zone3_vessels_r' class="form-control" placeholder="Right Zone 3 Vessels" value = "<?php echo $i->RIGHT_Z3_VESSELS; ?>" disabled></td>
																			<td><input name = 'zone3_vessels_l' class="form-control" placeholder="Left Zone 3 Vessels" value = "<?php echo $i->LEFT_Z3_VESSELS; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Vitreous</th>
																			<td><input name = 'zone3_vitreous_r' class="form-control" placeholder="Right Zone 3 Vitreous" value = "<?php echo $i->RIGHT_Z3_VITREOUS; ?>" disabled></td>
																			<td><input name = 'zone3_vitreous_l' class="form-control" placeholder="Left Zone 3 Vitreous" value = "<?php echo $i->LEFT_Z3_VITREOUS; ?>" disabled></td>
																		</tr>
																	</tbody>
																</table>
																
																<table class="table table-bordered">
																	<tbody>
																		<tr>
																			<th class="active"></th>
																			<th class = "success">RIGHT</th>
																			<th class = "warning">LEFT</th>
																		</tr>
																		<tr>
																			<th>Other Posterior Findings</th>
																			<td><input name = 'PostPole_other_r' class="form-control" placeholder="Right Posterior Other Findings" value = "<?php echo $i->RIGHT_OTHER_POSTERIOR; ?>" disabled></td>
																			<td><input name = 'PostPole_other_l' class="form-control" placeholder="Left Posterior Other Findings" value = "<?php echo $i->LEFT_OTHER_POSTERIOR; ?>" disabled></td>
																		</tr>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
														
										<?php
												}
											}
										?> 
												</div>
											</div><!--END COLLAPSE EYE EXAM GROUP-->
										</div>
									</div>
									<!--BEGIN COLLAPSE ANCILLARY TEST GROUP-->
									<div class="panel">
											<header class="panel-heading">
												<h2 class="">ANCILLARY TEST</h2>
											</header>
											<div class = "panel-body">
											<div class="panel-group m-bot20" id="accordion">
												<!--IOP-->
												<div class="panel panel-default">

													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseIntraPre<?php echo $visit->visit_num; ?>">
															<div class = 'panel panel-info'>
															<div class = "panel-heading">
																<b>Intraocular Pressure</b>
															</div></div>
														</a>
													</h4>
										<?php
											foreach ($ancillary_iop as $i)
											{
												if ($i->VISIT_NO == $visit->visit_num)
												{
										?>  
													<div id="collapseIntraPre<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
														<div class="panel-body">
															<div class="col-lg-12">
																<table class="table table-bordered">
																	<tbody>																		
																		<tr>
																			<th></th>
																			<th class = "success">RIGHT</th>
																			<th class = "warning">LEFT</th>
																		</tr>
																		<tr>
																			<th>Finger Palpation</th>
																			<td><input type="text" name = 'FingerPalp_r' class="form-control" placeholder="Right Finger Palpation" value = "<?php echo $i->RIGHT_PALPATION; ?>" disabled></td>
																			<td><input type="text" name = 'FingerPalp_l' class="form-control" placeholder="Left Finger Palpation" value = "<?php echo $i->LEFT_PALPATION; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>IOP (Perkins)</th>
																			<td><input name = 'iop_Perkins_r' class="form-control" placeholder="Right IOP (Perkins)" value = "<?php echo $i->RIGHT_IOP_PERKINS; ?>" disabled></td>
																			<td><input name = 'iop_Perkins_l' class="form-control" placeholder="Left IOP (Perkins)" value = "<?php echo $i->LEFT_IOP_PERKINS; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>IOP (Icare)</th>
																			<td><input name = 'iop_Icare_r' class="form-control" placeholder="Right IOP (Icare)" value = "<?php echo $i->RIGHT_IOP_ICARE; ?>" disabled></td>
																			<td><input name = 'iop_Icare_l' class="form-control" placeholder="Left IOP (Icare)" value = "<?php echo $i->LEFT_IOP_ICARE; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>IOP (Goldmann)</th>
																			<td><input name = 'iop_Goldmann_r' class="form-control" placeholder="Right IOP (Goldmann)" value = "<?php echo $i->RIGHT_IOP_GOLDMANN; ?>" disabled></td>
																			<td><input name = 'iop_Goldmann_l' class="form-control" placeholder="Left IOP (Goldmann)" value = "<?php echo $i->LEFT_IOP_GOLDMANN; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>IOP (Shiotz)</th>
																			<td><input name = 'iop_Shiotz_r' class="form-control" placeholder="Right IOP (Shiotz)" value = "<?php echo $i->RIGHT_IOP_SCHIOTZ; ?>" disabled></td>
																			<td><input name = 'iop_Shiotz_l' class="form-control" placeholder="Left IOP (Shiotz)" value = "<?php echo $i->LEFT_IOP_SCHIOTZ; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>IOP (Tonopen)</th>
																			<td><input name = 'iop_Tonopen_r' class="form-control" placeholder="Right IOP (Tonopen)" value = "<?php echo $i->RIGHT_IOP_TONOPEN; ?>" disabled></td>
																			<td><input name = 'iop_Tonopen_l' class="form-control" placeholder="Left IOP (Tonopen)" value = "<?php echo $i->LEFT_IOP_TONOPEN; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>IOP (others)</th>
																			<td><input name = 'iop_other_r' class="form-control" placeholder="Right IOP (others)" value = "<?php echo $i->RIGHT_IOP_OTHERS; ?>" disabled></td>
																			<td><input name = 'iop_other_l' class="form-control" placeholder="Left IOP (others)" value = "<?php echo $i->LEFT_IOP_OTHERS; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th>Type of Instrument used for Others</th>
																			<td><input name = 'iop_otherInstrument_r' class="form-control" placeholder="Right Type of Instrument used for Others" value = "<?php echo $i->RIGHT_IOP_OTHERS_INSTRUMENT; ?>" disabled></td>
																			<td><input name = 'iop_otherInstrument_l' class="form-control" placeholder="Left Type of Instrument used for Others" value = "<?php echo $i->LEFT_IOP_OTHERS_INSTRUMENT; ?>" disabled></td>
																		</tr>
																		<tr>
																			<td colspan=3></td>
																		</tr>
																		<tr>
																			<th class = "success">IOP Remarks</th>
																			<td colspan = 2><input name = "iop_remarks" class = "form-control" rows = 1 maxlength = 45  style = "overflow:auto;resize:none" placeholder = 'IOP Remarks' value = "<?php echo $i->IOP_REMARK; ?>" disabled></td>
																		</tr>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
											<?php
												}
											}
											?> 
												</div>
												<!--COLOR-->
												<div class="panel panel-default">
													
													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseColor<?php echo $visit->visit_num; ?>">
															<div class = 'panel panel-info'>
															<div class = "panel-heading">
																<b>Color Test</b>
															</div></div>
														</a>
													</h4>
													
										<?php
											foreach ($ancillary_color as $i)
											{
												if ($i->VISIT_NO == $visit->visit_num)
												{
										?>  
													<div id = "collapseColor<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
														<div class = "panel-body">
															<div class = "col-lg-12">
																<table class = "table table-bordered">
																	<tbody>																		
																		<tr>
																			<th class = "success">Color Test Used</th>
																			<td><input name = 'color_test' class="form-control" placeholder="Color Test Used" value = "<?php echo $i->COLOR_TEST; ?>" disabled></td>
																			<th class = "success">Color Institution</th>
																			<td><input name = 'colorInstitution' class="form-control" placeholder="Color Institution" value = "<?php echo $i->COLOR_INSTITUTION; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th class = "warning">Right Color Result</th>
																			<td><<input name = "color_result_r" class = "form-control" rows = 1 maxlength = 100  style = "overflow:auto;resize:none" placeholder = 'Right Color Result' value = "<?php echo $i->RIGHT_COLOR_RESULT; ?>" disabled>
																			</td>
																			<th class = "warning">Left Color Result</th>
																			<td><input name = "color_result_l" class = "form-control" rows = 1 maxlength = 100  style = "overflow:auto;resize:none" placeholder = 'Left Color Result' value = "<?php echo $i->LEFT_COLOR_RESULT; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th class = "success">Color Test Reader</th>
																			<td colspan = 3><input name = 'color_reader' class="form-control" placeholder="Color Test Reader" value = "<?php echo $i->COLOR_READER; ?>" disabled></td>
																		</tr>
																		<tr>
																			<td colspan = 4></td>
																		</tr>
																		<tr>
																			<th class = "active">Color Remarks</th>
																			<td colspan = 3><input name = "color_remarks" class = "form-control" rows = 1 maxlength = 100  style = "overflow:auto;resize:none" placeholder = 'Color Remarks' value = "<?php echo $i->COLOR_REMARK; ?>" disabled></td>
																		</tr>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
											
											<?php
												}
											}
											?>
												</div>
												<!--UTZ-->
												<div class="panel panel-default">													
													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOccUltra<?php echo $visit->visit_num; ?>">
															<div class = 'panel panel-info'>
															<div class = "panel-heading">
																<b>Occular Ultrasound</b>
															</div></div>
														</a>
													</h4>
										<?php
											foreach ($ancillary_utz as $i)
											{
												if ($i->VISIT_NO == $visit->visit_num)
												{
										?>  	
													<div id="collapseOccUltra<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
														<div class="panel-body">
														   <div class="col-lg-12">
																<table class="table table-bordered">
																	<tbody>																	
																	<tr>
																		<th class = "success">UTZ Institution</th>
																		<td><input name = 'utzInstitution' class="form-control" placeholder="UTZ Institution" value = "<?php echo $i->UTZ_INSTITUTION; ?>" disabled></td>
																		<th class = "success">UTZ Machine Used</th>
																		<td><input name = 'utzMachine' class="form-control" placeholder="UTZ Machine Used" value = "<?php echo $i->UTZ_MACHINE; ?>" disabled></td>
																	</tr>
																	<tr>
																		<td colspan = 4></td>
																	</tr>
																	<tr>
																		<th class = "active" >UTZ Reader</th>
																		<td colspan = 3><input name = 'utzReader' class="form-control" placeholder="UTZ Reader" value = "<?php echo $i->UTZ_READER; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th class = "success">UTZ Remarks</th>
																		<td colspan = 3><input name = "utz_remarks" class = "form-control" rows = 1 maxlength = 100  style = "overflow:auto;resize:none" placeholder = 'UTZ Remarks' value ="<?php echo $i->UTZ_REMARKS; ?>" disabled></td>
																	</tr>
																	</tbody>
																</table>																						
															 </div>
														</div>
													</div>
										<?php
												}
											}
										?>
												</div>
												
												<!--RETINA_IMAGING-->
												<div class="panel panel-default">												
													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseRetina_img<?php echo $visit->visit_num; ?>">
															<div class = 'panel panel-info'>
															<div class = "panel-heading">
																<b>Retina Imaging</b>
															</div></div>
														</a>
													</h4>
													
										<?php
											foreach ($ancillary_retina_image as $i)
											{
												if ($i->VISIT_NO == $visit->visit_num)
												{
										?>  
													<div id="collapseRetina_img<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
														<div class="panel-body">
														   <div class="col-lg-12">
																<table class="table table-bordered">
																	<tbody>																	
																	<tr>
																		<th class = "success">Retina Imaging Used</th>
																		<td><input name = 'retImg_used' class="form-control" placeholder="Retina Imaging Used" value = "<?php echo $i->RETINA_IMAGING_USED; ?>" disabled></td>
																		<th class = "success">Retina Imaging Institution</th>
																		<td><input name = 'retImg_institution' class="form-control" placeholder="Retina Imaging Institution" value = "<?php echo $i->RETINA_IMAGE_INSTITUTION; ?>" disabled></td>
																	</tr>
																	<tr>
																		<td colspan = 4></td>
																	</tr>
																	<tr>
																		<th class = "active" >Retina Image Reader</th>
																		<td colspan = 3><input name = 'retImg_reader' class="form-control" placeholder="Retina Image Reader" value = "<?php echo $i->RETINA_IMAGE_READER; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th class = "success">Retina Image Remarks</th>
																		<td colspan = 3><input name = "retImg_remarks" class = "form-control" rows = 1 maxlength = 500  style = "overflow:auto;resize:none" placeholder = 'Retina Image Remarks' value = "<?php echo $i->RETINA_IMAGE_REMARKS; ?>" disabled></td>
																	</tr>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
										<?php
												}
											}
										?>
												</div>
												<!--NEUROPHY_VER-->
												<div class="panel panel-default">													
													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseNeuroPhy_ver<?php echo $visit->visit_num; ?>">
															<div class = 'panel panel-info'>
															<div class = "panel-heading">
																<b>Neurophysiologic Tests: VER</b>
															</div></div>
														</a>
													</h4>
													
										<?php
											foreach ($ancillary_ver as $i)
											{
												if ($i->VISIT_NO == $visit->visit_num)
												{
										?>  
													<div id="collapseNeuroPhy_ver<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
														<div class="panel-body">
														   <div class="col-lg-12">
																<table class="table table-bordered">
																	<tbody>																	
																	<tr>
																		<th class = "success">Institution VER</th>
																		<td><input name = 'verInstitution' class="form-control" placeholder="Institution VER" value = "<?php echo $i->INSTITUTION_VER; ?>" disabled></td>
																		<th class = "success">VER Reader</th>
																		<td><input name = 'verReader' class="form-control" placeholder="VER Reader" value = "<?php echo $i->VER_READER; ?>" disabled></td>
																	</tr>
																	<tr>
																		<td colspan = 4></td>
																	</tr>
																	<tr>
																		<th class = "success">VER Remarks</th>
																		<td colspan = 3><input name = "ver_remarks" class = "form-control" rows = 1 maxlength = 100  style = "overflow:auto;resize:none" placeholder = 'VER Remarks' value = "<?php echo $i->VER_REMARKS; ?>" disabled></td>
																	</tr>
																	</tbody>
																</table>																
															</div>
														</div>
													</div>
										<?php
												}
											}
										?>
												</div>
												<!--NEUROPHY_EOG-->
												<div class="panel panel-default">
													
													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseNeuroPhy_eog<?php echo $visit->visit_num; ?>">
															<div class = 'panel panel-info'>
															<div class = "panel-heading">
																<b>Neurophysiologic Tests: EOG</b>
															</div></div>
														</a>
													</h4>
													
										<?php
											foreach ($ancillary_eog as $i)
											{
												if ($i->VISIT_NO == $visit->visit_num)
												{
										?>  
													<div id="collapseNeuroPhy_eog<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
														<div class="panel-body">
															<div class="col-lg-12">
																<table class="table table-bordered">
																	<tbody>																	
																	<tr>
																		<th class = "success">Institution EOG</th>
																		<td><input name = 'eogInstitution' class="form-control" placeholder="Institution EOG" value = "<?php echo $i->INSTITUTION_EOG; ?>" disabled></td>
																		<th class = "success">EOG Reader</th>
																		<td><input name = 'eogReader' class="form-control" placeholder="EOG Reader" value = "<?php echo $i->EOG_READER; ?>" disabled></td>
																	</tr>
																	<tr>
																		<td colspan = 4></td>
																	</tr>

																	<tr>
																		<th class = "success">EOG Remarks</th>
																		<td colspan = 3><input name = "eogRemarks" class = "form-control" rows = 1 maxlength = 100 style = "overflow:auto;resize:none" placeholder = 'EOG Remarks' value = "<?php echo $i->EOG_REMARKS; ?>" disabled></td>
																	</tr>
																	</tbody>
																</table>																
															</div>
														</div>
													</div>
										<?php
												}
											}
										?>		
												</div>
												<!--OCT_DISC-->
												<div class="panel panel-default">
													
													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOCTDisc<?php echo $visit->visit_num; ?>">
															<div class = 'panel panel-info'>
															<div class = "panel-heading">
																<b>Optical Coherence Tomography (Disc)</b>
															</div></div>
														</a>
													</h4>
													
										<?php
											foreach ($ancillary_oct_disc as $i)
											{
												if ($i->VISIT_NO == $visit->visit_num)
												{
										?>  
													<div id="collapseOCTDisc<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
														<div class="panel-body">
															<div class="col-lg-12">
																<table class="table table-bordered">
																	<tbody>																		
																		<tr>
																			<th class = "success">OCT DISC Institution</th>
																			<td><input name = 'octD_institution' class="form-control" placeholder="OCT DISC Institution" value = "<?php echo $i->OCT_DISC_INSTITUTION; ?>" disabled></td>
																			<th class = "success">OCT DISC Machine</th>
																			<td><input name = 'octD_machine' class="form-control" placeholder="OCT DISC Machine" value = "<?php echo $i->OCT_DISC_MACHINE; ?>" disabled></td>
																		</tr>
																		<tr>
																			<td colspan = 4></td>
																		</tr>
																		<tr>
																			<th class = "active" >OCT DISC Reader</th>
																			<td colspan = 3><input name = 'octD_reader' class="form-control" placeholder="OCT DISC Reader" value = "<?php echo $i->OCT_DISC_READER; ?>" disabled></td>
																		</tr>
																		<tr>
																			<th class = "success">OCT DISC Remarks</th>
																			<td colspan = 3><input name = "octD_remarks" class = "form-control" rows = 1 maxlength = 100 style = "overflow:auto;resize:none" placeholder = 'OCT DISC Remarks' value = "<?php echo $i->OCT_DISC_REMARKS; ?>" disabled></td>
																		</tr>
																	</tbody>
																</table>
																
															</div>
														</div>
													</div>
										<?php
												}
											}
										?>	
												</div>
												<!--OCT_MACULA-->
												<div class="panel panel-default">
													
													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOCTMacula<?php echo $visit->visit_num; ?>">
															<div class = 'panel panel-info'>
															<div class = "panel-heading">
																<b>Optical Coherence Tomography (Macula)</b>
															</div></div>
														</a>
													</h4>
													
										<?php
											foreach ($ancillary_oct_macula as $i)
											{
												if ($i->VISIT_NO == $visit->visit_num)
												{
										?> 
													<div id="collapseOCTMacula<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
														<div class="panel-body">
														   <div class="col-lg-12">
																<table class="table table-bordered">
																	<tbody>																	
																	<tr>
																		<th class = "success">OCT MACULA Institution</th>
																		<td><input name = 'octM_institution' class="form-control" placeholder="OCT MACULA Institution" value = "<?php echo $i->OCT_MACULA_INSTITUTION; ?>" disabled></td>
																		<th class = "success">OCT MACULA Machine</th>
																		<td><input name = 'octM_machine' class="form-control" placeholder="OCT MACULA Machine" value = "<?php echo $i->OCT_MACULA_MACHINE; ?>" disabled></td>
																	</tr>
																	<tr>
																		<td colspan = 4></td>
																	</tr>
																	<tr>
																		<th class = "active" >OCT MACULA Reader</th>
																		<td colspan = 3><input name = 'octM_reader' class="form-control" placeholder="OCT MACULA Reader" value = "<?php echo $i->OCT_MACULA_READER; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th class = "success">OCT MACULA Remarks</th>
																		<td colspan = 3><input name = "octM_remarks" class = "form-control" rows = 1 maxlength = 100 style = "overflow:auto;resize:none" placeholder = 'OCT MACULA Remarks' value = "<?php echo $i->OCT_MACULA_REMARKS; ?>" disabled></td>
																	</tr>
																	</tbody>
																</table>																
															</div>
														</div>
													</div>
										<?php
												}
											}
										?>
												</div>
												<!--OCT_OTHER-->
												<div class="panel panel-default">
													
													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOCTOther<?php echo $visit->visit_num; ?>">
															<div class = 'panel panel-info'>
															<div class = "panel-heading">
																<b>Optical Coherence Tomography (Other Areas)</b>
															</div></div>
														</a>
													</h4>
													
										<?php
											foreach ($ancillary_oct_other as $i)
											{
												if ($i->VISIT_NO == $visit->visit_num)
												{
										?> 
													<div id="collapseOCTOther<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
														<div class="panel-body">
														   <div class="col-lg-12">
																<table class="table table-bordered">
																	<tbody>
																	<tr>
																		<th class = "success">OCT Other Area Institution</th>
																		<td><input name = 'octOA_institution' class="form-control" placeholder="OCT Other Area Institution" value = "<?php echo $i->OCT_OTHER_INSTITUTION; ?>" disabled></td>
																		<th class = "success">OCT Other Area Machine</th>
																		<td><input name = 'octOA_machine' class="form-control" placeholder="OCT Other Area Machine" value = "<?php echo $i->OCT_OTHER_MACHINE; ?>" disabled></td>
																	</tr>
																	<tr>
																		<td colspan = 4></td>
																	</tr>
																	<tr>
																		<th class = "active" >OCT Other Area Tested</th>
																		<td colspan = 3><input name = 'octOA_tested' class="form-control" placeholder="OCT Other Area Tested" value = "<?php echo $i->OCT_OTHER_AREA_TESTED; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th class = "active" >OCT Other Reader</th>
																		<td colspan = 3><input name = 'octOA_reader' class="form-control" placeholder="OCT Other Reader" value = "<?php echo $i->OCT_OTHER_READER; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th class = "success">OCT Other Remarks</th>
																		<td colspan = 3><input name = "octOA_remarks" class = "form-control" rows = 1 maxlength = 100 style = "overflow:auto;resize:none" placeholder = 'OCT Other Remarks' value = "<?php echo $i->OCT_OTHER_REMARKS; ?>" disabled></td>
																	</tr>
																	</tbody>
																</table>															
															</div>
														</div>
													</div>
										<?php
												}
											}
										?>			
												</div>
												<!--VISUAL_FIELDS-->
												<div class="panel panel-default">													
													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseVisFields<?php echo $visit->visit_num; ?>">
															<div class = 'panel panel-info'>
															<div class = "panel-heading">
																<b>Visual Fields</b>
															</div></div>
														</a>
													</h4>
													
										<?php
											foreach ($ancillary_vf as $i)
											{
												if ($i->VISIT_NO == $visit->visit_num)
												{
										?> 
													<div id="collapseVisFields<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
														<div class="panel-body">
														   <div class="col-lg-12">
																<table class="table table-bordered">
																	<tbody>																	
																	<tr>
																		<th class = "success">Institution VF</th>
																		<td><input name = 'vfInstitution' class="form-control" placeholder="Institution VF" value = "<?php echo $i->INSTITUTION_VF; ?>" disabled></td>
																		<th class = "success">VF Program Used</th>
																		<td><input name = 'vfProgram' class="form-control" placeholder="VF Program Used" value="<?php echo $i->VF_PROGRAM; ?>" disabled></td>
																	</tr>
																	<tr>
																		<td colspan = 4></td>
																	</tr>
																	<tr>
																		<th class = "active" >VF Reader</th>
																		<td colspan = 3><input name = 'vfReader' class="form-control" placeholder="VF Reader" value = "<?php echo $i->VF_READER; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th class = "success">VF Remarks</th>
																		<td colspan = 3><input name = "vf_remarks" class = "form-control" rows = 1 maxlength = 100 style = "overflow:auto;resize:none" placeholder = 'VF Remarks' value="<?php echo $i->VF_REMARKS; ?>" disabled></td>
																	</tr>
																	</tbody>
																</table>																
															</div>
														</div>
													</div>
										<?php
												}
											}
										?>	
												</div>
												<!--OTHERS-->
												<div class="panel panel-default">													
													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOther<?php echo $visit->visit_num; ?>">
															<div class = 'panel panel-info'>
															<div class = "panel-heading">
																<b>Others</b>
															</div></div>
														</a>
													</h4>
													
										<?php
											foreach ($ancillary_other as $i)
											{
												if ($i->VISIT_NO == $visit->visit_num)
												{
										?> 
													<div id="collapseOther<?php echo $visit->visit_num; ?>" class = 'panel-collapse collapse' >
														<div class="panel-body">
														   <div class="col-lg-12">
																<table class="table table-bordered">
																	<tbody>																	
																	<tr>
																		<th class = "success">Institution Other Test</th>
																		<td><input name = 'otherInstitution' class="form-control" placeholder="Institution Other Test" value = "<?php echo $i->INSTITUTION_OTHER_TEST; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th class = "success">Other Test Done</th>
																		<td><input name = 'otherTest' class="form-control" placeholder="Other Test Done" value = "<?php echo $i->OTHER_TEST; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th class = "active" >Other Test Results Reader</th>
																		<td ><input name = 'otherReader' class="form-control" placeholder="Other Test Results Reader" value = "<?php echo $i->OTHER_TEST_READER; ?>" disabled></td>
																	</tr>
																	<tr>
																		<th class = "success">Remarks</th>
																		<td><input name = "other_remarks" class = "form-control" rows = 1 maxlength = 100 style = "overflow:auto;resize:none" placeholder = 'Other Test Remarks' value="<?php echo $i->OTHER_TEST_REMARKS; ?>" disabled></td>
																	</tr>
																	</tbody>
																</table>			
															</div>
														</div>
													</div>
										<?php
												}
											}
										?>
												</div>
											</div>
										</div><!--END ANCILLARY TEXT COLLAPSE GROUP-->
										
										<!-- START DIAGNOSES -->
										<div class="panel">
											<table class = 'table table-bordered'>
												<tbody>
													<tr>
														<th class = 'success'><center>Diagnoses</center>
														</th>
														<th class = 'success'><center>Remarks</center></th>
													</tr>
													
										<?php
											foreach ($diagnoses as $i)
											{
												if ($i->VISIT_NO == $visit->visit_num)
												{
										?>
													<tr>
														<th>Diagnosis</th>
														<td><input class = 'form-control' value = '<?php echo $i->DIAGNOSIS; ?>' readonly></td>
													</tr>
													<tr>
														<th>ICD 10 Code</th>
														<td><input class = 'form-control' value = '<?php echo $i->ICD10_DIAGNOSIS; ?>' readonly></td>
													</tr>
													<tr>
														<th>Diagnosis Remarks</th>
														<td><input class = 'form-control' name = 'diagnosis_remarks[]' value = '<?php echo $i->DIAGNOSIS_REMARKS; ?>' readonly></td>
													</tr>
													<tr>
														<td colspan = 2 class="success"></td>
													</tr>
										<?php
												}
											}
										?>
												</tbody>
											</table>
										</div>
										<!-- END DIAGNOSES -->
										
									</div>

								</div>
							</div>
					<?php
							}
					?>
							</div>
						</div>
						<div id="billings" class="tab-pane">
						
				<?php
					foreach ($billings as $billing)
					{
				?>		
							<div class="panel panel-danger">
								<div class="panel-heading">
									<h2 class="">Billing no. <?php echo $billing->bill_no; ?></h3>			
								</div>		
								 
								<div class="panel-body">
									<div class="text">
										
										<h2><?php echo date("j M Y, h:i:s A", strtotime($billing->installment_date)); ?></h2>
										<p>
											<a>Installment no: </a>
											<?php echo $billing->installment_no; ?>
										</p>
										<p>
											<a>Total Amount Paid: </a>
											₱<?php echo $billing->amount_deposited; ?>
										</p>
										
									</div>
								</div>
							</div>
				<?php
					}
				?>
						</div>
						  <!-- Ordering -->
						<div id="clinicalordering" class="tab-pane">
							<div class="profile-activity">	
	
					<?php 
						foreach ($order_lists as $order_list)
						{
							$grandTotal = 0;
					?>
								<div class="panel panel-success">
									<div class="panel-heading">
										<h2 class="">Order no. <?php echo $order_list->order_id; ?></h2>			
									</div>
								
									<div class="panel-body">
										<div class='col-lg-5'>
											<h3><?php echo date("j M Y, h:i:s A", strtotime($order_list->order_date)); ?></h3>
											<h3><?php echo $order_list->order_md; ?></h3>
										</div>
										<div class="col-lg-5">
											<div class="collapse filter-panel col-lg-12" id="tableOfOrder<?php echo $order_list->order_id; ?>">
												<section class="panel">
												
										<?php
											foreach ($packages as $package)
											{
												if ($order_list->order_id == $package->order_id)
												{
													$subtotal = $package->package_price * $package->quantity;
													$grandTotal += $subtotal;
										?>
													<h4><?php echo $package->package_name, " x ", $package->quantity; ?></h4>
													
													<table class="table table-bordered">
														<thead>
															<tr>
																<th>Product</th>
																<th>Price</th>
																<th>Quantity</th>
																<th>Subtotal</th>
															</tr>
														</thead>
														<tbody>
												<?php
													
													foreach ($products as $product)
													{
														if ($package->package_id == $product->package_id)
														{
															$subtotal = $product->product_price * $product->quantity;												?>
															<tr>
																<td><?php echo $product->product_name; ?></td>
																<td>₱<?php echo $product->product_price; ?></td>
																<td><?php echo $product->quantity; ?></td>
																<td>₱<?php echo $subtotal; ?></td>
															</tr>
												<?php
														}
													}													
													
												?>
														</tbody>
													</table>	
										<?php
												}
											}
										?>
												</section>
											</div>
											<h3>Grand Total: ₱<?php echo $grandTotal; ?></h3>
											<button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#tableOfOrder<?php echo $order_list->order_id; ?>">
											Check Order
											</button>
											
										</div>
										
									</div>
								</div>	
				<?php
						}
				?>
							</div>
						</div>
						
						<!--Appointments tab-->
						<div id="appointments" class="tab-pane">
						
				<?php
					foreach ($schedules as $schedule)
					{
						
				?>
							<div class="profile-activity">
								<div class="act-time">                                      
									<div class="activity-body act-in">
										<span class="arrow"></span>
										<div class="text">											  
											<h2>Schedule: 
											<?php echo ScheduledAppointment::getScheduleTime($schedule->{ScheduledAppointment::SCHEDULE_TIME}); ?>, 
											<?php echo ScheduledAppointment::getSCheduleDate($schedule->{ScheduledAppointment::SCHEDULE_DATE}); ?></h2>
											<p><a>Status: </a>
											<?php 
												$status = ScheduledAppointment::getStatus($schedule->{ScheduledAppointment::STATUS}, $schedule->{ScheduledAppointment::SCHEDULE_DATE}); 
												switch ($status)
												{
													case ScheduledAppointment::UPCOMING:
														echo "Upcoming";
														break;
													case ScheduledAppointment::OVERDUE:
														echo "Overdue";
														break;
													case ScheduledAppointment::CANCELLED:
														echo "Cancelled";
														break;
												}
											?>
											</p>
										</div>
									</div>
								</div>
							</div>
				<?php
					}
				?>
						</div>
						
						<!-- Scanned docs tab -->
						<div id="results" class="tab-pane">
							<section id="portfolio">
								<div class="container">
									
									<div class="row">
										<div class="col-lg-12 text-center">
											<hr class="star-primary">
										</div>
									</div>
									

					
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