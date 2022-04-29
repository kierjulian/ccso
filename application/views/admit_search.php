<!--main content start-->

<?php if (!$isPrintable)  { 
	echo "<section id='main-content'>";
	echo "<section class='wrapper'>";
 } else { 
	echo "<section>";
	echo "<section>";
 }
?>

	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header"><i class="fa fa fa-bars"></i> SEARCH PATIENT</h2>
			
			<?php if (!$isPrintable) { ?>
			<ol class="breadcrumb">
				<li><i class="fa fa-home"></i><a href='<?php echo base_url(); ?>home'>Home</a></li>
				<li><i class="fa fa-desktop"></i><a href='<?php echo base_url(); ?>search'>Search Patient</a></li>
			</ol>
			<?php } ?>
			
		</div>
	</div>
	
	<?php if (!$isPrintable) { ?>
	<hr class="col-lg-12">
	<?php } ?>
	
	<form method='get'>
		<?php if (!$isPrintable) { ?>
		<div class="row">
			<div class="col-lg-12">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">		
				<div class="form-group">
					<input type="text" name='name' class="form-control" placeholder="Name" value='<?php echo (isset($_GET["name"])? $_GET["name"]: ""); ?>'>
				</div>	
				
				<input type="submit" class="btn btn-default" style="font-weight:bold;" name='submit' value='Submit' />

				<button type="button" class="btn btn-primary" style="font-weight:bold;" data-toggle="collapse" data-target="#filter-panel">
				Advanced Search
				</button>
						
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-10">
				<div id="filter-panel" class="collapse filter-panel">
					
						<div class="panel-body">
							<div class="form-horizontal">
								<div class="form-group">
									<label for="bdatesearch" class="col-sm-2 control-label">Birthday</label>
									<div class="col-sm-3">
										<input class="form-control" type='date' name='bday' value='<?php echo (isset($_GET["bday"])? $_GET["bday"]: ""); ?>'/>
									</div>
									<label for="sexsearch" class="col-sm-1 control-label">Sex</label>
									<div class="col-sm-2">
										<select class="form-control input-sm" name='sex' />
											<option value='' <?php echo (empty($_GET["sex"])? "selected": ""); ?>><b>All</b></option>
											<option value='<?php echo Patient::MALE; ?>' <?php echo (!empty($_GET["sex"]) && $_GET["sex"] == Patient::MALE? "selected": ""); ?>><b>Male</b></option>
											<option value='<?php echo Patient::FEMALE; ?>' <?php echo (!empty($_GET["sex"]) && $_GET["sex"] == Patient::FEMALE? "selected": ""); ?>><b>Female</b></option>
										</select>
									</div>									
								</div>
							</div>
						</div>
					
				</div>							
			</div>
		</div>
		
		<hr class="col-lg-12">
		<?php } ?>
		
		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<header class="panel-heading">
						Patient List
					</header>
					<div class="table-responsive">
						<table class="table table-striped table-advance table-hover">
							<tbody>
								<tr>
									<th><i class="icon_id"></i>&nbsp;Patient ID</th>
									<th><i class="icon_profile"></i>&nbsp;Name</th>
									<th><i class="icon_question"></i>&nbsp;Sex</th>
									<th><i class="icon_calendar"></i>&nbsp;Birthday</th>
									<?php if (!$isPrintable) { echo '<th><i class="icon_cogs"></i>&nbsp;Action</th>'; } ?>
								</tr>
						<?php
							foreach ($patients as $patient)
							{			
						?>
								<tr>
									<td><b><?php echo Patient::getPatientID($patient->{Patient::CREATION_DATE}, $patient->{Patient::CREATION_NUM}); ?></b></td>
									<td><b><?php echo Patient::getFullName($patient->{Patient::LAST_NAME}, $patient->{Patient::FIRST_NAME}, $patient->{Patient::MIDDLE_NAME}); ?></b></td>
									<td><b><?php echo Patient::getSex($patient->{Patient::SEX}); ?></b></td>									
									<td><b><?php echo Patient::getBirthday($patient->{Patient::BIRTHDAY}); ?></b></td>
									<?php if (!$isPrintable) { ?>
									<td>
									
										<div class='btn-group'>
											<a class='btn btn-default' href='<?php echo base_url(); ?>profile/view/<?php echo $patient->{Patient::TRUE_ID}; ?>'><i class='icon_info_alt'></i>&nbsp;&nbsp;<b>View Profile</b></a>
											<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href=""><span class="caret"></span></a>
											<ul class="dropdown-menu">
												<li>
													<a class='' href='<?php echo base_url(); ?>profile/edit/<?php echo $patient->{Patient::TRUE_ID}; ?>'><i class='icon_pencil'></i>&nbsp;&nbsp;<b>Edit Profile</b></a>
												</li>
											</ul>
										</div>
									</td>
									<?php } ?>
								</tr>
						<?php	
							}
						?>                           
							</tbody>
						</table>
					</div>
				</section>
			</div>
			
			<!-- Pagination -->
			<div class="text-center">
		<?php
			if (!$isPrintable) {
				for ($i = 1; $i <= ceil($count/30); $i++)
				{
		?>
				<input type='submit' name='page' class='btn btn-default' value='<?php echo $i; ?>' />
		<?php
				}
				echo "<br><a href='$printableHREF'>$printableLink</a>";
			}
		?>
			</div>
	
	</form>		
	</section>
</section>
<!--main content end-->