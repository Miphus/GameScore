<?php
class GameDAO
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function add(Game $game): void
    {
    $sql = "INSERT INTO game (id, name, release_date, rating, metacritic, image_background, updated) VALUES (:id, :name, :release_date, :rating, :metacritic, :image_background, :updated)";
    $statement = $this->pdo->prepare($sql);
    $statement->bindValue(":id", $game->getId(), PDO::PARAM_INT);
    $statement->bindValue(":name", $game->getName());
    $statement->bindValue(":release_date", $game->getReleaseDate());
    $statement->bindValue(":rating", $game->getRating());
    $statement->bindValue(":metacritic", $game->getMetacritic());
    $statement->bindValue(":image_background", $game->getImageBackground());
    $statement->bindValue(":updated", $game->getUpdated());
    $statement->execute();
    }
    public function getAllgames(): array
    {
        $sql = "SELECT * FROM game";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $game = $statement->fetchAll(PDO::FETCH_CLASS, Game::class);
        return $game;
    }
    public function find(int $id): ?Game
    {
        $sql = "SELECT * FROM game WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();
        $game = $statement->fetchObject(Game::class);

        return $game ?: null;
    }

    public function findByName(string $name): ?Game
    {
        $sql = "SELECT * FROM game WHERE name = :name";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(":name", $name);
        $statement->execute();
        $game = $statement->fetchObject(Game::class);
        return $game ?: null;
    }

    public function getTopRatedgames(int $limit = 3): array {
        $sql = "SELECT * FROM game ORDER BY rating DESC, metacritic DESC LIMIT :limit";
        $statement = $this->pdo->prepare($sql);
        // Bind param as integer
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, Game::class);
    }
    


}