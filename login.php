<?
require_once('theme.html');
?>
<form id="login-form" action="loginController.php" method="POST" name="login">
    <input type="text" name="username" placeholder="Username" required autocomplete="off">
    <input type="password" name="pwd" placeholder="Password" required autocomplete="off">
    <input type="submit" type="submit" value="Регистрация">
</form>