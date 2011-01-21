<?php

if (isset($_POST['message'])) {
    $message = $_POST['message'];
    $conn = new mysqli('localhost', 'root', 'toor', 'sandscape');

    if ($conn->connect_error) {
        die('Connect Error (' . $conn->connect_errno . ') '
                . $conn->connect_error);
    }

    $conn->query("INSERT INTO Message (`message`,  `gameId`, `userId`) VALUES ('$message', 1, 1)");
}
?>
