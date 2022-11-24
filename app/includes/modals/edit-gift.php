<?php
    include realpath(__DIR__).'/../../controller/MainController.php';
    $manager = new GiftManager(DB_GIFTS);
    
    if(isset($_POST['id_gift']))
    {
        $gift = $manager->get($_POST['id_gift'],$_SESSION['user']->id_user());
        $title = "Modifier ce cadeau";
    }
    else
    {
        $default = [
            "publish" => time(),
            "id_user" => $_SESSION['user']->id_user()
        ];
        $gift = new Gift($default);
        $title = "Ajouter une idée de cadeau";
    }

?>
<div class="u-panel_content">
    <header class="u-panel_header">
        <p class="u-title_small">
            <?=$title?>
        </p>
    </header>
    <form action="<?=SITE_MAIN_BASE.'gifts/edit/'?>" method="POST" class="c-form" is-checked enctype="multipart/form-data">
        <input type="hidden" name="id_gift" value="<?=$gift->id_gift()?>">
        <input type="hidden" name="id_user" value="<?=$gift->id_user()?>">
        <input type="hidden" name="publish" value="<?=$gift->publish()?>">
        <input type="hidden" name="booked" value="<?=$gift->booked()?>">
        
        <div class="c-form_field">
            <label class="c-form_field_label" data-required>Comment ça s'appelle ?</label>
            <input name="required[name]" data-required="Il faut donner un nom à ce cadeau !" placeholder="Console PS4, Tee-shirt, Camion de pompier Pat'patrouille …" type="text" value="<?=$gift->name()?>">
        </div>
        
        <div class="c-form_field--price">
            <label class="c-form_field_label" data-required>Combien ça coûte ?</label>
            <input name="required[price]" data-required="Il me faut un prix !" placeholder="Prix / gamme de prix : 120 - 40 à 70 ..." type="text" value="<?=$gift->price()?>">
        </div>
        
        <div class="c-form_field">
            <label class="c-form_field_label" data-required>Où est-ce qu'on peut le trouver ?</label>
            <input name="required[store]" data-required="Il faut me dire où on peut le trouver !" placeholder="Nom du/des magasins, site internet, nom de l'artisan ..." type="text" value="<?=$gift->store()?>">
        </div>
        <div class="c-form_field">
            <label class="c-form_field_label">On peut en savoir un peu plus ?</label>
            <textarea name="desc" placeholder="Donnez un maximum de détails pour ne pas que l'on se trompe : taille (pour les vêtements), pointure (pour les chaussures), coloris, marque, modèle exact, précisez si c'est un cadeau groupé (pour les couples) etc."><?=$gift->desc()?></textarea>
        </div>
        <div class="c-form_field">
            <label class="c-form_field_label">On peut l'acheter en ligne ?</label>
            <input name="url[url_shop]" placeholder="Copier / coller le lien vers le site marchand" type="text" value="<?=$gift->url_shop()?>">
        </div>
        <div class="c-form_field c-form_file">
            <?php
                $class_img = (!empty($gift->img())) ? "unmasked" : "";
                $input_img = (!empty($gift->img())) ? "<input type='hidden' name='img' value='".$gift->img()."'/>" : "";
            ?>
            <label class="c-form_field_label">On peut voir à quoi ça ressemble ?</label>
            <div class="c-form_file_content"> 
                <input name="image_normal[img]" type="file" id="img" accept=".jpg,.jpeg,.png">
                <div class="c-form_file_image <?=$class_img?>">
                    <img src="<?=$gift->img()?>" alt="">
                    <?=$input_img?>
                </div>
                <label class="u-button--primary trigger" for="img">
                    <span class="icon-upload"></span>Choisir une <?=($action_name=='edit') ? "autre" : ""?> image
                </label>
            </div>

        </div>
        <div class="c-form_spacer"></div>
        <div class="c-form_field">
            <h2 class="u-title_small">C'est terminé ?</h2>
        </div>
        <div class="c-form_field--button">
            <button class="u-button--primary" type="submit"><span class="icon-check"></span> Enregistrer</button>
            <button data-close-panel class="u-button--secondary-dark" type="button"><span class="icon-cancel"></span> Annuler</button>
        </div>
    </form>
</div>