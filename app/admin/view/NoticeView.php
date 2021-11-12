<?php 
include 'includes/inc_header.php';
include 'includes/inc_main_sidebar.php';
include 'includes/inc_main_topbar.php';
?>
<!-- start content  -->
<div class="row notice">
    <div class="col-xs-12">
        <div class="page-title">
            <div class="title_left">
                <h3>Notice</h3> 
            </div>
        </div>
        <!-- end header -->
        <div class="row">
            <!-- start Admin -->
            <div class="col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                       <blockquote>
                            <p>Retrouvez dans cette page toutes les informations relatives à l'utilisation de votre site internet. <br> En cas de problème rencontré sur le fonctionnement de votre site, vous pouvez nous contacter au <strong>05 61 55 12 11</strong>.
                            </p>
                        </blockquote>
                        <br>
                        <h2>Adresse du site internet</h2>
                        <p>Votre site est accessible depuis l'url suivante : <strong><a href="<?php echo $config_site_url; ?>" target="_blank"><?php echo $config_site_domain; ?></a></strong></p>
                        <br>
                        <h2>Administration des contenus</h2>
                        <p>
                            Pour pouvoir modifier ou créer de nouvelles actualités, cliquez sur le lien <strong><a href="index.php?page=actualites"> <i class="fa fa-file-text"></i> Actualités</a></strong> dans le menu situé a gauche de l'écran.
                            <br>
                            Une fois votre contenu créé ou modifié, cliquez sur <span class="btn btn-success btn-xs record">Enregister</span> - en haut, à droite - pour que la modification soit effective sur votre site.
                            <br/><br/>
                            <b>ATTENTION :</b> les champs suivants sont obligatoires lors de l'ajout d'une nouvelle actualité :<br/>
                            Titre / Description / Image.
                            <br><br>
                        </p>
                        <br>
                        <h2>Infos utiles</h2>
                        <p>
                        - Déconnectez vous en cliquant sur <strong><i class="fa fa-user"></i> <?php echo $config_user_fullname; ?> </strong> dans la barre du haut puis sur <strong>Déconnection <i class="fa fa-sign-out"></i></strong>.
                        <br>
                        - Accédez directement à la page d'accueil de votre site en cliquant sur <strong><i class="fa fa-desktop"></i> Voir site</strong> dans la barre du haut.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end content  -->
<?php 
include 'includes/inc_main_bottombar.php'; 
include 'includes/inc_footer.php'; 
?>