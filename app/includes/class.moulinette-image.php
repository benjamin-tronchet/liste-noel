<?php

// EXEMPLE
// $galerie = new Galerie("img/realisations/extension-surelevation");
// le nom des dossiers contenu dans img/realisations/extension-surelevation n'a pas d'importance
// le nom des images doit etre précedé d'un numéro ecrit entre parenthes ex (100), (101) etc
// le nom des images sert pour les balises ALT : chaque mot séparé par des tirets et ne surtout pas mattre d'accent ex : (100)
// How to USE
// include 'includes/class.moulinette-image.php';
// $galerie_renovation = new MoulinetteImage("img/entretien/sliders"); /!\ Sans slash à la fin

class MoulinetteImage {
    
    // attributs
	protected $path;
    
	// constructeur  
	function __construct($path) {
        $this->path =  $path;
        if (is_dir($this->path)) {
            $this->getContent();
        }else{
            echo "Le dossier n'existe pas !";
        }
	}

    // getters
    public function getContent() {  

        $allImages = glob("$this->path/*.*", GLOB_BRACE);
        
        asort($allImages);
        //assort($images);

        $filter = array(".jpg", "-", "_");
        foreach($allImages as $key => $value) {
            // on détermine la balise alt (title)
            $title = preg_split("/(\()([\d]+)(\))/", $value); // on splite (100)
            $title = str_replace($filter, " ", $title[1]); // on filtre, remplace par des espaces
            $title = trim($title);
            // On récupère la taille du fichier pour l'injecter dans la balise image
            list($width, $height) = getimagesize($value);
            // On injecte les images dans la vue
            echo "<div><img src='$value' alt='".$title."' width='".$width."' height='".$height."'></div>";
        }
    } 

}

?>