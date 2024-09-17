<?php

class Post
{

    private $post_id;
    private $user_id;
    private $content;
    private $created_at;
    private $review_link; // Added review_link property

    // Getter and setter for post_id
    public function getPostId()
    {
        return $this->post_id;
    }

    public function setPostId($post_id)
    {
        $this->post_id = $post_id;
    }

    // Getter and setter for user_id
    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    // Getter and setter for content
    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    // Getter for created_at (typically, only a getter is needed)
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    // Getter and setter for review_link
    public function getReviewLink()
    {
        return $this->review_link;
    }

    public function setReviewLink($review_link)
    {
        $this->review_link = $review_link;
    }
}