<?
require_once('theme.html');
?>

<form id="login-form" action="loginController.php" method="POST" name="resitration">
    <input type="text" name="username-reg" placeholder="Username" required autocomplete="off">
    <input type="password" name="pwd" placeholder="Password" required autocomplete="off">
    <div class="checkbox">
        <input id="admin-checkbox" type="checkbox" name="admin">
        <label for="admin-checkbox">Я Админ</label>
    </div>
    <input type="submit" type="submit" value="Регистрация">
</form>

</body>
</html>