<?php
    function chargerClasses($classname) 
    {
        require(realpath(__DIR__ . '/..').'/models/'.$classname.'.php');
    }

    spl_autoload_register('chargerClasses');

    include_once realpath(__DIR__).'/../includes/inc_config.php';

    session_start();

    $manager = new UserManager(DB_USERS);
    $tools = new Tools();

    $value = $tools->createSlug($_POST['value']);

    $return = [
        "error" => false
    ];

    $username = '';
    if(isset($_SESSION['user']))
    {
        $username = $tools->createSlug($_SESSION['user']->username());
    }
    
    if($manager->get($value) && $value !== $username)
    {
        header('HTTP/1.1 403 Forbidden');
        $return = [
            "error" => true,
            "message"   => "Ce nom est déjà utilisé, choisis-en un autre"
        ];

    }

    echo json_encode($return);
?>