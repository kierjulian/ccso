<!--main content start-->
<section id="main-content">
	<section class="wrapper">
	
	<?php require_once "Patient.php";?>
	
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header"><i class="fa fa fa-bars"></i> SEARCH PATIENT</h2>
			<ol class="breadcrumb">
				<li><i class="fa fa-home"></i><a href='<?php echo base_url(); ?>admit/'>Home</a></li>
				<li><i class="fa fa-desktop"></i><a href='<?php echo base_url(); ?>search'>Search Patient</a></li>
			</ol>
		</div>
	</div>
	
		<div class="row">
			<div class="col-lg-12">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<form method='post' class="navbar-form navbar-left">
					<div class="form-group">
						<input type="text" name='query' class="form-control" placeholder="Search">
					</div>
					<input type="submit" class="btn btn-default" name='submit' value='Submit' />
					<div class="form-group">
						<select name='type' class="form-control input-sm ">
							<option value='name'>By Name</option>
							<option value='id'>By ID</option>
							<option value='birthday'>By Birthday</option>
							<option value='sex'>Sex</option>
						</select>
					</div>
				</form>						
			</div>
		</div>
		
		<hr class="col-lg-12">
		
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
									<th><i class="icon_cone"></i>&nbsp;Status</th>
									<th><i class="icon_cogs"></i>&nbsp;Action</th>
								</tr>
						<?php
							foreach ($patients as $patient)
							{
								
						?>
								<tr>
									<td><?php echo Patient::getPatientID($patient->{Patient::CREATION_DATE}, $patient->{Patient::CREATION_NUM}); ?></td>
									<td><?php echo Patient::getFullName($patient->{Patient::LAST_NAME}, $patient->{Patient::FIRST_NAME}, $patient->{Patient::MIDDLE_NAME}); ?></td>
									<td><?php echo Patient::getSex($patient->{Patient::SEX}); ?></td>									
									<td><?php echo Patient::getBirthday($patient->{Patient::BIRTHDAY}); ?></td>
									<td><?php echo Patient::getStatus($patient->{Patient::STATUS}); ?></td>
									
									<td>
										<div class='btn-group'>
											<a class='btn btn-default' href='<?php echo base_url(); ?>profile/view/<?php echo $patient->{Patient::TRUE_ID}; ?>'><i class='icon_info_alt'></i>&nbsp;&nbsp;View Profile</a>
											<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href=""><span class="caret"></span></a>
											<ul class="dropdown-menu">
											<li><a class='' href='<?php echo base_url(); ?>profile/edit/<?php echo $patient->{Patient::TRUE_ID}; ?>'><i class='icon_pencil'></i>&nbsp;&nbsp;Edit Profile</a></li>
											</ul>
									</td>
								</tr>
						<?php	
							}
						?>                           
							</tbody>
						</table>
					</div>
				</section>
			</div>
			<div class="text-center">
		<ul class="pagination">
			<li><a href="#">«</a></li>
			<li><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">5</a></li>
			<li><a href="#">»</a></li>
		</ul>
	</div>
		</div>
	</section>
</section>
<!--main content end-->