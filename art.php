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
    <h1>Have some of the wolps art :3</h1>
    <p>This page is very much a work in progress. Just got thumbnails to work and will try to improve this page. Wolp be new to php xp</p>
    <p>To view the full res image, simply click one and it'll open in a new tab. :3</p>
    <div class=imageContainer>
      <?php
        $ignored = array('.', '..', '.svn', '.htaccess', '.directory', 'thumb');
        $dir = 'media/art';
        $files = array();    
        foreach (scandir($dir) as $file) {
            if (in_array($file, $ignored)) continue;
            $files[$file] = filemtime($dir . '/' . $file);
        }
        arsort($files);

        foreach($files as $file => $value)  {
            $thumb_path = "media/art/thumb/{$file}_thumb.jpg";
            if(!file_exists($thumb_path)) {
                error_log($file);
                $imagick = new Imagick(realpath("media/art/$file"));
                $imagick->setbackgroundcolor('rgb(64, 64, 64)');
                $imagick->setImageCompressionQuality(100);
                $imagick->thumbnailImage(250,250, true, false);
                if (file_put_contents($thumb_path, $imagick) === false) {
                    throw new Exception("Could not put contents.");
                }
            }
            echo "<a style='padding:7px' target='_blank' href='media/art/$file'><img src='$thumb_path' width=10% ></a>";

        }
      ?>
    </div>
    </div>
</body>

</html>

