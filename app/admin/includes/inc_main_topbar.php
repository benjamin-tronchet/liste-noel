        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-user"></i> <?php echo $config_user_fullname ?>
                    <span class="fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="index.php?logout"><i class="fa fa-sign-out pull-right"></i> Déconnection</a></li>
                  </ul>
                </li>
                <li>
                   <a href="<?php echo $config_site_url ?>" target="_blank" class="hidden-xs">
                    <i class="fa fa-desktop"></i> Voir site
                  </a> 
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
        <div class="right_col" role="main">