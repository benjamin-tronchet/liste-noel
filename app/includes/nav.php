<nav class="p-nav">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1 col-xl-8 col-xl-offset-2">
                <div class="p-nav_wrapper">
                    <a href="dashboard/" class="p-nav_item">
                        <span class="icon-home"></span>
                    </a>
                    <button class="hidden-sm--min u-burger" data-action="menu">
                        <span class="u-burger_bar"></span>
                        <span class="u-burger_bar"></span>
                        <span class="u-burger_bar"></span>
                    </button>
                    <ul class="p-nav_menu">
                        <li class="p-nav_menu_item <?=($page_name == 'gifts') ? 'active' : ''?>">
                            <a href="gifts/list/">Ma liste <span class="icon-list"></span></a>
                        </li>
                        <li class="p-nav_menu_item <?=($page_name == 'groups') ? 'active' : ''?>">
                            <a href="users/">Trouver une idée <span class="icon-gift"></span></a>
                        </li>
                        <li class="p-nav_menu_item <?=($page_name == 'groups') ? 'active' : ''?>">
                            <a href="groups/">Mes groupes <span class="icon-groups"></span></a>
                        </li>
                        <li class="p-nav_menu_item <?=($page_name == 'groups') ? 'active' : ''?>">
                            <button data-panel="edit-profile"><?=$_SESSION['user']->username()?> <img src="<?=$_SESSION['user']->img()?>" alt="Avatar" class="p-nav_avatar"></button> 
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>