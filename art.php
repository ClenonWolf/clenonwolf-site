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
    <div class=imageContainer>
      <?php
        $ignored = array('.', '..', '.svn', '.htaccess', '.directory', 'thumb');
        $dir = 'media/art';
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $files_per_page = isset($_GET['files_per_page']) ? intval($_GET['files_per_page']) : 20;
        $files = array();
        foreach (scandir($dir) as $file) {
            if (in_array($file, $ignored)) continue;
            $files[$file] = filemtime($dir . '/' . $file);
        }
        arsort($files);
        $file_count = count($files);
        $total_pages = ceil($file_count / $files_per_page);
        $slice_offset = ($page-1) * $files_per_page;
        $pageselect_html = "<div class=pageselect>Page: <a href='?page=1'>1</a> ";
        for ($i = 2; $i <= $total_pages; $i++) {
            $pageselect_html .= "<a href='?page=$i'>$i</a> ";
        }
        $pageselect_html .= "</div>";
        echo $pageselect_html;

        $files_slice = array_slice($files, $slice_offset, $files_per_page);
        foreach($files_slice as $file => $value)  {
            $thumb_path = "media/art/thumb/{$file}_thumb.jpg";
            $file_path = "media/art/$file";
            if(!file_exists($thumb_path)) {
                error_log($file);
                $imagick = new Imagick(realpath("$file_path"));
                $imagick->setbackgroundcolor('rgb(64, 64, 64)');
                $imagick->setImageCompressionQuality(100);
                $imagick->thumbnailImage(250,250, true, false);
                if (file_put_contents($thumb_path, $imagick) === false) {
                    throw new Exception("Could not put contents.");
                }
            }
            echo "<a style='padding:7px' target='_blank' href='$file_path'><img src='$thumb_path' width=10% ></a>";

        }
        echo $pageselect_html;
      ?>
    </div>
    </div>
</body>

</html>

