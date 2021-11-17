<?
session_start();
require_once('dbController.php');
    if (isset($_POST)) {
        $db = new dbController();
        if (isset($_POST['username-reg']) && isset($_POST['pwd'])) {
            $username = htmlspecialchars(trim($_POST["username-reg"]));
            $pwd = htmlspecialchars(md5(trim($_POST["pwd"])));
            $role = (isset($_POST['role'])) ? 0 : 1;

            $db->registration($username, $pwd, $role);
            sessionInfo($db, $username, $pwd);

        } elseif (isset($_POST['username']) && isset($_POST['pwd'])) {
            $username = htmlspecialchars(trim($_POST["username"]));
            $pwd = htmlspecialchars(md5(trim($_POST["pwd"])));
            sessionInfo($db, $username, $pwd);
        }
    }
    if (isset($_GET['login']) && $_GET['login'] == "false"){
        session_destroy();
    }

    function sessionInfo($db, $username, $pwd) {
        if ($result = $db->login($username, $pwd)) {
            $_SESSION['username'] = $result['username'];
            $_SESSION['role'] = $result['role'];
        }
    }

    header('Location: /index.php');
?>