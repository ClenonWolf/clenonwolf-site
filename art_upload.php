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
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <h2>Authentification</h2>
            <input type="password" name="token" placeholder="Passphrase">
            <br><br>
            <h2>Post</h2>
            <input type="file" name="file">
            <br><br>
            <input type="text" name="title" placeholder="Title" size="30" style="">
            <br>
            <textarea type="text" name="description" placeholder="Description"></textarea>
            <br>
            <label for="upload_date">Creation date:</label>
            <input type="date" name="creation_date">
            <br>
            <input type="submit" value="Upload Image" name="submit">
        </form>
    </div>
</body>

</html>

