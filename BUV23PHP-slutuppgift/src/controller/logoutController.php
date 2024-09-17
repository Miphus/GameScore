<?php
session_start();
session_destroy(); // Förstör sessionen
header('Location: ../../view/main.php'); // Omdirigera till inloggningssidan
exit;
