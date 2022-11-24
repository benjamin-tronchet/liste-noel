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
                
            // Update d'un utilisateur
            case 'update':
                update_user($UserManager, $tools, $form_tools);
            break;     
                
            // Mot de passe oublié
            case 'forget-password':
                forget_password($UserManager, $tools, $form_tools);
            break;    
                
            // Reset Password
            case 'reset-password':
                reset_password($UserManager, $tools, $form_tools);
            break;
        }
    break;

    // ========================================================
    // Affichage du dashboard
    // ========================================================

    case 'dashboard':
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
                lists($GiftManager, $UserManager, $tools);
            break;
                
            // Ajout d'un cadeau en base de données
            case 'edit':
                edit_gift($GiftManager, $tools, $form_tools);
            break;
                
            // Supprime un cadeau
            case 'delete':
                delete_gift($GiftManager, $tools, $form_tools);
            break;
                
            // Bloque un cadeau
            case 'lock':
                lock_gift($GiftManager, $tools);
            break;
                
            // Bloque un cadeau
            case 'unlock':
                unlock_gift($GiftManager, $tools);
            break;
        }
    break;  

    // ========================================================
    // Gestion des listes d'utilisateurs
    // ========================================================

    case 'users':
        include 'controller/UsersController.php';
        switch($action_name)
        {       
            // Voir la liste des autres utilisateurs
            default:
                users_list($UserManager, $tools);
            break;
        }
    break;  

    // ========================================================
    // Gestion des groupes
    // ========================================================

    case 'groups':
        include 'controller/GroupsController.php';
        switch($action_name)
        {
            case 'edit-user' :
                edit_user($GroupManager, $tools, $form_tools);
                break;
                
            case 'delete-user' :
                delete_user($GroupManager, $tools, $form_tools);
                break;
                
            default :
                lists($GroupManager, $tools, $form_tools);
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