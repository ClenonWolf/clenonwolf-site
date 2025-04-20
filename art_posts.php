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
        <?php
        include "sql_init.php";
        $db = new SQLite3('sqlite/db.sqlite');
        // $post = 1;
        $statement = $db->prepare('SELECT * FROM "art_posts"'); //WHERE "id" = "post"
        // //$statement->bindValue(':post', $post);
        $result = $statement->execute();
        // $row = $result->fetchArray(SQLITE3_ASSOC);
        // printr($row);
        // $result->finalize();
        $i = 0;
        while($res = $result->fetchArray(SQLITE3_ASSOC)){
            if(!isset($res['id'])) continue;
            $row[$i]['id'] = $res['id'];
            $row[$i]['file_name'] = $res['file_name'];
            $row[$i]['file_hash'] = $res['file_hash'];
            //echo "<img src='media/posts/$res[$i]['file_hash']' width=10%>";
            $row[$i]['title'] = $res['title'];
            $row[$i]['description'] = $res['description'];
            $i++;
        }
        print_r($row);
        
        ?>
    </div>
</body>

</html>