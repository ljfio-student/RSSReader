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
include('../helper.php');

$token = $_COOKIE["session"];

$user_statement = $database->prepare("SELECT `user_id` FROM `session` WHERE `token` = :token");
$user_statement->execute([":token" => $token]);

if ($user_statement->rowCount() != 1) {
    // Not authenticated
}

$session = $user_statement->fetch(PDO::FETCH_ASSOC);

$statement = $database->prepare("SELECT `feed`.`id`, `feed`.`url` FROM `feed` INNER JOIN `user_feed` ON `user_feed`.`feed_id` = `feed`.`id` WHERE `user_id` = :user_id");
$statement->execute([
    ":user_id" => $session["user_id"],
]);

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $data = get_from_url($row["url"]);
    $articles = parse_rss_data($data);

    foreach ($articles as $article) {
        $exist_statement = $database->prepare("SELECT `id`, `date` FROM `content` WHERE `feed_id` = :feed_id AND `guid` = :guid");

        $exist_statement->execute([
            ":feed_id" => $row["id"],
            ":guid" => $article["guid"],
        ]);


        // If the article does not exist, or the date is different (e.g. updated)
        if ($exist_statement->rowCount() == 0) {
            $insert_statement = $database->prepare("INSERT INTO `content` (`feed_id`, `title`, `description`, `link`, `guid`, `date`) VALUES (:feed_id, :title, :description, :link, :guid, :date)");
            $insert_statement->execute([
                ":feed_id" => $row["id"],
                ":title" => $article["title"],
                ":description" => $article["description"],
                ":link" => $article["link"],
                ":guid" => $article["guid"],
                ":date" => $article["date"]->format("Y-m-d H:i:s"),
            ]);
        } else {
            $existing = $exist_statement->fetch(PDO::FETCH_ASSOC);

            $date = new DateTime($existing["date"]);

            if ($date->diff($article["date"], true) > 0) {
                $update_statement = $database->prepare("UPDATE `content` SET `title` = :title, `description` = :description, `link` = :link, `date` = :date WHERE `feed_id` = :feed_id AND `guid` = :guid");
                $update_statement->execute([
                    ":feed_id" => $row["id"],
                    ":title" => $article["title"],
                    ":description" => $article["description"],
                    ":link" => $article["link"],
                    ":guid" => $article["guid"],
                    ":date" => $article["date"]->format("Y-m-d H:i:s"),
                ]);
            }
        }
    }
}