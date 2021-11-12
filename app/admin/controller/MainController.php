<?php

//***********************************************
// Déconnection utilisateur
//***********************************************

if(isset($_GET['logout'])){
    unset($_SESSION['user']);
    header('Location:index.php?msgsystem=info_unlogged');
};

//***********************************************
// Définition Droit d'accès Admin 
// $is_admin vs $is_athor
//***********************************************

if(!empty($_SESSION) && !empty($_SESSION['user']['id'])) {
    if($_SESSION['user']['role'] === 'admin') {
        $is_admin = true;
    }else{
        $is_admin = false;
    }
    if($_SESSION['user']['role'] === 'author') {
        $is_author = true;
    }else{
        $is_author = false;
    }
};
//***********************************************
// System de gestion des notifications
//***********************************************
                
function get_helpers_pnotify_message_system(){
    
    if(isset($_GET['msgsystem'])){
        
        $msg = explode("_", $_GET['msgsystem']);
        $msg_type = $msg['0'];
        switch($msg_type){      
            case 'info':
                $type = 'info';
            break;
            case 'success':
                $type = 'success';
            break;
            case 'error':
                $type = 'error';
            break;
            case 'warning':
                $type = 'warning';
            break;
            default:
                $type = '';
            break;
        }
        switch($_GET['msgsystem']){      
            
            //####### ERROR MESSAGES #########
            case 'error_unknowuser':
                $title = 'OOPS';
                $text = 'Utilisateur inconnu !';
            break;
            case 'error_mustlogged':
                $title = 'OOPS';
                $text = 'Vous n avez pas accès à cet espace !';
            break; 
            case 'error_link':
                $title = 'Erreur';
                $text = 'Vous devez renseigner un lien ou un fichier PDF';
            break; 
                
            //####### WARNING MESSAGES #########
            case 'warning_connexion':
                $title = 'OOPS';
                $text = 'Le login ou le mot de passe renseigné n est pas correct !';
            break;
            case 'warning_linkerror':
                $title = 'Attention';
                $text = 'Le lien renseigné n est pas correct !<br/>Format accepté : http(s)://votre_url_avec_ou_sans_www';
            break; 
                
            //####### SUCCESS MESSAGES #########   
            case 'success_logged':
                $title = 'Bienvenue';
                $text = 'Vous êtes désormais connecté !';
            break;  
            case 'success_update-config':
                $title = 'Parfait';
                 $text = 'Configuration modifiée avec succès !';
            break;  
            case 'success_record-article':
                $title = 'Parfait';
                $text = 'Offre créée avec succès !';
            break;  
            case 'success_modify-article':
                $title = 'Parfait';
                $text = 'Offre modifiée avec succès !';
            break;
            case 'success_delete':
                $title = 'Parfait';
                $text = 'Elément supprimé avec succès !';
            break; 
                
            //####### INFO MESSAGES #########    
            case 'info_unlogged':
                $title = 'À bientôt';
                $text = 'Vous êtes désormais déconnecté !';
            break; 
            //####### DEFAULT #########   
            default:
                $title = 'Information';
                $text = '';
            break;
        }
    
        echo "<script>"."\n\t\t";
        echo "new PNotify({"."\n\t\t\t";
        echo "type: '".$type."',"."\n\t\t\t";
        echo "title: '".$title."',"."\n\t\t\t";
        echo "text: '".$text."'"."\n\t\t";
        echo " });"."\n\t";
        echo "</script>"."\n";
    }  
};

$addScriptDeclaration = '';

?>