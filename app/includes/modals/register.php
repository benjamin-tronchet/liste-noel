<?php
    include realpath(__DIR__).'/../inc_config.php';
?>
<div class="u-modal_box">
    <button class="u-modal_close" data-close-modal></button>
    <div class="u-modal_content">
        <header class="u-modal_header">
            <p class="u-title_small">
                Créer un nouvel utilisateur
            </p>
        </header>
        <form action="<?=SITE_MAIN_BASE.'user/create/'?>" method="POST" class="c-form" onsubmit="return form_checker(event)">
            <div class="c-form_field u-text_center">
                <label class="c-form_field_label" data-required>Nom :</label>
                <div class="c-form_dropdown">
                    <input name="required[alpha][username]" data-required="Merci d'indiquer votre nom." placeholder="Entrez un nom d'utilisateur" type="text">
                </div>
            </div>
            <div class="c-form_field u-text_center">
                <label class="c-form_field_label" data-required>Mot de passe :</label>
                <input name="required[password]" data-required="Merci d'indiquer votre mot de passe." placeholder="Saisir votre mot de passe" type="password">
            </div>
            <div class="c-form_field u-text_center">
                <button type="submit" class="u-button">Connexion</button>
            </div>
        </form>
    </div>
</div>