<?php include 'includes/header.php'; ?>

<body id="top-page" class="<?php echo $page_name; ?>">
    <div class="c-transition <?php echo $classAnimation; ?>"></div>
    
    <div class="page-background"></div>
    
    <?php
        include 'includes/nav.php';
    ?>
    
    <div id="wrapper"> 
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-10 col-md-offset-1 col-xl-8 col-xl-offset-2">
                    <header class="p-header">
                        <h1 class="u-title_medium u-color_secondary-dark">Trouve une idée de</h1>
                        <h1 class="u-title_big--alt" text="cadeau">cadeau</h1>
                    </header>
                    <section class="users_list">
                        <h2 class="u-title_medium users_list_title">
                            Trouver une idée pour :
                        </h2>
                <?php
                    if(empty($users))
                    {
                ?>
                        <p class="u-text_big u-text_center" style="width:100%">
                            <em>
                                Aucune liste à afficher pour le moment.
                                <br><br>
                                Rejoins un groupe pour pouvoir accéder aux listes de cadeaux autres membres.
                                <br><br>
                                <a href="groups/" class="u-button--secondary-dark"><span class="icon-groups"></span> MES GROUPES</a>
                            </em> 
                        </p>
                <?php
                    }
                    else
                    {
                ?>
                        <div class="users_list_item">
                <?php
                        foreach($users as $user)
                        {
                ?>
                            <div class="users_list_member">
                                <div class="users_list_member_img">
                                    <p class="users_list_member_img_wrapper">
                                        <img src="<?=$user->img()?>" alt="Avatar de <?=$user->username()?>">
                                    </p>
                                </div>
                                <p class="users_list_member_title">
                                    <?=$user->username()?> <br>
                                    <a href="gifts/list/<?=$user->id_user()?>" class="u-button--secondary-dark users_list_member_button">
                                        <span class="icon-gift"></span> Sa liste
                                    </a>
                                </p>
                        <?php
                            if($user->has_new_gifts())
                            {
                        ?>
                                <span class="users_list_member_notif">
                                    <span class="icon-flamme"></span>
                                    <span class="hidden-sm--max">Nouvelles idées !</span>
                                </span>
                        <?php
                            }
                        ?>
                           
                            </div>
                <?php
                        }
                ?>
                        </div>
                <?php
                    }
                ?>
                    </section>
                </div>
            </div>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>