<?php
$user = new User(2);// on indique l'id de l'author présent dans ConfigClass.php
$mail_user_mail       = $user->getMail();
$mail_user_pass       = $user->getPass();

$site = new Site();
$mail_site_name       = $site->getName();
$mail_site_mail       = $site->getMail();
$mail_site_domain     = $site->getDomain();
$mail_site_url        = $site->getUrl();

?>