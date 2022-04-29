<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Computerized Clinic System for Opthalmology">
    <meta name="author" content="UP Manila Students">
    <meta name="keyword" content="CCSO">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Login</title>

    <!-- Bootstrap CSS -->    
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="<?php echo base_url(); ?>assets/css/elegant-icons-style.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-img3-body">

    <div class="container">

      <form class="login-form" action= "<?php echo base_url(); ?>main" method = "post">        
        <div class="login-wrap">
            <p class="login-img"><i class="icon_lock_alt"></i></p>
            <div class="input-group">
              <span class="input-group-addon"><i class="icon_profile"></i></span>
                <input type="text" placeholder="Username" class="form-control" autofocus id="tf_account" name="tf_account" required>

            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                <input type="password" placeholder="Password" class="form-control" id = "tf_password" name = "tf_password" required>
            </div>

            
            <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>

            <label class="checkbox">
                <h4> <span class="pull-right"> <a href= "<?php echo base_url(); ?>main/changePass"> Change Password </a> </span> </h3> <br>
                <h4> <span class="pull-right"> <a href= "<?php echo base_url(); ?>main/forgot"> Forgot Password? </a></span> </h3>  <br>
            </label>
        </div>  
      </form>
    </div>
  </body>
</html>
