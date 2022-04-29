<!--main content start-->
<section id="main-content">
	
	<section class="wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header"><i class="fa fa fa-bars"></i>CCSO Users</h2>
			<ol class="breadcrumb">
				<li><i class="fa fa-home"></i><a href='<?php echo base_url(); ?>home'>Home</a></li>
			</ol>
		</div>
	</div>
	
		<div class="row">	
			<div class="col-lg-12">
                <section class="panel">
                          
                    <table class="table table-striped table-advance table-hover">
                        <tbody>
                            <tr>
								<th><i class="icon_id"></i> Username</th>
								<th><i class="icon_profile"></i> Name</th>
								<th><i class="icon_contacts"></i> Contact Details</th>
								<th colspan=2><i class="icon_documents_alt"></i> Employment Details</th>
                                <th><i class="icon_cogs"></i> Action</th>
                            </tr>
					<?php
						foreach ($users as $user)
						{	
					?>
							<tr>
								<td><?php echo $user['user']->uName; ?></td>
								<td><?php echo $user['user']->lName . ", " . $user['user']->fName . " " . $user['user']->mName; ?></td>
								<td><select name='contact'>
										<option><?php echo $user['user']->eAddr ?></option>
										<option><?php echo $user['user']->contactNo ?></option>
								    </select></td>
								<td>
									<?php foreach($user['jobs'] as $job){
										echo "<option>" . $job->job_name . "</option>"; 
									} ?>
								</td>	
								<td><?php echo $user['user']->doe ?></td>	
								<td>
									<div class='btn-group'>
										<a class='btn btn-default' onclick="javascript:deleteConfirm('<?php echo base_url().'user/delete_user/'.$user['user']->idDoc;?>');" deleteConfirm href="#"><span class='icon_close_alt2'></span>&nbsp;&nbsp;DELETE</a>
										<a class='btn btn-default' href="<?php echo base_url().'user/edit_user/'.$user['user']->idDoc;?>"><span class='icon_pencil'></span>&nbsp;&nbsp;EDIT</a>
									</div>
								</td>
							</tr>
					<?php
						}
					?>
                        </tbody>
                    </table>
                </section>
            </div>
			<div class="text-center">
				<ul class="pagination">
					<li><a href="#">«</a></li>
					<li><a href="#">1</a></li>
					<li><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li><a href="#">4</a></li>
					<li><a href="#">5</a></li>
					<li><a href="#">»</a></li>
				</ul>
			</div>
        </div>
	</section>
</section>
<!--main content end-->