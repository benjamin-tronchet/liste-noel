<?php include 'includes/header.php'; ?>

<body id="top-page" class="<?php echo $page_name; ?>">
    <div class="c-transition <?php echo $classAnimation; ?>"></div>
    
    <div class="page-background"></div>
    
    <div id="wrapper">
        <div class="p-header_fixed--alt">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-10 col-md-offset-1 col-xl-8 col-xl-offset-2">
                        <header class="p-header u-text_center">
                            <?php include 'includes/nav.php'; ?>
                            <h1 class="u-title_medium u-text_center">Et alors ?</h1>
                            <h1 class="u-title_big--alt u-text_center" text="On tente de tricher ?">On tente de tricher ?</h1>
                        </header> 
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-10 col-md-offset-1 col-xl-8 col-xl-offset-2">
                    <section class="liste_giftlist">
                        <p class="u-text_big u-text_center">
                            <em>
                                La curiosité est un vilain défaut !
                                <br><br>
                                Heureusement, le Père Noël a pensé à tout ! Tu n'as pas le droit d'accéder à ta liste de cadeaux, sinon, ça serait trop facile de voir ce que le père Noël va t'apporter.
                            </em>
                            <br><br>
                            <strong class="u-text_big">
                                Encore un peu de patience ! <br/>
                                Il reste <span class="u-color_secondary-dark"><?=$days_before_christmas?> jours</span> avant Noël !
                            </strong>
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </div>
    
    
<?php include 'includes/footer.php'; ?>