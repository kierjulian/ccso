     <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <script>
              	function scrollPresc(){
	              	$('html, body').animate({
					    scrollTop: $("#prescription").offset().top
					}, 1000);
				}
				function scrollDisc(){
              	  	$('html, body').animate({
					    scrollTop: $("#discharge").offset().top
					}, 1000);
				}
              </script>
              <ul class="sidebar-menu">                
				  <li class="active">
                      <a class="scrollForm" href="#" data-target="prescription" onclick="scrollPresc();">
                          <i class="icon_lifesaver"></i>
                          <span>Prescription</span>
                      </a>
                  </li>
				  <li class="active">
                      <a class="scrollForm" href="#" data-target="discharge" onclick="scrollDisc();">
                          <i class="arrow_right_alt"></i>
                          <span>Discharge</span>
                      </a>
                  </li>   
					<li class="active">
                      <a class="">
                          <span><?php if ($serverMsg == 'There are missing fields!') echo validation_errors();?></span>
                      </a>
                  </li> 
              </ul>
              <!-- sidebar menu end-->
              <br/>
              
          </div>
      </aside>
      <!--sidebar end-->