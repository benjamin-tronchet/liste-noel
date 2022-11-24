<?php
    include realpath(__DIR__).'/../../controller/MainController.php';
    $user = $_SESSION['user'];
?>
<div class="u-panel_content">
    <header class="u-panel_header">
        <p class="u-title_small">
            Mon profil
        </p>
        <a href="identification/logout/" class="u-panel_logout">
            Déconnexion <span class="icon-cancel"></span>
        </a>
    </header>
    <form action="<?=SITE_MAIN_BASE.'user/update/'?>" method="POST" class="c-form" is-checked enctype="multipart/form-data">
        <div class="c-form_field">
            <label class="c-form_field_label" data-required>Ton email :</label>
            <input name="required[mail][email]" data-required="Indique une adresse email" placeholder="email@domain.com" type="email" autocomplete="off" data-verification="user-email" value="<?=$user->email()?>">
        </div>
        <div class="c-form_field">
            <label class="c-form_field_label" data-required>Nom d'utilisateur :</label>
            <input name="required[username]" data-required="Indique un nom d'utilisateur" placeholder="Ton nom d'utilisateur" type="text" autocomplete="off" data-verification="user-username" value="<?=$user->username()?>">
        </div>
        <div class="c-form_field c-form_file">
            <label class="c-form_field_label" data-required>Avatar <small>(facult.)</small> :</label>
            <div class="c-form_file_content"> 
                <input name="image_normal[img]" type="file" id="img" accept=".jpg,.jpeg,.png">
                <div class="c-form_file_image unmasked">
                    <input type="hidden" name="img" value="<?=$user->img()?>">
                    <img src="<?=$user->img()?>" alt="">
                </div>
                <label class="u-button--primary trigger" for="img">
                    <span class="icon-upload"></span>Choisir un autre avatar
                </label>
                
            </div>

        </div>
        <div class="c-form_field c-form_submit">
            <button type="submit" class="u-button">Mettre à jour</button>
        </div>
    </form>
</div>