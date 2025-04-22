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
        <p>Testing page for viewing posts I've uploaded through my posting system. Posts are read from the sqlite db and each loaded.</p>
        <p>Different ways to sort and proper post views with post information coming soon :3</p>
        <div class=imageContainer>
            <?php
            include "sql_init.php";
            include "regen_thumbs.php";
            $db = new SQLite3('sqlite/db.sqlite');
            $results = $db->query('SELECT * FROM "art_posts" ORDER BY "id" DESC');
            while ($row = $results->fetchArray()) {
                echo "<a style='padding:7px' target='_blank' href='media/uploads/{$row['file_hash']}/{$row['file_name']}'><img src='media/uploads/thumbs/{$row['file_hash']}' width=10% ></a>";
            }
            ?>
        </div>
    </div>
</body>

</html>