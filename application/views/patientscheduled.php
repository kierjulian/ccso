<!--main content start-->
<section id="main-content">
	<?php
		require_once "Patient.php";
		require_once "ScheduledAppointment.php";
	?>
	<section class="wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header"><i class="fa fa fa-pencil-square-o"></i> SCHEDULED PATIENTS</h2>
			<ol class="breadcrumb">
				<li><i class="fa fa-home"></i><a href='<?php echo base_url(); ?>admit/'>Home</a></li>
				<li><i class="fa fa-pencil-square-o"></i><a ref="<?php echo base_url(); ?>scheduled">Scheduled Queue</a></li>
			</ol>
		</div>
	</div>
	
		<div class="row">
			<div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">
					<div class="info-box green-bg">
						<i class="fa fa-info-circle"></i>
						<div class="count"><?php echo $total; ?></div>
						<div class="title">Total Scheduled</div>						
					</div><!--/.info-box-->			
				</div><!--/.col-->
			<div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">
					<div class="info-box blue-bg">
						<i class="fa fa-check-square"></i>
						<div class="count"><?php echo $month; ?></div>
						<div class="title">Scheduled this month</div>						
					</div><!--/.info-box-->			
				</div><!--/.col-->	
			<div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">
					<div class="info-box red-bg">
						<i class="fa fa-exclamation-circle"></i>
						<div class="count"><?php echo $overdue; ?></div>
						<div class="title">Overdue on schedule</div>						
					</div><!--/.info-box-->			
				</div><!--/.col-->	
		</div>
		
		
	
		<div class="row">	
			<div class="col-lg-12">
                <section class="panel">
                          
                    <table class="table table-striped table-advance table-hover">
                        <tbody>
                            <tr>
                                <th><i class="icon_id"></i> Patient ID</th>
								<th><i class="icon_profile"></i> Name</th>
                                <th><i class="icon_calendar"></i> Scheduled Date</th>
								<th><i class="icon_clock"></i> Scheduled Time</th>
                                <th><i class="icon_cogs"></i> Action</th>
                            </tr>
			<?php
						foreach ($patients as $patient)
						{
			?>
							<tr>
								<td><?php echo Patient::getPatientID($patient->{Patient::CREATION_DATE}, $patient->{Patient::CREATION_NUM}); ?></td>
								<td><?php echo Patient::getFullName($patient->{Patient::LAST_NAME}, $patient->{Patient::FIRST_NAME}, $patient->{Patient::MIDDLE_NAME}); ?> </td>
								<td><?php echo ScheduledAppointment::getScheduleDate($patient->{ScheduledAppointment::SCHEDULE_DATE}); ?></td>
								<td><?php echo ScheduledAppointment::getScheduleTime($patient->{ScheduledAppointment::SCHEDULE_TIME}); ?></td>
									
								<td>
									<div class='btn-group'>
										<a class='btn btn-default' href='<?php echo base_url(); ?>profile/view/<?php echo $patient->{Patient::TRUE_ID}; ?>'><span class='icon_info_alt'></span>&nbsp;&nbsp;View Profile</a>
										<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href=""><span class="caret"></span></a>
										<ul class="dropdown-menu">
										<li><a class='' href='<?php echo base_url(); ?>profile/enqueue/<?php echo $patient->{Patient::TRUE_ID}; ?>'><span class='icon_plus_alt2'></span>&nbsp;&nbsp;Add to Queue</a></li>
										<li><a class='' href='<?php echo base_url(); ?>profile/unschedule/<?php echo $patient->{ScheduledAppointment::SCHEDULE_ID}; ?>'><span class='icon_close_alt2'></span>&nbsp;&nbsp;Cancel</a></li>
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