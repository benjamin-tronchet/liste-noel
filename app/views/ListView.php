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
                        <h1 class="u-title_medium u-color_secondary-dark">Les idées de</h1>
                        <h1 class="u-title_big--alt" text="<?=$user->username()?>"><?=$user->username()?></h1>
                    </header>
                    <section class="liste_giftlist">
                <?php
                    if(empty($gifts_list))
                    {
                ?>
                        <p class="u-text_big u-text_center">
                            <em>
                                <?=$user->username()?> n'a pas encore renseigné d'idées de cadeaux. <br>
                                Reviens un peu plus tard !
                            </em>
                        </p>
                <?php
                    }
                    else
                    {
                        foreach($gifts_list as $id_gift => $gift)
                        {
                            include 'includes/gift.php';
                        }
                    }
                ?>
                    </section>
                    <section class="liste_form">
                        <h2 class="u-title_medium u-text_center">C'est tout pour <?=$user->username()?> !</h2>
                        <h3 class="u-title_small u-text_center">Mais si tu te sens d'humeur généreuse, tu peux aller faire un tour sur la liste de quelqu'un d'autre et lui trouver un super cadeau !</h3>
                        <p class="u-text_center">
                            <a href="users/" class="u-button--secondary-dark"><span class="icon-gift"></span> Trouver une autre idée</a>
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>