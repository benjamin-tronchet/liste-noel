<?php

// *** Instanciation des classes

$UserManager = new UserManager(DB_USERS);

//***********************************************
// Création / update d'un utilisateur dans la database
//***********************************************

function create_user(UserManager $manager, Tools $tools, FormTools $form_tools) 
{
    $form_data = $form_tools->check_form_fields($_POST);

    if($form_data)
    {
        // Création de l'objet User
        $new_user = new User($form_data);
        $slug_new_user = $tools->createSlug($new_user->username());
        $new_user->setId_user($slug_new_user);

        // Création de l'objet User et hashage du mot de passe
        $new_user->hash();

        // Si le mail existe déjà en base de données, on renvoit à la page précédente
        if($manager->exists($new_user->id_user()))
        {
            $tools->redirect('identification/?info=existing_user');
            die();
        }

        // Création de l'utilisateur en BDD et renvoi vers la page de succès
        $manager->create($new_user);
        $manager->logIn($new_user->id_user(),$form_data['password']);
        $tools->redirect('dashboard/?info=success_create_user');
    }
    else 
    {
        // Un ou plusieurs champ(s) ne correspond(ent) pas au(x) format(s) attendu(s)
        $tools->redirect('identification/?info=wrong_format');
    }
}
