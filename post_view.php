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
        $db = new SQLite3('sqlite/db.sqlite');
        $statement = $db->prepare('SELECT * FROM art_posts WHERE id=:id');
        $statement->bindValue(":id", $_GET["id"]);
        $result = $statement->execute();
        $post = $result->fetchArray();
        if($post == false) {
            echo "Invalid Post ID";
            return;
        }
        ?>
        <br>
        <?php
        if($post["hidden"] == 0) {
            echo "
            <a target='_blank' href='media/uploads/{$post['file_hash']}/{$post['file_name']}'><img src='media/uploads/{$post['file_hash']}/{$post['file_name']}'></a>
            <h4>Title: {$post["title"]}</h4>
            <p> Description: {$post["description"]}</p>
            <p>Created: {$post['creation_date']}</p>
            <p>Uploaded: {$post['upload_date']}</p>
            ";
        } else {
            if($_COOKIE["token"] !== trim(file_get_contents("token.secret"))) {
                echo "Post is hidden";
                http_response_code(403);
                return;
            }
            //this is done in a dumb way but might just work :shrug:
            echo "
            <a target='_blank' href='media/uploads/{$post['file_hash']}/{$post['file_name']}'><img src='media/uploads/{$post['file_hash']}/{$post['file_name']}'></a>
            <h4>Title: {$post["title"]}</h4>
            <p> Description: {$post["description"]}</p>
            <p>Created: {$post['creation_date']}</p>
            <p>Uploaded: {$post['upload_date']}</p>
            ";
        }
        ?>
        <button onclick="location.href='post_edit.php?id=<?php echo $post["id"] ?>'" type='button'>Edit</button>
    </div>
</body>

</html>