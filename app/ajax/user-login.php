<?php
    function chargerClasses($classname) 
    {
        require(realpath(__DIR__ . '/..').'/models/'.$classname.'.php');
    }

    spl_autoload_register('chargerClasses');

    include_once realpath(__DIR__).'/../includes/inc_config.php';

    $manager = new UserManager(DB_USERS);
    $tools = new Tools();

    $value = $_POST['value'];

    $return = [
        "error" => false
    ];
    
    
    if($manager->get($value))
    {
        header('HTTP/1.1 403 Forbidden');
        $return = [
            "error" => true,
            "message"   => "Ce nom est déjà utilisé, choisis-en un autre"
        ];

    }

    echo json_encode($return);
?>