<?php 
include 'includes/inc_header.php';
include 'includes/inc_main_sidebar.php';
include 'includes/inc_main_topbar.php';
?>
<!-- start content  -->
<div class="row settings">
    <form id="enregistrer-settings" action="controller/SettingsController.php" method="post" class="col-xs-12" data-parsley-validate>
        <div class="page-title">
            <div class="title_left">
                <h3>Configuration</h3> </div>
            <div class="title_right">
                <div class="col-xs-12 form-group pull-right text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal-mail-config">Config par mail</button>
                    <a href="<?php echo $_SERVER["PHP_SELF"];?>" class="btn btn-danger">Annuler</a>
                    <button type="submit" name="choix" value="modifierrevue" class="btn btn-success">Enregistrer</button>
                    <input type="text" id="configForm" class="hidden" name="configForm" value="ok" />
                </div>
            </div>
        </div>
        <!-- end header -->
        <div class="row">
            <!-- start Admin -->
            <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Aministrateur <small>informations</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                       <!-- start content-->
                        <div class="form-horizontal form-label-left input_mask row">
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="admin_name" name="admin_name" placeholder="Nom" value="<?php echo $setting_admin_name;?>" required="required" readonly="readonly">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span> 
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="admin_firstname" name="admin_firstname" placeholder="Prénom" value="<?php echo $setting_admin_firstname;?>" required="required" readonly="readonly">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <div class="col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="admin_mail" name="admin_mail" placeholder="Email" value="<?php echo $setting_admin_mail;?>" required="required" readonly="readonly">
                                <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <div class="col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="admin_pass" name="admin_pass" placeholder="Mot de passe" value="<?php echo $setting_admin_pass;?>" required="required" readonly="readonly">
                                <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <!-- end content-->
                    </div>
                </div>
            </div>
            <!-- end Admin -->
            <!-- start User -->
            <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Utilisateur <small>informations</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                       <!-- start content-->
                        <div class="form-horizontal form-label-left input_mask row">
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="user_name" name="user_name" placeholder="Nom" value="<?php echo $setting_user_name;?>" required="required">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span> 
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="user_firstname" name="user_firstname" placeholder="Prénom" value="<?php echo $setting_user_firstname;?>" required="required">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <div class="col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="user_mail" name="user_mail" placeholder="Email" value="<?php echo $setting_user_mail;?>" required="required">
                                <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <div class="col-xs-12 form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="user_pass" name="user_pass" placeholder="Mot de passe" value="<?php echo $setting_user_pass;?>" required="required">
                                <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <!-- end content-->
                    </div>
                </div>
            </div>
            <!-- end User -->
        </div>
        <!-- start Site informations -->
        <div class="row">
            <div class="col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Site <small>informations</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <!-- start content-->   
                        <div class="form-horizontal form-label-left">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                                    Nom du site <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="site_name" name="site_name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $setting_site_name;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">
                                    Mail du site <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="site_mail" name="site_mail" required="required" class="form-control col-md-7 col-xs-12" type="mail" placeholder="contact@mon-super-site.com" value="<?php echo $setting_site_mail;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
                                    Nom de domaine du site <span class="required">*</span> 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="site_domain" name="site_domain" required="required" class="form-control col-md-7 col-xs-12" placeholder="mon-super-site.com" value="<?php echo $setting_site_domain;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
                                    Url du site <span class="required">*</span> 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="site_url" name="site_url" required="required" class="form-control col-md-7 col-xs-12" placeholder="http://www.mon-super-site.com/" value="<?php echo $setting_site_url;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="site_srcimg">
                                    Chemin de logo <span class="required">*</span> 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="site_srcimg" name="site_srcimg" required="required" class="form-control col-md-7 col-xs-12" placeholder="../img/mon-image.png" value="<?php echo $setting_site_srcimg;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                 Couleur de fond logo <span class="required">*</span> 
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <select class="form-control" name="site_colorimg">
                                    <option value="#2A3F54" <?php if($setting_site_colorimg == '#2A3F54'){echo 'selected';} ;?> >Bleu initial</option>
                                    <option value="#FFFFFF" <?php if($setting_site_colorimg == '#FFFFFF'){echo 'selected';} ;?>>Blanc</option>
                                    <option value="#243648" <?php if($setting_site_colorimg == '#243648'){echo 'selected';} ;?>>Bleu sombre</option>
                                  </select>
                                </div>
                              </div>
                        </div>
                    <!-- end content--> 
                    </div>
                </div>
            </div>
        </div>
        <!-- end Site informations -->
    </form>
    <!-- end formm -->
    <!-- modal mail config -->
    <div class="modal fade modal-mail-config" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="form-mail-settings" class="modal-content form-horizontal form-label-left" action="controller/MailSettingsController.php" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i></button>
                    <h4 class="modal-title" id="myModalLabel">Envoyer la configuration par email</h4> </div>
                <div class="modal-body">
                   <br>
                   <br>
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-md-2" for="email-object">
                            Objet de l'email<span class="required">*</span> 
                        </label>
                        <div class="col-xs-12 col-md-10">
                            <input type="text" id="email-object" name="email_object" class="form-control col-md-7 col-xs-12" value="[<?php echo $setting_site_name;?>] Mise en ligne">
                            <span id="msg_email-object" class="msg-err"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-md-2" for="mail-custom">
                            Adresse Email 
                        </label>
                        <div class="col-xs-12 col-md-10">
                            <input type="email" id="mail-custom" name="email_custom" class="form-control col-md-7 col-xs-12" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-md-2">
                        </label>
                        <div class="col-xs-12 col-md-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="email_staff[]" class="flat" value="romain@melting-k.fr"> <strong>Romain S.</strong> (romain@melting-k.fr) </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="flat" name="email_staff[]" value="yoan@melting-k.fr"> <strong>Yoan F.</strong> (yoan@melting-k.fr) </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="flat" name="email_staff[]" value="commercial@melting-k.fr"> <strong>Romain P</strong> (commercial@melting-k.fr) </label>
                            </div>
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="control-label col-xs-12 col-md-2" for="email-message">Message</label>
                        <div class="col-xs-12 col-md-10 ">
                            <textarea class="form-control" id="email-message" name="email_message"></textarea>
                        </div>
                    </div>
                   <br>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    <!-- end modal mail config -->
</div>
<!-- end content  -->
<?php 
include 'includes/inc_main_bottombar.php'; 
include 'includes/inc_footer.php'; 
?>