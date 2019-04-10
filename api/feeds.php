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

$session = $user_statement->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add a URL to our user's feed
    $url = $_POST["url"];

    $select_statement = $database->prepare("SELECT `id` FROM `feed` WHERE `url` = :url LIMIT 0, 1");
    $select_statement->execute([
        ":url" => $url,
    ]);

    if ($select_statement->rowCount() == 1)  {
        $result = $select_statement->fetch(PDO::FETCH_ASSOC);

        $feed_id = $result["id"];
    } else {
        $insert_statement = $database->prepare("INSERT INTO `feed` (`url`) VALUES (:url)");
        $insert_statement->execute([
            ":url" => $url,
        ]);

        $feed_id = $database->lastInsertId();
    }

    $statement = $database->prepare("INSERT INTO `user_feed` (`user_id`, `feed_id`) VALUES (:user_id, :feed_id)");
    $statement->execute([
        ":user_id" => $session["user_id"],
        ":feed_id" => $feed_id,
    ]);

    echo json_encode([
        "success" => true,
    ]);
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Get the list of users feeds
    $statement = $database->prepare("SELECT `user_feed`.`id`, `feed`.`url` FROM `user_feed` INNER JOIN `feed` ON `feed`.`id` = `user_feed`.`feed_id` WHERE `user_id` = :user_id");
    $statement->execute([
        ":user_id" => $session["user_id"],
    ]);

    $feeds = [];

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        array_push($feeds, [
            "id" => $row["id"],
            "url" => $row["url"],
        ]);
    }

    echo json_encode([
        "feeds" => $feeds,
    ]);
} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Remove a URL from the list of users feeds
    $id = $_GET["id"];

    $statement = $database->prepare("DELETE FROM `user_feed` WHERE `id` = :id");
    $statement->execute([
        "id" => $id,
    ]);

    $success = $statement->rowCount() == 1;

    echo json_encode([
        "success" => $success,
    ]);
}

?>