<?
require_once('dbController.php');
var_dump($_POST);
    if (isset($_POST)) {
        if (isset($_POST["username-reg"])) {
            $db = new dbController();
        } elseif (isset($_POST["username"])) {
            //login
        }
    } else {
        echo "POST не существует";
    }
?>