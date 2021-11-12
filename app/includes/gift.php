<div class="liste_card">
    <div class="liste_card_img">
    <?php
        if($gift->booked() && $gift->booked() === $_SESSION['user']->id_user())
        {
    ?>
        <div class="liste_card_img_overlay">
            <p class="liste_card_img_overlay_text">
                <span class="icon-lock u-color_light"></span>
                <br>
                Vous avez réservé ce cadeau
            </p>
        </div>
    <?php
        }
    ?>
        <img src="<?=($gift->img()) ? $gift->img() : 'img/default_img.jpg'?>" alt="<?=$gift->name()?>">
    </div>
    <div class="liste_card_text">
        <h2 class="u-title_small"><?=$gift->name()?></h2>
        <p class="u-text_big u-color_secondary">
            <strong>Ordre de prix : <?=$gift->price()?>€ - Où le trouver : <?=$gift->store()?></strong>
        </p>
        
    <?php
        if($gift->desc())
        {
    ?>
        <p>
            <strong>Details :</strong><br/>
            <em><?=nl2br($gift->desc())?></em>
        </p>
    <?php
        }
    ?>
        <p class="liste_card_buttons">
    <?php
        if(!$gift->booked())
        {
    ?>
            <button class="u-button--secondary-dark" data-modal="block" data-post="name=<?=$gift->name()?>&id=<?=$gift->id_gift()?>&id_user=<?=$user->id_user()?>"><span class="icon-lock"></span> Bloquer ce cadeau</button>
    <?php
        }
        elseif($gift->booked() === $_SESSION['user']->id_user())
        {
    ?>
            <button class="u-button--primary" data-modal="unblock" data-post="name=<?=$gift->name()?>&id=<?=$gift->id_gift()?>&id_user=<?=$user->id_user()?>"><span class="icon-cancel"></span> Débloquer</button>
    <?php
        }
             
        if($gift->url_shop())
        {
    ?>
            <a class="u-button--secondary-dark" target="_blank" href="<?=$gift->url_shop()?>"><span class="icon-cart"></span> Acheter en ligne</a>
    <?php
        }
    ?>
        </p>
    </div>
    <?php
        if($gift->booked() && $gift->booked() !== $_SESSION['user']->id_user())
        {
    ?>
    <div class="liste_card_overlay">
        <span class="icon-lock u-color_light"></span>
        <p class="u-title_medium u-color_light liste_card_overlay_text">
            Ce cadeau a déjà été réservé !
        </p>
    </div>
    <?php
        }
    ?>
</div>