<?php

require '../src/config.php';

$database = new Database();
$pdo = $database->getPdo();
$gameDAO = new GameDAO($pdo);

$jsonData = file_get_contents('../public/json/filtered_games.json');
$gamesData = json_decode($jsonData, true);

foreach ($gamesData as $gameData) {
    if ($gameDAO->find($gameData['id'])) {
        continue;
    }

    $game = new Game();
    $game->setId($gameData['id']);
    $game->setName($gameData['name']);
    $game->setImageBackground($gameData['image_background']);
    $game->setReleaseDate($gameData['release_date']);
    $game->setRating($gameData['rating']);
    $game->setMetacritic($gameData['metacritic']);
    $game->setUpdated($gameData['updated']);
    $gameDAO->add($game);
}

echo 'All games added successfully.';
header('Location: browse.php');
exit;