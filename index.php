<?

if (!isset($_COOKIE["session"])) {
    header("Location: /login.php");
    exit(0);
}

?>

<? include("layout/header.php"); ?>

<div class="container">
    <h1>Your Feed</h1>

    <div id="feed"></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.1/handlebars.min.js"
    integrity="sha256-Mki72593zH3nxiQrW1mskmSOAXOep8FVIK0ozKFISyY=" crossorigin="anonymous"></script>

<script type="text/javascript" src="/main.js"></script>

<script id="entry-template" type="text/x-handlebars-template">
<div class="card mb-3">
    <div class="row no-gutters">
        <div class="card-body">
            <h5 class="card-title">{{title}}</h5>
            <p class="card-text">{{description}}</p>
            <p class="card-text"><small class="text-muted">{{date}}</small></p>
            <a href="{{link}}" target="_blank" class="card-link">View</a>
        </div>
    </div>
</div>
</script>

<? include("layout/footer.php"); ?>