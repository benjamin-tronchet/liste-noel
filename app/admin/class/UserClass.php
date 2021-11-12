<?php
class User {
    
    // **** ATTRIBUTS ***************
	protected $user;
	protected $id;

	// **** METHODES ****************
	// constructeur  
	function __construct($id) {
        if(($id!=null) && (is_int($id))){
            $this->id = $id;
            include_once 'ConfigClass.php';
            new Config();
            $config = new Config();
            $this->user = $config->user[$this->id];    
	   }
    }
    // getters
	public function getName() {
		return html_entity_decode($this->user['name']); 
	}	
	public function getFirstName(){
		return html_entity_decode($this->user['firstname']); 
	}
    public function getFullName(){
		return html_entity_decode($this->user['firstname']. ' ' .$this->user['name']);
	}
    public function getMail(){
		return html_entity_decode($this->user['mail']);
	}
    public function getPass(){
		return html_entity_decode($this->user['pass']);
	}
    public function getRole(){
		return html_entity_decode($this->user['role']);
	}
    
	// setters
	public function setName($name) {
		$this->user['name'] = $name; 
	}
    public function setUrl($url) {
		$this->user['url'] = $url; 
	}
    public function setSrcImg($srcimg) {
		$this->user['srcimg'] = $srcimg; 
	}
    
    // static function
    static function matchMail($mail) {	
        include_once 'ConfigClass.php';
        new Config();
        $config = new Config();
        $userId = array_search($mail, array_column($config->user, 'mail','id'));
        if($userId) {
            return($userId);
        }else {
            return(false);
        }
	}
}
?>