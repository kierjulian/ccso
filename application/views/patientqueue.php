<!--main content start-->
<section id="main-content2">
	
	<?php
		require_once "Patient.php";
		require_once "Appointment.php";
	?>
	<?php
				$this->load->library(array('table', 'form_validation', 'session'));
				
				if(! $this->session->userdata("logged_in")){
					redirect(base_url() . "main/");
				}
	?>
	
	<section class="wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header"><i class="fa fa fa-bars"></i> CONSULTATION QUEUE</h2>
			<ol class="breadcrumb">
				<li><i class="fa fa-home"></i><a href='<?php echo base_url(); ?>home'>Home</a></li>
				<li><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>queue">Consultation Queue</a></li>
			</ol>
		</div>
	</div>
	
		<div class="row">
			<div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">
					<div class="info-box green-bg">
						<i class="fa fa-info-circle"></i>
						<div class="count"><?php echo $total; ?></div>
						<div class="title">On-queue Patients</div>						
					</div><!--/.info-box-->			
				</div><!--/.col-->
			<div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">
					<div class="info-box red-bg">
						<i class="fa fa-times-circle"></i>
						<div class="count"><?php echo $discharged; ?></div>
						<div class="title">Recently discharged</div>						
					</div><!--/.info-box-->			
				</div><!--/.col-->	
		</div>
	
		<div class="row">	
			<div class="col-lg-12">
                <section class="panel">
                          
                    <table class="table table-striped table-advance table-hover">
                        <tbody>
                            <tr>
								<th><i class="icon_id"></i> Visit No.</th>
                                <th><i class="icon_id"></i> Patient ID</th>
								<th><i class="icon_profile"></i> Name</th>
								<th><i class="icon_question"></i> Sex</th>
								<th><i class="icon_calendar"></i> Birthday</th>
                                <th><i class="icon_clock"></i> Time Admitted</th>
                                <th><i class="icon_cogs"></i> Action</th>
                            </tr>
					<?php
						foreach ($patients as $patient)
						{	
					?>
							<tr>
								<td><?php echo $patient->{Appointment::VISIT_NUMBER}; ?></td>
								<td><?php echo Patient::getPatientID($patient->{Patient::CREATION_DATE}, $patient->{Patient::CREATION_NUM}); ?></td>
								<td><?php echo Patient::getFullName($patient->{Patient::LAST_NAME}, $patient->{Patient::FIRST_NAME}, $patient->{Patient::MIDDLE_NAME}); ?></td>
								<td><?php echo Patient::getSex($patient->{Patient::SEX}); ?></td>
								<td><?php echo Patient::getBirthday($patient->{Patient::BIRTHDAY}); ?></td>
								<td><?php echo Appointment::getTime($patient->{Appointment::TIME_IN}); ?></td>
									
								<td>									
									<div class='btn-group'>
										<a class='btn btn-default' href='<?php echo base_url(); ?>profile/view/<?php echo $patient->{Patient::TRUE_ID}; ?>'><span class='icon_info_alt'></span>&nbsp;&nbsp;View Profile</a>
										<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href=""><span class="caret"></span></a>
										<ul class="dropdown-menu">
										<?php if($this->session->userdata("acsDP")){
												echo "<li><a class='' href='/CCSO/doc/index/".$patient->{Appointment::VISIT_NUMBER}."'><span class='icon_plus'></span>&nbsp;&nbsp;Doctor's Page</a></li>";
											}?>
										<?php if($this->session->userdata("acsBil")){
												echo "<li><a class='' href='/CCSO/billing'><span class='icon_menu'></span>&nbsp;&nbsp;Billing</a></li>";
											}?>
										<?php if($this->session->userdata("acsBil")){
												echo "<li><a class='' href='/CCSO/discharge/".$patient->{Patient::TRUE_ID}."'><span class='icon_close_alt2'></span>&nbsp;&nbsp;Discharge</a></li>";
											}?>
										<li><a class='' href='/CCSO/profile/dequeue/<?php echo $patient->{Patient::TRUE_ID}; ?>'><span class='icon_close'></span>&nbsp;&nbsp;Cancel</a></li>
										</ul>
									</div>
								</td>
                  
							</tr>
					<?php
						}
					?>
                                                      
                        </tbody>
                    </table>
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