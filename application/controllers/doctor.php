<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	require_once "assets/classes/ImageTableManager.php";
	require_once "assets/classes/Image.php";
	require_once "assets/classes/MessageManager.php";	
	require_once "assets/classes/Patient.php";
	require_once "assets/classes/Appointment.php";
	
class Doctor extends CI_Controller 
{
	function __construct(){
		parent::__construct();
		$this->load->model('model_discpresc');		
	}
	function searchICD(){
		$this->load->view('header.php');
		$this->load->view('navbar.php');
		$this->load->view('footer.php');
		$this->load->view('ICDsearchv.php');
	}
	function checknull($arr){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		foreach ($arr as &$elt) {
			if($elt == '')	$elt = 'N/A';
		}
		return $arr;
	}
	function print_me(){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$this->load->view('doc_print.php',$_POST);
	}
	function fetch_images_today ($vn) {
		$date_arr = getdate();
		$date_str = $date_arr['year']."-".$date_arr['mon']."-".$date_arr['mday'];
    	
    	$sql = "SELECT images.profile_id, images.image_id, images.image_name, images.image_path, images.image_comments, images.image_tags FROM `images`, `appointments` WHERE images.profile_id = appointments.true_id and appointments.visit_num = ".$vn;
		$sql = $this->db->query($sql) or die(mysql_error());
		return $sql->result();
	}
	function save_va($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `eye_exam_va` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		
		$va = "INSERT INTO `eye_exam_va` "
			. "(`VISIT_NO`,`DATE_CONSULT`,`VA_OD_SC`,`VA_OS_SC`,`VA_OD_SC_PH`,`VA_OS_SC_PH`,`VA_OD_BESTCORRECTION`,`VA_OS_BESTCORRECTION`,`OD_BESTCORRECTION_DISTANCE`,`OS_BESTCORRECTION_DISTANCE`,`VA_OU_DISTANCE_FORCED1`,`VA_OU_DISTANCE_AHP`,`OD_BESTCORRECTION_NEAR`,`OS_BESTCORRECTION_NEAR`,`AHP_NEAR`,`VA_OU_AHP_NEAR`,`VA_OU_FORCED1_NEAR`,`VA_OU_DOWNGAZE_NEAR`) "
			. "VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		
		$arg_va = array(
			$vn,
			$this->input->post('date_va'),
			$this->input->post('va_NoCorrect_r'),
			$this->input->post('va_NoCorrect_l'),
			$this->input->post('va_NoCorrect_pin_r'),
			$this->input->post('va_NoCorrect_pin_l'),
			$this->input->post('BestCorrect_r'),
			$this->input->post('BestCorrect_l'),
			$this->input->post('BestCorrect_dist_r'),
			$this->input->post('BestCorrect_dist_l'),
			$this->input->post('ForcedPrimary_dist'),
			$this->input->post('ahp_dist'), 				//va_ou_distance_ahp
			$this->input->post('BestCorrect_near_r'),
			$this->input->post('BestCorrect_near_l'),
			$this->input->post('ahp_near'),
			$this->input->post('va_ou_ahp_near'), 			//va_ou_ahp_near
			$this->input->post('ForcedPrimary_near'),
			$this->input->post('va_downgaze')
		);

		$arg_va = $this->checknull($arg_va);
		if ($this->db->query($va, $arg_va)) {
			$data = $this->get_va($vn, $data);
			$this->load_page($vn,$data);
		}
		else{
			$this->load->view('doc_page_error.php');
		}
	}

	function save_refrac($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `eye_exam_refraction` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

		$refrac = "INSERT INTO `eye_exam_refraction` "
			. "(`VISIT_NO`,`DATE_CONSULT`,`RIGHT_DRY_AUTOREFRACTION`,`RIGHT_DRY_OBJ_REFRACTION`,`RIGHT_VA_OBJECTIVE`,`RIGHT_MANIFEST_REFRACTION`,`RIGHT_VA_MANIFEST`,`RIGHT_CYCLO_REFRACTION`,`RIGHT_VA_CYCLO`,`RIGHT_CYCLOPLEGIC`,`RIGHT_TOLERATED_REFRACTION`,`RIGHT_VA_TOLERATED`,"
			."`LEFT_DRY_AUTOREFRACTION`,`LEFT_DRY_OBJ_REFRACTION`,`LEFT_VA_OBJECTIVE`,`LEFT_MANIFEST_REFRACTION`,`LEFT_VA_MANIFEST`,`LEFT_CYCLO_REFRACTION`,`LEFT_VA_CYCLO`,`LEFT_CYCLOPLEGIC`,`LEFT_TOLERATED_REFRACTION`,`LEFT_VA_TOLERATED`,`REFRACTION_REMARKS`) "
			. "VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			
		$arg_refrac = array(
				$vn,
				$this->input->post('date_ref'),
				$this->input->post('DryAutoRef_r'),
				$this->input->post('ObjRef_r'),		//right dryobjref
				$this->input->post('va_ObjRef_r'),
				$this->input->post('ManRef_r'),
				$this->input->post('va_ManRef_r'),
				$this->input->post('CycloRef_r'),
				$this->input->post('va_CycloRef_r'),
				$this->input->post('CycloAgent_r'),	//right cycloplegic
				$this->input->post('TolRef_r'),
				$this->input->post('va_TolRef_r'),
				$this->input->post('DryAutoRef_l'),
				$this->input->post('ObjRef_l'),		//left dry obj ref
				$this->input->post('va_ObjRef_l'),
				$this->input->post('ManRef_l'),
				$this->input->post('va_ManRef_l'),
				$this->input->post('CycloRef_l'),
				$this->input->post('va_CycloRef_l'),
				$this->input->post('CycloAgent_l'),	//left cycloplegic
				$this->input->post('TolRef_l'),
				$this->input->post('va_TolRef_l'),				
				$this->input->post('ref_remarks')
			);
		$arg_refrac = $this->checknull($arg_refrac);
		if ($this->db->query($refrac, $arg_refrac)) {
			$data = $this->get_refrac($vn, $data);
			$this->load_page($vn,$data);
		}
		else{
			$this->load->view('doc_page_error.php');   //... at least one non-true value // set NA LANG DIN!
		}
	}
	function save_pupils($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `eye_exam_pupils` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

		$pupils = "INSERT INTO `eye_exam_pupils` "
			. "(`VISIT_NO`,`DATE_CONSULT`,`OD_PUPIL_COLOR`,`OD_PUPIL_SHAPE`,`OD_PUPIL_SIZE_AMBIENT`,`OD_PUPIL_RTL_AMBIENT`,`OD_PUPIL_SIZE_DARK`,`OD_PUPIL_RTL_DARK`,`OD_RAPD`,`OD_PUPIL_OTHERS_1`,"
			. "`OS_PUPIL_COLOR`,`OS_PUPIL_SHAPE`,`OS_PUPIL_SIZE_AMBIENT`,`OS_PUPIL_RTL_AMBIENT`,`OS_PUPIL_SIZE_DARK`,`OS_PUPIL_RTL_DARK`,`OS_RAPD`,`OS_PUPIL_OTHERS_2`) "
			. "VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			
		$arg_pupils = array(
				$vn,
				$this->input->post('date_pupil'),
				$this->input->post('PupilColor_r'),
				$this->input->post('PupilShape_r'),
				$this->input->post('PupilSize_amb_r'),
				$this->input->post('LightRxn_amb_r'),	//R PUPIL RTL AMBIENT
				$this->input->post('PupilSize_dark_r'),
				$this->input->post('LightRxn_dark_r'),	//R PUPIL RTL DARK
				$this->input->post('relAPD_r'),
				$this->input->post('pupil_other_r'),	// pupil other 1
				$this->input->post('PupilColor_l'),
				$this->input->post('PupilShape_l'),
				$this->input->post('PupilSize_amb_l'),
				$this->input->post('LightRxn_amb_l'),	//L PUPIL RTL AMBIENT
				$this->input->post('PupilSize_dark_l'),
				$this->input->post('LightRxn_dark_l'),	//L PUPIL RTL DARK
				$this->input->post('relAPD_l'),
				$this->input->post('pupil_other_l')		// pupil other 2
			
			);
		$arg_pupils = $this->checknull($arg_pupils);
		if ($this->db->query($pupils, $arg_pupils)) {
			$data = $this->get_pupils($vn, $data);
			$this->load_page($vn,$data);
		}
		else
		{
			$this->load->view('doc_page_error.php');   //... at least one non-true value // set NA LANG DIN!
		}
	}
	function save_gross($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `eye_exam_gross` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

		$gross = "INSERT INTO `eye_exam_gross` "
        . "(`VISIT_NO`,`DATE_CONSULT`,`RIGHT_EYEBROW`,`RIGHT_ADNEXAE`,`RIGHT_LIDFISSURE_HT`,`RIGHT_CORNEA`,`RIGHT_SCLERA`,`RIGHT_OTHERS`,`RIGHT_PHOTOGRAPH`,`LEFT_EYEBROW`,`LEFT_ADNEXAE`,`LEFT_LIDFISSURE_HT`,`LEFT_CORNEA`,`LEFT_SCLERA`,`LEFT_OTHERS`,`LEFT_PHOTOGRAPH`) "
        . "VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        
      $arg_gross = array(
			$vn,
			$this->input->post('date_gross'),
			$this->input->post('eyebrow_r'),
			$this->input->post('adnexae_r'),
			$this->input->post('lidFissure_r'),
			$this->input->post('corneaGross_r'),
			$this->input->post('scleraGross_r'),
			$this->input->post('gross_other_r'),
			$this->input->post('gross_img_r'),
			$this->input->post('eyebrow_l'),
			$this->input->post('adnexae_l'),
			$this->input->post('lidFissure_l'),
			$this->input->post('corneaGross_l'),
			$this->input->post('scleraGross_l'),
			$this->input->post('gross_other_l'),        
			$this->input->post('gross_img_l')
		);

		$date_arr = getdate();
		$date_str = $date_arr['year']."-".$date_arr['mon']."-".$date_arr['mday'];
		for ($ctr=0;$ctr<$this->input->post('gross_count');$ctr++) {
			$sql = "UPDATE `images` SET image_comments = '".$this->input->post('gross_img_'.$ctr)."' , date_modif = ".$date_str."  WHERE image_id = '".$this->input->post('gross_id_'.$ctr)."'";
			$sql = $this->db->query($sql) or die(mysql_error());			
		}

      	$arg_gross = $this->checknull($arg_gross);
		if ($this->db->query($gross, $arg_gross)) {
			$data = $this->get_gross($vn, $data);
			$this->load_page($vn, $data);
		}
		else{
			$this->load->view('doc_page_error.php'); 
		}

	}
	function save_post($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `eye_exam_posterior` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

		$post = "INSERT INTO `eye_exam_posterior` "
        . "(`VISIT_NO`,`DATE_CONSULT`,`EYE_EXAM_POSTERIOR_INSTRUMENT`,`RIGHT_Z1_OPTICNERVE`,`RIGHT_Z1_RETINAL_ARCADE_VESSELS`,`RIGHT_Z1_MACULA`,`RIGHT_Z1_VITREOUS`,`RIGHT_Z2_RETINAL_ARCADE_VESSELS`,`RIGHT_Z2_BRANCHING`,`RIGHT_Z2_ARTERIES`,`RIGHT_Z2_VEINS`,`RIGHT_Z2_VORTEX`,`RIGHT_Z2_VITREOUS`,`RIGHT_Z3_RETINA`,`RIGHT_Z3_VESSELS`,`RIGHT_Z3_VITREOUS`,`RIGHT_OTHER_POSTERIOR`,`LEFT_Z1_OPTICNERVE`,`LEFT_Z1_RETINAL_ARCADE_VESSELS`,`LEFT_Z1_MACULA`,`LEFT_Z1_VITREOUS`,`LEFT_Z2_RETINAL_ARCADE_VESSELS`,`LEFT_Z2_BRANCHING`,`LEFT_Z2_ARTERIES`,`LEFT_Z2_VEINS`,`LEFT_Z2_VORTEX`,`LEFT_Z2_VITREOUS`,`LEFT_Z3_RETINA`,`LEFT_Z3_VESSELS`,`LEFT_Z3_VITREOUS`,`LEFT_OTHER_POSTERIOR`) "
        . "VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$arg_post = array(
				$vn,
				$this->input->post('date_postpole'),
				$this->input->post('PostPoleInstrument'),
				$this->input->post('zone1_optic_r'),
				$this->input->post('zone1_retinal_r'),
				$this->input->post('zone1_macula_r'),
				$this->input->post('zone1_vitreous_r'),
				$this->input->post('zone2_retinal_r'),	//r retinal arcade zone 2
				$this->input->post('zone2_branch_r'),
				$this->input->post('zone2_artery_r'),
				$this->input->post('zone2_veins_r'),
				$this->input->post('zone2_vortex_r'),
				$this->input->post('zone2_vitreous_r'),
				$this->input->post('zone3_retina_r'),
				$this->input->post('zone3_vessels_r'),
				$this->input->post('zone3_vitreous_r'),
				$this->input->post('PostPole_other_r'),
				$this->input->post('zone1_optic_l'),
				$this->input->post('zone1_retinal_l'),
				$this->input->post('zone1_macula_l'),
				$this->input->post('zone1_vitreous_l'),
				$this->input->post('zone2_retinal_l'),	//l retinal arcade zone 2			
				$this->input->post('zone2_branch_l'),
				$this->input->post('zone2_artery_l'),		
				$this->input->post('zone2_veins_l'),
				$this->input->post('zone2_vortex_l'),
				$this->input->post('zone2_vitreous_l'),
				$this->input->post('zone3_retina_l'),
				$this->input->post('zone3_vessels_l'),
				$this->input->post('zone3_vitreous_l'),
				$this->input->post('PostPole_other_l')
		);
		$arg_post = $this->checknull($arg_post);
		if ($this->db->query($post, $arg_post)) {
			$data = $this->get_post($vn, $data);
			$this->load_page($vn, $data);
		}
		else{
			$this->load->view('doc_page_error.php'); 
		}
	}
	function save_slitlamp($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `eye_exam_slitlamp` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

		$slitlamp = "INSERT INTO `eye_exam_slitlamp` "
        . "(`VISIT_NO`,`DATE_CONSULT`,`RIGHT_LIDS_UPPER`,`RIGHT_LIDS_LOWER`,`RIGHT_CONJ_PALPEBRAL`,`RIGHT_CONJ_BULBAR`,`RIGHT_SCLERA_SL`,`RIGHT_LIMBUS_SL`,`RIGHT_CORNEA_SL`,`RIGHT_ANGLES_TM`,`RIGHT_AC`,`RIGHT_GONIO_FINDINGS`,`RIGHT_GONIO_DRAWING`,`RIGHT_GONIO_PHOTO`,`RIGHT_IRIS_SL`,`RIGHT_LENS_SL`,`RIGHT_VITREOUS_SL`,`RIGHT_OPTIC_NERVE_SL`,`RIGHT_RETINAL_ARCADE_VESSELS_SL`,`RIGHT_MACULA_SL`,`RIGHT_POSTERIOR_OTHERS`,`RIGHT_PHOTO_SL`, "
        . "`LEFT_LIDS_UPPER`,`LEFT_LIDS_LOWER`,`LEFT_CONJ_PALPEBRAL`,`LEFT_CONJ_BULBAR`,`LEFT_SCLERA_SL`,`LEFT_LIMBUS_SL`,`LEFT_CORNEA_SL`,`LEFT_ANGLES_TM`,`LEFT_AC`,`LEFT_GONIO_FINDINGS`,`LEFT_GONIO_DRAWING`,`LEFT_GONIO_PHOTO`,`LEFT_IRIS_SL`,`LEFT_LENS_SL`,`LEFT_VITREOUS_SL`,`LEFT_OPTIC_NERVE_SL`,`LEFT_RETINAL_ARCADE_VESSELS_SL`,`LEFT_MACULA_SL`,`LEFT_POSTERIOR_OTHERS`,`LEFT_PHOTO_SL`) "
        . "VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

		$arg_slitlamp = array(
			$vn,
			$this->input->post('date_sl'),
			$this->input->post('lidsUp_r'),
			$this->input->post('lidsLow_r'),
			$this->input->post('conj_palp_r'),
			$this->input->post('conj_bulb_r'),
			$this->input->post('sl_sclera_r'),
			$this->input->post('limbus_r'),
			$this->input->post('sl_cornea_r'),
			$this->input->post('AnglesMesh_r'),
			$this->input->post('anterior_r'),
			$this->input->post('gonio_find_r'),
			$this->input->post('gonio_draw_r'),
			$this->input->post('gonio_img_r'),
			$this->input->post('iris_r'),
			$this->input->post('lens_r'),
			$this->input->post('sl_vitreous_r'),
			$this->input->post('sl_nerve_r'),
			$this->input->post('sl_retinal_r'),
			$this->input->post('sl_macula_r'),
			$this->input->post('sl_posterior_r'),
			$this->input->post('sl_img_r'),
			$this->input->post('lidsUp_l'),
			$this->input->post('lidsLow_l'),
			$this->input->post('conj_palp_l'),
			$this->input->post('conj_bulb_l'),
			$this->input->post('sl_sclera_l'),
			$this->input->post('limbus_l'),
			$this->input->post('sl_cornea_l'),
			$this->input->post('AnglesMesh_l'),
			$this->input->post('anterior_l'),
			$this->input->post('gonio_find_l'),
			$this->input->post('gonio_draw_l'),
			$this->input->post('gonio_img_l'),
			$this->input->post('iris_l'),
			$this->input->post('lens_l'),
			$this->input->post('sl_vitreous_l'),
			$this->input->post('sl_nerve_l'),
			$this->input->post('sl_retinal_l'),
			$this->input->post('sl_macula_l'),
			$this->input->post('sl_posterior_l'),
			$this->input->post('sl_img_l')
		);

		$date_arr = getdate();
		$date_str = $date_arr['year']."-".$date_arr['mon']."-".$date_arr['mday'];
		for ($ctr=0;$ctr<$this->input->post('slitlamp_count');$ctr++) {
			$sql = "UPDATE `images` SET image_comments = '".$this->input->post('slitlamp_img_'.$ctr)."' , date_modif = ".$date_str."  WHERE image_id = '".$this->input->post('slitlamp_id_'.$ctr)."'";
			$sql = $this->db->query($sql) or die(mysql_error());			
		}

		$arg_slitlamp = $this->checknull($arg_slitlamp);
		if ($this->db->query($slitlamp, $arg_slitlamp)) {
			$data = $this->get_slitlamp($vn, $data);
			$this->load_page($vn, $data);
		}
		else{
			$this->load->view('doc_page_error.php'); 
		}
	}
	function save_stereo($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `eye_exam_stereoacuity` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

		$stereo = "INSERT INTO `eye_exam_stereoacuity` "
        . "(`VISIT_NO`,`DATE_CONSULT`,`STEREO_DIST_USED`,`STEREO_DIST_RESULT`,`STEREO_NEAR_TEST`,`STEREO_NEAR_RESULT`,`INTERPRETATION`,`STEREO_REMARKS`) "
        . "VALUES (?,?,?,?,?,?,?,?)";
		$arg_stereo = array(
			$vn,
			$this->input->post('date_stereo'),
			$this->input->post('stereo_dist_test'),
			$this->input->post('stereo_dist_result'),
			$this->input->post('stereo_near_test'),
			$this->input->post('stereo_near_result'),
			$this->input->post('stereoacuity'),
			$this->input->post('stereo_remarks')
		);
		$arg_stereo = $this->checknull($arg_stereo);
		if ($this->db->query($stereo, $arg_stereo)) {
			$data = $this->get_stereo($vn, $data);
			$this->load_page($vn, $data);
		}
		else{
			$this->load->view('doc_page_error.php'); 
		}
	}
	function save_strabduc($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `eye_exam_strab_duction` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

		$strabduc = "INSERT INTO `eye_exam_strab_duction` "
        . "(`VISIT_NO`,`DATE_CONSULT`,`RMR_ADDUCTION`,`RLR_ABDUCTION`,`RIR_DEPRESSION`,`RIR_ADDUCTION`,`RIR_EXCYCLO`,`RSR_UPGAZE`,`RSR_ADDUCTION`,`RSR_INCYCLO`,`RSO_INCYCLO`,`RSO_DOWNGAZE`,`RSO_ABDUCT`,`RIO_EXCYCLO`,`RIO_UPGAZE`,`RIO_ABDUCTION`,`LMR_ADDUCTION`,`LLR_ABDUCTION`,`LIR_DEPRESSION`,`LIR_ADDUCTION`,`LIR_EXCYCLO`,`LSR_UPGAZE`,`LSR_ADDUCTION`,`LSR_INCYCLO`,`LSO_INCYCLO`, `LSO_DOWNGAZE`,`LSO_ABDUCT`,`LIO_EXCYCLO`,`LIO_UPGAZE`,`LIO_ABDUCTION`) "
        . "VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$arg_strabduc = array(
			$vn,
			$this->input->post('date_strabd'),
			$this->input->post('mr_add_r'),
			$this->input->post('lr_abd_r'),
			$this->input->post('ir_dep_r'),
			$this->input->post('ir_add_r'),
			$this->input->post('ir_excyc_r'),
			$this->input->post('sr_upgaze_r'),
			$this->input->post('sr_add_r'),
			$this->input->post('sr_incyc_r'),
			$this->input->post('so_incyc_r'),
			$this->input->post('so_downgaze_r'),
			$this->input->post('so_abd_r'),
			$this->input->post('io_excyc_r'),
			$this->input->post('io_upgaze_r'),
			$this->input->post('io_abd_r'),
			$this->input->post('mr_add_l'),
			$this->input->post('lr_abd_l'),
			$this->input->post('ir_dep_l'),
			$this->input->post('ir_add_l'),
			$this->input->post('ir_excyc_l'),
			$this->input->post('sr_upgaze_l'),
			$this->input->post('sr_add_l'),
			$this->input->post('sr_incyc_l'),
			$this->input->post('so_incyc_l'),
			$this->input->post('so_downgaze_l'),
			$this->input->post('so_abd_l'),
			$this->input->post('io_excyc_l'),
			$this->input->post('io_upgaze_l'),
			$this->input->post('io_abd_l')
		);
		$arg_strabduc = $this->checknull($arg_strabduc);
		if ($this->db->query($strabduc, $arg_strabduc)) {
			$data = $this->get_strabduc($vn, $data);
			$this->load_page($vn, $data);
		}
		else{
			$this->load->view('doc_page_error.php'); 
		}
	}
	function save_strabfusamp($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `eye_exam_strab_fusional_amplitudes` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

		$strabfusamp = "INSERT INTO `eye_exam_strab_fusional_amplitudes` "
        . "(`VISIT_NO`,`DATE_CONSULT`,`DIVERGENCE_DIST_BI`,`DIVERGENCE_NEAR_BI`,`CONVERGENCE_DIST_BO`,`CONVERGENCE_NEAR_BO`,`SURSUMVERGENCE`,`DEOSURSUMVERGENCE`,`CYCLOVERGENCE_EXTORTION`,`CYCLOVERGENCE_INTORSION`) "
        . "VALUES (?,?,?,?,?,?,?,?,?,?)";
		$arg_strabfusamp = array(
			$vn,
			$this->input->post('date_strabf'),
			$this->input->post('div_dist'),
			$this->input->post('div_near'),
			$this->input->post('conv_dist'),
			$this->input->post('conv_near'),
			$this->input->post('sursumverge'),
			$this->input->post('deosursumverge'),
			$this->input->post('cyclover_ext'),
			$this->input->post('cyclover_int')
		);
		$arg_strabfusamp = $this->checknull($arg_strabfusamp);
		if ($this->db->query($strabfusamp, $arg_strabfusamp)) {
			$data = $this->get_strabfusamp($vn, $data);
			$this->load_page($vn, $data);
		}
		else{
			$this->load->view('doc_page_error.php'); 
		}
	}
	function save_strabmea($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `eye_exam_strab_measurements` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

		$strabmea = "INSERT INTO `eye_exam_strab_measurements` "
        . "(`VISIT_NO`,`DATE_CONSULT`,`1_STRAB_UP&R`,`2_STRAB_UP`,`3_STRAB_UP&L`,`4_STRAB_R`,`5_STRAB_STRAIGHT`,`6_STRAB_L`,`7_STRAB_DOWN&R`,`8_STRAB_DOWN`,`9_STRAB_DOWN&L`,`STRAB_MEAST_RIGHT_TILT`,`STRAB_MEAST_LEFT_TILT`,`STRAB_MEAST_AHP_DISTANCE`,`STRAB_MEAST_DISTANCE_PRIMARY`,`STRAB_MEAST_AHP_NEAR`,`STRAB_MEAST_NEAR_PRIMARY`,`STRAB_MEAST_NEAR_DOWNGAZE` ) "
        . "VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$arg_strabmea = array(
			$vn,
			$this->input->post('date_strabm'),
			$this->input->post('strabM1'),
			$this->input->post('strabM2'),
			$this->input->post('strabM3'),
			$this->input->post('strabM4'),
			$this->input->post('strabM5'),
			$this->input->post('strabM6'),
			$this->input->post('strabM7'),
			$this->input->post('strabM8'),
			$this->input->post('strabM9'),
			$this->input->post('Mtilt_r'),
			$this->input->post('Mtilt_l'),
			$this->input->post('strabM_ahp_dist'),
			$this->input->post('strabM_primaryDist'),
			$this->input->post('strabM_ahp_near'),
			$this->input->post('strabM_primaryNear'),
			$this->input->post('strabM_downgazeNear')
		);
		$arg_strabmea = $this->checknull($arg_strabmea);
		if ($this->db->query($strabmea, $arg_strabmea)) {
			$data = $this->get_strabmea($vn, $data);
			$this->load_page($vn, $data);
		}
		else{
			$this->load->view('doc_page_error.php'); 
		}
	}
	function save_strabver($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `eye_exam_strab_version` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

		$strabver = "INSERT INTO `eye_exam_strab_version` "
        . "(`VISIT_NO`,`DATE_CONSULT`,`1_VERSION_UP&R`,`2_VERSION_UP`,`3_VERSION_UP&L`,`4_VERSION_RIGHT`,`5_VERSION_STRAIGHT`,`6_VERSION_LEFT`,`7_VERSION_DOWN&R`,`8_VERSION_DOWN`,`9_VERSION_DOWN&L`,`STRAB_VERSION_PHOTO1`,`STRAB_VERSION_PHOTO2`,`STRAB_VERSION_PHOTO3`,`STRAB_VERSION_PHOTO4`,`STRAB_VERSION_PHOTO5`,`STRAB_VERSION_PHOTO6`,`STRAB_VERSION_PHOTO7`,`STRAB_VERSION_PHOTO8`,`STRAB_VERSION_PHOTO9`,`RIGHT_TILT_VERSION`,`LEFT_TILT_VERSION`,`NEAR_POINT_CONVERGENCE`,`PHOTO_RIGHT_TILT`,`PHOTO_LEFT_TILT`) "
        ."VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$arg_strabver = array(
			$vn,
			$this->input->post('date_strabv'),
			$this->input->post('strabV1'),
			$this->input->post('strabV2'),
			$this->input->post('strabV3'),
			$this->input->post('strabV4'),
			$this->input->post('strabV5'),
			$this->input->post('strabV6'),
			$this->input->post('strabV7'),
			$this->input->post('strabV8'),
			$this->input->post('strabV9'),
			$this->input->post('composite_img1'),
			$this->input->post('composite_img2'),
			$this->input->post('composite_img3'),
			$this->input->post('composite_img4'),
			$this->input->post('composite_img5'),
			$this->input->post('composite_img6'),
			$this->input->post('composite_img7'),
			$this->input->post('composite_img8'),
			$this->input->post('composite_img9'),
			$this->input->post('Vtilt_r'),
			$this->input->post('Vtilt_l'),
			$this->input->post('nearPOC'),
			$this->input->post('Vtilt_img_r'),
			$this->input->post('Vtilt_img_l')
		);
		$date_arr = getdate();
		$date_str = $date_arr['year']."-".$date_arr['mon']."-".$date_arr['mday'];
		for ($ctr=0;$ctr<$this->input->post('strabver_count');$ctr++) {
			$sql = "UPDATE `images` SET image_comments = '".$this->input->post('strabver_img_'.$ctr)."' , date_modif = ".$date_str."  WHERE image_id = '".$this->input->post('strabver_id_'.$ctr)."'";
			$sql = $this->db->query($sql) or die(mysql_error());			
		}
		$arg_strabver = $this->checknull($arg_strabver);
		if ($this->db->query($strabver, $arg_strabver)) {
			$data = $this->get_strabver($vn, $data);
			$this->load_page($vn, $data);
		}
		else{
			$this->load->view('doc_page_error.php'); 
		}
	}
	function save_anci_color($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `ancillary_color` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

		$anci_color = "INSERT INTO `ancillary_color` "
        . "(`VISIT_NO`,`DATE_COLOR`, `COLOR_TEST`, `COLOR_INSTITUTION`, `RIGHT_COLOR_RESULT`, `LEFT_COLOR_RESULT`, `COLOR_READER`, `COLOR_REMARK`) "
        . "VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $arg_anci_color = array(
			$vn,
			$this->input->post('date_color'),
			$this->input->post('color_test'),
			$this->input->post('colorInstitution'),
			$this->input->post('color_result_r'),
			$this->input->post('color_result_l'),
			$this->input->post('color_reader'),
			$this->input->post('color_remarks')
        );
        $arg_anci_color = $this->checknull($arg_anci_color);
        if ($this->db->query($anci_color, $arg_anci_color)) {
			$data = $this->get_anci_color($vn, $data);
			$this->load_page($vn, $data);
		}
		else{
			$this->load->view('doc_page_error.php'); 
		}
	}
	function save_anci_eog($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `ancillary_eog` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

		$anci_eog = "INSERT INTO `ancillary_eog` "
        . "(`VISIT_NO`, `DATE_EOG`, `INSTITUTION_EOG`, `RIGHT_EOG_TRACING`, `RIGHT_EOG_READING`, `LEFT_EOG_TRACING`, `LEFT_EOG_READING`, `EOG_READER`, `EOG_REMARKS`) "
        . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $arg_anci_eog = array(
			$vn,
			$this->input->post('date_eog'),
			$this->input->post('eogInstitution'),
			$this->input->post('eogTracing_r'),
			$this->input->post('eogReading_r'),
			$this->input->post('eogTracing_l'),
			$this->input->post('eogReading_l'),
			$this->input->post('eogReader'),
			$this->input->post('eogRemarks')
        );
        $date_arr = getdate();
		$date_str = $date_arr['year']."-".$date_arr['mon']."-".$date_arr['mday'];
		for ($ctr=0;$ctr<$this->input->post('eog_count');$ctr++) {
			$sql = "UPDATE `images` SET image_comments = '".$this->input->post('eog_img_'.$ctr)."' , date_modif = ".$date_str."  WHERE image_id = '".$this->input->post('eog_id_'.$ctr)."'";
			$sql = $this->db->query($sql) or die(mysql_error());			
		}
        $arg_anci_eog = $this->checknull($arg_anci_eog);
        if ($this->db->query($anci_eog, $arg_anci_eog)) {
			$data = $this->get_anci_eog($vn, $data);
			$this->load_page($vn, $data);
		}
		else{
			$this->load->view('doc_page_error.php'); 
		}
	}
	function save_anci_iop($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `ancillary_iop` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

        $anci_iop = "INSERT INTO `ancillary_iop` "
        . "(`VISIT_NO`, `DATE_IOP`, `RIGHT_PALPATION`, `RIGHT_IOP_PERKINS`, `RIGHT_IOP_ICARE`, `RIGHT_IOP_GOLDMANN`, `RIGHT_IOP_SCHIOTZ`, `RIGHT_IOP_TONOPEN`, `RIGHT_IOP_OTHERS`, `RIGHT_IOP_OTHERS_INSTRUMENT`, `LEFT_PALPATION`, `LEFT_IOP_PERKINS`, `LEFT_IOP_ICARE`, `LEFT_IOP_GOLDMANN`, `LEFT_IOP_SCHIOTZ`, `LEFT_IOP_TONOPEN`, `LEFT_IOP_OTHERS`, `LEFT_IOP_OTHERS_INSTRUMENT`, `IOP_REMARK`) "
        . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$arg_anci_iop = array(
			$vn,
			$this->input->post('date_iop'),
			$this->input->post('FingerPalp_r'),
			$this->input->post('iop_Perkins_r'),
			$this->input->post('iop_Icare_r'),
			$this->input->post('iop_Goldmann_r'),
			$this->input->post('iop_Shiotz_r'),
			$this->input->post('iop_Tonopen_r'),
			$this->input->post('iop_other_r'),
			$this->input->post('iop_otherInstrument_r'),
			$this->input->post('FingerPalp_l'),
			$this->input->post('iop_Perkins_l'),
			$this->input->post('iop_Icare_l'),
			$this->input->post('iop_Goldmann_l'),
			$this->input->post('iop_Shiotz_l'),
			$this->input->post('iop_Tonopen_l'),
			$this->input->post('iop_other_l'),
			$this->input->post('iop_otherInstrument_l'),
			$this->input->post('iop_remarks')
        );
        $arg_anci_iop = $this->checknull($arg_anci_iop);
        if ($this->db->query($anci_iop, $arg_anci_iop)) {
			$data = $this->get_anci_iop($vn, $data);
			$this->load_page($vn, $data);
		}
		else{
			$this->load->view('doc_page_error.php'); 
		}
	}
	function save_anci_octd($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `ancillary_oct_disc` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

		$anci_octd = "INSERT INTO `ancillary_oct_disc` "
        . "(`VISIT_NO`, `DATE_OCT_DISC`, `OCT_DISC_INSTITUTION`, `OCT_DISC_MACHINE`, `RIGHT_OCT_DISC_IMAGE1`, `RIGHT_OCT_DISC_IMAGE2`, `RIGHT_OCT_DISC_IMAGE3`, `RIGHT_OCT_DISC_IMAGE4`, `RIGHT_OCT_DISC_IMAGE5`, `RIGHT_OCT_DISC_READING`, `LEFT_OCT_DISC_IMAGE1`, `LEFT_OCT_DISC_IMAGE2`, `LEFT_OCT_DISC_IMAGE3`, `LEFT_OCT_DISC_IMAGE4`, `LEFT_OCT_DISC_IMAGE5`, `LEFT_OCT_DISC_READING`, `OCT_DISC_READER`, `OCT_DISC_REMARKS`) "
        . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $arg_anci_octd = array(
			$vn,
			$this->input->post('date_octd'),
			$this->input->post('octD_institution'),
			$this->input->post('octD_machine'),
			$this->input->post('octD_img1_r'),
			$this->input->post('octD_img2_r'),
			$this->input->post('octD_img3_r'),
			$this->input->post('octD_img4_r'),
			$this->input->post('octD_img5_r'),
			$this->input->post('octD_reading_r'),
			$this->input->post('octD_img1_l'),
			$this->input->post('octD_img2_l'),
			$this->input->post('octD_img3_l'),
			$this->input->post('octD_img4_l'),
			$this->input->post('octD_img5_l'),
			$this->input->post('octD_reading_l'),
			$this->input->post('octD_reader'),
			$this->input->post('octD_remarks')
        );		
        $date_arr = getdate();
		$date_str = $date_arr['year']."-".$date_arr['mon']."-".$date_arr['mday'];
		for ($ctr=0;$ctr<$this->input->post('octsdisc_count');$ctr++) {
			$sql = "UPDATE `images` SET image_comments = '".$this->input->post('octsdisc_img_'.$ctr)."' , date_modif = ".$date_str."  WHERE image_id = '".$this->input->post('octsdisc_id_'.$ctr)."'";
			$sql = $this->db->query($sql) or die(mysql_error());			
		}        
        $arg_anci_octd = $this->checknull($arg_anci_octd);
        if ($this->db->query($anci_octd, $arg_anci_octd)) {
			$data = $this->get_anci_octd($vn, $data);
			$this->load_page($vn, $data);
		}
		else{
			$this->load->view('doc_page_error.php'); 
		}
	}
	function save_anci_octm($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `ancillary_oct_macula` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

        $anci_octm = "INSERT INTO `ancillary_oct_macula` "
        . "(`VISIT_NO`, `DATE_OCT_MACULA`, `OCT_MACULA_INSTITUTION`, `OCT_MACULA_MACHINE`, `RIGHT_OCT_MACULA_IMAGE1`, `RIGHT_OCT_MACULA_IMAGE2`, `RIGHT_OCT_MACULA_IMAGE3`, `RIGHT_OCT_MACULA_IMAGE4`, `RIGHT_OCT_MACULA_IMAGE5`, `RIGHT_OCT_MACULA_READING`, `LEFT_OCT_MACULA_IMAGE1`, `LEFT_OCT_MACULA_IMAGE2`, `LEFT_OCT_MACULA_IMAGE3`, `LEFT_OCT_MACULA_IMAGE4`, `LEFT_OCT_MACULA_IMAGE5`, `LEFT_OCT_MACULA_READING`, `OCT_MACULA_READER`, `OCT_MACULA_REMARKS`) "
        . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$arg_anci_octm = array(
			$vn,
			$this->input->post('date_octm'),
			$this->input->post('octM_institution'),
			$this->input->post('octM_machine'),
			$this->input->post('octM_img1_r'),
			$this->input->post('octM_img2_r'),
			$this->input->post('octM_img3_r'),
			$this->input->post('octM_img4_r'),
			$this->input->post('octM_img5_r'),
			$this->input->post('octM_reading_r'),
			$this->input->post('octM_img1_l'),
			$this->input->post('octM_img2_l'),
			$this->input->post('octM_img3_l'),
			$this->input->post('octM_img4_l'),
			$this->input->post('octM_img5_l'),
			$this->input->post('octM_reading_l'),
			$this->input->post('octM_reader'),
			$this->input->post('octM_remarks')
        );
        $date_arr = getdate();
		$date_str = $date_arr['year']."-".$date_arr['mon']."-".$date_arr['mday'];
		for ($ctr=0;$ctr<$this->input->post('octm_count');$ctr++) {
			$sql = "UPDATE `images` SET image_comments = '".$this->input->post('octm_img_'.$ctr)."' , date_modif = ".$date_str."  WHERE image_id = '".$this->input->post('octm_id_'.$ctr)."'";
			$sql = $this->db->query($sql) or die(mysql_error());			
		}
        $arg_anci_octm = $this->checknull($arg_anci_octm);
        if ($this->db->query($anci_octm, $arg_anci_octm)) {
			$data = $this->get_anci_octm($vn, $data);
			$this->load_page($vn, $data);
		}
		else{
			$this->load->view('doc_page_error.php'); 
		}
	}
	function save_anci_octo($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `ancillary_oct_other` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

		$anci_octo = "INSERT INTO `ancillary_oct_other` "
        . "(`VISIT_NO`, `DATE_OCT_OTHER`, `OCT_OTHER_AREA_TESTED`, `OCT_OTHER_INSTITUTION`, `OCT_OTHER_MACHINE`, `RIGHT_OCT_OTHER_IMAGE1`, `RIGHT_OCT_OTHER_IMAGE2`, `RIGHT_OCT_OTHER_IMAGE3`, `RIGHT_OCT_OTHER_IMAGE4`, `RIGHT_OCT_OTHER_IMAGE5`, `RIGHT_OCT_OTHER_READING`, `LEFT_OCT_OTHER_IMAGE1`, `LEFT_OCT_OTHER_IMAGE2`, `LEFT_OCT_OTHER_IMAGE3`, `LEFT_OCT_OTHER_IMAGE4`, `LEFT_OCT_OTHER_IMAGE5`, `LEFT_OCT_OTHER_READING`, `OCT_OTHER_READER`, `OCT_OTHER_REMARKS`) "
        . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $arg_anci_octo = array(
			$vn,
			$this->input->post('date_octo'),
			$this->input->post('octOA_tested'),
			$this->input->post('octOA_institution'),
			$this->input->post('octOA_machine'),
			$this->input->post('octOA_img1_r'),
			$this->input->post('octOA_img2_r'),
			$this->input->post('octOA_img3_r'),
			$this->input->post('octOA_img4_r'),
			$this->input->post('octOA_img5_r'),
			$this->input->post('octOA_reading_r'),
			$this->input->post('octOA_img1_l'),
			$this->input->post('octOA_img2_l'),
			$this->input->post('octOA_img3_l'),
			$this->input->post('octOA_img4_l'),
			$this->input->post('octOA_img5_l'),
			$this->input->post('octOA_reading_l'),
			$this->input->post('octOA_reader'),
			$this->input->post('octOA_remarks')
        );
        $date_arr = getdate();
		$date_str = $date_arr['year']."-".$date_arr['mon']."-".$date_arr['mday'];
		for ($ctr=0;$ctr<$this->input->post('octo_count');$ctr++) {
			$sql = "UPDATE `images` SET image_comments = '".$this->input->post('octo_img_'.$ctr)."' , date_modif = ".$date_str."  WHERE image_id = '".$this->input->post('octo_id_'.$ctr)."'";
			$sql = $this->db->query($sql) or die(mysql_error());			
		}        
        $arg_anci_octo = $this->checknull($arg_anci_octo);
		if ($this->db->query($anci_octo, $arg_anci_octo)) {
			$data = $this->get_anci_octo($vn, $data);
			$this->load_page($vn, $data);
		}
		else{
			$this->load->view('doc_page_error.php'); 
		}	
	}
	function save_anci_other($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `ancillary_other` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

        $anci_other = "INSERT INTO `ancillary_other` "
        . "(`VISIT_NO`, `DATE_OTHER_TEST`, `OTHER_TEST`, `INSTITUTION_OTHER_TEST`, `OTHER_TEST_IMAGE1`, `OTHER_TEST_IMAGE2`, `OTHER_TEST_IMAGE3`, `OTHER_TEST_IMAGE4`, `OTHER_TEST_IMAGE5`, `OTHER_TEST_READING`, `OTHER_TEST_READER`, `OTHER_TEST_REMARKS`)"
        . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$arg_anci_other = array(
			$vn,
			$this->input->post('date_other'),
			$this->input->post('otherTest'),
			$this->input->post('otherInstitution'),
			$this->input->post('other_img1'),
			$this->input->post('other_img2'),
			$this->input->post('other_img3'),
			$this->input->post('other_img4'),
			$this->input->post('other_img5'),
			$this->input->post('otherReading'),
			$this->input->post('otherReader'),
			$this->input->post('other_remarks')
        );
        $date_arr = getdate();
		$date_str = $date_arr['year']."-".$date_arr['mon']."-".$date_arr['mday'];
		for ($ctr=0;$ctr<$this->input->post('other_count');$ctr++) {
			$sql = "UPDATE `images` SET image_comments = '".$this->input->post('other_img_'.$ctr)."' , date_modif = ".$date_str."  WHERE image_id = '".$this->input->post('other_id_'.$ctr)."'";
			$sql = $this->db->query($sql) or die(mysql_error());			
		}
        $arg_anci_other = $this->checknull($arg_anci_other);
        if ($this->db->query($anci_other, $arg_anci_other)) {
			$data = $this->get_anci_other($vn, $data);
			$this->load_page($vn, $data);
		}
		else{
			$this->load->view('doc_page_error.php'); 
		}
	}
	function save_anci_retina($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `ancillary_retina_image` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

		$anci_retina = "INSERT INTO `ancillary_retina_image` "
        . "(`VISIT_NO`, `DATE_RETINA_IMAGE`, `RETINA_IMAGING_USED`, `RETINA_IMAGE_INSTITUTION`, `RIGHT_FUNDUS1`, `RIGHT_FUNDUS2`, `RIGHT_FUNDUS3`, `RIGHT_FUNDUS4`, `RIGHT_FUNDUS5`, `RIGHT_FUNDUS6`, `RIGHT_FUNDUS7`, `RIGHT_FUNDUS8`, `RIGHT_FUNDUS9`, `RIGHT_RETINA_IMAGE_READING`, `LEFT_FUNDUS1`, `LEFT_FUNDUS2`, `LEFT_FUNDUS3`, `LEFT_FUNDUS4`, `LEFT_FUNDUS5`, `LEFT_FUNDUS6`, `LEFT_FUNDUS7`, `LEFT_FUNDUS8`, `LEFT_FUNDUS9`, `LEFT_RETINA_IMAGE_READING`, `RETINA_IMAGE_READER`, `RETINA_IMAGE_REMARKS`) "
        . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $arg_anci_retina = array(
			$vn,
			$this->input->post('date_retimg'),
			$this->input->post('retImg_used'),
			$this->input->post('retImg_institution'),
			$this->input->post('fundusImg1_r'),
			$this->input->post('fundusImg2_r'),
			$this->input->post('fundusImg3_r'),
			$this->input->post('fundusImg4_r'),
			$this->input->post('fundusImg5_r'),
			$this->input->post('fundusImg6_r'),
			$this->input->post('fundusImg7_r'),
			$this->input->post('fundusImg8_r'),
			$this->input->post('fundusImg9_r'),
			$this->input->post('retImg_reading_r'),
			$this->input->post('fundusImg1_l'),
			$this->input->post('fundusImg2_l'),
			$this->input->post('fundusImg3_l'),
			$this->input->post('fundusImg4_l'),
			$this->input->post('fundusImg5_l'),
			$this->input->post('fundusImg6_l'),
			$this->input->post('fundusImg7_l'),
			$this->input->post('fundusImg8_l'),
			$this->input->post('fundusImg9_l'),
			$this->input->post('retImg_reading_l'),
			$this->input->post('retImg_reader'),
			$this->input->post('retImg_remarks')
        );
        $date_arr = getdate();
		$date_str = $date_arr['year']."-".$date_arr['mon']."-".$date_arr['mday'];
		for ($ctr=0;$ctr<$this->input->post('retina_count');$ctr++) {
			$sql = "UPDATE `images` SET image_comments = '".$this->input->post('retina_img_'.$ctr)."' , date_modif = ".$date_str."  WHERE image_id = '".$this->input->post('retina_id_'.$ctr)."'";
			$sql = $this->db->query($sql) or die(mysql_error());			
		}
		$arg_anci_retina = $this->checknull($arg_anci_retina);
        if ($this->db->query($anci_retina, $arg_anci_retina)) {
			$data = $this->get_anci_retina($vn, $data);
			$this->load_page($vn, $data);
		}
		else{
			$this->load->view('doc_page_error.php'); 
		}
	}
	function save_anci_utz($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `ancillary_utz` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

        $anci_utz = "INSERT INTO `ancillary_utz` "
        . "(`VISIT_NO`,`DATE_UTZ`,`UTZ_MACHINE`,`UTZ_INSTITUTION`,`RIGHT_UTZ_IMAGE1`,`RIGHT_UTZ_IMAGE2`,`RIGHT_UTZ_IMAGE3`,`RIGHT_UTZ_READING`,`LEFT_UTZ_IMAGE1`,`LEFT_UTZ_IMAGE2`,`LEFT_UTZ_IMAGE3`,`LEFT_UTZ_READING`,`UTZ_READER`,`UTZ_REMARKS`) "
        . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,?,?,?)";
		$arg_anci_utz = array(
			$vn,
			$this->input->post('date_utz'),
			$this->input->post('utzMachine'),
			$this->input->post('utzInstitution'),
			$this->input->post('utz_img1_r'),
			$this->input->post('utz_img2_r'),
			$this->input->post('utz_img3_r'),
			$this->input->post('utzReading_r'),
			$this->input->post('utz_img1_l'),
			$this->input->post('utz_img2_l'),
			$this->input->post('utz_img3_l'),
			$this->input->post('utzReading_l'),
			$this->input->post('utzReader'),
			$this->input->post('utz_remarks')
        );
        $date_arr = getdate();
		$date_str = $date_arr['year']."-".$date_arr['mon']."-".$date_arr['mday'];
		for ($ctr=0;$ctr<$this->input->post('utz_count');$ctr++) {
			$sql = "UPDATE `images` SET image_comments = '".$this->input->post('utz_img_'.$ctr)."' , date_modif = ".$date_str."  WHERE image_id = '".$this->input->post('utz_id_'.$ctr)."'";
			$sql = $this->db->query($sql) or die(mysql_error());			
		}
        $arg_anci_utz = $this->checknull($arg_anci_utz);
        if ($this->db->query($anci_utz, $arg_anci_utz)) {
			$data = $this->get_anci_utz($vn, $data);
			$this->load_page($vn, $data);
		}
		else{
			$this->load->view('doc_page_error.php'); 
		}
	}
	function save_anci_ver($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `ancillary_ver` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

		$anci_ver = "INSERT INTO `ancillary_ver` "
        . "(`VISIT_NO`, `DATE_VER`, `INSTITUTION_VER`, `RIGHT_VER_TRACING`, `RIGHT_VER_READING`, `LEFT_VER_TRACING`, `LEFT_VER_READING`, `VER_READER`, `VER_REMARKS`)"
        . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $arg_anci_ver = array(
			$vn,
			$this->input->post('date_ver'),
			$this->input->post('verInstitution'),
			$this->input->post('verTracing_r'),
			$this->input->post('verReading_r'),
			$this->input->post('verTracing_l'),
			$this->input->post('verReading_l'),
			$this->input->post('verReader'),
			$this->input->post('ver_remarks')
        );        
        $date_arr = getdate();
		$date_str = $date_arr['year']."-".$date_arr['mon']."-".$date_arr['mday'];
		for ($ctr=0;$ctr<$this->input->post('ver_count');$ctr++) {
			$sql = "UPDATE `images` SET image_comments = '".$this->input->post('ver_img_'.$ctr)."' , date_modif = ".$date_str."  WHERE image_id = '".$this->input->post('ver_id_'.$ctr)."'";
			$sql = $this->db->query($sql) or die(mysql_error());			
		}
        $arg_anci_ver = $this->checknull($arg_anci_ver);
        if ($this->db->query($anci_ver, $arg_anci_ver)) {
			$data = $this->get_anci_ver($vn, $data);
			$this->load_page($vn, $data);
		}
		else{
			$this->load->view('doc_page_error.php'); 
		}
	}
	function save_anci_vf($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `ancillary_vf` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

        $anci_vf = "INSERT INTO `ancillary_vf` "
        . "(`VISIT_NO`, `DATE_VF`, `INSTITUTION_VF`, `VF_PROGRAM`, `RIGHT_VF_IMAGE1`, `RIGHT_VF_IMAGE2`, `RIGHT_VF_IMAGE3`, `RIGHT_VF_IMAGE4`, `RIGHT_VF_IMAGE5`, `RIGHT_VF_IMAGE6`, `RIGHT_VF_READING`, `LEFT_VF_IMAGE1`, `LEFT_VF_IMAGE2`, `LEFT_VF_IMAGE3`, `LEFT_VF_IMAGE4`, `LEFT_VF_IMAGE5`, `LEFT_VF_IMAGE6`, `LEFT_VF_READING`, `VF_READER`, `VF_REMARKS`)"
        . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$arg_anci_vf = array(
			$vn,
			$this->input->post('date_vf'),
			$this->input->post('vfInstitution'),
			$this->input->post('vfProgram'),
			$this->input->post('vf_img1_r'),
			$this->input->post('vf_img2_r'),
			$this->input->post('vf_img3_r'),
			$this->input->post('vf_img4_r'),
			$this->input->post('vf_img5_r'),
			$this->input->post('vf_img6_r'),
			$this->input->post('vfReading_r'),
			$this->input->post('vf_img1_l'),
			$this->input->post('vf_img2_l'),
			$this->input->post('vf_img3_l'),
			$this->input->post('vf_img4_l'),
			$this->input->post('vf_img5_l'),
			$this->input->post('vf_img6_l'),
			$this->input->post('vfReading_l'),
			$this->input->post('vfReader'),
			$this->input->post('vf_remarks')
        );        
        $date_arr = getdate();
		$date_str = $date_arr['year']."-".$date_arr['mon']."-".$date_arr['mday'];
		for ($ctr=0;$ctr<$this->input->post('vf_count');$ctr++) {
			$sql = "UPDATE `images` SET image_comments = '".$this->input->post('vf_img_'.$ctr)."' , date_modif = ".$date_str."  WHERE image_id = '".$this->input->post('vf_id_'.$ctr)."'";
			$sql = $this->db->query($sql) or die(mysql_error());			
		}
        $arg_anci_vf = $this->checknull($arg_anci_vf);
        if ($this->db->query($anci_vf, $arg_anci_vf)) {
			$data = $this->get_anci_vf($vn, $data);
			$this->load_page($vn, $data);
		}
		else{
			$this->load->view('doc_page_error.php'); 
		}
	}
	
	function get_va($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "SELECT * FROM `eye_exam_va` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $va) {
				$data['date_va']= $va->DATE_CONSULT;
				$data['va_NoCorrect_r'] = $va->VA_OD_SC;
				$data['va_NoCorrect_l'] = $va->VA_OS_SC;
				$data['va_NoCorrect_pin_r'] = $va ->VA_OD_SC_PH;
				$data['va_NoCorrect_pin_l']= $va -> VA_OS_SC_PH;
				$data['BestCorrect_r']=$va->VA_OD_BESTCORRECTION;
				$data['BestCorrect_l']=$va->VA_OS_BESTCORRECTION;
				$data['BestCorrect_dist_r']=$va->OD_BESTCORRECTION_DISTANCE;
				$data['BestCorrect_dist_l']=$va->OS_BESTCORRECTION_DISTANCE;
				$data['BestCorrect_near_r']=$va->OD_BESTCORRECTION_NEAR;
				$data['BestCorrect_near_l']=$va->OS_BESTCORRECTION_NEAR;
				$data['ForcedPrimary_dist']=$va->VA_OU_DISTANCE_FORCED1;
				$data['ForcedPrimary_near']=$va->VA_OU_FORCED1_NEAR;
				$data['va_downgaze']=$va->VA_OU_DOWNGAZE_NEAR;
				$data['ahp_dist']=$va->VA_OU_DISTANCE_AHP;
				$data['ahp_near']=$va->AHP_NEAR;
				$data['va_ou_ahp_near']=$va->VA_OU_AHP_NEAR;
			}
			$data['set_va'] = 1;
		}
		return $data;
	}
	function get_refrac($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "SELECT * FROM `eye_exam_refraction` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_ref']= $col->DATE_CONSULT;
				$data['DryAutoRef_r'] = $col->RIGHT_DRY_AUTOREFRACTION;
				$data['DryAutoRef_l'] = $col->LEFT_DRY_AUTOREFRACTION;
				$data['ObjRef_r'] = $col ->RIGHT_DRY_OBJ_REFRACTION;
				$data['ObjRef_l']= $col ->LEFT_DRY_OBJ_REFRACTION;
				$data['va_ObjRef_r']=$col->RIGHT_VA_OBJECTIVE;
				$data['va_ObjRef_l']=$col->LEFT_VA_OBJECTIVE;
				$data['ManRef_r']=$col->RIGHT_MANIFEST_REFRACTION;
				$data['ManRef_l']=$col->LEFT_MANIFEST_REFRACTION;
				$data['va_ManRef_r']=$col->RIGHT_VA_MANIFEST;
				$data['va_ManRef_l']=$col->LEFT_VA_MANIFEST;
				$data['CycloRef_r']=$col->RIGHT_CYCLO_REFRACTION;
				$data['CycloRef_l']=$col->LEFT_CYCLO_REFRACTION;
				$data['va_CycloRef_r']=$col->RIGHT_VA_CYCLO;
				$data['va_CycloRef_l']=$col->LEFT_VA_CYCLO;
				$data['CycloAgent_r']=$col->RIGHT_CYCLOPLEGIC;
				$data['CycloAgent_l']=$col->LEFT_CYCLOPLEGIC;
				$data['TolRef_r']=$col->RIGHT_TOLERATED_REFRACTION;
				$data['TolRef_l']=$col->LEFT_TOLERATED_REFRACTION;
				$data['va_TolRef_r']=$col->RIGHT_VA_TOLERATED;
				$data['va_TolRef_l']=$col->LEFT_VA_TOLERATED;
				$data['ref_remarks']=$col->REFRACTION_REMARKS;
			}
			$data['set_refrac'] = 1;
		}
		return $data;
	}
	function get_pupils($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "SELECT * FROM `eye_exam_pupils` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_pupil'] = $col->DATE_CONSULT;
				$data['PupilColor_r'] = $col->OD_PUPIL_COLOR;
				$data['PupilColor_l'] = $col->OS_PUPIL_COLOR;
				$data['PupilShape_r'] = $col->OD_PUPIL_SHAPE;
				$data['PupilShape_l'] = $col->OS_PUPIL_SHAPE;
				$data['PupilSize_amb_r'] = $col->OD_PUPIL_SIZE_AMBIENT;
				$data['PupilSize_amb_l'] = $col->OS_PUPIL_SIZE_AMBIENT;
				$data['LightRxn_amb_r'] = $col->OD_PUPIL_RTL_AMBIENT;
				$data['LightRxn_amb_l'] = $col->OS_PUPIL_RTL_AMBIENT;
				$data['PupilSize_dark_r'] = $col->OD_PUPIL_SIZE_DARK;
				$data['PupilSize_dark_l'] = $col->OS_PUPIL_SIZE_DARK;
				$data['LightRxn_dark_r'] = $col->OD_PUPIL_RTL_DARK;
				$data['LightRxn_dark_l'] = $col->OS_PUPIL_RTL_DARK;
				$data['relAPD_r'] = $col->OD_RAPD;
				$data['relAPD_l'] = $col->OS_RAPD;
				$data['pupil_other_r'] = $col->OD_PUPIL_OTHERS_1;
				$data['pupil_other_l'] = $col->OS_PUPIL_OTHERS_2;
			}
			$data['set_pupils'] = 1;
		}
		return $data;
	}
	function get_gross($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
			$img_arr = $this->fetch_images_today($vn);
			$img_arr_today_gross = array();
			foreach ($img_arr as $img) {
				$string = $img->image_tags; 
				$tok = strtok($string, ", ");

				while ($tok !== false) {
					if ($tok=='gross') {
						array_push($img_arr_today_gross, $img);
					}
				    $tok = strtok(", ");
				}
			}
			$data['scans_arr_gross'] = $img_arr_today_gross;
			
		$sql = "SELECT * FROM `eye_exam_gross` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_gross'] = $col->DATE_CONSULT;
				$data['eyebrows_r'] = $col->RIGHT_EYEBROW;
				$data['adnexae_r'] = $col->RIGHT_ADNEXAE;
				$data['lidFissure_r'] = $col->RIGHT_LIDFISSURE_HT;
				$data['corneaGross_r'] = $col->RIGHT_CORNEA;
				$data['scleraGross_r'] = $col->RIGHT_SCLERA;
				$data['gross_other_r'] = $col->RIGHT_OTHERS;
				$data['gross_img_r'] = $col->RIGHT_PHOTOGRAPH;
				$data['eyebrows_l'] = $col->LEFT_EYEBROW;
				$data['adnexae_l'] = $col->LEFT_ADNEXAE;
				$data['lidFissure_l'] = $col->LEFT_LIDFISSURE_HT;
				$data['corneaGross_l'] = $col->LEFT_CORNEA;
				$data['scleraGross_l'] = $col->LEFT_SCLERA;
				$data['gross_other_l'] = $col->LEFT_OTHERS;
				$data['gross_img_l'] = $col->LEFT_PHOTOGRAPH;
			}

			$data['set_gross'] = 1;
		}
		return $data;
	}
	function get_post($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "SELECT * FROM `eye_exam_posterior` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_postpole'] = $col->DATE_CONSULT;
				$data['PostPoleInstrument'] = $col->EYE_EXAM_POSTERIOR_INSTRUMENT;
				$data['zone1_optic_r'] = $col->RIGHT_Z1_OPTICNERVE;
				$data['zone1_retinal_r'] = $col->RIGHT_Z1_RETINAL_ARCADE_VESSELS;
				$data['zone1_macula_r'] = $col->RIGHT_Z1_MACULA;
				$data['zone1_vitreous_r'] = $col->RIGHT_Z1_VITREOUS;
				$data['zone2_retinal_r'] = $col->RIGHT_Z2_RETINAL_ARCADE_VESSELS;
				$data['zone2_branch_r'] = $col->RIGHT_Z2_BRANCHING;
				$data['zone2_artery_r'] = $col->RIGHT_Z2_ARTERIES;
				$data['zone2_veins_r'] = $col->RIGHT_Z2_VEINS;
				$data['zone2_vortex_r'] = $col->RIGHT_Z2_VORTEX;
				$data['zone2_vitreous_r'] = $col->RIGHT_Z2_VITREOUS;
				$data['zone3_retina_r'] = $col->RIGHT_Z3_RETINA;
				$data['zone3_vessels_r'] = $col->RIGHT_Z3_VESSELS;
				$data['zone3_vitreous_r'] = $col->RIGHT_Z3_VITREOUS;
				$data['PostPole_other_r'] = $col->RIGHT_OTHER_POSTERIOR;
				$data['zone1_optic_l'] = $col->LEFT_Z1_OPTICNERVE;
				$data['zone1_retinal_l'] = $col->LEFT_Z1_RETINAL_ARCADE_VESSELS;
				$data['zone1_macula_l'] = $col->LEFT_Z1_MACULA;
				$data['zone1_vitreous_l'] = $col->LEFT_Z1_VITREOUS;
				$data['zone2_retinal_l'] = $col->LEFT_Z2_RETINAL_ARCADE_VESSELS;
				$data['zone2_branch_l'] = $col->LEFT_Z2_BRANCHING;
				$data['zone2_artery_l'] = $col->LEFT_Z2_ARTERIES;
				$data['zone2_veins_l'] = $col->LEFT_Z2_VEINS;
				$data['zone2_vortex_l'] = $col->LEFT_Z2_VORTEX;
				$data['zone2_vitreous_l'] = $col->LEFT_Z2_VITREOUS;
				$data['zone3_retina_l'] = $col->LEFT_Z3_RETINA;
				$data['zone3_vessels_l'] = $col->LEFT_Z3_VESSELS;
				$data['zone3_vitreous_l'] = $col->LEFT_Z3_VITREOUS;
				$data['PostPole_other_l'] = $col->LEFT_OTHER_POSTERIOR;
			}
			$data['set_post'] = 1;
		}
		return $data;
	}
	function get_slitlamp($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
				$img_arr = $this->fetch_images_today($vn); 
				$img_arr_today_slitlamp = array();
				foreach ($img_arr as $img) {
					$string = $img->image_tags; 
					$tok = strtok($string, ", ");

					while ($tok !== false) {
						if ($tok=='slit_lamp') {
							array_push($img_arr_today_slitlamp, $img);
						}
					    $tok = strtok(", ");
					}
				}
				$data['scans_arr_slitlamp'] = $img_arr_today_slitlamp;
		$sql = "SELECT * FROM `eye_exam_slitlamp` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_sl'] = $col->DATE_CONSULT;
				$data['lidsUp_r'] = $col->RIGHT_LIDS_UPPER;
				$data['lidsLow_r'] = $col->RIGHT_LIDS_LOWER;
				$data['conj_palp_r'] = $col->RIGHT_CONJ_PALPEBRAL;
				$data['conj_bulb_r'] = $col->RIGHT_CONJ_BULBAR;
				$data['sl_sclera_r'] = $col->RIGHT_SCLERA_SL;
				$data['limbus_r'] = $col->RIGHT_LIMBUS_SL;
				$data['sl_cornea_r'] = $col->RIGHT_CORNEA_SL;
				$data['AnglesMesh_r'] = $col->RIGHT_ANGLES_TM;
				$data['anterior_r'] = $col->RIGHT_AC;
				$data['gonio_find_r'] = $col->RIGHT_GONIO_FINDINGS;
				$data['gonio_draw_r'] = $col->RIGHT_GONIO_DRAWING;
				$data['gonio_img_r'] = $col->RIGHT_GONIO_PHOTO;
				$data['iris_r'] = $col->RIGHT_IRIS_SL;
				$data['lens_r'] = $col->RIGHT_LENS_SL;
				$data['sl_vitreous_r'] = $col->RIGHT_VITREOUS_SL;
				$data['sl_nerve_r'] = $col->RIGHT_OPTIC_NERVE_SL;
				$data['sl_retinal_r'] = $col->RIGHT_RETINAL_ARCADE_VESSELS_SL;
				$data['sl_macula_r'] = $col->RIGHT_MACULA_SL;
				$data['sl_posterior_r'] = $col->RIGHT_POSTERIOR_OTHERS;
				$data['sl_img_r'] = $col->RIGHT_PHOTO_SL;
				$data['lidsUp_l'] = $col->LEFT_LIDS_UPPER;
				$data['lidsLow_l'] = $col->LEFT_LIDS_LOWER;
				$data['conj_palp_l'] = $col->LEFT_CONJ_PALPEBRAL;
				$data['conj_bulb_l'] = $col->LEFT_CONJ_BULBAR;
				$data['sl_sclera_l'] = $col->LEFT_SCLERA_SL;
				$data['limbus_l'] = $col->LEFT_LIMBUS_SL;
				$data['sl_cornea_l'] = $col->LEFT_CORNEA_SL;
				$data['AnglesMesh_l'] = $col->LEFT_ANGLES_TM;
				$data['anterior_l'] = $col->LEFT_AC;
				$data['gonio_find_l'] = $col->LEFT_GONIO_FINDINGS;
				$data['gonio_draw_l'] = $col->LEFT_GONIO_DRAWING;
				$data['gonio_img_l'] = $col->LEFT_GONIO_PHOTO;
				$data['iris_l'] = $col->LEFT_IRIS_SL;
				$data['lens_l'] = $col->LEFT_LENS_SL;
				$data['sl_vitreous_l'] = $col->LEFT_VITREOUS_SL;
				$data['sl_nerve_l'] = $col->LEFT_OPTIC_NERVE_SL;
				$data['sl_retinal_l'] = $col->LEFT_RETINAL_ARCADE_VESSELS_SL;
				$data['sl_macula_l'] = $col->LEFT_MACULA_SL;
				$data['sl_posterior_l'] = $col->LEFT_POSTERIOR_OTHERS;
				$data['sl_img_l'] = $col->LEFT_PHOTO_SL;
			}
			$data['set_slitlamp'] = 1;
		}
		return $data;
	}
	function get_stereo($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "SELECT * FROM `eye_exam_stereoacuity` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_stereo'] = $col->DATE_CONSULT;
				$data['stereo_dist_test'] = $col->STEREO_DIST_USED;
				$data['stereo_dist_result'] = $col->STEREO_DIST_RESULT;
				$data['stereo_near_test'] = $col->STEREO_NEAR_TEST;
				$data['stereo_near_result'] = $col->STEREO_NEAR_RESULT;
				$data['stereoacuity'] = $col->INTERPRETATION;
				$data['stereo_remarks'] = $col->STEREO_REMARKS;
			}
			$data['set_stereo'] = 1;
		}
		return $data;
	}
	function get_strabduc($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "SELECT * FROM `eye_exam_strab_duction` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_strabd'] = $col->DATE_CONSULT;
				$data['mr_add_r'] = $col->RMR_ADDUCTION;
				$data['lr_abd_r'] = $col->RLR_ABDUCTION;
				$data['ir_dep_r'] = $col->RIR_DEPRESSION;
				$data['ir_add_r'] = $col->RIR_ADDUCTION;
				$data['ir_excyc_r'] = $col->RIR_EXCYCLO;
				$data['sr_upgaze_r'] = $col->RSR_UPGAZE;
				$data['sr_add_r'] = $col->RSR_ADDUCTION;
				$data['sr_incyc_r'] = $col->RSR_INCYCLO;
				$data['so_incyc_r'] = $col->RSO_INCYCLO;
				$data['so_downgaze_r'] = $col->RSO_DOWNGAZE;
				$data['so_abd_r'] = $col->RSO_ABDUCT;
				$data['io_excyc_r'] = $col->RIO_EXCYCLO;
				$data['io_upgaze_r'] = $col->RIO_UPGAZE;
				$data['io_abd_r'] = $col->RIO_ABDUCTION;
				$data['mr_add_l'] = $col->LMR_ADDUCTION;
				$data['lr_abd_l'] = $col->LLR_ABDUCTION;
				$data['ir_dep_l'] = $col->LIR_DEPRESSION;
				$data['ir_add_l'] = $col->LIR_ADDUCTION;
				$data['ir_excyc_l'] = $col->LIR_EXCYCLO;
				$data['sr_upgaze_l'] = $col->LSR_UPGAZE;
				$data['sr_add_l'] = $col->LSR_ADDUCTION;
				$data['sr_incyc_l'] = $col->LSR_INCYCLO;
				$data['so_incyc_l'] = $col->LSO_INCYCLO;
				$data['so_downgaze_l'] = $col->LSO_DOWNGAZE;
				$data['so_abd_l'] = $col->LSO_ABDUCT;
				$data['io_excyc_l'] = $col->LIO_EXCYCLO;
				$data['io_upgaze_l'] = $col->LIO_UPGAZE;
				$data['io_abd_l'] = $col->LIO_ABDUCTION;
			}
			$data['set_strabduc'] = 1;
		}
		return $data;
	}
	function get_strabfusamp($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "SELECT * FROM `eye_exam_strab_fusional_amplitudes` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_strabf'] = $col->DATE_CONSULT;
				$data['div_dist'] = $col->DIVERGENCE_DIST_BI;
				$data['div_near'] = $col->DIVERGENCE_NEAR_BI;
				$data['conv_dist'] = $col->CONVERGENCE_DIST_BO;
				$data['conv_near'] = $col->CONVERGENCE_NEAR_BO;
				$data['sursumverge'] = $col->SURSUMVERGENCE;
				$data['deosursumverge'] = $col->DEOSURSUMVERGENCE;
				$data['cyclover_ext'] = $col->CYCLOVERGENCE_EXTORTION;
				$data['cyclover_int'] = $col->CYCLOVERGENCE_INTORSION;
				
			}
			$data['set_strabfusamp'] = 1;
		}
		return $data;
	}
	function get_strabmea($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "SELECT * FROM `eye_exam_strab_measurements` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$strabm = array ("1_STRAB_UP&R","2_STRAB_UP","3_STRAB_UP&L","4_STRAB_R","5_STRAB_STRAIGHT","6_STRAB_L","7_STRAB_DOWN&R","8_STRAB_DOWN","9_STRAB_DOWN&L");
				$data['date_strabm'] = $col->DATE_CONSULT;
				$data['strabM1'] = $col->$strabm[0];
				$data['strabM2'] = $col->$strabm[1];
				$data['strabM3'] = $col->$strabm[2];
				$data['strabM4'] = $col->$strabm[3];
				$data['strabM5'] = $col->$strabm[4];
				$data['strabM6'] = $col->$strabm[5];
				$data['strabM7'] = $col->$strabm[6];
				$data['strabM8'] = $col->$strabm[7];
				$data['strabM9'] = $col->$strabm[8];
				$data['Mtilt_r'] = $col->STRAB_MEAST_RIGHT_TILT;
				$data['Mtilt_l'] = $col->STRAB_MEAST_LEFT_TILT;
				$data['strabM_ahp_dist'] = $col->STRAB_MEAST_AHP_DISTANCE;
				$data['strabM_primaryDist'] = $col->STRAB_MEAST_DISTANCE_PRIMARY;
				$data['strabM_ahp_near'] = $col->STRAB_MEAST_AHP_NEAR;
				$data['strabM_primaryNear'] = $col->STRAB_MEAST_NEAR_PRIMARY;
				$data['strabM_downgazeNear'] = $col->STRAB_MEAST_NEAR_DOWNGAZE;
			}
			$data['set_strabmea'] = 1;
		}
		return $data;
	}

	function get_strabver($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
			$img_arr = $this->fetch_images_today($vn);
			$img_arr_today_strabver = array();
			foreach ($img_arr as $img) {
				$string = $img->image_tags; 
				$tok = strtok($string, ", ");

				while ($tok !== false) {
					if ($tok=='strab_version') {
						array_push($img_arr_today_strabver, $img);
					}
				    $tok = strtok(", ");
				}
			}
			$data['scans_arr_strabver'] = $img_arr_today_strabver;
		$sql = "SELECT * FROM `eye_exam_strab_version` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			$strabv = array ("1_VERSION_UP&R","2_VERSION_UP","3_VERSION_UP&L","4_VERSION_RIGHT","5_VERSION_STRAIGHT","6_VERSION_LEFT","7_VERSION_DOWN&R","8_VERSION_DOWN","9_VERSION_DOWN&L");
			foreach($sql->result() as $col) {
				$data['date_strabv'] = $col->DATE_CONSULT;
				$data['strabV1'] = $col->$strabv[0];
				$data['strabV2'] = $col->$strabv[1];
				$data['strabV3'] = $col->$strabv[2];
				$data['strabV4'] = $col->$strabv[3];
				$data['strabV5'] = $col->$strabv[4];
				$data['strabV6'] = $col->$strabv[5];
				$data['strabV7'] = $col->$strabv[6];
				$data['strabV8'] = $col->$strabv[7];
				$data['strabV9'] = $col->$strabv[8];
				$data['composite_img1'] = $col->STRAB_VERSION_PHOTO1;
				$data['composite_img2'] = $col->STRAB_VERSION_PHOTO2;
				$data['composite_img3'] = $col->STRAB_VERSION_PHOTO3;
				$data['composite_img4'] = $col->STRAB_VERSION_PHOTO4;
				$data['composite_img5'] = $col->STRAB_VERSION_PHOTO5;
				$data['composite_img6'] = $col->STRAB_VERSION_PHOTO6;
				$data['composite_img7'] = $col->STRAB_VERSION_PHOTO7;
				$data['composite_img8'] = $col->STRAB_VERSION_PHOTO8;
				$data['composite_img9'] = $col->STRAB_VERSION_PHOTO9;
				$data['Vtilt_r'] = $col->RIGHT_TILT_VERSION;
				$data['Vtilt_l'] = $col->LEFT_TILT_VERSION;
				$data['nearPOC'] = $col->NEAR_POINT_CONVERGENCE;
				$data['Vtilt_img_r'] = $col->PHOTO_RIGHT_TILT;
				$data['Vtilt_img_l'] = $col->PHOTO_LEFT_TILT;
			}

			$data['set_strabver'] = 1;


		}
		return $data;
	}
	function get_anci_color($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "SELECT * FROM `ancillary_color` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_color'] = $col->DATE_COLOR;
				$data['color_test'] = $col->COLOR_TEST;
				$data['colorInstitution'] = $col->COLOR_INSTITUTION;
				$data['color_result_r'] = $col->RIGHT_COLOR_RESULT;
				$data['color_result_l'] = $col->LEFT_COLOR_RESULT;
				$data['color_reader'] = $col->COLOR_READER;
				$data['color_remarks'] = $col->COLOR_REMARK;
				
			}
			$data['set_anci_color'] = 1;
		}
		return $data;
	}
	function get_anci_eog($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
			$img_arr = $this->fetch_images_today($vn); 
			$img_arr_today_eog = array();
			foreach ($img_arr as $img) {
				$string = $img->image_tags; 
				$tok = strtok($string, ", ");

				while ($tok !== false) {
					if ($tok=='neurophy_eog') {
						array_push($img_arr_today_eog, $img);
					}
				    $tok = strtok(", ");
				}
			}

			$data['scans_arr_eog'] = $img_arr_today_eog;
		$sql = "SELECT * FROM `ancillary_eog` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_eog'] = $col->DATE_EOG;
				$data['eogInstitution'] = $col->INSTITUTION_EOG;
				$data['eogTracing_r'] = $col->RIGHT_EOG_TRACING;
				$data['eogReading_r'] = $col->RIGHT_EOG_READING;
				$data['eogTracing_l'] = $col->LEFT_EOG_TRACING;
				$data['eogReading_l'] = $col->LEFT_EOG_READING;
				$data['eogReader'] = $col->EOG_READER;
				$data['eogRemarks'] = $col->EOG_REMARKS;
			}
			$data['set_anci_eog'] = 1;
		}
		return $data;
	}
	function get_anci_iop($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "SELECT * FROM `ancillary_iop` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_iop'] = $col->DATE_IOP;
				$data['FingerPalp_r'] = $col->RIGHT_PALPATION;
				$data['iop_Perkins_r'] = $col->RIGHT_IOP_PERKINS;
				$data['iop_Icare_r'] = $col->RIGHT_IOP_ICARE;
				$data['iop_Goldmann_r'] = $col->RIGHT_IOP_GOLDMANN;
				$data['iop_Shiotz_r'] = $col->RIGHT_IOP_SCHIOTZ;
				$data['iop_Tonopen_r'] = $col->RIGHT_IOP_TONOPEN;
				$data['iop_other_r'] = $col->RIGHT_IOP_OTHERS;
				$data['iop_otherInstrument_r'] = $col->RIGHT_IOP_OTHERS_INSTRUMENT;
				$data['FingerPalp_l'] = $col->LEFT_PALPATION;
				$data['iop_Perkins_l'] = $col->LEFT_IOP_PERKINS;
				$data['iop_Icare_l'] = $col->LEFT_IOP_ICARE;
				$data['iop_Goldmann_l'] = $col->LEFT_IOP_GOLDMANN;
				$data['iop_Shiotz_l'] = $col->LEFT_IOP_SCHIOTZ;
				$data['iop_Tonopen_l'] = $col->LEFT_IOP_TONOPEN;
				$data['iop_other_l'] = $col->LEFT_IOP_OTHERS;
				$data['iop_otherInstrument_l'] = $col->LEFT_IOP_OTHERS_INSTRUMENT;
				$data['iop_remarks'] = $col->IOP_REMARK;
				
			}
			$data['set_anci_iop'] = 1;
		}
		return $data;
	}
	function get_anci_octd($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
			$img_arr = $this->fetch_images_today($vn); 
			$img_arr_today_octdisc = array();
			foreach ($img_arr as $img) {
				$string = $img->image_tags; 
				$tok = strtok($string, ", ");

				while ($tok !== false) {
					if ($tok=='oct_disc') {
						array_push($img_arr_today_octdisc, $img);
					}
				    $tok = strtok(", ");
				}
			}

			$data['scans_arr_octdisc'] = $img_arr_today_octdisc;
		$sql = "SELECT * FROM `ancillary_oct_disc` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_octd'] = $col->DATE_OCT_DISC;
				$data['octD_institution'] = $col->OCT_DISC_INSTITUTION;
				$data['octD_machine'] = $col->OCT_DISC_MACHINE;
				$data['octD_img1_r'] = $col->RIGHT_OCT_DISC_IMAGE1;
				$data['octD_img2_r'] = $col->RIGHT_OCT_DISC_IMAGE2;
				$data['octD_img3_r'] = $col->RIGHT_OCT_DISC_IMAGE3;
				$data['octD_img4_r'] = $col->RIGHT_OCT_DISC_IMAGE4;
				$data['octD_img5_r'] = $col->RIGHT_OCT_DISC_IMAGE5;
				$data['octD_reading_r'] = $col->RIGHT_OCT_DISC_READING;
				$data['octD_img1_l'] = $col->LEFT_OCT_DISC_IMAGE1;
				$data['octD_img2_l'] = $col->LEFT_OCT_DISC_IMAGE2;
				$data['octD_img3_l'] = $col->LEFT_OCT_DISC_IMAGE3;
				$data['octD_img4_l'] = $col->LEFT_OCT_DISC_IMAGE4;
				$data['octD_img5_l'] = $col->LEFT_OCT_DISC_IMAGE5;
				$data['octD_reading_l'] = $col->LEFT_OCT_DISC_READING;
				$data['octD_reader'] = $col->OCT_DISC_READER;
				$data['octD_remarks'] = $col->OCT_DISC_REMARKS;
			}
			$data['set_anci_octd'] = 1;
		}
		return $data;
	}
	function get_anci_octm($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
			$img_arr = $this->fetch_images_today($vn); 
			$img_arr_today_octm = array();
			foreach ($img_arr as $img) {
				$string = $img->image_tags; 
				$tok = strtok($string, ", ");

				while ($tok !== false) {
					if ($tok=='oct_macula') {
						array_push($img_arr_today_octm, $img);
					}
				    $tok = strtok(", ");
				}
			}
			$data['scans_arr_octm'] = $img_arr_today_octm;
		$sql = "SELECT * FROM `ancillary_oct_macula` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_octm'] = $col->DATE_OCT_MACULA;
				$data['octM_institution'] = $col->OCT_MACULA_INSTITUTION;
				$data['octM_machine'] = $col->OCT_MACULA_MACHINE;
				$data['octM_img1_r'] = $col->RIGHT_OCT_MACULA_IMAGE1;
				$data['octM_img2_r'] = $col->RIGHT_OCT_MACULA_IMAGE2;
				$data['octM_img3_r'] = $col->RIGHT_OCT_MACULA_IMAGE3;
				$data['octM_img4_r'] = $col->RIGHT_OCT_MACULA_IMAGE4;
				$data['octM_img5_r'] = $col->RIGHT_OCT_MACULA_IMAGE5;
				$data['octM_reading_r'] = $col->RIGHT_OCT_MACULA_READING;
				$data['octM_img1_l'] = $col->LEFT_OCT_MACULA_IMAGE1;
				$data['octM_img2_l'] = $col->LEFT_OCT_MACULA_IMAGE2;
				$data['octM_img3_l'] = $col->LEFT_OCT_MACULA_IMAGE3;
				$data['octM_img4_l'] = $col->LEFT_OCT_MACULA_IMAGE4;
				$data['octM_img5_l'] = $col->LEFT_OCT_MACULA_IMAGE5;
				$data['octM_reading_l'] = $col->LEFT_OCT_MACULA_READING;
				$data['octM_reader'] = $col->OCT_MACULA_READER;
				$data['octM_remarks'] = $col->OCT_MACULA_REMARKS;
			}
			$data['set_anci_octm'] = 1;
		}
		return $data;
	}
	function get_anci_octo($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
			$img_arr = $this->fetch_images_today($vn); 
			$img_arr_today_octo = array();
			foreach ($img_arr as $img) {
				$string = $img->image_tags; 
				$tok = strtok($string, ", ");

				while ($tok !== false) {
					if ($tok=='oct_other') {
						array_push($img_arr_today_octo, $img);
					}
				    $tok = strtok(", ");
				}
			}

			$data['scans_arr_octo'] = $img_arr_today_octo;
		$sql = "SELECT * FROM `ancillary_oct_other` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_octo'] = $col->DATE_OCT_OTHER;
				$data['octOA_tested'] = $col->OCT_OTHER_AREA_TESTED;
				$data['octOA_institution'] = $col->OCT_OTHER_INSTITUTION;
				$data['octOA_machine'] = $col->OCT_OTHER_MACHINE;
				$data['octOA_img1_r'] = $col->RIGHT_OCT_OTHER_IMAGE1;
				$data['octOA_img2_r'] = $col->RIGHT_OCT_OTHER_IMAGE2;
				$data['octOA_img3_r'] = $col->RIGHT_OCT_OTHER_IMAGE3;
				$data['octOA_img4_r'] = $col->RIGHT_OCT_OTHER_IMAGE4;
				$data['octOA_img5_r'] = $col->RIGHT_OCT_OTHER_IMAGE5;
				$data['octOA_reading_r'] = $col->RIGHT_OCT_OTHER_READING;
				$data['octOA_img1_l'] = $col->LEFT_OCT_OTHER_IMAGE1;
				$data['octOA_img2_l'] = $col->LEFT_OCT_OTHER_IMAGE2;
				$data['octOA_img3_l'] = $col->LEFT_OCT_OTHER_IMAGE3;
				$data['octOA_img4_l'] = $col->LEFT_OCT_OTHER_IMAGE4;
				$data['octOA_img5_l'] = $col->LEFT_OCT_OTHER_IMAGE5;
				$data['octOA_reading_l'] = $col->LEFT_OCT_OTHER_READING;
				$data['octOA_reader'] = $col->OCT_OTHER_READER;
				$data['octOA_remarks'] = $col->OCT_OTHER_REMARKS;
			}
			$data['set_anci_octo'] = 1;
		}
		return $data;
	}
	function get_anci_other($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
			$img_arr = $this->fetch_images_today($vn); 
			$img_arr_today_other = array();
			foreach ($img_arr as $img) {
				$string = $img->image_tags; 
				$tok = strtok($string, ", ");

				while ($tok !== false) {
					if ($tok=='others') {
						array_push($img_arr_today_other, $img);
					}
				    $tok = strtok(", ");
				}
			}

			$data['scans_arr_other'] = $img_arr_today_other;
		$sql = "SELECT * FROM `ancillary_other` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_other'] = $col->DATE_OTHER_TEST;
				$data['otherTest'] = $col->OTHER_TEST;
				$data['otherInstitution'] = $col->INSTITUTION_OTHER_TEST;
				$data['other_img1'] = $col->OTHER_TEST_IMAGE1;
				$data['other_img2'] = $col->OTHER_TEST_IMAGE2;
				$data['other_img3'] = $col->OTHER_TEST_IMAGE3;
				$data['other_img4'] = $col->OTHER_TEST_IMAGE4;
				$data['other_img5'] = $col->OTHER_TEST_IMAGE5;
				$data['otherReading'] = $col->OTHER_TEST_READING;
				$data['otherReader'] = $col->OTHER_TEST_READER;
				$data['other_remarks'] = $col->OTHER_TEST_REMARKS;
			}
			$data['set_anci_other'] = 1;
		}
		return $data;
	}
	function get_anci_retina($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
			$img_arr = $this->fetch_images_today($vn); 
			$img_arr_today_retina = array();
			foreach ($img_arr as $img) {
				$string = $img->image_tags; 
				$tok = strtok($string, ", ");

				while ($tok !== false) {
					if ($tok=='ret_img') {
						array_push($img_arr_today_retina, $img);
					}
				    $tok = strtok(", ");
				}
			}

			$data['scans_arr_retina'] = $img_arr_today_retina;
		$sql = "SELECT * FROM `ancillary_retina_image` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_retimg'] = $col->DATE_RETINA_IMAGE;
				$data['retImg_used'] = $col->RETINA_IMAGING_USED;
				$data['retImg_institution'] = $col->RETINA_IMAGE_INSTITUTION;
				$data['fundusImg1_r'] = $col->RIGHT_FUNDUS1;
				$data['fundusImg2_r'] = $col->RIGHT_FUNDUS2;
				$data['fundusImg3_r'] = $col->RIGHT_FUNDUS3;
				$data['fundusImg4_r'] = $col->RIGHT_FUNDUS4;
				$data['fundusImg5_r'] = $col->RIGHT_FUNDUS5;
				$data['fundusImg6_r'] = $col->RIGHT_FUNDUS6;
				$data['fundusImg7_r'] = $col->RIGHT_FUNDUS7;
				$data['fundusImg8_r'] = $col->RIGHT_FUNDUS8;
				$data['fundusImg9_r'] = $col->RIGHT_FUNDUS9;
				$data['retImg_reading_r'] = $col->RIGHT_RETINA_IMAGE_READING;
				$data['fundusImg1_l'] = $col->LEFT_FUNDUS1;
				$data['fundusImg2_l'] = $col->LEFT_FUNDUS2;
				$data['fundusImg3_l'] = $col->LEFT_FUNDUS3;
				$data['fundusImg4_l'] = $col->LEFT_FUNDUS4;
				$data['fundusImg5_l'] = $col->LEFT_FUNDUS5;
				$data['fundusImg6_l'] = $col->LEFT_FUNDUS6;
				$data['fundusImg7_l'] = $col->LEFT_FUNDUS7;
				$data['fundusImg8_l'] = $col->LEFT_FUNDUS8;
				$data['fundusImg9_l'] = $col->LEFT_FUNDUS9;
				$data['retImg_reading_l'] = $col->LEFT_RETINA_IMAGE_READING;
				$data['retImg_reader'] = $col->RETINA_IMAGE_READER;
				$data['retImg_remarks'] = $col->RETINA_IMAGE_REMARKS;
			}
			$data['set_anci_retina'] = 1;
		}
		return $data;
	}
	function get_anci_utz($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
			$img_arr = $this->fetch_images_today($vn); 
			$img_arr_today_utz = array();
			foreach ($img_arr as $img) {
				$string = $img->image_tags; 
				$tok = strtok($string, ", ");

				while ($tok !== false) {
					if ($tok=='utz') {
						array_push($img_arr_today_utz, $img);
					}
				    $tok = strtok(", ");
				}
			}

			$data['scans_arr_utz'] = $img_arr_today_utz;
		$sql = "SELECT * FROM `ancillary_utz` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_utz'] = $col->DATE_UTZ;
				$data['utzMachine'] = $col->UTZ_MACHINE;
				$data['utzInstitution'] = $col->UTZ_INSTITUTION;
				$data['utz_img1_r'] = $col->RIGHT_UTZ_IMAGE1;
				$data['utz_img2_r'] = $col->RIGHT_UTZ_IMAGE2;
				$data['utz_img3_r'] = $col->RIGHT_UTZ_IMAGE3;
				$data['utzReading_r'] = $col->RIGHT_UTZ_READING;
				$data['utz_img1_l'] = $col->LEFT_UTZ_IMAGE1;
				$data['utz_img2_l'] = $col->LEFT_UTZ_IMAGE2;
				$data['utz_img3_l'] = $col->LEFT_UTZ_IMAGE3;
				$data['utzReading_l'] = $col->LEFT_UTZ_READING;
				$data['utzReader'] = $col->UTZ_READER;
				$data['utz_remarks'] = $col->UTZ_REMARKS;
			}
			$data['set_anci_utz'] = 1;
		}
		return $data;
	}
	function get_anci_ver($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
			$img_arr = $this->fetch_images_today($vn); 
			$img_arr_today_ver = array();
			foreach ($img_arr as $img) {
				$string = $img->image_tags; 
				$tok = strtok($string, ", ");

				while ($tok !== false) {
					if ($tok=='neurophy_ver') {
						array_push($img_arr_today_ver, $img);
					}
				    $tok = strtok(", ");
				}
			}

			$data['scans_arr_ver'] = $img_arr_today_ver;
		$sql = "SELECT * FROM `ancillary_ver` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_ver'] = $col->DATE_VER;
				$data['verInstitution'] = $col->INSTITUTION_VER;
				$data['verTracing_r'] = $col->RIGHT_VER_TRACING;
				$data['verReading_r'] = $col->RIGHT_VER_READING;
				$data['verTracing_l'] = $col->LEFT_VER_TRACING;
				$data['verReading_l'] = $col->LEFT_VER_READING;
				$data['verReader'] = $col->VER_READER;
				$data['ver_remarks'] = $col->VER_REMARKS;
			}
			$data['set_anci_ver'] = 1;
		}
		return $data;
	}
	function get_anci_vf($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
			$img_arr = $this->fetch_images_today($vn); 
			$img_arr_today_vf = array();
			foreach ($img_arr as $img) {
				$string = $img->image_tags; 
				$tok = strtok($string, ", ");

				while ($tok !== false) {
					if ($tok=='visual_field') {
						array_push($img_arr_today_vf, $img);
					}
				    $tok = strtok(", ");
				}
			}

			$data['scans_arr_vf'] = $img_arr_today_vf;
		$sql = "SELECT * FROM `ancillary_vf` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_vf'] = $col->DATE_VF;
				$data['vfInstitution'] = $col->INSTITUTION_VF;
				$data['vfProgram'] = $col->VF_PROGRAM;
				$data['vf_img1_r'] = $col->RIGHT_VF_IMAGE1;
				$data['vf_img2_r'] = $col->RIGHT_VF_IMAGE2;
				$data['vf_img3_r'] = $col->RIGHT_VF_IMAGE3;
				$data['vf_img4_r'] = $col->RIGHT_VF_IMAGE4;
				$data['vf_img5_r'] = $col->RIGHT_VF_IMAGE5;
				$data['vf_img6_r'] = $col->RIGHT_VF_IMAGE6;
				$data['vfReading_r'] = $col->RIGHT_VF_READING;
				$data['vf_img1_l'] = $col->LEFT_VF_IMAGE1;
				$data['vf_img2_l'] = $col->LEFT_VF_IMAGE2;
				$data['vf_img3_l'] = $col->LEFT_VF_IMAGE3;
				$data['vf_img4_l'] = $col->LEFT_VF_IMAGE4;
				$data['vf_img5_l'] = $col->LEFT_VF_IMAGE5;
				$data['vf_img6_l'] = $col->LEFT_VF_IMAGE6;
				$data['vfReading_l'] = $col->LEFT_VF_READING;
				$data['vfReader'] = $col->VF_READER;
				$data['vf_remarks'] = $col->VF_REMARKS;
			}
			$data['set_anci_vf'] = 1;
		}
		return $data;
	}
	
	
	function save_diagnosis($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `diagnosis` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

		$diag = $_POST["diagnosis"];
		$icd10 = $_POST["diagnosis_icd10"];
		$remarks = $_POST["diagnosis_remarks"];
		for($idx = 0; $idx < count($diag); $idx++){
			$diagnosis = "INSERT INTO `diagnosis` "
            . "(`VISIT_NO`,`DATE_DIAGNOSIS`,`DIAGNOSIS`, `ICD10_DIAGNOSIS`, `DIAGNOSIS_REMARKS`)"
            . "VALUES (?, ?, ?, ?, ?)";
			$arg_diagnosis = array(
				$vn,
				$this->input->post('date_diagnosis'),
				$diag[$idx],
				$icd10[$idx],
				$remarks[$idx]
			);
			$arg_diagnosis = $this->checknull($arg_diagnosis);
			if (!$this->db->query($diagnosis, $arg_diagnosis)) {
				$this->load->view('doc_page_error.php');	
			}
		}
		$data = $this->get_diagnosis($vn, $data);
		$this->load_page($vn,$data);
	}
	function save_rec_eyeg($vn, $data){	//EDITED
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `recommendation_eyeglass` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		$eyeArgs = array(
			'visit_no' => $vn,
			'date_rx_recommendation' => $this->input->post('date_eyeg'),
			'od_sphere' => $this->input->post('eyeG_sphere_r'),
			'od_cylinder' => $this->input->post('eyeG_cyl_r'),
			'od_axis' => $this->input->post('eyeG_axis_r'),
			'od_prism' => $this->input->post('eyeG_prism_r'),
			'od_basein' => $this->input->post('eyeG_base_r'),
			'od_adds' => $this->input->post('eyeG_adds_r'),
			'od_distancePD' => $this->input->post('eyeG_distPD_r'),
			'od_nearPD' => $this->input->post('eyeG_nearPD_r'),
			'os_sphere' => $this->input->post('eyeG_sphere_l'),
			'os_cylinder' => $this->input->post('eyeG_cyl_l'),
			'os_axis' => $this->input->post('eyeG_axis_l'),
			'os_prism' => $this->input->post('eyeG_prism_l'),
			'os_basein' => $this->input->post('eyeG_base_l'),
			'os_adds' => $this->input->post('eyeG_adds_l'),
			'os_distancePD' => $this->input->post('eyeG_distPD_l'),
			'os_nearPD' => $this->input->post('eyeG_nearPD_l'),
			'remarks' => $this->input->post('eyeG_remarks')
		);
		$eyeArgs = $this->checknull($eyeArgs);
		if ($this->db->insert('recommendation_eyeglass', $eyeArgs)) {
		$data = $this->get_rec_eyeg($vn, $data);
		$this->load_page($vn,$data);
		}
		else{
		$this->load->view('doc_page_error.php');
		}
	}
	function save_rec_fu($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `recommendation_followup` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

		$rec_fu = "INSERT INTO `recommendation_followup`"
        ."(`VISIT_NO`, `FOLLOWUP_RECOMMENDATION`, `FOLLOWUP_SCHED`, `APPTMENT_BY`, `DATE_APPTMENT_MADE`, `APPTMENT_STAFF`, `FOLLOWUP_REMARKS`)"
        ."VALUES (?, ?, ?, ?, ?, ?, ?)";
        $arg_rec_fu = array(
			$vn,
			$this->input->post('fu_rec'), //followup recommendation
			$this->input->post('fu_sched'),
			$this->input->post('fu_apptMadeBy'),
			$this->input->post('fu_apptMadeDate'),
			$this->input->post('fu_apptStaff'),
			$this->input->post('fu_remarks'),
        );
        $arg_rec_fu = $this->checknull($arg_rec_fu);
		if ($this->db->query($rec_fu, $arg_rec_fu)) {
			$data = $this->get_rec_fu($vn, $data);
			$this->load_page($vn,$data);
		}
		else{
			$this->load->view('doc_page_error.php');
		}
	}
	function save_rec_med($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `recommendation_medication` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

		$gen = $_POST["med_gen"];
		$prep = $_POST["med_prep"];
		$brand = $_POST["med_brand"];
		$freq = $_POST["med_freq"];
		$dura = $_POST["med_dura"];
		$sig = $_POST["med_sig"];
		for($idx = 0; $idx < count($gen); $idx++){
			$rec_med = "INSERT INTO `recommendation_medication`"
			."(`VISIT_NO`, `DATE_MED_RECOMMENDED`, `MED_GENERIC`, `MED_PREP`, `MED_BRAND`, `MED_FREQUENCY`, `MED_DURATION`, `MED_REMARK`,`MED_SIG`)"
			." VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$arg_rec_med = array(
				$vn,
				$this->input->post('date_rec_med'),
				$gen[$idx],
				$prep[$idx],
				$brand[$idx],
				$freq[$idx],
				$dura[$idx],
				$this->input->post('med_remarks'),
				$sig[$idx]
			);
			$arg_rec_med = $this->checknull($arg_rec_med);
			if(!$this->db->query($rec_med, $arg_rec_med)){
				$this->load->view('doc_page_error.php');
			}
		}
		$data = $this->get_rec_med($vn, $data);
		$this->load_page($vn,$data);
	}
	function save_rec_surgery($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "DELETE FROM `recommendation_surgery` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());

		$rec_surgery = "INSERT INTO `recommendation_surgery`"
        ."(`VISIT_NO`, `DATE_SURGERY_RECOMMENDED`, `RECOMMENDED_SURGERY`, `RVS_CODE`, `DATE_SURGERY_SCHED`, `PLACE_SURGERY_SCHED`, `DATE_SURGERY_DONE`, `SURGERY_REMARKS`,`CLEARANCE_MD`,`CLEARANCE_SENT`,`CLEARANCE_CLEARED`,`ANAESTHESIOLOGIST`, `ANAESTHESIA`, `DATE_ANAESTHESIOLOGIST_INFORMED`,`ANAESTHESIOLOGIST_INFORMANT`)"
        ."VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $arg_rec_surgery = array(
			$vn,
			$this->input->post('date_surgery'),
			$this->input->post('surgeRecommend'),
			$this->input->post('surgeCode'),
			$this->input->post('surgeDateSched'),
			$this->input->post('surgePlace'),
			$this->input->post('surgeDateDone'),
			$this->input->post('surge_remarks'),
			$this->input->post('clearance_md'),
			$this->input->post('clearance_sent'),
			$this->input->post('clearance_cleared'),
			$this->input->post('anaesName'),
			$this->input->post('anaes'),
			$this->input->post('anaesDate'),
			$this->input->post('anaesInform')
        );
        $arg_rec_surgery = $this->checknull($arg_rec_surgery);
		if ($this->db->query($rec_surgery, $arg_rec_surgery)) {
			$data = $this->get_rec_surgery($vn, $data);
			$this->load_page($vn,$data);
		}
		else{
			$this->load->view('doc_page_error.php');
		}
	}
	
	function get_diagnosis($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "SELECT * FROM `diagnosis` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_diagnosis']= $col->DATE_DIAGNOSIS;
			}
			$data['set_diagnosis'] = 1;
		}
		return $data;
	}
	function get_rec_eyeg($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "SELECT * FROM `recommendation_eyeglass` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_eyeg'] = $col->date_rx_recommendation;
				$data['eyeG_sphere_r'] = $col->od_sphere;
				$data['eyeG_cyl_r'] = $col->od_cylinder;
				$data['eyeG_axis_r'] = $col->od_axis;
				$data['eyeG_prism_r'] = $col->od_prism;
				$data['eyeG_base_r'] = $col->od_basein;
				$data['eyeG_adds_r'] = $col->od_adds;
				$data['eyeG_distPD_r'] = $col->od_distancePD;
				$data['eyeG_nearPD_r'] = $col->od_nearPD;
				$data['eyeG_sphere_l'] = $col->os_sphere;
				$data['eyeG_cyl_l'] = $col->os_cylinder;
				$data['eyeG_axis_l'] = $col->os_axis;
				$data['eyeG_prism_l'] = $col->os_prism;
				$data['eyeG_base_l'] = $col->os_basein;
				$data['eyeG_adds_l'] = $col->os_adds;
				$data['eyeG_distPD_l'] = $col->os_distancePD;
				$data['eyeG_nearPD_l'] = $col->os_nearPD;
				$data['eyeG_remarks'] = $col->remarks;
			}
			$data['set_rec_eyeg'] = 1;
		}
		return $data;
	}
	function get_rec_fu($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "SELECT * FROM `recommendation_followup` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['fu_rec']= $col->FOLLOWUP_RECOMMENDATION; //???
				$data['fu_sched'] = $col->FOLLOWUP_SCHED;
				$data['fu_apptMadeBy'] = $col->APPTMENT_BY;
				$data['fu_apptMadeDate'] = $col ->DATE_APPTMENT_MADE;
				$data['fu_apptStaff']= $col->APPTMENT_STAFF;
				$data['fu_remarks'] = $col->FOLLOWUP_REMARKS;
			}
			$data['set_rec_fu'] = 1;
		}
		return $data;
	}
	function get_rec_med($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "SELECT * FROM `recommendation_medication` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_rec_med']= $col->DATE_MED_RECOMMENDED;
				$data['med_remarks']= $col->MED_REMARK; 
			}
			$data['set_rec_med'] = 1;
		}
		return $data;
	}
	function get_rec_surgery($vn, $data){
		if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('footer.php');
				$this->load->view('access_denied.php');
				return;
			}
		$sql = "SELECT * FROM `recommendation_surgery` WHERE `VISIT_NO` = '$vn'";
		$sql = $this->db->query($sql) or die(mysql_error());
		if($sql->num_rows() > 0) {
			foreach($sql->result() as $col) {
				$data['date_surgery']= $col->DATE_SURGERY_RECOMMENDED;
				$data['surgeRecommend'] = $col->RECOMMENDED_SURGERY;
				$data['surgeCode'] = $col->RVS_CODE;
				$data['surgeDateSched'] = $col ->DATE_SURGERY_SCHED;
				$data['surgePlace']= $col->PLACE_SURGERY_SCHED;
				$data['surgeDateDone'] = $col->DATE_SURGERY_DONE;
				$data['anaesName'] = $col->ANAESTHESIOLOGIST;
				$data['anaes'] = $col->ANAESTHESIA;
				$data['anaesDate'] = $col->DATE_ANAESTHESIOLOGIST_INFORMED;
				$data['anaesInform'] = $col->ANAESTHESIOLOGIST_INFORMANT;
				$data['surge_remarks'] = $col->SURGERY_REMARKS;
				$data['clearance_md'] = $col->CLEARANCE_MD;
				$data['clearance_sent'] = $col->CLEARANCE_SENT;
				$data['clearance_cleared'] = $col->CLEARANCE_CLEARED;
			}
			$data['set_rec_surgery'] = 1;
		}
		return $data;
	}
	

	function load_page($vn,$data){	
		require_once "assets/classes/Patient.php";
		require_once "assets/classes/Appointment.php";
		$query = sprintf(
			"SELECT `%s`, `%s`, `%s`, `%s`, `%s`" .
			"FROM `%s`, `%s`" .
			"WHERE `%s` = %s AND `%s`.`%s` = `%s`.`%s`",
			Patient::FIRST_NAME, Patient::LAST_NAME, Patient::MIDDLE_NAME, Patient::BIRTHDAY, Patient::SEX,
			Patient::TABLE_NAME, Appointment::TABLE_NAME,
			Appointment::VISIT_NUMBER, $vn, 
			Patient::TABLE_NAME, Patient::TRUE_ID, Appointment::TABLE_NAME, Appointment::TRUE_ID
		);
		if(isset($data['editme'])){
			$data['readonly'] = '';
			$data['alert'] = 0;			
		}
		$row = $this->db->query($query)->row();
		$data["name"] = Patient::getFullName($row->{Patient::LAST_NAME}, $row->{Patient::FIRST_NAME}, $row->{Patient::MIDDLE_NAME});
		$data['sex'] = ($row->{Patient::SEX} == 1? 'Male': 'Female');
		$data['bday'] = $row->{Patient::BIRTHDAY};
		$data['age'] = Patient::getAge($row->{Patient::BIRTHDAY});
		$data = $this->get_va($vn, $data);
		$data = $this->get_refrac($vn, $data);
		$data = $this->get_pupils($vn, $data);
		$data = $this->get_gross($vn, $data);
		$data = $this->get_post($vn, $data);
		$data = $this->get_slitlamp($vn, $data);
		$data = $this->get_stereo($vn, $data);
		$data = $this->get_strabduc($vn, $data);
		$data = $this->get_strabfusamp($vn, $data);
		$data = $this->get_strabmea($vn, $data);
		$data = $this->get_strabver($vn, $data);
		$data = $this->get_anci_color($vn, $data);
		$data = $this->get_anci_eog($vn, $data);
		$data = $this->get_anci_iop($vn, $data);
		$data = $this->get_anci_octd($vn, $data);
		$data = $this->get_anci_octm($vn, $data);
		$data = $this->get_anci_octo($vn, $data);
		$data = $this->get_anci_other($vn, $data);
		$data = $this->get_anci_retina($vn, $data);
		$data = $this->get_anci_utz($vn, $data);
		$data = $this->get_anci_ver($vn, $data);
		$data = $this->get_anci_vf($vn, $data);
		$data = $this->get_diagnosis($vn, $data);
		$data = $this->get_rec_eyeg($vn, $data);
		$data = $this->get_rec_fu($vn, $data);
		$data = $this->get_rec_med($vn, $data);
		$data = $this->get_rec_surgery($vn, $data);		

		$this->load->view('doc_page.php', $data);
	}
	
	public function index($visit_no){
		$this->session->set_userdata("visit", $visit_no);

		if(! $this->session->userdata("logged_in")){
		redirect(base_url() . "main/");
		}
	
		if($visit_no == -1)
		{
			if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('access_denied.php');
				$this->load->view('footer.php');
				return;
			}
			else
			{
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('empty_patient.php');
				$this->load->view('footer.php');
				
			}	
		} 
		
		else{
			if(!$this->session->userdata("acsDP")){
				$this->load->view('header.php');
				$this->load->view('navbar.php');
				$this->load->view('home_sidebar.php');
				$this->load->view('access_denied.php');
				$this->load->view('footer.php');
				return;
			}
			$this->load->view('header.php');
			$this->load->view('navbar.php');
			$this->load->view('doc_sidebar');
			$this->load->view('footer.php');
			
			// Default set values 
			$data['vn'] = $visit_no;
			$data['visit_num'] = $visit_no;
			$data['set_va'] = null;
			$data['set_refrac'] = null;
			$data["set_pupils"] = null;
			$data["set_gross"] = null;
			$data["set_post"] = null;
			$data["set_slitlamp"] = null;
			$data["set_stereo"] = null;
			$data["set_strabduc"] = null;
			$data["set_strabfusamp"] = null;
			$data["set_strabmea"] = null;
			$data["set_strabver"] = null;
			$data["set_anci_color"] = null;
			$data["set_anci_eog"] = null;
			$data["set_anci_iop"] = null;
			$data["set_anci_octd"] = null;
			$data["set_anci_octm"] = null;
			$data["set_anci_octo"] = null;
			$data["set_anci_other"] = null;
			$data["set_anci_retina"] = null;
			$data["set_anci_utz"] = null;
			$data["set_anci_ver"] = null;
			$data["set_anci_vf"] = null;
			$data["set_diagnosis"] = null;
			$data["set_rec_eyeg"] = null;
			$data["set_rec_fu"] = null;
			$data["set_rec_med"] = null;
			$data["set_rec_surgery"] = null;
			$data['editme'] = null;
			$data["readonly"] = " readonly";
			$data["alert"] = 1;
			($this->session->userdata("acsUse"))? $data['hasPermission'] = true : $data['hasPermission'] = false;
			
			$patient = null;
			$sql = "SELECT * FROM `eye_exam_va` WHERE `VISIT_NO` = '$visit_no'";
			
			if ($this->input->post('save_va') != false){
				$this->save_va($visit_no, $data);
			}
			else if ($this->input->post('save_refrac') != false){
				$this->save_refrac($visit_no, $data);
			}
			else if ($this->input->post('save_pupils') != false){
				$this->save_pupils($visit_no, $data);
			}
			else if ($this->input->post('save_gross') != false){
				$this->save_gross($visit_no, $data);
			}
			else if ($this->input->post('save_post') != false){
				$this->save_post($visit_no, $data);
			}
			else if ($this->input->post('save_slitlamp') != false){
				$this->save_slitlamp($visit_no, $data);
			}
			else if ($this->input->post('save_stereo') != false){
				$this->save_stereo($visit_no, $data);
			}
			else if ($this->input->post('save_strabduc') != false){
				$this->save_strabduc($visit_no, $data);
			}
			else if ($this->input->post('save_strabfusamp') != false){
				$this->save_strabfusamp($visit_no, $data);
			}
			else if ($this->input->post('save_strabmea') != false){
				$this->save_strabmea($visit_no, $data);
			}
			else if ($this->input->post('save_strabver') != false){
				$this->save_strabver($visit_no, $data);
			}
			else if ($this->input->post('save_anci_color') != false){
				$this->save_anci_color($visit_no, $data);
			}
			else if ($this->input->post('save_anci_eog') != false){
				$this->save_anci_eog($visit_no, $data);
			}
			else if ($this->input->post('save_anci_iop') != false){
				$this->save_anci_iop($visit_no, $data);
			}
			else if ($this->input->post('save_anci_octd') != false){
				$this->save_anci_octd($visit_no, $data);
			}
			else if ($this->input->post('save_anci_octm') != false){
				$this->save_anci_octm($visit_no, $data);
			}
			else if ($this->input->post('save_anci_octo') != false){
				$this->save_anci_octo($visit_no, $data);
			}
			else if ($this->input->post('save_anci_other') != false){
				$this->save_anci_other($visit_no, $data);
			}
			else if ($this->input->post('save_anci_retina') != false){
				$this->save_anci_retina($visit_no, $data);
			}
			else if ($this->input->post('save_anci_utz') != false){
				$this->save_anci_utz($visit_no, $data);
			}
			else if ($this->input->post('save_anci_ver') != false){
				$this->save_anci_ver($visit_no, $data);
			}
			else if ($this->input->post('save_anci_vf') != false){
				$this->save_anci_vf($visit_no, $data);
			}		
			else if ($this->input->post('save_diagnosis') != false){
				$this->save_diagnosis($visit_no, $data);
			}
			else if ($this->input->post('save_rec_eyeg') != false){
				$this->save_rec_eyeg($visit_no, $data);
			}
			else if ($this->input->post('save_rec_fu') != false){
				$this->save_rec_fu($visit_no, $data);
			}
			else if ($this->input->post('save_rec_med') != false){
				$this->save_rec_med($visit_no, $data);
			}
			else if ($this->input->post('save_rec_surgery') != false){
				$this->save_rec_surgery($visit_no, $data);
			}
			else if ($this->input->post('print_me') != false){
	 			$this->print_me();
			}
			//edit buttons
			else if ($this->input->post('edit_va') != false){
				$data['editme'] = 'va';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_refrac') != false){
				$data['editme'] = 'refrac';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_pupils') != false){
				$data['editme'] = 'pupils';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_gross') != false){
				$data['editme'] = 'gross';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_post') != false){
				$data['editme'] = 'post';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_slitlamp') != false){
				$data['editme'] = 'slitlamp';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_stereo') != false){
				$data['editme'] = 'stereo';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_strabduc') != false){
				$data['editme'] = 'strabd';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_strabfusamp') != false){
				$data['editme'] = 'strabf';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_strabmea') != false){	 
				$data['editme'] = 'strabm';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_strabver') != false){	 
				$data['editme'] = 'strabv';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_anci_color') != false){	 
				$data['editme'] = 'color';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_anci_eog') != false){	 
				$data['editme'] = 'eog';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_anci_iop') != false){	 
				$data['editme'] = 'iop';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_anci_octd') != false){	 
				$data['editme'] = 'octd';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_anci_octm') != false){	 
				$data['editme'] = 'octm';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_anci_octo') != false){	 
				$data['editme'] = 'octo';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_anci_other') != false){	 
				$data['editme'] = 'other';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_anci_retina') != false){	 
				$data['editme'] = 'retina';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_anci_utz') != false){	 
				$data['editme'] = 'utz';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_anci_ver') != false){	 
				$data['editme'] = 'ver';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_anci_vf') != false){	 
				$data['editme'] = 'vf';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_diagnosis') != false){	 
				$data['editme'] = 'diagnosis';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_rec_eyeg') != false){	 
				$data['editme'] = 'eyeg';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_rec_fu') != false){	 
				$data['editme'] = 'fu';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_rec_med') != false){	
				$data['editme'] = 'med';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('edit_rec_surgery') != false){	
				$data['editme'] = 'surgery';
	 			$this->load_page($visit_no,$data);
			}else if ($this->input->post('searchICD') != false){
				$this->searchICD();
			}
			else{
				$data["alert"] = null;
				$this->load_page($visit_no,$data);
			}
		}
	}	
}