<?php

class Comment {
    private $comment_id;
    private $post_id;
    private $content;
    private $created_at;
    private $user_id;


    public function getUserId() 
    {
        return $this->user_id;
    }

    public function setUserId($user_id) 
    {
        $this->user_id = $user_id;
    }



    // Getters
    public function getCommentId() {
        return $this->comment_id;
    }

    public function getPostId() {
        return $this->post_id;
    }

    public function getContent() {
        return $this->content;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    // Setters
    public function setCommentId($comment_id) {
        $this->comment_id = $comment_id;
    }

    public function setPostId($post_id) {
        $this->post_id = $post_id;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }
}