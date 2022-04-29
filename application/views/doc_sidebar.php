     <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu">                
				  <li class="active">
            <?php
                    echo "<a class'' href='".base_url()."doctor/index/".$this->session->userdata("visit")."'>";
            ?>
                          <i class="icon_profile"></i>
                          <span>View Profile</span>
                      </a>
                  </li>
				  <li class="active">
              <?php
                    echo "<a class'' href='".base_url()."procedures/index/".$this->session->userdata("visit")."'>";
            ?>
                          <i class="fa fa-dropbox"></i>
                          <span>Outside Procedures</span>
                      </a>
                  </li>  
            <li class="active">
              <?php
                    echo "<a class'' href='".base_url()."procedures/other/".$this->session->userdata("visit")."'>";
            ?>
                          <i class="fa fa-dropbox"></i>
                          <span>Additional Costs</span>
                      </a>
                  </li>  
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->