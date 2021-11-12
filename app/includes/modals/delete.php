<?php
    include realpath(__DIR__).'/../inc_config.php';
?>
<div class="u-modal_box">
    <button class="u-modal_close" data-close-modal></button>
    <div class="u-modal_content">
        <header class="u-modal_header">
            <p class="u-title_small">
                <span class="icon-warning"></span> ATTENTION !
            </p>
        </header>
        <p class="u-text_center">
            Vous êtes sur le point de supprimer le cadeau suivant de votre liste :
            <br><br>
            <strong class="u-color_secondary u-text_bigger">
                <?=$_POST['name']?>
            </strong>
            <br><br>
            <strong>
                Cette action est irréversible.<br/>
                Êtes-vous sûr de vouloir le supprimer ?
            </strong>
        </p>
        <p class="u-modal_content_buttons">
            <button class="u-button--primary" data-close-modal>
                <span class="icon-cancel"></span> Annuler
            </button>
            <a href="gifts/delete/<?=$_POST['id']?>" class="u-button--secondary-dark">
                <span class="icon-check"></span> SUPPRIMER
            </a>
        </p>
    </div>
</div>