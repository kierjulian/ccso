<section id="main-content">
  <section class="wrapper">
    <h3 class="page-header"><i class="fa fa fa-bars"></i><?php echo $header; ?></h3>
    <div class="row"> <div class="col-md-12">
      <?php if(isset($bad_qty)) { ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error! </strong>Invalid quantity. Please try again.
        </div>
      <?php } ?>
    </div></div>
    <div class="panel panel-primary">
      <div class="panel-heading">
        <div class="row">
            <div class="col-md-7">
              <h3>ORDER CART</h3>
            </div>
            <div class="col-md-3"> <div class="row">
              <form method='post' class='form-inline'>
                <div class="form-group col-md-12">
                  <input type='button' value=<?php echo "'".$ordermd."'"; ?> class='btn btn-active col-md-12 launch-modal' />
                </div>
              </form>
                <!-- MODAL -->
                <div class="modal fade" id="editMDmodal">
                  <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <!-- Modal Header -->
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"> <span aria-hidden="true">&times;</span>
                          <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="editMDmodalLabel">
                          Edit MD
                        </h4>
                      </div>
                      <!-- Modal Body -->
                      <div class="modal-body">
                        <form id="md" name="md" method='POST' action='<?php echo base_url(); ?>clinicalorder/editmd'>
                          <div class="form-group">
                            <label  class="col-sm-2 control-label" for="inputMD">MD</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="inputMD" id="inputMD" placeholder="MD" value=<?php echo "'".htmlspecialchars_decode($ordermd)."'"; ?>/>
                            </div>
                            <div class="col-sm-2">
                              <input id="mdsubmit" type="submit" name="submit" class="btn btn-default" value="Confirm">
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
            </div> </div>
            <div class="col-md-2"> <div class="row">
              <button class='btn btn-primary disabled col-md-12'> Total: <?php echo $order_total; ?> </button>
            </div> </div>
            
        </div>
      </div>
      <div class="panel-body" style="min-height: 100px; max-height: 180px; overflow-y: scroll;">
        <center><?php echo $orders; ?></center>
      </div>
      <div class="panel-footer">
        <center>
          <div class="row">
            <div class="col-md-1 col-md-offset-5">
              <form method='post' class='form-inline' action='<?php echo base_url(); ?>clinicalorder/cancel_order'>
                <input type="submit" class="btn btn-active" value="Cancel"/>
              </form>
            </div>
            <div class="col-md-1">
              <form method='post' class='form-inline' action='<?php echo base_url(); ?>clinicalorder/confirm_order/'>
                <?php $class = "btn btn-active";
                  if($orders=='<i class="fa fa-shopping-cart"></i><span>Add items to cart</span>') {
                  $class .= " disabled";
                } ?>
                <input type="submit" class=<?php echo $class; ?> value="Finalize"/>
              </form>
            </div> 
          </div>
        </center>
      </div>
    </div>
    <div class="row">
      <div class="panel panel-primary col-md-8">
        <div class="panel-heading">
          <div class="row">
              <div class="col-md-6">
                <h3>PACKAGES</h3>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <form method='post' class='form-inline' action='<?php echo base_url(); ?>clinicalorder/searchByPackage'>
                    <div class="form-group col-md-7">
                      <input type="text" name="package" id="package" class="form-control input-sm" placeholder="Search">
                    </div>
                    <input type="submit" class="btn btn-active input-sm" name='submit' value='Go'/>
                    <button class="btn btn-active input-sm"><a href='<?php echo base_url(); ?>clinicalorder/'> Display All </a></button>
                  </form>
                </div>
              </div>
          </div>
        </div>
        <div class="panel-body" style="min-height: 180px; max-height: 180px; overflow-y: scroll;">
          <div class="panel panel-primary">
            <center><?php echo $packages; ?></center>
          </div>
        </div>
      </div>
      <div class="panel panel-primary col-md-4">
        <div class="panel-heading">
          <?php echo $pack_name; ?>
        </div>
        <div class="panel-body" style="min-height: 180px; max-height: 180px; overflow-y: scroll;">
          <?php echo $pack_prods; ?>
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
                <form method='post' class='form-inline' action='<?php echo base_url(); ?>clinicalorder/searchByProduct#products'>
                  <div class="form-group col-md-7">
                    <input type="text" name="product" id="product" class="form-control input-sm" placeholder="Search">
                  </div>
                  <input type="submit" class="btn btn-active input-sm" name='submit' value='Go'/>
                  <button class="btn btn-active input-sm"><a href='<?php echo base_url(); ?>clinicalorder#products'> Display All </a></button>
                </form>
              </div>
            </div>
        </div>
      </div>
      <div class="panel-body" style="min-height: 150px; max-height: 150px; overflow-y: scroll;">
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
        <form id="qtyp" name="qtyp" method='POST' action='<?php echo base_url(); ?>clinicalorder/order'>
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