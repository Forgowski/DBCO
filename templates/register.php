<?php
require_once "header.php";
if(isset($_SESSION['user_id'])){
    header("Location: templates/index.php");
    exit();
}
?>
<section>
    <div>
        <form action="../UserHandler.php" method="post">
            <label for="firstName">Imie</label><input id="firstName" name="firstName" type="text">
            <label for="lastName">Nazwisko</label><input id="lastName" name="lastName" type="text">
            <label for="email">Email</label><input id="email" name="email" type="text">
            <label for="password">Hasło</label><input id="password" name="password" type="password">
            <label for="re-password">Powtórz hasło</label><input id="re-password" name="re-password" type="password">
            <input type="submit" value="Zarejestruj się">
        </form>
    </div>
</section>
<footer>

</footer>

</body>