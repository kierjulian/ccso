      <!--main content start-->
<!--<section id="main-content">
	<!--<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header">Discharge</h3>
		</div>
	</div>
	  <!-- page start-->
	 	 <?php 
			$this->load->helper('url');
			$this->load->helper('html');
			$this->load->helper('additional_html');
			$this->load->helper('form');
			$this->load->helper('table');
		
			echo '<section id="main-content"><section class="wrapper">';
			echo sing_tag('title', 'Discharge');
			echo link_tag('assets/css/discharge.css');
			echo "<script src = ".base_url()."assets/js/actionDischarge.js>";
			echo add_tag('script', array('src' => 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'));
			echo '</script>';
			if ($serverMsg != '')
				echo '<script language = "javascript">alert("'.$serverMsg.'")</script>';
			echo '<style>';
			
			//counts checkers
			$lab = 1;
			$rad = 1;
			$othersCnt = 1;
			$bioCnt = 1;
			$vtfCnt = 1;
			$octCnt = 1;
			$discPCnt = 1;
			$cctCnt = 1;
			$bScanCnt = 1;
			$maculaCnt = 1;
			$fundusCnt = 1;
			
			if (set_checkbox('labProc','Laboratory')===''){
				echo '#labTxt{
						display:none;
					  }';
				$lab = 0;
			}
			if (set_checkbox('labProc','Radiology')===''){
				echo '#radTxt{
						display:none;
					  }';
				$rad = 0;
			}
			if (set_checkbox('labProc','Others')===''){
				echo '#otherProcedures{
						display:none;
					  }';
				$othersCnt = 0;
			}
			if (set_checkbox('cataract','Biometry')===''){
				echo '#biometry{
						display:none;
					  }';
				$bioCnt = 0;
			}
			if (set_checkbox('glaucoma','Visual Test Field')===''){
				echo '#vtf{
						display:none;
					  }';
				$vtfCnt = 0;
			}
			if (set_checkbox('glaucoma','OCT (DISC/RNFL)')===''){
				echo '#oct{
						display:none;
					  }';
				$octCnt = 0;
			}
			if (set_checkbox('glaucoma','Disc Photo')===''){
				echo '#discPhoto{
						display:none;
					  }';
				$discPCnt = 0;
			}
			if (set_checkbox('glaucoma','Center Corneal Thickness')===''){
				echo '#cct{
						display:none;
					  }';
				$cctCnt = 0;
			}
			if (set_checkbox('retina','B-Scan')===''){
				echo '#BScan{
						display:none;
					  }';
				$bScanCnt = 0;
			}
			if (set_checkbox('retina','Oct (Macula)')===''){
				echo '#macula{
						display:none;
					  }';
				$maculaCnt = 0;
			}
			if (set_checkbox('retina','Fundus Photo')===''){
				echo '#fundus{
						display:none;
					  }';
				$fundusCnt = 0;
			}
			echo '</style>';
			
			//start forms
			$urlForm = 'discharge/' . $patientID;
			echo form_open_multipart($urlForm);
			
			
			//ptr FORM
			echo div('ptrForm');
			echo '<label id="labl"> Current PTR #: </label>';
			echo nbs(5);
			echo form_input(array('name'=>'newPtr','id'=>'textBx', 'value'=>$ptr->ptrNum));
			echo nbs(5);
			echo form_submit(array('name'=>'updatePtr', 'value'=>'Update', 'class'=>'btn btn-warning'));
			echo '</div>';
			
			?>
			
			<br />
			<div class="panel panel-primary">
				<div class="panel-heading"> <!--PRESCRIPTION FORM PANEL-->
					<font size=3px class="" id='prescription'>PRESCRIPTION FORM</font>	
				</div>
			
			<?php
			echo div('table');
			echo div('right', 'right');
			echo '<label id="labl"> *Date: </label>';
			echo nbs(3);
			echo form_input(array('type' => 'date', 'name' => 'date', 'class' => 'info', 'id'=>'dateStyle', 'required'),set_value('date'));
			echo '</div><br>';
			echo '<label id="labl"> Name: </label>';
			echo nbs(5);
			echo form_input(array('name'=>'name','id'=>'uneditableBx', 'size' => '50', 'readonly'=>'readonly'
			, 'value'=>is_array($patient) ? $patient['name'] : $patient->name));
			echo nbs(15);
			echo '<label id="labl"> Age: </label>';
			echo nbs(5);
			echo form_input(array('name'=>'Age','id'=>'uneditableBx', 'size' => '5', 'readonly'=>'readonly'
			, 'value'=>is_array($patient) ? $patient['age'] : $patient->age));
			echo nbs(15);
			echo 'Sex:';
			echo nbs(5);echo form_input(array('name'=>'sex','id'=>'uneditableBx', 'size' => '5', 'readonly'=>'readonly'
			, 'value'=>is_array($patient) ? $patient['sex'] : $patient->sex));
			echo br(2);
			
			
			echo div('medPresc');
			echo "<div class='form-group'>";
			echo '<div class="panel-heading"><b><center> MEDICATION </b></center></div>';
			echo br(2);
			echo div('medP');
			$medCnt = 0;
			if($meds!=NULL){
				echo div('medy');
				foreach ($meds as $med){
					$medCnt++;
					echo form_input(array('id'=>'uneditableBx', 'name'=>'gName1','placeholder'=>'Generic Name', 'required', 'class'=>'input', 'size'=>'48', 'readonly'=>'readonly', 'value'=>$med->MED_GENERIC));
					echo nbs(2);
					echo form_input(array('id'=>'uneditableBx', 'name'=>'dName1', 'placeholder'=>'Drug Name', 'required', 'class'=>'input', 'size'=>'49', 'readonly'=>'readonly', 'value'=>$med->MED_BRAND));
					echo nbs(1);
					echo form_input(array('class'=>'input', 'name'=>'qty'.$medCnt, 'placeholder'=>'Quantity - Please Fill Out', 'required', 'class'=>'input', 'size'=>'102.9', 'style'=>'margin: 5px 0 0 0;'),set_value('qty'.$medCnt));
					echo nbs(1);
					echo '<br>'."\n".'<id="info"><b>Sig</b><br>';
					echo form_textarea(array('id'=>'tableCell','name'=>'sig1','required', 'class'=>'input', 'height'=>'40', 'size' => '50', 'rows'=>'3', 'cols'=>'101', 'readonly'=>'readonly', 'value'=>$med->MED_SIG));
					echo br(2);
					echo br(1);
				}
				
				echo form_hidden('medCount', $medCnt);
				echo '</div>';
			}	
			else 
				echo "<br><b><center>There are no recommended medicines!</center></b><br><br>";		
			
			echo '</div></div></div>';
			//eye prescription
			echo div('eyePresc');
			echo "<div class='form-group'>";
			echo '<div class="panel-heading"><b> EYE PRESCRIPTION </b></div>';
			echo br(2);
			if($eyeP != NULL){
				echo '<label id="labl"> Date of Rx Recommendation: </label>';
				echo nbs(5);
				echo explode(' ', $eyeP->date_rx_recommendation)[0];
				$table = array('border' => '5px', 'width'=> '50%', 'height' => '30%', 'cellpadding' => '5px', 'cellspacing' => '0px','align'=>'center','id'=>'eyetab', 'margin'=>'15px');
				echo div('eyeP');
				echo table_create($table);
				echo '<tr><th></th><th>SPHERE</th><th>CYLINDER</th><th>AXIS</th><th>PRISM</th><th>ADDS</th><th>Prism Direction</th><th>DISTANCE PD</th><th>NEAR PD</th></tr>';			
				echo tr(array('OD', form_input(array('id'=>'uneditableBx', 'name'=>'ods', 'rows' => '1', 'style' => 'width: 6em', 'id'=>'tableCell', 'readonly'=>'readonly', 'value' => $eyeP->od_sphere)), 
					form_input(array('id' => 'odc','name'=>'odc', 'rows' => '1', 'style' => 'width: 6em', 'id'=>'tableCell', 'readonly'=>'readonly', 'value' => $eyeP->od_cylinder)), 
					form_input(array('id' => 'oda','name'=>'oda', 'rows' => '1', 'style' => 'width: 6em', 'id'=>'tableCell', 'readonly'=>'readonly', 'value' => $eyeP->od_axis)), 
					form_input(array('id' => 'odp','name'=>'odp', 'rows' => '1', 'style' => 'width: 6em', 'id'=>'tableCell', 'readonly'=>'readonly', 'value' => $eyeP->od_prism)), 
					form_input(array('id' => 'odadd','name'=>'odadd', 'rows' => '1', 'style' => 'width: 6em', 'id'=>'tableCell', 'readonly'=>'readonly', 'value' => $eyeP->od_adds)), 
					form_input(array('id' => 'odb','name'=>'odb', 'rows' => '1', 'style' => 'width: 6em', 'id'=>'tableCell', 'readonly'=>'readonly', 'value' => $eyeP->od_basein)),
					form_input(array('id' => 'oddpd','name'=>'oddpd', 'rows' => '1', 'style' => 'width: 6.5em', 'id'=>'tableCell', 'readonly'=>'readonly', 'value' => $eyeP->od_distancePD)),
					form_input(array('id' => 'odnpd','name'=>'odnpd', 'rows' => '1', 'style' => 'width: 6.5em', 'id'=>'tableCell', 'readonly'=>'readonly', 'value' => $eyeP->od_nearPD))));
				echo tr(array('OS', form_input(array('id' => 'oss','name'=>'oss', 'rows' => '1', 'style' => 'width: 6em', 'id'=>'tableCell', 'readonly'=>'readonly', 'value' => $eyeP->os_sphere)), 
					form_input(array('id' => 'osc','name'=>'osc', 'rows' => '1', 'style' => 'width: 6em', 'id'=>'tableCell', 'readonly'=>'readonly', 'value' => $eyeP->os_cylinder)), 
					form_input(array('id' => 'osa','name'=>'osa', 'rows' => '1', 'style' => 'width: 6em', 'id'=>'tableCell', 'readonly'=>'readonly', 'value' => $eyeP->os_axis)), 
					form_input(array('id' => 'osp','name'=>'osp', 'rows' => '1', 'style' => 'width: 6em', 'id'=>'tableCell', 'readonly'=>'readonly', 'value' => $eyeP->od_prism)),
					form_input(array('id' => 'osadd','name'=>'osadd', 'rows' => '1', 'style' => 'width: 6em', 'id'=>'tableCell', 'readonly'=>'readonly', 'value' => $eyeP->od_adds)),				
					form_input(array('id' => 'osb','name'=>'osb', 'rows' => '1', 'style' => 'width: 6em', 'id'=>'tableCell', 'readonly'=>'readonly', 'value' => $eyeP->od_basein)),
					form_input(array('id' => 'osdpd','name'=>'osdpd', 'rows' => '1', 'style' => 'width: 6.5em', 'id'=>'tableCell', 'readonly'=>'readonly', 'value' => $eyeP->od_distancePD)),
					form_input(array('id' => 'osnpd','name'=>'osnpd', 'rows' => '1', 'style' => 'width: 6.5em', 'id'=>'tableCell', 'readonly'=>'readonly', 'value' => $eyeP->od_nearPD))));
					
				echo "<tr><td colspan=7 align='right'>TOTAL</td><td>".form_input(array('id' => 'totald','name'=>'totald', 'rows' => '1', 'style' => 'width: 6.5em', 'id'=>'tableCell', 
					'value' => set_value('totald')))."</td>"."<td>".form_input(array('id' => 'totaln','name'=>'totaln', 'rows' => '1', 'style' => 'width: 6.5em', 'id'=>'tableCell', 
					'value' => set_value('totaln')))."</td></tr>";
					
				echo table_end();
				echo '</div>';
			}	
			else 
				echo "<br><b>There is no eyeglass prescription!</b><br><br>";		
			echo '</div></div><br></div>';
			
			?>
			</div>
			<div class="panel panel-primary">
			<div class="panel-heading"> <!--DISCHARGE FORM PANEL-->
				<font size=3 class="" id='discharge'>DISCHARGE FORM</font>	
			</div>
			
			<?php
			echo div('table');
			echo '<table border=1 width="900px" cellpadding="10px" id="disTable">';
			echo '<tr><td colspan="5"><label id="labl"> Name: </label>';
			echo nbs(5);
			echo form_input(array('name'=>'name2','id'=>'uneditableBx', 'size' => '50', 'readonly'=>'readonly'
			, 'value'=>is_array($patient) ? $patient['name'] : $patient->name));
			echo '</td>';			
			echo '<td colspan="3" align="right"><label id="labl"> Date of Birth: </label>';
			echo nbs(5);
			echo form_input(array('name'=>'dob','id'=>'uneditableBx', 'size' => '10', 'readonly'=>'readonly'
			, 'value'=>is_array($patient) ? $patient['birthday'] : $patient->birthday));
			echo '</td></tr>';
			
			echo '<tr><td colspan="5"><label id="labl"> *Hospital #: </label>';
			echo nbs(5);
			echo form_input(array('name' => 'hospitalNum', 'class' => 'input', 'style' => 'width: 7em', 'min' => '1', 'required'),set_value('hospitalNum'));			
			echo '</td>';
			echo '<td colspan="3" align="right"><label id="labl"> *Date of Consultation: </label>';
			echo nbs(2);
			echo form_input(array('type' => 'date', 'name' => 'doc', 'class' => 'info', 'id' => 'dateStyle', 'required'), set_value('doc'));			
			echo '</td></tr>';
			echo '<tr><td colspan=8><label id="labl"> *Chief Complaint: </label>';
			echo nbs(5);
			echo form_input(array('name'=>'cComp', 'required', 'class'=>'input', 'size'=>'105'),set_value('cComp'));
			echo '</td></tr><tr><td colspan=8>';
			echo '<label id="labl"> Discharge Diagnosis: </label>';
			echo nbs(5);
			$cnt = 1;
			if($discCodes != NULL){
				foreach($discCodes as $dCode){
					echo '<br/>';
					echo form_input(array('name'=>'dCode'.$cnt,'id'=>'uneditableBx', 'size' => '99', 'readonly'=>'readonly', 'value' => $dCode->ICD10_DIAGNOSIS));
					$cnt++;
				}
			} else echo " <strong>No diagnosis given.</strong>";
			echo '</td></tr><tr><td colspan=8>';
				// Procedures Performed
			echo '<label id="labl"> Procedures Performed: </label>';
			echo nbs(5);
			echo form_input(array('name'=>'procPerf', 'class'=>'input', 'size'=>'99', 'height'=>'50', 'rows'=>'2', 'cols'=>'95'),set_value('procPerf'));	
			echo '</td></tr><tr><td colspan=8>';
			// Lab Procedures for Follow-up
			echo '<label id="labl" style="font-size:15px;"> Diagnostic Procedures for Follow-Up:</label>';
			echo br(1);
		
				echo '<script>
					var labCnt = '.$lab.';
					var radCnt = '.$rad.';
					var othersCnt = '.$othersCnt.';
					var bioCnt = '.$bioCnt.';
					var vtfCnt = '.$vtfCnt.';
					var octCnt = '.$octCnt.';
					var discPCnt = '.$discPCnt.';
					var cctCnt = '.$cctCnt.';
					var bScanCnt = '.$bScanCnt.';
					var maculaCnt = '.$maculaCnt.';
					var fundusCnt = '.$fundusCnt.';
					
					function viewBox(val){
						if(val == "Laboratory"){
							viewLab();
							labCnt++;
						}	
						else if(val == "Radiology"){
							viewRad();
							radCnt++;	
						}
						else if(val == "Others"){
							viewOthers();
							othersCnt++;
						}
						else if(val == "Biometry"){
							bioCnt++;
							viewBiometry();	
						}	
						else if(val == "Visual Test Field"){
							vtfCnt++;
							viewVTF();
						}
						else if(val == "OCT (DISC/RNFL)"){
							octCnt++;
							viewOct();
						}
						else if(val == "Disc Photo"){
							discPCnt++;
							viewDiscPhoto();
						}
						else if(val == "Center Corneal Thickness"){
							cctCnt++;
							viewCCT();
						}
						else if(val == "B-Scan"){
							bScanCnt++;
							viewBScan();
						}
						else if(val == "Oct (Macula)"){
							maculaCnt++;
							viewMacula();
						}
						else if(val == "Fundus Photo"){
							fundusCnt++;
							viewFundus();
						}
						
						
					}
					
					function viewLab(){
						if (labCnt % 2 == 0)
							$(labTxt).show();
						else 
							$(labTxt).hide();
					}
					
					function viewRad(){
						if (radCnt % 2 == 0)
							$(radTxt).show();
						else 
							$(radTxt).hide();
					}
					
					function viewOthers(){
						if (othersCnt % 2 == 0)
							$(otherProcedures).show();
						else 
							$(otherProcedures).hide();
					}
					
					function viewBiometry(){
						if (bioCnt % 2 != 0)
							$(biometry).show();
						else 
							$(biometry).hide();	
					}
					
					function viewVTF(){
						if (vtfCnt % 2 != 0)
							$(vtf).show();
						else 
							$(vtf).hide();	
					}
					
					function viewOct(){
						if (octCnt % 2 != 0)
							$(oct).show();
						else 
							$(oct).hide();
					}
					
					function viewDiscPhoto(){
						if (discPCnt % 2 != 0)
							$(discPhoto).show();
						else 
							$(discPhoto).hide();
					}
					
					function viewCCT(){
						if (cctCnt % 2 != 0)
							$(cct).show();
						else 
							$(cct).hide();
					}
					
					function viewBScan(){
						if (bScanCnt % 2 != 0)
							$(BScan).show();
						else 
							$(BScan).hide();
					}
					
					function viewMacula(){
						if (maculaCnt % 2 != 0)
							$(macula).show();
						else 
							$(macula).hide();
					}
					
					function viewFundus(){
						if (fundusCnt % 2 != 0)
							$(fundus).show();
						else 
							$(fundus).hide();
					}
					
					function seePrev(){
						viewBiometry();
						viewVTF();
						viewOct();
						viewDiscPhoto();
						viewCCT();
						viewBScan();
						viewMacula();
						viewFundus();						
					}
				</script>';
			echo '<body onload = "seePrev()"> </body>';
			$radData = array('name'=>'labProc[]', 'value' => 'Laboratory', 'onClick' => 'viewBox(this.value)', 
							 'checked' => set_checkbox('labProc', 'Laboratory'));
			echo nbs(8);
			echo form_checkbox($radData);
			echo nbs(3);
			echo 'Laboratory';
			echo nbs(5);
			echo form_input(array('id'=>'labTxt', 'name'=>'labAdd', 'class'=>'input', 'placeholder'=>'Additional Remarks', 'class'=>'input'),set_value('labAdd'));
			echo br(2);
			$radData['value'] ='Radiology';
			$radData['checked'] = set_checkbox('labProc', 'Radiology');
			echo nbs(8);
			echo form_checkbox($radData);
			echo nbs(3);
			echo 'Radiology';
			echo nbs(8);
			echo form_input(array('id'=>'radTxt', 'name'=>'radAdd', 'placeholder'=>'Additional Remarks', 'class'=>'input'),set_value('radAdd'));
			echo br(2);
			$radData['value'] ='Others';
			$radData['checked'] = set_checkbox('labProc', 'Others');
			echo nbs(8);
			echo form_checkbox($radData);
			echo nbs(3);
			echo 'Others';
			echo br(2);
			
			// Start of Others ------------------------------------------------------------------------------------
			// ----------------------------------------------------------------------------------------------------
			
			echo div ('otherProcedures');
				echo div ('procedureExtras');
				
					echo '<b>CATARACT</b>';
						echo br(1);
						echo nbs(10);
						
						$radData = array('name'=>'cataract[]', 'value' => 'Biometry', 'onClick' => 'viewBox(this.value)', 'checked' => set_checkbox('cataract', 'Biometry'));
						echo form_checkbox($radData);
						echo nbs(3);
						echo '<label id="textOnly"> Biometry </label>';
						echo br(1);
						echo div('biometry');
							echo nbs(20);
							echo form_checkbox('bioOpts[]','OD', set_checkbox('bbioOpts', 'OD'));
							echo nbs(3);
							echo'OD'; 
							echo nbs(10);
							echo form_checkbox('bioOpts[]','OS', set_checkbox('bioOpts', 'OS'));  
							echo nbs(3);
							echo'OS';
							echo br(1);
						echo '</div>';
						
						$radData = array('name'=>'cataract[]', 'value' => 'Endothelial Cell Count', 'onClick' => 'viewBox(this.value)', 'checked' => set_checkbox('cataract', 'Endothelial Cell Count'));
						echo nbs(10);
						echo form_checkbox($radData);
						echo nbs(3);
						echo '<label id="textOnly"> Endothelial Cell Count </label>';
						echo br(2);
			
					echo '<b>GLAUCOMA</b>';
						echo br(1);
						echo nbs(10);
						$radData = array('name'=>'glaucoma[]', 'value' => 'Visual Test Field', 'onClick' => 'viewBox(this.value)', 'checked' => set_checkbox('glaucoma', 'Visual Test Field'));
						echo form_checkbox($radData);
						echo nbs(3);
						echo '<label id="textOnly"> Visual Test Field </label>';
						echo '<br>';
						echo div ('vtf');
							echo nbs(20);
							echo form_checkbox('visTestOpts[]','OD', set_checkbox('visTestOpts', 'OD'));
							echo nbs(3);
							echo'OD';
							echo nbs(10);
						echo form_checkbox('visTestOpts[]','OS', set_checkbox('visTestOpts', 'OS'));
							echo nbs(3);
							echo'OS <br />';
						echo '</div>';
			
						echo nbs(10);
						$radData = array('name'=>'glaucoma[]', 'value' => 'OCT (DISC/RNFL)', 'onClick' => 'viewBox(this.value)', 'checked'=>set_checkbox('glaucoma', 'OCT (DISC/RNFL)'));
						echo form_checkbox($radData);
						echo nbs(3);
						echo '<label id="textOnly"> OCT (DISC/RNFL) </label>';
						echo br(1);
						echo div ('oct');
							echo nbs(20);
							echo form_checkbox('octOpts[]','OD', set_checkbox('octOpts', 'OD'));
							echo nbs(3);
							echo'OD';
							echo nbs(10);
							echo form_checkbox('octOpts[]','OS', set_checkbox('octOpts', 'OS'));
							echo nbs(3);
							echo'OS <br />';
						echo '</div>';
						
						echo nbs(10);
						$radData = array('name'=>'glaucoma[]', 'value' => 'Disc Photo', 'onClick' => 'viewBox(this.value)', 'checked' => set_checkbox('glaucoma', 'Disc Photo'));
						echo form_checkbox($radData);
						echo nbs(3);
						echo '<label id="textOnly"> Disc Photo </label>';
						echo br(1);
						echo div('discPhoto');
							echo nbs(20);
							echo form_checkbox('discPhotoOpts[]','OD', set_checkbox('discPhotoOpts', 'OD'));
							echo nbs(3);
							echo'OD';
							echo nbs(10);
							echo form_checkbox('discPhotoOpts[]','OS', set_checkbox('discPhotoOpts', 'OS'));
							echo nbs(3);
							echo'OS <br />';
						echo '</div>';
							
						echo nbs(10);
						$radData = array('name'=>'glaucoma[]', 'value' => 'Center Corneal Thickness', 'onClick' => 'viewBox(this.value)', 'checked'=>set_checkbox('glaucoma', 'Center Corneal Thickness'));
						echo form_checkbox($radData);
						echo nbs(3);
						echo '<label id="textOnly"> Center Corneal Thickness </label>';
						echo br(1);
						echo div('cct');
							echo nbs(20);
							echo form_checkbox('cctOpts[]','OD', set_checkbox('cctOpts', 'OD'));
							echo nbs(3);
							echo'OD';
							echo nbs(10);
							echo form_checkbox('cctOpts[]','OS', set_checkbox('cctOpts', 'OS'));
							echo nbs(3);
							echo'OS';
							echo br(1);
						echo '</div>';
						
						echo 'Date of previous test:';
						echo nbs(2);
						echo form_input(array('type' => 'date', 'id' => 'dateStyle', 'name' => 'prevDateGlauc'), set_value('prevDateGlauc'));
						echo br(2);
			
					echo '<b>RETINA</b>';
					echo br(1);
						echo nbs(10);
						$radData = array('name'=>'retina[]', 'value' => 'B-Scan', 'onClick' => 'viewBox(this.value)', 'checked' => set_checkbox('retina', 'B-Scan'));
						echo form_checkbox($radData);
						echo nbs(3);
						echo '<label id="textOnly"> B-Scan </label>';
						echo br(1);
						echo div('BScan');
							echo nbs(20);
							echo form_checkbox('BScanOpts[]','OD', set_checkbox('BScanOpts', 'OD'));
							echo nbs(3);
							echo 'OD';
							echo nbs(10);
							echo form_checkbox('BScanOpts[]','OS', set_checkbox('BScanOpts', 'OS'));
							echo nbs(3);
							echo'OS <br />';
						echo '</div>';
			
						echo nbs(10);
						$radData = array('name'=>'retina[]', 'value' => 'Oct (Macula)', 'onClick' => 'viewBox(this.value)', 'checked'=>set_checkbox('retina', 'Oct (Macula)'));
						echo form_checkbox($radData);
						echo nbs(3);
						echo '<label id="textOnly"> Oct (Macula) </label>';
						echo br(1);
						echo div('macula');
							echo nbs(20);
							echo form_checkbox('maculaOpts[]','OD', set_checkbox('maculaOpts', 'OD'));
							echo nbs(3);
							echo'OD';
							echo nbs(10);
							echo form_checkbox('maculaOpts[]','OS', set_checkbox('maculaOpts', 'OS'));
							echo nbs(3);
							echo'OS <br />';
						echo '</div>';
							
						echo nbs(10);
						$radData = array('name'=>'retina[]', 'value' => 'Fluorescein Angiography', 'onClick' => 'viewBox(this.value)', 'checked'=>set_checkbox('retina', 'Fluorescein Angiography'));
						echo form_checkbox($radData);
						echo nbs(3);
						echo '<label id="textOnly"> Fluorescein Angiography </label>';
						echo '<br>';
						
						echo nbs(10);
						$radData = array('name'=>'retina[]', 'value' => 'Fundus Photo', 'onClick' => 'viewBox(this.value)', 'checked' => set_checkbox('retina', 'Fundus Photo'));
						echo form_checkbox($radData);
						echo nbs(3);
						echo '<label id="textOnly"> Fundus Photo </label>';
						echo br(1);
						echo div('fundus');
							echo nbs(20);
							echo form_checkbox('fundusOpts[]','OD', set_checkbox('fundusOpts', 'OD'));
							echo nbs(3);
							echo'OD';
							echo nbs(10);
							echo form_checkbox('fundusOpts[]','OS', set_checkbox('fundusOpts', 'OS'));
							echo nbs(3);
							echo'OS';
							echo br(1);
						echo '</div>';
							
						echo 'Date of previous test:';
						echo nbs(2);
						echo form_input(array('type' => 'date', 'id' => 'dateStyle', 'name' => 'prevDateRet'), set_value('prevDateRet'));
						echo br(2);
			
			echo '<b>ADDITIONAL PROCEDURES</b>';
			echo br(1);
			echo nbs(10);
			echo form_checkbox('addProc[]','Dilate', set_checkbox('addProc', 'Dilate'));
			echo nbs(3);
			echo '<label id="textOnly"> Dilate </label>';
			echo nbs(10);
			echo form_checkbox('addProc[]','Constrict', set_checkbox('addProc', 'Constrict'));
			echo nbs(3);
			echo '<label id="textOnly"> Constrict </label>';
			echo nbs(10);
			echo form_checkbox('addProc[]','AS IS', set_checkbox('addProc', 'AS IS'));
			echo nbs(6);
			echo '<label id="textOnly"> AS IS</label>';
			echo '<br>';
			echo nbs(10);
			echo form_checkbox('addProc[]','OD', set_checkbox('addProc', 'OD'));
			echo nbs(3);
			echo '<label id="textOnly"> OD </label>';
			echo nbs(15);
			echo form_checkbox('addProc[]','OS', set_checkbox('addProc', 'OS'));
			echo nbs(3);
			echo '<label id="textOnly"> OS </label>';
			echo nbs(25);
			echo form_checkbox('addProc[]','OU', set_checkbox('addProc', 'OU'));
			echo nbs(3);
			echo '<label id="textOnly"> OU </label>';
			echo '</div>';
	
			echo div ('righthalf');
			echo '<b>LASER:</b>';
			echo br(1);
			echo nbs(15);
			echo form_checkbox('laser[]','PRP', set_checkbox('laser', 'PRP'));
			echo nbs(3);
			echo '<label id="textOnly"> PRP </label>';
			echo nbs(45);
			echo form_checkbox('laser[]','PASCAL', set_checkbox('laser', 'PASCAL'));
			echo nbs(3);
			echo '<label id="textOnly"> PASCAL </label>';
			echo '<br>';
			echo nbs(15);
			echo form_checkbox('laser[]','FOCAL', set_checkbox('laser', 'FOCAL'));
			echo nbs(3);
			echo '<label id="textOnly"> FOCAL </label>';
			echo nbs(38);
			echo form_checkbox('laser[]','532nm DIODE', set_checkbox('laser', '532nm DIODE'));
			echo nbs(3);
			echo '<label id="textOnly"> 532nm DIODE </label>';
			echo '<br>';
			echo nbs(15);
			echo form_checkbox('laser[]','LIO', set_checkbox('laser', 'LIO'));
			echo nbs(3);
			echo '<label id="textOnly"> LIO </label>';
			echo nbs(46);
			echo form_checkbox('laser[]','810nm DIODE', set_checkbox('laser', '810nm DIODE'));
			echo nbs(3);
			echo '<label id="textOnly"> 810nm DIODE </label>';
			echo '<br>';
			echo nbs(15);
			echo form_checkbox('laser[]','CAPSULOTOMY', set_checkbox('laser', 'CAPSULOTOMY'));
			echo nbs(3);
			echo '<label id="textOnly"> CAPSULOTOMY </label>';
			echo nbs(16);
			echo form_checkbox('laser[]','YAG', set_checkbox('laser', 'YAG'));
			echo nbs(3);
			echo '<label id="textOnly"> YAG </label>';
			echo '<br>';
			echo nbs(15);
			echo form_checkbox('laser[]','LASER IRIDOTOMY', set_checkbox('laser', 'LASER IRIDOTOMY'));
			echo nbs(3);
			echo '<label id="textOnly"> LASER IRIDOTOMY </label>';
			echo nbs(9);
			echo form_checkbox('laser[]','PDT', set_checkbox('laser', 'PDT'));
			echo nbs(3);
			echo '<label id="textOnly"> PDT </label>';
			echo '<br>';
			echo nbs(15);
			echo form_checkbox('laser[]','SLT', set_checkbox('laser', 'SLT'));
			echo nbs(3);
			echo '<label id="textOnly"> SLT </label>';
			echo '<br>';
			echo nbs(15);
			echo form_checkbox('laser[]','others', set_checkbox('laser', 'others'));
			echo nbs(3);
			echo '<label id="textOnly"> Others (Please Specify): </label>';
			echo nbs(5);
			echo form_input(array('type' => 'text', 'name' => 'laserOthers', 'placeholder'=>'Others', 'class'=>'input'), set_value('laserOthers'));
			echo br(2);
			
			
			echo '<b>PACKAGE:</b>';
			echo br(1);
			echo nbs(5);
			echo form_checkbox('packageOpts[]', 'RETINA ASSESSMENT', set_checkbox('packageOpts', 'RETINA ASSESSMENT'));
			echo nbs(3);
			echo '<label id="textOnly"> RETINA ASSESSMENT (FA,OCT) </label>';
			echo '<br>';
			echo nbs(5);
			echo form_checkbox('packageOpts[]', 'GLAUCOMA RISK PROFILE', set_checkbox('packageOpts', 'GLAUCOMA RISK PROFILE'));
			echo nbs(3);
			echo '<label id="textOnly"> GLAUCOMA RISK PROFILE (VFT,OCT,DISC PHOTO) </label>';
			echo '<br>';
			echo nbs(5);
			echo form_checkbox('packageOpts[]', 'GLAUCOMA PLUS PACKAGE', set_checkbox('packageOpts', 'GLAUCOMA PLUS PACKAGE'));
			echo nbs(3);
			echo '<label id="textOnly">GLAUCOMA PLUS PACKAGE (VFT,OCT,DISC PHOTO,CENTRAL CORNEAL THICKNESS) </label>';
			echo '<br>';
			echo nbs(5);
			echo form_checkbox('packageOpts[]', 'ETHAMBUTOL TOXICITY SCREENING', set_checkbox('packageOpts', 'ETHAMBUTOL TOXICITY SCREENING'));
			echo nbs(3);
			echo '<label id="textOnly">ETHAMBUTOL TOXICITY SCREENING / MONITORING (VFT,OCT,FUNDUS PHOTO) </label>';
			echo '<br>';
			echo nbs(5);
			echo form_checkbox('packageOpts[]', 'LOW VISION', set_checkbox('packageOpts', 'LOW VISION'));
			echo nbs(3);
			echo '<label id="textOnly">LOW VISION</label>';
			echo '</div>';
			echo "</div>";
			// ----------------------------------------------------------------------------------------------------
			// End of Others --------------------------------------------------------------------------------------
			echo '</td></tr><tr><td colspan=8>';
			echo div('disIn');
			echo '<label id="labl" style="font-size:15px;"> Discharge Instructions: </label>';
			echo br(1);
			echo nbs(8);
			echo form_radio('disIns', 'normal', set_radio('disIns', 'normal'));
			echo nbs(3);
			echo '<label id="textOnly">Normal ADLs</label>';
			echo br(1);
			echo nbs(8);
			echo form_radio('disIns', 'anl', set_radio('disIns', 'anl'));
			echo nbs(3);
			echo '<label id="textOnly">ADLs and Limitation</label>';
			echo br(1);
			echo nbs(8);
			echo form_radio('disIns', 'fullRes', set_radio('disIns', 'fullRes'));
			echo nbs(3);
			echo '<label id="textOnly">Full Restriction</label>';
			echo '</td></tr><tr><td colspan=8>';
			echo div('sec1');
			echo nbs(3);
			echo '<label id="labl"> *Follow-up Instructions: </label>';
			echo form_textarea(array('name'=>'follow', 'class'=>'input', 'size'=>'50', 'height'=>'40', 'rows'=>'6', 'cols'=>'55', 'id' => 'tableCell'),set_value('follow'));	
			echo "</div>";

			echo div('sec2');
			echo br(1);
			echo "<div class='icon'>
				<img onclick='showUpload();' img src='".base_url()."assets/img/upload.png' width='50px' height='50px'><br><br>
				<img id='download'  onclick='showDownload()' type='image' src='".base_url()."assets/img/download.png' width='50px' height='50px'></input></div>";
			echo "</div>";
			echo div('sec3');
			echo br(1);
			echo "<div id='uploadBox'>";
			echo 'Upload a file <input type="file" name="filename" size="20" /><span class="text-danger">';
			if (isset($error)) { echo $error; } 
			echo '</span>';
			echo ' <input type="submit" name="upload" value="Upload File" class="btn btn-primary"/>';		
			
			
			echo "</div>				
			
				<div id='downloadBox'>
				Files Available: <br/>
				<ul>"; 
				$file = $this->model_discpresc->getFile();	
				
				foreach ($file as $rows) {
					$fileName = $rows->filename;
					if(strpos($fileName, '.docx') == FALSE){
						$fileName = substr($fileName, 0, -4);
					} else {
						$fileName = substr($fileName, 0, -5);
					}
				 	echo "<li><a href='".base_url()."assets/files/".$fileName.".php'>".$rows->filename."</a></li>	";
				}
			echo "</ul></div>
			<script>
			function showUpload() {
				$(uploadBox).show();
				$(downloadBox).hide();
			}
			function showDownload() {
				$(downloadBox).show();
				$(uploadBox).hide();
			}</script>";
				
			echo '</td></tr></table></div><center>';			
			if(!is_array($patient)){
			echo form_submit(array('name'=>'update', 'value'=>'Update', 'class'=>'btn btn-lg btn-primary pull-center'));
			echo nbs(5);
			echo form_submit(array('name'=>'print', 'value'=>'Print', 'class'=>'btn btn-lg btn-primary pull-center'));
			}
			echo br(2);
			echo '<br></form></div></div></div></section></section>'; //last div: table
		?>
	   <!-- page end -->
	</section>
</section>
      <!--main content end-->