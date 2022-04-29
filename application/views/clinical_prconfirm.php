<section id="main-content">
  <section class="wrapper">
    <h3 class="page-header"><?php echo $header; ?></h3>
  <form class='form-horizontal' method='post' action=<?php echo $next;?>>
    <div class='well'>
      <div class='row'>
        <label class='col-sm-2'>Product Name: </label>
        <input class='disabled input-sm btn btn-primary col-sm-8' type='text' name='name1' placeholder='Name' value=<?php echo "'".$name_conf."'";?>>
      </div>
      <div class='row'>
        <label class='col-md-2'>Product Description: </label>
        <input class='disabled input-sm btn btn-info col-sm-8' type='text' name='desc1' placeholder='Description' value=<?php echo "'".$desc_conf."'";?>>
      </div>
      <div class='row'>
        <label class='col-md-2'>Product Price: </label>
        <input class='disabled input-sm btn btn-primary col-sm-8' type='text' name='price1' placeholder='Price' value=<?php echo "'".$price_conf."'";?>>
      </div>
    </div>
    <input type='submit' class='btn btn-primary col-sm-1' name='submitprod' value='Finalize'>
  </form>
  <form class='form-horizontal' method='post' action=<?php echo $prev;?>>
    <input type='submit' class='btn btn-info col-sm-1' name='cancel' value='Cancel'>
    <input type='hidden' name='name1' value=<?php echo "'".$name_conf."'";?>>
    <input type='hidden' name='desc1' value=<?php echo "'".$desc_conf."'";?>>
    <input type='hidden' name='price1' value=<?php echo "'".$price_conf."'";?>>
  </form>
  </div>
  </section>
</section>