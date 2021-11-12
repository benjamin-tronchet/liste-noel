<?php 
include 'includes/inc_header.php';
include 'includes/inc_main_sidebar.php';
include 'includes/inc_main_topbar.php';
if(isset($_GET['creer']) && $_GET['creer'] == 'nouveau') {
    $action = 'creer';
} else {
    $action = 'modifier';
}
?>
<!-- start content  -->
<div class="row offre">
    <form enctype="multipart/form-data" id="enregistrer-offre" action="index.php?page=actualite&id=<?php echo $actualite_id?>" method="post" class="col-xs-12">
        <div class="page-title">
            <div class="title_left">
                <h3>Actualité n°<?php echo $actualite_id?></h3> 
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right text-right"> 
                   <a href="<?php echo $_SERVER["PHP_SELF"];?>?page=actualites" class="btn btn-danger">Annuler</a>
                    <button type="submit" name="choix" value="<?php echo $action; ?>" class="btn btn-success">Enregistrer</button>
                    <input type="text" id="configForm" class="hidden" name="configForm" value="ok" />
                </div>
            </div>
        </div>
        <!-- end header -->
        <div class="row">
            <!-- start Admin -->
            <div class="col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <!-- start content-->
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                   <label>Titre * :</label>
                                    <input class="form-control" placeholder="Entrez le titre de l'actualité :" type="text" value="<?php echo $actualite_titre ?>" name="titre" required>
                                </div>
                            </div>
                            <div class="col-sm-5 col-sm-offset-1">
                                <div class="form-group">
                                    <label>Image * :</label>
                                    <div class="row">
                                        <?php if($actualite_img){ ?>                             
                                        <div class="col-md-6">
                                           <img src="<?php echo $actualite_img; ?>" width="400" heigt="400" class="img-responsive" alt="">
                                           <br/>
                                           OU
                                           <br/>
                                        </div>
                                        <?php } 
                                            if($msgIMG) {  ?> 
                                        <div class="col-md-6">
                                          <?php echo $msgIMG; ?> 
                                        </div>
                                        <?php } ?> 
                                        <div class="col-md-12 uploadfile">
                                            <label for="fileToUpload" class="label-file btn btn-info">Choisir une image</label>
                                            <input id="fileToUpload" class="input-file" type="file" name="img">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>Description * :</label><br/>
                                    <textarea id="wysiwig" name="desc" class="form-control" placeholder="Description de l'actualité :"><?php echo $actualite_desc; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </form>
</div>
<!-- end content  -->
<?php 
include 'includes/inc_main_bottombar.php'; 
include 'includes/inc_footer.php'; 
?>