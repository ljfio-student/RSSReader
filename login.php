<?
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"], $_POST["password"])) {
        include("database.php");

        $email = strtolower($_POST["email"]);
        $password = $_POST["password"];

        $statement = $database->prepare("SELECT `id`, `password` FROM `user` WHERE `email` = :email");
        $statement->execute([":email" => $email]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $result["password"])) {
            // Logged in successfully
            $token = bin2hex(random_bytes(32));

            $insert_statement = $database->prepare("INSERT INTO `session` (`token`, `user_id`) VALUES (:token, :user_id)");

            $insert_statement->execute([
                ":token" => $token,
                ":user_id" => $result["id"]
            ]);

            setcookie("session", $token);

            header("Location: /index.php");
            exit(0);
        } else {
            // Failed to verify password
            $login_error = true;
        }
    }
} else {
    if (isset($_COOKIE["session"])) {
        header("Location: /index.php");
        exit(0);
    }
}
?>

<? include("layout/header.php"); ?>

<div class="container">
    <h1>Login</h1>

    <div class="row">
        <div class="col">

            <? if ($login_error) { ?>
            <div class="alert alert-danger">
                You have entered an incorrect username or password
            </div>
            <? } ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" />
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" />
                </div>

                <div class="row">
                    <div class="col">
                        <a href="/register.php" class="btn btn-primary">Register</a>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-success">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<? include("layout/footer.php"); ?>