<?php

class FriendsDAO
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getFriendsByUserId($userId)
    {
        $query = "SELECT user.id, user.email, user.profilepic, friend.status
                  FROM friend
                  JOIN user ON friend.user_id_b = user.id
                  WHERE friend.user_id_a = :userId
                    AND friend.status = 'accepted'";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
