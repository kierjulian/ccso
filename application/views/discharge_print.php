<?php
	$this->load->helper('table');
	$this->load->library('tcpdf');
	$this->load->helper('html');
	$this->load->helper('url');
	$this->load->helper('additional_html');
	$this->load->helper('form');

	//CODE VOUCHER
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'STATEMENT', true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Alvina Santiago');	//doctor's name here
	$pdf->SetTitle('COMPUTERIZED CLINIC OPHTALMOLOGIC SYSTEM');
	if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		require_once(dirname(__FILE__).'/lang/eng.php');
		$pdf->setLanguageArray($l);
	}
	$pdf->SetFont('dejavusans', '', 8);		
	
	// PRESCRIPTION - MEDICATIONS
	if($meds != NULL){
		$medCnt = 1;
		$pdf->AddPage();
		$html = '<img align = "center" src = "assets/img/discharge/presc_header.jpg" width="450" height="55"><br>';
		$html .= '<h4 align="right">Date: '.$pdate.'</h4><hr>';
		$html .= '<h6><br></h6><h3 align="center">PRESCRIPTION FORM<br><small>MEDICATIONS</small></h3>';
		$html .= '<b>Name: </b>'.$name.'<br><b>Age:</b> '.$age.'<b>     Sex: </b>'.$sex.'<h6><br></h6><hr><h6><br></h6>';
		$html .= '<img src = "assets/img/discharge/rx.png" width="40" height="35">    MEDICATIONS:<br><br>';			
		// Medication Table
		$html .= table_create(array('width'=> '100%', 'cellpadding' => '2px', 'cellspacing' => '0px', 'fontsize' => 9));	
		foreach($meds as $med){
			$html .= tr(array($medCnt. '. '.nbs(5).
				$med->MED_GENERIC.nbs(10).'<br>'.nbs(10).
				'('.$med->MED_BRAND.')'.
				'<br>'.nbs(10).'<b>Sig: </b>'.$med->MED_SIG.'<br>' 
				, 'Qty: '.$medQty[$medCnt]));
			$medCnt++;
		}	
		$html .= table_end();
		// Signature
		$html.='<br><br><br><br><h4 align="center">';
		if($docName === 'Alvina Pauline D. Santiago, M.D.')
			$html.='<img src = "assets/img/discharge/signature.jpg" style="width: 80px;height: 30px"><br>';
		else 
			$html.='_________________________________________________<br>';
			$html.=$docName.'<br>
			PTR# '.$ptr->ptrNum.'<br>
			PRC# 0410530
			</h4><br><br>';
		$pdf->writeHTML($html, true, false, true, false, '');
	}	
	
	// 	PRESCRIPTIONS - EYE
	if($eyeP != NULL){
		$pdf->AddPage();
		$html = '<img align = "center" src = "assets/img/discharge/presc_header.jpg" width="450" height="55"><br><br>';
		$html .= '<h4 align="right">Date: '.$pdate.'</h4><hr>';
		$html .= '<h4><br></h4><h3 align="center">PRESCRIPTION FORM<br><small>EYE PRESCRIPTIONS</small></h4>';
		$html .= '<b>Name: </b>'.$name.'<br><b>Age:</b> '.$age.'<b>     Sex: </b>'.$sex.'<h6><br></h6><hr><h3><br></h3>';
		$html .= 'EYE PRESCRIPTIONS:<br><br>';
			// Eye Prescriptions
			$html .= table_create(array('border'=> '1px', 'align' => 'center'));
			$html .= tr(array('', '<b>Sphere</b>', '<b><small>Cylinder</small></b>', '<b>Axis</b>', '<b>Prism</b>', '<b>Adds</b>', '<b><small>Prism Direction</small></b>', '<b><small>Distance-PD</small></b>', '<b><small>Near-PD</small></b>'));
			$html .= tr(array('<b>OD</b>', $prescEye['ods'], $prescEye['odc'], $prescEye['oda'], $prescEye['odp'], $prescEye['odadd'], $prescEye['odb'], $prescEye['oddpd'], $prescEye['odnpd']));
			$html .= tr(array('<b>OS</b>', $prescEye['oss'], $prescEye['osc'], $prescEye['osa'], $prescEye['osp'], $prescEye['osadd'], $prescEye['osb'], $prescEye['osdpd'], $prescEye['osnpd']));	
			$html .= table_create(array('border'=>'0px', 'margin-top'=>'5px'));
			$html .= tr(array('','','','','','', '<b>TOTAL</b>', $prescEye['totald'], $prescEye['totaln']));
			$html .= table_end();
			$html .= table_end();
		// Signature
		$html.='<br><br><br><br><br><h4 align="center">';
		if($docName === 'Alvina Pauline D. Santiago, M.D.')
			$html.='<img src = "assets/img/discharge/signature.jpg" style="width: 80px;height: 30px"><br>';
		else 
			$html.='_________________________________________________<br>';
			$html.=$docName.'<br>
			PTR# '.$ptr->ptrNum.'<br>
			PRC# 0410530
			</h4><br><br>';
		$pdf->writeHTML($html, true, false, true, false, '');
	}
	
	// DISCHARGE
	$pdf->AddPage(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false); // Second Page ----------------------------------------------
	$html = '<img align = "center" src = "assets/img/discharge/presc_header.jpg" width="450" height="55"><br>';
	$html .= '<h4 align="right">Date Of Consultation: '.$cDate.'</h4><hr>';
	$html .= '<h6><br></h6><h3 align="center">DISCHARGE FORM</h3>';
	$html .= '<b>Name: </b>'.$name.'<br><b>Date of Birth:</b> '.$birthday.'<br><b>Hospital #: </b>'.$hospitalNum.'<h6><br></h6>';
	
	$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
	$html .= tr(array('<b>CHIEF COMPLAINT:</b> <br>'.$cComp.''));
	$html .= table_end();
	
	$cnt = 1;
	$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));	
	if($discCodes != NULL){
		foreach($discCodes as $dCode){
			$html .= tr(array('<b>DISCHARGE DIAGNOSIS:</b><br>'.$dCode->ICD10_DIAGNOSIS.'<br>'));
			$cnt++;
		}
	} else {
		$html .= tr(array('<b>DISCHARGE DIAGNOSIS:</b><br>No diagnosis given.'));
	} $html .= table_end();
	
	if($procPerf != ''){
		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<b>PROCEDURES PERFORMED:</b> <br>'.$procPerf.''));
		$html .= table_end();
	}
	
	if($labProc != ''){
		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array('<b>DIAGNOSTIC PROCEDURE(S) PERFORMED:</b><br>'.implode("<br>", $labProc).''));
		$html .= table_end();
	}
	
	if( $others == "TRUE") {
		$html .= '<br><h4 align="center">Other Diagnostic Procedures for Follow-Up:</h4><br>';
		$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
		$html .= tr(array(implode("<br>", $dProcPer).''));
		$html .= table_end().'<br><br>';
	}
	
	$html .= table_create(array('border' => '1px', 'width'=> '100%', 'height' => '30%', 'cellpadding' => '2px', 'cellspacing' => '0px'));
	if($diagIns != '') $html .= tr(array('<b>DIAGNOSTIC INSTRUCTIONS: </b><br>'.$diagIns.''));
	$html .= tr(array('<b>FOLLOW-UP INSTRUCTIONS: </b><br>'.$follow.''));
	$html .= table_end();
	
	$html.='<br><br><br><br><h4 align="center">';
		if($docName === 'Alvina Pauline D. Santiago, M.D.')
			$html.='<img src = "assets/img/discharge/signature.jpg" style="width: 80px;height: 30px"><br>';
		else 
			$html.='_________________________________________________<br>';
			$html.=$docName.'<br>
			PTR# '.$ptr->ptrNum.'<br>
			PRC# 0410530
			</h4><br><br>';
	$pdf->writeHTML($html, true, false, true, false, '');
	$pdf->lastPage();
	$pdf->Output("DischargeForms(".date("d-m-y").")".$name.".pdf", "D");
?>