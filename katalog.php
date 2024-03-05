<?php
session_start();
?>
<html>

<head>
    <title>Библиотека</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div id="head">
        <div id="login">
            <?php
            if (!isset($_SESSION['login']) && !isset($_SESSION['password'])) {
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
        //Таблица
        $conn = new mysqli("localhost", "root", "", "kursov");
        $sql = "SELECT * FROM katalog";
        if ($result = $conn->query($sql)) {
            echo "<table><tr><th>Удк</th><th>Имя автора</th><th>Название</th><th>Дата публикации</th><th>Кол-во экземпляров</th><th>В аренде</th></tr>";
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . $row["UDK"] . "</td>";
                echo "<td>" . $row["Name"] . "</td>";
                echo "<td>" . $row["Title"] . "</td>";
                echo "<td>" . $row["DatePub"] . "</td>";
                echo "<td>" . $row["Num"] . "</td>";
                echo "<td>" . $row["debt"] . "</td>";
                echo "</tr>";
            }
            //Редактирование *для админа
            if (isset($_SESSION['login']) && isset($_SESSION['password'])) {
                $login = $_SESSION['login'];
                $password = $_SESSION['password'];
                $sel = "SELECT * FROM users WHERE login = '$login' AND password = '$password' AND role = 'admin'";
                $res = mysqli_query($conn, $sel);
                $num = mysqli_num_rows($res);
                if ($num != 0) {
                    if (isset($_GET['go'])) {
                        echo
                        '<form>
                        <tr>
                        <td><input type=text name=udk placeholder=Удк></td>
                        <td><input type=text name=name placeholder=Имя автора></td>
                        <td><input type=text name=title placeholder=Название книги></td>
                        <td><input type=text name=date placeholder=Дата публикации></td>
                        <td><input type=text name=num placeholder=Кол-во экземпляров></td>
                        <td><input type=text name=num placeholder=Кол-во></td>
                        </tr></table>
                        <p><input type=submit name=save value=Сохранить>
                        <input type=submit name=back value=Назад></form></p>';
                    }
                    if (isset($_GET['save'])) {
                        $udk = $conn->real_escape_string(($_GET['udk']));
                        $name = $conn->real_escape_string(($_GET['name']));
                        $title = $conn->real_escape_string(($_GET['title']));
                        $datepub = $conn->real_escape_string(($_GET['date']));
                        $amount = $conn->real_escape_string(($_GET['num']));
                        $sel = "SELECT * FROM katalog WHERE Name='$name' AND Title='$title'";
                        $res = mysqli_query($conn, $sel);
                        $num = mysqli_num_rows($res);
                        if ($num == 0) {
                            $insert = "insert into katalog (UDK, Name, Title, DatePub, Num) values ('$udk', '$name', '$title', '$datepub', '$amount')";
                            $res = $conn->query($insert);
                            if ($res) {
                                header("Location: katalog.php");
                            }
                        }
                    }
                    if (!isset($_GET['go'])) {
                        echo "<form><p><input type=submit name=go value=Редактировать></form>";
                    }
                }
                
                $sel = "SELECT * FROM users WHERE login = '$login' AND password = '$password'";
                $res = mysqli_query($conn, $sel);
                $num = mysqli_num_rows($res);
                if ($num != 0) {
                    //Аренда
                    if (!isset($_GET['take'])) {
                        echo '<form><input type=submit name=take value=Аренда>';
                    } else {
                        echo '<form><p>Выберите название книги <select name=select0 myltiple>';
                        foreach ($result as $row) {
                            echo '<option>' . $row['Title'] . '</option>';
                        }
                        echo "</select></p>";
                        echo '<p>Выберете количество книг <select name=select1 myltiple>';
                        for ($i = 1; $i < 1000; $i++) {
                            echo '<option>' . $i . '</option>';
                        }
                        echo "</select></p>";
                        echo '<p><input type=submit name=taketake value=Арендовать> ';
                        echo '<input type=submit name=back value=Назад></p></form>';
                    }
                    if (isset($_GET['taketake'])) {
                        $title = $conn->real_escape_string($_GET['select0']);
                        $number = $conn->real_escape_string($_GET['select1']);
                        $sel = "SELECT * FROM katalog WHERE Title='$title'";
                        $res = mysqli_query($conn, $sel);
                        $num = mysqli_num_rows($res);
                        if ($num != 0) {
                            //$sel = "SELECT Num FROM katalog WHERE Title='$title'";
                            foreach ($result as $row) {
                                if ($row['Num'] >= $number) {
                                    $update = "UPDATE katalog SET Num = Num-'$number' WHERE Title='$title'";
                                    $update1 = "UPDATE katalog SET debt = debt+'$number' WHERE Title='$title'";
                                    $res = $conn->query($update);
                                    $res1 = $conn->query($update1);
                                    if ($res && $res1) {
                                        header("Location: katalog.php");
                                        exit();
                                    }
                                } else {
                                    echo "Столько книг у нас нет!";
                                    exit();
                                }
                            }
                        }
                    }
                    //возврат
                    if (!isset($_GET['return'])) {
                        echo '<form><p><input type=submit name=return value=Возврат></p>';
                    } else {
                        echo '<form><p>Выберите название книги <select name=select2 myltiple>';
                        foreach ($result as $row) {
                            echo '<option>' . $row['Title'] . '</option>';
                        }
                        echo "</select></p>";
                        echo '<p>Выберете количество книг <select name=select3 myltiple>';
                        for ($i = 1; $i < 1000; $i++) {
                            echo '<option>' . $i . '</option>';
                        }
                        echo "</select></p>";
                        echo '<p><input type=submit name=returnreturn value=Вернуть> ';
                        echo '<input type=submit name=back value=Назад></p></form>';
                    }
                    if (isset($_GET['returnreturn'])) {
                        $title1 = $conn->real_escape_string($_GET['select2']);
                        $number1 = $conn->real_escape_string($_GET['select3']);
                        $sel1 = "SELECT * FROM katalog WHERE Title='$title1'";
                        $res = mysqli_query($conn, $sel1);
                        $num = mysqli_num_rows($res);
                        if ($num != 0) {
                            foreach ($result as $row) {
                                if ($row['debt'] >= $number1) {
                                    $update = "UPDATE katalog SET Num = Num+'$number1' WHERE Title='$title1'";
                                    $update1 = "UPDATE katalog SET debt = debt-'$number1' WHERE Title='$title1'";
                                    $res = $conn->query($update);
                                    $res1 = $conn->query($update1);
                                    if ($res && $res1) {
                                        header("Location: katalog.php");
                                        exit();
                                    }
                                } else {
                                    echo "Слишком много книг для возврата!";
                                    exit();
                                }
                            }
                        }
                    }
                }
            }
            $result->free();
        }
        $conn->close();
        ?>
    </div>
</body>

</html>