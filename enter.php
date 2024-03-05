<?php
session_start();
?>
<html>

<head>
    <title>Библиотека</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div id=head>
        <div id="login">
            <?php
            if (!isset($_SESSION['login']) && !isset($_SESSION['password0'])) {
                echo '<ul class="topmenu">
            <li><a href="reg.php" id="welcome">Регистация</a></li>
            <li><a>/</a></li>
            <li><a href="enter.php" id="welcome">Вход</a></li>
        </ul>';
            } else {
                echo '<ul class="topmenu">
                <li><a>Добро пожаловать, ', $_SESSION['login'];
                echo '!</a></li>
                <li><a href="clear-session.php" id="welcome">Выйти</a></li>';
            }
            ?>
        </div>
        <header>
            <a href="main.php" class="logo">БИБЛИОТЕКА</a>
            <nav>
                <ul class="menu">
                    <li><a href="katalog.php">Каталог</a></li>
                </ul>
            </nav>
        </header>
    </div>
    <div id="reg">
        <?php
        if (!isset($_GET['go'])) {
            echo '<p>
            <h2>Авторизация</h2>
            </p>';
            echo '<form>
    <p><input type=login name=login placeholder="Логин"></p>
    <p><input type=password name=password placeholder="Пароль"></p>
    <p><input type=submit name=go value=Авторизация></p>
  </form>';
        } else {
            $conn = mysqli_connect("localhost", "root", "", "kursov");
            $login = $conn->real_escape_string($_GET["login"]);
            $password = $conn->real_escape_string($_GET["password"]);
            $sel = "SELECT * FROM users WHERE login = '$login' AND password = '$password'";
            $res = mysqli_query($conn, $sel);
            $num = mysqli_num_rows($res);
                if ($num != 0) {
                    $_SESSION['password'] = $_GET['password'];
                    $_SESSION['login'] = $_GET['login'];
                    header("Location: main.php");
                }else{
                    header("Location: enter.php");
                }
        }
        ?>
    </div>
</body>

</html>