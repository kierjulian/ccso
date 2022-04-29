<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Discharge extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('model_patient');
		$this->load->model('model_discpresc');
		$this->load->library('form_validation');
		$this->load->library('session');		
		$this->load->helper('url');
	}

	public function index()
	{
		if(! $this->session->userdata("logged_in")){
			redirect(base_url() . "main/");
		}

		if(!$this->session->userdata("acsDis")){
			$this->load->view('header.php');
			$this->load->view('navbar.php');
			$this->load->view('home_sidebar.php');
			$this->load->view('access_denied.php');
			$this->load->view('footer.php');
			return;
		}

		$this->load->view('header.php');
		$this->load->view('navbar.php');
		$this->load->view('empty_discharge.php');
		$this->load->view('footer.php');
	}
	
	public function loadPage($data){	
		$this->load->view('header.php');
		$this->load->view('navbar.php');
		$this->load->view('discharge_sidebar.php', $data); //contains Prescription and Discharge
		$this->load->view('footer.php');
		$this->load->view('discharge_form', $data);	
	}	
	
	public function forms($patientID) {
		$patientDet = $this->model_patient->getPatient($patientID);
		if(count($patientDet) == NULL){
			$patientDet = array('age'=>0, 'sex'=>'null', 'name'=>'null', 'birthday'=>'');
			$data['serverMsg'] = 'Error! Patient not found in the database!';
		} else{
			$patientDet = $patientDet[0];
			$patientDet->age = date_diff(date_create($patientDet->birthday), date_create('today'))->y; //compute for the patient's age
			$patientDet->sex = ($patientDet->sex == 2) ? 'F' : 'M';
			$patientDet->name = $patientDet->last_name . ', ' . $patientDet->first_name . ' ' . $patientDet->middle_name;
			$data['serverMsg'] = '';
		}
		$data['patient'] = $patientDet;	
		$data['patientID'] = $patientID;
		$vNum = $this->model_discpresc->getVnum($data['patientID']);
		$data['vNum'] = $vNum[0]->visit_num;
		$ptr = $this->model_discpresc->getptr();
		$data['ptr'] = $ptr[0];
		$data['discCodes'] = $this->model_discpresc->getDCodes($data['vNum']);
		$data['meds'] = $this->model_discpresc->getMeds($data['vNum']);
		$data['eyeP'] = $this->model_discpresc->getEye($data['vNum'])[0];

		$gName[0] = '';
		$qty[0]= '';
		$dName[0] = '';
		$data['gName'] = $gName;
		$data['qty'] = $qty;
		$data['dName'] = $dName;
		$data['prescType'] = $this->input->post('prescType');
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->action($data);
		} else {
			$gName[0] = '';
			$qty[0] = '';
			$dName[0] = '';
			$data['gName'] = $gName;
			$data['qty'] = $qty;
			$data['dName'] = $dName;
			$this->loadPage($data);
		}	
	}

	public function action($data) {
		$this->form_validate();
		if($this->input->post('updatePtr') != ''){
			$this->form_validation->run();
			if($this->input->post('newPtr') != ''){
				$this->model_discpresc->updateptr($this->input->post('newPtr'));
				$data['serverMsg'] = 'PTR successfully updated!';			
			} else {
				$data['serverMsg'] = 'Error in PTR input!';			
			}
			$ptr = $this->model_discpresc->getptr();
			$data['ptr'] = $ptr[0];
			$this->loadPage($data);
		} else if($this->input->post('upload') != ''){
			$this->form_validation->run();
			$config['upload_path'] = './assets/files/';
			$config['allowed_types'] = 'txt|pdf|doc|docx';
			$config['max_size']    = '100000';

			//load upload class library
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('filename')){
				// case - failure
				$data['serverMsg'] = 'Something went wrong with the upload!';
				$data['error'] = $this->upload->display_errors();
				$this->loadPage($data);
			}
			else{
				// case - success
				$upload_data = $this->upload->data();
				$fileName = $upload_data['file_name'];
				$fileType = '';
				if(strpos($fileName, '.docx') == FALSE){
					$fileType = substr($fileName, -3);
					$fileName = substr($fileName, 0, -4);
				} else {
					$fileType = substr($fileName, -4);
					$fileName = substr($fileName, 0, -5);
				}
				$url = "assets/files/".$fileName.".php";
				
				 $newfile = fopen($url, "w") or die("Unable to open file!");			
$txt = "<?php
header('Content-disposition: attachment;filename=".$upload_data['file_name']."');header('Content-type:application/".$fileType."');readfile('".$upload_data['file_name']."');
?>";							
				fwrite($newfile, $txt);				
				fclose($newfile); 
				
				$this->model_discpresc->updateFiles($upload_data['file_name']); 		
				$data['success_msg'] = '<div class="alert alert-success text-center">Your file <strong>' . $upload_data['file_name'] . '</strong> was successfully uploaded!</div>';
				$data['serverMsg'] = 'Your file ' . $upload_data['file_name'] . ' was successfully uploaded!';
				$this->loadPage($data);		
			}
		}else if($this->form_validation->run() == FALSE) {
			$msg = 'There are missing fields!';
			$data['serverMsg'] = $msg;
			$this->loadPage($data); 
		} 
		
		else {
			$patientDet = $data['patient'];
			$form = array();
			
			//patient info
			$form['birthday'] = $patientDet->birthday;
			$form['name'] = $patientDet->name;
			$form['age'] = $patientDet->age;
			$form['sex'] = $patientDet->sex;
			$form['cComp'] = $this->input->post('cComp');
			$ptr = $this->model_discpresc->getptr();
			$form['ptr'] = $ptr[0];
			$vNum = $this->model_discpresc->getVnum($data['patientID']);
			$form['vNum'] = $vNum[0]->visit_num;
			
			//prescription variables
			$form['pdate'] = $this->input->post('date');
			$eye = false;
			
			$medNum = $this->input->post('medCount');
			$medQty = array();
			for($x=1;$x<=$medNum;$x++){								
				$medQty[$x] = $this->input->post('qty'.$x);
			}
			$form['medQty'] = $medQty;
			$form['meds'] = $this->model_discpresc->getMeds($form['vNum']);
			
			$prescEye = array();
			$prescEye['ods'] = $this->input->post('ods');
			$prescEye['odc'] = $this->input->post('odc');
			$prescEye['oda'] = $this->input->post('oda');
			$prescEye['odp'] = $this->input->post('odp');
			$prescEye['odadd'] = $this->input->post('odadd');
			$prescEye['odb'] = $this->input->post('odb');
			$prescEye['oddpd'] = $this->input->post('oddpd');
			$prescEye['odnpd'] = $this->input->post('odnpd');
			$prescEye['oss'] = $this->input->post('oss');
			$prescEye['osc'] = $this->input->post('osc');
			$prescEye['osa'] = $this->input->post('osa');
			$prescEye['osp'] = $this->input->post('osp');
			$prescEye['osadd'] = $this->input->post('osadd');
			$prescEye['osb'] = $this->input->post('osb');
			$prescEye['osdpd'] = $this->input->post('osdpd');
			$prescEye['osnpd'] = $this->input->post('osnpd');
			$prescEye['totald'] = $this->input->post('totald');
			$prescEye['totaln'] = $this->input->post('totaln');
			$form['prescEye'] = $prescEye;
			$form['eyeP'] = $data['eyeP'];
			
			//discharge variables
			$form['cDate'] = $this->input->post('doc');
			$form['hospitalNum'] = $this->input->post('hospitalNum');
			$form['discCodes'] = $data['discCodes'];
			$form['discDiagDesc'] = $this->input->post('discDiagDesc');
			if($this->input->post('procPerf')=="") {
				$form['procPerf'] = $this->input->post('procPerfText');
			}
			else {
				$form['procPerf'] = $this->input->post('procPerf');
			}
			
			$catar = array();
			$glauc = array();
			$retin = array();
			$aproc = array();
			$lase = array();
			$pack = array();
			$lab = array();
			$lab = $this->input->post('labProc');
			$others = array();
			$proc = '';
			
			if($lab != ''){
				$proc = array();
				if(in_array("Laboratory", $lab)){
					$lty = "Laboratory " . $this->input->post('labAdd');
					$pos = array_search("Laboratory", $lab);
					array_splice($proc, $pos, 1, $lty);
				}
				
				if(in_array("Radiology", $lab)){
					$rty = "Radiology " . $this->input->post('radAdd');
					$pos = array_search("Radiology", $lab);
					array_splice($proc, $pos, 1, $rty);
				}
				
				if(in_array("Others", $this->input->post('labProc'))){
					$catle = "<br>Cataract: ";
					$catar = $this->input->post('cataract');
					if (!empty($catar)){
						array_splice($catar,0,0,$catle);
						if(in_array("Biometry", $catar)==true){
							$bio = "Biometry" . " " . implode(" ",$this->input->post('bioOpts'));
							$pos = array_search("Biometry", $catar);
							array_splice($catar,$pos,1,$bio);
						}
						$others = array_merge($others,$catar);
					}
					
					$glatle = "<br>Glaucoma: ";
					$glauc = $this->input->post('glaucoma');
					if (!empty($glauc)){
						array_splice($glauc,0,0,$glatle);
						if(in_array("Visual Test Field", $glauc)==true){
							$vts = "Visual Test Field" . " " . implode(" ",$this->input->post('visTestOpts'));
							$pos = array_search("Visual Test Field", $glauc);
							array_splice($glauc,$pos,1,$vts);
						}
						if(in_array("OCT (DISC/RNFL)", $glauc)==true){
							$od = "OCT (DISC/RNFL)" . " " . implode(" ",$this->input->post('octOpts'));
							$pos = array_search("OCT (DISC/RNFL)", $glauc);
							array_splice($glauc,$pos,1,$od);
						}
						if(in_array("Disc Photo", $glauc)==true){
							$dp = "Disc Photo" . " " . implode(" ",$this->input->post('discPhotoOpts'));
							$pos = array_search("Disc Photo", $glauc);
							array_splice($glauc,$pos,1,$dp);
						}
						if(in_array("Center Corneal Thickness", $glauc)==true){
							$cct = "Center Corneal Thickness" . " " . implode(" ",$this->input->post('cctOpts'));
							$pos = array_search("Center Corneal Thickness", $glauc);
							array_splice($glauc,$pos,1,$cct);
						}
						$gdate = "Date of previous test: " . $this->input->post('prevDateGlauc');
						$pos = array_search(end($glauc), $glauc);
						array_splice($glauc,$pos+1,0,$gdate);
					
						$others = array_merge($others,$glauc);
					}
					
					$retle = "<br>Retina: ";
					$retin = $this->input->post('retina');
					if (!empty($retin)){
						array_splice($retin,0,0,$retle);
						if(in_array("B-Scan", $retin)==true){
							$bs = "B-Scan" . " " . implode(" ",$this->input->post('BScanOpts'));
							$pos = array_search("B-Scan", $retin);
							array_splice($retin,$pos,1,$bs);
						}
						if(in_array("Oct (Macula)", $retin)==true){
							$om = "Oct (Macula)" . " " . implode(" ",$this->input->post('maculaOpts'));
							$pos = array_search("Oct (Macula)", $retin);
							array_splice($retin,$pos,1,$om);
						}
						if(in_array("Fundus Photo", $retin)==true){
							$fp = "Fundus Photo" . " " . implode(" ",$this->input->post('fundusOpts'));
							$pos = array_search("Fundus Photo", $retin);
							array_splice($retin,$pos,1,$fp);
						}
						$rdate = "Date of previous test: " . $this->input->post('prevDateRet');
						$pos = array_search(end($retin), $retin);
						array_splice($retin,$pos+1,0,$rdate);
					
						$others = array_merge($others,$retin);
					}
					
					$aptle = "<br>Additional Procedure(s): ";
					$aproc = $this->input->post('addProc');
					if (!empty($aproc)){
						array_splice($aproc,0,0,$aptle);
						$others = array_merge($others,$aproc);
					}
					
					$latle = "<br>Laser: ";
					$lase = $this->input->post('laser');
					if (!empty($lase)){
						array_splice($lase,0,0,$latle);
						if(in_array("others", $lase)==true){
							$loth = "Others: " . $this->input->post('laserOthers');
							$pos = array_search("others", $lase);
							array_splice($lase,$pos,1,$loth);
						}
						$others = array_merge($others,$lase);
					}
					
					$patle = "<br>Package: ";
					$pack = $this->input->post('packageOpts');
					if (!empty($pack)){
						array_splice($pack,0,0,$patle);
						$others = array_merge($others,$pack);
					}
									
					$form['dProcPer'] = $others;
					$form['others'] = "TRUE";
				}
				else{
					$form['dProcPer'] = array();
					$form['others'] = "FALSE";
				}
			} else{
				$form['dProcPer'] = '';
				$form['others'] = "FALSE";
			}
			$form['labProc'] = $proc;
			
			if($this->input->post('disIns') === ('normal')){
				$form['diagIns'] = 'Normal ADLs';
			} else if($this->input->post('disIns') === ('anl')){
				$form['diagIns'] = 'ADLs and Limitation';
			} else {
				$form['diagIns'] = 'Full Restriction';
			}
			$form['follow'] = $this->input->post('follow');
			
			//web info
			$form['patientID'] = $data['patientID'];
			$docName = $this->model_discpresc->getdocname();
			$docName = $docName[0];
			$form['docName'] = $docName->fName . ' ' .$docName->mName. '. ' .$docName->lName . ', ' . $docName->pos;
			
			//update the required stuff
			$this->model_discpresc->updatePatientInfos($form); 
			$this->model_discpresc->updateTimeOut($data['patientID']);
			if ($this->input->post('print') != ''){
				//update and print
				$this->load->view('discharge_print', $form);  
			} else {
				//update only
				$data['serverMsg'] = "Update Successful!";
			}		
			
			$this->loadPage($data);	
		}
	}

	public function form_validate(){
		
		$this->form_validation->set_rules('date', 'Date', 'required|date');
		$this->form_validation->set_rules('totald', 'Distance PD Total', '');
		$this->form_validation->set_rules('totaln', 'Near PD Total', '');
		
		$medNo = $this->input->post('medCount');
		for($x=1; $x<=$medNo; $x++){
			$this->form_validation->set_rules('qty'.$x, 'Medicine '.$x.' Qty ', 'required');
		}
		
		$this->form_validation->set_rules('doc', 'Date of Consultation', 'required');
		$this->form_validation->set_rules('hospitalNum', 'Hospital Number', 'required');
		$this->form_validation->set_rules('cComp', 'Chief Complaint', 'required');
		$this->form_validation->set_rules('procPerf', 'Procedures Performed', '');
		$this->form_validation->set_rules('labProc', 'Lab Procedures', 'callback_check_labProcedures');
		$this->form_validation->set_rules('labAdd', 'Lab Text', '');
		$this->form_validation->set_rules('radAdd', 'Rad Text', '');
		
		//if clicked lang yung others saka lang makikita ang mga ito, no need to be required as long as saved the checks
		$this->form_validation->set_rules('cataract', 'cataract', '');
		$this->form_validation->set_rules('bioOpts', 'bioOpts', '');
		$this->form_validation->set_rules('glaucoma', 'glaucoma', '');
		$this->form_validation->set_rules('visTestOpts', 'visTestOpts', '');
		$this->form_validation->set_rules('octOpts', 'octOpts', '');
		$this->form_validation->set_rules('discPhotoOpts', 'discPhotoOpts', '');
		$this->form_validation->set_rules('cctOpts', 'cctOpts', '');
		$this->form_validation->set_rules('prevDateGlauc', 'prevDateGlauc', '');
		$this->form_validation->set_rules('retina', 'retina', '');
		$this->form_validation->set_rules('BScanOpts', 'BScanOpts', '');
		$this->form_validation->set_rules('maculaOpts', 'maculaOpts', '');
		$this->form_validation->set_rules('fundusOpts', 'fundusOpts', '');
		$this->form_validation->set_rules('prevDateRet', 'prevDateRet', '');
		$this->form_validation->set_rules('addProc', 'addProc', '');
		$this->form_validation->set_rules('laser', 'laser', '');
		$this->form_validation->set_rules('laserOthers', 'laserOthers', '');
		$this->form_validation->set_rules('packageOpts', 'packageOpts', '');
		//end of others
		
		$this->form_validation->set_rules('disIns', 'Diagnostic Instructions', '');
		$this->form_validation->set_rules('follow', 'Follow Up Instructions', 'required');
		
	}

	function check_labProcedures(){
		$labProc = $this->input->post("labProc");							
		$falseCnt = 0;
		$message = '';
		if ($labProc == '') return TRUE;
		foreach ($labProc as $value){
			if ($value == "Others"){
				if($cataract = $this->input->post("cataract")){
					foreach($cataract as $value1){
						if($value1=="Biometry"){											
							if(!$this->input->post("bioOpts")){		
								$message .= 'Please choose between OS and OD in Biometry.<br><br>';
								$falseCnt++;
							}
							
						}
					}						
				}
				if($glaucoma = $this->input->post("glaucoma")){	
					foreach($glaucoma as $value1){							
						if($value1 == "Visual Test Field"){
							if(!$this->input->post("visTestOpts")){									
								$message .= 'Please choose between OS and OD in Visual Test Field.<br><br>';
								$falseCnt++;
							}									
						}
						if($value1 == "CT (DISC/RNFL)"){
							if(!$this->input->post("octOpts")){
								$message .= 'Please choose between OS and OD in CT (DISC/RNFL).<br><br>';
								$falseCnt++;
							}										
						}
						if($value1 == "Disc Photo"){
							if(!$this->input->post("discPhotoOpts")){
								$message .= 'Please choose between OS and OD in Disc Photo.<br><br>';
								$falseCnt++;
							}										
						}
						if($value1 == "Center Corneal Thickness"){
							if(!$this->input->post("cctOpts")){
								$message .= 'Please choose between OS and OD in Center Corneal Thickness.<br><br>';
								$falseCnt++;
							}
						}
					}
					if(!$this->input->post("prevDateGlauc")){
						$message .= 'Please input Date of Previous Test for Glaucoma.<br><br>';
						$falseCnt++;
					}
				}
				if($retina = $this->input->post("retina")){					
					foreach($retina as $value1){							
						if($value1 == "B-Scan"){
							if(!$this->input->post("BScanOpts")){
								$message .= 'Please choose between OS and OD in B-Scan.<br><br>';
								$falseCnt++;
							}									
						}
						if($value1 == "Oct (Macula)"){
							if(!$this->input->post("maculaOpts")){
								$message .= 'Please choose between OS and OD in Oct (Macula).<br><br>';
								$falseCnt++;
							}										
						}
						if($value1 == "Fundus Photo"){
							if(!$this->input->post("fundusOpts")){
								$message .= 'Please choose between OS and OD in Fundus Photo.<br><br>';
								$falseCnt++;
							}
						}
					}
					if(!$this->input->post("prevDateRet")){
						$message .= 'Please input Date of Previous Test for Retina.<br><br>';
						$falseCnt++;
					}
				}
				if($laser = $this->input->post("laser")){					
					foreach($laser as $value1){
						if($value1 == "others"){
							if(!$this->input->post("laserOthers")){
								$message .= 'Please fill out others field for laser.<br><br>';
								$falseCnt++;
							}
						}
					}
				}
			}
		}
		if($falseCnt>0){
			$this->form_validation->set_message('check_labProcedures', $message);
			return false;
		}
		else 
			return true;
	}
}

/* End of file discharge.php */
/* Location: ./application/controllers/discharge.php */