<?php
    include realpath(__DIR__).'/../../controller/MainController.php';
    $user = $_SESSION['user'];
?>
<div class="u-panel_content">
    <header class="u-panel_header">
        <p class="u-title_small">
            <span class="icon-gift"></span> Réserver un cadeau
        </p>
    </header>
    <p>
        Tu es sur le point de réserver le cadeau suivant :
        <br><br>
        <strong class="u-color_secondary u-text_bigger">
            <?=$_POST['name']?>
        </strong>
        <br><br>
        <strong>
            Une fois le cadeau réservé, il sera indisponible pour les autres personnes !
        </strong>
        <br><br>
        <strong>
            On part là dessus ?
        </strong>
    </p>
    <form action="<?=SITE_MAIN_BASE.'gifts/lock/'?>" method="POST" class="c-form" is-checked>
        <div class="c-form_field c-form_submit">
            <input type="hidden" name="id_user" value="<?=$_POST['id_user']?>">
            <input type="hidden" name="id_gift" value="<?=$_POST['id']?>">
            <input type="hidden" name="id_locker" value="<?=$_SESSION['user']->id_user()?>">
            <button class="u-button--primary" type=submit>
                <span class="icon-check"></span> Je réserve !
            </button>
            <button class="u-button--secondary-dark" type="button" data-close-panel>
                <span class="icon-cancel"></span> J'annule
            </button> 
        </div>
    </form>
</div>