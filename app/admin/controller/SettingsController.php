<?php
session_start();
include ($_SESSION['basedir'] . 'MainController.php');


$admin_name = $admin_firstname = $admin_mail = $admin_pass = '';
$user_name = $user_firstname = $user_mail = $user_pass = '';
$site_name = $site_mail = $site_domain = $site_url = $site_srcimg = $site_colorimg = '';

if (($_SERVER["REQUEST_METHOD"] == "POST") && ($is_admin)) {
    
    if(isset($_POST['configForm'])){

        // admin
        $admin_name          = test_input($_POST['admin_name']);
        $admin_firstname     = test_input($_POST['admin_firstname']);
        $admin_mail          = test_email($_POST['admin_mail']);
        $admin_pass          = test_pass($_POST['admin_pass']);
        // author
        $user_name           = test_input($_POST['user_name']);
        $user_firstname      = test_input($_POST['user_firstname']);
        $user_mail           = test_email($_POST['user_mail']);
        $user_pass           = test_pass($_POST['user_pass']);
        /// site
        $site_name           = test_input($_POST['site_name']);
        $site_mail           = test_email($_POST['site_mail']);
        $site_domain         = test_input($_POST['site_domain']);
        $site_url            = test_url($_POST['site_url']);
        $site_srcimg         = test_input($_POST['site_srcimg']);
        $site_colorimg       = test_input($_POST['site_colorimg']);
        
        // array
        $user = '$user';
        $site = '$site';

        $array = 
"<?php
class Config {
    public $user =  
        [
            1 => [
                'id'        => 1,
                'name'      => '$admin_name',
                'firstname' => '$admin_firstname',
                'mail'      => '$admin_mail',
                'pass'      => '$admin_pass',
                'role'      => 'admin'
            ],
            2 => [
                'id'        => 2,
                'name'      => '$user_name',
                'firstname' => '$user_firstname',
                'mail'      => '$user_mail',
                'pass'      => '$user_pass',
                'role'      => 'author'
            ]
        ];
     public $site =  
         [
            'name'          => '$site_name',
            'mail'          => '$site_mail',
            'domain'        => '$site_domain',
            'url'           => '$site_url',
            'srcimg'        => '$site_srcimg',
            'colorimg'      => '$site_colorimg'
        ];
};
?>";
    
    file_put_contents("../class/ConfigClass.php", $array);
    header('Location:../index.php?page=settings&msgsystem=success_update-config');
    exit;
    }    

    //$string_data = serialize($array);
    //file_put_contents("post/filename.php", $string_data);
    //
    //$string_data = file_get_contents("post/filename.php");
    //$array = unserialize($string_data);
    
    //var_dump($array);


} else { // if not admin
    
    header('Location:../index.php');
    exit;
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = htmlentities($data, ENT_QUOTES, "UTF-8");
  return $data;
}

function test_pass($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = htmlentities($data, ENT_QUOTES, "UTF-8");
  return $data;
}


function test_email($data) {
  $data = trim($data);
  $data = stripslashes($data);
  filter_var($data, FILTER_SANITIZE_EMAIL);
  return $data;
}

function test_url($data) {
  $data = trim($data);
  $data = rtrim($data, '/\\');
  $data = stripslashes($data);
  filter_var($data, FILTER_SANITIZE_URL);
  return $data;
}


?>
