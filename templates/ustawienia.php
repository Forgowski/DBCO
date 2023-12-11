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
            <label class="lb-registry" for="firstName">Imie</label>
            <input class="inp-txt-input" id="firstName" name="firstName" type="text"
                   value="<?php echo $user->getFirstName(); ?>">
            <label class="lb-registry" for="lastName">Nazwisko</label>
            <input class="inp-txt-input" id="lastName" name="lastName" type="text"
                   value="<?php echo $user->getLastName(); ?>">>
            <label class="lb-registry" for="email">Email</label>
            <input class="inp-txt-input" id="email" name="email" type="text"
                   value="<?php echo $user->getMail(); ?>">
            <input type="hidden" name="_action" value="UPDATE">
            <input type="submit" value="Zaktualizuj">
        </form>
    </div>
    <div>
        <div>Zmień hasło</div>
        <form action="../UserHandler.php" method="POST">
            <label class="lb-registry" for="old_password">Hasło</label><input class="inp-txt-input" id="old_password" name="old_password" type="password">
            <label class="lb-registry" for="password">Nowe hasło</label><input class="inp-txt-input" id="password" name="password" type="password">
            <label class="lb-registry" for="re-password">Powtórz nowe hasło</label><input class="inp-txt-input" id="re-password" name="re-password" type="password">
            <input type="hidden" name="_action" value="UPDATE_PASS">
            <input type="submit" value="Zaktualizuj">
        </form>
    </div>
</section>
</body>
