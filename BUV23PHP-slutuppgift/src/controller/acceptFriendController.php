<?php

require '../config.php';

$db = new Database();
$friendsReqDAO = new FriendsReqDAO($db->getPdo());

header('Content-Type: application/json'); // Set content type for JSON response

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userA = isset($_SESSION['username']) ? $_SESSION['username'] : null;
    $userB = isset($_POST['userId']) ? $_POST['userId'] : null;

    if ($userA && $userB) {
        try {
            if ($friendsReqDAO->acceptFriendRequest($userA, $userB)) {
                echo json_encode(["message" => "Friend request accepted successfully!"]);
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(["message" => "Failed to accept friend request."]);
            }
        } catch (Exception $e) { // Catch any Exception
            error_log("Exception in accept_friend_request.php: " . $e->getMessage());
            http_response_code(500); // Internal Server Error
            echo json_encode(["message" => "An error occurred while processing your request."]);
        }
    } else {
        http_response_code(422); // Unprocessable Entity
        echo json_encode(["message" => "Invalid data provided."]);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["message" => "Invalid request method."]);
}
