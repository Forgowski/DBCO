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
            <li><a href="/DBCO/templates/index.php">Strona Główna</a></li>
            <li><a href="/DBCO/templates/about.php">O nas</a></li>
            <li><a href="/DBCO/templates/kursy.php">Kursy</a></li>
            <?php
            session_start();
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
            if($user_id == null){
                ?>
                <li class = 'right'><a href="/DBCO/templates/login.php">Zaloguj się</a></li>
                <li class = 'right'><a href="/DBCO/templates/register.php">Zarejestruj się</a></li>
                <?php
            }else{
                $admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : null;
                if($admin==1){
                    ?>
                    <li class = 'right'><a href="/DBCO/templates/admin_panel.php">Panel administratora</a></li>
                    <?php
                }else{
                    ?>
                    <li class = 'right'><a href="/DBCO/templates/moje_kursy.php">Moje kursy</a></li>
                    <?php
                }
                ?>
                <li class = 'right'><a href="/DBCO/templates/ustawienia.php">Ustawienia</a></li>
                <li class = 'right'><a href="/DBCO/wyloguj.php">Wyloguj się</a></li>
                <?php
            }
            ?>
        </ul>
    </nav>
</header>