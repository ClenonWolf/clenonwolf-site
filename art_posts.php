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
        <p>Testing page for viewing posts I've uploaded through my posting system. Posts are read from the sqlite db and each loaded.</p>
        <p>Different ways to sort and proper post views with post information coming soon :3</p>
        <p>Click to view post details</p>
        <form action="art_posts.php" method="post">
            <label for="sortby">Sort by:</label>
            <select onchange="this.form.submit();" name="sortby">
                <option <?php if (isset($_POST["sortby"]) and $_POST["sortby"] == "id_desc") echo 'selected="selected"' ?> value="id_desc">ID Descending</option>
                <option <?php if (isset($_POST["sortby"]) and $_POST["sortby"] == "id_asc") echo 'selected="selected"' ?> value="id_asc">ID Ascending</option>
                <option <?php if (isset($_POST["sortby"]) and $_POST["sortby"] == "creation_date_desc") echo 'selected="selected"' ?> value="creation_date_desc">Creation Date Descending</option>
                <option <?php if (isset($_POST["sortby"]) and $_POST["sortby"] == "creation_date_asc") echo 'selected="selected"' ?> value="creation_date_asc">Creation Date Ascending</option>
                <option <?php if (isset($_POST["sortby"]) and $_POST["sortby"] == "upload_date_desc") echo 'selected="selected"' ?> value="upload_date_desc">Upload Date Descending</option>
                <option <?php if (isset($_POST["sortby"]) and $_POST["sortby"] == "upload_date_asc") echo 'selected="selected"' ?> value="upload_date_asc">Upload Date Ascending</option>
            </select>
            <!-- php
            if (isset($_POST["nsfw_toggle"]) and $_POST["nsfw_toggle"] === "on") {
                setcookie("nsfw", "on", time()+60*60*24*30);
                $_COOKIE["nsfw"] = $_POST["nsfw_toggle"];
            } elseif ($_POST["nsfw"] === "") {setcookie("nsfw", "");}
            $nsfw_enabled = isset($_COOKIE["nsfw"]) ? $_COOKIE["nsfw"] === "on" : false;
            ?> -->
            <!-- <select onchange="this.form.submit();" name="nsfw_toggle">
                <option php if (isset($_POST["nsfw_toggle"]) and $_POST["nsfw_toggle"] == "AND nsfw=0") echo 'selected="selected"' ?> value="AND nsfw=0">NSFW (18+) hidden</option>
                <option php if (isset($_POST["nsfw_toggle"]) and $_POST["nsfw_toggle"] == "") echo 'selected="selected"' ?> value="">NSFW (18+) shown</option>
            </select> -->
            <input <?php if (isset($_POST["nsfw_toggle"]) and $_POST["nsfw_toggle"]) echo 'checked' ?> onchange="this.form.submit();" type="checkbox" name="nsfw_toggle">Show NSFW (18+) Posts</input>
            <!-- <input type="submit" value="Apply" name="submit"> -->
        </form>
        <br>
        <div class=imageContainer>
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
            
            $_POST["sortby"] = !isset($_POST["sortby"]) ? 'id_desc' : $_POST["sortby"];
            // $_POST["nsfw_toggle"] = !isset($_POST["nsfw_toggle"]) ? 'AND nsfw=0' : $_POST["nsfw_toggle"];
            $nsfw_toggle = $_POST["nsfw_toggle"] ? '' : 'AND nsfw=0';

            $db = new SQLite3('sqlite/db.sqlite');
            $statement = $db->prepare('SELECT * FROM art_posts WHERE hidden=0 '. $nsfw_toggle .' ORDER BY '. $order_options[$_POST["sortby"]].'');
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