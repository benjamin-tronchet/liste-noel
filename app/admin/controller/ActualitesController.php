<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $listeActualites = [];
    $i=0;
    $json = file_get_contents(realpath(__DIR__ . '/..') . '/database/actualites.json');

    $actualitesArray = json_decode($json);
    if(!empty($actualitesArray)){
        foreach($actualitesArray as $actualite){
            $i++;
            $listeActualites[$i]['id'] = html_entity_decode($actualite->id);
            $listeActualites[$i]['titre'] = html_entity_decode($actualite->titre);
            $listeActualites[$i]['desc'] = html_entity_decode($actualite->desc);
            $listeActualites[$i]['img'] = html_entity_decode($actualite->img);
            $listeActualites[$i]['actu_date'] = html_entity_decode($actualite->actu_date);
        }
    }
}

function parse($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlentities($data, ENT_QUOTES, "UTF-8");
    return $data;
}

// On affiche la vue
include (realpath(__DIR__ . '/..') . '/view/ActualitesView.php');

?>
