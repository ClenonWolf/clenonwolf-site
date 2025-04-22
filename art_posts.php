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
    <div class="centerdiv">
        <div class=imageContainer>
        <?php
        include "sql_init.php";
        $db = new SQLite3('sqlite/db.sqlite');
        $results = $db->query('SELECT * FROM "art_posts"');
        while ($row = $results->fetchArray()) {
            echo "<a style='padding:7px' target='_blank' href='media/uploads/{$row['file_hash']}'><img src='media/uploads/{$row['file_hash']}' width=10% ></a>";
        }
        ?>
        </div>
    </div>
</body>

</html>