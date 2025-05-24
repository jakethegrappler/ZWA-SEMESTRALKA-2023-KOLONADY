<?php
/**
 * Spustí novou nebo obnoví existující relaci.
 */
session_start();

/**
 * Vyžaduje soubor s definicí třídy LoginUser.
 */
require("login.class.php");

/**
 * Ověřuje odeslání formuláře pro přihlášení.
 */
if (isset($_POST['submit'])) {

    /**
     * Ověřuje token pro ochranu proti CSRF útokům.
     */
    if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF attack detected');
    } else {

        /**
         * Vytvoří instanci třídy LoginUser s předaným uživatelským jménem a heslem.
         */
        $user = new LoginUser($_POST['username'], $_POST['password']);
    }

    /**
     * Ověřuje, zda je uživatel přihlášen, a přesměruje na hlavní stránku.
     */
    if ($user->isLoggedIn()) {
        $_SESSION['logged_in'] = true;
        // Přesměrování na hlavní stranu
        header('Location: index.php');
        exit();
    }
}
/**
 * Kontroluje, zda je uživatel již přihlášen, a přesměrovává na hlavní stránku.
 */
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: index.php');
    exit();
}
?>
<?php include "head.php"; ?>

<div class="user_check">
    <form action="login.php" method="post" class="user_form" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

        <label>Username: </label>
        <input type="text" name="username" placeholder="Enter your Username..." id="username" value="<?php if (isset($_POST['submit'])){ echo $_POST["username"];}?>"required>

        <label>Password: </label>
        <input type="password" name="password" placeholder="Enter password..." id="password" required>
        <button type="submit" name="submit" class="login-butt">Log in</button>

        <a href="register.php" id="SignUp" rel="SignUp">
           SignUp
        </a>

        <p class="error"><?php if(isset($_POST['submit'])){
            echo @$user->error; }?>
        </p>
        <p class="success"><?php echo @$user->success ?></p>
    </form>
</div>

</body>
</html>
