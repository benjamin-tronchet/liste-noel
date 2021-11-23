<?php include 'includes/header.php'; ?>

<body id="top-page" class="<?php echo $page_name; ?>">
    <div class="c-transition <?php echo $classAnimation; ?>"></div>
    
    <div class="page-background"></div>
    
    <div id="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">
                    <header class="p-header">
                        <h1 class="u-title_medium u-color_secondary-dark">Bienvenue</h1>
                        <h1 class="u-title_big--alt" text="<?=$user->username()?>"><?=$user->username()?></h1>
                    </header> 
                    <section class="dashboard_content">
                        <h2 class="u-title_small">
                            Je souhaite gérer ma liste d'idées
                        </h2>
                        <p>
                            Pour ajouter de nouvelles idées de cadeau, modifier ma liste, rendre un cadeau indisponible...
                            <br><br>
                            <a href="gifts/list/" class="u-button--secondary-dark">
                                <span class="icon-list"></span> Gérer ma liste
                            </a>
                        </p>
                    </section>
                    <section class="dashboard_content">
                        <h2 class="u-title_small">
                            Je souhaite trouver une idée de cadeau
                        </h2>
                        <p>
                            Jeter un oeil aux listes d'envies, et trouver une idée de cadeau qui fera plaisir à coup sûr !
                        </p>
                        <form action="<?=SITE_MAIN_BASE.'liste/view/'?>" onsubmit="return form_checker(event)" method="post" class="c-form">
                            <div class="c-form_field">
                                <label class="c-form_field_label" data-required>Je veux voir la liste de :</label>
                                <div class="c-form_dropdown">
                                    <input type="hidden" value="" data-required="Merci de sélectionner un utilisateur" name="required[id_user]"/>
                                    <button class="c-form_dropdown_btn" type="button">
                                       <span class="text">Choisir une personne dans la liste</span> <span class="icon-caret"></span>
                                    </button>
                                    <ul class="c-form_dropdown_list">
                                <?php
                                    foreach($users_list as $id_user => $user)
                                    {
                                        $user_list = $GiftManager->lists($id_user);
                                        if($id_user !== $_SESSION['user']->id_user() && !empty($user_list))
                                        {
                                ?>
                                        <li data-value="<?=$user->id_user()?>"><?=$user->username()?></li>
                                <?php
                                        }
                                    }
                                ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="c-form_field">
                                <button class="u-button--secondary-dark"><span class="icon-eye"></span>Voir la liste</button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>