<?php include 'includes/header.php'; ?>

<body id="top-page" class="<?php echo $page_name; ?>">
    <div class="c-transition <?php echo $classAnimation; ?>"></div>
    
    <div class="page-background"></div>
    
    <div id="wrapper">
        <div class="p-header_fixed--alt">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-xl-8 col-xl-offset-2">
                        <header class="p-header u-text_center">
                            <?php include 'includes/nav.php'; ?>
                            <h1 class="u-title_medium u-text_center">Voilà de quoi faire plaisir à</h1>
                            <h1 class="u-title_big--alt u-text_center" text="<?=$user->username()?>"><?=$user->username()?></h1>
                        </header> 
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-xl-8 col-xl-offset-2">
                    <section class="liste_giftlist">
                <?php
                    if(empty($user_list))
                    {
                ?>
                        <p class="u-text_big u-text_center">
                            <em>
                                <?=$user->username()?> n'a pas encore renseigné d'idées de cadeaux. <br>
                                Reviens un peu plus tard !
                            </em>
                        </p>
                <?php
                    }
                    else
                    {
                        foreach($user_list as $id_gift => $gift)
                        {
                            include 'includes/gift.php';
                        }
                    }
                ?>
                    </section>
                    <section class="liste_form">
                        <h2 class="u-title_medium u-text_center">C'est tout pour <?=$user->username()?> !</h2>
                        <h3 class="u-title_small u-text_center">Mais si vous vous sentez d'humeur généreuse, vous pouvez aller faire un tour sur la liste de quelqu'un d'autre et trouver d'autres idées !</h3>
                        
                        <form action="<?=SITE_MAIN_BASE.'liste/view/'?>" onsubmit="return form_checker(event)" method="post" class="c-form">
                            <div class="c-form_field">
                                <label class="c-form_field_label" data-required>Je veux voir la liste de :</label>
                                <div class="c-form_dropdown">
                                    <input type="hidden" value="" data-required="Merci de sélectionner un utilisateur" name="required[id_user]"/>
                                    <button class="c-form_dropdown_btn" type="button">
                                       <span class="text">Choisir une personne dans la liste</span> <span class="icon-caret"></span>
                                    </button>
                                    <ul class="c-form_dropdown_list">
                                <?php
                                    foreach($users_list as $id_user => $user)
                                    {
                                        if(!isset($user_list)) {
                                            $user_list = $GiftManager->lists($id_user);
                                        }
                                        
                                        if($id_user !== $_SESSION['user']->id_user() && !empty($user_list))
                                        {
                                ?>
                                        <li data-value="<?=$user->id_user()?>"><?=$user->username()?></li>
                                <?php
                                        }
                                    }
                                ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="c-form_field u-text_center">
                                <button class="u-button--secondary-dark"><span class="icon-eye"></span>Voir la liste</button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>