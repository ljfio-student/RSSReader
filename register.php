<?
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["name"], $_POST["email"], $_POST["password"])) {
        include("database.php");

        $name = $_POST["name"];
        $email = strtolower($_POST["email"]);
        $password = $_POST["password"];

        if (strlen(trim($name)) == 0 || strlen(trim($email)) == 0 || strlen(trim($password)) == 0) {
            $register_error = true;
        } else {
            $statement = $database->prepare("SELECT `id` FROM `user` WHERE `email` = :email");
            $statement->execute([":email" => $email]);

            if ($statement->rowCount() == 0) {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                $insert_statement = $database->prepare("INSERT INTO `user` (`name`, `email`, `password`) VALUES (:name, :email, :password)");
                $insert_statement->execute([
                    ":name" => $name,
                    ":email" => $email,
                    ":password" => $hashed_password
                ]);

                $register_success = true;
            } else {
                $register_error = true;
            }
        }
    }
}
?>

<? include("layout/header.php") ?>

<div class="container">
    <h1>Register</h1>

    <div class="row">
        <div class="col">
            <? if ($register_error) { ?>
                <div class="alert alert-danger">
                    Cannot create a user account using the provided details.
                </div>
            <? } elseif ($register_success) { ?>
                <div class="alert alert-success">
                    You user account has been created, please login.
                </div>
            <? } ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" />
                </div>

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
                        <a href="/login.php" class="btn btn-success">Login</a>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<? include("layout/footer.php") ?>