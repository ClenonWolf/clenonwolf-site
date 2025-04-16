<?php
$token = $_POST["token"]??null;
if($token !== file_get_contents("token.secret")) {
    echo "Invalid Passphrase :p";
    http_response_code(403);
    return;
}

if(!file_exists('media/uploads')) {
    mkdir('media/uploads', 0755, true);
}
$target_dir = "media/uploads/";
$file_hash = md5_file($_FILES["file"]["tmp_name"]);
$target_file = $target_dir . $file_hash;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

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
      $db = new SQLite3('sqlite/db.sqlite');
      $db->enableExceptions(true);
      $statement = $db->prepare('INSERT INTO "art_posts" (file_name, file_hash, title, description) VALUES (:file_name, :file_hash, :title, :description)');
      $statement->bindValue(':file_name', $_FILES["file"]["name"]);
      $statement->bindValue(':file_hash', $file_hash);
      $statement->bindValue(':title', $_POST["title"]);
      $statement->bindValue(':description', $_POST["description"]);
      $result = $statement->execute();
      echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded."; 
      // header("Location: art_upload.php");
      // http_response_code(301);
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}
?>
