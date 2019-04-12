<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="/main.css" rel="stylesheet" />
    </head>
    <body>
        <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="/">RSS Reader</a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a href="/" class="nav-link">Home</a>
                        </li>
                        <? if (!isset($_COOKIE["session"])) { ?>
                        <li class="nav-item">
                            <a href="/login.php" class="nav-link">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="/register.php" class="nav-link">Register</a>
                        </li>
                        <? } else { ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link" id="show-feeds">Feeds</a>
                        </li>
                        <? } ?>
                    </ul>
                    <? if (isset($_COOKIE["session"])) { ?>
                    <form class="form-inline">
                        <button class="btn btn-outline-success my-2 my-sm-0" id="refresh-feed">Refresh</button>
                    </form>
                    <? } ?>
                </div>
            </div>
        </nav>