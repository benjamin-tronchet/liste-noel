<?php 
session_start();
// helpers
include 'controller/MainController.php';
 
//if(empty($_SESSION['utilisateur']['id']) OR $_SESSION['utilisateur']['type']==0){
if(empty($_SESSION['user']['id']) OR empty($_SESSION['user']['mail'])){
    
    include_once 'class/SiteClass.php';
    include 'model/SiteModel.php';
    include 'view/LoginView.php';
    
} else {
    
    include_once 'class/SiteClass.php';
    include_once 'class/UserClass.php';
    include 'model/SiteModel.php';
    include 'model/UserModel.php';
    
    // Contenu de la page
    if(!empty($_GET['page'])) {
        $pageName = $_GET['page'];
    } else {
        $pageName = '';
    }
    switch($pageName){      
        case 'actualites':
            include 'controller/ActualitesController.php';
        break;
        case 'actualite':
            include 'controller/ActualiteController.php';
        break;
        case 'offres':
            include 'controller/OffresController.php';
        break;
        case 'offre':
            include 'controller/OffreController.php';
        break;
        case 'settings':
            include_once 'class/ConfigClass.php';
            include_once 'model/SettingsModel.php';
            include 'view/SettingsView.php';
        break;
        default:
            include 'view/NoticeView.php';
        break;
    }
}

?>