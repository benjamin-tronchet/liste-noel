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
    private $_img = DEFAULT_AVATAR;
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
        if (is_string($email) && filter_var($email,FILTER_VALIDATE_EMAIL))
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
        $date = date_parse($date);
        if (is_int($last_visit) && checkdate($date['month'], $date['day'], $date['year']))
        {
            $this->_last_visit = $last_visit;
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
    
    public function generate_slug() {
        $tools = new Tools();
        $slug = $tools->createSlug($this->username());
        $this->setId_user($slug);
    }
    
    public function has_new_gifts() {
        $last_visit = $_SESSION['last_visit'];
        $has_seen = $_SESSION['has-seen'];
        $manager = new GiftManager(DB_GIFTS);
        $gifts = $manager->lists($this->_id_user);
        
        foreach($gifts as $gift)
        {
            if($gift->publish() > $last_visit && !in_array($this->_id_user,$_SESSION['has-seen']))
            {
                return true;
            }
        }
        
        return false;
    }
    
    public function has_common_group($id_user) {
        $manager = new GroupManager(DB_GROUPS);
        $list = $manager->lists();
        $validation = false;
        
        foreach($list as $group) {
            if($group->is_member($id_user) && $group->is_member($this->_id_user))
            {
                $validation = true;
            }
        }
        
        return $validation;
    }
    
    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_user' => $this->id_user(),
            'email' => $this->email(),
            'username' => $this->username(),
            'password' => $this->password(),
            'token' => $this->token(),
            'img' => $this->img(),
            'last_visit' => $this->last_visit()
        ];
    }
}