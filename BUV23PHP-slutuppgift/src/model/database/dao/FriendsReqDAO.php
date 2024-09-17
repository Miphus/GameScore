<?php

class FriendsReqDAO
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function sendFriendRequest($userA, $userB)
    {
        $query = "INSERT INTO friend (user_id_a, user_id_b, status, created_at)
              VALUES (:user_id_a, :user_id_b, 'pending', current_timestamp())";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user_id_a', $userA);
        $stmt->bindParam(':user_id_b', $userB);

        try {
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Failed to execute the query");
            }
        } catch (Exception $e) {

            return false;
        }
    }

    public function getFriendRequests($userB)
    {
        $query = "SELECT user_id_a, created_at
        FROM friend
        WHERE user_id_b = :user_id_b
        AND status = 'pending'";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user_id_b', $userB, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function acceptFriendRequest(string $userA, string $userB): bool
    {
        $query = "UPDATE friend
          SET status = :new_status
          WHERE (user_id_a = :user_id_a1 AND user_id_b = :user_id_b1)
             OR (user_id_a = :user_id_b2 AND user_id_b = :user_id_a2)
          AND status = :current_status";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user_id_a1', $userA);
        $stmt->bindParam(':user_id_b1', $userB);
        $stmt->bindParam(':user_id_a2', $userA);
        $stmt->bindParam(':user_id_b2', $userB);
        $stmt->bindValue(':new_status', 'accepted');
        $stmt->bindValue(':current_status', 'pending');
        $stmt->execute();


        $query = "INSERT INTO friend (user_id_a, user_id_b, status, created_at)
              VALUES (:user_id_a, :user_id_b, 'accepted', current_timestamp())";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user_id_a', $userA);
        $stmt->bindParam(':user_id_b', $userB);

        try {
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("PDOException in acceptFriendRequest: " . $e->getMessage());
            error_log("Error Code: " . $e->getCode());
            return false;
        }
    }
}
