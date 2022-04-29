<section id="portfolio">
	<div class="container">
		<!-- Page Header -->
		<div class="row">
			<div class="col-lg-12 text-center">
				<hr class="star-primary">
			</div>
		</div>
		<!-- /.row -->

	<!-- Image previews -->	
	<?php	
		$i = 0;
		foreach ($images as $image)
		{
			if ($i % 3 == 0)
				echo "<div class='row'>";
	?>
				
			<div class='col-md-4 portfolio-item' >
				<a href='<?php printf("#imageModal%d", $image->{Image::TABLE_IMAGEID}); ?>' class='portfolio-link' data-toggle='modal'>
					<div class='caption'>
						<div class='caption-content'>
							<i class='fa fa-search-plus fa-3x'></i>
						</div>
					</div>
					<img src='<?php echo $image->{Image::TABLE_IMAGEPATH}; ?>' class='img-responsive ' style='width: 300px; height: 200px;' />
				<h3><?php echo Image::trimTitle( $image->{Image::TABLE_TITLE} ); ?></h3>
				</a>
			</div>
			
	<?php		
			if ($i++ % 3 == 2)
				echo "</div>";
		}
		if ($i % 3 != 0)
			echo "</div>";
	?>
	<!-- End of image previews -->	
	
	<hr>
	
	<!-- Start of image modals -->
	<?php		
		foreach ($images as $image)
		{
	?>
			<div class='portfolio-modal modal fade' id='<?php printf("imageModal%d", $image->{Image::TABLE_IMAGEID}); ?>' tabindex='-1' role='dialog' aria-hidden='true'>
				<div class='modal-content'>
					<div class='close-modal' data-dismiss='modal'>
						<div class='lr'>
							<div class='rl'>
							</div>
						</div>
					</div>
					<div class='container'>
						<div class='row'>
							<div class='col-lg-8 col-lg-offset-2'>
								<div class='modal-body'>
									<h2><?php echo $image->{ Image::TABLE_TITLE }; ?></h2> 
									<hr class='star-primary'>
									<img src='<?php echo $image->{ Image::TABLE_IMAGEPATH } ?>' class='img-responsive img-centered' />
									<p><?php echo $image->{ Image::TABLE_CONTENT }; ?></p>
									<ul class='list item-details'>
										<li>
											Category: 
											<strong><?php echo Image::getCategory( $image -> {Image::TABLE_CATEGORY} ); ?></strong>
										</li>
										<li>
										
										<?php
											$token = strtok($image -> {Image::TABLE_IMAGETAGS}, ", ");
											while ($token !== false) {
												echo '<span class="label label-info" style="font-size: 14px;">' . $token . '</span>';
												$token = strtok(", ");
											}
										?>
											
										</li>
									</ul>
									<button type='button' class='btn btn-default' data-dismiss='modal'><i class='fa fa-times'></i> Close</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	<?php		
		}
	?>
	<!--End of image modals-->
	</div>
</section>