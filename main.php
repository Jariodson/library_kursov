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
    <div id="main">
        <?php

        ?>
        <div id="top-main">
            <div class="inf">
                <h2>Общая информация</h2>
                <p>Составить программу, которая содержит текущую информацию о книгах в библиотеке. Сведения о книгах
                    содержат: номер УДК, фамилию и инициалы автора, название, год издания, количество экземпляров в
                    библиотеке. Программа должна обеспечить: начальное формирование данных обо всех книгах; добавление
                    данных о книгах, поступающих в библиотеку; изменение данных при вводе информации о том, что
                    пользователь берет или возвращает книгу; выдачу данных о наличии книг в библиотеке. Вся информация
                    должна храниться в БД.</p>
            </div>
        </div>
    </div>
</body>

</html>