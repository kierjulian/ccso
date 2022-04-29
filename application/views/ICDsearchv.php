<!--main content start-->
<section id="main-content">
<section class="wrapper">	
<!-- page start-->
	
	<div class = "panel">
		<div class="panel-body">	
	<div class = "panel">
		<header class="panel-heading">
			<h2 class="">ICD SEARCH</h2>	
		</header>
		<div class = "panel-body">
			<form class="form-horizontal" method='post'>	
				<select name='ICDdoagnosis'>
					<option value = "" size = "150"> </option>
					<?php			
						$query = $this->db->query("SELECT DISTINCT * FROM discharge_diag WHERE 1");
						$discDiagRows = $query->result();;
						foreach ($discDiagRows as $row)
							echo '<option value="'. $row->Description.'" '.set_select('dischargeDiag', $row->Description).'>'. $row->DCode . ' - ' . $row->Description . '</option>';
					?>
					</select>	
				<input type = 'submit' class='btn btn-primary' id = 'saveDiag' value = 'SUBMIT' disabled = 'disabled' >
				
				</form>
		</div>
	</div>
	
</section>
</section>
      <!--main content end-->