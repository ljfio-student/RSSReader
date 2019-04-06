<?php
if (!isset($_COOKIE["session"])) {
    // Not authorised
}

include('../database.php');

$token = $_COOKIE["session"];

$user_statement = $database->prepare("SELECT `user_id` FROM `session` WHERE `token` = :token");
$user_statement->execute([":token" => $token]);

if ($user_statement->rowCount() != 1) {
    // Not authenticated
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add a URL to our user's feed
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Get the list of users feeds
} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Remove a URL from the list of users feeds
}

?>