<?php
include("config.php");

?>

<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link href="css/style.css" rel="stylesheet" >

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <?php
                include("partials/header.php");
            ?>

        </div>
        <div class="container">
            <?php
            if ($_GET["action"] === "create") {
                include("partials/create.php");
            }else
            if ($_GET["action"] === "close") {
                include("partials/close.php");
            }else
            if ($_GET["action"] === "show") {
                include("partials/show.php");
            }else
            if ($_GET["action"] === "vote_select") {
                include("partials/vote_select.php");
            }else
            if ($_GET["action"] === "vote") {
                include("partials/vote.php");
            }else
            if ($_GET["action"] === "all") {
                include("partials/all.php");
            }
            ?>

        </div>
        <img src="images/icon.png">
    </body>
</html>