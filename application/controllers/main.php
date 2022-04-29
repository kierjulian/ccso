<?php 

class Main extends CI_Controller {
    
     function __construct() 
     {
        parent::__construct();
        $this->clear_cache();
		$this->load->library('form_validation');
		$this->load->library('session');
     }
    
      

    public function index() {
        //Begins the code
        
		$this->session->set_userdata("logged_in", false);
        $rules = array(
            "tf_account" => array("field" => "tf_account",
                "label" => "Username or Email",
                "rules" => "required|trim|callback_account_exist"
            ),
            "tf_password" => array("field" => "tf_password",
                "label" => "Password",
                "rules" => "required"
            )
        );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() != true) {
            //Load Login Page
            $this->load->view('header.php');
			$this->load->view('login.php');
			$this->load->view('footer.php');
            $this->unset_ordering_vars();
            $this->unset_outproc_vars();
        } 
        else 
        {
            $input = $this->input->post("tf_account"); //Forms Text Field Account.
            $password = $this->input->post("tf_password"); //Forms Text Field Password.
        
            $sql = "SELECT * FROM `doctors_list`
			WHERE `uName` = '" . mysql_real_escape_string(addslashes(strip_tags($input))) . "'";
            $sql = $this->db->query($sql) or die(mysql_error());

            if ($sql->num_rows() > 0) {
                foreach ($sql->result() as $data) 
                {
					$db_id = $data->idDoc;
                    $db_password = $data->pWord;
                    $db_username = $data->uName;
					$db_position = $data->position;
                }
				
                $password = md5($password);
                if ($password == $db_password)
                {
                    $this->session->set_userdata("logged_in", true);
					$this->session->set_userdata("id", $db_id);
                    $this->session->set_userdata("username", $db_username);
					
					$query = "SELECT * FROM job_module, user_job WHERE job_module.job_id = user_job.job_id AND idDoc=" . $db_id;
					$moduleSQL = $this->db->query($query);
					
					$acsUse = false;
					$acsAdm = false;
					$acsDP = false;
					$acsCO = false;
					$acsBil = false;
					$acsDis = false;
					
					foreach($moduleSQL->result() as $data)
                    {
						if($data->job_id == 1){
							$acsUse = true;
						}
						if($data->acsAdm == 1){
							$acsAdm = true;
						}
						if($data->acsDP == 1){
							$acsDP = true;
						}
						if($data->acsCO == 1){
							$acsCO = true;
						}
						if($data->acsBil == 1){
							$acsBil = true;
						}
						if($data->acsDis == 1){
							$acsDis = true;
						}
					}
					
					$this->session->set_userdata("acsUse", $acsUse);
					$this->session->set_userdata("acsAdm", $acsAdm);
					$this->session->set_userdata("acsDP", $acsDP);
					$this->session->set_userdata("acsCO", $acsCO);
					$this->session->set_userdata("acsBil", $acsBil);
					$this->session->set_userdata("acsDis", $acsDis);
                    $this->session->set_flashdata("notification", "Successful login $db_username");
                    $this->session->set_userdata("visit", 0);
                    echo '<script type="text/javascript">
                                alert("Login Successful!");
                               </script> ' ;

                    redirect(base_url() . 'home/');
                }
                else
                {
                    echo '<script type="text/javascript">
                                alert("Incorrect username/password combination!");
                               </script> ' ;
                    $this->load->view('header.php');
                    $this->load->view('login.php');
                    $this->load->view('footer.php');
                } 
            }

            else
            {
                echo '<script type="text/javascript">
                                alert("Incorrect username/password combination!");
                               </script> ' ;

                $this->load->view('header.php');
                $this->load->view('login.php');
                $this->load->view('footer.php');
            }
        }
	}

    public function changePass()
    {
        $this->load->view('header.php');
        $this->load->view('changePass.php');
        $this->load->view('footer.php');      
    }

    public function confirmChangePass()
    {
        $this->load->view('header.php');
        $this->load->view('changePass.php');
        $this->load->view('footer.php'); 

        $uname = $_POST['uname'];
        $pass = $_POST['pass'];
        $newPass = $_POST['nPass'];
        $cNewPass = $_POST['cPass'];

        $sql = "SELECT * FROM `doctors_list`
        WHERE `uName` = '" . mysql_real_escape_string(addslashes(strip_tags($uname))) . "'";
        
        $sql = $this->db->query($sql) or die(mysql_error());
        
        if ($sql->num_rows() > 0) 
        {
            foreach ($sql->result() as $data) 
            {
                $db_password = $data->pWord;
                $db_username = $data->uName;
            }

            $pass= md5($pass);

            if(($db_password == $pass) && ($db_username == $uname))
            {
                if(($newPass == $cNewPass))
                {
                    if((strlen($newPass) >= 8))
                    {
                        $newPass = md5($newPass);
                        $sql = "UPDATE doctors_list SET pWord = '$newPass' 
                        WHERE uName = '$uname'";
                        $sql = $this -> db -> query($sql) or die(mysql_error());

                      echo '<script type="text/javascript">
                                alert("Password successfully changed!");
                               </script> ' ;

                    }

                    else
                    {
                        echo '<script type="text/javascript">
                                    alert("Password should be more than 7 characters!");
                                   </script> ' ;
                    }

                      
                }
                else
                {
                    echo '<script type="text/javascript">
                                alert("Passwords do not match!");
                               </script> ' ;
                }
            }
            else
            {
                echo '<script type="text/javascript">
                                alert("Incorrect username/password combination!");
                               </script> ' ;
            }
        }
        else
        {
          echo '<script type="text/javascript">
                                alert("Incorrect username/password combination!");
                               </script> ' ;
        }

    }

    public function forgot()
    {
        $this->load->view('header.php');
        $this->load->view('forgot.php');
        $this->load->view('footer.php'); 
    }

    public function resetPass()
    {
        $this->load->view('header.php');
        $this->load->view('forgot.php');
        $this->load->view('footer.php'); 

        $uname = $_POST['uname'];
        $email = $_POST['email'];

        $sql = "SELECT * FROM `doctors_list`
        WHERE `uName` = '" . mysql_real_escape_string(addslashes(strip_tags($uname))) . "'";
        
        $sql = $this->db->query($sql) or die(mysql_error());
        
        if ($sql->num_rows() > 0) 
        {
            foreach ($sql->result() as $data) 
            {
                $db_email = $data->eAddr;
                $db_username = $data->uName;
            }

            if(($db_email == $email) && ($db_username == $uname))
            {
                $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
                $string = '';
                for ($i = 0; $i < 7; $i++)
                {
                      $string .= $characters[rand(0, strlen($characters) - 1)];
                }

                $newPWord = md5($string);
                $sql = "UPDATE doctors_list SET pWord = '$newPWord' 
                WHERE uName = '$uname'";
                $sql = $this -> db -> query($sql) or die(mysql_error());

                //load pdf
                $this->load->library('Pdf');

                $pdf = new TCPDF($orientation = 'P',$unit = 'mm', $format = 'Letter', $diskcache = false,$pdfa = false, $encoding = 'ISO-8859-1');
                $pdf->setTitle('CCSO: Reset Password');
                $pdf->AddPage();
                $pdf->SetFont('helvetica', '', 12);

                $html = '
                <html>
                <head>
                <link rel="stylesheet" type="text/css">
                    <style>
                        h1{
                            text-align: center;
                        }
      
                        margin-left: auto;
                        margin-right: auto;
                            border: 0.5px solid;
                        }
                    </style>
                </head>
                <body>
                <p align = "center"><h4> Alvina Pauline D. Santiago, M.D.</h4><br/>
                    Computerised Clinic System for Opthalmology <br/>
                    The Medical City <br/>
                    St. Lukes Medical Center <br/>
                    Manila Doctors Hospital <br/>
                    </p> <hr> <br>

                <h1>CCSO: Reset Password</h1><br/>';

                $html .= '<p align = "center"> Here is your new password: <br/></p>';
                    
                $html .= '<p align = "center"> '.$string.' </p>

                </body>
                </html>';
                
                $pdf->writeHTML($html, $ln = true, $fill = false, $reseth = false, $cell = false, $align = 'L');
                $filename = 'ResetPassword.pdf';
                $ePdf = $pdf->Output($filename, 'S');

                $this->load->library('Mail');

                $mail = new PHPMailer();
                $mail -> isSendmail();
                $mail -> setFrom('cbgeneroso@up.edu.ph', 'Christian Neil Generoso');
                $mail -> addReplyTo('cbgeneroso@up.edu.ph', 'Chrisitan Neil Generoso');
                $mail -> addAddress($email);
                $mail -> Subject = 'CCSO: Reset Password';
                $mail->Body = 'Your password has been reset! See attachment for more information.';
                $mail -> AltBody = 'Your password has been reset! See attachment for more information.';
                $mail->AddStringAttachment($ePdf ,'ResetPassword.pdf');
                //send the message, check for errors
                if ($mail -> send()) 
                {
                    echo '<script type="text/javascript">
                                alert("Password has been reset! Details have been sent to your mail!");
                               </script> ';
                }
            }

            else
            {
               echo '<script type="text/javascript">
                                alert("Incorrect username/email combination!");
                               </script> ';
            }
        }
        else
        {
             echo '<script type="text/javascript">
                                alert("Incorrect username/email combination!");
                               </script> ';
        }
    }

    public function clear_cache()
    {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    function unset_ordering_vars() {
        $this->session->unset_userdata('patient_id');
        $this->session->unset_userdata('patient_name');
        $this->session->unset_userdata('order_cart');

        $this->session->unset_userdata('pkg_id');
        $this->session->unset_userdata('pkg');
        $this->session->unset_userdata('pkg_name');
        $this->session->unset_userdata('pkg_desc');
        $this->session->unset_userdata('pkg_mode');
        $this->session->unset_userdata('orig_pack_name');

        $this->session->unset_userdata('prod_id');
        $this->session->unset_userdata('orig_prod_name');
        $this->session->unset_userdata('pack_s_id');
    }

    function unset_outproc_vars() {
        $this->session->unset_userdata('procedure_package');
        $this->session->unset_userdata('procedure_order');
        $this->session->unset_userdata('procedure_price');
    }
}

?>