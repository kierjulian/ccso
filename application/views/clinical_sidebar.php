     <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse">
              <!-- sidebar menu start-->
            <ul class="sidebar-menu">                
              <li class="active">
                <a class="" href="<?php echo base_url(); ?>clinicalorder">
                    <i class="fa fa-shopping-cart"></i>
                    <span>Order</span>
                </a>
              </li>
              <li class="active">
                <a class="" data-toggle="collapse" data-hover="collapse" href="#collapseOne">
                  <i class="fa fa-cube"></i>
                  <span>Manage Products</span>
                  <i class="fa fa-caret-down"></i>
                </a>
                <ul id="collapseOne" class="panel-collapse collapse">
                  <li><a href="<?php echo base_url(); ?>productmanager/addprod">
                    <i class="fa fa-plus"></i>
                    <span>Add Product</span>
                  </a></li>
                  <li><a href="<?php echo base_url(); ?>productmanager/editprod">
                    <i class="fa fa-pencil-square-o"></i>
                    <span>Edit Product</span>
                  </a></li>
                </ul>
              </li>  
              <li class="active">
                <a class="" data-toggle="collapse" data-hover="collapse" href="#collapseTwo">
                  <i class="fa fa-dropbox"></i>
                  <span>Manage Packages</span>
                  <i class="fa fa-caret-down"></i>
                </a>
                <ul id="collapseTwo" class="panel-collapse collapse">
                  <li><a href="<?php echo base_url(); ?>productmanager/addpkg">
                    <i class="fa fa-plus"></i>
                    <span>Add Package</span>
                  </a></li>
                  <li><a href="<?php echo base_url(); ?>productmanager/editpkg">
                    <i class="fa fa-pencil-square-o"></i>
                    <span>Edit Package</span>
                  </a></li>
                </ul>
              </li>  
            </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->