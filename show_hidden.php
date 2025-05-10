<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>My page :3</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>

<body>
<?php include "snowflakes.php" ?>
    <?php include "headerdiv.php" ?>
    <?php include "navbar.php" ?>
    <div class="centerdiv">
        <h2>View Hidden Posts</h2>
        <p>Silly you, really thought I'd just show them like this xp</p>
        <div class=imageContainer>
            <?php
            if($_COOKIE["token"] !== trim(file_get_contents("token.secret"))) {
                echo "Not logged in";
                http_response_code(403);
                return;
            }
            include "sql_init.php";
            include "regen_thumbs.php";
            $db = new SQLite3('sqlite/db.sqlite');
            $statement = $db->prepare('SELECT * FROM art_posts WHERE hidden=1 ORDER BY id DESC');
            $results = $statement->execute();
            while ($row = $results->fetchArray()) {
                $alt_text = "Title: {$row['title']}\nDesc: {$row['description']}\nCreated: {$row['creation_date']}\nUploaded: {$row['upload_date']}";
                echo "<a target='_self' style='padding:7px' target='_blank' href='post_view.php?id={$row['id']}'><img title='{$alt_text}' src='media/uploads/thumbs/{$row['file_hash']}' width=10% ></a>";
            }
            ?>
        </div>
    </div>
</body>

</html>