<div class="u-modal_box">
    <button class="u-modal_close" data-close-modal></button>
    <div class="u-modal_content">
        <header class="u-modal_header">
            <p class="u-title_small">
                <span class="icon-warning"></span> Débloquer un cadeau
            </p>
        </header>
        <p class="u-text_center">
            Vous êtes sur le point d'annuler votre réservation du cadeau suivant :
            <br><br>
            <strong class="u-color_secondary u-text_bigger">
                <?=$_POST['name']?>
            </strong>
            <br><br>
            <strong>
                Cela signifie donc que le cadeau apparaitra de nouveau comme disponible pour les autres utilisateurs.
            </strong>
            <br><br>
            <strong>
                On est OK là dessus ?
            </strong>
        </p>
        <form action="gifts/unblock/" class="u-modal_content_buttons" method="post">
            <input type="hidden" name="id_user" value="<?=$_POST['id_user']?>">
            <input type="hidden" name="id_gift" value="<?=$_POST['id']?>">
            <button class="u-button--primary" data-close-modal>
                <span class="icon-cancel"></span> J'annule
            </button> 
            <button class="u-button--secondary-dark" type=submit>
                <span class="icon-check"></span> Je confirme !
            </button>
        </form>
    </div>
</div>