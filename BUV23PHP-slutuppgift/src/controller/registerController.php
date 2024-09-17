<?php
require '../config.php';
require 'validation.php';

// Funktion för att omdirigera tillbaka till register.php med ett felmeddelande
function redirectWithError($error) {
    header('Location: ../../view/register.php');
    //?error=' . urlencode($error)
    exit;
}

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Använd valideringsfunktionerna
//     if (!validateUsername($_POST["username"])) {
//         redirectWithError("Username is required");
//     }

//     if (!validateEmail($_POST["email"])) {
//         redirectWithError("Valid email is required");
//     }

//     if (!validatePassword($_POST["password"])) {
//         redirectWithError("Password must be at least 8 characters and contain at least one letter and one number");
//     }

//     if (!passwordsMatch($_POST["password"], $_POST["password_confirmation"])) {
//         redirectWithError("Passwords must match");
//     }
// }

//skapa User-objektet och använda UserDAO för att spara användaren
$user = new User();
$user->setUsername($_POST['username']);
$user->setPassword($_POST['password']);
$user->setEmail($_POST['email']);

$db = new Database();
$userDao = new UserDAO($db->getPdo());
try {
    $userDao->addUser($user);
    header('Location: ../../view/login.php?success=1');
    exit;
} catch (Exception $e) {
    redirectWithError("An error occurred, please try again.");
}
