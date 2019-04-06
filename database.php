<?

$database_name = "rssfeed";
$hostname = "127.0.0.1";
$username = "root";
$password = "";

try {
    $database = new PDO("mysql:dbname=$database_name;host=$hostname", $username, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}