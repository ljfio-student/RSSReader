<?php

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    // Wrong request method
    exit(0);
}

if (!isset($_COOKIE["session"])) {
    // Not authorised
    exit(0);
}

include('../database.php');

$token = $_COOKIE["session"];

$user_statement = $database->prepare("SELECT `user_id` FROM `session` WHERE `token` = :token");
$user_statement->execute([":token" => $token]);

if ($user_statement->rowCount() != 1) {
    // Not authenticated
}

$session = $user_statement->fetch(PDO::FETCH_ASSOC);

$statement = $database->prepare("SELECT `content`.`id`, `content`.`feed_id`, `content`.`title`, `content`.`description`, `content`.`link`, `content`.`date`
FROM `content`
INNER JOIN `user_feed` ON `user_feed`.`feed_id` = `content`.`feed_id`
WHERE `user_feed`.`user_id` = :user_id");
$statement->execute([":user_id" => $session["user_id"]]);

$articles = [];

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    array_push($articles, [
        "id" => $row["id"],
        "feed_id" => $row["feed_id"],
        "title" => $row["title"],
        "decription" => $row["description"],
        "link" => $row["link"],
        "date" => $row["date"],
    ]);
}

echo json_encode([
    "articles" => $articles
]);

?>