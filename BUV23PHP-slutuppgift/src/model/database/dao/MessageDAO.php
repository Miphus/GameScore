<?php

class MessageDAO
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function sendMessage($senderId, $receiverId, $messageText)
    {
        $query = "INSERT INTO message (sender_id, receiver_id, message_text) VALUES (:senderId, :receiverId, :messageText)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':senderId', $senderId);
        $stmt->bindParam(':receiverId', $receiverId);
        $stmt->bindParam(':messageText', $messageText);
        return $stmt->execute();
    }

    public function getMessagesByUserId($userId)
    {
        $query = "SELECT * FROM message WHERE receiver_id = :userId ORDER BY sent_at DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
