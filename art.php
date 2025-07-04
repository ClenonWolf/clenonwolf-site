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
    <?php include "audioplayer.php" ?>
    <div class="centerdiv">
    <h1>Art Dump :3</h1>
    <p>The lazy dump of the wolps art. Just a folder I can throw everything into.</p>
    <p>To view the full res image, simply click one and it'll open in a new tab.</p>
    <?php $dir = "media/art"; include "modules/image_folder.php" ?>
    </div>
</body>

</html>

