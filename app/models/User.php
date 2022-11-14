<?php
class User implements JsonSerializable
{
    // ========================================================
    // Définition des attributs de base
    // ========================================================
    
    private $_id_user;
    private $_email;
    private $_username;
    private $_password;
    private $_token;
    private $_img;
    private $_last_visit;
    
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
    public function email()
    {
        return $this->_email;
    }
    public function username()
    {
        return $this->_username;
    }
    public function password()
    {
        return $this->_password;
    }
    public function token()
    {
        return $this->_token;
    }
    public function img()
    {
        return $this->_img;
    }
    public function last_visit()
    {
        return $this->_last_visit;
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
    public function setEmail($email)
    {
        if (is_string($email) && filter_var($email,FILTER_SANITIZE_EMAIL))
        {
            $this->_email = $email;
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
    public function setToken($token)
    {
        if (is_string($token) && strlen($token) == 10)
        {
            $this->_token = $token;
        }
    }
    public function setImg($img)
    {
        if (is_string($img))
        {
            $this->_img = $img;
        }
    }
    public function setLast_visit($last_visit)
    {
        $date = date('d/m/Y',$last_visit);
        $date = date_parse($date_format);
        if (is_string($last_visit) && checkdate($date['month'], $date['day'], $date['year']))
        {
            $this->_last_visite = $last_visit;
        }
    }
    
    // ========================================================
    // Fonctions utilitaires
    // ========================================================
    
    public function hash() {
        $this->setPassword(password_hash($this->_password,PASSWORD_DEFAULT));
    }
    
    public function generate_token() {
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $max = mb_strlen($keyspace, '8bit') - 1;
        
        for ($i = 0; $i < 10; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        
        $token = implode('', $pieces);
        $this->setToken($token);
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