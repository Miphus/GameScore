<?php
require '../config.php';

// Kontrollera om användarnamnet är tillgängligt och är inloggat
if (isset($_POST['adminkey']) && isset($_SESSION['username'])) {
    $adminkey = $_POST['adminkey'];
    $expectedAdminKey = "alfakrull";
    
    if ($adminkey === $expectedAdminKey) {
        $db = new Database();
        $userDao = new UserDAO($db->getPdo());

        try {
            // Sätter user till admin-status
            $userDao->makeAdmin($username);
            $_SESSION['role'] = 'admin';
            // Redirect till en bekräftelsesida eller någon annan sida efter åtgärden
            header('Location: ../../view/friends.php');
            exit; // Det är viktigt att avsluta skriptet efter en header-redirect
        } catch (Exception $e) {
            // Hantera eventuella fel här
            echo "An error occurred: " . $e->getMessage();
        }
    } else {
        echo "Invalid admin key provided.";
        http_response_code(404);
        // header('ErrorDocument 500 "The server made a boo boo.');
        
    }
} else {
    // Om användarnamn eller adminkey inte är tillgängliga eller är tomma
    echo "User not logged in, username not provided, or admin key not provided.";
}
