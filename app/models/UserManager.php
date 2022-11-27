<?php
class UserManager extends Manager
{
    
    // ========================================================
    // Ajout d'un utilisateur
    // ========================================================
    
    public function create(User $user) 
    {
        if($this->get($user->email()) || $this->get($user->id_user()))
        {
            return false;
        }
        
        $users_list = $this->lists();
        $users_list[] = $user;
        
        // Encodage au format JSON
        $json = json_encode($users_list, JSON_PRETTY_PRINT);

        // Réécriture du fichier JSON
        file_put_contents($this->_db, $json);
        
        return true;
    }
    
    // ========================================================
    // Update d'un utilisateur
    // ========================================================
    
    public function update(User $user) 
    {
        $user_old = $this->get($user->token());
        
        // Suppression de l'ancienne cover si elle a été modifiée
        if($user_old->img() !== $user->img() && $user_old->img() !== DEFAULT_AVATAR)
        {
            unlink(realpath(__DIR__ . '/..').'/'.$user_old->img());
        }
        
        // Modification des groupes si l'id / username a été modifié
        if($user_old->id_user() !== $user->id_user())
        {
            $GroupManager = new GroupManager(DB_GROUPS);
            $GroupManager->update_id_user($user_old->id_user(),$user->id_user());
        }
        
        // Récupération du token et de la last visit
        
        if(empty($user->token()))
        {
            $user->setToken($user_old->token());
        }
        
        if(empty($user->last_visit()))
        {
            $user->setLast_visit($user_old->last_visit());
        }
        
        if(empty($user->password()))
        {
            $user->setPassword($user_old->password());
        }
        
        $users_list = $this->lists();
        
        // Suppression de l'ancien user
        foreach($users_list as $key => $current_user)
        {
            if($current_user->token() == $user->token())
            {
                unset($users_list[$key]);
            }
        }
        
        // Ajout du user modifié
        $users_list[] = $user;
        
        // Encodage au format JSON
        $json = json_encode($users_list, JSON_PRETTY_PRINT);

        // Réécriture du fichier JSON
        file_put_contents($this->_db, $json);
    }
    
    // ========================================================
    // Vérification que le mot de passe correspond à l'utilisateur
    // Retourne true s'il correspond, et false s'il ne correspond pas
    // ========================================================
    
    public function matchPassword($email, $password) 
    {
        $user = $this->get($email);
        
        // Vérification du mot de passe
        if(password_verify($password, $user->password())) {
            
            // Vérification de la validité du hash : si non valide, on le réenregistre.
            if (password_needs_rehash($user->password(), PASSWORD_DEFAULT)) {
                $user->hash();
                $this->update($user);
            }
            return true;
            
        } else {
            return false;
        }
    }
    
    // ========================================================
    // Vérification que l'email n'existe pas déjà
    // Retourne true s'il existe, et false s'il n'existe pas
    // ========================================================
    
    public function matchEmail($email) 
    {
        $users_list = $this->lists();
        
        if(empty($users_list))
        {
            return false;
        }
        
        foreach($users_list as $user)
        {
            if($user->email() == $email)
            {
                return true;
            }
        }
        
        return false;
    }
    
    // ========================================================
    // Récupération d'un utilisateur par son id / email / token
    // ========================================================
    
    public function get($id) 
    {
        $users_list = $this->lists();
        
        if(empty($users_list))
        {
            return false;
        }
        else
        {
            foreach($users_list as $user)
            {
                if($user->id_user() == $id || $user->email() == $id || $user->token() == $id)
                {
                    return $user;
                }
            }
            
            return false;
        }
    }
    
    // ========================================================
    // Lister tous les utilisateurs
    // ========================================================
    
    public function lists() 
    {
        $users_array = [];
        $users_names = [];
        
        $users = json_decode(file_get_contents($this->_db));
        
        if(!empty($users))
        {
            foreach($users as $user)
            {
                $current_user = new User((array) $user);
                $users_array[] = $current_user;
                $users_names[] = $current_user;
            }

            array_multisort($users_names, SORT_ASC, $users_array);
        }
        
        return $users_array;
    }
    
    // ========================================================
    // Fonction de login d'un utilisateur
    // Vérifie l'existence du mail dans la base de données
    // Vérifie le match email / password
    // Renvoie true si login réussi / false si login échoué
    // ========================================================
    
    public function logIn($email,$password) 
    {
        if(!$this->matchEmail($email))
        {
            return false;
        }
        
        if(!$this->matchPassword($email,$password))
        {
            return false;
        }
        
        $user = $_SESSION['user'] = $this->get($email);
        
        $_SESSION['last_visit'] = ($user->last_visit()) ? $user->last_visit() : time();
        
        $user->setLast_visit(time());
        $this->update($user);
        return true;
    }
}
?>