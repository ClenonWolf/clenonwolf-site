<?php
$token = $_POST["token"]??null;
if($token !== trim(file_get_contents("token.secret"))) {
    echo "Invalid Passphrase :p";
    http_response_code(403);
    return;
}

if(isset($_POST["submit"])) {
      include "sql_init.php";
      $db = new SQLite3('sqlite/db.sqlite');
      $db->enableExceptions(true);
      $statement = $db->prepare('UPDATE "art_posts" SET title=:title, description=:description, creation_date=:creation_date WHERE id=:id');
      $statement->bindValue(':title', $_POST["title"]);
      $statement->bindValue(':description', $_POST["description"]);
      $statement->bindValue(':creation_date', $_POST["creation_date"]);
      $statement->bindValue(':id', $_GET["id"]);
      $result = $statement->execute(); 
      header("Location: post_view.php?id={$_GET["id"]}");
      http_response_code(301);
    } else {
      echo "Sorry, there was an error editing the post.";
    }
?>
