<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>My page :3</title>
    <script type="text/javascript" src="script.js?t=3"></script>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>

<body>
    <?php include "snowflakes.php" ?>
    <?php include "headerdiv.php" ?>
    <?php include "navbar.php" ?>
    <div class="centerdiv">
        <h2>Upload</h2>
        <?php
        if($_COOKIE["token"] !== trim(file_get_contents("token.secret"))) {
            echo "Not logged in";
            http_response_code(403);
            return;
        }
        echo "
        <h2>Post</h2>
        <label for='files'>Select multiple files:</label>
        <input onchange='distributeFiles();' type='file' id='multiFileInput' name='files' multiple />
        <br><br>
        ";
        for($i = 0; $i <= 9; $i++) {    
            echo "
            <form action='upload.php' id='upload_form' method='post' enctype='multipart/form-data'>
                <label for='file{$i}'>{$i}</label>
                <input type='file' name='file{$i}'>
                <input type='text' name='title{$i}' placeholder='Title' size='30'>
                <textarea name='description{$i}' placeholder='Description' rows='1' cols='40'></textarea>
                <label for='creation_date{$i}'>Creation date:</label>
                <input type='date' name='creation_date{$i}'>
                <input type='checkbox' name='hidden{$i}' value='1'>Hidden</input>
                <input type='checkbox' name='nsfw{$i}' value='1'>NSFW</input>
                <br>
            ";
        }
        echo "
                <br>
                <input type='submit' value='Upload Image' name='submit'>
            </form>
        ";
        ?>
    </div>
</body>

</html>

