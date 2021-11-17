<?
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="/js/jquery-3.6.0.min.js"></script>
    <title>Сайт</title>
</head>
<body>
    <div id="wrapper">
        <div class="top-menu">
            <div class="main-menu">
                <a href="/">Главная</a>
                <?
                if (isset($_SESSION['role']) && $_SESSION['role'] == 0) {
                    ?>
                    <a href="addItem.php">Добавить товар</a>
                    <?
                }
                ?>
            </div>
            <div class="reg-controll">
                <?
                if (isset($_SESSION['username'])) {
                    ?>
                    <a class="sign-in"><?echo $_SESSION['username'];?></a>
                    <a href="/loginController.php?login=false" class="sign-up">Выйти</a>
                    <?
                } else {
                    ?>
                    <a href="/login.php" class="sign-in">Войти</a>
                    <a href="/registration.php" class="sign-up">Регистрация</a>
                    <?
                }
                ?>

            </a>
        </div>
    </div>