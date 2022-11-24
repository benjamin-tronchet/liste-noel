<?php
class Gift implements JsonSerializable
{
    // ========================================================
    // Définition des attributs de base
    // ========================================================
    
    private $_id_gift;
    private $_publish;
    private $_name;
    private $_price;
    private $_desc;
    private $_store;
    private $_url_shop;
    private $_img = DEFAULT_GIFT;
    private $_id_user;
    private $_booked = "0";
    
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
    
    public function id_gift()
    {
        return $this->_id_gift;
    }
    public function publish()
    {
        return $this->_publish;
    }
    public function name()
    {
        return $this->_name;
    }
    public function price()
    {
        return $this->_price;
    }
    public function desc()
    {
        return $this->_desc;
    }
    public function store()
    {
        return $this->_store;
    }
    public function url_shop()
    {
        return $this->_url_shop;
    }
    public function img()
    {
        return $this->_img;
    }
    public function id_user()
    {
        return $this->_id_user;
    }
    public function booked()
    {
        return $this->_booked;
    }
    
    // ========================================================
    // Setters : mettent à jour les valeurs des attributs de l'élément
    // ========================================================
    
    public function setId_gift($id_gift)
    {
        if (is_string($id_gift))
        {
            $this->_id_gift = $id_gift;
        }
    }
    public function setPublish($publish)
    {
        if(is_numeric($publish))
        {
            $publish = (int) $publish;
        }
        else 
        {
            return false;
        }
        
        $date = date('d/m/Y',$publish);
        $date = date_parse($date);
        if (is_int($publish) && checkdate($date['month'], $date['day'], $date['year']))
        {
            $this->_publish = $publish;
        }
    }
    public function setName($name)
    {
        if (is_string($name))
        {
            $this->_name = $name;
        }
    }
    public function setPrice($price)
    {
        if (is_string($price))
        {
            $price = str_replace(array('euros', '€', 'euro', 'eur', 'Euros', 'EUROS', 'Euro', 'EURO', 'Eur', 'EUR'), '', $price);
            $this->_price = $price;
        }
    }
    public function setDesc($desc)
    {
        if (is_string($desc))
        {
            $this->_desc = $desc;
        }
    }
    public function setStore($store)
    {
        if (is_string($store))
        {
            $this->_store = $store;
        }
    }
    public function setUrl_shop($url_shop)
    {
        if (filter_var($url_shop,FILTER_VALIDATE_URL))
        {
            $this->_url_shop = $url_shop;
        }
    }
    public function setImg($img)
    {
        if (is_string($img))
        {
            $this->_img = $img;
        }
    }
    public function setId_user($id_user)
    {
        $userManager = new UserManager(DB_USERS);
        
        if (is_string($id_user) && $userManager->get($id_user))
        {
            $this->_id_user = $id_user;
        }
    }
    public function setBooked($booked)
    {
        if (is_string($booked))
        {
            $this->_booked = $booked;
        }
    }
    
    // ========================================================
    // Fonctions utilitaires
    // ========================================================

    
    public function jsonSerialize() {
        return [
            'id_gift' => $this->id_gift(),
            'publish' => $this->publish(),
            'name' => $this->name(),
            'price' => $this->price(),
            'desc' => $this->desc(),
            'store' => $this->store(),
            'url_shop' => $this->url_shop(),
            'img' => $this->img(),
            'id_user' => $this->id_user(),
            'booked' => $this->booked()
        ];
    }

    public function lock($id_user) {
        $UserManager = new UserManager(DB_USERS);
        $GiftManager = new GiftManager(DB_GIFTS);
        
        if($UserManager->get($id_user) && !$this->_booked)
        {
            $this->setBooked($id_user);
            $GiftManager->update($this);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function unlock($id_user) {
        $GiftManager = new GiftManager(DB_GIFTS);
        
        if($this->booked() == $id_user)
        {
            $this->setBooked('0');
            $GiftManager->update($this);
            return true;
        }
        else
        {
            return false;
        }
        
    }
}
?>