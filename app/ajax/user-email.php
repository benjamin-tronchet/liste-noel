<?php

    function chargerClasses($classname) 
    {
        require(realpath(__DIR__ . '/..').'/models/'.$classname.'.php');
    }

    spl_autoload_register('chargerClasses');

    include_once realpath(__DIR__).'/../includes/inc_config.php';

    session_start();

    $manager = new UserManager(DB_USERS);
    $value = $_POST['value'];

    $return = [
        "error" => false
    ];

    $user_email = '';
    if(isset($_SESSION['user']))
    {
        $user_email = $_SESSION['user']->email();
    }

    
    if(filter_var($value,FILTER_VALIDATE_EMAIL))
    {
        if($manager->get($value) && $value !== $user_email)
        {
            header('HTTP/1.1 403 Forbidden');
            $return = [
                "error" => true,
                "message"   => "Cette adresse mail est déjà utilisée."
            ];
            
        }
    }
    echo json_encode($return);
?>