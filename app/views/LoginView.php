<?php include 'includes/header.php'; ?>

<body id="top-page" class="<?php echo $page_name; ?>">
    <div class="c-transition <?php echo $classAnimation; ?>"></div>
    
    <div id="wrapper">
        
        <header class="p-header">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-sm-offset-1 u-text_center">
                        <h1 class="u-title_big" text="Ma liste de noël">Ma liste de noël</h1>
                    </div>
                </div>
            </div>
        </header>
        
        <section class="container">
            <div class="row identification_form">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                    <form class="c-form" action="<?=SITE_MAIN_BASE.'identification/login'?>" method="post" onsubmit="return form_checker(event)">
                        <div class="c-form_field">
                            <label class="c-form_field_label">Se connecter comme :</label>
                            <div class="c-form_dropdown">
                                <input type="hidden" value="" data-required="Merci de sélectionner un utilisateur" name="required[id_user]" onchange="show_hidden()"/>
                                <button class="c-form_dropdown_btn" type="button">
                                   <span class="text">Choisir une personne dans la liste</span> <span class="icon-caret"></span>
                                </button>
                                <ul class="c-form_dropdown_list">
                                <?php
                                    foreach($users_list as $id_user => $user)
                                    {
                                ?>
                                    <li data-value="<?=$user->id_user()?>"><?=$user->username()?></li>
                                <?php
                                    }
                                ?>
                                </ul>
                            </div>
                        </div>
                        <div class="c-form_field" data-hidden>
                            <label class="c-form_field_label">Mot de passe :</label>
                            <input name="required[password]" data-required="Merci d'indiquer votre mot de passe." placeholder="Saisir votre mot de passe" type="password">
                        </div>
                        <div class="c-form_field--button u-text_center" data-hidden>
                            <button type="submit" class="u-button">Connexion</button>
                        </div>
                    </form>
                    <p class="c-form_infos">
                        Pas encore enregistré ? <br>
                        <button data-modal="register">Je m'enregistre</button>
                    </p>
                </div>
            </div>
        </section>
    
    </div>

<?php include 'includes/footer.php'; ?>