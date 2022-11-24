<?php

$UserManager = new UserManager(DB_USERS);

// ======================================================== 
// Affichage du formulaire d'identification
// ========================================================

function identification(Tools $tools, UserManager $UserManager) 
{
    // Utilisateur logué ? >> Renvoi vers la page d'accueil
    if(!empty($_SESSION['user'])) 
    {
        $tools->redirect('dashboard/');
    } 
    else
    {
        $santa_text = "Connecte-toi, ou crée un compte si ce n'est pas encore fait !";
        $users_list = $UserManager->lists();
        include 'views/LoginView.php';
    }
}

// ======================================================== 
// Login d'un utilisateur
// ========================================================

function login(UserManager $manager, Tools $tools, FormTools $form_tools) 
{   

    // Vérification que les données correspondent à ce qui est attendu
    $form_data = $form_tools->check_form_fields($_POST); 
    
    if($form_data)  
    {
        // Login de l'utilisateur
        $login = $manager->logIn($form_data['email'],$form_data['password']);
        
        if($login)
        {
            // Login réussi
            $_SESSION['notif'] = (object) [
                "type"      => "success",
                "title"     => "Bienvenue ".$_SESSION['user']->username(),
                "message"   => "Tu es maintenant connecté"
            ];
            
            $tools->redirect('dashboard/');
        }
        else
        {
            // Login échoué
            $_SESSION['notif'] = (object) [
                "type"      => "warning",
                "title"     => "Attention",
                "message"   => "Ton login / mot de passe ne correspond pas."
            ];
            
            $tools->redirect('identification/');
        }
    }
    else
    {
        // Les données transmises ne correspondent pas aux patterns attendus
        $tools->redirect('identification/?info=warning_error-format');
    }
}

// ======================================================== 
// Logout d'un utilisateur
// ========================================================

function logout(UserManager $manager, Tools $tools) 
{   
    // Déconnexion réussie
    $_SESSION['notif'] = (object) [
        "type"      => "success",
        "title"     => "A bientôt ".$_SESSION['user']->username()." !",
        "message"   => "Tu es à présent déconnecté"
    ];
    
    unset($_SESSION['user']);
    unset($_SESSION['has-seen']);
    unset($_SESSION['last_visit']);
    
    $tools->redirect('identification/');
}

?>