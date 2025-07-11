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
        <h2>Have the wolps art :3</h2>
        <p>Page for viewing posts I've uploaded through my posting system. For moar art visit my <a href="art.php">Art Dump</a> which is the stuff I'm too lazy to properly post.</p>
        <p>Click to view post details :p</p>
        <h3>For admin wolp:</h3>
        <button onclick="location.href='art_upload.php'" type='button'>Upload</button><button onclick="location.href='show_hidden.php'" type='button'>Show hidden</button>
        <form action="login.php?source=art_posts.php" method="post" enctype="multipart/form-data">
            <input type="password" name="token" placeholder="Passphrase">
            <input type="submit" value="Login" name="submit">
        </form>
        <button onclick="location.href='logout.php'" type='button'>Logout</button>
        <h3>Here's yours to play with:</h3>
        <form action="art_posts.php" method="post">
            <label for="sortby">Sort by:</label>
            <select onchange="this.form.submit();" name="sortby">
                <option <?php if (isset($_POST["sortby"]) and $_POST["sortby"] == "creation_date_desc") echo 'selected="selected"' ?> value="creation_date_desc">Creation Date Descending</option>
                <option <?php if (isset($_POST["sortby"]) and $_POST["sortby"] == "creation_date_asc") echo 'selected="selected"' ?> value="creation_date_asc">Creation Date Ascending</option>
                <option <?php if (isset($_POST["sortby"]) and $_POST["sortby"] == "upload_date_desc") echo 'selected="selected"' ?> value="upload_date_desc">Upload Date Descending</option>
                <option <?php if (isset($_POST["sortby"]) and $_POST["sortby"] == "upload_date_asc") echo 'selected="selected"' ?> value="upload_date_asc">Upload Date Ascending</option>
                <option <?php if (isset($_POST["sortby"]) and $_POST["sortby"] == "id_desc") echo 'selected="selected"' ?> value="id_desc">ID Descending</option>
                <option <?php if (isset($_POST["sortby"]) and $_POST["sortby"] == "id_asc") echo 'selected="selected"' ?> value="id_asc">ID Ascending</option>
            </select>
            <input <?php if (isset($_POST["nsfw_toggle"]) and $_POST["nsfw_toggle"]) echo 'checked' ?> onchange="this.form.submit();" type="checkbox" name="nsfw_toggle">Show NSFW (18+) Posts</input>
        </form>
        <br>
        <div class=images-container>
            <?php
            $order_options = array(
                "id_desc"=>'id DESC',
                "id_asc"=>'id ASC',
                "creation_date_desc"=>'creation_date DESC',
                "creation_date_asc"=>'creation_date ASC',
                "upload_date_desc"=>'upload_date DESC',
                "upload_date_asc"=>'upload_date ASC'
            );
            include "sql_init.php";
            include "regen_thumbs.php";
            
            $_POST["sortby"] = !isset($_POST["sortby"]) ? 'creation_date_desc' : $_POST["sortby"];
            $nsfw_toggle = $_POST["nsfw_toggle"] ? '' : 'AND nsfw=0';

            $db = new SQLite3('sqlite/db.sqlite');
            $statement = $db->prepare('SELECT * FROM art_posts WHERE hidden=0 '. $nsfw_toggle .' ORDER BY '. $order_options[$_POST["sortby"]].'');
            $results = $statement->execute();
            while ($row = $results->fetchArray()) {
                $alt_text = "Title: {$row['title']}\nDesc: {$row['description']}\nCreated: {$row['creation_date']}\nUploaded: {$row['upload_date']}";
                echo "
                <div class='image-container'>
                    <a target='_self' href='post_view.php?id={$row['id']}'><img title='{$alt_text}' src='media/uploads/thumbs/{$row['file_hash']}'></a><br>
                    {$row['title']}<br>{$row['creation_date']}
                </div>
                ";
            }
            ?>
        </div>
    </div>
</body>

</html>