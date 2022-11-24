<?php

// *** Instanciation des classes

$GiftManager = new GiftManager(DB_GIFTS);
$UserManager = new UserManager(DB_USERS);

//***********************************************
// Liste des cadeaux
//***********************************************

function lists(GiftManager $manager, UserManager $UserManager, Tools $tools) 
{
    $santa_text = "Astuce :<br/>Tu peux ajouter une nouvelle idée avec le bouton en haut de page";
    
    if(isset($_GET['id']))
    {
        $id_user = $_GET['id'];
        
        if($UserManager->get($id_user))
        {
            if($id_user == $_SESSION['user']->id_user())
            {
                $_SESSION['notif'] = (object) [
                    "type"      => "warning",
                    "title"     => "Bien essayé",
                    "message"   => "Tu n'as pas le droit de voir ta propre liste !<br/>En revanche, tu peux toujours ajouter de nouvelles idées ;)"
                ];
                
                $tools->redirect('gifts/list/');
            }
            else
            {
                if(!in_array($id_user,$_SESSION['has-seen']))
                {
                    $_SESSION['has-seen'][] = $id_user;
                }
                
                $gifts_list = $manager->lists($id_user);
                $user = $UserManager->get($id_user);
                
                $santa_text = $user->username()." a été très sage cette année, alors il est temps d'aligner la moula pour lui faire plaisir !";
                
                include 'views/ListView.php';
            }
        }
        else
        {
            $_SESSION['notif'] = (object) [
                "type"      => "error",
                "title"     => "Erreur",
                "message"   => "Cet utilisateur n'existe pas"
            ];
            
            $tools->redirect('groups/');
        }
    }
    else
    {
        $gifts_list = $manager->lists($_SESSION['user']->id_user());
        include 'views/GiftsView_list.php';
    }
}

//***********************************************
// Edition d'un cadeau
//***********************************************

function edit_gift(GiftManager $manager, Tools $tools, FormTools $form_tools) 
{
    
    $form_data = $form_tools->check_form_fields($_POST,$_FILES);
    
    if($form_data)
    {
        // Création de l'objet Gift
        $new_gift = new Gift($form_data);
        
        // Création ou Modification ?
        $creation = ($new_gift->id_gift()) ? false : true;

        // Case : création d'un nouveau gift
        if($creation)
        {   
            // Enregistrement du cadeau
            $manager->create($new_gift);
            
            // Redirection avec notification
            $_SESSION['notif'] = (object) [
                "type"      => "success",
                "title"     => "Élément ajouté !",
                "message"   => "Cette nouvelle idée vient d'être ajoutée à ta liste"
            ];

            $tools->redirect('gifts/list/');
        }

        // Case : update d'un gift existant
        else
        {
            $manager->update($new_gift);
            
            $_SESSION['notif'] = (object) [
                "type"      => "success",
                "title"     => "Élément modifié !",
                "message"   => "Ton idée de cadeau a bien été modifiée"
            ];
            
            $tools->redirect('gifts/list/');
        }
    }
    else
    {
        $_SESSION['notif'] = (object) [
            "type"      => "error",
            "title"     => "Erreur",
            "message"   => "Un des champs renseignés contient des erreurs"
        ];

        $tools->redirect('gifts/list/');
    }
}

//***********************************************
// Suppression d'un cadeau dans la base de données
//***********************************************

function delete_gift(GiftManager $manager, Tools $tools) 
{
   
    $manager->delete($_POST['id_gift']);
    
    $_SESSION['notif'] = (object) [
        "type"      => "success",
        "title"     => "Cadeau supprimé",
        "message"   => "Ce cadeau a été supprimé de ta liste"
    ];

    $tools->redirect('gifts/list/');
}

//***********************************************
// Blocage d'un cadeau par un utilisateur
//***********************************************

function lock_gift(GiftManager $manager, Tools $tools) 
{
    if(!empty($_POST['id_gift']) && !empty($_POST['id_user']) && !empty($_POST['id_locker']))
    {
        $id_gift = $_POST['id_gift'];
        $id_user = $_POST['id_user'];
        $id_locker = $_POST['id_locker'];
        
        $gift = $manager->get($id_gift,$id_user);
        
        if(!$gift)
        {
            $_SESSION['notif'] = (object) [
                "type"      => "error",
                "title"     => "Erreur",
                "message"   => "Le cadeau que tu veux réserver n'existe pas."
            ];

            $tools->redirect('gifts/list/'.$id_user.'/');
            die();
        }
        
        if($gift->lock($id_locker))
        {
            $_SESSION['notif'] = (object) [
                "type"      => "success",
                "title"     => "Réservé",
                "message"   => "Ce cadeau a bien été réservé.<br/>Il est maintenant indisponible pour les autres utilisateurs."
            ];

            $tools->redirect('gifts/list/'.$id_user.'/');
            die();
        }
        else
        {
            $_SESSION['notif'] = (object) [
                "type"      => "error",
                "title"     => "Erreur",
                "message"   => "Une erreur est survenue lors de la réservation du cadeau."
            ];

            $tools->redirect('gifts/list/'.$id_user.'/');
            die();
        }
    }
    else
    {
        $_SESSION['notif'] = (object) [
            "type"      => "error",
            "title"     => "Erreur",
            "message"   => "Des informations sont manquantes pour réserver le cadeau."
        ];
    
        $tools->redirect('gifts/list/'.$id_user.'/');
    }
}

//***********************************************
// Débloquage d'un cadeau par un utilisateur
//***********************************************

function unlock_gift(GiftManager $manager, Tools $tools) 
{
    if(!empty($_POST['id_gift']) && !empty($_POST['id_user']) && !empty($_POST['id_locker']))
    {
        $id_gift = $_POST['id_gift'];
        $id_user = $_POST['id_user'];
        $id_locker = $_POST['id_locker'];
        
        $gift = $manager->get($id_gift,$id_user);
        
        if(!$gift)
        {
            $_SESSION['notif'] = (object) [
                "type"      => "error",
                "title"     => "Erreur",
                "message"   => "Le cadeau que tu veux débloquer n'existe pas."
            ];

            $tools->redirect('gifts/list/'.$id_user.'/');
            die();
        }
        
        if($gift->unlock($id_locker))
        {
            $_SESSION['notif'] = (object) [
                "type"      => "success",
                "title"     => "Réservé",
                "message"   => "Ce cadeau a bien été débloqué. <br/>Les autres utilisateurs peuvent à présent le réserver."
            ];

            $tools->redirect('gifts/list/'.$id_user.'/');
            die();
        }
        else
        {
            $_SESSION['notif'] = (object) [
                "type"      => "error",
                "title"     => "Erreur",
                "message"   => "Une erreur est survenue lors du débloquage du cadeau."
            ];

            $tools->redirect('gifts/list/'.$id_user.'/');
            die();
        }
    }
    else
    {
        $_SESSION['notif'] = (object) [
            "type"      => "error",
            "title"     => "Erreur",
            "message"   => "Des informations sont manquantes pour débloquer le cadeau."
        ];
    
        $tools->redirect('gifts/list/'.$id_user.'/');
    }
}

//***********************************************
// Voir la liste de cadeaux d'un utilisateur
//***********************************************

function view_list(GiftManager $manager, UserManager $user_manager, Tools $tools, FormTools $form_tools) 
{
    if(!empty($_GET['id']))
    {
        $id_user = $_GET['id'];
        
        if(!$user_manager->exists($id_user))
        {
            $tools->redirect('dashboard/');
        }
        
        $user = $user_manager->get($id_user);
        $user_list = $manager->lists($id_user);
        $users_list = $user_manager->lists();
        $santa_text = $user->username()." a été très sage cette année, alors il est temps d'aligner les billets pour lui faire plaisir !";
        
        if($id_user === $_SESSION['user']->id_user())
        {
            // Inclusion de la vue
            $days_before_christmas = intval((strtotime("25 December 2022") - time()) / 3600 / 24);
            $santa_text = "Petit malin ! Tu as cru pouvoir me duper ?";
            include 'views/ListView_error.php';
            die();
        }
        
        // Inclusion de la vue
        include 'views/ListView.php';
    }
    else
    {
        $form_data = $form_tools->check_form_fields($_POST);
        
        if($form_data) {
            
            $tools->redirect('liste/view/'.$form_data['id_user'].'/');
            
        }
        else 
        {
            $tools->redirect('dashboard/');
        }
    }
}