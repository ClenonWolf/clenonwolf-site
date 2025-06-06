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
    <h1>Photography Dump :3</h1>
    <p>Another dump of images, but this time it's the wolps Photography :p</p>
    <form method="get" action="photo_dump.php">
        <label for="files_per_page">Posts per page: </label>
        <select onchange="this.form.submit();" name="files_per_page">
            <option <?php if (isset($_GET['files_per_page']) and intval($_GET['files_per_page']) === 25) echo 'selected="selected"' ?> value=25>25</option>
            <option <?php if (isset($_GET['files_per_page']) and intval($_GET['files_per_page']) === 50) echo 'selected="selected"' ?> value=50>50</option>
            <option <?php if (isset($_GET['files_per_page']) and intval($_GET['files_per_page']) === 100) echo 'selected="selected"' ?> value=100>100</option>
        </select>
    </form>
    <div class=imageContainer>
    <?php
        $ignored = array('.', '..', '.svn', '.htaccess', '.directory', 'thumb');
        $dir = 'media/photos';
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $files_per_page = isset($_GET['files_per_page']) ? intval($_GET['files_per_page']) : 25;
        $files = array();
        foreach (scandir($dir) as $file) {
            if (in_array($file, $ignored)) continue;
            $files[$file] = filemtime($dir . '/' . $file);
        }
        arsort($files);
        $file_count = count($files);
        $total_pages = ceil($file_count / $files_per_page);
        $slice_offset = ($page-1) * $files_per_page;
        
        $pageselect_html = "<div class=pageselect>Page: $page | <a href='?page=1&files_per_page=$files_per_page'>1</a> ";
        for ($i = 2; $i <= $total_pages; $i++) {
            $pageselect_html .= "<a href='?page=$i&files_per_page=$files_per_page'>$i</a> ";
        }
        $pageselect_html .= "</div>";
        echo $pageselect_html;

        $files_slice = array_slice($files, $slice_offset, $files_per_page);
        foreach($files_slice as $file => $value)  {
            $thumb_path = "{$dir}/thumb/{$file}_thumb.jpg";
            $file_path = "{$dir}/$file";
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

