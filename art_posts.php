<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>My page :3</title>
</head>

<body>
<?php include "snowflakes.php" ?>
    <?php include "headerdiv.php" ?>
    <?php include "navbar.php" ?>
    <?php include "audioplayer.php" ?>
    <div class="centerdiv">
        <?php
        include "sql_init.php";
        
        $db = new SQLite3('sqlite/db.sqlite');
        ?>
    </div>
</body>

</html>

