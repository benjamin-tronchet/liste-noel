<?php
    function chargerClasses($classname) 
    {
        require(realpath(__DIR__ . '/..').'/models/'.$classname.'.php');
    }

    spl_autoload_register('chargerClasses');

    include_once realpath(__DIR__).'/../includes/inc_config.php';

    $manager = new UserManager(DB_USERS);
    $value = $_POST['value'];

    $return = [
        "error" => false
    ];
    
    if(filter_var($value,FILTER_VALIDATE_EMAIL))
    {
        if(!$manager->get($value))
        {
            header('HTTP/1.1 403 Forbidden');
            $return = [
                "error" => true,
                "message"   => "Cette adresse mail n'est rattachée à aucun compte."
            ];
            
        }
    }

    echo json_encode($return);
?>