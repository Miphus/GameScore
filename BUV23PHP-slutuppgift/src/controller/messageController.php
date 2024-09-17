<?php
require_once '../config.php';


$senderId = $_SESSION['username'];
$receiverId = $_POST['receiverId'];
$messageText = $_POST['messageText'];

if (!empty($receiverId) && !empty($messageText)) {
    $db = new Database();
    $pdo = $db->getPdo();
    $messageDAO = new MessageDAO($pdo);

    if ($messageDAO->sendMessage($senderId, $receiverId, $messageText)) {
        echo "Message sent successfully";
    } else {
        echo "Error sending message";
    }
} else {
    echo "Required fields are missing";
}
