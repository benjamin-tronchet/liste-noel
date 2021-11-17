<?php
class UserManager extends Manager
{
    
    // ========================================================
    // Ajout d'un utilisateur
    // ========================================================
    
    public function create(User $user) 
    {
        $users_list = $this->lists();
        
        $id_user = $user->id_user();
        $users_list[$id_user] = $user;
        
        // Encodage au format JSON
        $json = json_encode($users_list, JSON_PRETTY_PRINT);

        // Réécriture du fichier JSON
        file_put_contents($this->_db, $json);
    }
    
    // ========================================================
    // Vérification que le mot de passe correspond à l'utilisateur
    // Retourne true s'il correspond, et false s'il ne correspond pas
    // ========================================================
    
    public function matchPassword($id, $password) 
    {
        $users_list = $this->lists();
        $user = $users_list[$id];
        
        // Vérification du mot de passe
        if(password_verify($password, $user->password())) {
            
            // Vérification de la validité du hash : si non valide, on le réenregistre.
            if (password_needs_rehash($user->password(), PASSWORD_DEFAULT)) {
                $user->hash();
                $users_list[$id_user] = $user;
                $json = json_encode($users_list, JSON_PRETTY_PRINT);
                file_put_contents($this->_db, $json);
            }
            return true;
            
        } else {
            return false;
        }
    }
    
    // ========================================================
    // Récupération d'un utilisateur par son id
    // ========================================================
    
    public function get($id) 
    {
        $users_list = $this->lists();
        $user = $users_list[$id];
        
        return $user;
    }
    
    // ========================================================
    // Vérification de l'existence d'un id
    // ========================================================
    
    public function exists($id) 
    {
        $users_list = $this->lists();
        foreach($users_list as $id_user => $user)
        {
            if($id_user === $id)
            {
                return true;
            }
        }
        return false;
    }
    
    // ========================================================
    // Lister tous les utilisateurs
    // ========================================================
    
    public function lists() 
    {
        $users_array = [];
        
        $users = json_decode(file_get_contents($this->_db));
        
        foreach($users as $user)
        {
            $user_array = (array) $user;
            $current_user = new User($user_array);
            $users_array[$current_user->id_user()] = $current_user;
        }
        
        ksort($users_array);
        
        return $users_array;
    }
    
    // ========================================================
    // Fonction de login d'un utilisateur
    // Vérifie l'existence du mail dans la base de données
    // Vérifie le match email / password
    // Renvoie true si login réussi / false si login échoué
    // ========================================================
    
    public function logIn($id,$password) 
    {
        $connexion = $this->matchPassword($id,$password);
        
        if($connexion) 
        {
            $_SESSION['user'] = $this->get($id);

            // Tout est ok, renvoi vrai
            return true;
        }
        else 
        {
            // Mot de passe incorrect, renvoi false
            return false;
        } 
    }
}
?>