<?php if (!defined('APP')) { die('Access denied.'); }
function base_header($title) {
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Library <?= $title ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
  </head>
  <body>
    <div class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Library</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="#">Check out</a></li>
                    <li><a href="#">Check in</a></li>
                    <li><a href="#">Loans</a></li>
                    <li><a href="#">Patrons</a></li>
                    <li><a href="#">Catalog</a></li>
                    <li><a href="#">Authorities</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Admin</a></li>
                    <li><a href="#">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
<?php
} // end header

function base_footer() {
?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  </body>
</html>
<?php } // end footer