<?php
require_once "header.php";
include_once '../utils/DbConnector.php';
include_once '../account/User.php';
if(!isset($_SESSION['user_id'])){
    header("Location: templates/index.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$dbConn = new DbConnector();
$user = $dbConn->getUser($user_id);
?>
<section>
    <div>
        <div>Moje dane</div>
        <form action="../UserHandler.php" method="POST">
            <label for="firstName">Imie</label>
            <input id="firstName" name="firstName" type="text"
                   value="<?php echo $user->getFirstName(); ?>">
            <label for="lastName">Nazwisko</label>
            <input id="lastName" name="lastName" type="text"
                   value="<?php echo $user->getLastName(); ?>">
            <label for="email">Email</label>
            <input id="email" name="email" type="text"
                   value="<?php echo $user->getMail(); ?>">
            <input type="hidden" name="_action" value="UPDATE">
            <input type="submit" value="Zaktualizuj">
        </form>
    </div>
    <div>
        <div>Zmień hasło</div>
        <form action="../UserHandler.php" method="POST">
            <label for="old_password">Hasło</label><input id="old_password" name="old_password" type="password">
            <label for="password">Nowe hasło</label><input id="password" name="password" type="password">
            <label for="re-password">Powtórz nowe hasło</label><input id="re-password" name="re-password" type="password">
            <input type="hidden" name="_action" value="UPDATE_PASS">
            <input type="submit" value="Zaktualizuj">
        </form>
    </div>
</section>
</body>
