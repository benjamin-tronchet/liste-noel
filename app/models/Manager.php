<?php
class Manager 
{
    // ========================================================
    // Définition des propriétés de base
    // ========================================================
    
    protected $_db;
    
    // ========================================================
    // Création du constructeur
    // ========================================================
    
    public function __construct($db) 
    {
        $this->setDb(realpath('./').'/'.$db);
    }
    
    // ========================================================
    // Assignation de la requête PDO à la propriété $_db
    // ========================================================
    
    protected function setDb($db)
    {
        $this->_db = $db;
    }
}
?>