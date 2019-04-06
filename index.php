<?

if (!isset($_COOKIE["session"])) {
    header("Location: /login.php");
    exit(0);
}

?>

<? include("layout/header.php"); ?>

<div class="container">
    <h1>Your Feed</h1>
</div>

<? include("layout/footer.php"); ?>