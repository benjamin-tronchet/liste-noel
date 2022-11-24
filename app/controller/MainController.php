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

// ========================================================
// Gestionnaire de notifications
// ======================================================== 

if(!isset($_SESSION['santa']))
{
    $_SESSION['santa'] = "expand";
}

if(isset($_SESSION['notif']))
{
    $notification = $_SESSION['notif'];
    unset($_SESSION['notif']);
}

// ========================================================
// Gestionnaire du panel
// ======================================================== 

$panel = [];
if(isset($_GET['panel']))
{
    $panel['type'] = $_GET['panel'];
    
    if(isset($_GET['data']) && !empty($_GET['data']))
    {
        $panel['data'] = $_GET['data'];
    }
}

// ========================================================
// Gestionnaire des listes vues
// ======================================================== 

if(!isset($_SESSION['has-seen']))
{
    $_SESSION['has-seen'] = [];
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