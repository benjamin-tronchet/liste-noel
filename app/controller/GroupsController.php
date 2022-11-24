<?php

// *** Instanciation des classes

$GiftManager = new GiftManager(DB_GIFTS);
$GroupManager = new GroupManager(DB_GROUPS);
$UserManager = new UserManager(DB_USERS);

//***********************************************
// Liste des groups
//***********************************************

function lists(GroupManager $manager) 
{
    $groups_list = $manager->lists($_SESSION['user']->id_user());
    
    $santa_text = "Astuce :<br/>Rejoins le(s) groupe(s) de ton souhait pour pouvoir consulter les idées de cadeaux des autres membres";
    
    include 'views/GroupsView_list.php';
}

//***********************************************
// Ajout d'un utilisateur dans un ou plusieurs groupes
//***********************************************

function edit_user(GroupManager $manager, Tools $tools, FormTools $form_tools) 
{
    
    $form_data = $form_tools->check_form_fields($_POST);
    $groups = $manager->lists();
    
    if($form_data)
    {
        $id_user = $form_data['id_user'];
        
        foreach($groups as $group)
        {
            if(empty($form_data['groups']))
            {
                $group->remove_user($id_user);
                $manager->update($group);
            }
            else
            {
                if(in_array($group->id_group(),$form_data['groups']))
                {
                    $group->add_user($id_user);
                    $manager->update($group);
                }
                else
                {
                    $group->remove_user($id_user);
                    $manager->update($group);
                }
            }
        }
        
        $_SESSION['notif'] = (object) [
            "type"      => "success",
            "title"     => "Modification enregistrée",
            "message"   => "Vos modifications ont été enregistrées"
        ];
        
        $tools->redirect('groups/');
    }
    else
    {
        $_SESSION['notif'] = (object) [
            "type"      => "error",
            "title"     => "Erreur",
            "message"   => "Une erreur est survenue, merci de réessayer"
        ];
        
        $tools->redirect('groups/panel/join-group');
    }
}

//***********************************************
// Supprimer un utilisateur du groupe
//***********************************************

function delete_user(GroupManager $manager, Tools $tools, FormTools $form_tools) 
{
    $form_data = $form_tools->check_form_fields($_POST);
    
    if($form_data)
    {
        $id_user = $form_data['id_user'];
        $id_group = $form_data['id_group'];
        
        $group = $manager->get($id_group);
        
        $group->remove_user($id_user);
        $manager->update($group);
     
        $_SESSION['notif'] = (object) [
            "type"      => "success",
            "title"     => "Modification enregistrée",
            "message"   => "Tu as quitté le groupe ".$group->title()
        ];
        
        $tools->redirect('groups/');
    }
    else
    {
        $_SESSION['notif'] = (object) [
            "type"      => "error",
            "title"     => "Erreur",
            "message"   => "Une erreur est survenue, merci de réessayer"
        ];
        
        $tools->redirect('groups/');
    }
}