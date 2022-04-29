<?php 
	$this->load->helper('url');
	$this->load->helper('html');
	$this->load->helper('additional_html');
	$this->load->helper('form');
	$this->load->helper('table');
	@mysql_connect('localhost', 'root', '') or die ('Could not connect to database' . mysql_error());
	mysql_select_db('ccso');
	
	echo '<section id="main-content"><section class="wrapper"><head>'."\n";
	echo sing_tag('title', 'Discharge');
	echo link_tag('assets/css/discharge.css');
	echo "<script src = ".base_url()."assets/scripts/add.js>";
	echo add_tag('script', array('src' => 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'));
	echo '</script>'."\n".'</head>'."\n".'<body>';
	echo div('page-wrap');
	echo '<header>';
	echo '<nav><h1>PRESCRIPTION FORM</h1>';
	echo ul(array(''), array('class'=>'group'));
	echo '</nav>'."\n".'</header>';
	echo div('inner');

	//PRESCIPTION FORM
	$urlForm = 'discharge/forms/' . $patientID;
	echo form_open($urlForm);
	echo div('right', 'right');
	echo '<id="info" class="info"><b>Date: </b>';
	echo form_input(array('type' => 'date', 'name' => 'date', 'class' => 'info', 'required'),set_value('date'));
	echo br(1);
	
	echo '</id></div>'."\n".'<id="info">Name:</id>';
	echo nbs(2);
	echo $patient->name;
	echo '<id="info" class="right"><br>Age:</id>';
	echo nbs(2);
	echo date_diff(date_create($patient->bday), date_create('today'))->y;
	echo nbs(5);
	echo 'Sex:';
	echo nbs(2);
	echo $patient->sex;
	echo br(2);

	for ($x=0; $x<$addMedNo;$x++){
		echo form_input(array('id'=>'gName'.$x ,'name'=>'gName'.$x ,'placeholder'=>'Generic Name', 'required', 'class'=>'input', 'size'=>'50'),set_value('gName'.$x));
		echo nbs(1);
		echo form_input(array('id'=>'qty'.$x, 'name'=>'qty'.$x, 'placeholder'=>'Quantity', 'required', 'class'=>'input', 'size'=>'5'),set_value('qty'.$x));
		echo nbs(1);
		echo '<id="info">#</id>';
		echo nbs(1);
		echo form_input(array('id'=>'dName'.$x, 'name'=>'dName'.$x, 'placeholder'=>'Drug Name', 'required', 'class'=>'input', 'size'=>'50'),set_value('dName'.$x));
		echo nbs(1);	
	}
	echo "<input type='button' name='add' value='ADD' onClick='addMed(\"$patientID\", \"$addMedNo\")'/>";
	
	echo '<id="info"><b>#</b></id>';
	echo br(2);
	echo form_input(array('id'=>'dName','name'=>'dName', 'placeholder'=>'Drug Name', 'required', 'class'=>'input', 'size'=>'50'),set_value('dName'));
	echo nbs(1);
	
	echo form_input(array('type'=>'button', 'name'=>'add', 'value'=>'ADD', 'class'=>'input'));
	echo '<br><br>'."\n".'<id="info"><b>Sig</b><br>';
	echo form_textarea(array('id'=>'sig','name'=>'sig','required', 'class'=>'input', 'size'=>'50', 'height'=>'40', 'rows'=>'3', 'cols'=>'53'),set_value('sig'));
	echo br(2);
	
	//DISCHARGE FORM
	echo '<header>';
	echo '<nav><h1>DISCHARGE FORM</h1>';
	echo ul(array(''), array('class'=>'group'));
	echo '</nav>'."\n".'</header>';
	echo add_tag('section', array('id'=>'main-content'));
	echo div('form');
	echo div('inner');
	
	echo div('right', 'right');
	echo '<center>';
	echo '</center><id="info" class="info"><b>Date of Birth:</b> ';
	echo $patient->bday;
	echo br(1);
	echo '<id="info" class="info"><b>Date of Consultation:</b> ';
	echo form_input(array('type' => 'date', 'name' => 'doc', 'class' => 'info', 'required'), set_value('doc'));
	echo br(2);
	echo '</id></div>'.'<id="info"><b>Name:</b> </id>';
	echo $patient->name;

	echo br(1);
	echo '<id="info"><b>Hospital #:</b> ';
	echo form_input(array('type' => 'number', 'name' => 'hospitalNum', 'class' => 'input', 'style' => 'width: 3em', 'min' => '1', 'required'),set_value('hospitalNum'));
	echo br(3);
	echo '<id="info"><b>Chief Complaint: </b></id>';
	echo form_input(array('name'=>'cComp', 'required', 'class'=>'input', 'size'=>'55'),set_value('cComp'));
	echo br(2);
	
	echo '<b>Discharge diagnosis: </b>';
	$sql = "SELECT * FROM `table 2` WHERE 1";
	$result = mysql_query($sql);
	
	echo '<select name="dischargeDiag" required class="info">';
	while ($row = mysql_fetch_array($result)) {
		echo '<option value="' . $row["DCode"] . '">' . $row["DCode"] . '</option>';			
	}
	echo '</select>';
	
	echo br(2);
	echo '<b>Procedures Performed: </b>';
	
	$sql2 = "SELECT * FROM `table 2` WHERE 1";
	$result2 = mysql_query($sql2);
	
	echo '<select name="procPerf" required class="info">';
	while ($row = mysql_fetch_array($result2)) {
		echo '<option value="' . $row["DCode"] . '">' . $row["DCode"] . '</option>';			
	}
	echo '</select>';
	echo br(2);
	echo '<b>Lab Procedures for Follow-Up: </b>';
	echo br(1);
	
	
	echo '<script>
			function viewBox(val){
			if (val == "Others")
				$(otherProcedures).show();
			else 
				$(otherProcedures).hide();
			}
		</script>';
	$radData = array('name'=>'labProc', 'value' => 'Lab', 'onClick' => 'viewBox(this.value)');
	echo form_radio($radData);
	echo 'Laboratory';
	echo br(1);
	$radData['value'] ='Rad';
	echo form_radio($radData);
	echo 'Radiology';
	echo br(1);
	$radData['value'] ='Others';
	echo form_radio($radData);
	echo 'Others';
	echo br(1);
	echo div ('otherProcedures');
	echo div ('procedureExtras');
	echo br(2);
	
	echo '<b>CATARACT</b>';	// "Others" Options **************************************************************
	echo br(1);
	echo nbs(10);
	echo form_radio('cataract', 'biometry');
	echo 'Biometry';
	echo br(1);
	echo nbs(20);
	echo form_radio('bioOpts','OD');
	echo'OD'; 
	echo nbs(10);
	echo form_radio('bioOpts','OS');  
	echo'OS';
	echo br(1);
	echo nbs(10);
	echo form_radio('Cataract','endoCell');
	echo'Endothelial Cell Count';
	echo br(2);
	
	echo '<b>GLAUCOMA</b>';
	echo br(1);
	echo nbs(10);
	echo form_radio('glaucoma','visTest');
	echo 'Visual Test Field<br>';
	echo nbs(20);
	echo form_radio('visTestOpts','OD');
	echo'OD';
	echo nbs(10);
	echo form_radio('visTestOpts','OS');
	echo'OS <br />';
	echo nbs(10);
	echo form_radio('glaucoma','oct');
	echo'OCT (DISC/RNFL)';
	echo br(1);
	echo nbs(20);
	echo form_radio('octOpts','OD');
	echo'OD';
	echo nbs(10);
	echo form_radio('octOpts','OS');
	echo'OS <br />';
	echo nbs(10);
	echo form_radio('glaucoma','discPhoto');
	echo'Disc Photo';
	echo br(1);
	echo nbs(20);
	echo form_radio('discPhotoOpts','OD');
	echo'OD';
	echo nbs(10);
	echo form_radio('discPhotoOpts','OS');
	echo'OS <br />';
	echo nbs(10);
	echo form_radio('glaucoma','cct');
	echo'Center Corneal Thickness';
	echo br(1);
	echo nbs(20);
	echo form_radio('cctOpts','OD');
	echo'OD';
	echo nbs(10);
	echo form_radio('cctOpts','OS');
	echo'OS';
	echo br(1);
	echo 'Date of previous test:';
	echo nbs(2);
	echo form_input(array('type' => 'date', 'name' => 'prevDateGlauc'));
	echo br(2);
	
	echo '<b>RETINA</b>';
	echo br(1);
	echo nbs(10);
	echo form_radio('retina','BScan');
	echo 'B-Scan';
	echo br(1);
	echo nbs(20);
	echo form_radio('BScanOpts','OD');
	echo 'OD';
	echo nbs(10);
	echo form_radio('BScanOpts','OS');
	echo'OS <br />';
	echo nbs(10);
	echo form_radio('retina','macula');
	echo'Oct (Macula)';
	echo br(1);
	echo nbs(20);
	echo form_radio('maculaOpts','OD');
	echo'OD';
	echo nbs(10);
	echo form_radio('maculaOpts','OS');
	echo'OS <br />';
	echo nbs(10);
	echo form_radio('retina','flan');
	echo'Fluorescein Angiography<br />';
	echo nbs(10);
	echo form_radio('retina','fundus');
	echo'Fundus Photo';
	echo br(1);
	echo nbs(20);
	echo form_radio('fundusOpts','OD');
	echo'OD';
	echo nbs(10);
	echo form_radio('fundusOpts','OS');
	echo'OS';
	echo br(1);
	echo 'Date of previous test:';

	echo nbs(2);
	echo form_input(array('type' => 'date', 'name' => 'prevDateRet'));
	echo br(2);
	
	echo '<b>ADDITIONAL PROCEDURES</b>';
	echo br(1);
	echo nbs(10);
	echo form_radio('addProc','dilate');
	echo'Dilate';
	echo nbs(10);
	echo form_radio('addProc','constrict');
	echo'Constrict';
	echo nbs(10);
	echo form_radio('addProc','asis');
	echo'AS IS <br />';
	echo nbs(10);
	echo form_radio('addProc','od');
	echo'OD';
	echo nbs(15);
	echo form_radio('addProc','os');
	echo'OS';
	echo nbs(10);
	echo form_radio('addProc','ou');
	echo'OU</div>';
	
	echo div ('righthalf');
	echo div ('laserExtras');
	echo br(1);
	echo nbs(10);
	echo 'LASER: ';
	echo br(1);
	echo nbs(15);
	echo form_radio('laser','prp');
	echo 'PRP';
	echo nbs(38);
	echo form_radio('laser','pascal');
	echo'PASCAL<br />';
	echo nbs(15);
	echo form_radio('laser','focal');
	echo'FOCAL';
	echo nbs(33);
	echo form_radio('laser','532nm');
	echo'532nm DIODE<br />';
	echo nbs(15);
	echo form_radio('laser','lio');
	echo'LIO';
	echo nbs(40);
	echo form_radio('laser','810nm');
	echo'810nm DIODE<br />';
	echo nbs(15);
	echo form_radio('laser','caps');
	echo'CAPSULOTOMY';
	echo nbs(16);
	echo form_radio('laser','yag');
	echo'YAG<br />';
	echo nbs(15);
	echo form_radio('laser','iridotomy');
	echo'LASER IRIDOTOMY';
	echo nbs(10);
	echo form_radio('laser','pdt');
	echo'PDT<br />';
	echo nbs(15);
	echo form_radio('laser','slt');
	echo'SLT<br />';
	echo nbs(15);
	echo form_radio('laser','other');
	echo'Others(Please Specify)<br />';
	echo nbs(15);
	echo form_input('laserOthers');
	echo'</div>';
	echo br(1);
	
	echo div ('packageOptions');
	echo '<b>PACKAGE:</b>';
	echo br(1);
	echo nbs(5);
	echo form_radio('packageOpts', 'retAsses');
	echo'RETINA ASSESSMENT (FA,OCT)<br />';
	echo nbs(5);
	echo form_radio('packageOpts', 'glaucProf');
	echo'GLAUCOMA RISK PROFILE (VFT,OCT,DISC PHOTO)<br />';
	echo nbs(5);
	echo form_radio('packageOpts', 'glaucPlus');
	echo'GLAUCOMA PLUS PACKAGE (VFT,OCT,DISC PHOTO,CENTRAL CORNEAL THICKNESS)<br />';
	echo nbs(5);
	echo form_radio('packageOpts', 'etham');
	echo'ETHAMBUTOL TOXICITY SCREENING / MONITORING (VFT,OCT,FUNDUS PHOTO)<br />';
	echo nbs(5);
	echo form_radio('packageOpts', 'lowVis');
	echo'LOW VISION';
	echo br(1);
	echo '</div></div></div></div>'; // "Others" Options **************************************************************
	echo br(1)
;
	
	// Discharge Instructions
	echo '<b>Discharge Instructions:</b>';
	echo br(1);
	echo form_radio('disIns', 'normal');
	echo 'Normal ADLs';
	echo br(1);
	echo form_radio('disIns', 'anl');
	echo'ADLs and Limitation';
	echo br(1);
	echo form_radio('disIns', 'fullRes');
	echo'Full Restriction<br /></id>';
	echo br(2);
	echo '<p id="info"><b>Follow Up Instructions: </b></p>';
	echo form_textarea(array('name'=>'follow', 'class'=>'input', 'size'=>'50', 'height'=>'40', 'rows'=>'3', 'cols'=>'57'),set_value('follow'));	
	echo br(3);
	echo  '<center>';
	echo form_submit('update', 'UPDATE');
	echo br(2);
	echo form_submit('print', 'PRINT');
	echo '</form>';
	echo '</center>';
	
	echo '</div></div></section>';
	echo '<br></div></body>';
	echo '</section></section>';
?>