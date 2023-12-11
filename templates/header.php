<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="index.php">Strona Główna</a></li>
            <li><a href="#">O nas</a></li>
            <li><a href="#">Kursy</a></li>
            <li><a href="#">Kontakt</a></li>
            <?php
            session_start();
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
            if($user_id == null){
                ?>
                <li class = 'right'><a href="login.php">Zaloguj się</a></li>
                <li class = 'right'><a href="register.php">Zarejestruj się</a></li>
                <?php
            }else{
                ?>
                <li class = 'right'><a href="moje_kursy.php">Moje kursy</a></li>
                <li class = 'right'><a href="ustawienia.php">Ustawienia</a></li>
                <li class = 'right'><a href="./../wyloguj.php">Wyloguj się</a></li>
                <?php
            }
            ?>
        </ul>
        <?php
        $admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : null;
        if($admin==1){
          echo 'jam admin';
        }
        elseif($admin==0){
            echo 'jam not admin';
        }
        ?>
    </nav>
</header>