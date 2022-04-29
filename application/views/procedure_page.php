      <!--main content start-->
<section id="main-content">
	<section class="wrapper">
	<div class="row">
		<div class="col-lg-10">
			<h3 class="page-header"><i class="fa fa-bars"></i>Outside Procedures</h3>
		</div>
	</div>
	  <!-- page start-->
	  
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
        <div class="row">
          <div class="col-md-1 col-md-offset-5">
            <form method='post' class='form-inline' action=<?php echo "'".base_url()."procedures/cancel_procedure/".$visit_num."'"; ?>>
              <input type="submit" class="btn btn-danger" value="Cancel"/>
            </form>
          </div>
          <div class="col-md-1">
            <form method='post' class='form-inline' action=<?php echo "'".base_url()."procedures/confirm_procedure/".$visit_num."'"; ?>>
              <?php $class = "btn btn-success";
                if($procedure_package=='<i class="fa fa-dropbox"></i><span>Add items to package</span>') {
                $class .= " disabled";
              } ?>
              <input type="submit" class=<?php echo "'".$class."'"; ?> value="Finalize"/>
            </form>
          </div> 
        </div>
      </div>
    </div>
		<div class="panel panel-info">
			<div class="panel-heading">
					<form method='post' class='form-inline' action=<?php echo "'".base_url()."procedures/search/".$visit_num."'"; ?>>
						<table>
							<tr class>
								<th class = "col-lg-9" rowspan = 2><h3><b>PROCEDURES</b></h3></th>
								<td class = "col-md-7"><input type="text" name='search_query' class="form-control"></td>
								<td><input type="submit" class="btn btn-default" name='submit_search' value='Search' /></td>
							</tr>
							<tr><td class = "col-md-7">
								<select name="searchType" id="searchType" class="form-control input-sm ">
								<option value="rvs_code">By RVS Code</option>
								<option value="classification">By Classification</option>
								</select>
							</td>
							<tr>
						</table>
					</form>
				
			</div>
			<div class="content">
				<div class="text-center">
					<ul class="pagination">
						<?php echo $pagination; ?>
					</ul>
				</div>
				<div class="data"><?php echo $table; ?></div>
			</div>
		</div>
	
	  <!-- page end-->
	</section>
</section>
      <!--main content end-->
	