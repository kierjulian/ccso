<section id="main-content">
  <section class="wrapper">
    <h3 class="page-header"><i class="fa fa fa-bars"></i><?php echo $header; ?></h3>
    <div class="panel panel-primary">
      <div class="panel-heading">
        <div class="row">
            <div class="col-md-7">
              <h3><?php echo $table_header; ?></h3>
            </div>
            <div class="col-md-3">
              <?php
                if ($mode=="order") {
                  echo "
                  <button class='btn btn-info disabled col-md-12'>".
                    $ordermd
                  ."</button>";
                } elseif ($mode=="package") {
                  echo "
                  <button class='btn btn-info disabled col-md-12'>Fee: ".
                    $pkg_pf
                  ."</button>";                  
                }
              ?>
            </div>
            <?php
                if ($mode=="order") {
                  $disp="Total: ";
                } elseif ($mode=="package") {
                  $disp="Price: ";              
                }
                echo "
                  <div class='col-md-2'> <div class='row'>
                    <button class='btn btn-primary disabled col-md-12'>".$disp.$total."</button>
                  </div> </div>
                ";
            ?>


        </div>
        <div class="row">
          <?php
            if ($mode=="package") {
              echo "<div class='col-md-12'>".$description."</div>";
            }
          ?>
        </div>
      </div>
      <div class="panel-body" style="max-height: 750px; overflow-y: scroll;">
        <center><?php echo $confirm_table; ?></center>
      </div>
      <div class="panel-footer">
        <center>
          <div class="row">
            <div class="col-md-1 col-md-offset-5">
                <form method='post' class='form-inline' action=<?php echo $prev;?>>
                  <input type="submit" class="btn btn-active" value="Cancel"/>
                </form>
            </div>
            <div class="col-md-1">
              <form method='post' class='form-inline' action=<?php 
                if($prev==''.base_url().'productmanager/addpkg') {
                  echo "".base_url()."productmanager/success/".$mode."/add";
                } elseif($prev==''.base_url().'productmanager/editpkg') {
                  echo "".base_url()."productmanager/success/".$mode."/edit";
                } elseif($prev==''.base_url().'clinicalorder/') {
                  echo "".base_url()."clinicalorder/success";
                }
                ?>>
                <input type="submit" class="btn btn-active" value="Finalize"/>
              </form>
            </div> 
          </div>
        </center>
      </div>
    </div>
  </section>
</section>