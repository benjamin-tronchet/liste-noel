<?php
    
// ========================================================
// Inclusion des fonctions utiles
// ========================================================

include __DIR__ . "/../utils/fonctions.php";
    
// ========================================================
// Inclusion des constantes
// ========================================================

include_once realpath(__DIR__).'/../includes/inc_config.php';

// ========================================================
// Création de l'autoload pour les classes à utiliser
// ========================================================

function chargerClasses($classname) 
{
    require(realpath(__DIR__ . '/..').'/models/'.$classname.'.php');
}

spl_autoload_register('chargerClasses');

// ========================================================
// Démarrage de la session
// ======================================================== 

session_start();
if(!isset($_SESSION['santa']))
{
    $_SESSION['santa'] = "expand";
}

// ========================================================
// Gestionnaire d'erreurs
// ======================================================== 

$class_modal = '';

if(isset($_GET['info']))
{
    $class_modal = 'active';
    
    switch ($_GET['info'])
    {
        case "success_create_user":
            $modal_title = "<span class='icon-check'></span> Utilisateur créé !";
            $modal_text = "Votre compte utilisateur a été créé avec succès !<br/><br/>Vous pouvez maintenant commencer à éditer votre liste d'idées ou à accéder à celles des autres utilisateurs.";
            break;
            
        case "existing_user":
            $modal_title = "<span class='icon-cancel'></span> Utilisateur existant !";
            $modal_text = "Ce nom a déjà été choisi par un autre utilisateur.<br/><br/>Veuillez re-créer votre compte en choisissant un autre nom d'utilisateur.";
            break;
            
        case "wrong_format":
            $modal_title = "<span class='icon-cancel'></span> Mauvais format";
            $modal_text = "Certaines données entrées dans le formulaire ne respectent pas le format attendu.";
            break;
            
        case "warning_connexion":
            $modal_title = "<span class='icon-cancel'></span> Erreur de connexion";
            $modal_text = "Le mot de passe ne correspond pas à l'utilisateur sélectionné.";
            break;
            
        case "duplicate":
            $modal_title = "<span class='icon-cancel'></span> Création impossible";
            $modal_text = "Un élément de votre liste porte déjà ce nom, veuillez en choisir un différent";
            break;
    }
}

// ========================================================
// On instancie les classes utilitaires
// ======================================================== 

$tools = new Tools();
$form_tools = new FormTools();

// ========================================================
// On récupère les paramètres utiles dans l'URL
// ======================================================== 

// Récupère le nom de page envoyé en GET via l'URL Rewriting
if(!empty($_GET['page'])) 
{
    $page_name = $_GET['page'];
} 
else 
{
    $page_name = '';
}

// Récupère l'action envoyée en GET via l'URL Rewriting
if(!empty($_GET['action'])) 
{
    $action_name = $_GET['action'];
} 
else 
{
    $action_name = '';
}

// ========================================================
// Si l'utilisateur n'est pas logué, 
// on le renvoie sur le formulaire d'authentification
// ========================================================

if(empty($_SESSION['user']) && $page_name !== 'identification' && $page_name !== 'user')
{
    $tools->redirect('identification/');
} 

?>