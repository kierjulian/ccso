<!--main content start-->
<section id="main-content">
<section class="wrapper">
<!-- page start-->
	<div class = "panel">
		<div class="panel-body">
			<table class = "table table-bordered">
				<tr>
					<th class = "success">Patient Name:</th>
					<td><?php echo $name; ?></td>
					<th class = "success">Age: </th>
					<td><?php echo $age; ?></td>
					<th class = "success">Sex:</th>
					<td> <?php echo $sex; ?></td>
				</tr>
			</table>
		</div>
	</div>
<?php	if ($alert == 1){ ?>
		<script language = "javascript">
			alert("Saving Successful!");
		</script>
<?php	} ?>
	<!-- EYE EXAMINATION -->	
	<div class="panel">
		<div class="panel-heading">
			<h2>EYE EXAMINATION</h2>	
		</div>
		<div class = "panel-body">
			<div class="panel-group m-bot20" id="accordion">
				<!--VA-->
				<div class="panel panel-default">
					<form class="form-horizontal" method='post' <?php if($editme == 'va' || $set_va != 1) echo "";?>>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseVA">
							<div class = <?php if($set_va == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
							<div class = "panel-heading">
								<b>Visual Acuity</b>
							</div></div>
						</a>
					</h4>
						  
					<div id="collapseVA" class = <?php if($editme == 'va') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
						<div class="panel-body">
							<div class="col-lg-12">
								<table class="table table-bordered">
									<?php if($set_va == 1) {
									?>		<tr><td colspan = '3'>
											<input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_va' value = 'Edit' />
											<input type = 'hidden' name = 'set' value = 'va' />
											<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
											<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
											<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
									<?php }?>
									<tbody>
										<tr>
											<th>Date of Consult</th>
											<td colspan = 3><input type = "date" class="form-control" name='date_va' required value = <?php if(isset($set_va)) echo $date_va.$readonly; else echo "";?> /></td>
										</tr>
										<tr>
											<th class = "active"></th>
											<th class = "success"><center>RIGHT VA</center></th>
											<th class = "warning"><center>LEFT VA</center></th>
										</tr>
										<tr>
											<th>VA without correction</th>
											<td><input name = 'va_NoCorrect_r' class="form-control" placeholder="Right VA without correction" value = <?php if($set_va == 1) echo "'".$va_NoCorrect_r."'".$readonly;?>></td>
											<td><input name = 'va_NoCorrect_l' class="form-control" placeholder="Left VA without correction" value = <?php if($set_va == 1) echo "'".$va_NoCorrect_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>VA without correction with pinhole</th>
											<td><input name = 'va_NoCorrect_pin_r' class="form-control" placeholder="Right VA w/o correction with pinhole" value = <?php if($set_va == 1) echo "'".$va_NoCorrect_pin_r."'".$readonly; ?>></td>
											<td><input name = 'va_NoCorrect_pin_l' class="form-control" placeholder="Left VA w/o correction with pinhole" value = <?php if($set_va == 1) echo "'".$va_NoCorrect_pin_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Best Correction</th>
											<td><input name = 'BestCorrect_r' class="form-control" placeholder="Right VA best correction" value = <?php if($set_va == 1) echo "'".$BestCorrect_r."'".$readonly; ?>></td>
											<td><input name = 'BestCorrect_l' class="form-control" placeholder="Left VA best correction" value = <?php if($set_va == 1) echo "'".$BestCorrect_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Best Correction (distance)</th>
											<td><input name = 'BestCorrect_dist_r' class="form-control" placeholder="Right VA best correction (distance)" value = <?php if($set_va == 1) echo "'".$BestCorrect_dist_r."'".$readonly; ?>></td>
											<td><input name = 'BestCorrect_dist_l' class="form-control" placeholder="Left VA best correction (distance)" value = <?php if($set_va == 1) echo "'".$BestCorrect_dist_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Best Correction (near)</th>
											<td><input name = 'BestCorrect_near_r' class="form-control" placeholder="Right VA best correction (near)" value = <?php if($set_va == 1) echo "'".$BestCorrect_near_r."'".$readonly; ?>></td>
											<td><input name = 'BestCorrect_near_l' class="form-control" placeholder="Left VA best correction (near)" value = <?php if($set_va == 1) echo "'".$BestCorrect_near_l."'".$readonly; ?>></td>
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
											<td><input name = 'ForcedPrimary_dist' class="form-control" placeholder="Forced Primary (Distance)" value = <?php if($set_va == 1) echo "'".$ForcedPrimary_dist."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Forced Primary (Near)</th>
											<td><input name = 'ForcedPrimary_near' class="form-control" placeholder="Forced Primary (Near)" value = <?php if($set_va == 1) echo "'".$ForcedPrimary_near."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Downgaze (Reading)</th>
											<td><input name = 'va_downgaze' class="form-control" placeholder="Downgaze (Reading)" value = <?php if($set_va == 1) echo "'".$va_downgaze."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Anomalous Head Posture (Distance)</th>
											<td><input name = 'ahp_dist' class="form-control" placeholder="Anomalous Head Posture (Distance)" value = <?php if($set_va == 1) echo "'".$ahp_dist."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Anomalous Head Posture (Near)</th>
											<td><input name = 'ahp_near' class="form-control" placeholder="Anomalous Head Posture (Near)" value = <?php if($set_va == 1) echo "'".$ahp_near."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>VA Anomalous Head Posture (Near)</th>
											<td><input name = 'va_ou_ahp_near' class="form-control" placeholder="Anomalous Head Posture (Near)" value = <?php if($set_va == 1) echo "'".$va_ou_ahp_near."'".$readonly; ?>></td>
										</tr>
									</tbody>
								</table>
							<?php if($editme == 'va' || $set_va != 1) echo "<input type = 'submit' class='btn btn-primary' name ='save_va' value = 'Save'/>";?>
							</div>
						</div>
					</div>
					</form>
				</div>
				<!--REFRACTION-->
				<div class="panel panel-default">
					<form class="form-horizontal" method='post' <?php if($editme == 'refrac' || $set_refrac != 1) echo "";?>>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseRefrac">
							<div class = <?php if($set_refrac == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
							<div class = "panel-heading">
								<b>Refraction</b>
							</div></div>
						</a>
					</h4>
		  
					<div id="collapseRefrac" class = <?php if($editme == 'refrac') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
						<div class="panel-body">
							<div class="col-lg-12">
								<table class="table table-bordered">
									<?php if($set_refrac == 1) {
									?>		<tr><td colspan = '3'>
											<input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_refrac' value = 'Edit' />
											<input type = 'hidden' name = 'set' value = 'va' />
											<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
											<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
											<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
									<?php }?>
									<tbody>
										<tr>
											<th>Date of Consult</th>
											<td colspan = 3><input type = "date" class="form-control" name='date_ref' required value = <?php if($set_refrac == 1) echo $date_ref.$readonly; ?>/> </td>
										</tr>
										<tr>
											<th></th>
											<th class = "success">RIGHT</th>
											<th class = "warning">LEFT</th>
										</tr>
										<tr>
											<th>Dry Autorefraction</th>
											<td><input name = 'DryAutoRef_r' class="form-control" placeholder="Right Dry Autorefraction" value = <?php if($set_refrac == 1) echo "'".$DryAutoRef_r."'".$readonly; ?>></td>
											<td><input name = 'DryAutoRef_l' class="form-control" placeholder="Left Dry Autorefraction" value = <?php if($set_refrac == 1) echo "'".$DryAutoRef_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Dry Objective Refraction</th>
											<td><input name = 'ObjRef_r'  class="form-control" placeholder="Right Dry Objective Refraction" value = <?php if($set_refrac == 1) echo "'".$ObjRef_r."'".$readonly; ?>></td>
											<td><input name = 'ObjRef_l'  class="form-control" placeholder="Left Dry Objective Refraction" value = <?php if($set_refrac == 1) echo "'".$ObjRef_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>VA with Objective Refraction</th>
											<td><input name = 'va_ObjRef_r' class="form-control" placeholder="Right VA with Objective Refraction" value = <?php if($set_refrac == 1) echo "'".$va_ObjRef_r."'".$readonly; ?>></td>
											<td><input name = 'va_ObjRef_l' class="form-control" placeholder="Left VA with Objective Refraction" value = <?php if($set_refrac == 1) echo "'".$va_ObjRef_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Manifest Refraction</th>
											<td><input name = 'ManRef_r' class="form-control" placeholder="Right Manifest Refraction" value = <?php if($set_refrac == 1) echo "'".$ManRef_r."'".$readonly; ?>></td>
											<td><input name = 'ManRef_l' class="form-control" placeholder="Left Manifest Refraction" value = <?php if($set_refrac == 1) echo "'".$ManRef_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>VA with Manifest Refraction</th>
											<td><input name = 'va_ManRef_r' class="form-control" placeholder="Right VA with Manifest Refraction" value = <?php if($set_refrac == 1) echo "'".$va_ManRef_r."'".$readonly; ?>></td>
											<td><input name = 'va_ManRef_l' class="form-control" placeholder="Left VA with Manifest Refraction" value = <?php if($set_refrac == 1) echo "'".$va_ManRef_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Cycloplegic Refraction</th>
											<td><input name = 'CycloRef_r' class="form-control" placeholder="Right Cycloplegic Refraction" value = <?php if($set_refrac == 1) echo "'".$CycloRef_r."'".$readonly; ?>></td>
											<td><input name = 'CycloRef_l' class="form-control" placeholder="Left Cycloplegic Refraction" value = <?php if($set_refrac == 1) echo "'".$CycloRef_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>VA with Cycloplegic Refraction</th>
											<td><input name = 'va_CycloRef_r' class="form-control" placeholder="Right VA with Cycloplegic Refraction" value = <?php if($set_refrac == 1) echo "'".$va_CycloRef_r."'".$readonly; ?>></td>
											<td><input name = 'va_CycloRef_l' class="form-control" placeholder="Left VA with Cycloplegic Refraction" value = <?php if($set_refrac == 1) echo "'".$va_CycloRef_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Cycloplegic Agent</th>
											<td><input name = 'CycloAgent_r' class="form-control" placeholder="Right Cycloplegic Agent" value = <?php if($set_refrac == 1) echo "'".$CycloAgent_r."'".$readonly; ?>></td>
											<td><input name = 'CycloAgent_l' class="form-control" placeholder="Left Cycloplegic Agent" value = <?php if($set_refrac == 1) echo "'".$CycloAgent_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Tolerated Refraction</th>
											<td><input name = 'TolRef_r' class="form-control" placeholder="Right Tolerated Refraction" value = <?php if($set_refrac == 1) echo "'".$TolRef_r."'".$readonly; ?>></td>
											<td><input name = 'TolRef_l' class="form-control" placeholder="Left Tolerated Refraction" value = <?php if($set_refrac == 1) echo "'".$TolRef_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>VA with Tolerated Refraction</th>
											<td><input name = 'va_TolRef_r' class="form-control" placeholder="Right VA with Tolerated Refraction" value = <?php if($set_refrac == 1) echo "'".$va_TolRef_r."'".$readonly; ?>></td>
											<td><input name = 'va_TolRef_l' class="form-control" placeholder="Left VA with Tolerated Refraction" value = <?php if($set_refrac == 1) echo "'".$va_TolRef_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<td colspan=3></td>
										</tr>
										<tr>
											<th class = "success">Refraction Remarks</th>
											<td colspan=2>
											<textarea name = "ref_remarks" class = "form-control" rows = 1 maxlength = 100 style = "overflow:auto;resize:none" <?php if($set_refrac == 1) echo $readonly; else echo "placeholder = 'Refraction Remarks'";?>><?php if($set_refrac == 1) echo $ref_remarks;?></textarea>
											</td>
										</tr>
									</tbody>
								</table>
								<?php if($editme == 'refrac' || $set_refrac != 1) echo "<input type = 'submit' class='btn btn-primary' name ='save_refrac' value = 'Save'/>";?>
							</div>
						</div>
					</div>
					</form>
				</div>
				<!--PUPILS-->
				<div class="panel panel-default">
					<form class="form-horizontal" method='post' <?php if($editme == 'pupils' || $set_pupils != 1) echo "";?>>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapsePupil">
							<div class = <?php if($set_pupils == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
							<div class = "panel-heading">
								<b>Pupils</b>
							</div></div>
						</a>
					</h4>
		  
					<div id="collapsePupil" class = <?php if($editme == 'pupils') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
						<div class="panel-body">
							<div class="col-lg-12">
								<table class="table table-bordered">
									<?php if($set_pupils == 1) {?>
										<tr><td colspan = '3'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_pupils' value = 'Edit' />
										<input type = 'hidden' name = 'set' value = 'pupils' />
										<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
										<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
										<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
									<?php }?>
									<tbody>
										<tr>
											<th>Date of Consult</th>
											<td colspan = 3><input type = "date" class="form-control" name='date_pupil' required value = <?php if($set_pupils == 1) echo $date_pupil.$readonly; ?>/> </td>
										</tr>
										<tr>
											<th class="active"><center>Pupil's General Information</center></th>
											<th class = "success">RIGHT</th>
											<th class = "warning">LEFT</th>
										</tr>
										<tr>
											<th>Color</th>
											<td><input name = 'PupilColor_r' class="form-control" placeholder="Right Pupil Color" value = <?php if($set_pupils == 1) echo "'".$PupilColor_r."'".$readonly; ?>></td>
											<td><input name = 'PupilColor_l' class="form-control" placeholder="Left Pupil Color" value = <?php if($set_pupils == 1) echo "'".$PupilColor_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Shape</th>
											<td><input name = 'PupilShape_r'  class="form-control" placeholder="Right Pupil Shape" value = <?php if($set_pupils == 1) echo "'".$PupilShape_r."'".$readonly; ?>></td>
											<td><input name = 'PupilShape_l'  class="form-control" placeholder="Left Pupil Shape" value = <?php if($set_pupils == 1) echo "'".$PupilShape_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Size (ambient)</th>
											<td><input name = 'PupilSize_amb_r' class="form-control" placeholder="Right Pupil Size (ambient)" value = <?php if($set_pupils == 1) echo "'".$PupilSize_amb_r."'".$readonly; ?>></td>
											<td><input name = 'PupilSize_amb_l' class="form-control" placeholder="Left Pupil Size (ambient)" value = <?php if($set_pupils == 1) echo "'".$PupilSize_amb_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Size (dark room)</th>
											<td><input name = 'PupilSize_dark_r' class="form-control" placeholder="Right Pupil Size (dark room)" value = <?php if($set_pupils == 1) echo "'".$PupilSize_dark_r."'".$readonly; ?>></td>
											<td><input name = 'PupilSize_dark_l' class="form-control" placeholder="Left Pupil Size (dark room)" value = <?php if($set_pupils == 1) echo "'".$PupilSize_dark_l."'".$readonly; ?>></td>
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
											<td><input name = 'LightRxn_amb_r' class="form-control" placeholder="Right Reaction to Light (ambient)" value = <?php if($set_pupils == 1) echo "'".$LightRxn_amb_r."'".$readonly; ?>></td>
											<td><input name = 'LightRxn_amb_l' class="form-control" placeholder="Left Reaction to Light (ambient)" value = <?php if($set_pupils == 1) echo "'".$LightRxn_amb_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Reaction to light (dark room)</th>
											<td><input name = 'LightRxn_dark_r' class="form-control" placeholder="Right Reaction to Light (dark room)" value = <?php if($set_pupils == 1) echo "'".$LightRxn_dark_r."'".$readonly; ?>></td>
											<td><input name = 'LightRxn_dark_l' class="form-control" placeholder="Left Reaction to Light (dark room)" value = <?php if($set_pupils == 1) echo "'".$LightRxn_dark_l."'".$readonly; ?>></td>
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
											<td><input name = 'relAPD_r' class="form-control" placeholder="Right Relative Afferent Pupillary Defect" value = <?php if($set_pupils == 1) echo "'".$relAPD_r."'".$readonly; ?>></td>
											<td><input name = 'relAPD_l' class="form-control" placeholder="Left Relative Afferent Pupillary Defect" value = <?php if($set_pupils == 1) echo "'".$relAPD_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Other Observation</th>
											<td><input name = 'pupil_other_r' class="form-control" placeholder="Right Pupil (Other Observations)" value = <?php if($set_pupils == 1) echo "'".$pupil_other_r."'".$readonly; ?>></td>
											<td><input name = 'pupil_other_l' class="form-control" placeholder="Left Pupil (Other Observations)" value = <?php if($set_pupils == 1) echo "'".$pupil_other_l."'".$readonly; ?>></td>
										</tr>
									</tbody>
								</table>
								<?php if($editme == 'pupils' || $set_pupils != 1) echo "<input type = 'submit' class='btn btn-primary' name ='save_pupils' value = 'Save'/>";?>
							</div>
						</div>
					</div>
					</form>
				</div>
				<!--GROSS-->
				<div class="panel panel-default">
					<form class="form-horizontal" method='post' <?php if($editme == 'gross' || $set_gross != 1) echo "";?>>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseGross">
							<div class = <?php if($set_gross == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
							<div class = "panel-heading">
								<b>Gross</b>
							</div></div>
						</a>
					</h4>
		  
					<div id="collapseGross" class="panel-collapse collapse collapse">
						<div class="panel-body">
							<div class="col-lg-12">
								<table class="table table-bordered">
									<?php if($set_gross == 1) {?>
										<tr><td colspan = '3'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_gross' value = 'Edit' />
										<input type = 'hidden' name = 'set' value = 'gross' />
										<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
										<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
										<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
									<?php }?>
									<tbody>
										<tr>
											<th>Date of Consult</th>
											<td colspan = 3><input type = "date" class="form-control" name='date_gross' required value = <?php if($set_gross == 1) echo $date_gross.$readonly; ?>/> </td>
										</tr>
										<tr>
											<th class = "active"></th>
											<th class = "success"><center>RIGHT</center></th>
											<th class = "warning"><center>LEFT</center></th>
										</tr>
										<tr>
											<th>Eyebrows</th>
											<td><input name = 'eyebrows_r' class="form-control" placeholder="Right Eyebrow" value = <?php if($set_gross == 1) echo "'".$eyebrows_r."'".$readonly; ?>></td>
											<td><input name = 'eyebrows_l' class="form-control" placeholder="Left Eyebrow" value = <?php if($set_gross == 1) echo "'".$eyebrows_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Adnexae</th>
											<td><input name = 'adnexae_r' class="form-control" placeholder="Right Adnexae" value = <?php if($set_gross == 1) echo "'".$adnexae_r."'".$readonly; ?>></td>
											<td><input name = 'adnexae_l' class="form-control" placeholder="Left Adnexae" value = <?php if($set_gross == 1) echo "'".$adnexae_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Lid Fissure (vertical HT)</th>
											<td><input name = 'lidFissure_r' class="form-control" placeholder="Right Lid Fissure (vertical HT)" value = <?php if($set_gross == 1) echo "'".$lidFissure_r."'".$readonly; ?>></td>
											<td><input name = 'lidFissure_l' class="form-control" placeholder="Left Lid Fissure (vertical HT)" value = <?php if($set_gross == 1) echo "'".$lidFissure_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th class>Cornea Gross</th>
											<td><input name = 'corneaGross_r' class="form-control" placeholder="Right Cornea (gross)" value = <?php if($set_gross == 1) echo "'".$corneaGross_r."'".$readonly; ?>></td>
											<td><input name = 'corneaGross_l' class="form-control" placeholder="Left Cornea (gross)" value = <?php if($set_gross == 1) echo "'".$corneaGross_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th class>Sclera Gross</th>
											<td><input name = 'scleraGross_r' class="form-control" placeholder="Right Sclera (gross)" value = <?php if($set_gross == 1) echo "'".$scleraGross_r."'".$readonly; ?>></td>
											<td><input name = 'scleraGross_l' class="form-control" placeholder="Left Sclera (gross)" value = <?php if($set_gross == 1) echo "'".$scleraGross_l."'".$readonly; ?>></td>
										</tr>	
										<tr>
											<th>Photograph</th>
											<td><input name = 'gross_img_r' class="form-control" placeholder="Right Photograph (gross)" value = <?php if($set_gross == 1) echo "'".$gross_img_r."'".$readonly; ?>></td>
											<td><input name = 'gross_img_l' class="form-control" placeholder="Left Photograph (gross)" value = <?php if($set_gross == 1) echo "'".$gross_img_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Others</th>
											<td><input name = 'gross_other_r' class="form-control" placeholder="Right Gross (others)" value = <?php if($set_gross == 1) echo "'".$gross_other_r."'".$readonly; ?>></td>
											<td><input name = 'gross_other_l' class="form-control" placeholder="Left Gross (others)" value = <?php if($set_gross == 1) echo "'".$gross_other_l."'".$readonly; ?>></td>
										</tr>
									</tbody>
								</table>
								<table class="table table-bordered">
									<tbody>
										<?php 
											$ctr = 0;
											if (isset($scans_arr_gross)) { 
										?>
										<tr>
											<th class="active" colspan="3"><center>Scanned Documents</center></th>
										</tr>
										<?php
												foreach ($scans_arr_gross as $scan) {
													if ($ctr % 2 == 0) {
														echo "<tr>";
													}
													echo "<td><div class='well alert'>";
													echo "<input type='hidden' name='gross_name_".$ctr."' value='".$scan->image_name."'>";
													echo "<div class='row'><div class='col-md-12 text-primary'><center>".strtoupper($scan->image_name)."</h6><center></div></div>";
													echo "<div class='row'><div class='col-md-12'><center><img src = '".$scan->image_path."' height='200px' width='340px'></center></div></div>";
													echo "<div class='row'><div class='col-md-12'><input type='hidden' name='gross_id_".$ctr."' value=".$scan->image_id."><input type='text' name='gross_img_".$ctr."' class='form-control' placeholder='Findings' value='".$scan->image_comments."'".$readonly."></div></div>";
													echo "</div></td>";
													if ($ctr % 2 == 1) {
														echo "</tr>";
													}
													$ctr++;
												}												
											}
											echo "<input type='hidden' name='gross_count' value=".$ctr.">";
										?>
									</tbody>
								</table>
								<?php if($editme == 'gross' || $set_gross != 1) echo "<input type = 'submit' class='btn btn-primary' name ='save_gross' value = 'Save'/>";?>
							</div>
						</div>
					</div>
					</form>
				</div>
				<!--SLIT LAMP-->
				<div class="panel panel-default">
					<form class="form-horizontal" method='post' enctype="multipart/form-data" <?php if($editme == 'slitlamp' || $set_slitlamp != 1) echo "";?>>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseSlit">
							<div class = <?php if($set_slitlamp == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
							<div class = "panel-heading">
								<b>Slit Lamp</b>
							</div></div>
						</a>
					</h4>
		  
					<div id="collapseSlit" class = <?php if($editme == 'slitlamp') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
						<div class="panel-body">
							<div class="col-lg-12">
								<table class="table table-bordered">
									<?php if($set_slitlamp == 1) {?>
										<tr><td colspan = '3'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_slitlamp' value = 'Edit' />
										<input type = 'hidden' name = 'set' value = 'slitlamp' />
										<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
										<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
										<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
									<?php }?>
									<tbody>
									<tr>
										<th>Date of Consult</th>
										<td colspan = 3><input type = "date" class="form-control" name='date_sl' required value = <?php if($set_slitlamp == 1) echo $date_sl.$readonly; ?>/> </td>
									</tr>
									<tr>
										<th></th>
										<th class = "success">RIGHT</th>
										<th class = "warning">LEFT</th>
									</tr>
									<tr>
										<th>Lids Upper</th>
										<td><input name = 'lidsUp_r' class="form-control" placeholder="Right Lids Upper" value = <?php if($set_slitlamp == 1) echo "'".$lidsUp_r."'".$readonly; ?>></td>
										<td><input name = 'lidsUp_l' class="form-control" placeholder="Left Lids Upper" value = <?php if($set_slitlamp == 1) echo "'".$lidsUp_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Lids Lower</th>
										<td><input name = 'lidsLow_r' class="form-control" placeholder="Right Lids Lower" value = <?php if($set_slitlamp == 1) echo "'".$lidsLow_r."'".$readonly; ?>></td>
										<td><input name = 'lidsLow_l' class="form-control" placeholder="Left Lids Lower" value = <?php if($set_slitlamp == 1) echo "'".$lidsLow_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Conjunctiva (Palpebral)</th>
										<td><input name = 'conj_palp_r' class="form-control" placeholder="Right Conjuctiva (Palpebral)" value = <?php if($set_slitlamp == 1) echo "'".$conj_palp_r."'".$readonly; ?>></td>
										<td><input name = 'conj_palp_l' class="form-control" placeholder="Left Conjuctiva (Palpebral)" value = <?php if($set_slitlamp == 1) echo "'".$conj_palp_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Conjunctiva (Bulbar)</th>
										<td><input name = 'conj_bulb_r' class="form-control" placeholder="Right Conjuctiva (Bulbar)" value = <?php if($set_slitlamp == 1) echo "'".$conj_bulb_r."'".$readonly; ?>></td>
										<td><input name = 'conj_bulb_l' class="form-control" placeholder="Left Conjuctiva (Bulbar)" value = <?php if($set_slitlamp == 1) echo "'".$conj_bulb_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Sclera SL</th>
										<td><input name = 'sl_sclera_r' class="form-control" placeholder="Right Sclera (slit lamp)" value = <?php if($set_slitlamp == 1) echo "'".$sl_sclera_r."'".$readonly; ?>></td>
										<td><input name = 'sl_sclera_l' class="form-control" placeholder="Left Sclera (slit lamp)" value = <?php if($set_slitlamp == 1) echo "'".$sl_sclera_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Limbus</th>
										<td><input name = 'limbus_r' class="form-control" placeholder="Right Limbus" value = <?php if($set_slitlamp == 1) echo "'".$limbus_r."'".$readonly; ?>></td>
										<td><input name = 'limbus_l' class="form-control" placeholder="Left Limbus" value = <?php if($set_slitlamp == 1) echo "'".$limbus_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Cornea SL</th>
										<td><input name = 'sl_cornea_r' class="form-control" placeholder="Right Cornea (slit lamp)" value = <?php if($set_slitlamp == 1) echo "'".$sl_cornea_r."'".$readonly; ?>></td>
										<td><input name = 'sl_cornea_l' class="form-control" placeholder="Left Cornea (slit lamp)" value = <?php if($set_slitlamp == 1) echo "'".$sl_cornea_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Angles/Trabecular Meshwork</th>
										<td><input name = 'AnglesMesh_r' class="form-control" placeholder="Right Angles/Trabecular Meshwork" value = <?php if($set_slitlamp == 1) echo "'".$AnglesMesh_r."'".$readonly; ?>></td>
										<td><input name = 'AnglesMesh_l' class="form-control" placeholder="Left Angles/Trabecular Meshwork" value = <?php if($set_slitlamp == 1) echo "'".$AnglesMesh_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Anterior Chamber</th>
										<td><input name = 'anterior_r' class="form-control" placeholder="Right Anterior Chamber" value = <?php if($set_slitlamp == 1) echo "'".$anterior_r."'".$readonly; ?>></td>
										<td><input name = 'anterior_l' class="form-control" placeholder="Left Anterior Chamber" value = <?php if($set_slitlamp == 1) echo "'".$anterior_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Iris</th>
										<td><input name = 'iris_r' class="form-control" placeholder="Right Iris" value = <?php if($set_slitlamp == 1) echo "'".$iris_r."'".$readonly; ?>></td>
										<td><input name = 'iris_l' class="form-control" placeholder="Left Iris" value = <?php if($set_slitlamp == 1) echo "'".$iris_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Lens</th>
										<td><input name = 'lens_r' class="form-control" placeholder="Right Lens" value = <?php if($set_slitlamp == 1) echo "'".$lens_r."'".$readonly; ?>></td>
										<td><input name = 'lens_l' class="form-control" placeholder="Left Lens" value = <?php if($set_slitlamp == 1) echo "'".$lens_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Vitreous (SL)</th>
										<td><input name = 'sl_vitreous_r' class="form-control" placeholder="Right Vitreous (slit lamp)" value = <?php if($set_slitlamp == 1) echo "'".$sl_vitreous_r."'".$readonly; ?>></td>
										<td><input name = 'sl_vitreous_l' class="form-control" placeholder="Left Vitreous (slit lamp)" value = <?php if($set_slitlamp == 1) echo "'".$sl_vitreous_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Nerve (SL)</th>
										<td><input name = 'sl_nerve_r' class="form-control" placeholder="Right Nerve (slit lamp)" value = <?php if($set_slitlamp == 1) echo "'".$sl_nerve_r."'".$readonly; ?>></td>
										<td><input name = 'sl_nerve_l' class="form-control" placeholder="Left Nerve (slit lamp)" value = <?php if($set_slitlamp == 1) echo "'".$sl_nerve_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Retinal arcade/vessels (SL)</th>
										<td><input name = 'sl_retinal_r' class="form-control" placeholder="Right Retinal Arcade/Vessels (slit lamp)" value = <?php if($set_slitlamp == 1) echo "'".$sl_retinal_r."'".$readonly; ?>></td>
										<td><input name = 'sl_retinal_l' class="form-control" placeholder="Left Retinal Arcade/Vessels (slit lamp)" value = <?php if($set_slitlamp == 1) echo "'".$sl_retinal_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Macula (SL)</th>
										<td><input name = 'sl_macula_r' class="form-control" placeholder="Right Macula (slit lamp)" value = <?php if($set_slitlamp == 1) echo "'".$sl_macula_r."'".$readonly; ?>></td>
										<td><input name = 'sl_macula_l' class="form-control" placeholder="Left Macula (slit lamp)" value = <?php if($set_slitlamp == 1) echo "'".$sl_macula_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Posterior Pole Others (SL)</th>
										<td><input name = 'sl_posterior_r' class="form-control" placeholder="Right Posterior Pole (slit lamp)" value = <?php if($set_slitlamp == 1) echo "'".$sl_posterior_r."'".$readonly; ?>></td>
										<td><input name = 'sl_posterior_l' class="form-control" placeholder="Left Posterior Pole (slit lamp)" value = <?php if($set_slitlamp == 1) echo "'".$sl_posterior_l."'".$readonly; ?>></td>
									</tr>
									</tbody>
								</table>
								
								<table class="table table-bordered">
									<tbody>
										<?php 
											$ctr = 0;
											if (isset($scans_arr_slitlamp)) {
										?>
										<tr>
											<th class="active" colspan="3"><center>Scanned Documents</center></th>
										</tr>
										<?php
												foreach ($scans_arr_slitlamp as $scan) {
													if ($ctr % 2 == 0) {
														echo "<tr>";
													}
													echo "<td><div class='well alert'>";
													echo "<input type='hidden' name='slitlamp_name_".$ctr."' value='".$scan->image_name."'>";
													echo "<div class='row'><div class='col-md-12 text-primary'><center>".strtoupper($scan->image_name)."</h6><center></div></div>";
													echo "<div class='row'><div class='col-md-12'><center><img src = '".$scan->image_path."' height='200px' width='340px'></center></div></div>";
													echo "<div class='row'><div class='col-md-12'><input type='hidden' name='slitlamp_id_".$ctr."' value=".$scan->image_id."><input type='text' name='slitlamp_img_".$ctr."' class='form-control' placeholder='Findings' value='".$scan->image_comments."'".$readonly."></div></div>";
													echo "</div></td>";
													if ($ctr % 2 == 1) {
														echo "</tr>";
													}
													$ctr++;
												}
											}
											echo "<input type='hidden' name='slitlamp_count' value=".$ctr.">";
										?>
									</tbody>
								</table>
								<?php if($editme == 'slitlamp' || $set_slitlamp != 1) echo "<input type = 'submit' class='btn btn-primary' name ='save_slitlamp' value = 'Save'/>";?>
							</div>
						</div>
					</div>
					</form>
				</div>
				<!-- STRABISMUS-->
				<div class="panel panel-default">
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseStrab">
							<div class = <?php $strab = $set_strabduc +  $set_strabmea + $set_strabfusamp +  $set_strabver; if($strab == 4)
								echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
							<div class = "panel-heading">
								<b>Strabismus</b>
							</div></div>
						</a>
					</h4>
					<div id="collapseStrab" class = <?php if($editme == 'strabd' || $editme == 'strabf' || $editme == 'strabm' || $editme == 'strabv') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
						<div class="panel-body">
							<div class = "col-lg-12">
								<div class="panel-group m-bot20" id="accordion3">
								<!--STRABDUC-->
								<div class="panel panel-default">
									<form class="form-horizontal" method='post' <?php if($editme == 'strabd' || $set_strabduc != 1) echo "";?>>
									<h4 class="panel-title">
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseStrabDuc">
											<div class = <?php if($set_strabduc == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
											<div class = "panel-heading">
												<b>Duction</b>
											</div></div>
										</a>
									</h4>
						  
									<div id="collapseStrabDuc" class = <?php if($editme == 'strabd') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
										<div class="panel-body">
											<div class = "col-lg-12">
												<table class="table table-bordered">
													<?php if($set_strabduc == 1) {?>
													<tr><td colspan = '3'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_strabd' value = 'Edit' />
														<input type = 'hidden' name = 'set' value = 'strabd' />
														<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
														<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
														<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
													<?php }?>
													<tbody>
														<tr>
															<th>Date of Consult</th>
															<td colspan = 3><input type = "date" class="form-control" name='date_strabd' required value = <?php if($set_strabduc == 1) echo $date_strabd.$readonly;?>/></td>
														</tr>
														<tr>
															<th></th>
															<th class = "success"><center>RIGHT</center></th>
															<th class = "warning"><center>LEFT</center></th>
														</tr>
														<tr>
															<th>MR (Primary)</th>
															<td><input name = 'mr_add_r' class="form-control" placeholder="Right MR (primary)" value = <?php if($set_strabduc == 1) echo "'".$mr_add_r."'".$readonly;?>></td>
															<td><input name = 'mr_add_l' class="form-control" placeholder="Left MR (primary)" value = <?php if($set_strabduc == 1) echo "'".$mr_add_l."'".$readonly;?>></td>
														</tr>
														<tr>
															<th>LR (Primary)</th>
															<td><input name = 'lr_abd_r' class="form-control" placeholder="Right LR (primary)" value = <?php if($set_strabduc == 1) echo "'".$lr_abd_r."'".$readonly;?>></td>
															<td><input name = 'lr_abd_l' class="form-control" placeholder="Left LR (primary)" value = <?php if($set_strabduc == 1) echo "'".$lr_abd_l."'".$readonly;?>></td>
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
															<td><input name = 'ir_dep_r' class="form-control" placeholder="Right IR (depression)" value = <?php if($set_strabduc == 1) echo "'".$ir_dep_r."'".$readonly;?>></td>
															<td><input name = 'ir_dep_l' class="form-control" placeholder="Left IR (depression)" value = <?php if($set_strabduc == 1) echo "'".$ir_dep_l."'".$readonly;?>></td>
														</tr>
														<tr>
															<th>Adduction</th>
															<td><input name = 'ir_add_r' class="form-control" placeholder="Right IR (abduction)" value = <?php if($set_strabduc == 1) echo "'".$ir_add_r."'".$readonly;?>></td>
															<td><input name = 'ir_add_l' class="form-control" placeholder="Left IR (depression)" value = <?php if($set_strabduc == 1) echo "'".$ir_add_l."'".$readonly;?>></td>
														</tr>
														<tr>
															<th>Excyclotorsion</th>
															<td><input name = 'ir_excyc_r' class="form-control" placeholder="Right IR (excyclotorsion)" value = <?php if($set_strabduc == 1) echo "'".$ir_excyc_r."'".$readonly;?>></td>
															<td><input name = 'ir_excyc_l' class="form-control" placeholder="Left IR (excyclotorsion)" value = <?php if($set_strabduc == 1) echo "'".$ir_excyc_l."'".$readonly;?>></td>
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
															<td><input name = 'io_excyc_r' class="form-control" placeholder="Right IO (excyclotorsion)" value = <?php if($set_strabduc == 1) echo "'".$io_excyc_r."'".$readonly;?>></td>
															<td><input name = 'io_excyc_l' class="form-control" placeholder="Left IO (excyclotorsion)" value = <?php if($set_strabduc == 1) echo "'".$io_excyc_l."'".$readonly;?>></td>
														</tr>
														<tr>
															<th>Upgaze</th>
															<td><input name = 'io_upgaze_r' class="form-control" placeholder="Right IO (upgaze)" value = <?php if($set_strabduc == 1) echo "'".$io_upgaze_r."'".$readonly;?>></td>
															<td><input name = 'io_upgaze_l' class="form-control" placeholder="Left IO (upgaze)" value = <?php if($set_strabduc == 1) echo "'".$io_upgaze_l."'".$readonly;?>></td>
														</tr>
														<tr>
															<th>Abduction</th>
															<td><input name = 'io_abd_r' class="form-control" placeholder="Right IO (abduction)" value = <?php if($set_strabduc == 1) echo "'".$io_abd_r."'".$readonly;?>></td>
															<td><input name = 'io_abd_l' class="form-control" placeholder="Left IO (abduction)" value = <?php if($set_strabduc == 1) echo "'".$io_abd_l."'".$readonly;?>></td>
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
															<td><input name = 'sr_upgaze_r' class="form-control" placeholder="Right SR (upgaze)" value = <?php if($set_strabduc == 1) echo "'".$sr_upgaze_r."'".$readonly;?>></td>
															<td><input name = 'sr_upgaze_l' class="form-control" placeholder="Left SR (upgaze)" value = <?php if($set_strabduc == 1) echo "'".$sr_upgaze_l."'".$readonly;?>></td>
														</tr>
														<tr>
															<th>Adduction</th>
															<td><input name = 'sr_add_r' class="form-control" placeholder="Right SR (abduction)" value = <?php if($set_strabduc == 1) echo "'".$sr_add_r."'".$readonly;?>></td>
															<td><input name = 'sr_add_l' class="form-control" placeholder="Left SR (abduction)" value = <?php if($set_strabduc == 1) echo "'".$sr_add_l."'".$readonly;?>></td>
														</tr>
														<tr>
															<th>Incyclotorsion</th>
															<td><input name = 'sr_incyc_r' class="form-control" placeholder="Right SR (incyclotorsion)" value = <?php if($set_strabduc == 1) echo "'".$sr_incyc_r."'".$readonly;?>></td>
															<td><input name = 'sr_incyc_l' class="form-control" placeholder="Left SR (incyclotorsion)" value = <?php if($set_strabduc == 1) echo "'".$sr_incyc_l."'".$readonly;?>></td>
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
															<td><input name = 'so_incyc_r' class="form-control" placeholder="Right SO (intorsion)" value = <?php if($set_strabduc == 1) echo "'".$so_incyc_r."'".$readonly;?>></td>
															<td><input name = 'so_incyc_l' class="form-control" placeholder="Left SO (intorsion)" value = <?php if($set_strabduc == 1) echo "'".$so_incyc_l."'".$readonly;?>></td>
														</tr>
														<tr>
															<th>Downgaze</th>
															<td><input name = 'so_downgaze_r' class="form-control" placeholder="Right SO (downgaze)" value = <?php if($set_strabduc == 1) echo "'".$so_downgaze_r."'".$readonly;?>></td>
															<td><input name = 'so_downgaze_l' class="form-control" placeholder="Left SO (downgaze)" value = <?php if($set_strabduc == 1) echo "'".$so_downgaze_l."'".$readonly;?>></td>
														</tr>
														<tr>
															<th>Abduction</th>
															<td><input name = 'so_abd_r' class="form-control" placeholder="Right SO (abduction)" value = <?php if($set_strabduc == 1) echo "'".$so_abd_r."'".$readonly;?>></td>
															<td><input name = 'so_abd_l' class="form-control" placeholder="Left SO (abduction)" value = <?php if($set_strabduc == 1) echo "'".$so_abd_l."'".$readonly;?>></td>
														</tr>
													</tbody>
												</table>
												<?php if($editme == 'strabd' || $set_strabduc != 1) echo "<input type = 'submit' class='btn btn-primary' name ='save_strabduc' value = 'Save'/>";?>
											</div>
										</div>
									</div>
								</form>
								</div>
								<!--STRABFUSAMP-->
								<div class="panel panel-default">
									<form class="form-horizontal" method='post' <?php if($editme == 'strabf' || $set_strabfusamp != 1) echo "";?>>
									<h4 class="panel-title">
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseStrabFusAmp">
											<div class = <?php if($set_strabfusamp == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
											<div class = "panel-heading">
												<b>Fusional Amplitude</b>
											</div></div>
										</a>
									</h4>
						  
									<div id="collapseStrabFusAmp" class = <?php if($editme == 'strabf') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
										<div class="panel-body">
										   <div class="col-lg-12">
												<table class="table table-bordered">
													<?php if($set_strabfusamp == 1) {?>
													<tr><td colspan = '3'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_strabf' value = 'Edit' />
														<input type = 'hidden' name = 'set' value = 'strabf' />
														<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
														<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
														<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
													<?php }?>
													<tbody>
													<tr>
														<th>Date of Consult</th>
														<td colspan = 3><input type = "date" class="form-control" required name='date_strabf' value = <?php if($set_strabfusamp == 1) echo $date_strabf.$readonly; ?>/> </td>
													</tr>
													<tr>
														<th>Divergence Distance (Base In)</th>
														<td><input name = 'div_dist' class="form-control" placeholder = "Divergence Distance (Base In)" value = <?php if($set_strabfusamp == 1) echo "'".$div_dist."'".$readonly; ?> ></td>
													</tr>
													<tr>
														<th>Convergence Distance (Base Out)</th>
														<td><input name = 'conv_dist' class="form-control" placeholder = "Convergence Distance (Base Out)" value = <?php if($set_strabfusamp == 1) echo "'".$conv_dist."'".$readonly; ?> ></td>
													</tr>
													<tr>
														<th>Sursumvergence (Base Up)</th>
														<td><input name = 'sursumverge' class="form-control" placeholder = "Sursumvergence (Base Up)" value = <?php if($set_strabfusamp == 1) echo "'".$sursumverge."'".$readonly; ?>></td>
													</tr>
													<tr>
														<th>Cyclovergence (Extorsion)</th>
														<td><input name = 'cyclover_ext' class="form-control" placeholder = "Cyclovergence (Extorsion)" value = <?php if($set_strabfusamp == 1) echo "'".$cyclover_ext."'".$readonly; ?> ></td>
													</tr>
													<tr>
														<th>Divergence Near (Base In)</th>
														<td><input name = 'div_near' class="form-control" placeholder = "Divergence Near (Base In)" value = <?php if($set_strabfusamp == 1) echo "'".$div_near."'".$readonly; ?>></td>
													</tr>
													<tr>
														<th>Convergence Near (Base Out)</th>
														<td><input name = 'conv_near' class="form-control" placeholder = "Convergence Near (Base Out)" value = <?php if($set_strabfusamp == 1) echo "'".$conv_near."'".$readonly; ?>></td>
													</tr>
													<tr>
														<th>Deosursumvergence (Base Down)</th>
														<td><input name = 'deosursumverge' class="form-control" placeholder = "Deosursumvergence (Base Down)" value = <?php if($set_strabfusamp == 1) echo "'".$deosursumverge."'".$readonly; ?>></td>
													</tr>
													<tr>
														<th>Cyclovergence (Intorsion)</th>
														<td><input name = 'cyclover_int' class="form-control" placeholder = "Cyclovergence (Intorsion)" value = <?php if($set_strabfusamp == 1) echo "'".$cyclover_int."'".$readonly; ?> ></td>
													</tr>
													</tbody>
												</table>
												<?php if($editme == 'strabf' || $set_strabfusamp != 1) echo "<input type = 'submit' class='btn btn-primary' name ='save_strabfusamp' value = 'Save'/>";?>
										   </div>
										</div>
									</div>
									</form>
								</div>
								<!--STRABMEA-->
								<div class="panel panel-default">
									<form class="form-horizontal" method='post' <?php if($editme == 'strabm' || $set_strabmea != 1) echo "";?>>
									<h4 class="panel-title">
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseStrabMea">
											<div class = <?php if($set_strabmea == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
											<div class = "panel-heading">
												<b>Measurements</b>
											</div></div>
										</a>
									</h4>
						  
									<div id="collapseStrabMea" class = <?php if($editme == 'strabm') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
										<div class="panel-body">
										   <div class="col-lg-12">
												<table class="table table-bordered">
													<?php if($set_strabmea == 1) {?>
													<tr><td colspan = '3'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_strabm' value = 'Edit' />
														<input type = 'hidden' name = 'set' value = 'strabm' />
														<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
														<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
														<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
													<?php }?>
													<tbody>
													<tr>
														<th>Date of Consult</th>
														<td colspan = 3><input type = "date" class="form-control" name='date_strabm' required value = <?php if($set_strabmea == 1) echo $date_strabm.$readonly; ?>/> </td>
													</tr>
													<tr>
														<th></th>
														<th class = "success"><center> Remarks </center></th>
													</tr>
													<tr>
														<th>1 Version (Up and Right)</th>
														<td><input name = 'strabM1' class="form-control" placeholder="1 Version (Up and Right)" value = <?php if($set_strabmea == 1) echo "'".$strabM1."'".$readonly; ?>></td>
													</tr>
													<tr>
														<th>2 Version (Straight Up)</th>
														<td><input name = 'strabM2' class="form-control" placeholder="2 Version (Straight Up)" value = <?php if($set_strabmea == 1) echo "'".$strabM2."'".$readonly; ?>></td>
													</tr>
													<tr>
														<th>3 Version (Up and Left)</th>
														<td><input name = 'strabM3' class="form-control" placeholder="3 Version (Up and Left)" value = <?php if($set_strabmea == 1) echo "'".$strabM3."'".$readonly; ?>></td>
													</tr>
													<tr>
														<th>4 Version (Right)</th>
														<td><input name = 'strabM4' class="form-control" placeholder="4 Version (Right)" value = <?php if($set_strabmea == 1) echo "'".$strabM4."'".$readonly; ?>></td>
													</tr>
													<tr>
														<th>5 Version (Straight)</th>
														<td><input name = 'strabM5' class="form-control" placeholder="5 Version (Straight)" value = <?php if($set_strabmea == 1) echo "'".$strabM5."'".$readonly; ?>></td>
													</tr>
													<tr>
														<th>6 Version (Left)</th>
														<td><input name = 'strabM6' class="form-control" placeholder="6 Version (Left)" value = <?php if($set_strabmea == 1) echo "'".$strabM6."'".$readonly; ?>></td>
													</tr>
													<tr>
														<th>7 Version (Down and Right)</th>
														<td><input name = 'strabM7' class="form-control" placeholder="7 Version (Down and Right)" value = <?php if($set_strabmea == 1) echo "'".$strabM7."'".$readonly; ?>></td>
													</tr>
													<tr>
														<th>8 Version (Straight Down)</th>
														<td><input name = 'strabM8' class="form-control" placeholder="8 Version (Straight Down)" value = <?php if($set_strabmea == 1) echo "'".$strabM8."'".$readonly; ?>></td>
													</tr>
													<tr>
														<th>9 Version (Down and Left)</th>
														<td><input name = 'strabM9' class="form-control" placeholder="9 Version (Down and Left)" value = <?php if($set_strabmea == 1) echo "'".$strabM9."'".$readonly; ?>></td>
													</tr>
													<tr>
														<th>Right Tilt</th>
														<td><input name = 'Mtilt_r' class="form-control" placeholder="Right Tilt" value = <?php if($set_strabmea == 1) echo "'".$Mtilt_r."'".$readonly; ?>></td>
													</tr>
													<tr>
														<th>Left Tilt</th>
														<td><input name = 'Mtilt_l' class="form-control" placeholder="Left Tilt" value = <?php if($set_strabmea == 1) echo "'".$Mtilt_l."'".$readonly; ?>></td>
													</tr>
													<tr>
														<th>Strabismus Measurement in AHP (distance)</th>
														<td><input name = 'strabM_ahp_dist' class="form-control" placeholder="Strabismus Measurement in AHP (distance)" value = <?php if($set_strabmea == 1) echo "'".$strabM_ahp_dist."'".$readonly; ?>></td>
													</tr>
													<tr>
														<th>Strabismus Measurement Primary Distance</th>
														<td><input name = 'strabM_primaryDist' class="form-control" placeholder="Strabismus Measurement Forced" value = <?php if($set_strabmea == 1) echo "'".$strabM_primaryDist."'".$readonly; ?>></td>
													</tr>
													<tr>
														<th>Strabismus Measurement in AHP (near)</th>
														<td><input name = 'strabM_ahp_near' class="form-control" placeholder="Strabismus Measurement in AHP (near)" value = <?php if($set_strabmea == 1) echo "'".$strabM_ahp_near."'".$readonly; ?>></td>
													</tr>
													<tr>
														<th>Strabismus Measurement Primary Near</th>
														<td><input name = 'strabM_primaryNear' class="form-control" placeholder="Strabismus Measurement Primary Gaze" value = <?php if($set_strabmea == 1) echo "'".$strabM_primaryNear."'".$readonly; ?>></td>
													</tr>
													<tr>
														<th>Strabismus Measurement Downgaze Near</th>
														<td><input name = 'strabM_downgazeNear' class="form-control" placeholder="Strabismus Measurement Downgaze Near" value = <?php if($set_strabmea == 1) echo "'".$strabM_downgazeNear."'".$readonly; ?>></td>
													</tr>
													<tr>
														<td colspan=3></td>
													</tr>
													</tbody>
												</table>
												<?php if($editme == 'strabm' || $set_strabmea != 1) echo "<input type = 'submit' class='btn btn-primary' name ='save_strabmea' value = 'Save'/>";?>
										   </div>
										</div>
									</div>
									</form>
								</div>
								<!--STRABVer-->
								<div class="panel panel-default">
									<form class="form-horizontal" method='post' <?php if($editme == 'strabv' || $set_strabver != 1) echo "";?>>
									<h4 class="panel-title">
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseStrabVer">
											<div class = <?php if($set_strabver == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
											<div class = "panel-heading">
												<b>Version</b>
											</div></div>
										</a>
									</h4>
						  
									<div id="collapseStrabVer" class = <?php if($editme == 'strabv') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
										<div class="panel-body">
										   <div class="col-lg-12">
												<table class="table table-bordered" colspan = "5">
													<?php if($set_strabver == 1) {?>
													<tr><td colspan = '3'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_strabv' value = 'Edit' />
														<input type = 'hidden' name = 'set' value = 'strabv' />
														<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
														<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
														<input type = 'submit' class = 'btn btn-lg btn-danger' type = "submit" name = 'print_me' value = 'Save as Pdf' /></td></tr>
													<?php }?>
													<tbody>
                                    <tr>
										<th>Date of Consult</th>
										<td colspan = 3><input type = "date" class="form-control" name='date_strabv' required value = <?php if($set_strabver == 1) echo $date_strabv.$readonly; ?>/> </td>
									</tr>
													<tr>
														<th></th>
														<th class = "success" colspan = 4><center> Remarks </center></th>
													</tr>
													<tr>
														<th>Near Point of Convergence</th>
														<td colspan = 2><input name = 'nearPOC' class="form-control" placeholder="Near Point of Convergence" value = <?php if($set_strabver == 1) echo "'".$nearPOC."'".$readonly; ?>></td>
													</tr>													
													</tbody>
												</table>
												<table class="table table-bordered">
													<tbody>
														<?php 
															$ctr = 0;
															if (isset($scans_arr_strabver)) {
														?>
														<tr>
															<th class="active" colspan="3"><center>Scanned Documents</center></th>
														</tr>
														<?php
																foreach ($scans_arr_strabver as $scan) {
																	if ($ctr % 2 == 0) {
																		echo "<tr>";
																	}
																	echo "<td><div class='well alert'>";
																	echo "<input type='hidden' name='strabver_name_".$ctr."' value='".$scan->image_name."'>";
																	echo "<div class='row'><div class='col-md-12 text-primary'><center>".strtoupper($scan->image_name)."</h6><center></div></div>";
																	echo "<div class='row'><div class='col-md-12'><center><img src = '".$scan->image_path."' height='200px' width='340px'></center></div></div>";
																	echo "<div class='row'><div class='col-md-12'><input type='hidden' name='strabver_id_".$ctr."' value=".$scan->image_id."><input type='text' name='strabver_img_".$ctr."' class='form-control' placeholder='Findings' value='".$scan->image_comments."'".$readonly."></div></div>";
																	echo "</div></td>";
																	if ($ctr % 2 == 1) {
																		echo "</tr>";
																	}
																	$ctr++;
																}
															}
															echo "<input type='hidden' name='strabver_count' value=".$ctr.">";
														?>
													</tbody>
												</table>
												<?php if($editme == 'strabv' || $set_strabver != 1) echo "<input type = 'submit' class='btn btn-primary' name ='save_strabver' value = 'Save'/>";?>
										   </div>
										</div>
									</div>
									</form>
								</div>
								</div>
							</div>
						</div>
					</div><!--END COLLAPSE STRAB-->
				</div>
				<!--STEREO-->
				<div class="panel panel-default">
               		<form class="form-horizontal" method='post' <?php if($editme == 'stereo'|| $set_stereo != 1) echo "";?>>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseStereo">
							<div class = <?php if($set_stereo== 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
							<div class = "panel-heading">
								<b>Stereoacuity</b>
							</div></div>
						</a>
					</h4>						  
					<div id="collapseStereo" class="panel-collapse collapse collapse">
						<div class="panel-body">
						   <div class="col-lg-12">
								<table class="table table-bordered">
									<?php if($set_stereo == 1) {?>
										<tr><td colspan = '4'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_stereo' value = 'Edit' />
										<input type = 'hidden' name = 'set' value = 'stereo' />
										<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
										<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
										<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
									<?php }?>
									<tbody>
                                    <tr>
										<th>Date of Consult</th>
										<td colspan = 5><input type = "date" class="form-control" name='date_stereo' required value = <?php if($set_stereo == 1) echo $date_stereo.$readonly; ?>/> </td>
									</tr>
									<tr>
										<th class = "success">Distance Stereo Test</th>
										<td class = "success"><input name = 'stereo_dist_test' class="form-control" placeholder = "Stereo Distance Test" value = <?php if($set_stereo == 1) echo "'".$stereo_dist_test."'".$readonly; ?>></td>

										<th class = "success">Result Distance</th>
										<td class = "success"><input name = 'stereo_dist_result' class="form-control" placeholder = "Distance Test Result" value = <?php if($set_stereo == 1) echo "'".$stereo_dist_result."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th class = "warning">Near Stereo Test</th>
										<td class = "warning"><input name = 'stereo_near_test' class="form-control" placeholder = "Stereo Near Test" value = <?php if($set_stereo == 1) echo "'".$stereo_near_test."'".$readonly; ?>></td>
										<th class = "warning">
										Result Near Stereo</th>
										<td class = "warning">
										<input name = 'stereo_near_result' class="form-control" placeholder = "Near Test Result" value = <?php if($set_stereo == 1) echo "'".$stereo_near_result."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th class = "">Stereoacuity</th>
										<td colspan = 3><textarea name = "stereoacuity" class = "form-control" rows = 1 maxlength = 500  style = "overflow:auto;resize:none" <?php if($set_stereo == 1) echo " readonly>".$stereoacuity; else echo "placeholder = 'Stereoacuity'>";?></textarea></td>
									</tr>
									<tr>
										<th class = "success">Remarks</th>
										<td colspan = 3>
										<textarea name = "stereo_remarks" class = "form-control" rows = 1 maxlength = 100  style = "overflow:auto;resize:none" <?php if($set_stereo == 1) echo " readonly>".$stereo_remarks; else echo "placeholder = 'Stereo Remarks'>";?></textarea>
										</td>
									</tr>
									</tbody>
								</table>
								 <?php if($editme == 'stereo' || $set_stereo != 1) echo "<input type = 'submit' class='btn btn-primary' name ='save_stereo' value = 'Save'/>";?>
						   </div>
						</div>
					</div>
					</form>
				</div>
				<!--POSTPOLE-->
				<div class="panel panel-default">
            		<form class="form-horizontal" method='post' <?php if($editme == 'post'|| $set_post != 1) echo "";?>>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapsePostPole">
							<div class = <?php if($set_post == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
							<div class = "panel-heading">
								<b>Posterior Pole</b>
							</div></div>
						</a>
					</h4>
					<div id="collapsePostPole" class = <?php if($editme == 'post') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
						<div class="panel-body">
						   <div class="col-lg-12">
								<table class="table table-bordered">
									<?php if($set_post == 1) {?>
										<tr><td colspan = '3'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_post' value = 'Edit' />
										<input type = 'hidden' name = 'set' value = 'post' />
										<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
										<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
										<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
									<?php }?>
									<tbody>
                                    <tr>
										<th>Date of Consult</th>
										<td colspan = 3><input type = "date" class="form-control" name='date_postpole' required value = <?php if($set_post == 1) echo $date_postpole.$readonly; ?>/> </td>
									</tr>
										<tr>
										<th class = "success">Instrument</th>
										<td colspan=2><input name = 'PostPoleInstrument' class="form-control" placeholder = "Posterior Pole Instrument" value = <?php if($set_post == 1) echo "'".$PostPoleInstrument."'".$readonly; ?>></td>
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
											<td><input name = 'zone1_optic_r' class="form-control" placeholder="Right Zone 1 Optic Nerve" value = <?php if($set_post == 1) echo "'".$zone1_optic_r."'".$readonly; ?>></td>
											<td><input name = 'zone1_optic_l' class="form-control" placeholder="Left Zone 1 Optic Nerve" value = <?php if($set_post == 1) echo "'".$zone1_optic_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Retinal Arcade</th>
											<td><input name = 'zone1_retinal_r' class="form-control" placeholder="Right Zone 1 Retinal Arcade" value = <?php if($set_post == 1) echo "'".$zone1_retinal_r."'".$readonly; ?>></td>
											<td><input name = 'zone1_retinal_l' class="form-control" placeholder="Left Zone 1 Retinal Arcade" value = <?php if($set_post == 1) echo "'".$zone1_retinal_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Macula</th>
											<td><input name = 'zone1_macula_r' class="form-control" placeholder="Right Zone 1 Macula" value = <?php if($set_post == 1) echo "'".$zone1_macula_r."'".$readonly; ?>></td>
											<td><input name = 'zone1_macula_l' class="form-control" placeholder="Left Zone 1 Macula" value = <?php if($set_post == 1) echo "'".$zone1_macula_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Vitreous</th>
											<td><input name = 'zone1_vitreous_r' class="form-control" placeholder="Right Zone 1 Vitreous" value = <?php if($set_post == 1) echo "'".$zone1_vitreous_r."'".$readonly; ?>></td>
											<td><input name = 'zone1_vitreous_l' class="form-control" placeholder="Left Zone 1 Vitreous" value = <?php if($set_post == 1) echo "'".$zone1_vitreous_l."'".$readonly; ?>></td>
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
											<td><input name = 'zone2_branch_r' class="form-control" placeholder="Right Zone 2 Branching" value = <?php if($set_post == 1) echo "'".$zone2_branch_r."'".$readonly; ?>></td>
											<td><input name = 'zone2_branch_l' class="form-control" placeholder="Left Zone 2 Branching" value = <?php if($set_post == 1) echo "'".$zone2_branch_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Artery</th>
											<td><input name = 'zone2_artery_r' class="form-control" placeholder="Right Zone 2 Artery" value = <?php if($set_post == 1) echo "'".$zone2_artery_r."'".$readonly; ?>></td>
											<td><input name = 'zone2_artery_l' class="form-control" placeholder="Left Zone 2 Artery" value = <?php if($set_post == 1) echo "'".$zone2_artery_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Veins</th>
											<td><input name = 'zone2_veins_r' class="form-control" placeholder="Right Zone 2 Veins" value = <?php if($set_post == 1) echo "'".$zone2_veins_r."'".$readonly; ?>></td>
											<td><input name = 'zone2_veins_l' class="form-control" placeholder="Left Zone 2 Veins" value = <?php if($set_post == 1) echo "'".$zone2_veins_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Vortex Veins</th>
											<td><input name = 'zone2_vortex_r' class="form-control" placeholder="Right Zone 2 Vortex Veins" value = <?php if($set_post == 1) echo "'".$zone2_vortex_r."'".$readonly; ?>></td>
											<td><input name = 'zone2_vortex_l' class="form-control" placeholder="Left Zone 2 Vortex Veins" value = <?php if($set_post == 1) echo "'".$zone2_vortex_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Vitreous</th>
											<td><input name = 'zone2_vitreous_r' class="form-control" placeholder="Right Zone 2 Vitreous" value = <?php if($set_post == 1) echo "'".$zone2_vitreous_r."'".$readonly; ?>></td>
											<td><input name = 'zone2_vitreous_l' class="form-control" placeholder="Left Zone 2 Vitreous" value = <?php if($set_post == 1) echo "'".$zone2_vitreous_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Retinal Arcade</th>
											<td><input name = 'zone2_retinal_r' class="form-control" placeholder="Right Zone 2 Retinal Arcade" value = <?php if($set_post == 1) echo "'".$zone2_retinal_r."'".$readonly; ?>></td>
											<td><input name = 'zone2_retinal_l' class="form-control" placeholder="Left Zone 2 Retinal Arcade" value = <?php if($set_post == 1) echo "'".$zone2_retinal_l."'".$readonly; ?>></td>
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
											<td><input name = 'zone3_retina_r' class="form-control" placeholder="Right Zone 3 Retina" value = <?php if($set_post == 1) echo "'".$zone3_retina_r."'".$readonly; ?>></td>
											<td><input name = 'zone3_retina_l' class="form-control" placeholder="Left Zone 3 Retina" value = <?php if($set_post == 1) echo "'".$zone3_retina_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Vessels</th>
											<td><input name = 'zone3_vessels_r' class="form-control" placeholder="Right Zone 3 Vessels" value = <?php if($set_post == 1) echo "'".$zone3_vessels_r."'".$readonly; ?>></td>
											<td><input name = 'zone3_vessels_l' class="form-control" placeholder="Left Zone 3 Vessels" value = <?php if($set_post == 1) echo "'".$zone3_vessels_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Vitreous</th>
											<td><input name = 'zone3_vitreous_r' class="form-control" placeholder="Right Zone 3 Vitreous" value = <?php if($set_post == 1) echo "'".$zone3_vitreous_r."'".$readonly; ?>></td>
											<td><input name = 'zone3_vitreous_l' class="form-control" placeholder="Left Zone 3 Vitreous" value = <?php if($set_post == 1) echo "'".$zone3_vitreous_l."'".$readonly; ?>></td>
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
											<td><input name = 'PostPole_other_r' class="form-control" placeholder="Right Posterior Other Findings" value = <?php if($set_post == 1) echo "'".$PostPole_other_r."'".$readonly; ?>></td>
											<td><input name = 'PostPole_other_l' class="form-control" placeholder="Left Posterior Other Findings" value = <?php if($set_post == 1) echo "'".$PostPole_other_l."'".$readonly; ?>></td>
										</tr>
									</tbody>
								</table>
								<?php if($editme == 'post' || $set_post != 1) echo "<input type = 'submit' class='btn btn-primary' name ='save_post' value = 'Save'/>";?>
						   </div>
						</div>
					</div>
					</form>
				</div>
			</div><!--END COLLAPSE EYE EXAM GROUP-->
		</div>
	</div>
	
	<!--ANCILLARY TEST-->
	<div class="panel">
		<header class="panel-heading">
			<h2 class="">ANCILLARY TEST</h2>
		</header>
		<div class = "panel-body">
			<div class="panel-group m-bot20" id="accordion">
				<!--IOP-->
				<div class="panel panel-default">
					<form class="form-horizontal" method='post' <?php if($editme == 'iop' || $set_anci_iop != 1) echo "onSubmit='return confirm(\"Do you really want to submit the form?\")'";?>>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseIntraPre">
							<div class = <?php if($set_anci_iop == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
							<div class = "panel-heading">
								<b>Intraocular Pressure</b>
							</div></div>
						</a>
					</h4>

					<div id="collapseIntraPre" class = <?php if($editme == 'iop') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
						<div class="panel-body">
							<div class="col-lg-12">
								<table class="table table-bordered">
									<?php if($set_anci_iop == 1) {?>
										<tr><td colspan = '3'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_iop' value = 'Edit' />
										<input type = 'hidden' name = 'set' value = 'iop' />
										<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
										<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
										<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
									<?php }?>
									<tbody>
										<tr>
											<th>Date of Consult</th>
											<td colspan = 3><input type = "date" class="form-control" name='date_iop' required value = <?php if($set_anci_iop == 1) echo $date_iop.$readonly; ?>/> </td>
										</tr>
										<tr>
											<th></th>
											<th class = "success">RIGHT</th>
											<th class = "warning">LEFT</th>
										</tr>
										<tr>
											<th>Finger Palpation</th>
											<td><input type="text" name = 'FingerPalp_r' class="form-control" placeholder="Right Finger Palpation" value = <?php if($set_anci_iop == 1) echo "'".$FingerPalp_r."'".$readonly; ?>></td>
											<td><input type="text" name = 'FingerPalp_l' class="form-control" placeholder="Left Finger Palpation" value = <?php if($set_anci_iop == 1) echo "'".$FingerPalp_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>IOP (Perkins)</th>
											<td><input name = 'iop_Perkins_r' class="form-control" placeholder="Right IOP (Perkins)" value = <?php if($set_anci_iop == 1) echo "'".$iop_Perkins_r."'".$readonly; ?>></td>
											<td><input name = 'iop_Perkins_l' class="form-control" placeholder="Left IOP (Perkins)" value = <?php if($set_anci_iop == 1) echo "'".$iop_Perkins_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>IOP (Icare)</th>
											<td><input name = 'iop_Icare_r' class="form-control" placeholder="Right IOP (Icare)" value = <?php if($set_anci_iop == 1) echo "'".$iop_Icare_r."'".$readonly; ?>></td>
											<td><input name = 'iop_Icare_l' class="form-control" placeholder="Left IOP (Icare)" value = <?php if($set_anci_iop == 1) echo "'".$iop_Icare_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>IOP (Goldmann)</th>
											<td><input name = 'iop_Goldmann_r' class="form-control" placeholder="Right IOP (Goldmann)" value = <?php if($set_anci_iop == 1) echo "'".$iop_Goldmann_r."'".$readonly; ?>></td>
											<td><input name = 'iop_Goldmann_l' class="form-control" placeholder="Left IOP (Goldmann)" value = <?php if($set_anci_iop == 1) echo "'".$iop_Goldmann_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>IOP (Shiotz)</th>
											<td><input name = 'iop_Shiotz_r' class="form-control" placeholder="Right IOP (Shiotz)" value = <?php if($set_anci_iop == 1) echo "'".$iop_Shiotz_r."'".$readonly; ?>></td>
											<td><input name = 'iop_Shiotz_l' class="form-control" placeholder="Left IOP (Shiotz)" value = <?php if($set_anci_iop == 1) echo "'".$iop_Shiotz_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>IOP (Tonopen)</th>
											<td><input name = 'iop_Tonopen_r' class="form-control" placeholder="Right IOP (Tonopen)" value = <?php if($set_anci_iop == 1) echo "'".$iop_Tonopen_r."'".$readonly; ?>></td>
											<td><input name = 'iop_Tonopen_l' class="form-control" placeholder="Left IOP (Tonopen)" value = <?php if($set_anci_iop == 1) echo "'".$iop_Tonopen_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>IOP (others)</th>
											<td><input name = 'iop_other_r' class="form-control" placeholder="Right IOP (others)" value = <?php if($set_anci_iop == 1) echo "'".$iop_other_r."'".$readonly; ?>></td>
											<td><input name = 'iop_other_l' class="form-control" placeholder="Left IOP (others)" value = <?php if($set_anci_iop == 1) echo "'".$iop_other_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th>Type of Instrument used for Others</th>
											<td><input name = 'iop_otherInstrument_r' class="form-control" placeholder="Right Type of Instrument used for Others" value = <?php if($set_anci_iop == 1) echo "'".$iop_otherInstrument_r."'".$readonly; ?>></td>
											<td><input name = 'iop_otherInstrument_l' class="form-control" placeholder="Left Type of Instrument used for Others" value = <?php if($set_anci_iop == 1) echo "'".$iop_otherInstrument_l."'".$readonly; ?>></td>
										</tr>
										<tr>
											<td colspan=3></td>
										</tr>
										<tr>
											<th class = "success">IOP Remarks</th>
											<td colspan = 2><textarea name = "iop_remarks" class = "form-control" rows = 1 maxlength = 45  style = "overflow:auto;resize:none" <?php if($set_anci_iop == 1) echo " readonly>".$iop_remarks; else echo "placeholder = 'IOP Remarks'>";?></textarea></td>
										</tr>
									</tbody>
								</table>
								 <?php if($editme == 'iop' || $set_anci_iop != 1) echo "<input type = 'submit' class='btn btn-primary' type='submit' name ='save_anci_iop' value = 'Save'/>";?>
							</div>
						</div>
					</div>
					</form>
				</div>
				<!--COLOR-->
				<div class="panel panel-default">
					<form class="form-horizontal" method='post' <?php if($editme == 'color' || $set_anci_color != 1) echo "onSubmit='return confirm(\"Do you really want to submit the form?\")'";?>>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseColor">
							<div class = <?php if($set_anci_color == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
							<div class = "panel-heading">
								<b>Color Test</b>
							</div></div>
						</a>
					</h4>
					<div id = "collapseColor" class = <?php if($editme == 'color') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
						<div class = "panel-body">
							<div class = "col-lg-12">
								<table class = "table table-bordered">
									<?php if($set_anci_color == 1) {?>
										<tr><td colspan = '4'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_color' value = 'Edit' />
										<input type = 'hidden' name = 'set' value = 'color' />
										<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
										<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
										<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
									<?php }?>
									<tbody>
										<tr>
											<th>Date of Consult</th>
											<td colspan = 3><input type = "date" class="form-control" name='date_color' required value = <?php if($set_anci_color == 1) echo $date_color.$readonly; ?>/></td>
										</tr>
										<tr>
											<th class = "success">Color Test Used</th>
											<td><input name = 'color_test' class="form-control" placeholder="Color Test Used" value = <?php if($set_anci_color == 1) echo "'".$color_test."'".$readonly; ?>></td>
											<th class = "success">Color Institution</th>
											<td><input name = 'colorInstitution' class="form-control" placeholder="Color Institution" value = <?php if($set_anci_color == 1) echo "'".$colorInstitution."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th class = "warning">Right Color Result</th>
											<td><textarea name = "color_result_r" class = "form-control" rows = 1 maxlength = 100  style = "overflow:auto;resize:none" <?php if($set_anci_color == 1) echo " readonly ".$color_result_r. " >"; else echo "placeholder = 'Right Color Result'>";?></textarea>
											</td>
											<th class = "warning">Left Color Result</th>
											<td><textarea name = "color_result_l" class = "form-control" rows = 1 maxlength = 100  style = "overflow:auto;resize:none" <?php if($set_anci_color == 1) echo " readonly>".$color_result_l; else echo "placeholder = 'Left Color Result'>";?></textarea></td>
										</tr>
										<tr>
											<th class = "success">Color Test Reader</th>
											<td colspan = 3><input name = 'color_reader' class="form-control" placeholder="Color Test Reader" value = <?php if($set_anci_color == 1) echo "'".$color_reader."'".$readonly; ?>></td>
										</tr>
										<tr>
											<td colspan = 4></td>
										</tr>
										<tr>
											<th class = "active">Color Remarks</th>
											<td colspan = 3><textarea name = "color_remarks" class = "form-control" rows = 1 maxlength = 100  style = "overflow:auto;resize:none" <?php if($set_anci_color == 1) echo " readonly>".$color_remarks; else echo "placeholder = 'Color Remarks'>";?></textarea></td>
										</tr>
								</tbody>
								</table>
								<?php if($editme == 'color' || $set_anci_color != 1) echo "<input type = 'submit' class='btn btn-primary' type='submit' name ='save_anci_color' value = 'Save'/>";?>
							</div>
						</div>
					</div>
					</form>
				</div>
				<!--UTZ-->
				<div class="panel panel-default">
					<form class="form-horizontal" method='post' <?php if($editme == 'utz' || $set_anci_utz != 1) echo "onSubmit='return confirm(\"Do you really want to submit the form?\")'";?>>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOccUltra">
							<div class = <?php if($set_anci_utz == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
							<div class = "panel-heading">
								<b>Occular Ultrasound</b>
							</div></div>
						</a>
					</h4>
					
					<div id="collapseOccUltra" class = <?php if($editme == 'color') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
						<div class="panel-body">
						   <div class="col-lg-12">
								<table class="table table-bordered">
									<?php if($set_anci_utz == 1) {?>
										<tr><td colspan = '4'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_utz' value = 'Edit' />
										<input type = 'hidden' name = 'set' value = 'utz' />
										<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
										<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
										<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
									<?php }?>
									<tbody>
									<tr>
										<th>Date of Consult</th>
										<td colspan = 3><input type = "date" class="form-control" name='date_utz' required value = <?php if($set_anci_utz == 1) echo $date_utz.$readonly; ?>/> </td>
									</tr>
									<tr>
										<th class = "success">UTZ Institution</th>
										<td><input name = 'utzInstitution' class="form-control" placeholder="UTZ Institution" value = <?php if($set_anci_utz == 1) echo "'".$utzInstitution."'".$readonly; ?>></td>
										<th class = "success">UTZ Machine Used</th>
										<td><input name = 'utzMachine' class="form-control" placeholder="UTZ Machine Used" value = <?php if($set_anci_utz == 1) echo "'".$utzMachine."'".$readonly; ?>></td>
									</tr>
									<tr>
										<td colspan = 4></td>
									</tr>
									<tr>
										<th class = "active" >UTZ Reader</th>
										<td colspan = 3><input name = 'utzReader' class="form-control" placeholder="UTZ Reader" value = <?php if($set_anci_utz == 1) echo "'".$utzReader."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th class = "success">UTZ Remarks</th>
										<td colspan = 3><textarea name = "utz_remarks" class = "form-control" rows = 1 maxlength = 100  style = "overflow:auto;resize:none" <?php if($set_anci_utz == 1) echo " readonly>".$utz_remarks; else echo "placeholder = 'UTZ Remarks'>";?></textarea></td>
									</tr>
									</tbody>
								</table>
								<table class="table table-bordered">
									<tbody>
										<?php 
											$ctr = 0;
											if (isset($scans_arr_utz)) {
										?>
										<tr>
											<th class="active" colspan="3"><center>Scanned Documents</center></th>
										</tr>
										<?php
												foreach ($scans_arr_utz as $scan) {
													if ($ctr % 2 == 0) {
														echo "<tr>";
													}
													echo "<td><div class='well alert'>";
													echo "<input type='hidden' name='utz_name_".$ctr."' value='".$scan->image_name."'>";
													echo "<div class='row'><div class='col-md-12 text-primary'><center>".strtoupper($scan->image_name)."</h6><center></div></div>";
													echo "<div class='row'><div class='col-md-12'><center><img src = '".$scan->image_path."' height='200px' width='340px'></center></div></div>";
													echo "<div class='row'><div class='col-md-12'><input type='hidden' name='utz_id_".$ctr."' value=".$scan->image_id."><input type='text' name='utz_img_".$ctr."' class='form-control' placeholder='Findings' value='".$scan->image_comments."'".$readonly."></div></div>";
													echo "</div></td>";
													if ($ctr % 2 == 1) {
														echo "</tr>";
													}
													$ctr++;
												}
											}
											echo "<input type='hidden' name='utz_count' value=".$ctr.">";

										?>
									</tbody>
								</table>							
								 <?php if($editme == 'utz' || $set_anci_utz != 1) echo "<input type = 'submit' class='btn btn-primary' type='submit' name ='save_anci_utz' value = 'Save'/>";?>
						   </div>
						</div>
					</div>
					</form>
				</div>
				<!--RETINA_IMAGING-->
				<div class="panel panel-default">
               		<form class="form-horizontal" method='post' <?php if($editme == 'retina' || $set_anci_retina != 1) echo "onSubmit='return confirm(\"Do you really want to submit the form?\")'";?>>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseRetina_img">
							<div class = <?php if($set_anci_retina == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
							<div class = "panel-heading">
								<b>Retina Imaging</b>
							</div></div>
						</a>
					</h4>
					<div id="collapseRetina_img" class = <?php if($editme == 'retina') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
						<div class="panel-body">
						   <div class="col-lg-12">
								<table class="table table-bordered">
									<?php if($set_anci_retina == 1) {?>
										<tr><td colspan = '4'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_retina' value = 'Edit' />
										<input type = 'hidden' name = 'set' value = 'retina' />
										<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
										<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
										<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
									<?php }?>
									<tbody>
                                    <tr>
										<th>Date of Consult</th>
										<td colspan = 3><input type = "date" class="form-control" name='date_retimg' required value = <?php if($set_anci_retina == 1) echo $date_retimg.$readonly; ?>/> </td>
									</tr>
									<tr>
										<th class = "success">Retina Imaging Used</th>
										<td><input name = 'retImg_used' class="form-control" placeholder="Retina Imaging Used" value = <?php if($set_anci_retina == 1) echo "'".$retImg_used."'".$readonly; ?>></td>
										<th class = "success">Retina Imaging Institution</th>
										<td><input name = 'retImg_institution' class="form-control" placeholder="Retina Imaging Institution" value = <?php if($set_anci_retina == 1) echo "'".$retImg_institution."'".$readonly; ?>></td>
									</tr>
									<tr>
										<td colspan = 4></td>
									</tr>
									<tr>
										<th class = "active" >Retina Image Reader</th>
										<td colspan = 3><input name = 'retImg_reader' class="form-control" placeholder="Retina Image Reader" value = <?php if($set_anci_retina == 1) echo "'".$retImg_reader."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th class = "success">Retina Image Remarks</th>
										<td colspan = 3><textarea name = "retImg_remarks" class = "form-control" rows = 1 maxlength = 500  style = "overflow:auto;resize:none" <?php if($set_anci_retina == 1) echo " readonly>".$retImg_remarks; else echo "placeholder = 'Retina Image Remarks'>";?></textarea></td>
									</tr>
									</tbody>
								</table>
								<table class="table table-bordered">
									<tbody>
										<?php 
											$ctr = 0;
											if (isset($scans_arr_retina)) {
										?>
										<tr>
											<th class="active" colspan="3"><center>Scanned Documents</center></th>
										</tr>
										<?php
												foreach ($scans_arr_retina as $scan) {
													if ($ctr % 2 == 0) {
														echo "<tr>";
													}
													echo "<td><div class='well alert'>";
													echo "<input type='hidden' name='retina_name_".$ctr."' value='".$scan->image_name."'>";
													echo "<div class='row'><div class='col-md-12 text-primary'><center>".strtoupper($scan->image_name)."</h6><center></div></div>";
													echo "<div class='row'><div class='col-md-12'><center><img src = '".$scan->image_path."' height='200px' width='340px'></center></div></div>";
													echo "<div class='row'><div class='col-md-12'><input type='hidden' name='retina_id_".$ctr."' value=".$scan->image_id."><input type='text' name='retina_img_".$ctr."' class='form-control' placeholder='Findings' value='".$scan->image_comments."'".$readonly."></div></div>";
													echo "</div></td>";
													if ($ctr % 2 == 1) {
														echo "</tr>";
													}
													$ctr++;
												}												
											}
											echo "<input type='hidden' name='retina_count' value=".$ctr.">";
										?>
									</tbody>
								</table>	
								<?php if($editme == 'retina' || $set_anci_retina != 1) echo "<input type = 'submit' class='btn btn-primary' type='submit' name ='save_anci_retina' value = 'Save'/>";?>
						   </div>
						</div>
					</div>
					</form>
				</div>
				<!--NEUROPHY_VER-->
				<div class="panel panel-default">
               		<form class="form-horizontal" method='post' <?php if($editme == 'ver' || $set_anci_ver != 1) echo "onSubmit='return confirm(\"Do you really want to submit the form?\")'";?>>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseNeuroPhy_ver">
							<div class = <?php if($set_anci_ver == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
							<div class = "panel-heading">
								<b>Neurophysiologic Tests: VER</b>
							</div></div>
						</a>
					</h4>
					<div id="collapseNeuroPhy_ver" class = <?php if($editme == 'ver') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
						<div class="panel-body">
						   <div class="col-lg-12">
								<table class="table table-bordered">
									<?php if($set_anci_ver == 1) {?>
										<tr><td colspan = '4'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_ver' value = 'Edit' />
										<input type = 'hidden' name = 'set' value = 'ver' />
										<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
										<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
										<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
									<?php }?>
									<tbody>
                                    <tr>
										<th>Date of Consult</th>
										<td colspan = 3><input type = "date" class="form-control" name='date_ver' value = <?php if($set_anci_ver == 1) echo $date_ver.$readonly; ?>/> </td>
									</tr>
									<tr>
										<th class = "success">Institution VER</th>
										<td><input name = 'verInstitution' class="form-control" placeholder="Institution VER" value = <?php if($set_anci_ver == 1) echo "'".$verInstitution."'".$readonly; ?>></td>
										<th class = "success">VER Reader</th>
										<td><input name = 'verReader' class="form-control" placeholder="VER Reader" value = <?php if($set_anci_ver == 1) echo "'".$verReader."'".$readonly; ?>></td>
									</tr>
									<tr>
										<td colspan = 4></td>
									</tr>
									<tr>
										<th class = "success">VER Remarks</th>
										<td colspan = 3><textarea name = "ver_remarks" class = "form-control" rows = 1 maxlength = 100  style = "overflow:auto;resize:none" <?php if($set_anci_ver == 1) echo " readonly>".$ver_remarks; else echo "placeholder = 'VER Remarks'>";?></textarea></td>
									</tr>
									</tbody>
								</table>
								<table class="table table-bordered">
									<tbody>
										<?php 
											$ctr = 0;
											if (isset($scans_arr_ver)) {
										?>
										<tr>
											<th class="active" colspan="3"><center>Scanned Documents</center></th>
										</tr>
										<?php
												foreach ($scans_arr_ver as $scan) {
													if ($ctr % 2 == 0) {
														echo "<tr>";
													}
													echo "<td><div class='well alert'>";
													echo "<input type='hidden' name='ver_name_".$ctr."' value='".$scan->image_name."'>";
													echo "<div class='row'><div class='col-md-12 text-primary'><center>".strtoupper($scan->image_name)."</h6><center></div></div>";
													echo "<div class='row'><div class='col-md-12'><center><img src = '".$scan->image_path."' height='200px' width='340px'></center></div></div>";
													echo "<div class='row'><div class='col-md-12'><input type='hidden' name='ver_id_".$ctr."' value=".$scan->image_id."><input type='text' name='ver_img_".$ctr."' class='form-control' placeholder='Findings' value='".$scan->image_comments."'".$readonly."></div></div>";
													echo "</div></td>";
													if ($ctr % 2 == 1) {
														echo "</tr>";
													}
													$ctr++;
												}												
											}
											echo "<input type='hidden' name='ver_count' value=".$ctr.">";
										?>
									</tbody>
								</table>
								<?php if($editme == 'ver' || $set_anci_ver != 1) echo "<input type = 'submit' class='btn btn-primary' type='submit' name ='save_anci_ver' value = 'Save'/>";?>
						   </div>
						</div>
					</div>
					</form>
				</div>
				<!--NEUROPHY_EOG-->
				<div class="panel panel-default">
               		<form class="form-horizontal" method='post' <?php if($editme == 'eog' || $set_anci_eog != 1) echo "onSubmit='return confirm(\"Do you really want to submit the form?\")'";?>>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseNeuroPhy_eog">
							<div class = <?php if($set_anci_eog == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
							<div class = "panel-heading">
								<b>Neurophysiologic Tests: EOG</b>
							</div></div>
						</a>
					</h4>
					<div id="collapseNeuroPhy_eog" class = <?php if($editme == 'eog') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
						<div class="panel-body">
							<div class="col-lg-12">
								<table class="table table-bordered">
									<?php if($set_anci_eog == 1) {?>
										<tr><td colspan = '4'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_eog' value = 'Edit' />
										<input type = 'hidden' name = 'set' value = 'eog' />
										<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
										<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
										<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
									<?php }?>
									<tbody>
										<tr>
										<th>Date of Consult</th>
										<td colspan = 3><input type = "date" class="form-control" name='date_eog' required value = <?php if($set_anci_eog == 1) echo $date_eog.$readonly; ?>/> </td>
									</tr>
									<tr>
										<th class = "success">Institution EOG</th>
										<td><input name = 'eogInstitution' class="form-control" placeholder="Institution EOG" value = <?php if($set_anci_eog == 1) echo "'".$eogInstitution."'".$readonly; ?>></td>
										<th class = "success">EOG Reader</th>
										<td><input name = 'eogReader' class="form-control" placeholder="EOG Reader" value = <?php if($set_anci_eog == 1) echo "'".$eogReader."'".$readonly; ?>></td>
									</tr>
									<tr>
										<td colspan = 4></td>
									</tr>

									<tr>
										<th class = "success">EOG Remarks</th>
										<td colspan = 3><textarea name = "eogRemarks" class = "form-control" rows = 1 maxlength = 100 style = "overflow:auto;resize:none" <?php if($set_anci_eog == 1) echo " readonly>".$eogRemarks; else echo "placeholder = 'EOG Remarks'>";?></textarea></td>
									</tr>
									</tbody>
								</table>
								<table class="table table-bordered">
									<tbody>
										<?php 
											$ctr = 0;
											if (isset($scans_arr_eog)) {
										?>
										<tr>
											<th class="active" colspan="3"><center>Scanned Documents</center></th>
										</tr>
										<?php
												foreach ($scans_arr_eog as $scan) {
													if ($ctr % 2 == 0) {
														echo "<tr>";
													}
													echo "<td><div class='well alert'>";
													echo "<input type='hidden' name='eog_name_".$ctr."' value='".$scan->image_name."'>";
													echo "<div class='row'><div class='col-md-12 text-primary'><center>".strtoupper($scan->image_name)."</h6><center></div></div>";
													echo "<div class='row'><div class='col-md-12'><center><img src = '".$scan->image_path."' height='200px' width='340px'></center></div></div>";
													echo "<div class='row'><div class='col-md-12'><input type='hidden' name='eog_id_".$ctr."' value=".$scan->image_id."><input type='text' name='eog_img_".$ctr."' class='form-control' placeholder='Findings' value='".$scan->image_comments."'".$readonly."></div></div>";
													echo "</div></td>";
													if ($ctr % 2 == 1) {
														echo "</tr>";
													}
													$ctr++;
												}												
											}
											echo "<input type='hidden' name='eog_count' value=".$ctr.">";
										?>
									</tbody>
								</table>
							<?php if($editme == 'eog' || $set_anci_eog != 1) echo "<input type = 'submit' class='btn btn-primary' type='submit' name ='save_anci_eog' value = 'Save'/>";?>
							</div>
						</div>
					</div>
					</form>
				</div>
				<!--OCT_DISC-->
				<div class="panel panel-default">
					<form class="form-horizontal" method='post' <?php if($editme == 'octd' || $set_anci_octd != 1) echo "onSubmit='return confirm(\"Do you really want to submit the form?\")'";?>>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOCTDisc">
							<div class = <?php if($set_anci_octd == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
							<div class = "panel-heading">
								<b>Optical Coherence Tomography (Disc)</b>
							</div></div>
						</a>
					</h4>
					<div id="collapseOCTDisc" class = <?php if($editme == 'octd') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
						<div class="panel-body">
							<div class="col-lg-12">
								<table class="table table-bordered">
									<?php if($set_anci_octd == 1) {?>
										<tr><td colspan = '4'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_octd' value = 'Edit' />
										<input type = 'hidden' name = 'set' value = 'octd' />
										<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
										<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
										<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
									<?php }?>
									<tbody>
										<tr>
											<th>Date of Consult</th>
											<td colspan = 3><input type = "date" class="form-control" name='date_octd' required value = <?php if($set_anci_octd == 1) echo $date_octd.$readonly; ?> /></td>
										</tr>
										<tr>
											<th class = "success">OCT DISC Institution</th>
											<td><input name = 'octD_institution' class="form-control" placeholder="OCT DISC Institution" value = <?php if($set_anci_octd == 1) echo "'".$octD_institution."'".$readonly; ?>></td>
											<th class = "success">OCT DISC Machine</th>
											<td><input name = 'octD_machine' class="form-control" placeholder="OCT DISC Machine" value = <?php if($set_anci_octd == 1) echo "'".$octD_machine."'".$readonly; ?>></td>
										</tr>
										<tr>
											<td colspan = 4></td>
										</tr>
										<tr>
											<th class = "active" >OCT DISC Reader</th>
											<td colspan = 3><input name = 'octD_reader' class="form-control" placeholder="OCT DISC Reader" value = <?php if($set_anci_octd == 1) echo "'".$octD_reader."'".$readonly; ?>></td>
										</tr>
										<tr>
											<th class = "success">OCT DISC Remarks</th>
											<td colspan = 3><textarea name = "octD_remarks" class = "form-control" rows = 1 maxlength = 100 style = "overflow:auto;resize:none" <?php if($set_anci_octd == 1) echo " readonly>".$octD_remarks; else echo "placeholder = 'OCT DISC Remarks'>";?></textarea></td>
										</tr>
									</tbody>
								</table>
								<table class="table table-bordered">
									<tbody>
										<?php 
											$ctr = 0;
											if (isset($scans_arr_octdisc)) {
										?>
										<tr>
											<th class="active" colspan="3"><center>Scanned Documents</center></th>
										</tr>
										<?php
												foreach ($scans_arr_octdisc as $scan) {
													if ($ctr % 2 == 0) {
														echo "<tr>";
													}
													echo "<td><div class='well alert'>";
													echo "<input type='hidden' name='octdisc_name_".$ctr."' value='".$scan->image_name."'>";
													echo "<div class='row'><div class='col-md-12 text-primary'><center>".strtoupper($scan->image_name)."</h6><center></div></div>";
													echo "<div class='row'><div class='col-md-12'><center><img src = '".$scan->image_path."' height='200px' width='340px'></center></div></div>";
													echo "<div class='row'><div class='col-md-12'><input type='hidden' name='octdisc_id_".$ctr."' value=".$scan->image_id."><input type='text' name='octdisc_img_".$ctr."' class='form-control' placeholder='Findings' value='".$scan->image_comments."'".$readonly."></div></div>";
													echo "</div></td>";
													if ($ctr % 2 == 1) {
														echo "</tr>";
													}
													$ctr++;
												}												
											}
											echo "<input type='hidden' name='octdisc_count' value=".$ctr.">";
										?>
									</tbody>
								</table>
								<?php if($editme == 'octd' || $set_anci_octd != 1) echo "<input type = 'submit' class='btn btn-primary' type='submit' name ='save_anci_octd' value = 'Save'/>";?>
							</div>
						</div>
					</div>
					</form>
				</div>
				<!--OCT_MACULA-->
				<div class="panel panel-default">
               		<form class="form-horizontal" method='post' <?php if($editme == 'octm') echo "onSubmit='return confirm(\"Do you really want to submit the form?\")'";?>>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOCTMacula">
							<div class = <?php if($set_anci_octm == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
							<div class = "panel-heading">
								<b>Optical Coherence Tomography (Macula)</b>
							</div></div>
						</a>
					</h4>
					<div id="collapseOCTMacula" class = <?php if($editme == 'octm') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
						<div class="panel-body">
						   <div class="col-lg-12">
								<table class="table table-bordered">
									<?php if($set_anci_octm == 1) {?>
										<tr><td colspan = '4'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_octm' value = 'Edit' />
										<input type = 'hidden' name = 'set' value = 'octm' />
										<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
										<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
										<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
									<?php }?>
									<tbody>
                                    <tr>
										<th>Date of Consult</th>
										<td colspan = 3><input type = "date" class="form-control" name='date_octm' required value = <?php if($set_anci_octm == 1) echo $date_octm.$readonly; ?>/> </td>
									</tr>
									<tr>
										<th class = "success">OCT MACULA Institution</th>
										<td><input name = 'octM_institution' class="form-control" placeholder="OCT MACULA Institution" value = <?php if($set_anci_octm == 1) echo "'".$octM_institution."'".$readonly; ?>></td>
										<th class = "success">OCT MACULA Machine</th>
										<td><input name = 'octM_machine' class="form-control" placeholder="OCT MACULA Machine" value = <?php if($set_anci_octm == 1) echo "'".$octM_machine."'".$readonly; ?>></td>
									</tr>
									<tr>
										<td colspan = 4></td>
									</tr>
									<tr>
										<th class = "active" >OCT MACULA Reader</th>
										<td colspan = 3><input name = 'octM_reader' class="form-control" placeholder="OCT MACULA Reader" value = <?php if($set_anci_octm == 1) echo "'".$octM_reader."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th class = "success">OCT MACULA Remarks</th>
										<td colspan = 3><textarea name = "octM_remarks" class = "form-control" rows = 1 maxlength = 100 style = "overflow:auto;resize:none" <?php if($set_anci_octm == 1) echo " readonly>".$octM_remarks; else echo "placeholder = 'OCT MACULA Remarks'>";?></textarea></td>
									</tr>
									</tbody>
								</table>
								<table class="table table-bordered">
									<tbody>
										<?php 
											$ctr = 0;
											if (isset($scans_arr_octm)) {
										?>
										<tr>
											<th class="active" colspan="3"><center>Scanned Documents</center></th>
										</tr>
										<?php
												foreach ($scans_arr_octm as $scan) {
													if ($ctr % 2 == 0) {
														echo "<tr>";
													}
													echo "<td><div class='well alert'>";
													echo "<input type='hidden' name='octm_name_".$ctr."' value='".$scan->image_name."'>";
													echo "<div class='row'><div class='col-md-12 text-primary'><center>".strtoupper($scan->image_name)."</h6><center></div></div>";
													echo "<div class='row'><div class='col-md-12'><center><img src = '".$scan->image_path."' height='200px' width='340px'></center></div></div>";
													echo "<div class='row'><div class='col-md-12'><input type='hidden' name='octm_id_".$ctr."' value=".$scan->image_id."><input type='text' name='octm_img_".$ctr."' class='form-control' placeholder='Findings' value='".$scan->image_comments."'".$readonly."></div></div>";
													echo "</div></td>";
													if ($ctr % 2 == 1) {
														echo "</tr>";
													}
													$ctr++;
												}												
											}
											echo "<input type='hidden' name='octm_count' value=".$ctr.">";
										?>
									</tbody>
								</table>
								<?php if($editme == 'octm' || $set_anci_octm != 1) echo "<input type = 'submit' class='btn btn-primary' type='submit' name ='save_anci_octm' value = 'Save'/>";?>
						   </div>
						</div>
					</div>
					</form>
				</div>
				<!--OCT_OTHER-->
				<div class="panel panel-default">
              		<form class="form-horizontal" method='post' <?php if($editme == 'octo') echo "onSubmit='return confirm(\"Do you really want to submit the form?\")'";?>>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOCTOther">
							<div class = <?php if($set_anci_octo == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
							<div class = "panel-heading">
								<b>Optical Coherence Tomography (Other Areas)</b>
							</div></div>
						</a>
					</h4>
					<div id="collapseOCTOther" class = <?php if($editme == 'octo') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
						<div class="panel-body">
						   <div class="col-lg-12">
								<table class="table table-bordered">
									<?php if($set_anci_octo == 1) {?>
										<tr><td colspan = '4'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_octo' value = 'Edit' />
										<input type = 'hidden' name = 'set' value = 'octo' />
										<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
										<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
										<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
									<?php }?>
									<tbody>
                                    <tr>
										<th>Date of Consult</th>
										<td colspan = 3><input type = "date" class="form-control" name='date_octo' required value = <?php if($set_anci_octo == 1) echo $date_octo.$readonly; ?>/> </td>
									</tr>
									<tr>
										<th class = "success">OCT Other Area Institution</th>
										<td><input name = 'octOA_institution' class="form-control" placeholder="OCT Other Area Institution" value = <?php if($set_anci_octo == 1) echo "'".$octOA_institution."'".$readonly; ?>></td>
										<th class = "success">OCT Other Area Machine</th>
										<td><input name = 'octOA_machine' class="form-control" placeholder="OCT Other Area Machine" value = <?php if($set_anci_octo == 1) echo "'".$octOA_machine."'".$readonly; ?>></td>
									</tr>
									<tr>
										<td colspan = 4></td>
									</tr>
									<tr>
										<th class = "active" >OCT Other Area Tested</th>
										<td colspan = 3><input name = 'octOA_tested' class="form-control" placeholder="OCT Other Area Tested" value = <?php if($set_anci_octo == 1) echo "'".$octOA_tested."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th class = "active" >OCT Other Reader</th>
										<td colspan = 3><input name = 'octOA_reader' class="form-control" placeholder="OCT Other Reader" value = <?php if($set_anci_octo == 1) echo "'".$octOA_reader."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th class = "success">OCT Other Remarks</th>
										<td colspan = 3><textarea name = "octOA_remarks" class = "form-control" rows = 1 maxlength = 100 style = "overflow:auto;resize:none" <?php if($set_anci_octo == 1) echo " readonly>".$octOA_remarks; else echo "placeholder = 'OCT Other Remarks'>";?></textarea></td>
									</tr>
									</tbody>
								</table>
								<table class="table table-bordered">
									<tbody>
										<?php 
											$ctr = 0;
											if (isset($scans_arr_octo)) {
										?>
										<tr>
											<th class="active" colspan="3"><center>Scanned Documents</center></th>
										</tr>
										<?php
												foreach ($scans_arr_octo as $scan) {
													if ($ctr % 2 == 0) {
														echo "<tr>";
													}
													echo "<td><div class='well alert'>";
													echo "<input type='hidden' name='octo_name_".$ctr."' value='".$scan->image_name."'>";
													echo "<div class='row'><div class='col-md-12 text-primary'><center>".strtoupper($scan->image_name)."</h6><center></div></div>";
													echo "<div class='row'><div class='col-md-12'><center><img src = '".$scan->image_path."' height='200px' width='340px'></center></div></div>";
													echo "<div class='row'><div class='col-md-12'><input type='hidden' name='octo_id_".$ctr."' value=".$scan->image_id."><input type='text' name='octo_img_".$ctr."' class='form-control' placeholder='Findings' value='".$scan->image_comments."'".$readonly."></div></div>";
													echo "</div></td>";
													if ($ctr % 2 == 1) {
														echo "</tr>";
													}
													$ctr++;
												}												
											}
											echo "<input type='hidden' name='octo_count' value=".$ctr.">";
										?>
								</table>
								 <?php if($editme == 'octo' || $set_anci_octo != 1) echo "<input type = 'submit' class='btn btn-primary' type='submit' name ='save_anci_octo' value = 'Save'/>";?>
						   </div>
						</div>
					</div>
					</form>
				</div>
				<!--VISUAL_FIELDS-->
				<div class="panel panel-default">
               		<form class="form-horizontal" method='post' <?php if($editme == 'vf') echo "";?>>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseVisFields">
							<div class = <?php if($set_anci_vf == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
							<div class = "panel-heading">
								<b>Visual Fields</b>
							</div></div>
						</a>
					</h4>
					<div id="collapseVisFields" class = <?php if($editme == 'vf') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
						<div class="panel-body">
						   <div class="col-lg-12">
								<table class="table table-bordered">
									<?php if($set_anci_vf == 1) {?>
										<tr><td colspan = '4'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_vf' value = 'Edit' />
										<input type = 'hidden' name = 'set' value = 'vf' />
										<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
										<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
										<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
									<?php }?>
									<tbody>
                                    <tr>
										<th>Date of Consult</th>
										<td colspan = 3><input type = "date" class="form-control" name='date_vf' required value = <?php if($set_anci_vf == 1) echo $date_vf.$readonly; ?>/> </td>
									</tr>
									<tr>
										<th class = "success">Institution VF</th>
										<td><input name = 'vfInstitution' class="form-control" placeholder="Institution VF" value = <?php if($set_anci_vf == 1) echo "'".$vfInstitution."'".$readonly; ?>></td>
										<th class = "success">VF Program Used</th>
										<td><input name = 'vfProgram' class="form-control" placeholder="VF Program Used" value = <?php if($set_anci_vf == 1) echo "'".$vfProgram."'".$readonly; ?>></td>
									</tr>
									<tr>
										<td colspan = 4></td>
									</tr>
									<tr>
										<th class = "active" >VF Reader</th>
										<td colspan = 3><input name = 'vfReader' class="form-control" placeholder="VF Reader" value = <?php if($set_anci_vf == 1) echo "'".$vfReader."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th class = "success">VF Remarks</th>
										<td colspan = 3><textarea name = "vf_remarks" class = "form-control" rows = 1 maxlength = 100 style = "overflow:auto;resize:none" <?php if($set_anci_vf == 1) echo " readonly>".$vf_remarks; else echo "placeholder = 'VF Remarks'>";?></textarea></td>
									</tr>
									</tbody>
								</table>
								<table class="table table-bordered">
									<tbody>
										<?php 
											$ctr = 0;
											if (isset($scans_arr_vf)) {
										?>
										<tr>
											<th class="active" colspan="3"><center>Scanned Documents</center></th>
										</tr>
										<?php
												foreach ($scans_arr_vf as $scan) {
													if ($ctr % 2 == 0) {
														echo "<tr>";
													}
													echo "<td><div class='well alert'>";
													echo "<input type='hidden' name='vf_name_".$ctr."' value='".$scan->image_name."'>";
													echo "<div class='row'><div class='col-md-12 text-primary'><center>".strtoupper($scan->image_name)."</h6><center></div></div>";
													echo "<div class='row'><div class='col-md-12'><center><img src = '".$scan->image_path."' height='200px' width='340px'></center></div></div>";
													echo "<div class='row'><div class='col-md-12'><input type='hidden' name='vf_id_".$ctr."' value=".$scan->image_id."><input type='text' name='vf_img_".$ctr."' class='form-control' placeholder='Findings' value='".$scan->image_comments."'".$readonly."></div></div>";
													echo "</div></td>";
													if ($ctr % 2 == 1) {
														echo "</tr>";
													}
													$ctr++;
												}												
											}
											echo "<input type='hidden' name='vf_count' value=".$ctr.">";
										?>
									</tbody>
								</table>
								<?php if($editme == 'vf' || $set_anci_vf != 1) echo "<input type = 'submit' class='btn btn-primary' type='submit' name ='save_anci_vf' value = 'Save'/>";?>
						   </div>
						</div>
					</div>
					</form>
				</div>
				<!--OTHERS-->
				<div class="panel panel-default">
               		<form class="form-horizontal" method='post' <?php if($editme == 'other') echo "";?>>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOther">
							<div class = <?php if($set_anci_other == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
							<div class = "panel-heading">
								<b>Others</b>
							</div></div>
						</a>
					</h4>
					<div id="collapseOther" class = <?php if($editme == 'other') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
						<div class="panel-body">
						   <div class="col-lg-12">
								<table class="table table-bordered">
									<?php if($set_anci_other == 1) {?>
										<tr><td colspan = '3'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_other' value = 'Edit' />
										<input type = 'hidden' name = 'set' value = 'other' />
										<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
										<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
										<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
									<?php }?>
									<tbody>
                                    <tr>
										<th>Date of Consult</th>
										<td colspan = 3><input type = "date" class="form-control" name='date_other' required value = <?php if($set_anci_other == 1) echo $date_other.$readonly; ?>/> </td>
									</tr>
									<tr>
										<th class = "success">Institution Other Test</th>
										<td><input name = 'otherInstitution' class="form-control" placeholder="Institution Other Test" value = <?php if($set_anci_other == 1) echo "'".$otherInstitution."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th class = "success">Other Test Done</th>
										<td><input name = 'otherTest' class="form-control" placeholder="Other Test Done" value = <?php if($set_anci_other == 1) echo "'".$otherTest."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th class = "active" >Other Test Results Reader</th>
										<td ><input name = 'otherReader' class="form-control" placeholder="Other Test Results Reader" value = <?php if($set_anci_other == 1) echo "'".$otherReader."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th class = "success">Remarks</th>
										<td><textarea name = "other_remarks" class = "form-control" rows = 1 maxlength = 100 style = "overflow:auto;resize:none" <?php if($set_anci_other == 1) echo " readonly>".$other_remarks; else echo "placeholder = 'Other Test Remarks'>";?></textarea></td>
									</tr>
									</tbody>
								</table>
								<table class="table table-bordered">
									<tbody>
										<?php 
											$ctr = 0;
											if (isset($scans_arr_other)) {
										?>
										<tr>
											<th class="active" colspan="3"><center>Scanned Documents</center></th>
										</tr>
										<?php
												foreach ($scans_arr_other as $scan) {
													if ($ctr % 2 == 0) {
														echo "<tr>";
													}
													echo "<td><div class='well alert'>";
													echo "<input type='hidden' name='other_name_".$ctr."' value='".$scan->image_name."'>";
													echo "<div class='row'><div class='col-md-12 text-primary'><center>".strtoupper($scan->image_name)."</h6><center></div></div>";
													echo "<div class='row'><div class='col-md-12'><center><img src = '".$scan->image_path."' height='200px' width='340px'></center></div></div>";
													echo "<div class='row'><div class='col-md-12'><input type='hidden' name='other_id_".$ctr."' value=".$scan->image_id."><input type='text' name='other_img_".$ctr."' class='form-control' placeholder='Findings' value='".$scan->image_comments."'".$readonly."></div></div>";
													echo "</div></td>";
													if ($ctr % 2 == 1) {
														echo "</tr>";
													}
													$ctr++;
												}												
											}
											echo "<input type='hidden' name='other_count' value=".$ctr.">";
										?>
									</tbody>
								</table>
								<?php if($editme == 'other' || $set_anci_other != 1) echo "<input type = 'submit' class='btn btn-primary' type='submit' name ='save_anci_other' value = 'Save'/>";?>
						   </div>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div><!--END ANCILLARY TEXT COLLAPSE GROUP-->
	</div>
	
	<!-- DIAGNOSIS -->
<div class = <?php 	if ($set_diagnosis == 1) echo "'panel panel-success'"; else echo "'panel'";?>>
		<header class="panel-heading">
			<h2 class="">DIAGNOSIS</h2>	
		</header>
		<div class = "panel-body">
			<form class="form-horizontal" method='post' <?php if($editme == 'diagnosis') echo "";?>>
			<?php if($set_diagnosis == 1) {?>
				<table class="table table-bordered">
					<tr><td colspan = '3'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_diagnosis' value = 'Edit' />
						<input type = 'hidden' name = 'set' value = 'diagnosis' />
						<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
						</td></tr>
				</table>
			<?php }?>
			<table class = "table table-bordered">
				<tbody>
					<tr>
						<th >Date of Diagnosis</th>
						<td ><input type = "date" class="form-control" name='date_diagnosis' required value = <?php if($set_diagnosis == 1) echo $date_diagnosis.$readonly; ?> > </td>
					</tr>
					<tr><th>ICD 10 Reference</th>
						<td>
						<select name='ICDdoagnosis'>
								<option value = "" size = "200"> </option>
								<?php			
									$query = $this->db->query("SELECT DISTINCT * FROM discharge_diag WHERE 1");
									$discDiagRows = $query->result();;
									foreach ($discDiagRows as $row)
										echo '<option value="'. $row->Description.'" '.set_select('dischargeDiag', $row->Description).'>'. $row->DCode . ' - ' . $row->Description . '</option>';
								?>
						</select>	
						</td></tr>
				</tbody>
			</table>
						
<!--HERE-->
<?php
	if($set_diagnosis == 1){
		$diags = mysql_query("SELECT * FROM `diagnosis` WHERE `VISIT_NO` = '$vn'");
		$idx = 1; 
?>								<table class = 'table table-bordered'>
								<tbody>
<?php
		while ($row = mysql_fetch_assoc($diags)) {
			$diag = $row['DIAGNOSIS'];
			$icd = $row["ICD10_DIAGNOSIS"];
			$rem = $row["DIAGNOSIS_REMARKS"];
			if($idx > 1 ){
?>					<!--date-->
					<tr>
						<td colspan = 2></td>
					</tr>
<?php 	}
?>					<tr>
						<th class = 'active'><center>Diagnosis <?php echo $idx;?></center>
						</th>
						<th class = 'success'><center>Remarks</center></th>
					</tr>
					<tr>
						<th>Diagnosis</th>
						<td><input class = 'form-control' name = 'diagnosis[]' value = <?php if($set_diagnosis == 1) echo "'".$diag."'".$readonly; ?>></td>
					</tr>
					<tr>
						<th>ICD 10 Code</th>
						<td><input class = 'form-control' name = 'diagnosis_icd10[]' value = <?php if($set_diagnosis== 1) echo "'".$icd."'".$readonly; ?>></td>
					</tr>
					<tr>
						<th>Diagnosis Remarks</th>
						<td><input class = 'form-control' name = 'diagnosis_remarks[]' value = <?php if($set_diagnosis == 1) echo "'".$rem."'".$readonly; ?>></td>
					</tr>
<?php
		$idx++;
		}
?>								</tbody>
								</table>
<?php
	}else{
?>		<table class = 'table table-bordered' id = 'dynamicDiag'>	</table>
		<input type = 'button' class = 'btn btn-warning btn-lg btn-block' value = '+ Add Diagnosis' onClick = "addDiagnosis('dynamicDiag',0);">
		<br>
<?php
	}if($editme == 'diagnosis'){ ?>
		<table class = 'table table-bordered' id = 'dynamicDiag'>	</table>
		<input type = 'button' class = 'btn btn-warning btn-lg btn-block' value = '+ Add Diagnosis' onClick = "addDiagnosis('dynamicDiag',1);">
		<br>
<?php		
	}
?>
<!--DIAGNOSIS FUNCTION-->
<script language="Javascript" type="text/javascript">
var counter = 0;

function addDiagnosis(tbl,edit){	
	var add;
	if(counter == 0 && edit == 0){
		/*add = "<tr>"
				+ "<th>Date of Diagnosis</th>"
				+ "<td><input type = 'date' class='form-control' name='date_diagnosis' required value = <?php if($set_diagnosis == 1) echo $date_diagnosis.$readonly; ?> /> </td>"
			+ "</tr>"*/
		add = "<tr><td colspan = 2></td></tr>";
		document.getElementById('submitD').disabled = false;
	}
	else
		add = "<tr><td colspan = 2></td></tr>";

	var newtbl = document.createElement('tbody');
	newtbl.innerHTML = add + "<tr>"
	+ "<th class = 'active'><center>Diagnosis </center></th>"
	+ "<th class = 'success'><center>Remarks</center></th>"
	+ "</tr>"
	+ "<tr>"
		+ "<th>Diagnosis</th>"
		+ "<td><input name = 'diagnosis[]' class = 'form-control' placeholder = 'Diagnosis' required ></td>"
	+ "</tr>"
	+ "<tr>"
		+ "<th>ICD 10 Code</th>"
		+ "<td><input name = 'diagnosis_icd10[]' class = 'form-control' placeholder = 'ICD 10 Code' required ></td>"
	+ "</tr>"
	+ "<tr>"
		+ "<th>Diagnosis Remarks</th>"
		+ "<td><input name = 'diagnosis_remarks[]' class = 'form-control' placeholder = 'Remarks'></td>"
	+ "</tr>";
	document.getElementById(tbl).appendChild(newtbl);				
	counter++;
	
}
</script>
<!--END DIAGNOSIS FUNCTION-->

			<?php if($set_diagnosis != 1) echo "<input type = 'submit' id = 'submitD' class='btn btn-primary' type='submit' name ='save_diagnosis' value = 'Save' disabled = 'disabled'>";
				if($editme == 'diagnosis') echo "<input type = 'submit' class='btn btn-primary' id = 'submit' name ='save_diagnosis' value = 'Save' />";?>
			</form>
		</div>
	</div>
	
	<!--RECOMMENDATIONS -->
	<div class="panel">
		<div class="panel-heading">
			<h2 class="">RECOMMENDATIONS</h2>
		</div>
		<div class = "panel-body">
			<div class="panel-group m-bot20" id="accordion4">
				<!--EYE GLASSES -->
				<div class="panel panel-default">
					<form class="form-horizontal" method='post' <?php if($editme == 'eyeg') echo "";?>>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapseEyeG">
							<div class = <?php if($set_rec_eyeg == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
								<div class = "panel-heading">
									<b>Eye Glasses</b>
								</div>
							</div>
						</a>
					</h4>
					<!--EDITED-->
					<div id="collapseEyeG" class = <?php if($editme == 'eyeg') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
						<div class="panel-body">
							<div class="col-lg-12">
								<table class="table table-bordered">
									<?php if($set_rec_eyeg == 1) {?>
										<tr><td colspan = '3'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_rec_eyeg' value = 'Edit' />
										<input type = 'hidden' name = 'set' value = 'eyeg' />
										<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
										</td></tr>
									<?php }?>
									<tbody>
									<tr>
										<th>Date of Rx Recommendation</th>
										<td colspan = 2><input type = "date" class="form-control" name='date_eyeg' required value = <?php if($set_rec_eyeg == 1) echo $date_eyeg.$readonly; ?>/> </td>
									</tr>
									<tr>
										<th></th>
										<th class = "success">RIGHT (OD)</th>
										<th class = "warning">LEFT (OS)</th>
									</tr>
									<tr>
										<th>Sphere</th>
										<td><input name = 'eyeG_sphere_r' class="form-control" placeholder="Right Sphere" value = <?php if($set_rec_eyeg == 1) echo "'".$eyeG_sphere_r."'".$readonly; ?>></td>
										<td><input name = 'eyeG_sphere_l' class="form-control" placeholder="Left Sphere" value = <?php if($set_rec_eyeg == 1) echo "'".$eyeG_sphere_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Cylinder</th>
										<td><input name = 'eyeG_cyl_r' class="form-control" placeholder="Right Cylinder" value = <?php if($set_rec_eyeg == 1) echo "'".$eyeG_cyl_r."'".$readonly; ?>></td>
										<td><input name = 'eyeG_cyl_l' class="form-control" placeholder="Left Cylinder" value = <?php if($set_rec_eyeg == 1) echo "'".$eyeG_cyl_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Axis</th>
										<td><input name = 'eyeG_axis_r' class="form-control" placeholder="Right Axis" value = <?php if($set_rec_eyeg == 1) echo "'".$eyeG_axis_r."'".$readonly; ?>></td>
										<td><input name = 'eyeG_axis_l' class="form-control" placeholder="Left Axis" value = <?php if($set_rec_eyeg == 1) echo "'".$eyeG_axis_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Adds</th>
										<td><input name = 'eyeG_adds_r' class="form-control" placeholder="Right Adds" value = <?php if($set_rec_eyeg == 1) echo "'".$eyeG_adds_r."'".$readonly; ?>></td>
										<td><input name = 'eyeG_adds_l' class="form-control" placeholder="Left Adds" value = <?php if($set_rec_eyeg == 1) echo "'".$eyeG_adds_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Prism</th>
										<td><input name = 'eyeG_prism_r' class="form-control" placeholder="Right Prism" value = <?php if($set_rec_eyeg == 1) echo "'".$eyeG_prism_r."'".$readonly; ?>></td>
										<td><input name = 'eyeG_prism_l' class="form-control" placeholder="Left Prism" value = <?php if($set_rec_eyeg == 1) echo "'".$eyeG_prism_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Prism Direction</th>
										<td><input name = 'eyeG_base_r' class="form-control" placeholder="Base In / Base Out / Base Up / Base Down / Base in ? degrees" value = <?php if($set_rec_eyeg == 1) echo "'".$eyeG_base_r."'".$readonly; ?>>
										</td>
										<td><input name = 'eyeG_base_l' class="form-control" placeholder="Base In / Base Out / Base Up / Base Down / Base in ? degrees" value = <?php if($set_rec_eyeg == 1) echo "'".$eyeG_base_l."'".$readonly; ?>>
										</td>
									</tr>
									<tr>
										<th>Pupillary Distance</th>
										<td><input name = 'eyeG_distPD_r' class="form-control" placeholder="Right Distance PD" value = <?php if($set_rec_eyeg == 1) echo "'".$eyeG_distPD_r."'".$readonly; ?>></td>
										<td><input name = 'eyeG_distPD_l' class="form-control" placeholder="Left Distance PD" value = <?php if($set_rec_eyeg == 1) echo "'".$eyeG_distPD_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Near Pupillary Distance</th>
										<td><input name = 'eyeG_nearPD_r' class="form-control" placeholder="Right Near PD" value = <?php if($set_rec_eyeg == 1) echo "'".$eyeG_nearPD_r."'".$readonly; ?>></td>
										<td><input name = 'eyeG_nearPD_l' class="form-control" placeholder="Left Near PD" value = <?php if($set_rec_eyeg == 1) echo "'".$eyeG_nearPD_l."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th class = "active">Remarks</th>
										<td colspan = 3>
										<textarea name = "eyeG_remarks" class = "form-control" rows = 1 maxlength = 100 style = "overflow:auto;resize:none" <?php if($set_rec_eyeg == 1) echo $readonly; else echo "placeholder = 'Eyeglasses Remarks'";?>><?php if($set_rec_eyeg == 1) echo $eyeG_remarks;?></textarea>
										</td>
									</tr>
									</tbody>
								</table>
								<?php if($editme == 'eyeg' || $set_rec_eyeg != 1) echo "<input type = 'submit' class='btn btn-primary' type='submit' name ='save_rec_eyeg' value = 'Save'/>";?>
							</div>
						</div>
					</div>
					</form>
				</div>
				<!-- MEDICATIONS -->
				<div class="panel panel-default">
					<form class="form-horizontal" method = 'post' <?php if($editme == 'med') echo "";?> > 
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapseMed">
							<div class = <?php if($set_rec_med == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
								<div class = "panel-heading">
									<b>Medications</b>
								</div>
							</div>
						</a>
					</h4>
					<div id="collapseMed" class = <?php if($editme == 'med') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
						<div class="panel-body">
							<div class="col-lg-12">
							<?php if($set_rec_med == 1) {?>
									<table class = "table table-bordered">
										<tr><td colspan = '3'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_rec_med' value = 'Edit' />
										<input type = 'hidden' name = 'set' value = 'med' />
										<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
										<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
										</td></tr>
									</table>
							<?php }?>

<?php
	if($set_rec_med == 1){
		$meds = mysql_query("SELECT * FROM `recommendation_medication` WHERE `VISIT_NO` = '$vn'");
		$idx = 1; 
?>								<table class = 'table table-bordered'>
								<tbody>
<?php
		while ($row = mysql_fetch_assoc($meds)) {
			$gen = $row['MED_GENERIC'];
			$prep = $row["MED_PREP"];
			$brand = $row["MED_BRAND"];
			$freq = $row["MED_FREQUENCY"];
			$dura = $row["MED_DURATION"];
			$sig = $row["MED_SIG"];
			if($idx == 1 ){
?>									<tr>
										<th>Date of Medication Recommendation</th>
										<td><input type = "date" class="form-control" name='date_rec_med' required value = <?php if($set_rec_med == 1) echo $date_rec_med.$readonly; ?>/> </td>
									</tr>
									<tr>
										<th class = "active">Medication Remarks</th>
										<td><input name = 'med_remarks' class="form-control" placeholder="Medication Remarks" maxlength = 100 value = <?php if($set_rec_med == 1) echo "'".$med_remarks."'".$readonly; ?>></td>
									</tr>
									<tr>
										<td colspan = 2></td>
									</tr>
<?php 	}else{
?>									<tr>
										<td colspan = 2></td>
									</tr>
<?php   }						
?>									<tr>
										<th class = 'active'><center>Medication <?php echo $idx;?></center>
										</th>
										<th class = 'success'><center>Remarks</center></th>
									</tr>
									<tr>
										<th>Generic Name</th>
										<td><input class = 'form-control' name = 'med_gen[]' value = <?php if($set_rec_med == 1) echo "'".$gen."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Preparation</th>
										<td><input class = 'form-control'name = 'med_prep[]' value = <?php if($set_rec_med == 1) echo "'".$prep."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Brand Name</th>
										<td><input class = 'form-control' name = 'med_brand[]' value = <?php if($set_rec_med == 1) echo "'".$brand."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Frequency</th>
										<td><input class = 'form-control' name = 'med_freq[]' value = <?php if($set_rec_med == 1) echo "'".$freq."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Duration</th>
										<td><input class = 'form-control' name = 'med_dura[]' value = <?php if($set_rec_med == 1) echo "'".$dura."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Sig</th>
										<td><input class = 'form-control' name = 'med_sig[]' value = <?php if($set_rec_med == 1) echo "'".$sig."'".$readonly; ?>></td>
									</tr>
<?php
		$idx++;
		}
?>								</tbody>
								</table>
<?php
	}else{
?>		<table class = 'table table-bordered' id = 'dynamicInput'>	</table>
		<input type = 'button' class = 'btn btn-warning btn-lg btn-block' value = '+ Add Medication' onClick = "addInput('dynamicInput',0);">
		<br>
<?php
	}

	if($editme == 'med'){ ?>
		<table class = 'table table-bordered' id = 'dynamicInput'>	</table>
		<input type = 'button' class = 'btn btn-warning btn-lg btn-block' value = '+ Add Medication' onClick = "addInput('dynamicInput',1);">
		<br>
<?php		
	}
?>
<!--MEDICATIONS FUNCTION-->
<script language="Javascript" type="text/javascript">
var counter = 0;

function addInput(tbl,edit){	
	var add;
	if(counter == 0 && edit == 0){
		add = "<tr>"
				+ "<th>Date of Medication Recommendation</th>"
				+ "<td><input type = 'date' class='form-control' name='date_rec_med' required value = <?php if($set_rec_med == 1) echo $date_rec_med.$readonly; ?> /> </td>"
			+ "</tr>"
			+ "<tr>"
				+ "<th class = 'active'>Medication Remarks</th>"
				+ "<td><input name = 'med_remarks' required class = 'form-control' placeholder='Medication Remarks' maxlength = 100 /></td>"
			+ "</tr>"
			+ "<tr><td colspan = 2></td></tr>";
		document.getElementById('submit').disabled = false;
	}
	else
		add = "<tr><td colspan = 2></td></tr>";

	var newtbl = document.createElement('tbody');
	newtbl.innerHTML = add + "<tr>"
	+ "<th class = 'active'><center>Medication </center></th>"
	+ "<th class = 'success'><center>Remarks</center></th>"
	+ "</tr>"
	+ "<tr>"
		+ "<th>Generic Name</th>"
		+ "<td><input name = 'med_gen[]' class = 'form-control' placeholder = 'Generic Name' required ></td>"
	+ "</tr>"
	+ "<tr>"
		+ "<th>Preparation</th>"
		+ "<td><input name = 'med_prep[]' class = 'form-control' placeholder = 'Preparation' required ></td>"
	+ "</tr>"
	+ "<tr>"
		+ "<th>Brand Name</th>"
		+ "<td><input name = 'med_brand[]' class = 'form-control' placeholder = 'Brand Name'></td>"
	+ "</tr>"
	+ "<tr>"
		+ "<th>Frequency</th>"
		+ "<td><input name = 'med_freq[]' class = 'form-control' placeholder = 'Frequency' required></td>"
	+ "</tr>"
	+ "<tr>"
		+ "<th>Duration</th>"
		+ "<td><input name = 'med_dura[]' class = 'form-control' placeholder = 'Duration' required></td>"
	+ "</tr>"
	+ "<tr>"
		+ "<th>Sig</th>"
		+ "<td><input name = 'med_sig[]' class = 'form-control' placeholder = 'Sig' maxlength = 100 required></td>"
	+ "</tr>";
	document.getElementById(tbl).appendChild(newtbl);				
	counter++;
	
}
</script>
<!--END MEDICATIONS FUNCTION-->
								<?php if($set_rec_med != 1) echo "<input type = 'submit' class='btn btn-primary' id = 'submit' name ='save_rec_med' value = 'Save' disabled = 'disabled' />";
								if($editme == 'med') echo "<input type = 'submit' class='btn btn-primary' id = 'submit' name ='save_rec_med' value = 'Save' />";?>
							</div>
						</div>
					</div>
					</form>
				</div>	
					
				<!-- SURGERY -->
				<div class="panel panel-default">
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapseSurg">
							<div class = <?php if($set_rec_surgery == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
								<div class = "panel-heading">
									<b>Surgery</b>
								</div>
							</div>
						</a>
					</h4>
					<div id="collapseSurg" class = <?php if($editme == 'surgery') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
					<form class="form-horizontal" method='post' <?php if($editme == 'surgery') echo "";?>>
						<div class="panel-body">
							<div class="col-lg-12">
								<table class="table table-bordered">
									<?php if($set_rec_surgery == 1) {?>
										<tr><td colspan = '3'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_rec_surgery' value = 'Edit' />
										<input type = 'hidden' name = 'set' value = 'surgery' />
										<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
										<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
										<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
									<?php }?>
									<tbody>
									<tr>
										<th>Date</th>
										<td colspan = 3><input type = "date" class="form-control" name='date_surgery' required value = <?php if($set_rec_surgery == 1) echo $date_surgery.$readonly; ?>/> </td>
									</tr>
									<tr>
									  <th>Surgery Recommended</th>
									  <td colspan = 3><input name = 'surgeRecommend' class="form-control" placeholder = "Surgery Recommended" value = <?php if($set_rec_surgery == 1) echo "'".$surgeRecommend."'".$readonly;  ?>></td>
									</tr>
									<tr>
										<th>RVS Code</th>
									  <td colspan = 3><input name = 'surgeCode' class="form-control" placeholder = "RVS Code" value = <?php if($set_rec_surgery == 1) echo "'".$surgeCode."'".$readonly;  ?>></td>
									</tr>
									<tr><td colspan = 2></td></tr>
									<tr>
										<th class = "active" colspan = 2><center>SURGERY SCHEDULE</center></th>
									</tr>
									<tr>
									  <th>Date</th>
									  <td><input type = "date" name = 'surgeDateSched' class="form-control" placeholder = "Date of Surgery" value = <?php if($set_rec_surgery == 1) echo $surgeDateSched.$readonly; ?>></td>
									</tr>
									<tr>
										<th>Place</th>
									  <td colspan = 3><input name = 'surgePlace' class="form-control" placeholder = "Place of Surgery" value = <?php if($set_rec_surgery == 1) echo "'".$surgePlace."'".$readonly;  ?>></td>
									</tr>
									<tr>
									  <th>Date Surgery Done</th>
									  <td><input type = "date" name = 'surgeDateDone' class="form-control" placeholder = "Date Surgery Done" value = <?php if($set_rec_surgery == 1) echo $surgeDateDone.$readonly;  ?>></td>
									</tr>
									<tr><td colspan = 2></td></tr>
									<tr>
										<th class = "active" colspan = 2><center>ANAESTHESIOLOGIST DETAILS</center></th>
									</tr>
									<tr>
									  <th>Anaesthesiologist</th>
									  <td><input name = 'anaesName' class="form-control" placeholder = "Name of Anaesthesiologist" value = <?php if($set_rec_surgery == 1) echo "'".$anaesName."'".$readonly; ?>></td>
									</tr>
									<tr>
										<th>Anaesthesia</th>
									  <td colspan = 3><input name = 'anaes' class="form-control" placeholder = "General / Local / assisted LA / regional block / ..." value = <?php if($set_rec_surgery == 1) echo "'".$anaes."'".$readonly;  ?>></td>
									</tr>
									<tr>
									  <th>Date Anaesthesiologist Informed</th>
									  <td><input type = "date" name = 'anaesDate' class="form-control" placeholder = " " value = <?php if($set_rec_surgery == 1) echo $anaesDate.$readonly;  ?>></td>
									</tr>
									<tr>
									  <th>Informed by</th>
									  <td><input name = 'anaesInform' class="form-control" placeholder = "Name of Informant" value = <?php if($set_rec_surgery == 1) echo "'".$anaesInform."'".$readonly; ?>></td>
									</tr>

									<tr><td colspan = 2></td></tr>
									<tr>
										<th class = "success">Surgery Remarks</th>
										<td>
										<textarea name = "surge_remarks" class = "form-control" rows = 1 maxlength = 100 style = "overflow:auto;resize:none" <?php if($set_rec_surgery == 1) echo $readonly; else echo "placeholder = 'Surgery Remarks'";?>><?php if($set_rec_surgery == 1) echo $surge_remarks;?></textarea>
										</td>
									</tr>
									</tbody>
								</table>
								<table class = "table table-bordered">
									<tbody>
										<tr>
											<th class = "active" colspan = 2><center>CLEARANCE</center></th>
										</tr>
										<tr>
											<th>Clearance MD</th>
											<td><input name = 'clearance_md' class="form-control" placeholder = "Clearance MD" value = <?php if($set_rec_surgery == 1) echo "'".$clearance_md."'".$readonly;  ?>></td>
										</tr>
										<tr>
											<th>Date Sent</th>
											<td><input type = "date" name = 'clearance_sent' class="form-control" value = <?php if($set_rec_surgery == 1) echo $clearance_sent.$readonly;  ?>></td>
										</tr>
										<tr>
											<th>Date Cleared</th>
											<td><input type = "date" name = 'clearance_cleared' class="form-control" value = <?php if($set_rec_surgery == 1) echo $clearance_cleared.$readonly;  ?>></td>
										</tr>
									</tbody>
								</table>
								<?php if($editme == 'surgery' || $set_rec_surgery != 1) echo "<input type = 'submit' class='btn btn-primary' type='submit' name ='save_rec_surgery' value = 'Save'/>";?>
							</div>
						</div>
					</form>
					</div>	
				</div>

				<!-- FOLLOW UP -->
				<div class="panel panel-default">
				<!--EDITED-->
					<form class="form-horizontal" method='post' <?php if($editme == 'fu' || $set_rec_fu != 1) echo "";?>>
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapseFollowUp">
							<div class = <?php if($set_rec_fu == 1) echo "'panel panel-success'"; else echo "'panel panel-info'";?>>
							<div class = "panel-heading">
								<b>Follow Up</b>
							</div></div>
						</a>
					</h4>
					<div id="collapseFollowUp" class = <?php if($editme == 'fu') echo "'panel-collapse active'"; else echo "'panel-collapse collapse'"; ?> >
						<div class="panel-body">
							<div class="col-lg-12">
								<table class="table table-bordered">
									<?php if($set_rec_fu == 1) {?>
										<tr><td colspan = '3'><input type = 'submit' class='btn btn-lg btn-warning' type='submit' name ='edit_rec_fu' value = 'Edit' />
										<input type = 'hidden' name = 'set' value = 'fu' />
										<input type = 'hidden' name = 'patient' value = <?php echo "'".$name."'";?> />
										<input type = 'hidden' name = 'birthday' value = <?php echo "'".$bday."'";?> />
										<input type = 'submit' class='btn btn-lg btn-danger' type='submit' name ='print_me' value = 'Save as Pdf' /></td></tr>
									<?php }?>
									<tbody>
										<tr>
										<th>Follow-Up Recommendation</th>
										<td colspan = 3><input name = 'fu_rec' required class="form-control" placeholder="Follow-Up Recommendation" maxlength = 100 value = <?php if($set_rec_fu == 1) echo "'".$fu_rec."'".$readonly;  ?>></td>
									</tr>
										<tr>
											<th class="active"></th>
											<th class = "success"><center>Remarks</center></th>
										</tr>
									<tr>
											<th>Schedule of Follow-Up</th>
											<td><input type = "date" name = 'fu_sched' class="form-control" placeholder="Schedule of Follow-Up" value = <?php if($set_rec_fu == 1) echo $fu_sched.$readonly;  ?>></td>
										</tr>
										<tr>
											<th>Appointment made by</th>
											<td><input name = 'fu_apptMadeBy' class="form-control" placeholder="Appointment made by" value = <?php if($set_rec_fu == 1) echo "'".$fu_apptMadeBy."'".$readonly;  ?>></td>
										</tr>
										<tr>
											<th>Date Appointment Made</th>
											<td><input type = "date" name = 'fu_apptMadeDate' class="form-control" value = <?php if($set_rec_fu == 1) echo $fu_apptMadeDate.$readonly;  ?>></td>
										</tr>
										<tr>
											<th>Staff who took the appointment</th>
											<td><input name = 'fu_apptStaff' class="form-control" placeholder="Staff who took the appointment" value = <?php if($set_rec_fu == 1) echo "'".$fu_apptStaff."'".$readonly;  ?>></td>
										</tr>
										<tr>
											<th>Follow-Up Remarks</th>
											<td>
											<textarea name = "fu_remarks" class = "form-control" rows = 1 maxlength = 100 style = "overflow:auto;resize:none" <?php if($set_rec_fu == 1) echo $readonly; else echo "placeholder = 'Follow-Up Remarks'";?>><?php if($set_rec_fu == 1) echo $fu_remarks;?></textarea>
											</td>
										</tr>
									</tbody>
								</table>
								<?php if($editme == 'fu' || $set_rec_fu != 1) echo "<input type = 'submit' class='btn btn-primary' type='submit' name ='save_rec_fu' value = 'Save'/>";?>
							</div>
						</div>
					</div>	
					</form>
				</div>	<!--END FOLLOW-UP-->


		</div>
	</div><!--END PANEL RECOMMENDATION-->
	</div>
</section>
</section>
      <!--main content end-->