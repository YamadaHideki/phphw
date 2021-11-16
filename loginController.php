<?
var_dump($_POST);
    if (isset($_POST)) {
        if (isset($_POST["username-reg"])) {
            //registration
        } elseif (isset($_POST["username"])) {
            //login
        }
    } else {
        echo "POST не существует";
    }
?>