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
            <h2>Регистрация</h2>
            </p>';
            echo '<form action="">
    <p><input type=login name=login placeholder="Логин"></p>
    <p><input type=password name=password0 placeholder="Пароль"></p>
    <p><input type=password name=password1 placeholder="Повторный пароль"></p>
    <p><input type=submit name=go value=Регистрация></p>
  </form>';
        } else {
            if ($_GET['password0'] == $_GET['password1']) {
                $conn = new mysqli("localhost", "root", "", "kursov");
                $login = $conn->real_escape_string($_GET["login"]);
                $password = $conn->real_escape_string($_GET["password0"]);
                $sel = "SELECT * FROM users WHERE login = '$login'";
                $res = mysqli_query($conn, $sel);
                $num = mysqli_num_rows($res);
                if ($num == 0) {
                    //добавляем в бд
                    $sql = "insert into users (login, password, role) values ('$login', '$password', 'user')";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        $_SESSION['password'] = $_GET['password0'];
                        $_SESSION['login'] = $_GET['login'];
                        $message = "Вы зарегестрированы!";
                        header("Location: main.php");
                        exit();
                    } else {
                        echo "Error";
                    }
                } else {
                    $_SESSION['error_msg'] = 'Неверный пароль или логин';
                }
                if(!empty($_SESSION['error_msg'])){
                    echo $_SESSION['error_msg'];
                    unset($_SESSION['error_msg']);
                } else{
                    header("Location: main.php");
                }
            } else {
                echo "Пароли не совпадают!";
                exit();
            }
            $conn->close();
        }
        ?>
    </div>
</body>

</html>