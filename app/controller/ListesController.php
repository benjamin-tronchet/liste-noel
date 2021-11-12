<?php

// *** Instanciation des classes

$GiftManager = new GiftManager(DB_GIFTS);

//***********************************************
// Liste des cadeaux
//***********************************************

function set_list(GiftManager $manager, Tools $tools, FormTools $form_tools) 
{
    $gifts_list = $manager->lists($_SESSION['user']->id_user());
    $santa_text = "Astuce :<br/>Tu peux ajouter une nouvelle idée avec le bouton en haut à droite";
    include 'views/GiftsView_list.php';
}