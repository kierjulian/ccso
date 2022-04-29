<!--main content start-->

<script type = "text/javascript">
	function removeFromQueue(visitNum, patientID) {
		$.ajax({  
			type: 'POST',  
			url: "<?php echo base_url()?>queue/dequeue/", 
			data: { 
				ajax_queue_remove	: true,
				patient_id			: patientID,
			},
			success: function(response) {
				alert("Succefully removed patient from the consultation queue.");
			},
			error: function() {
				alert("Unable to remove patient in the database.");
			}
		});	
	}
	
	function removeFromQueueDisplay(visitNum) {
		var 	divID 		= "queueRow" + visitNum;
		
		if ( document.getElementById(divID) == null ) {
			return;
		}
		
		$('#' + divID)
			.find('td')
			.wrapInner('<div style="display: block;" />')
			.parent()
			.find('td > div')
			.slideUp(2000, function(){
				$(this).parent().parent().remove();
			})
		;
			
		var		patientCount	= document.getElementById("patient_count").innerHTML;
		document.getElementById("patient_count").innerHTML = --patientCount;
	}
	
	function addToQueueDisplay() {
	
		var		rowElements		= document.getElementsByClassName("cell_visitnum");
		var		queueLength		= rowElements.length;
		
		if (queueLength > 30) {
			return;
		} 

		var 	lastVisitNum 	= 0;
		if (queueLength > 0) {
			lastVisitNum	= rowElements[queueLength - 1].innerText;
		}
		
		$.ajax({  
			type: 'POST',  
			url: "<?php echo base_url()?>queue/addpoll/", 
			data: { 
				ajax_queue_poll		: true,
				queue_length		: queueLength,
				last_visitnum		: lastVisitNum
			},
			datatype: "xml",
			cache: false,
			success: function(response) {
				response = response.trim();
				if ( response != "" ) {

					response = $.parseXML(response);	
					var			responseCount	= parseInt(response.getElementsByTagName("count")[0].textContent);
					var			patientCount	= parseInt(document.getElementById("patient_count").innerHTML);
					var			newCount		= responseCount + patientCount;
					var			responseText	= "";
					var		nodes 		= response.getElementsByTagName("row");
					var		nodeCount	= nodes.length;
					
					var		index;
					for ( index = 0; index < nodeCount; index++ ) {
						var			visitNo 	= nodes[index].getElementsByTagName("visitno")[0].textContent.trim();
						var			rowID		= nodes[index].getElementsByTagName("dateid")[0].textContent;
						var			rowName		= nodes[index].getElementsByTagName("name")[0].textContent;
						var			rowSex		= nodes[index].getElementsByTagName("sex")[0].textContent;
						var			rowBday		= nodes[index].getElementsByTagName("bday")[0].textContent;
						var			rowTimeIn	= nodes[index].getElementsByTagName("time")[0].textContent;
						var			patientID	= nodes[index].getElementsByTagName("trueid")[0].textContent;
						
						responseText += " <tr id = 'queueRow" + visitNo + "' class = 'queue_row'> <td class = \"cell_visitnum\"><b> " + visitNo + "</b></td><td><b> " + rowID + " </b></td><td><b> " + rowName + " </b></td> <td><b> " + rowSex + " </b></td><td><b> " + rowBday + " </b></td><td><b> " + rowTimeIn + " </b></td><td><div class='btn-group'><a class='btn btn-default' href='<?php echo base_url()?>profile/view/" + patientID + "'><span class='icon_info_alt'></span>&nbsp;&nbsp;<b>View Profile</b></a><a class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" href=\"\"><span class=\"caret\"></span></a><ul class=\"dropdown-menu\"><li><a class='' href='<?php echo base_url()?>doc/index/" + visitNo + "'><span class='icon_plus'></span>&nbsp;&nbsp;Doctors Page</a></li><li><a class='' href='<?php base_url() ?>procedures/index/" + visitNo + "'><span class='icon_plus'></span>&nbsp;&nbsp;<b>Outside Procedures</b></a></li><li><a class='' href='<?php echo base_url() ?>discharge/" + patientID + "'><span class='icon_menu'></span>&nbsp;&nbsp;<b>Discharge</b></a></li><li><a class='' href='#'><span class='icon_close_alt2'></span>&nbsp;&nbsp;<b>Billing</b></a></li><li><a class='' href='#/' onClick='removeFromQueue(\"" + visitNo + "\", \"" + patientID + "\");'><span class='icon_close'></span>&nbsp;&nbsp;<b>Cancel Appointment</b></a></li></ul></div></td></tr>";
					}
					
					document.getElementById("row_placeholder").outerHTML = responseText + "<tr id ='row_placeholder'></tr>";
					document.getElementById("patient_count").innerHTML = newCount;
					alterPaginationButtons(newCount);
				}
	
			},
			error: function() {
				alert("Unable to add patient into queue display.");
			}
		});
		
	}
	
	function alterPaginationButtons(count) {
		count				= parseInt(count);
		
		var			loop;
		var			pageCount;
		var			newCode = "";
		for ( loop = 0, pageCount = 1; loop < count; loop += 30, pageCount++ ) {	
			newCode += "<input type='submit' name='page' class='btn btn-default' value='" + pageCount + "' />";
		}	
		document.getElementById("paginationdiv").innerHTML = newCode;	
	}
	
	function getVisitNums() {
		
		var		rowElements		= document.getElementsByClassName("cell_visitnum");
		var		queueLength		= rowElements.length;
		
		var		returnedString	= "";
		
		var		index;
		for ( index = 0; index < queueLength; index++ ) {
			var		visitNum	= rowElements[index].innerText;		
			returnedString += visitNum + ";";
		}
		
		return 	returnedString;
	
	}
	
	function addPoll() {
		var		rowElements		= document.getElementsByClassName("cell_visitnum");
		var		queueLength		= rowElements.length;
		if (queueLength >= 30) {
			return;
		}
		addToQueueDisplay();
	}
	
	function removePoll() {
		var		visitNums	= getVisitNums();

		$.ajax({  
			type: 'POST',  
			url: "<?php echo base_url() ?>queue/removepoll/", 
			data: { 
				ajax_queue_poll		: true,
				visit_nums			: visitNums,
				delimiter			: ";"
			},
			success: function(response) {
				response = response.trim();

				if ( response != "" ) {
					var		returnedVals		= response.split(";");
					var		valsLength			= returnedVals.length;
				
					var		index;
					for( index = 0; index < valsLength; index++ ) {
						removeFromQueueDisplay( returnedVals[index] );
					}
				}
			},
			error: function() {
				alert("Error in remove poll procedure.");
			}
		});
	
	}

	window.setInterval(removePoll, 5000);
	window.setInterval(addPoll, 5000);
</script>

<section>
<?php if ( !$isPrintable ) { ?>
	<section class="wrapper">
<?php } else { ?>
	<section>
<?php } ?>
	
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header"><i class="fa fa fa-bars"></i> CONSULTATION QUEUE</h2>
			
			<?php if ( !$isPrintable ) { ?>
			<ol class="breadcrumb">
				<li><i class="fa fa-home"></i><a href = "<?php echo base_url(); ?>home">Home</a></li>
				<li><i class="fa fa-bars"></i><a href="">Consultation Queue</a></li>
			</ol>
			<?php } ?>
		</div>
	</div>
	
	<?php if ( !$isPrintable ) { ?>
	
		<div class="row">
			<div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">
					<div class="info-box green-bg">
						<i class="fa fa-info-circle"></i>
						<div class="count" id = "patient_count"><?php echo $count; ?></div>
						<div class="title">On-queue Patients</div>						
					</div><!--/.info-box-->			
				</div><!--/.col-->
			<div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">
					<div class="info-box red-bg">
						<i class="fa fa-times-circle"></i>
						<div class="count"><?php echo $discharged; ?></div>
						<div class="title">Recently discharged</div>						
					</div><!--/.info-box-->			
				</div><!--/.col-->	
		</div>
		
	<?php } else { ?>
	
		<div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">
			<p style="font-size:20px;">On-queue Patients   : <?php echo $count; ?> <p>
		</div>
		
		<div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">
			<p style="font-size:20px;">Recently discharged : <?php echo $discharged; ?></p>
		</div>
	
		<br><br>
	<?php } ?>
	
		<div class="row">	
			<div class="col-lg-12">
                <section class="panel">
                          
                    <table class="table table-striped table-advance table-hover">
                        <tbody>
                            <tr>
								<th><i class="icon_id"></i> Visit No.</th>
                                <th><i class="icon_id"></i> Patient ID</th>
								<th><i class="icon_profile"></i> Name</th>
								<th><i class="icon_question"></i> Sex</th>
								<th><i class="icon_calendar"></i> Birthday</th>
                                <th><i class="icon_clock"></i> Time Admitted</th>
                                <?php if ( !$isPrintable ) {  echo '<th><i class="icon_cogs"></i> Action</th>'; } ?>
                            </tr>
					<?php
						$lastVisitNo = 0;
						foreach ($patients as $patient)
						{	
							$visitNo	= $patient->{Appointment::VISIT_NUMBER};
							$lastVisitNo= $visitNo;
							echo "<tr id = 'queueRow$visitNo' class = 'queue_row'>";
					?>
							
								<td class = "cell_visitnum"><b><?php echo $visitNo; ?></b></td>
								<td><b><?php echo Patient::getPatientID($patient->{Patient::CREATION_DATE}, $patient->{Patient::CREATION_NUM}); ?></b></td>
								<td><b><?php echo Patient::getFullName($patient->{Patient::LAST_NAME}, $patient->{Patient::FIRST_NAME}, $patient->{Patient::MIDDLE_NAME}); ?></b></td>
								<td><b><?php echo Patient::getSex($patient->{Patient::SEX}); ?></b></td>
								<td><b><?php echo Patient::getBirthday($patient->{Patient::BIRTHDAY}); ?></b></td>
								<td><b><?php echo Appointment::getTime($patient->{Appointment::TIME_IN}); ?></b></td>
												
					<?php 
							if ( !$isPrintable ) { 
								$patientID 	= $patient->{Patient::TRUE_ID};
					?>
								<td>									
									<div class='btn-group'>
										<a class='btn btn-default' href='<?php echo base_url(); ?>profile/view/<?php echo $patient->{Patient::TRUE_ID}; ?>'><span class='icon_info_alt'></span>&nbsp;&nbsp;<b>View Profile</b></a>
										<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href=""><span class="caret"></span></a>
										<ul class="dropdown-menu">
										<?php if($this->session->userdata("acsDP")){
												echo "<li><a class='' href='".base_url()."doctor/index/".$patient->{Appointment::VISIT_NUMBER}."'><span class='icon_plus'></span>&nbsp;&nbsp;Doctor's Page</a></li>";
												echo "<li><a class='' href='".base_url()."procedures/index/".$patient->{Appointment::VISIT_NUMBER}."'><span class='icon_plus'></span>&nbsp;&nbsp;Outside Procedures</a></li>";
											}?>
										<?php if($this->session->userdata("acsBil")){
												echo "<li><a class='' href='".base_url()."billing/searchByName?first_name=" . $patient->{Patient::FIRST_NAME} . "&last_name=". $patient->{Patient::LAST_NAME} . "&searched=searched'><span class='icon_menu'></span>&nbsp;&nbsp;Billing</a></li>";
											}?>
										<?php if($this->session->userdata("acsDis")){
												echo "<li><a class='' href='".base_url()."discharge/".$patient->{Patient::TRUE_ID}."'><span class='icon_close_alt2'></span>&nbsp;&nbsp;Discharge</a></li>";
											}?>
										
										<?php 
											echo "<li><a class='' href='#/' onClick='removeFromQueue(\"$visitNo\", \"$patientID\");'><span class='icon_close'></span>&nbsp;&nbsp;<b>Cancel Appointment</b></a></li>";
										?>
										</ul>
									</div>
								</td>
								
					<?php
							} // if
							echo "</tr>";
						} // foreach
					?>

							<tr id ="row_placeholder"></tr>
					  
					  
                        </tbody>
                    </table>
                </section>
            </div>
		</div>
		<form method='get'>
					<!-- Pagination -->
			<div id = "paginationdiv" class="text-center">
		<?php
			if (!$isPrintable) {
				for ($i = 1; $i <= ceil($count/30); $i++)
				{
		?>
				<input type='submit' name='page' class='btn btn-default' value='<?php echo $i; ?>' />
		<?php
				}
			echo "
			</div>
			<div class ='text-center'>
				<br>$printableLink
			</div>

			";
			
			}
		?>
			
		</form>
	</section>
</section>
<!--main content end-->