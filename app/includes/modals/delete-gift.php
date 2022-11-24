<?php
    include realpath(__DIR__).'/../../controller/MainController.php';
?>
<div class="u-panel_content">
    <header class="u-panel_header">
        <p class="u-title_small">
            Supprimer un cadeau
        </p>
    </header>
    <p>
        Tu es sur le point de supprimer le cadeau suivant de ta liste :
        <br><br>
        <strong class="u-color_secondary u-text_bigger">
            <?=$_POST['name']?>
        </strong>
        <br><br>
        <small><em>Si ce cadeau avait été réservé par quelqu'un, il recevra automatiquement un email pour l'informer que tu as retiré cette idée de ta liste.</em></small>
        <br><br>
        <strong class="u-panel_warning">
            <span class="icon-warning"></span>
            <span>
                Cette action est irréversible.<br/>
                Es-tu sûr de vouloir le supprimer ?
            </span>
        </strong>
    </p>
    <form action="<?=SITE_MAIN_BASE.'gifts/delete/'?>" method="POST" class="c-form" is-checked enctype="multipart/form-data">
        <input type="hidden" name="id_gift" value="<?=$_POST['id']?>">
        <div class="c-form_field c-form_submit">
            <button class="u-button--primary" type="sumbit">
                <span class="icon-check"></span> SUPPRIMER
            </button>
            <button class="u-button--secondary-dark" data-close-panel type="button">
                <span class="icon-cancel"></span> Annuler
            </button>
        </div>
    </form>
</div>