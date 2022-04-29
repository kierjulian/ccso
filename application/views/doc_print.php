<?php
	$this->load->helper('table');
	$this->load->library('tcpdf');

	//code voucher here
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'STATEMENT', true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Alvina Santiago');	//doctor's name here
	$pdf->SetTitle('COMPUTERIZED CLINIC OPHTALMOLOGIC SYSTEM');

	if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		require_once(dirname(__FILE__).'/lang/eng.php');
		$pdf->setLanguageArray($l);
	}
	$pdf->SetFont('dejavusans', '', 8);
	
	$pdf->AddPage(); 
	$html = '<h3 align="center">MEDICAL REPORT</h3><br><br>';
	$html .= table_create(array('border' => '1px', 'width'=> '100%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
	$html .= tr(array('<b>PATIENT NAME</b><br>'.$patient.'','<h4 align = "right"><b>BIRTHDAY</b><br>'.$birthday.'</h4>'));
	$html .= table_end();
	$pdf->writeHTML($html, true, false, true, false, '');

	if($set == 'va'){
		//PRINT VA
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Eye Examination: <br>Visual Acuity</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_va.'</h4>'));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('VA without Correction',$va_NoCorrect_r,$va_NoCorrect_l));
		$html .= tr(array('VA without Correction<br>with Pinhole',$va_NoCorrect_pin_r,$va_NoCorrect_pin_l));
		$html .= tr(array('Best Correction',$BestCorrect_r,$BestCorrect_l));
		$html .= tr(array('Best Correction (distance)',$BestCorrect_dist_r,$BestCorrect_dist_l));
		$html .= tr(array('Best Correction (near)',$BestCorrect_near_r,$BestCorrect_near_l));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));		
		$html .= tr(array('<td></td>','<th>Remarks</th>'));
		$html .= tr(array('Forced Primary (distance)',$ForcedPrimary_dist));
		$html .= tr(array('Forced Primary (near)',$ForcedPrimary_near));
		$html .= tr(array('Anomalous Head Posture (distance)',$ahp_dist));
		$html .= tr(array('Anomalous Head Posture (near)',$ahp_near));
		$html .= tr(array('VA Anomalous Head Posture (near)',$va_ou_ahp_near));
		$html .= tr(array('Downgaze (Reading)',$va_downgaze));
		$html .= table_end();

		$pdf->writeHTML($html, true, false, true, false, '');
	}
	if($set == 'refrac'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Eye Examination: <br>Refraction</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_ref.'</h4>'));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">RIGHT</th>',"<th align = 'center'>LEFT</th>"));
		$html .= tr(array('Dry Autorefraction',$DryAutoRef_r,$DryAutoRef_l));
		$html .= tr(array('Dry Objective Refraction',$ObjRef_r,$ObjRef_l));
		$html .= tr(array('VA with Objective Refraction',$va_ObjRef_r,$va_ObjRef_l));
		$html .= tr(array('Manifest Refraction',$ManRef_r,$ManRef_l));
		$html .= tr(array('VA with Manifest Refraction',$va_ManRef_r,$va_ManRef_l));
		$html .= tr(array('Cycloplegic Refraction',$CycloRef_r,$CycloRef_l));
		$html .= tr(array('VA with Cycloplegic Refraction',$va_CycloRef_r,$va_CycloRef_l));
		$html .= tr(array('Cycloplegic Agent',$CycloAgent_r,$CycloAgent_l));
		$html .= tr(array('Tolerated Refraction',$TolRef_r,$TolRef_l));
		$html .= tr(array('VA with Tolerated Refraction',$va_TolRef_r,$va_TolRef_l));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));		
		$html .= tr(array('Refraction Remarks',$ref_remarks));
		$html .= table_end();

		$pdf->writeHTML($html, true, false, true, false, '');
	}
	if($set == 'pupils'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Eye Examination: <br>Pupils</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_pupil.'</h4>'));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<th align = "center">General Information</th>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('Pupil Color',$PupilColor_r,$PupilColor_l));
		$html .= tr(array('Shape',$PupilShape_r,$PupilShape_l));
		$html .= tr(array('Size (ambient)',$PupilSize_amb_r,$PupilSize_amb_l));
		$html .= tr(array('Size (dark room)',$PupilSize_dark_r,$PupilSize_dark_l));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<th align = "center">Reactivity to Light</th>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('Reaction to light (ambient light)',$LightRxn_amb_r,$LightRxn_amb_l));
		$html .= tr(array('Reaction to light (dark room)',$LightRxn_dark_r,$LightRxn_dark_l));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<th align = "center"></th>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('Relative Afferent Pupillary Defect',$relAPD_r,$relAPD_l));
		$html .= tr(array('Other Observations',$pupil_other_r,$pupil_other_l));
		$html .= table_end().'<br><br>';;
		$pdf->writeHTML($html, true, false, true, false, '');
	}
	if($set == 'gross'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Eye Examination: <br>Gross</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_gross.'</h4>'));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<th align = "center">General Information</th>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('Eyebrows',$eyebrows_r,$eyebrows_l));
		$html .= tr(array('Adnexae',$adnexae_r,$adnexae_l));
		$html .= tr(array('Lid Fissure (Vertical HT)',$lidFissure_r,$lidFissure_l));
		$html .= tr(array('Cornea Gross',$corneaGross_r,$corneaGross_l));
		$html .= tr(array('Sclera Gross',$scleraGross_r,$scleraGross_l));
		$html .= table_end().'<br><br>';
		if($gross_count > 0){
			$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
			$html .= tr(array('<th align = "center">Scanned Documents</th>','<th align = "center"> Findings</th>'));
			for($idx = 0; $idx < $gross_count; $idx++){
				$title = "gross_name_".$idx;
				$findings = "gross_img_".$idx;
				$html .= tr(array($$title,$$findings));
			}
			$html .= table_end().'<br><br>';	
		}
		$pdf->writeHTML($html, true, false, true, false, '');
	}
	if($set == 'post'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Eye Examination: <br>Posterior</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_postpole.'</h4>'));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<th>Instrument</th>','<td colspan = 3>'.$PostPoleInstrument.'</td>'));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<th align = "center">Zone 1</th>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('Optic Nerve',$zone1_optic_r,$zone1_optic_l));
		$html .= tr(array('Retinal Arcade',$zone1_retinal_r,$zone1_retinal_l));
		$html .= tr(array('Macula',$zone1_macula_r,$zone1_macula_l));
		$html .= tr(array('Vitreous',$zone1_vitreous_r,$zone1_vitreous_l));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<th align = "center">Zone 2</th>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('Branching',$zone2_branch_r,$zone2_branch_l));
		$html .= tr(array('Artery',$zone2_artery_r,$zone2_artery_l));
		$html .= tr(array('Veins',$zone2_veins_r,$zone2_veins_l));
		$html .= tr(array('Vortex Veins',$zone2_vortex_r,$zone2_vortex_l));
		$html .= tr(array('Vitreous',$zone2_vitreous_r,$zone2_vitreous_l));
		$html .= tr(array('Retinal Arcade',$zone2_retinal_r,$zone2_retinal_l));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<th align = "center">Zone 3</th>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('Retina',$zone3_retina_r,$zone3_retina_l));
		$html .= tr(array('Vessels',$zone3_vessels_r,$zone3_vessels_l));
		$html .= tr(array('Vitreous',$zone3_vitreous_r,$zone3_vitreous_l));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<th></th>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('Other Posterior Findings',$PostPole_other_r,$PostPole_other_l));
		$html .= table_end().'<br><br>';
		$pdf->writeHTML($html, true, false, true, false, '');
	}
	if($set == 'slitlamp'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Eye Examination: <br>Slitlamp</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_sl.'</h4>'));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<th align = "center">General Information</th>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('Lids Upper',$lidsUp_r,$lidsUp_l));
		$html .= tr(array('Lids Lower',$lidsLow_r,$lidsLow_l));
		$html .= tr(array('Conjunctiva (Palpebral)',$conj_palp_r,$conj_palp_l));
		$html .= tr(array('Conjunctiva (Bulbar)',$conj_bulb_r,$conj_bulb_l));
		$html .= tr(array('Sclera (SL)',$sl_sclera_r,$sl_sclera_l));
		$html .= tr(array('Limbus',$limbus_r,$limbus_l));
		$html .= tr(array('Cornea (SL)',$sl_cornea_r,$sl_cornea_l));
		$html .= tr(array('Angles/Trabecular Meshwork',$AnglesMesh_r,$AnglesMesh_l));
		$html .= tr(array('Anterior Chamber',$anterior_r,$anterior_l));
		$html .= tr(array('Iris',$iris_r,$iris_l));
		$html .= tr(array('Lens',$lens_r,$lens_l));
		$html .= tr(array('Vitreous (SL)',$sl_vitreous_r,$sl_vitreous_l));
		$html .= tr(array('Nerve (SL)',$sl_nerve_r,$sl_nerve_l));
		$html .= tr(array('Retina arcade/vessels (SL)',$sl_retinal_r,$sl_retinal_l));
		$html .= tr(array('Macula (SL)',$sl_macula_r,$sl_macula_l));
		$html .= tr(array('Posterior Pole Others',$sl_posterior_r,$sl_posterior_l));
		//PHOTOGRAPHS
		/*
		$html .= tr(array('Slitlamp Photograph',$sl_img_r,$sl_img_l));
		$html .= tr(array('Gonioscopy Drawing',$gonio_draw_r,$gonio_draw_l));
		$html .= tr(array('Gonioscopy Photograph',$gonio_img_r,$gonio_img_l));*/
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<th align = "center">Gonioscopy</th>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('Findings',$gonio_find_r,$gonio_find_l));
		$html .= table_end().'<br><br>';

		if($slitlamp_count > 0){
			$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
			$html .= tr(array('<th align = "center">Scanned Documents</th>','<th align = "center"> Findings</th>'));
			for($idx = 0; $idx < $slitlamp_count; $idx++){
				$title = "slitlamp_name_".$idx;
				$findings = "slitlamp_img_".$idx;
				$html .= tr(array($$title,$$findings));
			}
			$html .= table_end().'<br><br>';	
		}

		$pdf->writeHTML($html, true, false, true, false, '');
	}
	if($set == 'stereo'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Eye Examination: <br>Stereoacuity</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_stereo.'</h4>'));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<th align = "center">General Information</th>','<th align = "center">REMARKS</th>'));
		$html .= tr(array('Distance Stereo Test',$stereo_dist_test));
		$html .= tr(array('Result Distance Stereo',$stereo_dist_result));
		$html .= tr(array('Near Stereo Test',$stereo_near_test));
		$html .= tr(array('Result Near Stereo',$stereo_near_result));
		$html .= tr(array('Stereoacuity',$Stereoacuity));
		$html .= tr(array('Remarks',$stereo_remarks));
		$html .= table_end().'<br><br>';

		$pdf->writeHTML($html, true, false, true, false, '');
	}
	if($set == 'strabd'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Eye Examination: <br>Strabismus Duction</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_strabd.'</h4>'));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<th align = "center">General Information</th>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('MR (Primary)',$mr_add_r,$mr_add_l));
		$html .= tr(array('LR (Primary)',$lr_abd_r,$lr_abd_l));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<th align = "center">IR</th>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('Depression',$ir_dep_r,$ir_dep_l));
		$html .= tr(array('Adduction',$ir_add_r,$ir_add_l));
		$html .= tr(array('Excyclotorsion',$ir_excyc_r,$ir_excyc_l));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<th align = "center">IO</th>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('Excyclotorsion',$io_dep_r,$io_dep_l));
		$html .= tr(array('Abduction',$io_abd_r,$io_abd_l));
		$html .= tr(array('Upgaze',$io_upgaze_r,$io_upgaze_l));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<th align = "center">SR</th>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('Upgaze',$sr_upgaze_r,$sr_upgaze_l));
		$html .= tr(array('Adduction',$sr_add_r,$sr_add_l));
		$html .= tr(array('Incyclotorsion',$sr_incyc_r,$sr_incyc_l));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<th align = "center">SO</th>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('Incyclotorsion',$so_incyc_r,$so_incyc_l));
		$html .= tr(array('Downgaze',$so_downgaze_r,$so_downgaze_l));
		$html .= tr(array('Abduction',$so_abd_r,$so_abd_l));
		$html .= table_end().'<br><br>';

		$pdf->writeHTML($html, true, false, true, false, '');
	}
	if($set == 'strabf'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Eye Examination: <br>Strabismus Fusional Amplitude</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_strabf.'</h4>'));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('Divergence Distance (Base In)',$div_dist));
		$html .= tr(array('Convergence Distance (Base Out)',$conv_dist));
		$html .= tr(array('Sursumvergence (Base Up)',$sursumverge));
		$html .= tr(array('Cyclovergence (Extorsion)',$cyclover_ext));
		$html .= tr(array('Divergence Near (Base In)',$div_near));
		$html .= tr(array('Convergence Near (Base Out)',$conv_near));
		$html .= tr(array('Deosursumvergence',$deosursumverge));
		$html .= tr(array('Cyclovergence (Intorsion)',$cyclover_int));
		$html .= table_end().'<br><br>';

		$pdf->writeHTML($html, true, false, true, false, '');
	}
	if($set == 'strabm'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Eye Examination: <br>Strabismus Measurement</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_strabm.'</h4>'));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<th align = "center">General Information</th>','<th align = "center">REMARKS</th>'));
		$html .= tr(array('1 Version (Up and Right)',$strabM1));
		$html .= tr(array('2 Version (Straight Up)',$strabM2));
		$html .= tr(array('3 Version (Up and Left)',$strabM3));
		$html .= tr(array('4 Version (Right)',$strabM4));
		$html .= tr(array('5 Version (Straight)',$strabM5));
		$html .= tr(array('6 Version (Left)',$strabM6));
		$html .= tr(array('7 Version (Down and Right)',$strabM7));
		$html .= tr(array('8 Version (Straight Down)',$strabM8));
		$html .= tr(array('9 Version (Down and Left)',$strabM9));
		$html .= tr(array('Right Tilt',$Mtilt_r));
		$html .= tr(array('Left Tilt',$Mtilt_l));
		$html .= tr(array('Strabismus Measurement<br>in AHP (distance)',$strabM_ahp_dist));
		$html .= tr(array('Strabismus Measurement<br>Primary Distance',$strabM_primaryDist));
		$html .= tr(array('Strabismus Measurement<br>in AHP (near)',$strabM_ahp_near));
		$html .= tr(array('Strabismus Measurement<br>Primary Near',$strabM_primaryNear));
		$html .= tr(array('Strabismus Measurement<br>Downgaze Near',$strabM_downgazeNear));
		$html .= table_end().'<br><br>';

		$pdf->writeHTML($html, true, false, true, false, '');
	}
	if($set == 'strabv'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Eye Examination: <br>Strabismus Version</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_strabv.'</h4>'));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<th align = "center">General Information</th>','<th align = "center">REMARKS</th>'));
		$html .= tr(array('1 Version (Up and Right)',$strabV1));
		$html .= tr(array('2 Version (Straight Up)',$strabV2));
		$html .= tr(array('3 Version (Up and Left)',$strabV3));
		$html .= tr(array('4 Version (Right)',$strabV4));
		$html .= tr(array('5 Version (Straight)',$strabV5));
		$html .= tr(array('6 Version (Left)',$strabV6));
		$html .= tr(array('7 Version (Down and Right)',$strabV7));
		$html .= tr(array('8 Version (Straight Down)',$strabV8));
		$html .= tr(array('9 Version (Down and Left)',$strabV9));
		$html .= tr(array('Right Tilt',$Vtilt_r));
		$html .= tr(array('Left Tilt',$Vtilt_l));
		//PHOTOGRAPHS
		/*
		$html .= tr(array('Composite Image 1',$composite_img1));
		$html .= tr(array('Composite Image 2',$composite_img2));
		$html .= tr(array('Composite Image 3',$composite_img3));
		$html .= tr(array('Composite Image 4',$composite_img4));
		$html .= tr(array('Composite Image 5',$composite_img5));
		$html .= tr(array('Composite Image 6',$composite_img6));
		$html .= tr(array('Composite Image 7',$composite_img7));
		$html .= tr(array('Composite Image 8',$composite_img8));
		$html .= tr(array('Composite Image 9',$composite_img9));
		$html .= tr(array('Near Point of Convergence',$nearPOC));*/
		$html .= table_end().'<br><br>';

		if($strabver_count > 0){
			$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
			$html .= tr(array('<th align = "center">Scanned Documents</th>','<th align = "center"> Findings</th>'));
			for($idx = 0; $idx < $strabver_count; $idx++){
				$title = "strabver_name_".$idx;
				$findings = "strabver_img_".$idx;
				$html .= tr(array($$title,$$findings));
			}
			$html .= table_end().'<br><br>';	
		}

		$pdf->writeHTML($html, true, false, true, false, '');
	}
	if($set == 'color'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Ancillary Test: <br>Color Test</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_color.'</h4>'));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('Color Result',$color_result_r,$color_result_l));	
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">Result</th>'));
		$html .= tr(array('Color test used',$color_test));
		$html .= tr(array('Color Institution',$colorInstitution));
		$html .= tr(array('Color Test Reader',$color_reader));
		$html .= tr(array('Color Remarks',$color_remarks));
		$html .= table_end();

		$pdf->writeHTML($html, true, false, true, false, '');
	}
	if($set == 'eog'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Ancillary Test: <br>Neurophysiologic Test: EOG</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_eog.'</h4>'));
		$html .= table_end().'<br><br>';
		
		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('EOG Tracing',$eogTracing_r,$eogTracing_l));
		$html .= tr(array('EOG Reading',$eogReading_r,$eogReading_l));
	    $html .= table_end().'<br><br>';

	    if($eog_count > 0){
			$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
			$html .= tr(array('<th align = "center">Scanned Documents</th>','<th align = "center"> Findings</th>'));
			for($idx = 0; $idx < $eog_count; $idx++){
				$title = "eog_name_".$idx;
				$findings = "eog_img_".$idx;
				$html .= tr(array($$title,$$findings));
			}
			$html .= table_end().'<br><br>';	
		}

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">Results</th>'));
		$html .= tr(array('Institution EOG',$eogInstitution));
		$html .= tr(array('EOG Reader',$eogReader));
		$html .= tr(array('EOG Remarks',$eogRemarks));
	

		$html .= table_end().'<br><br>';
		$pdf->writeHTML($html, true, false, true, false, '');
	}
	if($set == 'iop'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Ancillary Test: <br>Intraocular Pressure</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_iop.'</h4>'));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('Finger Palpatation',$FingerPalp_r,$FingerPalp_l));	
		$html .= tr(array('IOP(Perkins)',$iop_Perkins_r,$iop_Perkins_l));
		$html .= tr(array('IOP(Icare)',$iop_Icare_r,$iop_Icare_l));
		$html .= tr(array('IOP(Goldmann',$iop_Goldmann_r,$iop_Goldmann_l));
		$html .= tr(array('IOP(Shiotz)',$iop_Shiotz_r,$iop_Shiotz_l));
		$html .= tr(array('IOP(Tonopen)',$iop_Tonopen_r,$iop_Tonopen_l));
		$html .= tr(array('IOP(Others)',$iop_other_r,$iop_other_l));
		$html .= tr(array('Type of Instrument used for Others',$iop_otherInstrument_r,$iop_otherInstrument_l));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<th align = "center">Remarks</th>'));
		$html .= tr(array($iop_remarks));
		$html .= table_end().'<br><br>';

		$pdf->writeHTML($html, true, false, true, false, '');
	}
	if($set == 'octd'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Ancillary Test: <br>Optical Coherence Tomography (Disc)</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_octd.'</h4>'));
		$html .= table_end().'<br><br>';
		/*
		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		//PHOTOGRAPHS
		
		$html .= tr(array('Image 1',$octD_img1_r, $octD_img1_l));
		$html .= tr(array('Image 2',$octD_img2_r, $octD_img2_l));
		$html .= tr(array('Image 3',$octD_img3_r, $octD_img3_l));
		$html .= tr(array('Image 4',$octD_img4_r, $octD_img4_l));
		$html .= tr(array('Image 5',$octD_img5_r, $octD_img5_l));
		$html .= table_end().'<br><br>';
		*/
		if($octdisc_count > 0){
			$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
			$html .= tr(array('<th align = "center">Scanned Documents</th>','<th align = "center"> Findings</th>'));
			for($idx = 0; $idx < $octdisc_count; $idx++){
				$title = "octdisc_name_".$idx;
				$findings = "octdisc_img_".$idx;
				$html .= tr(array($$title,$$findings));
			}
			$html .= table_end().'<br><br>';	
		}

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">Results</th>'));
		$html .= tr(array('OCT DISC Instituted',$octD_institution));
		$html .= tr(array('OCT DISC Machine',$octD_machine));
		$html .= tr(array('OCT DISC Reader',$octD_reader));
		$html .= tr(array('OCT DISC Remarks',$octD_remarks));
	

		$html .= table_end().'<br><br>';
		$pdf->writeHTML($html, true, false, true, false, '');
	}
	if($set == 'octm'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Ancillary Test: <br>Optical Coherence Tomography (Macula)</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_octm.'</h4>'));
		$html .= table_end().'<br><br>';
		/*
		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		//PHOTOGRAPHS
		$html .= tr(array('Image 1',$octM_img1_r, $octM_img1_l));
		$html .= tr(array('Image 2',$octM_img2_r, $octM_img2_l));
		$html .= tr(array('Image 3',$octM_img3_r, $octM_img3_l));
		$html .= tr(array('Image 4',$octM_img4_r, $octM_img4_l));
		$html .= tr(array('Image 5',$octM_img5_r, $octM_img5_l));
		$html .= table_end().'<br><br>';
		*/

		if($octm_count > 0){
			$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
			$html .= tr(array('<th align = "center">Scanned Documents</th>','<th align = "center"> Findings</th>'));
			for($idx = 0; $idx < $octm_count; $idx++){
				$title = "octm_name_".$idx;
				$findings = "octm_img_".$idx;
				$html .= tr(array($$title,$$findings));
			}
			$html .= table_end().'<br><br>';	
		}

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">Results</th>'));
		$html .= tr(array('OCT MACULA Instituted',$octM_institution));
		$html .= tr(array('OCT MACULA Machine',$octM_machine));
		$html .= tr(array('OCT MACULA Reader',$octM_reader));
		$html .= tr(array('OCT MACULA Remarks',$octM_remarks));
	

		$html .= table_end().'<br><br>';
		$pdf->writeHTML($html, true, false, true, false, '');
	}
	if($set == 'octo'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Ancillary Test: <br>Optical Coherence Tomography (Other Areas)</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_octo.'</h4>'));
		$html .= table_end().'<br><br>';
		/*
		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		//PHOTOGRAPHS
		$html .= tr(array('Image 1',$octOA_img1_r, $octOA_img1_l));
		$html .= tr(array('Image 2',$octOA_img2_r, $octOA_img2_l));
		$html .= tr(array('Image 3',$octOA_img3_r, $octOA_img3_l));
		$html .= tr(array('Image 4',$octOA_img4_r, $octOA_img4_l));
		$html .= tr(array('Image 5',$octOA_img5_r, $octOA_img5_l));
		$html .= table_end().'<br><br>';
		*/

		if($octo_count > 0){
			$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
			$html .= tr(array('<th align = "center">Scanned Documents</th>','<th align = "center"> Findings</th>'));
			for($idx = 0; $idx < $octo_count; $idx++){
				$title = "octo_name_".$idx;
				$findings = "octo_img_".$idx;
				$html .= tr(array($$title,$$findings));
			}
			$html .= table_end().'<br><br>';	
		}

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">Results</th>'));
		$html .= tr(array('OCT Other Area Instituted',$octOA_institution));
		$html .= tr(array('OCT Other Area Machine',$octOA_machine));
		$html .= tr(array('OCT Other Area Tested',$octOA_tested));
		$html .= tr(array('OCT Other Area Reader',$octOA_reader));
		$html .= tr(array('OCT Other Area Remarks',$octOA_remarks));
	

		$html .= table_end().'<br><br>';
		$pdf->writeHTML($html, true, false, true, false, '');
	}
	if($set == 'other'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Ancillary Test: <br>Others </h4>','<h4 align = "right">Date of Consulation: <br>'.$date_other.'</h4>'));
		$html .= table_end().'<br><br>';
		/*
		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('Image 1',$other_img1));
		$html .= tr(array('Image 2',$other_img2));
		$html .= tr(array('Image 3',$other_img3));
		$html .= tr(array('Image 4',$other_img4));
		$html .= tr(array('Image 5',$other_img5));
		$html .= table_end().'<br><br>';
		*/

		if($other_count > 0){
			$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
			$html .= tr(array('<th align = "center">Scanned Documents</th>','<th align = "center"> Findings</th>'));
			for($idx = 0; $idx < $other_count; $idx++){
				$title = "other_name_".$idx;
				$findings = "other_img_".$idx;
				$html .= tr(array($$title,$$findings));
			}
			$html .= table_end().'<br><br>';	
		}

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">Results</th>'));
		$html .= tr(array('Institution Other Test',$otherInstitution));
		$html .= tr(array('Other Test Done',$otherTest));
		$html .= tr(array('Other TEst Results Reader',$otherReading));
		$html .= tr(array('Remarks',$other_remarks));
	

		$html .= table_end().'<br><br>';
		$pdf->writeHTML($html, true, false, true, false, '');
	}
	if($set == 'retina'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Eye Examination: <br>Retina Imaging</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_u.'</h4>'));
		$html .= table_end().'<br><br>';
		/*
		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		//PHOTOGRAPHS
		$html .= tr(array('Fundus Image 1',$fundusImg1_r, $fundusImg1_l));
		$html .= tr(array('Fundus Image 2',$fundusImg2_r, $fundusImg2_l));
		$html .= tr(array('Fundus Image 3',$fundusImg3_r, $fundusImg3_l));
		$html .= tr(array('Fundus Image 4',$fundusImg4_r, $fundusImg4_l));
		$html .= tr(array('Fundus Image 5',$fundusImg5_r, $fundusImg5_l));
		$html .= tr(array('Fundus Image 6',$fundusImg6_r, $fundusImg6_l));
		$html .= tr(array('Fundus Image 7',$fundusImg7_r, $fundusImg7_l));
		$html .= tr(array('Fundus Image 8',$fundusImg8_r, $fundusImg8_l));
		$html .= tr(array('Fundus Image 9',$fundusImg9_r, $fundusImg9_l));
		$html .= table_end().'<br><br>';
		*/
		if($retina_count > 0){
			$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
			$html .= tr(array('<th align = "center">Scanned Documents</th>','<th align = "center"> Findings</th>'));
			for($idx = 0; $idx < $retina_count; $idx++){
				$title = "retina_name_".$idx;
				$findings = "retina_img_".$idx;
				$html .= tr(array($$title,$$findings));
			}
			$html .= table_end().'<br><br>';	
		}

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">Results</th>'));
		$html .= tr(array('Retina Imaging Used',$retImg_used));
		$html .= tr(array('Retina Imaging Institution',$retImg_institution));
		$html .= tr(array('Retina Image Reader',$retImg_reader));
		$html .= tr(array('Retina Image Remarks',$retImg_remarks));
	

		$html .= table_end().'<br><br>';
		$pdf->writeHTML($html, true, false, true, false, '');
	}
	if($set == 'utz'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Eye Examination: <br>Occular Ultrasound</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_utz.'</h4>'));
		$html .= table_end().'<br><br>';
		/*
		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('UTZ Image 1',$utz_img1_r, $utz_img1_l));
		$html .= tr(array('UTZ Image 2',$utz_img2_r, $utz_img2_l));
		$html .= tr(array('UTZ Image 3',$utz_img3_r, $utz_img3_l));
		$html .= table_end().'<br><br>';
		*/
		if($utz_count > 0){
			$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
			$html .= tr(array('<th align = "center">Scanned Documents</th>','<th align = "center"> Findings</th>'));
			for($idx = 0; $idx < $utz_count; $idx++){
				$title = "utz_name_".$idx;
				$findings = "utz_img_".$idx;
				$html .= tr(array($$title,$$findings));
			}
			$html .= table_end().'<br><br>';	
		}

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">Results</th>'));
		$html .= tr(array('UTZ Institution',$utzInstitution));
		$html .= tr(array('UTZ Machine Used',$utzMachine));
		$html .= tr(array('UTZ Reader',$utzReader));
		$html .= tr(array('UTZ Remarks',$utz_remarks));

		$html .= table_end().'<br><br>';
		$pdf->writeHTML($html, true, false, true, false, '');
	}
	
	if($set == 'ver'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Eye Examination: <br>Neurophysiologic Test: VER</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_u.'</h4>'));
		$html .= table_end().'<br><br>';

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		$html .= tr(array('VER Tracing',$verTracing_r, $verTracing_l));
		$html .= tr(array('VER Reading',$verReading_r, $verReading_l));
		$html .= table_end().'<br><br>';

		if($ver_count > 0){
			$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
			$html .= tr(array('<th align = "center">Scanned Documents</th>','<th align = "center"> Findings</th>'));
			for($idx = 0; $idx < $ver_count; $idx++){
				$title = "ver_name_".$idx;
				$findings = "ver_img_".$idx;
				$html .= tr(array($$title,$$findings));
			}
			$html .= table_end().'<br><br>';	
		}


		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">Results</th>'));
		$html .= tr(array('Institution VER',$verInstitution));
		$html .= tr(array('VER Reader',$verReader));
		$html .= tr(array('VER Remarks',$ver_remarks));
	

		$html .= table_end().'<br><br>';
		$pdf->writeHTML($html, true, false, true, false, '');
	}
	if($set == 'vf'){
		$html = table_create(array('width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<h4>Ancillary Test: <br>Visual Field</h4>','<h4 align = "right">Date of Consulation: <br>'.$date_vf.'</h4>'));
		$html .= table_end().'<br><br>';

		/*
		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">RIGHT</th>','<th align = "center">LEFT</th>'));
		//PHOTOGRAPHS
		$html .= tr(array('VF Image 1',$vf_img1_r, $vf_img1_l));
		$html .= tr(array('VF Image 2',$vf_img2_r, $vf_img2_l));
		$html .= tr(array('VF Image 3',$vf_img3_r, $vf_img3_l));
		$html .= tr(array('VF Image 4',$vf_img4_r, $vf_img4_l));
		$html .= tr(array('VF Image 5',$vf_img5_r, $vf_img5_l));
		$html .= tr(array('VF Image 6',$vf_img6_r, $vf_img6_l));
		$html .= table_end().'<br><br>';
		*/
		if($vf_count > 0){
			$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
			$html .= tr(array('<th align = "center">Scanned Documents</th>','<th align = "center"> Findings</th>'));
			for($idx = 0; $idx < $vf_count; $idx++){
				$title = "vf_name_".$idx;
				$findings = "vf_img_".$idx;
				$html .= tr(array($$title,$$findings));
			}
			$html .= table_end().'<br><br>';	
		}

		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<td></td>','<th align = "center">Results</th>'));
		$html .= tr(array('Institution VF',$vfInstitution));
		$html .= tr(array('VF Program Used',$vfProgram));
		$html .= tr(array('VF Reader',$vfReader));
		$html .= tr(array('VF Remarks',$vf_remarks));
	

		$html .= table_end().'<br><br>';
		$pdf->writeHTML($html, true, false, true, false, '');
	}
	
	$pdf->lastPage();
	ob_clean();
	$pdf->Output("MedForm(".date("Y-m-d").")_".$set."_".$patient.".pdf", "D");
?>
