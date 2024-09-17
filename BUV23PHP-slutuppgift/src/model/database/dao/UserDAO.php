<?php
class UserDAO{

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function addUser(User $user) : void {
        // Hasha lösenordet
        $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (id, password, email) VALUES (:username, :password, :email)";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(":username", $user->getUsername());
        $statement->bindValue(":password", $hashedPassword);
        $statement->bindValue(":email", $user->getEmail());
        $statement->execute();
    }

    public function findUser($username) : ?User {
        $sql = "SELECT * FROM user WHERE id = :username";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(":username", $username);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, User::class);
        return $statement->fetch();
    }

    public function deleteUserByUsername(string $username): bool {
        $sql = "DELETE FROM user WHERE id = :username";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(":username", $username);
        return $statement->execute();
    }

    public function makeAdmin($username) : void {
        $sql = "UPDATE `gamescore`.`user` SET `role` = 'admin' WHERE id = :username";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(":username", $username);
        $statement->execute();
    }

    public function findRoleByUsername($username) : ?string {
        $sql = "SELECT role FROM user WHERE id = :username"; // Ändra 'username' till 'id' om det är en ID-sökning
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(":username", $username); // Bind the correct parameter
        $statement->execute(); // Don't forget to execute the statement
        $user = $statement->fetch();

        $userRole = $user ? $user['role'] : null;
        return $userRole;

        // if ($user) {
        //     return $user['role']; // Assuming 'role' is the column name in your database
        // } else {
        //     return null; // Or throw an exception, or handle as you see fit
        // }
    }
}