      <!--main content start-->
<section id="main-content">
	<section class="wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header">Create New Job Position</h3>
		</div>
	</div>
	  <!-- page start-->
	  
	<div class="panel panel-primary">
		
		<div class="panel-heading">
			<h3 class="">Job Information</h3>	
		</div>
			
		<div class="panel-body">
			<form class="form-horizontal form-validate" method='post' id = "user_form">
			
				<div class="form-group">
					<label for="jname" class="col-sm-2 control-label">Job Name</label>
						<div class="col-sm-3">
							<input name='jname' class="form-control" placeholder="Job Name" required id = 'jname' />
							<?php echo form_error('jname'); ?>
						</div>
				</div>		

				<div class="form-group">
					<label for="chosennavbar" class="col-sm-2 control-label">Job Position</label>
						<div class="col-sm-3">
							<input type="checkbox" name="module[]" value="admission"><label>Admission</label><br/>
							<input type="checkbox" name="module[]" value="doctorsPage"><label>Doctor's Page</label><br/>
							<input type="checkbox" name="module[]" value="clinicalOrder"><label>Clinical Order</label><br/>
							<input type="checkbox" name="module[]" value="discharge"><label>Discharge</label><br/>
							<input type="checkbox" name="module[]" value="billing"><label>Billing</label><br/>
							
							<?php echo form_error('module[]'); ?>
						</div>
				</div>						
											
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" name='submit' value='Add Position' class="btn btn-lg btn-primary pull-center" />
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