<section id="main-content">
	<section class="wrapper">
		<h3 class="page-header"><i class="fa fa-medkit"></i>Anesthesia</h3>
		<div class="row"> <div class="col-md-12">
	      <?php if(isset($bad_input)) { ?>
	        <div class="alert alert-danger alert-dismissible">
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <strong>Error! </strong>Invalid input. Please try again.
	        </div>
	      <?php } ?>
	    </div></div>
		<form method='post' class='form-inline' action=<?php echo "'".base_url()."procedures/anesthesia/".$visit_num."'"; ?>>
			<label> Anesthesiologist </label> <input type="text" name='doc' class="form-control"> <br>
			<label> Cost of Anesthesia </label> <input type="text" name='cost' class="form-control">
			<input type="submit" class="btn btn-default" name='submit' value='Add Anesthesia' />
		</form>		
	</section>
</section>