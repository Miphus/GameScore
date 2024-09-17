<?php
require '../config.php';

$db = new Database();
$pdo = $db->getPdo();
$postDAO = new PostDAO($pdo);
$commentDAO = new CommentDAO($pdo);



// Initialize your PDO connection
// Assuming $pdo is your PDO object from your database connection setup

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment-content'], $_POST['post-id'])) {
    $commentContent = trim($_POST['comment-content']);
    $postId = trim($_POST['post-id']);

    // Simple validation (You should implement more robust validation)
    if (empty($commentContent) || !is_numeric($postId)) {
        // Handle error - for example, redirect back with an error message
        header('Location: yourPostsPage.php?error=Invalid input');
        exit();
    }

    // Error%20adding%20comment

    // Validate that the post exists
    $postDAO = new PostDAO($pdo);
    $post = $postDAO->getPostById($postId);
    if (!$post) {
        // Redirect or error handling if the post doesn't exist
        header('Location: yourPostsPage.php?error=Post not found');
        exit();
    }

    // Create a new Comment object and set its properties
    $comment = new Comment();
    $comment->setPostId($postId);
    $comment->setContent($commentContent);
    $comment->setUserId($username);
    // Assuming the created_at field is handled within your database as a timestamp (e.g., CURRENT_TIMESTAMP)

    // Use CommentDAO to insert the comment into the database
    $commentDAO = new CommentDAO($pdo);
    try {
        $commentDAO->insertComment($comment);
        // Redirect back to the posts page or wherever appropriate after successful insertion
        header('Location: ../../view/posterwall.php');
        exit();
    } catch (Exception $e) {
        // Handle error - for example, log the error and redirect back with an error message
        header('Location: yourPostsPage.php?error=Error adding comment');
        exit();
    }
} else {
    // Redirect or error handling if the necessary POST data isn't set
    header('Location: yourPostsPage.php?error=Invalid request');
    exit();
}
