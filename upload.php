<?php
$token = $_POST["token"]??null;
if($token !== trim(file_get_contents("token.secret"))) {
    echo "Invalid Passphrase :p";
    http_response_code(403);
    return;
}

date_default_timezone_set('Europe/Berlin');
$target_dir = "media/uploads/";
$thumb_dir = "media/uploads/thumbs/";
$file_hash = md5_file($_FILES["file"]["tmp_name"]);
$target_file = $target_dir . $file_hash;
$thumb_file = $thumb_dir . $file_hash;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

foreach(array($target_dir, $thumb_dir) as $dir) {
  mkdir($dir, 0755, true);
}

if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["file"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".<br>";
    $uploadOk = 1;
  } else {
    echo "File is not an image.<br>";
    $uploadOk = 0;
  }
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.<br>";
    $uploadOk = 0;
  }

  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
      $imagick = new Imagick(realpath($target_file));
      $imagick->setbackgroundcolor('rgb(64, 64, 64)');
      $imagick->setImageCompressionQuality(100);
      $imagick->thumbnailImage(250,250, true, false);
      if (file_put_contents($thumb_file, $imagick) === false) {
          throw new Exception("Could not put contents.");
      }
      include "sql_init.php";
      $db = new SQLite3('sqlite/db.sqlite');
      $db->enableExceptions(true);
      $statement = $db->prepare('INSERT INTO "art_posts" (file_name, file_hash, title, description, creation_date, hidden, nsfw, upload_date) VALUES (:file_name, :file_hash, :title, :description, :creation_date, :hidden, :nsfw, :upload_date)');
      $statement->bindValue(':file_name', $_FILES["file"]["name"]);
      $statement->bindValue(':file_hash', $file_hash);
      $statement->bindValue(':title', $_POST["title"]);
      $statement->bindValue(':description', $_POST["description"]);
      $statement->bindValue(':creation_date', $_POST["creation_date"]);
      $hidden = $_POST["hidden"] ?? 0;
      $statement->bindValue(':hidden', $hidden);
      $nsfw = $_POST["nsfw"] ?? 0;
      $statement->bindValue(':nsfw', $nsfw);
      $statement->bindValue(':upload_date', date('Y-m-d H:i:s'));
      $result = $statement->execute();
      echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded."; 
      header("Location: art_upload.php");
      http_response_code(301);
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}
?>
