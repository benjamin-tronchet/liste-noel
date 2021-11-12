<?php
class User implements JsonSerializable
{
    // ========================================================
    // Définition des attributs de base
    // ========================================================
    
    private $_id_user;
    private $_username;
    private $_password;
    
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
    
    public function id_user()
    {
        return $this->_id_user;
    }
    public function username()
    {
        return $this->_username;
    }
    public function password()
    {
        return $this->_password;
    }
    
    // ========================================================
    // Setters : mettent à jour les valeurs des attributs de l'élément
    // ========================================================
    
    public function setId_user($id_user)
    {
        if (is_string($id_user))
        {
            $this->_id_user = $id_user;
        }
    }
    public function setUsername($username)
    {
        if (is_string($username))
        {
            $this->_username = $username;
        }
    }
    public function setPassword($password)
    {
        if (is_string($password))
        {
            $this->_password = $password;
        }
    }
    
    // ========================================================
    // Fonctions utilitaires
    // ========================================================
    
    public function hash() {
        $this->setPassword(password_hash($this->_password,PASSWORD_DEFAULT));
    }
    
    public function jsonSerialize() {
        return [
            'id_user' => $this->id_user(),
            'username' => $this->username(),
            'password' => $this->password()
        ];
    }
}
?>