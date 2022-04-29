      <!--main content start-->
<section id="main-content">
  <section class="wrapper">
    <h3 class="page-header"><?php echo $header; ?></h3>
    <div class="row"> <div class="col-md-12">
      <h4><?php echo $prompt; ?></h4>
    </div> </div>
      <form method='post' class="form-inline" action=<?php echo $next; ?>>  
        <div class="row"> <div class="col-md-12">
            <?php
              if (isset($selected)) {
                echo '<input type="text" name="selected_name" class="btn btn-info col-md-4 disabled"  value="'.$selected_name.'">';
                echo '<input type="hidden" name="selected_final" class="form-control" value="'.$selected.'">';
                echo '<input type="submit" class="btn btn-primary" name="submit" value="Go"/>';
              } else {
                echo '<input type="submit" name="selected_name" class="btn btn-active col-md-4 disabled" value="'.$placeholder.'">';
                echo '<input type="submit" class="btn btn-primary disabled" name="submit" value="Go"/>';
              }
            ?>
        </div> </div>
      </form>
    <hr class="col-lg-12">
    <div class="row">
      <div class="col-md-12">
        <form method='post' class='form-inline' action=<?php echo $next; ?>>
          <div class="form-group col-md-3">
            <input type="text" name="psearch" id="psearch" class="form-control input-sm" placeholder="Search">
          </div>
          <input type="submit" class="btn btn-active input-sm" name='submit' value='Search'/>
          <button class="btn btn-active input-sm"><a href=<?php echo $next; ?>> Display All </a></button>
        </form>
      </div>
    </div>
    <br>
    <div class="row"> 
      <div class="col-lg-12">
        <section class="panel">
          <?php echo $select_table; ?>
        </section>
      </div>
    </div>

  </section>
</section>
      <!--main content end-->