<?php include 'includes/header.php'; ?>

<body id="top-page" class="<?php echo $page_name; ?>">
    <div class="c-transition <?php echo $classAnimation; ?>"></div>
    
    <div id="wrapper">
        
        <header class="p-header">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-sm-offset-1 u-text_center">
                        <h1 class="u-title_big" text="Qui veut quoi ?">Qui veut quoi ?</h1>
                    </div>
                </div>
            </div>
        </header>
        
        <section class="container">
            <div class="row identification_form">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                    <form class="c-form" action="<?=SITE_MAIN_BASE.'identification/login'?>" method="post" is-checked>
                        <div class="c-form_field">
                            <label class="c-form_field_label">Email :</label>
                            <input name="required[mail][email]" data-required="Indique ton email" placeholder="email@domain.com" type="email" data-verification="user-exists">
                        </div>
                        <div class="c-form_field">
                            <label class="c-form_field_label">Mot de passe :</label>
                            <input name="required[password]" data-required="Indique ton mot de passe." placeholder="Mot de passe" type="password">
                        </div>
                        <div class="c-form_field--button u-text_center">
                            <button type="submit" class="u-button">Connexion</button> <br>
                            <button class="c-form_link" data-panel="password-forgot">Mot de passe oublié ?</button>
                        </div>
                    </form>
                    <p class="c-form_infos">
                        Pas encore enregistré ? <br><br>
                        <button data-panel="register" class="u-button">Créer mon compte</button>
                    </p>
                </div>
            </div>
        </section>
    
    </div>

<?php include 'includes/footer.php'; ?>