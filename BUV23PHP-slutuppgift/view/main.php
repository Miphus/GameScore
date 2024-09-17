<?php require '../src/config.php';
require 'db_connect.php';

 // $db = new Database();
    $newsDAO = new NewsDAO($pdo);

    // Get all the articles

    $newsLists = $newsDAO->findAll();

    // $pdo = $db->getPdo();
    $gameDAO = new GameDAO($pdo);
    $games = $gameDAO->getAllGames();

    $topRatedGames = $gameDAO->getTopRatedGames(5);

?>
<!doctype html>
<html lang="en">

<head>
    <link rel="icon" type="webp" href="../public/img/Logo.webp">
    <title>Gamescore</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="stylesheet" href="../public/CSS/main.css">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />




</head>






<body>

    <div class="container-xxl">
        <header>
            <!-- <img src="img/header-pic.jpg" alt="lololol"> -->
            <div class=header-text>
                <h1>Gamescore</h1>
                <h2>Play, Review, Connect Your Gaming Community Awaits!</h2>
                <h3>Home</h3>
            </div>
        </header>
        <div class="nav">
        <a href="main.php" class="nav-link-active">Home </a>
            <a href="browse.php">Browse</a>
            <a href="posterwall.php">Community</a>
            <?php
            echo isset($username) ? "<a href='friends.php'>$username</a>" : "";
            echo isset($username) ? "<a href='../src/controller/logoutController.php'>Logout</a>" : "<a href='login.php'>Login</a>";
            ?>
        </div>

        <div id="main">
            <div class="main-header">

                <!-----Carousel function------>

                <div id="carouselExampleDark" class="carousel carousel-light slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="5000" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="5000">
                            <img src="../public/img/wow.jpg" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h1 class="fs-1">We have the latest news in the gaming world</h1>
                                <h2 class="fs-2">Search your favourite game and learn all from tips and tricks to lore</h2>
                                <h3 class="fs-3">Make friends and join the community</h3>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="5000">
                            <img src="../public/img/overwatch.jpg" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h1>We have the latest news in the gaming world</h1>
                                <h2>search your favourite game and learn all from tips and tricks to lore</h2>
                                <h3>make friends and join the community</h3>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="5000">
                            <img src="../public/img/pubg.jpg" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h1>We have the latest news in the gaming world</h1>
                                <h2>search your favourite game and learn all from tips and tricks to lore</h2>
                                <h3>make friends and join the community</h3>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <!-----Carousel function END------>

            </div>

            <div class="background-image">

                <div class="container">
                    <h1>Latest News</h1>
                    <div class="row justify-content-md-center">
                        <!-- <div class="col"> -->
                        <!-- START: Posts Grid -->
                        <div class="row col-lg-10">
                            <?php foreach ($newsLists as $newsList) : ?>
                                <div class="mb-2 custom-card">
                                    <img class="card-img-top" src="<?php echo $newsList->getImage() ? $newsList->getImage() : '../public/img/placeholder.jpg'; ?>
                                    " alt="<?php echo $newsList->getTitle(); ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $newsList->getTitle(); ?></h5>
                                        <p class="card-text"><?php echo $newsList->getContent(); ?></p>
                                        <p class="card-text-Source"><?php echo $newsList->getSource(); ?></p> <!-- Display Source -->
                                        <p class="card-text-Address"><?php echo $newsList->getAddress(); ?></p> <!-- Display Address -->
                                        <a href="<?php echo $newsList->getUrl(); ?>" class="btn btn-primary">Read More</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>

                        <!-- </div> -->
                        <!-- END: Posts Grid -->

                        <div class="col-lg-2">

                            <h1>TOP-RATED REVIEWS</h1>
                            <!-- START: Fristående Kort -->
                            <div class="row justify-content-md-center">
                                <?php foreach ($topRatedGames as $game) : ?>
                                    <div class="col-md-12">
                                        <div class="card mb-3 custom-card2">
                                            <img src="<?php echo htmlspecialchars($game->getImageBackground()); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($game->getName()); ?>">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo htmlspecialchars($game->getName()); ?></h5>
                                                <p class="card-text">Rating: <?php echo htmlspecialchars($game->getRating()); ?></p>
                                                <p class="card-text">Metacritic: <?php echo htmlspecialchars($game->getMetacritic()); ?></p>
                                                <!-- Lägg till en knapp för att gå till recensionen, liknande den från browse.php -->
                                                <a href="game_details.php?id=<?php echo htmlspecialchars($game->getId()); ?>" class="btn btn-primary">Learn More</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <!-- END: Fristående Kort -->


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>