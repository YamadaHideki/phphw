<?
require_once('theme.php');
?>
<form id="login-form" class="form-style" action="loginController.php" method="POST" name="login">
    <input type="text" name="username" placeholder="Username" required autocomplete="off">
    <input type="password" name="pwd" placeholder="Password" required autocomplete="off">
    <input type="submit" type="submit" value="Войти">
</form>