<?php
class GroupManager extends Manager
{
    // ========================================================
    // Update d'un group
    // ========================================================
    
    public function update(Group $group) 
    {
        $groups_list = $this->lists();
        $tri = [];
        
        // Suppression de l'ancien group
        foreach($groups_list as $key => $current_group)
        {
            if($current_group->id_group() == $group->id_group())
            {
                unset($groups_list[$key]);
            }
            else
            {
                $tri[] = $current_group->id_group();
            }
        }
        
        // Ajout du group modifié
        $groups_list[] = $group;
        $tri[] = $group->id_group();
        
        // Tri par ordre alphabétique
        array_multisort($tri, SORT_ASC, $groups_list);
        
        // Encodage au format JSON
        $json = json_encode($groups_list, JSON_PRETTY_PRINT);

        // Réécriture du fichier JSON
        file_put_contents($this->_db, $json);
    }
    
    // ========================================================
    // Récupération d'un group par son id
    // ========================================================
    
    public function get($id) 
    {
        $groups_list = $this->lists();
        
        if(empty($groups_list))
        {
            return false;
        }
        else
        {
            foreach($groups_list as $group)
            {
                if($group->id_group() == $id)
                {
                    return $group;
                }
            }
            
            return false;
        }
    }
    
    // ========================================================
    // Lister tous les groups
    // Si id_user est transmis, on liste les groupes dont fait partie l'utilisateur
    // ========================================================
    
    public function lists($id_user = false) 
    {
        $groups = json_decode(file_get_contents($this->_db));
        $groups_array = [];
        
        foreach($groups as $group)
        {
            $current_group = new Group((array) $group);
            
            if($id_user)
            {
                if($current_group->is_member($id_user))
                {
                    $groups_array[] = $current_group;
                }
            }
            else
            {
                $groups_array[] = $current_group;
            }
        }
        
        return $groups_array;
    }
    
    // ========================================================
    // Update ID_user in all groups
    // ========================================================
    
    public function update_id_user($old_id,$new_id) 
    {
        $groups_list = $this->lists($old_id);
        
        if(!empty($groups_list))
        {
            foreach($groups_list as $group)
            {
                $group->remove_user($old_id);
                $group->add_user($new_id);
                $this->update($group);
            }
        }
    }
}
?>