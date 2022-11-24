<?php
    include realpath(__DIR__).'/../inc_config.php';
?>
<div class="u-panel_content">
    <header class="u-panel_header">
        <p class="u-title_small">
            Mot de passe oublié
        </p>
        <p>
            Indique ton adresse email ci-dessous pour recevoir un lien de réinitialisation de ton mot de passe.
        </p>
    </header>
    <form action="<?=SITE_MAIN_BASE.'user/forget-password/'?>" method="POST" class="c-form" is-checked is-ajax>
        <div class="c-form_field">
            <label class="c-form_field_label" data-required>Ton adresse email :</label>
            <input name="required[mail][email]" data-required="Entre une adresse email" placeholder="email@domain.com" type="email" autocomplete="off" data-verification="user-email-exists">
        </div>
        <div class="c-form_field c-form_submit">
            <input type="hidden" name="form" value="reset-password">
            <button type="submit" class="u-button">Valider</button>
        </div>
    </form>
</div>