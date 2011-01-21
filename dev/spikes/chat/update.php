<?php

if (isset($_GET['after'])) {
    $after = $_GET['after'];

    $conn = new mysqli('localhost', 'root', 'toor', 'sandscape');

    if ($conn->connect_error) {
        die('Connect Error (' . $conn->connect_errno . ') '
                . $conn->connect_error);
    }

    if (($result = $conn->query("
            SELECT Message.messageId,
                   Message.stamp,
                   Message.message
              FROM Message
             WHERE Message.messageId > $after"))) {

        $messages = array();
        while (($temp = $result->fetch_object())) {
            $messages[] = $temp;
        }

        exit(json_encode($messages));
    }
}
?>
