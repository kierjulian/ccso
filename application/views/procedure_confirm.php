<section id="main-content">
	<section class="wrapper">
	<div class="row">
		<div class="col-lg-10">
			<h3 class="page-header"><i class="fa fa-bars"></i>Outside Procedures</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-10">
			<h4 class="page-header"><strong>Please confirm order:</strong></h4>
		</div>
	</div>
	  <div class="panel panel-info">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10"><div class="row"></div></div>
					<div class"col-md-2">
						<button class='btn btn-primary disabled col-md-2'>Price: <?php echo $procedure_price; ?></button>
					</div>
			</div>
		</div>
		<div class="panel-body" style="min-height: 150px; max-height: 200px; overflow-y: scroll;">
			<center><?php echo $procedure_package; ?></center>
		</div>
		<div class="panel-footer">
		<div class="panel-footer">
        <div class="row">
          <div class="col-md-1 col-md-offset-5">
            <form method='post' class='form-inline' action=<?php echo "'".base_url()."procedures/index/".$visit_num."'"; ?>>
              <input type="submit" class="btn btn-danger" value="Cancel"/>
            </form>
          </div>
          <div class="col-md-1">
            <form method='post' class='form-inline' action=<?php echo "'".base_url()."procedures/success/".$visit_num."'"; ?>>
              <input type="submit" class='btn btn-primary' value="Confirm"/>
            </form>
          </div> 
        </div>
      </div>
		</div>
    </div>
	  
	  
	  <!-- page end-->
	</section>
</section>
      <!--main content end-->