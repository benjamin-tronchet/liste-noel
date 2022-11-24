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
                        <h1 class="u-title_medium u-color_secondary-dark">Bienvenue</h1>
                        <h1 class="u-title_big--alt" text="<?=$user->username()?>"><?=$user->username()?></h1>
                    </header> 
                    <section class="dashboard_content">
                        <h2 class="u-title_small">
                            Que souhaites-tu faire ?
                        </h2>
                        <div class="dashboard_card_wrapper">
                            <div class="dashboard_card">
                                <p class="dashboard_card_head">
                                    GÉRER MA LISTE
                                </p>
                                <b>Gérer ma liste, ajouter de nouvelles idées de cadeaux</b>
                                <br><br>
                                <a href="gifts/list/" class="u-button--secondary-dark dashboard_card_button">
                                    <span class="icon-list"></span> ma liste
                                </a>
                            </div>
                            <div class="dashboard_card">
                                <p class="dashboard_card_head">
                                    TROUVER UNE IDÉE
                                </p>
                                <b>Voir les listes des autres utilisateurs pour trouver une idée</b>
                                <br><br>
                                <a href="users/" class="u-button--secondary-dark dashboard_card_button">
                                    <span class="icon-gift"></span> Trouver une idée
                                </a>
                            </div>
                            <div class="dashboard_card">
                                <p class="dashboard_card_head">
                                    GÉRER MES GROUPES
                                </p>
                                <b>Rejoindre ou quitter un groupe d'utilisateurs</b>
                                <br><br>
                                <a href="groups/" class="u-button--secondary-dark dashboard_card_button">
                                    <span class="icon-groups"></span> Mes groupes
                                </a>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>