<?php
require '../src/config.php';
require 'db_connect.php';

// $db = new Database();
$friendsReqDAO = new FriendsReqDAO($pdo);
$friendRequests = $friendsReqDAO->getFriendRequests($username);
?>

<!doctype html>
<html lang="en">

<head>
    <title>Gamescore</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" type="webp" href="../public/img/Logo.webp">
    <link rel="stylesheet" href="../public/CSS/friends.css">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".accept-friend").click(function() {
                var userId = $(this).data("user-id");
                var cardSelector = "#friendRequestCard_" + userId;

                $.ajax({
                    url: '../src/controller/acceptFriendController.php',
                    type: 'POST',
                    data: {
                        userId: userId
                    },
                    success: function(response) {
                        if (response.message === "Friend request accepted successfully!") {
                            $(cardSelector).fadeOut("slow", function() {
                                $(this).remove();
                                getFriendsByUserId($username);
                            });
                        } else {
                            alert('Failed to accept the friend request.');
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
</head>

<body>

    <div class="container-xxl">
        <header>
            <!-- <img src="img/header-pic.jpg" alt="lololol"> -->
            <div class=header-text>
                <h1>Gamescore</h1>
                <h2>Play, Review, Connect Your Gaming Community Awaits!</h2>
                <h3>Profile</h3>
            </div>
        </header>
        <div class="nav">
        <a href="main.php">Home</a>
            <a href="browse.php">Browse</a>
            <a href="posterwall.php">Community</a>
            <?php
            echo isset($username) ? "<a href='friends.php' class='nav-link-active'>$username</a>" : "";
            echo isset($username) ? "<a href='../src/controller/logoutController.php'>Logout</a>" : "<a href='login.php'>Login</a>";
            ?>
        </div>


        <div id="friend">
            <div class="container">
                <div class="row justify-content-center">
                    <?php foreach ($friendRequests as $friend) : ?>
                        <div class="col-lg-3 col-md-3 col-sm-6">
                            <div class="card mb-4" id="friendRequestCard_<?php echo $friend['user_id_a']; ?>">
                                <div class="card-body">
                                    <img src="../public/img/profile.jpg" alt="Profile Picture">
                                    <p>User ID: <?php echo $friend['user_id_a']; ?></p>
                                    <a href="#" class="buttons accept-friend" data-user-id="<?php echo $friend['user_id_a']; ?>">Accept Friend</a>
                                    <?php
                                    $friendsDAO = new FriendsDAO($pdo);
                                    $friends = $friendsDAO->getFriendsByUserId($username);
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>


    </div>











    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>