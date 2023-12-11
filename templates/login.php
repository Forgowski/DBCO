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
            <label class="lb-registry" for="email">Email</label><input class="inp-txt-input" id="email" name="email" type="text">
            <label class="lb-registry" for="password">Hasło</label><input class="inp-txt-input" id="password" name="password" type="password">
            <input type="submit" value="Zaloguj się">
        </form>
        <div class="forget-password">
            <span><a href="#">Zapomniałem hasła</a></span>
        </div>
    </div>

</section>
<footer>

</footer>

</body>