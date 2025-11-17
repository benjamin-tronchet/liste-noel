<?php
class Group implements JsonSerializable
{
    // ========================================================
    // Définition des attributs de base
    // ========================================================
    
    private $_id_group;
    private $_title;
    private $_users;
    
    // ========================================================
    // Création du constructeur
    // ========================================================
    
    public function __construct(array $donnees) 
    {
        $this->hydrate($donnees);
    }
    
    // ========================================================
    // Création de la fonction d'hydratation de la classe
    // ========================================================
    
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value)
        {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }
    
    // ========================================================
    // Getters : récupèrent les valeurs des attributs de l'élément
    // ========================================================
    
    public function id_group()
    {
        return $this->_id_group;
    }
    public function title()
    {
        return $this->_title;
    }
    public function users()
    {
        return $this->_users;
    }
    
    // ========================================================
    // Setters : mettent à jour les valeurs des attributs de l'élément
    // ========================================================
    
    public function setId_group($id_group)
    {
        if (is_string($id_group))
        {
            $this->_id_group = $id_group;
        }
    }
    public function setTitle($title)
    {
        if (is_string($title))
        {
            $this->_title = $title;
        }
    }
    public function setUsers($users)
    {
        if (is_array($users))
        {
          $this->_users = $users;
        }
        elseif (is_string($users))
        {
          $this->_users = unserialize($users);
        }
    }
    
    // ========================================================
    // Fonctions utilitaires
    // ========================================================

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_group' => $this->id_group(),
            'title' => $this->title(),
            'users' => $this->users()
        ];
    }
    
    // ========================================================
    // Savoir si un membre fait partie d'un groupe
    // ========================================================
    
    public function is_member($id_user) 
    {
        if(empty($this->users()))
        {
            return false;
        }
        elseif(in_array($id_user,$this->users()))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    // ========================================================
    // Récupérer les utilisateurs d'un group
    // ========================================================
    
    public function get_members()
    {
        $members = [];
        $UserManager = new UserManager(DB_USERS);
        
        if(!empty($this->_users))
        {
            foreach($this->_users as $id_user)
            {
                $members[] = $UserManager->get($id_user);
            }
            
            $this->setUsers($members);
        }
    }
    
    // ========================================================
    // Ajouter un utilisateur au groupe
    // ========================================================
    
    public function add_user($id_user)
    {
        if(!empty($this->_users))
        {
            if(!in_array($id_user,$this->_users))
            {
                $this->_users[] = $id_user;
            }
        }
        else
        {
            $this->_users[] = $id_user;
        }
    }
    
    // ========================================================
    // Retirer un utilisateur du groupe
    // ========================================================
    
    public function remove_user($id_user)
    {
        if(!empty($this->_users))
        {
            foreach($this->_users as $key => $user)
            {
                if($user == $id_user)
                {
                    unset($this->_users[$key]);
                }
            }
            
            $this->_users = array_values($this->users());
        }
    }
}
?>