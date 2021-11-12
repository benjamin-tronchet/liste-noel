<?php
class FormTools
{
    //***************************************************
    // VERIFICATION DES CHAMPS DE FORMULAIRE
    // (REQUIRED + FORMAT)
    //***************************************************
    
    public function check_form_fields($post,$files=false)
    {
        // *** Initialisation des variables
        
        $form_data = [];
        $form_state = true;
        
        
        // *** On vide la session des données temporaires
        unset($_SESSION['temp_data']);
        
        // *** Traitement des champs du formulaire ($_POST)
        
        if(!empty($post))
        {
            foreach($post as $key => $value)
            {
                // Vérification de la première clef : required / format / default
                switch($key)
                {
                    case "required":
                        if(!$this->checkRequired($value)) 
                        {
                            $form_state = false;
                        }
                        break;
                    case "alphanum":
                    case "alpha":
                    case "mail":
                    case "url":
                    case "date":
                        if(!$this->checkFormat($key,$value)) 
                        {
                            $form_state = false;
                        }
                        break;
                    default :
                        if(empty($form_data[$key]))
                        {
                            $form_data[$key] = $this->returnData($value);
                        }
                        else
                        {
                            $form_data[$key] = $this->returnData($value,$form_data[$key]);
                        }
                        
                        break;
                }
                
                // Vérification de la seconde clef : format ou default 
                // Vérification qu'il n'y a pas d'erreur sur les vérifications de la première clef
                // Vérification qu'il n'y a pas déjà des données enregistrées à l'index $key (doublons)
                if(is_array($value) && $form_state && empty($form_data[$key]))
                {
                    foreach($value as $key2 => $value2)
                    {
                        switch($key2)
                        {
                            case "alphanum":
                            case "alpha":
                            case "mail":
                            case "url":
                            case "date":
                                if(!$this->checkFormat($key2,$value2)) 
                                {
                                    $form_state = false;
                                }
                                break;
                            default :
                                if(empty($form_data[$key2]))
                                {
                                    $form_data[$key2] = $this->returnData($value2);
                                }
                                else
                                {
                                    $form_data[$key2] = $this->returnData($value2,$form_data[$key2]);
                                }
                                break;
                        }
                        
                        // Vérification de la troisieme clef : default 
                        // Vérification qu'il n'y a pas d'erreur sur les vérifications des deux premières clefs
                        // Vérification qu'il n'y a pas déjà des données enregistrées à l'index $key2 (doublons)
                        if(is_array($value2) && $form_state && empty($form_data[$key2]))
                        {
                            foreach($value2 as $key3 => $value3)
                            {
                                if(empty($form_data[$key3]))
                                {
                                    $form_data[$key3] = $this->returnData($value3);
                                }
                                else
                                {
                                    $form_data[$key3] = $this->returnData($value3,$form_data[$key3]);
                                }
                            }
                        }
                    }
                }
            }
        }
        

        // *** Traitement des fichiers du formulaire ($_FILES)
        
        if(!empty($files))
        {
            // Normalisation du tableau $_FILES
            $files_formatted = $this->format_files_array($files);

            foreach($files_formatted as $key => $value)
            {
                // Vérification de la première clef : required / format / default
                switch($key)
                {
                    case "required":
                        if(!$this->checkRequiredFile($value)) 
                        {
                            $form_state = false;
                        }
                        break;
                    case "image_normal":
                        if(!$this->checkFileFormat($key,$value)) 
                        {
                            $form_state = false;
                        }
                        $format = $key;
                        break;
                }
                
                // Vérification de la seconde clef : format ou default 
                // Vérification qu'il n'y a pas d'erreur sur les vérifications de la première clef
                if(is_array($value) && $form_state)
                {
                    foreach($value as $key2 => $value2)
                    {
                        switch($key2)
                        {
                            case "image_normal":
                                if(!$this->checkFileFormat($key2,$value2)) 
                                {
                                    $form_state = false;
                                }
                                $format = $key2;
                                break;
                            default:
                                if(empty($form_data[$key2]))
                                {
                                    $form_data[$key2] = $this->returnFiles($format,$value2);
                                }
                                else
                                {
                                    $form_data[$key2] = $this->returnFiles($format,$value2,$form_data[$key2]);
                                }
                                if(!$form_data[$key2] && !empty($value2['name']))
                                {
                                    $form_state = false;
                                }
                                break;
                        }
                        
                        // Vérification de la troisieme clef : default 
                        // Vérification qu'il n'y a pas d'erreur sur les vérifications des deux premières clefs
                        // Vérification qu'il n'y a pas déjà des données enregistrées à l'index $key2 (doublons)
                        if(is_array($value2) && $form_state && empty($form_data[$key2]))
                        {
                            foreach($value2 as $key3 => $value3)
                            {
                                if(empty($form_data[$key3]))
                                {
                                    $form_data[$key3] = $this->returnFiles($format,$value3);
                                }
                                else
                                {
                                    $form_data[$key3] = $this->returnFiles($format,$value3,$form_data[$key3]);
                                }
                                if(!$form_data[$key3] && !empty($value3['name']))
                                {
                                    $form_state = false;
                                }
                            }
                        }
                    }
                }
            }  
        }
        if($form_state)
        {
            // Si $validation n'est pas false, on renvoie le tableau des données
            return $form_data;
        }
        else
        {
            // La validation a échoué, on stocke les données temporairement et on renvoie false
            $_SESSION['temp_data'] = $form_data;
            return false;
        }
    }
    
    //***************************************************
    // Vérification des champs requis ($_POST)
    //*************************************************** 
    
    public function checkRequired($data)
    {
        $return = true;
        if(is_array($data))
        {
            foreach($data as $index => $value)
            {
                if(!$this->checkRequired($value))
                {
                    $return = false;
                }
            }
        }
        else
        {
            if(empty($data) && $data !== '0')
            {
                $return = false;
            }
        }
        return $return;
    }
    
    //***************************************************
    // Vérification des champs requis ($_FILES)
    //*************************************************** 
    
    public function checkRequiredFile($data)
    {
        $return = true;
        if(isset($data['name']))
        {
            if($data['error'] != 0 || $data['size'] = 0 || empty($data['name']))
            {
                $return = false;
            }
        }
        elseif(is_array($data))
        {
            foreach($data as $key => $value)
            {
                if(!$this->checkRequiredFile($value))
                {
                    $return = false;
                }
            }
            
        }
        return $return;
    }
                                
    //***************************************************
    // Vérification du format des données attendues
    //*************************************************** 
    
    public function checkFormat($key,$data)
    {
        // Initialisation du retour à true
        $return = true;
        
        // On crée des patterns pour tester les champs de formulaire
        
        // PATTERN EMAIL
        $PATTERN_email            = '/^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*(\.\w{2,})+$/';
        
        // PATTERN ALPHABETIQUE + ACCENTS
        $PATTERN_alpha            = "/^[A-Za-z'’ èéàùçâêûôîäüöïëÈÉÀÙÇÂÊÛÔÎÄÜÖÏË,-.\/()!?:\";*+]*$/";
        
        // PATTERN ALPHABETIQUE + ACCENTS + CHIFFRES
        $PATTERN_alphanum         = "/^[A-Za-z0-9'’ èéàùçâêûôîäüöïëÈÉÀÙÇÂÊÛÔÎÄÜÖÏË,-.°\/()!?:\";*+]*$/";
        
        // PATTERN DATE : JJ-MM-AAAA
        $PATTERN_date             = "/^[\d]{4}\-[\d]{2}\-[\d]{2}$/";
        
        // Si les données sont un tableau, on le parcourt pour vérifier toutes les entrées (récursivement)
        if(is_array($data))
        {
            foreach($data as $index => $value)
            {
                if(!$this->checkFormat($key,$value))
                {
                    $return = false;
                }
            }
        }
        else
        {
            if(!empty($data))
            {
                var_dump($data);
                switch($key)
                {
                    // Type de données attendues : email
                    case 'mail':
                        if(!filter_var($data,FILTER_VALIDATE_EMAIL) || !preg_match($PATTERN_email,$data))
                        {
                            $return = false;
                        }
                    break;

                    // Type de données attendues : url
                    case 'url':
                        if(!filter_var($data,FILTER_VALIDATE_URL))
                        {
                            $return = false;
                        }
                    break;

                    // Type de données attendues : caractères alphabétiques
                    case 'alpha':
                        if(!preg_match($PATTERN_alpha,$data))
                        {
                            $return = false;
                        }
                    break;

                    // Type de données attendues : caractères alphabétiques et numériques
                    case 'alphanum':
                        if(!preg_match($PATTERN_alphanum,$data))
                        {
                            $return = false;
                        }
                    break;

                    // Type de données attendues : date au format AAAA/MM/JJ
                    case 'date':
                        if(!preg_match($PATTERN_date,$data))
                        {
                            $return = false;
                        }
                    break; 
                }
            }
        }
        return $return;
    }
                                
    //***************************************************
    // Vérification du format des données attendues
    //*************************************************** 
    
    public function checkFileFormat($key,$data)
    {
        // Initialisation du retour à true
        $return = true;
        
        if(isset($data['name']) && !empty($data['name']))
        {
            $ext_array = preg_split("/\./",$data['name']);
            $ext = strtolower($ext_array[count($ext_array)-1]);
            switch($key)
            {
                // Type de données attendues : fichier image
                case 'image_normal':
                    $ext_allow = array("jpg", "jpeg", "png");
                break;
            }
            if(!in_array($ext,$ext_allow))
            {
                $return = false;
            }
        }
        elseif(is_array($data))
        {
            foreach($data as $index => $value)
            {
                if(!$this->checkFileFormat($key,$value))
                {
                    $return = false;
                }
            }
            
        }
        return $return;
    }
    
    //***************************************************
    // Renvoi des données ($_POST)
    //*************************************************** 
    
    public function returnData($data, $original = false)
    {
        // Il n'y a pas de données enregistrées à cet index
        if(!$original)
        {
            if(is_array($data))
            {
                foreach($data as $index => $value)
                {
                    $return[$index] = $this->returnData($value);
                }
            }
            else
            {
                $return = $data;
            }
        }
        // Il y a des données enregistrées à cet index
        // On ajoute les nouvelles sans écrases les anciennes
        else
        {
            $return = $original;
            if(is_array($data))
            {
                foreach($data as $index => $value)
                {
                    if(isset($return[$index]) && !empty($return[$index]))
                    {
                        $old_index = $return[$index];
                        $new_index = $this->returnData($value);
                        $return[$index] = array_merge($old_index,$new_index);
                    }
                    else
                    {
                        $return[$index] = $this->returnData($value);
                    }
                    
                }
            }
        }
        return $return;
    }
    
    //***************************************************
    // Renvoi vers la fonction d'enregistrement des fichiers
    // 2 cas : données déjà présentes sur l'index, ou non : fonction récursive
    //*************************************************** 
    
    public function returnFiles($format,$data, $original = false)
    {
        // Il n'y a pas de données enregistrées à cet index
        if(!$original)
        {
            if(isset($data['name']) && !empty($data['name']))
            {
                $files = $this->save_file($format,$data);
            }
            elseif(is_array($data) && !isset($data['name']))
            {
                foreach($data as $index => $value)
                {
                    $returned_file = $this->returnFiles($format,$value);
                    if($returned_file)
                    {
                        $files[$index] = $returned_file;
                    }
                    else
                    {
                        $files = false;
                    }
                }
            }
            else
            {
                return false;
            }
        }
        // Il y a des données enregistrées à cet index
        // On ajoute les nouvelles sans écrases les anciennes
        else
        {
            $files = $original;
            if(is_array($data) && !isset($data['name']))
            {
                foreach($data as $index => $value)
                {
                    if(isset($files[$index]) && !empty($files[$index]))
                    {
                        $old_index = $files[$index];
                        $new_index = $this->returnFiles($format,$value);
                        if($new_index)
                        {
                             $files[$index] = array_merge($old_index,$new_index);
                        }
                    }
                    else
                    {
                        $files[$index] = $this->returnFiles($format,$value);
                    }
                }
            }
            elseif(isset($data['name']) && !empty($data['name']))
            {
                $files = $this->save_file($format,$data);
            }
        }
        return $files;
    }
    
    public function save_file($format,$data)
    {
        // On commence par vérifier le format du fichier pour lui attribuer les données nécessaires
        switch($format) 
        {
            case 'image_normal':
                $width = 800;
                $height = 800;
                $folder = "images";
                $crop = false;
            break;
        }
        
        // *** Enregistrement du fichier selon son type
        switch($format)
        {
            // *** Enregistrement des images
                
            case 'image_normal':
                
                // *** Inclusion de la classe de traitement d'images
                include_once (realpath(__DIR__ . '/..') . '/models/ImageManipulatorClass.php');
                
                // *** Tableau des extensions valides
                $validExtensions = array('.jpg', '.jpeg', '.png');

                // *** Récuperation de l'extension du fichier
                $fileExtension = strtolower(strrchr($data['name'], "."));
                
                // *** Vérification que l'extension du fichier est une extension autorisee
                if (in_array($fileExtension, $validExtensions)) 
                {
                    // *** Définition du répertoire d'enregistrement de l'image
                    $upload_folder = realpath(__DIR__ . '/..') .'/uploads/'.$folder; 

                    // *** Creation / suppression des repertoires
                    if(!is_dir($upload_folder))
                    {
                        mkdir($upload_folder,0777);
                    }

                    // *** Redimensionnement de l'image
                    $manipulator = new ImageManipulator($data['tmp_name']);
                    $newImage = $manipulator->resample($width, $height, $crop);
                    
                    if($crop)
                    {
                        // *** Crop de l'image
                        $widthImg  = $manipulator->getWidth();
                        $heightImg = $manipulator->getHeight();
                        $centreX = round($widthImg / 2);
                        $centreY = round($heightImg / 2);

                        $x1 = $centreX - round($width/2); 
                        $y1 = $centreY - round($height/2); 
                        $x2 = $centreX + round($width/2); 
                        $y2 = $centreY + round($height/2);

                        $newImage = $manipulator->crop($x1, $y1, $x2, $y2);
                        $newImage = $manipulator->enlargeCanvas($width, $height,[255, 255, 255]);
                    }

                    // *** Nettoyage du nom du fichier
                    $final_name = $this->clean_name($data['name'],$fileExtension);

                    // Get image type
                    if($fileExtension === '.jpg' || $fileExtension === '.jpeg')
                    {
                        $image_type = IMAGETYPE_JPEG;
                    }
                    elseif($fileExtension === '.png')
                    {
                        $image_type = IMAGETYPE_PNG;
                    }
                    
                    // saving file to uploads folder
                    $manipulator->save($upload_folder.'/'. $final_name, $image_type);

                    $image_url = 'uploads/'.$folder.'/'. $final_name;
                } 
                else 
                {
                    $image_url = false;
                }
                return $image_url;
            break;
        }
    }
    
    // ========================================================
    // Normalisation du tableau des images
    // =======================================================
    
    public function format_files_array($files)
    {
        $out = [];
        foreach ($files as $key => $file) {
            if (isset($file['name']) && is_array($file['name'])) {
                $new = [];
                foreach (['name', 'type', 'tmp_name', 'error', 'size'] as $k) {
                    array_walk_recursive($file[$k], function (&$data, $key, $k) {
                        $data = [$k => $data];
                    }, $k);
                    $new = array_replace_recursive($new, $file[$k]);
                }
                $out[$key] = $new;
            } else {
                $out[$key] = $file;
            }
        }
        return $out;
    }
    
    // ========================================================
    // Génération d'une chaine de caractères aléatoire
    // =======================================================
    
    private function random_str(
        int $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }
    
    // ========================================================
    // Normalisation du nom du fichier
    // =======================================================
    
    private function clean_name($name,$fileExtension) 
    {
        $tools = new Tools();
        $newNamePrefix = '_'.$this->random_str(6);
        $file_name = str_replace($fileExtension,"",$name);
        $file_name_without_ext = $tools->createSlug($file_name);
        $final_name = $file_name_without_ext . $newNamePrefix . $fileExtension;
        return $final_name;
    }
}
?>