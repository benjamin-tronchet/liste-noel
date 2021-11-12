<?php

// on récupère l'id de l'utilisateur stocké en variable de session
$userId = $_SESSION['user']['id'];
    
$user = new User($userId);
$config_user_name       = $user->getName();
$config_user_firstname  = $user->getFirstName();
$config_user_fullname   = $user->getFullName();
$config_user_mail       = $user->getMail();
$config_user_pass       = $user->getPass();
$config_user_role       = $user->getRole();

?>