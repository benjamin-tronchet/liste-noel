<?php

class Site {
    
    // **** ATTRIBUTS ***************
	protected $site;

	// **** METHODES ****************
	// constructeur  
	function __construct() {
        include_once 'ConfigClass.php';
        new Config();
        $config = new Config();
        $this->site = $config->site;        
	}
    // getters
	public function getName() {
		return html_entity_decode($this->site['name']); 
	}	
	public function getMail(){
		return html_entity_decode($this->site['mail']); 
	}
	public function getDomain(){
		return html_entity_decode($this->site['domain']); 
	}
	public function getUrl(){
		return html_entity_decode($this->site['url']); 
	}
	public function getSrcImg(){
		return html_entity_decode($this->site['srcimg']); 
	}
	public function getColorImg(){
		return html_entity_decode($this->site['colorimg']); 
	}

}

?>