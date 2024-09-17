<?php
require '../src/config.php';
require 'db_connect.php';
// $db = new Database();
// $pdo = $db->getPdo();
$gameDAO = new GameDAO($pdo);

$term = $_POST['term'];
$games = $gameDAO->getAllGames();


$filteredGames = array_filter($games, function($game) use ($term) {
    return strpos(strtolower($game->getName()), strtolower($term)) !== false;
});

$gamesPerRow = 4;
$gameCount = 0;

foreach ($filteredGames as $game) {
    $gameName = htmlspecialchars($game->getName());
    $gameImage = htmlspecialchars($game->getImageBackground());
    $gameId = htmlspecialchars($game->getId());
    $released = htmlspecialchars($game->getReleaseDate());

    if ($gameCount % $gamesPerRow == 0) {
        echo "<div class='row justify-content-center'>";
    }

    echo "<div class='col-lg-3 col-md-3 col-sm-6'>";
    echo "<div class='card mb-4' style='width: 18rem;'>";
    echo "<img src='{$gameImage}' class='card-img-top' alt='Game Image'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>{$gameName}</h5>";
    echo '<p class="card-text">' . "Released:  " . $released . '</p>';
    echo "<a href='game_details.php?id={$gameId}' class='btn btn-primary'>Learn More</a>";
    echo "</div>";
    echo "</div>";
    echo "</div>";

    if ($gameCount % $gamesPerRow == $gamesPerRow - 1) {
        echo "</div>";
    }

    $gameCount++;
}

if ($gameCount % $gamesPerRow != 0) {
    echo "</div>";
}

