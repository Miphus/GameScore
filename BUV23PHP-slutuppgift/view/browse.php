<?php require '../src/config.php';
require 'db_connect.php';

$gameDAO = new GameDAO($pdo);
$games = $gameDAO->getAllGames();
?>
<!doctype html>
<html lang="en">
<script src="https://unpkg.com/vanilla-tilt@1.7.0"></script>
<script src="../public/js/Browse.js"></script>

<?php
$filteredGamesFilePath = '../public/json/filtered_games.json';

if (!file_exists($filteredGamesFilePath)) {
    $apiKey = "43e773150eda4c50b462a6d47a38e5d9";
    $numPages = 10;
    $games = [];

    for ($i = 1; $i <= $numPages; $i++) {
        $url = "https://api.rawg.io/api/games?key=" . $apiKey . "&page=" . $i;
        $json = file_get_contents($url);
        $data = json_decode($json, true);

        if ($data && isset($data['results'])) {
            foreach ($data['results'] as $game) {
                $games[] = [
                    'id' => $game['id'],
                    'name' => $game['name'],
                    'release_date' => $game['released'],
                    'rating' => $game['rating'],
                    'metacritic' => $game['metacritic'],
                    'updated' => $game['updated'],
                    'image_background' => $game['background_image'],
                ];
            }
        }
    }

    file_put_contents($filteredGamesFilePath, json_encode($games, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}

//$games = json_decode(file_get_contents($filteredGamesFilePath), true);
?>

<head>
    <link rel="icon" type="webp" href="../public/img/Logo.webp">
    <title>Gamescore</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="stylesheet" href="../public/CSS/browse.css">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <div class="container-xxl">
        <header>
            <div class=header-text>
                <h1>Gamescore</h1>
                <h2>Play, Review, Connect Your Gaming Community Awaits!</h2>
                <h3>Browse</h3>
            </div>
        </header>
        <div class="nav">
            <a href="main.php">Home</a>
            <a href="browse.php" class="nav-link-active">Browse</a>
            <a href="posterwall.php">Community</a>
            <?php
            echo isset($username) ? "<a href='friends.php'>$username</a>" : "";
            echo isset($username) ? "<a href='../src/controller/logoutController.php'>Logout</a>" : "<a href='login.php'>Login</a>";
            ?>
        </div>

        <div id="main">
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-4">
                    <input type="text" id="search" placeholder="Search" class="form-control search-input">
                </div>
                <div class="col-lg-9 col-sm-6 col-8 d-flex justify-content-end">
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
                    <form action="import_games.php" method="post">
                        <input type="submit" value="Import Games From Json" class="btn btn-primary bg-dark button-browse">
                    </form>
                    <?php endif; ?>
                </div>
            </div>

            <div class="container" id="game-list">
                <div class="row justify-content-center">
                    <?php

                    //$games = json_decode(file_get_contents('filtered_games.json'), true);
                    $gamesPerPage = 20;
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
                    $offset = ($page - 1) * $gamesPerPage;

                    $games = $gameDAO->getAllGames($gamesPerPage, $offset);

                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                    } else {
                        $page = 1;
                    }

                    $totalPages = ceil(count($games) / $gamesPerPage); // 100 / 20 = 5
                    $start = ($page - 1) * $gamesPerPage; // 0, 20, 40, 60, 80
                    $games = array_slice($games, $start, $gamesPerPage); // 0-19, 20-39, 40-59, 60-79, 80-99

                    foreach ($games as $game) {
                        echo '<div class="col-lg-3 col-md-4 col-sm-6">';
                        echo '<div class="card mb-4">';
                        $image = $game->getImageBackground() ? $game->getImageBackground() : '../public/img/placeholder.jpg';
                        echo '<img class="card-img-top" src="' . $image . '" alt="Card image" loading="lazy">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . htmlspecialchars($game->getName()) . '</h5>';
                        //$description = $game->getShortDescription() ? $game->getShortDescription() : 'No description available.';
                        $released = $game->getReleaseDate() ? $game->getReleaseDate() : 'No release date available.';
                        echo '<p class="card-text">' . "Released:  " . htmlspecialchars($released) . '</p>';
                        echo '<a href="game_details.php?id=' . $game->getId() . '" class="btn btn-primary">Learn More</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>

                <div class="pagination">
                    <?php
                    for ($i = 1; $i <= $totalPages; $i++) { // 1, 2, 3, 4, 5
                        if ($i == $page) {
                            echo "<a href='?page=" . $i . "' class='active'>" . $i . "</a> ";
                        } else {
                            echo "<a href='?page=" . $i . "'>" . $i . "</a> ";
                        }
                    }
                    ?>
                </div>

            </div>
        </div>

    </div>
    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search').on('input', function() {
                var term = $('#search').val();
                if (term) {
                    $.ajax({
                        url: 'search_games.php',
                        type: 'POST',
                        data: {
                            term: term
                        },
                        success: function(data) {
                            $('#game-list').html(data);

                            setTimeout(function() {
                                VanillaTilt.init(document.querySelectorAll(".card"), {
                                    max: 20,
                                    speed: 400,
                                    glare: true,
                                    "max-glare": 0.4
                                });
                                VanillaTilt.init(document.querySelectorAll("#main .btn"), {
                                    max: 20,
                                    speed: 400,
                                    perspective: 1000,
                                    scale: 1.2,
                                });
                            }, 0);
                        }
                    });
                } else {
                    location.reload();
                }
            });
        });
    </script>
</body>

</html>