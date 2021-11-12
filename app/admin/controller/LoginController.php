<?php
session_start();

// Traitement d'un cas de connection
$formEmail = $formPass = $user = $userId = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && isset($_POST['pass'])){

        // formatage des données
        $formEmail = test_input($_POST['email']);
        $formPass = test_input($_POST['pass']);
        //$pass = md5(htmlspecialchars($_POST['mdp']));

        include_once '../class/UserClass.php';
        $user = new User(null);
        $userId = $user::matchMail($formEmail);


        if($userId) {
            $user = new User($userId);
            $userMail = $user->getMail();
            $userPass = $user->getPass();  

            if(($userMail === $formEmail) && ($userPass === $formPass)){

                // on récupère les données de l'utilisateur
                $userFirstname  = $user->getFirstName();
                $userName       = $user->getName();
                $userRole       = $user->getRole();

                // on stocke l'id de l'utilisateur dans la session
                $_SESSION['user']['id']   = $userId;
                $_SESSION['user']['name'] = $userFirstname." ".$userName;
                $_SESSION['user']['mail'] = $userMail;
                $_SESSION['user']['role'] = $userRole;

               header('Location:../index.php?msgsystem=success_logged');

            } else { // if not match user

                header('Location:../index.php?msgsystem=warning_connexion');
            }
        } else { // if $key false

            header('Location:../index.php?msgsystem=error_unknowuser');
        }
    } else { // if not isset

        header('Location:../index.php?msgsystem=error_mustlogged');
    }
    
} else { // if not post

        header('Location:../index.php?msgsystem=error_mustlogged');
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>