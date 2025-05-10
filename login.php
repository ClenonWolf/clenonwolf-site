<?php
if($_POST["token"] !== trim(file_get_contents("token.secret"))) {
    echo "Invalid Passphrase :p";
    http_response_code(403);
    return;
}
setcookie("token", $_POST["token"]);
echo "logged in";