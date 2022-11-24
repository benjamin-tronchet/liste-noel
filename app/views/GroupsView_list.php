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
                        <h1 class="u-title_medium u-color_secondary-dark">Mes</h1>
                        <h1 class="u-title_big--alt" text="groupes">groupes</h1>
                    </header>
                    <p class="groups_list_add">
                        <button class="u-button--primary" data-panel="join-group"><span class="icon-groups"></span> Rejoindre un groupe</button>
                    </p>
                    <h2 class="groups_list_title u-title_medium">
                        Mes groupes :
                    </h2>
                    <section class="groups_list">
                <?php
                    if(empty($groups_list))
                    {
                ?>
                        <p class="u-text_big u-text_center" style="width:100%">
                            <em>
                                Tu n'as rejoint aucun groupe pour le moment.
                                <br/>
                                Utilisez le bouton ci-dessus pour sélectionner un ou plusieurs groupe(s) à rejoindre.
                            </em>
                        </p>
                <?php
                    }
                    else
                    {
                        foreach($groups_list as $group)
                        {
                ?>
                        <div class="groups_list_item">
                            <header class="groups_list_item_head">
                                <p class="u-title_medium groups_list_item_title">
                                    <?=$group->title()?>
                                </p>
                                <button data-panel="leave-group" data-post="id_group=<?=$group->id_group()?>" class="groups_list_item_leave">
                                    Quitter<span class="hidden-sm--max">&nbsp;ce groupe</span>
                                    <span class="icon-cancel"></span>
                                </button>
                            </header>
                            <h3 class="groups_list_item_intro">
                                <strong>Liste des membres :</strong>
                            </h3>
                        <?php
                            $group->get_members();  
                            if(!empty($group->users()))
                            {
                                foreach($group->users() as $user)
                                {
                            ?>
                            <div class="groups_list_member">
                                <div class="groups_list_member_img">
                                    <p class="groups_list_member_img_wrapper">
                                        <img src="<?=$user->img()?>" alt="Avatar de <?=$user->username()?>">
                                    </p>
                                </div>
                                <p class="groups_list_member_title">
                                    <?=$user->username()?>
                                </p>
                                </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                <?php
                        }
                    }
                ?>
                    </section>
                </div>
            </div>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>