 <body class="nav-md">
    <div class="container body">
      <div class="main_container">
         <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
             <div class="wrapper-img">
                 <img src="<?php echo $config_site_srcimg; ?>" alt="..." class="">
             </div>
              <a href="index.php" class=""><span><?php echo $config_site_name; ?></span></a>
            </div>
            <div class="clearfix"></div>
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
                  <li>
                      <a href="index.php"><i class="fa fa-desktop"></i> Notice</a>
                  </li>
                  <br>        
                  <li>
                      <a href="index.php?page=actualites"><i class="fa fa-file-text"></i>Vos actualités</a>
                  </li>
                  <br>        
                 <?php if($is_admin): ?>
                 <br> 
                 <li>
                      <a href="index.php?page=settings"><i class="fa fa-cog"></i> Configuration</a>
                 </li>
                 <?php endif; ?>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
<!--
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
-->
            <!-- /menu footer buttons -->
          </div>
        </div>