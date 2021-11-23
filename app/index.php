<?php 

// Include the Main Controller
include 'controller/MainController.php';

// ========================================================
// Routeur : Page Name
// ========================================================

switch($page_name)
{
    // ========================================================
    // Gestion du login
    // ========================================================

    case 'identification':
        include 'controller/LoginController.php';

        switch($action_name)
        {
            // Login d'un utilisateur 
            case 'login':
                login($UserManager, $tools, $form_tools);
            break;
                
            // Login d'un utilisateur 
            case 'logout':
                logout($UserManager, $tools);
            break;

            // Par défaut : affichage du formulaire de login
            default:
                identification($tools, $UserManager);
        }
    break; 

    // ========================================================
    // Gestion des utilisateurs
    // ========================================================

    case 'user':
        include 'controller/UsersController.php';
        switch($action_name)
        {       
            // Création d'un utilisateur
            case 'create':
                create_user($UserManager, $tools, $form_tools);
            break;
        }
    break;

    // ========================================================
    // Affichage du dashboard
    // ========================================================

    case 'dashboard':
        include 'controller/UsersController.php';
        $GiftManager = new GiftManager(DB_GIFTS);
        $users_list = $UserManager->lists();
        $santa_text = "Que souhaites-tu faire, mon enfant ?";
        $user = $_SESSION['user'];
        include 'views/DashboardView.php';
    break;  

    // ========================================================
    // Gestion des cadeaux
    // ========================================================

    case 'gifts':
        include 'controller/GiftsController.php';
        switch($action_name)
        {       
            // Affiche la liste des cadeaux
            case 'list':
                lists($GiftManager, $tools, $form_tools);
            break;
                
            // Création d'un cadeau
            case 'create':
                create_gift();
            break;
                
            // Ajout d'un cadeau en base de données
            case 'add':
                update_gift($GiftManager, $tools, $form_tools, true);
            break;
                
            // Ajout d'un cadeau en base de données
            case 'update':
                update_gift($GiftManager, $tools, $form_tools, false);
            break;
                
            // Ajout d'un cadeau en base de données
            case 'edit':
                edit_gift($GiftManager, $tools);
            break;
                
            // Supprime un cadeau
            case 'delete':
                delete_gift($GiftManager, $tools, $form_tools);
            break;
                
            // Bloque un cadeau
            case 'block':
                block_gift($GiftManager, $tools);
            break;
                
            // Bloque un cadeau
            case 'unblock':
                unblock_gift($GiftManager, $tools);
            break;
        }
    break;  
    
    // ========================================================
    // Affichage d'une liste
    // ========================================================

    case 'liste':
        include 'controller/GiftsController.php';
        switch($action_name)
        {       
            // Création d'un utilisateur
            case 'view':
                view_list($GiftManager, $UserManager, $tools, $form_tools);
            break;
        }
    break;  

    // ========================================================
    // Default page : afficher la notice
    // ========================================================

    default:
        $tools->redirect('dashboard/');
    break;
}

?>