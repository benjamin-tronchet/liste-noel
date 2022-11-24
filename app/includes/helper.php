<?php

//*******************************
// Balises Méta
//*******************************

$META_author = 'Qui veut quoi ?';
global $page_name;
global $action_name;

switch ($page_name) {
        
    case 'accueil':
        $META_title = "";
        $META_description = "";
        $META_robots = "noindex,nofollow";
        break;
        
    case 'identification':
        $META_title = "Identifiez-vous | Qui veut quoi ?";
        $META_description = "Identifiez-vous ou créez un compte utilisateur pour accéder à l'application liste de Noël";
        $META_robots = "noindex,nofollow";
        break;
        
    case 'dashboard':
        $META_title = "Bienvenue sur la gestion de votre compte | Qui veut quoi ?";
        $META_description = "Gérer votre compte, ajoutez ou modifiez des idées de cadeaux de Noël, ou accédez à la liste de quelqu'un d'autre pour trouver des idées de cadeaux originales !";
        $META_robots = "noindex,nofollow";
        break;
        
    case 'gifts':
        $META_title = "Gérer ma liste de cadeaux | Qui veut quoi ?";
        $META_description = "Gérez votre liste de cadeaux : ajoutez-en de nouveaux, modifier les existants ou supprimez-les à votre guise.";
        $META_robots = "noindex,nofollow";
        break;
        
    case 'groups':
        $META_title = "Gérer mes groupes | Qui veut quoi ?";
        $META_description = "Gérez vos groupes, rejoignez de nouveaux groupes pour consulter les idées de cadeaux des autres utilisateurs";
        $META_robots = "noindex,nofollow";
        break;
        
    case 'users':
        $META_title = "Trouver une idée de cadeau | Qui veut quoi ?";
        $META_description = "Parcourez la liste des utilisateurs pour consulter leur liste de cadeaux et trouver une idée !";
        $META_robots = "noindex,nofollow";
        break;
        
    case 'liste':
        $META_title = "Bienvenue sur la liste d'envies de ".$user->username();
        $META_description = "Trouvez des idées de cadeaux pour faire plaisir à coup sûr : bienvenue sur la liste de ".$user->username();
        $META_robots = "noindex,nofollow";
        break;
    
    default:
        $META_description = '';
        $META_title = '';
}