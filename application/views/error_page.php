<section id="main-content">
	<section class="wrapper">
		<div class="page-404">
			<p class="text-404">404</p>
			
			<?php
				if ( !isset($message) ) {
					$message = "Something went wrong. No detailed description of error.";
				}
				if ( !isset($linkPath) ) {
					$linkPath = base_url() . "home/";
				}
				if ( !isset($linkName) ) {
					$linkName = "Return Home";
				}
			?>
			
			<h2>Aww Snap!</h2>
			<p> <?php echo "$message <br><a href = '$linkPath'>$linkName</a>" ?> </p>
		</div>
	</section>
</section>