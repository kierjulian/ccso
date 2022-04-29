<!--main content start-->
<section id="main-content">
	<section class = "wrapper">
	
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header"><i class="fa fa fa-pencil-square-o"></i>MANAGE HEALTH CARDS</h3>
			
			<ol class="breadcrumb">
				<li><i class="fa fa-home"></i><a href='<?php echo base_url(); ?>home'>Home</a></li>
				<li><i class="fa fa-pencil-square-o"></i><a href="<?php echo base_url(); ?>admit/cards">Healthcards</a></li>
			</ol>
			
		</div>
	</div>
	
	<hr>
	
	<form method='post' action='<?php echo $_SERVER["REQUEST_URI"]; ?>'>
		<div class="row">
			<div class="col-sm-6">	
				<div class="form-group col-sm-5">
					<input type="text" name='name' class="form-control" placeholder="Name" />
				</div>
				<div class="form-group col-sm-6">
					<input type="submit" class="btn btn-default" style="font-weight:bold;" name='create' value='Add card' />
				</div>
			</div>
		</div>
	</form>	
	
	<hr>
		
	<div class="row">	
		<div class="col-lg-12">
			<section class="panel">
					  
				<table class="table table-striped table-advance table-hover">
					<tbody>
						<tr>
							<th><i class="icon_id"></i>Health Card name</th>
							<th><i class="icon_cogs"></i> Action</th>
						</tr>
		<?php
					foreach ($cards as $card)
					{
						if ($card->{HealthCard::CARD_TYPE} != 1)
						{
							
		?>
						<tr>
							<td><b><?php echo $card->{HealthCard::CARD_NAME}; ?></b></td>														
							<td>
								<form method='post' action='<?php echo $_SERVER["REQUEST_URI"]; ?>'>
									<input type='hidden' name='type' value='<?php echo $card->{HealthCard::CARD_TYPE}; ?>' />
									<input type='submit' name='delete' class='btn btn-danger' value='Delete' />
								</form>	
							</td>							
						</tr>
		<?php
						}
					}	
		?>
												  
					</tbody>
				</table>
			</section>
		</div>
	</div>
	
	</section>
</section>
<!--main content end-->