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
        <form action="art_posts.php" method="post">
            <label for="sortby">Sort by:</label>
            <select onchange="this.form.submit();" name="sortby">
                <option value='SELECT * FROM art_posts ORDER BY id DESC'>ID Descending</option>
                <option value='SELECT * FROM art_posts ORDER BY id ASC'>ID Ascending</option>
                <option value='SELECT * FROM art_posts ORDER BY creation_date ASC'>Creation Date Ascending</option>
                <option value='SELECT * FROM art_posts ORDER BY creation_date DESC'>Creation Date Descending</option>
                <option value='SELECT * FROM art_posts ORDER BY upload_date ASC' >Upload Date Ascending</option>
                <option value='SELECT * FROM art_posts ORDER BY upload_date DESC'>Upload Date Descending</option>
            </select>
        </form>
        <div class=imageContainer>
            <?php
            include "sql_init.php";
            include "regen_thumbs.php";
            if(isset($_POST["sortby"])) {
                $sql = $_POST["sortby"];
            } else {
                $sql = 'SELECT * FROM art_posts ORDER BY id DESC';
            }
            $db = new SQLite3('sqlite/db.sqlite');
            $results = $db->query($sql);
            while ($row = $results->fetchArray()) {
                echo "<a style='padding:7px' target='_blank' href='media/uploads/{$row['file_hash']}/{$row['file_name']}'><img src='media/uploads/thumbs/{$row['file_hash']}' width=10% ></a>";
            }
            ?>
        </div>
    </div>
</body>

</html>