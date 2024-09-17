<?php   

class CommentDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function insertComment(Comment $comment) {
        $sql = "INSERT INTO comment (post_id, content, user_id) VALUES (:post_id, :content, :user_id)";
        $stmt = $this->pdo->prepare($sql);
        // Use the Comment object's getters to retrieve post_id and content
        $postId = $comment->getPostId();
        $content = $comment->getContent();
        $userid = $comment->getUserId();
        $stmt->bindParam(':post_id', $postId);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':user_id', $userid);
        $stmt->execute();
    }
    
    
    
    // Retrieve a comment by its ID
    public function getCommentById($comment_id) {
        $sql = "SELECT * FROM comment WHERE comment_id = :comment_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':comment_id', $comment_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Comment($row['comment_id'], $row['post_id'], $row['content'], $row['created_at']);
    }

    public function getCommentsByPostId($postId) {
        $sql = "SELECT * FROM comment WHERE post_id = :post_id ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Comment');
    }

    // Other methods for updating, deleting, or fetching comments can be added here
}