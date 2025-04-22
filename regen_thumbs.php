<?php
include "sql_init.php";
$db = new SQLite3('sqlite/db.sqlite');
$results = $db->query('SELECT "file_hash" FROM "art_posts"');
while ($row = $results->fetchArray()) {
    $source_dir = "media/uploads/";
    $thumb_dir = "media/uploads/thumbs/";
    $source_file = $source_dir . $row['file_hash'];
    $thumb_file = $thumb_dir . $row['file_hash'];

    if(!file_exists($thumb_file)) {
        error_log($file);
        $imagick = new Imagick(realpath($source_file));
        $imagick->setbackgroundcolor('rgb(64, 64, 64)');
        $imagick->setImageCompressionQuality(100);
        $imagick->thumbnailImage(250,250, true, false);
        if (file_put_contents($thumb_file, $imagick) === false) {
            throw new Exception("Could not put contents.");
        }
    }
}
?>