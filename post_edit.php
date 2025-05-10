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
        <?php
        if($_COOKIE["token"] !== trim(file_get_contents("token.secret"))) {
            echo "Not logged in";
            http_response_code(403);
            return;
        }
        $db = new SQLite3('sqlite/db.sqlite');
        $statement = $db->prepare('SELECT * FROM art_posts WHERE id=:id');
        $statement->bindValue(":id", $_GET["id"]);
        $result = $statement->execute();
        $post = $result->fetchArray();
        if($post == false) {
            echo "Invalid Post ID";
            return;
        }
        $hidden = '';
        $nsfw = '';
        if($post['hidden'] == 1) {$hidden = 'checked';}
        if($post['nsfw'] == 1) {$nsfw = 'checked';}
        echo "
        <a style='padding:7px' target='_blank' href='media/uploads/{$post['file_hash']}/{$post['file_name']}'><img src='media/uploads/{$post['file_hash']}/{$post['file_name']}'></a>
        <form action='edit.php?id={$_GET["id"]}'' method='post' enctype='multipart/form-data'>
            <!-- <input type='password' name='token' placeholder='Passphrase'>
            <br><br> -->
            <input type='text' name='title' placeholder='Title' size='30' style='' value='{$post['title']}'>
            <br>
            <textarea type='text' name='description' placeholder='Description'>{$post['description']}</textarea>
            <br>
            <label for='upload_date'>Creation date:</label>
            <input type='date' name='creation_date' value='{$post['creation_date']}'>
            <br><br>
            <input {$hidden} type='checkbox' name='hidden' value='1'>Hidden</input>
            <br>
            <input {$nsfw} type='checkbox' name='nsfw' value='1'>NSFW</input>
            <br><br>
            <input type='submit' value='Update Post' name='submit'>
            <br><br>
            <input style='color: red;'type='submit' value='Delete' name='delete'>
        </form>
        ";
        ?>

    </div>
</body>

</html>