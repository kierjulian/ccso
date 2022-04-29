<!--main content start-->
<?php if (!$isPrintable) { ?>
<section id="main-content">
	<section class = "wrapper">
<?php } else { ?>
<section>
	<section>
<?php } ?>

	
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header"><i class="fa fa fa-pencil-square-o"></i> SCHEDULED PATIENTS</h3>
			
			<?php if (!$isPrintable) { ?>
			<ol class="breadcrumb">
				<li><i class="fa fa-home"></i><a href='<?php echo base_url(); ?>home'>Home</a></li>
				<li><i class="fa fa-pencil-square-o"></i><a href="<?php echo base_url(); ?>schedule/index">Scheduled Queue</a></li>
			</ol>
			<?php } ?>
			
		</div>
	</div>
	<?php if (!$isPrintable) { ?>
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
	<?php } else { ?>
		<div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">
			<p style="font-size:20px;">Total Scheduled   : <?php echo $count; ?> <p>
		</div>
		<div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">
			<p style="font-size:20px;">Scheduled this month : <?php echo $month; ?></p>
		</div>
		<div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">
			<p style="font-size:20px;">Overdue on schedule : <?php echo $overdue; ?></p>
		</div>
	<?php } ?>
	
	<hr>
	
	
	<form method='get'>
		<?php if (!$isPrintable) { ?>
		<div class="row">
			<div class="col-sm-6">	
				<div class="form-group col-sm-5">
					<label for="fromsearch" class="col-sm-1 control-label">Name</label>
					<input type="text" name='name' class="form-control" placeholder="Name" value='<?php echo (isset($_GET["name"])? $_GET["name"]: ""); ?>' />
				</div>
				<div class="form-group col-sm-6">
					<label for="fromsearch" class="col-sm-1 control-label">From</label>
					<input class="form-control" type = "date" name='from' value='<?php echo (isset($_GET["from"])? $_GET["from"]: ""); ?>' />
						
					<label for="tosearch" class="col-sm-1 control-label">To</label>
					<input class="form-control" type = "date" name='to' value='<?php echo (isset($_GET["to"])? $_GET["to"]: ""); ?>' />
				</div>
				<div class="form-group col-sm-6">
					<input type="submit" class="btn btn-default" style="font-weight:bold;" value='Submit' />
				</div>
			</div>
		</div>

		<hr>
		<?php } ?>
		
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
								<th><i class="icon_question"></i> Remarks</th>
                                <?php if (!$isPrintable) { echo '<th><i class="icon_cogs"></i> Action</th>'; } ?>
                            </tr>
			<?php
						foreach ($patients as $patient)
						{
			?>
							<tr>
								<td><b><?php echo Patient::getPatientID($patient->{Patient::CREATION_DATE}, $patient->{Patient::CREATION_NUM}); ?></b></td>
								<td><b><?php echo Patient::getFullName($patient->{Patient::LAST_NAME}, $patient->{Patient::FIRST_NAME}, $patient->{Patient::MIDDLE_NAME}); ?> </b></td>
								<td><b><?php echo ScheduledAppointment::getScheduleDate($patient->{ScheduledAppointment::SCHEDULE_DATE}); ?></b></td>
								<td><b><?php echo ScheduledAppointment::getScheduleTime($patient->{ScheduledAppointment::SCHEDULE_TIME}); ?></b></td>
								<td><?php echo $patient->{ScheduledAppointment::REMARKS}; ?></td>
								
								<?php if (!$isPrintable) { ?>
								
								<td>
									<div class='btn-group'>
										<a class='btn btn-default' href='<?php echo base_url(); ?>profile/view/<?php echo $patient->{Patient::TRUE_ID}; ?>'><span class='icon_info_alt'></span>&nbsp;&nbsp;<b>View Profile</b></a>
										<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href=""><span class="caret"></span></a>
										<ul class="dropdown-menu">
										<li><a class='' href='<?php echo base_url(); ?>profile/enqueue/<?php echo $patient->{Patient::TRUE_ID}; ?>'><span class='icon_plus_alt2'></span>&nbsp;&nbsp;<b>Add to Queue</b></a></li>
										<li><a class='' href='<?php echo base_url(); ?>profile/unschedule/<?php echo $patient->{ScheduledAppointment::SCHEDULE_ID}; ?>'><span class='icon_close_alt2'></span>&nbsp;&nbsp;<b>Cancel</b></a></li>
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
				echo "<br>$printableLink";
			}
		?>
			</div>
        </div>
	</form>	
	</section>
</section>
<!--main content end-->