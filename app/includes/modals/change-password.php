<?php
    include_once realpath(__DIR__).'/../inc_config.php';
?>
<div class="u-panel_content active">
    <header class="u-panel_header">
        <p class="u-title_small">
            Définir un nouveau mot de passe
        </p>
    </header>
    <form action="<?=SITE_MAIN_BASE.'user/reset-password/'?>" method="POST" class="c-form" is-checked enctype="multipart/form-data">
        <div class="c-form_field">
            <label class="c-form_field_label" data-required>Nouveau mot de passe :</label>
            <input name="required[password]" id="password" data-required="Entre un nouveau mot de passe" placeholder="Nouveau mot de passe" type="password" autocomplete="off">
        </div>
        <div class="c-form_field">
            <label class="c-form_field_label" data-required>Confirmer le nouveau mot de passe :</label>
            <input name="required[password2]" data-required="Confirme ton mot de passe" placeholder="Confirmer le nouveau mot de passe" type="password" autocomplete="off" data-same="#password">
        </div>
        <div class="c-form_field c-form_submit">
            <input type="hidden" name="token" value="<?=$panel['data']?>">
            <button type="submit" class="u-button">Valider</button>
        </div>
    </form>
</div>