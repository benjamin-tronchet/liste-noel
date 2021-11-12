<?php 
include 'includes/inc_header.php';
include 'includes/inc_main_sidebar.php';
include 'includes/inc_main_topbar.php';
?>
<!-- start content  -->
<div class="row actualites">
    <div class="col-xs-12">
        <div class="page-title">
            <div class="title_left">
                <h3>Vos actualités</h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right text-right"> 
                    <a href="index.php?page=actualite&amp;creer=nouveau" class="btn btn-success">Ajouter nouveau</a>
                </div>
            </div>
        </div>
        <!-- end header -->
        <div class="row">
            <!-- start Admin -->
            <div class="col-xs-12">
                <div class="x_panel">
                  <div class="x_content">

                    <!-- start project list -->
                    <table class="table table-striped projects">
                      <thead>
                        <tr>
                          <th style="width:3%">#</th>
                          <th style="width:20%">Date</th>
                          <th style="width:57%">Titre</th>
                          <th style="width: 20%">Édition</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          if(!empty($listeActualites)){
                            rsort($listeActualites);
                            foreach($listeActualites as $value){
                                $actualite_id = $value['id'];
                                $actualite_titre = $value['titre'];
                                $actualite_date = $value['actu_date'];
                        ?>
                        <tr>
                          <td><?php echo $actualite_id; ?></td>
                          <td><?php echo $actualite_date; ?></td>
                          <td>
                              <?php echo $actualite_titre; ?>
                          </td>
                          <td>
                           <form method="post" class="edition">
                                <a href="index.php?page=actualite&amp;id=<?php echo $actualite_id;?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Modifier</a>
                                <button id="<?php echo $actualite_id;?>" class="btn btn-danger btn-xs delete-post" type="button" data-toggle="modal" data-target=".modal-delete"><i class="fa fa-trash-o"></i> Effacer</button>
                            </form>
                          </td>
                        </tr>
                        
                        <?php 
                            }
                          }else{
                              echo '<tr><td></td><td colspan="3"><p><br/>Il n\'y a pas encore de publications</p></td></tr>';
                          }
                        ?>
                      </tbody>
                    </table>
                    <!-- end project list -->

                  </div>
                </div>
            </div>
        </div>
      </div>
</div>

<!-- modal -->
<div class="modal fade modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span> </button>
                <h4 class="modal-title" id="myModalLabel2">EFFACER</h4> </div>
            <div class="modal-body">
                <h4>Supprimer cet élément ?</h4>
                <p>Veuillez comfirmer la suppression de cet élément.</p>
            </div>
            <form class="modal-footer" method="get" action="index.php?page=actualite">
               <input type="hidden" name="page" value="actualite">
               <input id="supprimmer" type="hidden" name="supprimmer" value="4">
                <button type="buton" class="btn btn-primary" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-danger">Confirmer</button>
            </form>
        </div>
    </div>
</div>
<!-- /modal -->

<!-- end content  -->
<?php 
include 'includes/inc_main_bottombar.php'; 
include 'includes/inc_footer.php'; 
?>
