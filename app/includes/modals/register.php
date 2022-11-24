<?php
    include realpath(__DIR__).'/../inc_config.php';
?>
<div class="u-panel_content">
    <header class="u-panel_header">
        <p class="u-title_small">
            Créer un compte
        </p>
    </header>
    <form action="<?=SITE_MAIN_BASE.'user/create/'?>" method="POST" class="c-form" is-checked enctype="multipart/form-data">
        <div class="c-form_field">
            <label class="c-form_field_label" data-required>Ton email :</label>
            <input name="required[mail][email]" data-required="Indique une adresse email" placeholder="email@domain.com" type="email" autocomplete="off" data-verification="user-email">
        </div>
        <div class="c-form_field">
            <label class="c-form_field_label" data-required>Mot de passe :</label>
            <input name="required[password]" data-required="Indique un mot de passe" placeholder="Saisir une mot de passe" type="password" autocomplete="off" >
        </div>
        <div class="c-form_field">
            <label class="c-form_field_label" data-required>Nom d'utilisateur :</label>
            <input name="required[username]" data-required="Indique un nom d'utilisateur" placeholder="Ton nom d'utilisateur" type="text" autocomplete="off" data-verification="user-username">
        </div>
        <div class="c-form_field c-form_file">
            <label class="c-form_field_label" data-required>Avatar <small>(facult.)</small> :</label>
            <div class="c-form_file_content"> 
                <input name="image_normal[img]" type="file" id="img" accept=".jpg,.jpeg,.png">
                <div class="c-form_file_image">
                    <img src="" alt="">
                </div>
                <label class="u-button--primary trigger" for="img">
                    <span class="icon-upload"></span>Choisir un avatar
                </label>
            </div>

        </div>
        <div class="c-form_field c-form_submit">
            <button type="submit" class="u-button">Créer mon compte</button>
        </div>
    </form>
</div>