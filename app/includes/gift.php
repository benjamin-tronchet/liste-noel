<div class="gifts_card <?=($gift->booked() && $gift->booked() !== $_SESSION['user']->id_user()) ? "is-booked" : ""?>">
    <?php if($gift->is_featured()):?>
    <span class="gifts_card_featured">
        <img src="img/star.png" alt="Star">
    </span>
<?php endif; ?>
    <div class="gifts_card_img">
    <?php
        if($gift->booked() && $gift->booked() === $_SESSION['user']->id_user())
        {
    ?>
        <div class="gifts_card_img_overlay">
            <p class="gifts_card_img_overlay_text">
                <span class="icon-lock u-color_light"></span>
                <br>
                Tu as bloqué ce cadeau
            </p>
        </div>
    <?php
        }
    ?>
        <img src="<?=($gift->img()) ? $gift->img() : 'img/default_img.jpg'?>" alt="<?=$gift->name()?>">
    </div>
    <div class="gifts_card_text">
        <h2 class="u-title_medium"><?=$gift->name()?></h2>
        <p class="u-text_big u-color_secondary">
            <strong>Ordre de prix : <?=$gift->price()?>€ <br/> Où le trouver : <?=$gift->store()?></strong>
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
        <p class="gifts_card_buttons">
    <?php
        if(!$gift->booked())
        {
    ?>
            <button class="u-button--secondary-dark" data-panel="lock-gift" data-post="name=<?=$gift->name()?>&id=<?=$gift->id_gift()?>&id_user=<?=$gift->id_user()?>"><span class="icon-lock"></span> Bloquer ce cadeau</button>
    <?php
        }
        elseif($gift->booked() === $_SESSION['user']->id_user())
        {
    ?>
            <button class="u-button--primary" data-panel="unlock-gift" data-post="name=<?=$gift->name()?>&id=<?=$gift->id_gift()?>&id_user=<?=$user->id_user()?>"><span class="icon-cancel"></span> Débloquer</button>
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
    <div class="gifts_card_overlay">
        <span class="icon-lock u-color_light"></span>
        <p class="u-title_medium u-color_light gifts_card_overlay_text">
            Ce cadeau est déjà réservé !
        </p>
    </div>
    <?php
        }
    ?>
</div>