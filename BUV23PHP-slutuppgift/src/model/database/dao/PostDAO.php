<?php

class PostDAO
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insertPost(Post $post)
    {
        $sql = "INSERT INTO post (user_id, content, review_link) VALUES (:user_id, :content, :review_link)";
        $stmt = $this->pdo->prepare($sql);
        $userId = $post->getUserId();
        $content = $post->getContent();
        $reviewLink = $post->getReviewLink();

        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':review_link', $reviewLink);


        $stmt->execute();
    }

    public function getAllPost(): array
    {
        // Updated SQL query to join the `post` and `user` tables and select the profile picture
        $sql = "SELECT post.*, user.profilepic FROM post JOIN user ON post.user_id = user.id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        // Assuming you have a Post class that can handle the additional profilepic property
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Post');
    }

    // public function updatePost(Post $post)
    // {
    //     $sql = "UPDATE post SET user_id = :user_id, content = :content, review_link = :review_link WHERE post_id = :post_id";
    //     $stmt = $this->pdo->prepare($sql);
    //     $stmt->bindParam(':user_id', $post->getUserId());
    //     $stmt->bindParam(':content', $post->getContent());
    //     $stmt->bindParam(':review_link', $post->getReviewLink()); // Update review_link
    //     $stmt->bindParam(':post_id', $post->getPostId());
    //     $stmt->execute();
    // }

    public function getPostById($postId) {
        $sql = "SELECT * FROM post WHERE post_id = :post_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Post');
        return $stmt->fetch();
    }
}
