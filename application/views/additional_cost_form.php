<section id="main-content">
	<section class="wrapper">
		<h3 class="page-header"><i class="fa fa-medkit"></i>Additional Costs</h3>
		<div class="row"> <div class="col-md-12">
	      <?php if(isset($bad_input)) { ?>
	        <div class="alert alert-danger alert-dismissible">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <strong>Error! </strong>Invalid input. Please try again.
	        </div>
	      <?php } ?>
	    </div></div>
		<form method='post' class='form-inline' action=<?php echo "'".base_url()."procedures/other/".$visit_num."'"; ?>>
			<label> Surgeon </label> <input type="text" name='surgeon' class="form-control"> <br>
			<label> Professional Fee (Surgery) </label> <input type="text" name='pfs' class="form-control"> <br>
			<label> Anesthesiologist </label> <input type="text" name='doc' class="form-control"> <br>
			<label> Professional Fee (Anesthesia) </label> <input type="text" name='pfa' class="form-control"> <br>
			<label> Other Costs </label> <input type="text" name='other' class="form-control">
			<input type="submit" class="btn btn-default" name='submit' value='Add Costs' />
		</form>		
	</section>
</section>