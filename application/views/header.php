<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ophthalmology">
    <meta name="author" content="CMSC 127 Batch 2017">
    <meta name="keyword" content="Ophthalmology, Eye Treatment">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Computerised Clinic System for Ophthalmology</title>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/logo.JPG" type="image/png">
    <!-- Bootstrap CSS -->    
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="<?php echo base_url(); ?>assets/css/elegant-icons-style.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" />    
    <!-- Custom styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fullcalendar.css">
	<link href="<?php echo base_url(); ?>assets/css/widgets.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style-responsive.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/css/xcharts.min.css" rel=" stylesheet">	
	<link href="<?php echo base_url(); ?>assets/css/jquery-ui-1.10.4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript">
    
    function order_qty(id) {
        $('#qtyp').attr('action', '<?php echo base_url()?>clinicalorder/order/'+id);
        $('#qtyprompt').modal({
            backdrop: 'static'
        });
    }

    function add_qty(id) {
        $('#qtypk').attr('action', '<?php echo base_url()?>productmanager/add_to_pkg/'+id);
        $('#qtyprompt').modal({
            backdrop: 'static'
        });
    }

    $(document).ready(function(){
        $('.launch-modal').click(function(){
            $('#editMDmodal').modal({
                backdrop: 'static'
            });
        }); 
    });

    $(document).ready(function(){
        function hAlignModal(){
            var modalDialog = $(this).find(".modal-dialog");
            /* Applying the left margin on modal dialog to align it horizontally center */
            modalDialog.css("margin-left", Math.max(0, ($(window).width() - modalDialog.width()) / 2));
        }
        // Align modal when it is displayed
        $(".modal").on("shown.bs.modal", hAlignModal);
    
        // Align modal when user resize the window
        $(window).on("resize", function(){
            $(".modal:visible").each(hAlignModal);
        });   
        function vAlignModal(){
            var modalDialog = $(this).find(".modal-dialog");
            /* Applying the top margin on modal dialog to align it vertically center */
            modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 4));
        }
        // Align modal when it is displayed
        $(".modal").on("shown.bs.modal", vAlignModal);
    
        // Align modal when user resize the window
        $(window).on("resize", function(){
            $(".modal:visible").each(vAlignModal);
        });   
    });
</script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <script src="js/lte-ie7.js"></script>
    <![endif]-->
  </head>
