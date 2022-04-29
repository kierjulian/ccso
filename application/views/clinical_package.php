<section id="main-content">
  <section class="wrapper">
    <h3 class="page-header"><?php echo $header; ?></h3>
    <div class="row"> <div class="col-md-12">
      <?php if(isset($bad_qty)) { ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error! </strong>Invalid quantity. Please try again.
        </div>
      <?php } ?>
      <?php if(isset($bad_name)) { if ($bad_name == TRUE) { $pkg_name=''; ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error! </strong>Name taken. Please try again.
        </div>
      <?php } } ?>
      <?php if(isset($bad_name)) { if ($bad_name == FALSE) { $pkg_name=''; ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error! </strong>Name required. Please try again.
        </div>
      <?php } } ?>
      <?php if(isset($bad_desc)) { $pkg_desc=''; ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error! </strong>Description required. Please try again.
        </div>
      <?php } ?>
      <?php if(isset($bad_pf)) { ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error! </strong>Invalid professional fee. Please try again.
        </div>
      <?php } ?>
    </div></div>
    <div class="panel panel-primary">
      <div class="panel-heading">
        <div class="row">
          <div class="col-md-1">
            <label>
              Name:
            </label>
          </div>
          <div class="col-md-6"> <div class="row">
            <form method="post" class="form-inline" action="<?php echo base_url(); ?>productmanager/edit_pkg_name">
              <div class="col-md-8">
                <?php if ($name_mode=='display') {
                  echo "<input type='submit' class='btn btn-active' name='pack_name' style='cursor: text' value='".$pkg_name."'>";
                } elseif ($name_mode=='edit') {
                  echo "<input type='text' name='pack_name' placeholder='Package Name' class='input-sm form-control active' value='".htmlspecialchars_decode($pkg_name)."'/>";
                }
                ?>
              </div>
              <?php if ($name_mode=='edit') {
                echo "<input type='submit' name='success' class='btn btn-default' value='confirm'/>";
              }
              ?>
            </form>
          </div>  </div>
          <div class="col-md-3">
            <form method="post" class="form-inline" action="<?php echo base_url(); ?>productmanager/edit_pkg_pf">
                <?php if ($pf_mode=='display') {
                  echo "<input type='submit' class='btn btn-active col-md-12' name='pack_pf' style='cursor: text' value='Fee: ".$pkg_pf."'>";
                } elseif ($pf_mode=='edit') {
                  echo "<div class='col-md-8'><input type='text' name='pack_pf' placeholder='Professional Fee' class='input-sm form-control active' value='".htmlspecialchars_decode($pkg_pf)."'/></div>";
                  echo "<input type='submit' name='success' class='btn btn-default col-md-4' value='confirm'/>";
                }
                ?>
            </form>
          </div>
          <div class"col-md-2">
            <button class='btn btn-primary disabled col-md-2'>Price: <?php echo $pkg_price; ?></button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-1">
            <label>
              Description:
            </label>
          </div>
          <div class="col-md-11">
            <form method="POST" class="form-inline" action="<?php echo base_url(); ?>productmanager/edit_pkg_desc">
              <div class="col-md-8">
                <?php if ($desc_mode=='display') {
                  echo "<input type='submit' class='btn btn-active' name='pack_desc' style='cursor: text' value='".$pkg_desc."'>";
                } elseif ($desc_mode=='edit') {
                  echo "<input type='text' name='pack_desc' placeholder='Package Description' class='input-sm form-control active' value='".htmlspecialchars_decode($pkg_desc)."'/>";
                }
                ?>
              </div>
              <?php if ($desc_mode=='edit') {
                echo "<input type='submit' name='success' class='btn btn-default' value='confirm'/>";
              }
              ?>
            </form>
          </div>
        </div> 
      </div>
      <div class="panel-body" style="min-height: 150px; max-height: 200px; overflow-y: scroll;">
        <center><?php echo $package; ?></center>
      </div>
      <div class="panel-footer">
        <div class="row">
          <div class="col-md-1 col-md-offset-5">
            <form method='post' class='form-inline' action=<?php echo "'".base_url()."productmanager/cancel_package/".$mode."'"; ?>>
              <input type="submit" class="btn btn-active" value="Cancel"/>
            </form>
          </div>
          <div class="col-md-1">
            <form method='post' class='form-inline' action=<?php echo "'".base_url()."productmanager/confirm_package/".$mode."'"; ?>>
              <?php $class = "btn btn-active";
                if($package=='<i class="fa fa-dropbox"></i><span>Add items to package</span>') {
                $class .= " disabled";
              } ?>
              <input type="submit" class=<?php echo $class; ?> value="Finalize"/>
            </form>
          </div> 
        </div>
      </div>
    </div>
    <a name="products"></a>
    <div class="panel panel-primary">
      <div class="panel-heading">
        <div class="row">
          <div class="col-md-8">
            <h3>PRODUCTS</h3>
          </div>
          <div class="col-md-4">
            <div class="row">
              <form method='post' class='form-inline' action='<?php echo base_url(); ?>productmanager/searchByProduct#products'>
                <div class="form-group col-md-7">
                  <input type="text" name="product" id="product" class="form-control input-sm" placeholder="Search">
                </div>
                <input type="submit" class="btn btn-active input-sm" name='submit' value='Go'/>
                <button class="btn btn-active input-sm"><a href=<?php echo "'".base_url()."productmanager/".$mode."pkg#products'"; ?>> Display All </a></button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="panel-body" style="max-height: 200px; overflow-y: scroll;">
        <center><?php echo $products; ?></center>
      </div>
    </div>
  </section>
</section>
<!-- MODAL -->
<div class="modal fade" id="qtyprompt">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"> <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="quantityprompt">
          Product Quantity
        </h4>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
        <form id="qtypk" name="qtypk" method='POST' action='<?php echo base_url(); ?>productmanager/add'>
          <div class="form-group">
            <label  class="col-sm-2 control-label" for="qty">Quantity</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="qty" id="qty" placeholder="qty" value=1 />
            </div>
            <div class="col-sm-2">
              <input id="qtysubmit" type="submit" name="qtysubmit" class="btn btn-default" value="Confirm">
            </div>
          </div>
        </form>
        <br>
      </div>
      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
      </div>
    </div>
  </div>
</div>
<!-- modal end -->