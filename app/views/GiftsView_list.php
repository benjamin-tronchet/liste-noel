<?php include 'includes/header.php'; ?>

<body id="top-page" class="<?php echo $page_name; ?>">
    <div class="c-transition <?php echo $classAnimation; ?>"></div>
    
    <div class="page-background"></div>
    
    <?php
        include 'includes/nav.php';
    ?>
    <div id="wrapper"> 
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-10 col-md-offset-1 col-xl-8 col-xl-offset-2">
                    <header class="p-header">
                        <h1 class="u-title_medium u-color_secondary-dark">Gérer ma</h1>
                        <h1 class="u-title_big--alt" text="liste de cadeaux">liste de cadeaux</h1>
                    </header>
                    <section class="gifts_list">
                        <p class="gifts_list_add">
                            <button class="u-button--primary" data-panel="edit-gift"><span class="icon-gift"></span> Ajouter une idée</button>
                        </p>
                        <h2 class="gifts_list_title u-title_medium">
                            Mes idées :
                        </h2>
                <?php
                    if(empty($gifts_list))
                    {
                ?>
                        <p class="u-text_big u-text_center" style="width:100%">
                            <em>
                                Il n'y a aucune idée de cadeau sur ta liste pour le moment.
                            </em>
                        </p>
                <?php
                    }
                    else
                    {
                        foreach($gifts_list as $gift)
                        {
                ?>
                        <div class="gifts_list_item">
                        <?php if($gift->is_featured()):?>
                            <span class="gifts_list_item_featured">
                                <img src="img/star.png" alt="Star">
                            </span>
                        <?php endif; ?>
                            <div class="gifts_list_item_img">
                                <p class="gifts_list_item_img_wrapper">
                                    <img src="<?=$gift->img()?>" alt="<?=$gift->name()?>">
                                </p>
                            </div>
                            <p class="gifts_list_item_text">
                                <strong class="gifts_list_item_title"><?=$gift->name()?></strong>
                                <br>
                                <span class="gifts_list_item_price">
                                    Ordre de prix : <?=$gift->price()?>€
                                </span>
                            </p>
                            <p class="gifts_list_item_buttons">
                                <button class="u-button--primary" data-panel="edit-gift" data-post="id_gift=<?=$gift->id_gift()?>"><span class="icon-pen"></span> Modifier</button>
                                <button class="u-button--secondary-dark" data-panel="delete-gift" data-post="name=<?=$gift->name()?>&id=<?=$gift->id_gift()?>"><span class="icon-trash"></span> Supprimer</button>
                            </p>
                        </div>
                <?php
                        }
                    }
                ?>
                    </section>
                </div>
            </div>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>