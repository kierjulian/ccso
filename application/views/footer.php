<!-- container section end -->
    <!-- javascripts -->
	<!-- container section end -->
    <!-- javascripts -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <!-- nice scroll -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.nicescroll.js" type="text/javascript"></script>

    <!-- jquery ui -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>

    <!--custom checkbox & radio-->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/ga.js"></script>
    <!--custom switch-->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-switch.js"></script>
    <!--custom tagsinput-->
    <script src="<?php echo base_url(); ?>assets/js/jquery.tagsinput.js"></script>
    
    <!-- colorpicker -->
   
    <!-- bootstrap-wysiwyg -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.hotkeys.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-wysiwyg.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-wysiwyg-custom.js"></script>
    <!-- ck editor -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
    <!-- custom form component script for this page-->
    <script src="<?php echo base_url(); ?>assets/js/form-component.js"></script>
    <!-- custome script for all page -->
    <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>

    <!-- nice scroll -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.nicescroll.js" type="text/javascript"></script><!--custome script for all page-->
    <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
	
	<!--validators-->
	<!-- jquery validate js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>

    <!-- custom form validation script for this page-->
    <script src="<?php echo base_url(); ?>assets/js/form-validation-script.js"></script>
    <!--custome script for all page-->
    <script type="text/javascript"> 
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.document.location = $(this).data("href");
            });
    });
    </script>
    <script type="text/javascript"> 
    function deleteConfirm(url)
     {
        if(confirm('Do you want to Delete this record ?'))
        {
            window.location.href=url;
        }
     }
    </script>
  </body>
</html>