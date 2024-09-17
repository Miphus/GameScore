<?php
ob_start();
require '../src/config.php' ?>
<!doctype html>
<html lang="en">

<head>
<link rel="icon" type="webp" href="../public/img/Logo.webp">
    <title>Gamescore</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="stylesheet" href="../public/CSS/game_details.css">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>

    <div class="container-xxl">
        <header>
            <!-- <img src="img/header-pic.jpg" alt="lololol"> -->
            <div class=header-text>
                <h1>Gamescore</h1>
                <h2>Play, Review, Connect Your Gaming Community Awaits!</h2>
                <h3>Game details</h3>
            </div>
        </header>
        <div class="nav">
            <?php
            echo '<a href="main.php">Home</a>';
            echo '<a href="browse.php">Browse</a>';
            echo '<a href="posterwall.php">Community</a>';
            echo isset($username) ? "<a href='friends.php'>$username</a>" : "";
            echo isset($username) ? "<a href='../src/controller/logoutController.php'>Logout</a>" : "<a href='login.php'>Login</a>";
            ?>
        </div>
        <div class="container">
            <?php
            $gameId = $_GET['id'];
            $games = json_decode(file_get_contents('../public/json/filtered_games.json'), true);
            $game = array_values(array_filter($games, function ($g) use ($gameId) {
                return $g['id'] == $gameId;
            }))[0];
            ?>

            <div class="game-image">
                <img src="<?php echo htmlspecialchars($game['image_background']); ?>" alt="Game image">
                <h1 class="game-name">
                    <?php echo htmlspecialchars($game['name']); ?>
                </h1>
            </div>
            <p class="game-release-date">Release date:
                <?php echo $game['release_date']; ?>
            </p>
            <p class="game-rating">Rating:
                <?php echo $game['rating']; ?>
            </p>
            <p class="game-metacritic">Metacritic:
                <?php echo $game['metacritic']; ?>
            </p>
        </div>
        <div class="comment-section">
            <h1>Comments</h1>
        </div>
        <div class="comments-container">
            <?php
            if (!file_exists('../public/json/comments.json')) {
                file_put_contents('../public/json/comments.json', json_encode([]));
            }

            $json = file_get_contents('../public/json/comments.json');
            $comments = json_decode($json, true);
            $gameComments = $comments[$gameId] ?? [];

            foreach ($gameComments as $comment) {
                echo '<div class="comment">';
                echo '<div class="username">' . htmlspecialchars($comment['username']) . ':</div>';
                echo '<div class="content">' . htmlspecialchars($comment['text']) . '</div>';
                echo '<div class="date">' . "Was posted: " . htmlspecialchars($comment['date']) . '</div>';
                echo '</div>';
            }
            ?>
        </div>
        <?php
        if (isset($_SESSION['username'])) {
            ?>
            <div id="commentForm">
                <form method="post">
                    <textarea name="text" class="text-area-field" placeholder="Write your comment here..." maxlength="70"
                        required></textarea>
                    <button type="submit" class="submit-button">Submit Comment</button>
                </form>
            </div>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = $_SESSION['username'];
                $text = $_POST['text'];
                if (!empty(trim($text))) {
                    $comments[$gameId][] = [
                        'username' => $username,
                        'text' => $text,
                        'date' => date('Y-m-d H:i:s')
                    ];
                    file_put_contents('../public/json/comments.json', json_encode($comments));
                    header("Location: game_details.php?id=$gameId");
                    exit;
                } else {
                    echo '<p>Comment cannot be empty.</p>';
                }
            }
        }
        ob_end_flush();
        ?>
    </div>
</body>

</html>