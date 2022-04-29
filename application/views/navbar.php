  <body>
  <!-- container section start -->
	  <header class="header dark-bg">
	        <div class="toggle-nav">
	            <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"></div>
	        </div>

	        <!--logo start-->
	        <a href="<?php echo base_url(); ?>home" class="logo"><img src="<?php echo base_url(); ?>assets/img/logo.JPG" height="40px" width="40px"> Computerised Clinic System <span class="lite">for Ophthalmology</span></a>
	        <!--logo end-->
			</br><a class="logout" href="<?php echo base_url(); ?>main">LOGOUT</a>
				 <a class="logout"> &nbsp&nbsp&nbsp </a>
				 <a class="logout" ><font color="#fed189"><?php echo $this->session->userdata("username"); ?></font></a>
			
			</br></br>
			
			<div id="navbar">
			  <ul class="nav nav-pills nav-justified">
				<li class="navbar"> <a href="<?php echo base_url(); ?>home">
			      	<i class="icon_house"></i>
				  	<span>HOME</span>
				</a> </li>
				<li class="navbar"> <a href="<?php echo base_url(); ?>queue	">
			      	<i class="icon_group"></i>
				  	<span>Patient List</span>
				</a> </li>
			<?php
				$this->load->library(array('table', 'form_validation', 'session'));
				
				if(! $this->session->userdata("logged_in")){
					redirect(base_url() . "main/");
				}
				
				if($this->session->userdata("acsUse")){ ?>
					<li class="navbar"> <a href="<?php echo base_url(); ?>user"> <i class="icon_id-2"></i> <span>Users</span> </a> </li>
				<?php
				}
				if($this->session->userdata("acsAdm")){ ?>
					<li class="navbar"> <a href="<?php echo base_url(); ?>admit/"> <i class="icon_pencil-edit"></i> <span>Registration</span> </a> </li>
				<?php
				}
			    if($this->session->userdata("acsDP")){ ?>
					<li class="navbar"> <a href="<?php echo base_url(); ?>doctor"> <i class="icon_id_alt"></i> <span>Doctors Page</span> </a> </li>
				<?php
				}
			    if($this->session->userdata("acsCO")){ ?>
					<li class="navbar"> <a href="<?php echo base_url(); ?>clinicalorder"> <i class="icon_clipboard"></i> <span>Clinical Order</span> </a> </li>
				<?php
				}
			    if($this->session->userdata("acsDis")){ ?>
					<li class="navbar"> <a href="<?php echo base_url(); ?>discharge/index"> <i class="arrow_right"></i> <span>Discharge</span> </a> </li>
				<?php
				}
			    if($this->session->userdata("acsBil")){ ?>
					<li class="navbar"> <a href="<?php echo base_url(); ?>billing"> <i class="icon_documents_alt"></i> <span>Billing</span> </a> </li>
				<?php
				}
			?>  
			  </ul>
			 </div>
	  <!-- navbar end-->
	  </header>  
	   <!--header end-->
	  
	  
	  
    