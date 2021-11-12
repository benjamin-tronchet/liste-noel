<?php include 'includes/inc_header.php'; ?>
<div class="login">
    <div class="login_wrapper">
        <div class="form login_form">
            <section class="login_content">
                    <div class="wrapper-logo">
                        <img class="login-image" src="<?php echo $config_site_srcimg; ?>" alt="">
                    </div>
                    <h1 class="login-title"><?php echo $config_site_name; ?></h1>
                <form action="controller/LoginController.php" method="post">
                    <div class="col-xs-12 form-group has-feedback">
                        <input name="email" class="form-control has-feedback-left" placeholder="Identifiant" type="mail" required="">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-xs-12 form-group has-feedback">
                        <input name="pass" type="password" class="form-control has-feedback-left" placeholder="Mot de passe" required="">
                        <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div> 
                        <input class="btn btn-primary" type="submit" value="Se connecter">
                    </div>
                    <div class="clearfix"></div>
                    <div class="separator">
                    <div class="clearfix"></div>
                    <div class="copyright">
                        <p>Une réalisation <a href="http://www.melting-k.fr/" target="_blank">Melting K</a></p>
                    </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
<?php include 'includes/inc_footer.php'; ?>