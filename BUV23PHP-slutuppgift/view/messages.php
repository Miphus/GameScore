<?php
require_once '../src/config.php';
?>
<!doctype html>
<html lang="en">

<head>
    <title>Messages</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" type="webp" href="../public/img/Logo.webp">
    <link rel="stylesheet" href="../public/CSS/friends.css">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.reply-btn').click(function() {
                var senderId = $(this).data('sender-id');
                $('#replyModal').modal('show');

                $('#sendReply').off('click').on('click', function() {
                    var replyText = $('#reply-message-text').val();

                    $('#reply-message-text').val('');

                    // AJAX request to send the reply
                    $.ajax({
                        url: '../src/controller/messageController.php', // Use the same controller as for sending messages
                        type: 'POST',
                        data: {
                            receiverId: senderId, // The original sender becomes the receiver of the reply
                            messageText: replyText
                        },
                        success: function(response) {
                            console.log(response);
                            $('#replyModal').modal('hide');
                            // Optionally, refresh the messages list or show a success message
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
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

        <div class="main">
            <div class="container">
                <img class="profile" src="../public/img/placeholder.webp" alt="profile picture">
                <h1><?php echo $username ?></h1>
            </div>
        </div>

        <div class="container" id="message-container">
            <h1>Messages</h1>
            <?php



            $userId = $_SESSION['username'];

            $db = new Database();
            $pdo = $db->getPdo();
            $messageDAO = new MessageDAO($pdo);
            $messages = $messageDAO->getMessagesByUserId($userId);

            if (!empty($messages)) {
                foreach ($messages as $message) {
                    echo "<div class='message'>";
                    echo "<p>From: " . $message['sender_id'] . "</p>";
                    echo "<p>Message: " . $message['message_text'] . "</p>";
                    echo "<p>Sent at: " . $message['sent_at'] . "</p>";

                    echo "<button class='buttons reply-btn' data-sender-id='" . $message['sender_id'] . "'>Reply</button>";
                    echo "</div>";
                }
            } else {
                echo "<p>No messages found.</p>";
            }
            ?>
        </div>
        <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="replyModalLabel">Reply Message</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <textarea class="form-control" id="reply-message-text"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="buttons" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="buttons" id="sendReply">Send Reply</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>