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
    <?php 
    include "snowflakes.php";
    include "headerdiv.php";
    include "navbar.php";
    include "audioplayer.php";
    ?>
    <div class="centerdiv">
    <h1>Photography Dump :3</h1>
    <p>Another dump of images, but this time it's the wolps Photography :p</p>
    <?php $dir = "media/photos"; include "modules/image_folder.php" ?>
    </div>
</body>

</html>

