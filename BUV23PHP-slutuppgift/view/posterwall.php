<?php
require '../src/config.php';
require 'db_connect.php';
// $db = new Database();
// $pdo = $db->getPdo();
$postDAO = new PostDAO($pdo);
$posts = $postDAO->getAllPost();
$commentDAO = new CommentDAO($pdo);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="webp" href="../public/img/Logo.webp">
    <title>Gamescore</title>
    <link rel="stylesheet" href="../public/CSS/posterwall.css">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>

    <div class="container-xxl">

        <header>
            <div class="header-text">
                <h1>Gamescore</h1>
                <h2>Play, Review, Connect Your Gaming Community Awaits!</h2>
                <h3>Community</h3>
            </div>
        </header>

        <div class="nav">
            <a href="main.php">Home</a>
            <a href="browse.php">Browse</a>
            <a href="posterwall.php" class="nav-link-active">Community</a>
            <?php
            echo isset($username) ? "<a href='friends.php'>$username</a>" : "";
            echo isset($username) ? "<a href='../src/controller/logoutController.php'>Logout</a>" : "<a href='login.php'>Login</a>";
            ?>
        </div>

        <div class="wallpost-section">
            <h2>Wallpost Section</h2>
            <div class="form-group">
                <h3>Create a Post</h3>
                <form id="postForm" method="POST" action="../src/controller/posterwallController.php">
                    <textarea name="post-content" id="post-content" placeholder="Write your post here..."></textarea>
                    <input type="text" name="review-link" id="review-link" placeholder="Review Link (optional)">
                    <button type="submit">Post</button>
                </form>
            </div>

            <div class="posts" id="postsContainer">
                <?php foreach ($posts as $post) : ?>
                    <div class="post">
                    <?php if ($post->profilepic) : ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($post->profilepic) ?>" alt="User Profile Picture" />
                        <?php else : ?>
                            <img src="../public/img/placeholder.webp" alt="placeholder.webp" width="50px" height="50px" />
                        <?php endif; ?>
                        <p> user: <?= htmlspecialchars($post->getUserId()) ? htmlspecialchars($post->getUserId()) : "User not found"; ?></p>
                      
                        <div class="title">
                            <h2><?= htmlspecialchars($post->getContent()) ? htmlspecialchars($post->getContent()) : "Content not found"; ?></h2>
                        </div>
                        <div class="link">
                            <a href="<?= htmlspecialchars($post->getReviewLink()) ? htmlspecialchars($post->getReviewLink()) : "#"; ?>">
                                <h3><?= htmlspecialchars($post->getReviewLink()) ? htmlspecialchars($post->getReviewLink()) : "Link not found"; ?></h3>
                            </a>
                        </div>
                        <!-- Comment Form -->
                        <form action="../src/controller/CommentController.php" method="POST">
                            <div class="form-group">
                                <textarea name="comment-content" placeholder="Write your comment here..." required></textarea>
                            </div>
                            <input type="hidden" name="post-id" value="<?= $post->getPostId(); ?>">
                            <button type="submit">Submit Comment</button>
                        </form>

                        <!-- Display comments for this post -->
                        <?php
                        $comments = $commentDAO->getCommentsByPostId($post->getPostId());
                        if (!empty($comments)) : ?>

                            <?php foreach ($comments as $comment) : ?>
                                <div class="comment">
                                    <p><strong>User ID:</strong> <?= htmlspecialchars($comment->getUserId()); ?></p>
                                    <p><?= htmlspecialchars($comment->getContent()); ?></p>
                                    <p><small>Posted on: <?= htmlspecialchars($comment->getCreatedAt()); ?></small></p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

            </div>

        </div>
    </div>

</body>

</html>