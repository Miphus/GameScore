<?php 
require '../config.php';
$db = new Database();
$pdo = $db->getPdo();
$postDAO = new PostDAO($pdo);
$posts = $postDAO->getAllPost();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['post-content'] ?? '';
    $reviewLink = $_POST['review-link'] ?? '';


    $post = new Post();
    $post->setUserId($username); // Assuming the setter method is named setUserId
    $post->setContent($content);
    $post->setReviewLink($reviewLink);

    try {
        $postDAO->insertPost($post); // Assuming insertPost expects a Post object
        header('Location: ../../view/posterwall.php'); // Anpassa till din skyddade sida
      
    } catch (Exception $e) {
        // Log the error or handle it as per your logging strategy
        echo "error: Failed to add post"; // Simple text response indicating failure
    }
    exit; // Stop script execution after handling POST request
}

