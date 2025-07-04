<form method="get" action="">
    <label for="files_per_page">Posts per page: </label>
    <!-- <php
    foreach($_GET as $param) {
        echo "<input name='{$param}' type='text' palceholder='{$param}' value='{$param}' hidden />";
    }
    ?> -->
    <select onchange="this.form.submit();" name="files_per_page">
        <option <?php if (isset($_GET['files_per_page']) and intval($_GET['files_per_page']) === 50) echo 'selected="selected"' ?> value=50>50</option>
        <option <?php if (isset($_GET['files_per_page']) and intval($_GET['files_per_page']) === 75) echo 'selected="selected"' ?> value=75>75</option>
        <option <?php if (isset($_GET['files_per_page']) and intval($_GET['files_per_page']) === 100) echo 'selected="selected"' ?> value=100>100</option>
    </select>
</form>
<form method="get" action="">
    <label for="files_per_page">Or enter manually: </label>
    <input onchange="this.form.submit();" type="number" name="files_per_page" min="1">
</form>
<div class=images-container>
    <?php
        $ignored = array('.', '..', '.svn', '.htaccess', '.directory', 'thumb');
        $def_files_per_page = 50;
        $thumb_dir = "{$dir}/thumb";

        if(!file_exists($thumb_dir)) mkdir($thumb_dir);
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $files_per_page = isset($_GET['files_per_page']) ? intval($_GET['files_per_page']) : $def_files_per_page;
        $files = array();
        foreach (scandir($dir) as $file) {
            if (in_array($file, $ignored)) continue;
            $files[$file] = filemtime($dir . '/' . $file);
        }
        arsort($files);
        $file_count = count($files);
        $total_pages = ceil($file_count / $files_per_page);
        $slice_offset = ($page-1) * $files_per_page;

        $prev = $page - 1;
        $next = $page + 1;
        $pageselect_html = "<div class=pageselect>Total of $file_count images<br>Page: $page / $total_pages<br>";
        if ($page > 1) {
            $pageselect_html .= "<a href='?dir={$_GET["dir"]}&page=$prev&files_per_page=$files_per_page'>◄Prev</a> ";
        }
        if ($page < $total_pages) {
            $pageselect_html .= "<a href='?dir={$_GET["dir"]}&page=$next&files_per_page=$files_per_page'>Next►</a>";
        }
        $pageselect_html .= "<br>";
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i === $page) {
                $pageselect_html .= "<a style='color: green' href='?dir={$_GET["dir"]}&page=$i&files_per_page=$files_per_page'>$i</a> ";
            } else {
                $pageselect_html .= "<a href='?dir={$_GET["dir"]}&page=$i&files_per_page=$files_per_page'>$i</a> ";
            }
        }
        $pageselect_html .= "</div>";
        echo $pageselect_html;
        
        echo "<div class='images-container'>";
        $files_slice = array_slice($files, $slice_offset, $files_per_page);
        foreach($files_slice as $file => $value)  {
            $thumb_path = "{$thumb_dir}/{$file}_thumb.jpg";
            $file_path = "{$dir}/$file";
            $file_date = date("F d Y", filemtime($file_path));
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
            echo "
            <div class='image-container'>
                <a target='_blank' href='$file_path'><img src='$thumb_path'></a><br>
                $file<br>$file_date
            </div>
            ";

        }
        echo "</div>";
        echo $pageselect_html;
        ?>
</div>