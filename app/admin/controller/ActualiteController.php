<?php

$parent_pagename = 'actualites';
$pagename = 'actualite';

// recupere le fichier json
$json = file_get_contents(realpath(__DIR__ . '/..') . '/database/actualites.json');
// decode pour que php puisse le traiter
$actualitesArray = json_decode($json);

$actualite_id               = '';
$actualite_titre            = '';
$actualite_desc             = '';
$actualite_img              = '';
$actualite_date             = '';
$msgIMG                 = false;

/*=========================================================
=============================
==============
DANS LE CAS D'UNE SUPPRESSION
==============
=============================
=========================================================*/

if(!empty($_GET['supprimmer'])) {
    $id = $_GET['supprimmer'];
    $idActualite = "actualite_".$id;
    unset($actualitesArray->$idActualite);
    
    $upload_folder = realpath(__DIR__ . '/..') .'/uploads'; 
    $upload_subfolder = $upload_folder .'/'. $idActualite .'/'; 
    
    if (is_dir($upload_subfolder)) {
        $filesinfolder = glob($upload_subfolder.'/*.*');
        if(!empty($filesinfolder)){
            array_map('unlink', $filesinfolder);
        }
        rmdir($upload_subfolder);
    }
    
    // Stockage du chemin vers le fichier JSON
    $filePath = realpath(__DIR__ . '/..') . '/database/actualites.json';
    
    // Encodage au format JSON
    $json = json_encode($actualitesArray);
    
    // Réécriture du fichier JSON
    file_put_contents($filePath, $json);
    
    // Et hop ! terminé, c'est supprimé 
    header('Location:index.php?page=actualites&msgsystem=success_delete');
}

/*=========================================================
=============================
==============
DANS LE CAS D'UNE MODIFICATION, ON RECUPERE LES INFOS DEJA PRÉSENTES
==============
=============================
=========================================================*/


if (!empty($_GET['id'])) {
    // ON RECUPERE L'ID DE L'ACTU
    $id = $_GET['id'];
    
    // ON RECUPERE L'ID DE L'OBJET DANS LE JSON
    $idActualite = "actualite_".$id;
    
    // CASE : MODIFICATION 
    if (!isset($_POST['choix']) || $_POST['choix']!= 'creer') {

        // ON RECUPERE DANS LE JSON L'OBJET actualite CONCERNÉ
        $actualite = $actualitesArray->$idActualite;

        // ON DEFINIT L'ACTION DU FORMULAIRE A "MODIFIER"
        $action = 'modifier';

        // ON RECUPERE LES INFOS DU FICHIER JSON
        if($actualite) {
            $actualite_id           = html_entity_decode($actualite->id);
            $actualite_titre        = html_entity_decode($actualite->titre);
            $actualite_desc         = html_entity_decode($actualite->desc);
            $actualite_img          = html_entity_decode($actualite->img);
            $actualite_date         = html_entity_decode($actualite->actu_date);
        }
        else 
        {
            header("location:index.php?page=".$parent_pagename);
        }
    }
}

/*=========================================================
=============================
==============
DANS LE CAS D'UNE CREATION, ON CREE UN ID, ON L'ASSIGNE A LA actualite, ET ON LUI ASSIGNE LA DATE DU JOUR
==============
=============================
=========================================================*/

if(!empty($_GET['creer']) && $_GET['creer'] = 'nouveau') {


    // ON DEFINIT L'ACTION DU FORMULAIRE A "CREER"
    $action = 'creer';
    
    // FONCTION DE CALCUL DU PLUS HAUT ID DEJA PRESENT
    if(!empty($actualitesArray)){
        $a = [];
        foreach($actualitesArray as $actualite){
            
            // on envoie le numéro dans le tableau
            $id = $actualite->id;
            array_push($a,$id);
        }
        if(!empty($a)) {
            $maxId = max($a);
            $actualite_id  = intval($maxId + 1);
        }
        else {
            $actualite_id = intval(1);
        }
    } else {
       // SI PAS ENCORE D'ACTUS, ALORS ON LUI ASSIGNE LA VALEUR "1"
       $actualite_id   = intval(1);
    }
}


/*=========================================================
=============================
==============
DANS LE CAS D'UNE MODIFICATION DES INFORMATIONS PAR L'UTILISATEUR (CREATION OU MODIFICATION)
==============
=============================
=========================================================*/


if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['choix'] == 'modifier' || $_POST['choix'] == 'creer')) {
    
    if($_POST['choix'] == 'creer') {
        
        // CREATION D'UN OBJET VIDE
        $actualitesArray->$idActualite = new stdClass();
        $date = date('d-m-Y');
    }
    
    
    // RECUPERATION DE L'OBJET ACTU (DANS LE JSON)
    $actualite = $actualitesArray->$idActualite;
    
    if($_POST['choix'] == 'modifier') {
        $date = $actualite->actu_date;
    }
    
    // RECUPERATION DES VALEURS POSTEES
    $titre = parse($_POST['titre']);
    $desc = parse($_POST['desc']);
    
    // ON VERIFIE QUE L'IMAGE A BIEN ETE POSTEE
    if (!empty($_FILES['img']) && $_FILES['img']['size'] != 0)
    {
        // ON VERIFIE QU'IL N'Y A PAS D'ERREUR
        if ($_FILES['img']['error'] > 0) 
        {
            $msgIMG = "Une erreur s'est produite : " . $_FILES['img']['error'];
        } 
        else 
        {   
            // INCLUSION DE LA CLASSE
            include_once (realpath(__DIR__ . '/..') . '/class/ImageManipulatorClass.php');

            // TABLEAU DES EXTENSIONS VALIDES
            $validExtensions = array('.jpg', '.JPG', '.jpeg', '.JPEG', '.png', '.PNG');

            // RECUPERATION DE L'EXTENSION DU FICHIER
            $fileExtension = strrchr($_FILES['img']['name'], ".");

            // VERIFICATION QUE L'EXTENSION DU FICHIER EST UNE EXTENSION AUTORISEE
            if (in_array($fileExtension, $validExtensions)) 
            {
                // DEFINITION DU REPERTOIRE D'UPLOAD
                $upload_folder = realpath(__DIR__ . '/..') .'/uploads'; 
                $upload_subfolder = $upload_folder .'/'. $idActualite .'/'; 

                // CREATION / SUPPRESSION DES REPERTOIRES
                if (is_dir($upload_subfolder)) {
                    $filesinfolder = glob($upload_subfolder.'/*.*');
                    if(!empty($filesinfolder)){
                        array_map('unlink', $filesinfolder);
                    }
                    rmdir($upload_subfolder);
                }
                
                if(!is_dir($upload_folder))
                {
                    mkdir($upload_folder,0777);
                }
                if(!is_dir($upload_subfolder))
                {
                    mkdir($upload_subfolder,0777);
                }

                // REDIMENSIONNEMENT DE L'IMAGE
                $finalWidth = '1010';
                $finalHeight = '620';
                $newNamePrefix = time() . '_';
                $manipulator = new ImageManipulator($_FILES['img']['tmp_name']);
                // resize
                $newImage = $manipulator->resample($finalWidth, $finalHeight, $constrainProportions = true);
                // suite
                $widthImg  = $manipulator->getWidth();
                $heightImg = $manipulator->getHeight();
                $centreX = round($widthImg / 2);
                $centreY = round($heightImg / 2);
                // our dimensions will be 200x130
                $x1 = $centreX - round($finalWidth/2); // 200 / 2
                $y1 = $centreY - round($finalHeight/2); // 130 / 2
                $x2 = $centreX + round($finalWidth/2); // 200 / 2
                $y2 = $centreY + round($finalHeight/2); // 130 / 2
                // center cropping
                $newImage = $manipulator->crop($x1, $y1, $x2, $y2);
                $newImage = $manipulator->enlargeCanvas($finalWidth, $finalHeight,[255, 255, 255]);
                // Clean file name
                $file_name = strtolower($_FILES['img']['name']);
                $find = array("_","%"," ");
                $file_name = str_replace($find,"-",$file_name);
                $file_name = explode(".", $file_name);
                $file_name  = $file_name[0] . "." . $file_name[1];
                // saving file to uploads folder
                $manipulator->save($upload_subfolder.'/'. $newNamePrefix . $file_name);

                $actualite->img = 'uploads/'. $idActualite .'/'. $newNamePrefix . $file_name;
                $msgIMG = false;
            } 
            else 
            {
                $actualite->img = false;
                $msgIMG = "Le format du fichier n'est pas pris en charge !";
            }
        }
    } elseif($_FILES['img']['size'] != 0) {
        $actualite->img = false;
        $msgIMG = "Une erreur s'est produite lors du téléchargement !";
    }
    
    // Assignation des nouvelles valeurs à l'objet actualite correspondant
    $actualite->id = $id;
    $actualite->titre = $titre;
    $actualite->desc = $desc;
    $actualite->actu_date = $date;
    
        
    if (
        isset($actualite->id) &&
        isset($actualite->titre) &&
        isset($actualite->desc) &&
        isset($actualite->img) && 
        $msgIMG == false
    ) {
        // Stockage du chemin vers le fichier JSON
        $filePath = realpath(__DIR__ . '/..') . '/database/actualites.json';

        // Encodage au format JSON
        $json = json_encode($actualitesArray);

        // Réécriture du fichier JSON
        file_put_contents($filePath, $json);
        
        // On renvoie à la page précédente
        header('location:index.php?page='.$parent_pagename.'&msgsystem=success_modify-article');
    }
}


function parse($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlentities($data, ENT_QUOTES, "UTF-8");
    return $data;
}


// On affiche la vue
include (realpath(__DIR__ . '/..') . '/view/ActualiteView.php');

?>
