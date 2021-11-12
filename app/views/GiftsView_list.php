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
                            <h1 class="u-title_medium">Gérer ma liste de cadeaux</h1>
                            <a href="gifts/create/" class="u-button--primary p-header_button"><span class="icon-gift"></span> Ajouter une idée</a>
                        </header> 
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-xl-8 col-xl-offset-2">
                    <h2 class="u-title_small">
                        Mes idées de cadeaux :
                    </h2>
                    <section class="gifts_list">
                <?php
                    if(empty($gifts_list))
                    {
                ?>
                        <p class="gifts_list_item">
                            <em>
                                Il n'y a aucun cadeau ajouté à votre liste pour le moment.
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
                            <p class="gifts_list_item_text">
                                <strong><?=$gift->name()?></strong>
                            </p>
                            <p class="gifts_list_item_buttons">
                                <a href="gifts/edit/<?=$gift->id_gift()?>" class="u-button--primary"><span class="icon-pen"></span> Modifier</a>
                                <a href="gifts/delete/<?=$gift->id_gift()?>" class="u-button--secondary-dark" data-modal="delete" data-post="name=<?=$gift->name()?>&id=<?=$gift->id_gift()?>"><span class="icon-trash"></span> Supprimer</a>
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