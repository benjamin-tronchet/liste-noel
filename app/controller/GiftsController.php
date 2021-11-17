<?php

// *** Instanciation des classes

$GiftManager = new GiftManager(DB_GIFTS);
$UserManager = new UserManager(DB_USERS);

//***********************************************
// Liste des cadeaux
//***********************************************

function lists(GiftManager $manager) 
{
    $gifts_list = $manager->lists($_SESSION['user']->id_user());
    
    $santa_text = "Astuce :<br/>Tu peux ajouter une nouvelle idée avec le bouton en haut à droite";
    include 'views/GiftsView_list.php';
}

//***********************************************
// Création d'un cadeau
//***********************************************

function create_gift() 
{
    // Tentative de récupération de la session temporaire, si existante
    if(!empty($_SESSION['temp_data']))
    {
        $gift = new Gift($_SESSION['temp_data']);
    }
    // Sinon, création de l'objet vide
    else
    {
        $gift = new Gift([]);
    }
    
    // Définition des actions et variables utiles
    $action = "add/";
    $page_title = "Ajouter un cadeau";
    $santa_text = "Astuce :<br/>Les champs indiqués en rouge sont obligatoires, pense à les remplir !";
    
    // Inclusion de la vue
    include 'views/GiftsView_edit.php';
}

//***********************************************
// Edition d'un cadeau
//***********************************************

function edit_gift(GiftManager $manager, Tools $tools) 
{
    if(isset($_GET['id']))
    {
        $id_gift =  $_GET['id'];
        if($manager->exists($id_gift))
        {
            $gift = $manager->get($id_gift);
            
            if(!empty($_SESSION['temp_data']))
            {
                $gift = new Gift($_SESSION['temp_data']);
            }
    
            // Définition des actions et variables utiles
            $action = "update/".$id_gift.'/';
            $page_title = "Modifier un cadeau";
            $santa_text = "Astuce :<br/>Les champs indiqués en rouge sont obligatoires, pense à les remplir !";
            $_SESSION['edit_gift'] = $id_gift;

            // Inclusion de la vue
            include 'views/GiftsView_edit.php';
        }
        else
        {
            $tools->redirect('gifts/list/');
        }
    }
    else
    {
        $tools->redirect('gifts/list/');
    }
}

//***********************************************
// Ajout / modification d'un cadeau en base de données
//***********************************************

function update_gift(GiftManager $manager, Tools $tools, FormTools $form_tools, $creation) 
{
    // Création de l'URL de redirection en cas d'erreur
    if($creation)
    {
        $url_redirect = 'gifts/create/';
    }
    else 
    {
        $url_redirect = 'gifts/edit/'.$_GET['id'];
    }
    
    $form_data = $form_tools->check_form_fields($_POST,$_FILES);
    
    if($form_data)
    {
        // Création de l'objet Article
        $new_gift = new Gift($form_data);

        // Création et assignation du slug en ID
        $new_gift->setId_gift($tools->createSlug($new_gift->name()));

        // Case : création d'un nouveau gift
        if($creation)
        {   
            // Création du gift en BDD et renvoi vers la page de succès
            if(!$manager->exists($new_gift->id_gift()))
            {
                $manager->create($new_gift);
                $tools->redirect('gifts/list/');
            }
            else
            {
                $_SESSION['temp_data'] = $form_data;
                $tools->redirect($url_redirect.'?info=duplicate');
            }
        }

        // Case : update d'un gift existante
        else
        {
            // On vérifie que l'ID transmis est correct et que le gift existe
            if(
                !empty($_GET['id']) &&
                !empty($_SESSION['edit_gift']) && 
                $_SESSION['edit_gift'] === $_GET['id']
            )
            {
                // Stockage de l'ID transmis et destruction de la session
                $id = $_GET['id'];
                unset($_SESSION['edit_gift']);

                $new_gift->setId_gift($id);

                $manager->update($new_gift);
                $tools->redirect('gifts/list/');
            }
            else
            {
                $tools->redirect('gifts/list/');
            }
        }
    }
    else
    {
        // Un ou plusieurs champ(s) ne correspond(ent) pas au(x) format(s) attendu(s)
        $tools->redirect($url_redirect.'?info=wrong_format');
    }
}

//***********************************************
// Suppression d'un cadeau dans la base de données
//***********************************************

function delete_gift(GiftManager $manager, Tools $tools) 
{
    if(!empty($_GET['id']))
    {
        $manager->delete($_GET['id']);
        $tools->redirect('gifts/list/');
    }
    else
    {
        $tools->redirect('gifts/list/');
    }
}

//***********************************************
// Blocage d'un cadeau par un utilisateur
//***********************************************

function block_gift(GiftManager $manager, Tools $tools) 
{
    if(!empty($_POST['id_gift']) && !empty($_POST['id_user']))
    {
        $id_gift = $_POST['id_gift'];
        $id_user = $_POST['id_user'];
        
        $user_list = $manager->lists($id_user);
        $gift = $user_list[$id_gift];
        
        $gift->setBooked($_SESSION['user']->id_user());
        
        $manager->update($gift,$id_user);
        
        $tools->redirect('liste/view/'.$id_user.'/');
    }
    else
    {
        $tools->redirect('dashboard/');
    }
}

//***********************************************
// Déblocage d'un cadeau par un utilisateur
//***********************************************

function unblock_gift(GiftManager $manager, Tools $tools) 
{
    if(!empty($_POST['id_gift']) && !empty($_POST['id_user']))
    {
        $id_gift = $_POST['id_gift'];
        $id_user = $_POST['id_user'];
        
        $user_list = $manager->lists($id_user);
        $gift = $user_list[$id_gift];
        
        if($gift->booked() === $_SESSION['user']->id_user())
        {
            $gift->setBooked('0');
            $manager->update($gift,$id_user);
            $tools->redirect('liste/view/'.$id_user.'/');
        }
    }
    else
    {
        $tools->redirect('dashboard/');
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
            $days_before_christmas = intval((strtotime("25 December 2021") - time()) / 3600 / 24);
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