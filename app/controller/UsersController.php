<?php

// *** Instanciation des classes

$UserManager = new UserManager(DB_USERS);

//***********************************************
// Création d'un utilisateur dans la database
//***********************************************

function create_user(UserManager $manager, Tools $tools, FormTools $form_tools) 
{
    $form_data = $form_tools->check_form_fields($_POST,$_FILES);
    
    if($form_data)
    {
        // Création de l'objet User
        $new_user = new User($form_data);

        // Création de l'objet User et hashage du mot de passe
        $new_user->hash();
        $new_user->generate_slug();
        $new_user->generate_token();

        // Création de l'utilisateur en BDD 
        $create = $manager->create($new_user);
        
        if(!$create) {
            
            $_SESSION['notif'] = (object) [
                "type"      => "error",
                "title"     => "Erreur",
                "message"   => "Cet email / nom d'utilisateur est déjà utilisé"
            ];
            
            $tools->redirect('identification/');
        }
        
        // Connexion de l'utilisateur
        $manager->logIn($new_user->email(), $form_data['password']);
        
        $_SESSION['notif'] = (object) [
            "type"      => "success",
            "title"     => "Bienvenue $new_user->username()",
            "message"   => "Ton compte a bien été créé.<br/><br/>Tu es maintenant connecté"
        ];

        $tools->redirect('dashboard/');
    }
    else 
    {
        // Un ou plusieurs champ(s) ne correspond(ent) pas au(x) format(s) attendu(s)
        $tools->redirect('identification/?info=wrong_format');
    }
}

//***********************************************
// Update d'un utilisateur dans la database
//***********************************************

function update_user(UserManager $manager, Tools $tools, FormTools $form_tools) 
{
    $current_user = $_SESSION['user'];
    
    $form_data = $form_tools->check_form_fields($_POST,$_FILES);
    
    if($form_data)
    {
        $current_user = $_SESSION['user'];
        
        $current_user->setEmail($form_data['email']);
        $current_user->setUsername($form_data['username']);
        $current_user->setId_user($tools->createSlug($current_user->username()));
        $current_user->setImg($form_data['img']);
        
        $manager->update($current_user);
        
        $_SESSION['notif'] = (object) [
            "type"      => "success",
            "title"     => "Profil modifié",
            "message"   => "Tes informations ont bien été mises à jour."
        ];

        $tools->redirect('dashboard/');
    }
    else
    {
        $_SESSION['notif'] = (object) [
            "type"      => "error",
            "title"     => "Erreur",
            "message"   => "Le format des données que tu as entré n'est pas bon"
        ];

        $tools->redirect('dashboard/');
    }
}

//***********************************************
// Mot de passe oublié
//***********************************************

function forget_password(UserManager $manager, Tools $tools, FormTools $form_tools) 
{
    $form_data = $form_tools->check_form_fields($_POST);
    $return = [
        "error" => false,
        "message"   => "Tu vas recevoir un email contenant le lien de réinitialisation de ton mot de passe. <br><br><b>Si tu ne le reçois pas, penses à vérifier ton courrier indésirable.</b>"
    ];
    
    if($form_data)
    {
        $user = $manager->get($form_data['email']);
        
        if(!$user)
        {
            $return = [
                "error" => true,
                "message"   => "Cet utilisateur n'existe pas."
            ];
            echo json_encode($return);
            die();
        }
        
        $email_address = $user->email();
        $email_link = SITE_MAIN_BASE.'identification/panel/change-password/'.$user->token();
        $formulaire = $form_data['form'];
        
        include(realpath(__DIR__).'/../form/form-mail-contact.php');
        echo json_encode($return);
        die();
    }
    else 
    {
        // Un ou plusieurs champ(s) ne correspond(ent) pas au(x) format(s) attendu(s)
        $return = [
            "error" => true,
            "message"   => "L'adresse email renseignée n'est pas valide"
        ];
        echo json_encode($return);
        die();
    }
}

//***********************************************
// Réinitialiser le mot de passe
//***********************************************

function reset_password(UserManager $manager, Tools $tools, FormTools $form_tools) 
{
    $form_data = $form_tools->check_form_fields($_POST);
    $user = $manager->get($form_data['token']);
    $password = $form_data['password'];
    $password_confirm = $form_data['password2'];
    
    if($user)
    {
        
        if($password == $password_confirm)
        {
            
            $user->setPassword($password);
            $user->hash();
            $manager->update($user);
            
            // Connexion de l'utilisateur
            $manager->logIn($user->email(), $password);
            
            $_SESSION['notif'] = (object) [
                "type"      => "success",
                "title"     => "Mot de passe modifié",
                "message"   => "Ton mot de passe a bien été modifié.<br>Tu es maintenant connecté."
            ];
            
            $tools->redirect('dashboard/');
        }
        else
        {
            $_SESSION['notif'] = (object) [
                "type"      => "error",
                "title"     => "Erreur",
                "message"   => "Les mots de passe ne correspondent pas."
            ];
            
            $tools->redirect('identification/panel/change-password/'.$form_data['token']);
        } 
    }
    else 
    {   
        $_SESSION['notif'] = (object) [
            "type"      => "error",
            "title"     => "Erreur",
            "message"   => "Utilisateur inconnu."
        ];

        $tools->redirect('identification/');
    }
}

//***********************************************
// Voir la liste des autres utilisateurs
//***********************************************

function users_list(UserManager $manager, Tools $tools)
{
    $users = $manager->lists();
    
    foreach($users as $key => $user)
    {
        if(
            $user->id_user() == $_SESSION['user']->id_user() || 
           !$user->has_common_group($_SESSION['user']->id_user())
        )
        {
            unset($users[$key]);
        }
    }
    
    $santa_text = "Parcours les listes et trouve des idées de cadeaux !";
    include 'views/UsersView_list.php';
}
