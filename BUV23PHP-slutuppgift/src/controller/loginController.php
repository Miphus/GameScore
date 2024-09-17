<?php
require '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $db = new Database();
    $userDao = new UserDAO($db->getPdo());
    $user = $userDao->findUser($username);
    $userRole = $userDao->findRoleByUsername($username);
    
    if ($user && password_verify($password, $user->getPassword())) {
        // Lösenordet är korrekt
        $_SESSION['username'] = $username; // Spara användarnamnet i sessionen
        $_SESSION['role'] = $userRole;
        header('Location: ../../view/friends.php');
         // Anpassa till din skyddade sida
        exit;
    } else {
        echo "<h2>Felaktigt användarnamn eller lösenord</h2>";
    }
}
