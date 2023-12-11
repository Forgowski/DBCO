<!DOCTYPE html>
<html lang="pl">
<head>
  <!-- Theme Made By www.w3schools.com - No Copyright -->
  <title>Title</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
  body {
    font: 20px Montserrat, sans-serif;
    line-height: 1.8;
    color: black;
    background-color: #1abc9c;
  }
  p {font-size: 16px; color: black;}
  .margin {margin-bottom: 45px;}
  .bg-1 { 
    background-color: #1abc9c; /* Green */
    color: black;
  }
  .bg-2 { 
    background-color: #474e5d; /* Dark Blue */
    color: black;
  }
  .bg-3 { 
    background-color: #ffffff; /* White */
    color: black;
  }
  .bg-4 { 
    background-color: #2f2f2f; /* Black Gray */
    color: black;
  }
  .container-fluid {
    padding-top: 70px;
    padding-bottom: 70px;
  }
  .navbar {
    padding-top: 15px;
    padding-bottom: 15px;
    border: 0;
    border-radius: 0;
    margin-bottom: 0;
    font-size: 12px;
    letter-spacing: 5px;
  }
  .navbar-nav  li a:hover {
    color: #1abc9c !important;
  }
  .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
    color: black;
  }
  </style>
</head>
<body>

<!-- Navbar -->
<header>
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">Me</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
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
    </div>
  </div>
</nav>
</header>

<!-- First Container -->
<div class="container-fluid bg-1 text-center">

</div>



