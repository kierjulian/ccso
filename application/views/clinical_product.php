<section id="main-content">
  <section class="wrapper">
    <h3 class="page-header"><?php echo $header; ?></h3>
    <div class="row"> <div class="col-md-12">
      	<?php if(isset($bad_name)) { if ($bad_name==TRUE) { $name_init = ''; ?>
        	<div class="alert alert-danger alert-dismissible">
          		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          		<strong>Error! </strong>Name taken. Please try again.
        	</div>
      	<?php } } ?>
      	<?php if(isset($bad_name)) { if ($bad_name==FALSE) { ?>
        	<div class="alert alert-danger alert-dismissible">
          		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          		<strong>Error! </strong>Name required. Please try again.
        	</div>
      	<?php } } ?>
      	<?php if(isset($bad_desc)) { ?>
        	<div class="alert alert-danger alert-dismissible">
          		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          		<strong>Error! </strong>Description required. Please try again.
        	</div>
      	<?php } ?>
      	<?php if(isset($bad_price)) { if ($bad_price==TRUE) { $price_init = ''; ?>
        	<div class="alert alert-danger alert-dismissible">
          		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          		<strong>Error! </strong>Invalid price. Please try again.
        	</div>
      	<?php } } ?>
      	<?php if(isset($bad_price)) { if ($bad_price==FALSE) { ?>
        	<div class="alert alert-danger alert-dismissible">
          		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          		<strong>Error! </strong>Price required. Please try again.
        	</div>
      	<?php } } ?>
    </div></div>
	<form class='form-horizontal' method='post' action=<?php echo $next;?>>
		<div class='well'>
			<div class='row'>
				<label class='col-sm-2'>Product Name: </label>
				<div class='col-sm-10'>
					<input class='form-control input-sm' type='text' name='name1' placeholder='Name' value=<?php echo "'".$name_init."'";?>>
				</div>
			</div>
			<div class='row'>
				<label class='col-md-2'>Product Description: </label>
				<div class='col-sm-10'>
					<input class='form-control input-sm' type='text' name='desc1' placeholder='Description' value=<?php echo "'".$desc_init."'";?>>
				</div>
			</div>
			<div class='row'>
				<label class='col-md-2'>Product Price: </label>
				<div class='col-sm-10'>
					<input class='form-control input-sm' type='text' name='price1' placeholder='Price' value=<?php echo "'".$price_init."'";?>>
				</div>
			</div>
		</div>
		<input type='submit' class='btn btn-primary col-sm-1' name='submitprod' value=<?php echo $mode; ?>>
	</form>
	<form class='form-horizontal' method='post' action=<?php echo $self;?>>
		<input type='submit' class='btn btn-info col-sm-1' name='cancelprod' value='Cancel'>
	</form>
	</div>
  </section>
</section>