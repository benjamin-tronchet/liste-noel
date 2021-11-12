<?php 
session_start();
if(!empty($_SESSION) && $_SESSION['user']['id']) {
    if($_SESSION['user']['role'] === 'admin') {
        include_once '../class/ConfigClass.php';
        include_once '../class/UserClass.php';
        include_once '../class/SiteClass.php';
        include '../model/MailModel.php';
    }
};

header('Content-Type: text/html; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $emailtoArray = [];
    
    // OBJECT ********************************************
    if (empty($_POST["email_object"])) {
        $email_object = '';
    } else {
        $email_object = test_input($_POST["email_object"]); 
    }
    
    // EMAIL CUSTOM ********************************************
    if (empty($_POST["email_custom"])) {
        $email_custom = '';
    } else {
        $email_custom = test_input($_POST["email_custom"]);
        array_push($emailtoArray, $email_custom);
    }

    // MAIL STAFF ********************************************
    if (empty($_POST["email_staff"])) {
        $email_staff = '';
    } else {
        $email_staff = $_POST["email_staff"];
        foreach($email_staff as $i => $value){
           array_push($emailtoArray, $value); 
        };
    }

    // MESSAGE ********************************************
    if (empty($_POST["email_message"])) {
        $email_message = '';
    } else {
        $email_message = test_input($_POST["email_message"]); 
    }

    $emailto = implode(',', $emailtoArray);
    
    //var_dump($emailtoArray);
//   echo  $emailto;
//   echo  $email_object;

    // PREPARATION DES DONNEES *******************************
    $ip           = $_SERVER["REMOTE_ADDR"];
    $hostname     = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
    $destinataire = $emailto;
    $objet        = $email_object;
    $contenu      = "Le site " . $mail_site_name . " est en ligne : " . $mail_site_domain . "\r\n\n";
    $contenu     .= "L'administration du site est disponible à l'adresse suivante : " . $mail_site_domain . "/admin" . "\r\n\n";
    $contenu     .= "Identifiant : " . $mail_user_mail ."\r\n";
    $contenu     .= "Mot de passe : " . $mail_user_pass ."\r\n\n";
    $contenu     .= "Le formulaire de contact envoie les mails sur : " . $mail_site_mail ."\r\n\n";
    if($email_message) {
    $contenu     .= $email_message ."\r\n\n";   
    }
    //$contenu     .= "Adresse IP de l'expéditeur : " . $ip . "\r\n";
    //$contenu     .= "DLSAM : " . $hostname;
    //$headers  = "CC: " . $email . " \r\n"; // ici l'expediteur du mail
    $headers = 'From: Administration ' . $mail_site_name .' <' . $mail_site_mail . '>'."\r\n";
    $headers .= "Content-Type: text/plain; charset=\"ISO-8859-1\"; DelSp=\"Yes\"; format=flowed /r/n";
    $headers .= "Content-Disposition: inline \r\n";
    $headers .= "Content-Transfer-Encoding: 7bit \r\n";
    $headers .= "MIME-Version: 1.0";

    // SI LES CHAMPS SONT MAL REMPLIS
    if ( (empty($email_object)) && (empty($emailto)) ) {
        echo 'echec :( <br /><a href="contact-audit-echo-social-media.php">Retour au formulaire</a>';
    } else {
        // ENCAPSULATION DES DONNEES 
        mail($destinataire, $objet, utf8_decode($contenu), $headers);
    }
} // end if method post
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function test_message($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}
?>