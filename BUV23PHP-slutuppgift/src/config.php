<?php
$lifetime=600;
session_start();
setcookie(session_name(),session_id(),time()+$lifetime); //refreshar afk tiden till 10 min varje gång du hoppar in på en ny sida

$username = null;
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

$userRole = null;

if (isset($_SESSION['role'])) {
    $userRole = $_SESSION['role'];
    // använda till if för att kolla rollen user/admin
    // echo $userRole;
}   
spl_autoload_register(function ($className) {

    $basePath = __DIR__;
    
    $paths = [
        $basePath . "/controller/" . $className . ".php",
        $basePath . "../view/" . $className . ".php",
        $basePath . "/model/database/" . $className . ".php",
        $basePath . "/model/database/dao/" . $className . ".php",
        $basePath . "/model/database/entity/" . $className . ".php",
    ];
    
    foreach ($paths as $file) {
        $file = str_replace('/', DIRECTORY_SEPARATOR, $file);
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
        // echo $file . '<BR>';

        if (file_exists($file)) {
            require_once $file;
            
            break;
        }
    }
    
});

//ev bool för att kolla om man är inloggad

//http://localhost/BUV23PHP-slutuppgift/src/config/src/config/model/database/

//klistra in php raden här nedan längst upp på sidan:
/*<?php require 'src/config.php' ?>*/

//echo för att testa så den laddar in:
// echo 'test från autoloader';

