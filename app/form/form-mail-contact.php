<?php

//***************************************************
// DETERMINER LA SOURCE
//***************************************************

$mail_template = file_get_contents(__DIR__.'/template-mail.php');

switch ($formulaire)
{
    case 'reset-password':
        $email_subject = "Réinitialisation du mot de passe";
        $mail_message = "Bonjour 
        <br><br>
        Pour réinitialiser ton mot de passe, clique sur le lien ci-dessous : <br>
        <a href='".$email_link."' target='_blank'>Réinitialiser mon mot de passe</a>
        <br><br>
        <b>Si tu n'es pas à l'origine de cette opération, ignore simplement ce message.</b><br>
        Ton mot de passe restera inchangé.
        ";
        
        $mail_template = str_replace('%%MAIL_MSG%%', $mail_message, $mail_template); 
        
        break;
        
    case 'gift-deleted':
        $email_subject = "Un cadeau que tu avais réservé a été supprimé";
        $mail_message = "Bonjour ".$user_name."
        <br><br>
        Tu as réservé le cadeau \"".$gift_name."\" sur la liste de ".$owner_name."
        <br><br>
        Malheureusement, ".$owner_name." a supprimé ce cadeau de sa liste. Tu devras donc probablement en réserver un nouveau.
        <br/><br/>
        Pour trouver une autre idée de cadeau à lui offir, tu peux cliquer sur le lien suivant : 
        <br/><br/>
        <a href='".$email_link."' target='_blank'>Voir la liste de ".$owner_name."</a>";
        
        $mail_template = str_replace('%%MAIL_MSG%%', $mail_message, $mail_template); 
        
        break;
}

// INITIALISATION DE PHP MAILER

spl_autoload_unregister('chargerClasses');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require realpath(__DIR__).'/../form/phpmailer/PHPMailer.php';
require realpath(__DIR__).'/../form/phpmailer/Exception.php';
require realpath(__DIR__).'/../form/phpmailer/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'mail.mailo.com';
    $mail->SMTPAuth   = true;      
    $mail->Username = 'benjamintronchet@mailo.com';
    $mail->Password = 'b4mz0rus@Mailo';                       
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
    $mail->Port       = 465;   

    $mail->CharSet = 'UTF-8';
    $mail->setFrom('benjamintronchet@mailo.com','Application Noël');
    $mail->addAddress($email_address);
    $mail->Subject = $email_subject;
    $mail->isHTML(true);

    $mail->Body = $mail_template;
    $mail->send();
} catch (Exception $e) {
    $return = [
        "error" => true,
        "message"   => "Une erreur est survenue durant l'envoi du mail : ".$mail->ErrorInfo."<br/><br/>Veuillez réessayer."
    ];
}