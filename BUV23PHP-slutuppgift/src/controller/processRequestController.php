<?php
require '../config.php';

$db = new Database();
$friendsReqDAO = new FriendsReqDAO($db->getPdo());

// Get data from the AJAX request
$userB = $_POST['friendUsername'];

$userA = $_SESSION['username'];


$result = $friendsReqDAO->sendFriendRequest($userA, $userB);

if ($result) {
    echo "Friend request sent successfully!";
} else {
    echo "Error sending friend request.";
}
