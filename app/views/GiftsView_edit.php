<?php include 'includes/header.php'; ?>

<body id="top-page" class="<?php echo $page_name; ?>">
    <div class="c-transition <?php echo $classAnimation; ?>"></div>
    
    <div class="page-background"></div>
    
    <div id="wrapper">
        <div class="p-header_fixed">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-xl-8 col-xl-offset-2">
                        <header class="p-header u-text_right">
                            <?php include 'includes/nav.php'; ?>
                            <h1 class="u-title_medium"><?=$page_title?></h1>
                            <a href="gifts/list/" class="u-button--primary p-header_button"><span class="icon-cancel"></span> Annuler</a>
                        </header> 
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-xl-8 col-xl-offset-2">
                    <section class="gifts_form">
                        <form action="<?=SITE_MAIN_BASE.'gifts/'.$action?>" method="post" class="c-form" onsubmit="return form_checker(event)" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-0 c-form_col">
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
                                </div>
                                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-0 c-form_col">
                                    <div class="c-form_field">
                                        <label class="c-form_field_label">On peut en savoir un peu plus ?</label>
                                        <textarea name="desc" placeholder="Donnez un maximum de détails pour ne pas que l'on se trompe : taille (pour les vêtements), pointure (pour les chaussures), coloris, marque, modèle exact, précisez si c'est un cadeau groupé (pour les couples) etc."><?=$gift->desc()?></textarea>
                                    </div>
                                    <div class="c-form_field">
                                        <label class="c-form_field_label">On peut l'acheter en ligne ?</label>
                                        <input name="url[url_shop]" placeholder="Copier / coller le lien vers le site marchand" type="text" value="<?=$gift->url_shop()?>">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-12 col-md-offset-0 c-form_col--full">
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
                                        <button class="u-button--secondary-dark"><span class="icon-check"></span> Enregistrer</button>
                                        <a href="gifts/list/" class="u-button--primary"><span class="icon-cancel"></span> Annuler</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>