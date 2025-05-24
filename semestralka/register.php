<?php

/**
 * Registrace nového uživatele.
 *
 * Tento skript zpracovává přihlášení nového uživatele. V případě úspěšné registrace
 * přesměruje uživatele na přihlašovací stránku. Obsahuje také ochranu proti CSRF útokům.
 *
 * @package Registration
 */


/**
 * Start nové nebo obnov stávající relace.
 */
session_start();

/**
 * Vyžaduje soubor s definicí třídy RegisterUser.
 */
require("register.class.php");


/**
 * Zpracování formuláře při odeslání.
 *
 * Provádí kontrolu CSRF útoků a vytváří instanci třídy pro registraci uživatele.
 * Při úspěšné registraci přesměrovává na přihlašovací stránku.
 *
 * @uses RegisterUser
 */
if (isset($_POST['submit']) && $_POST['submit'] === "submitted") {
    if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF attack detected');
    } else {
        /**
         * Vytvoření instance třídy pro registraci uživatele.
         */
        $user = new RegisterUser($_POST['username'], $_POST['email'], $_POST['password'], $_POST['password2'], $_POST['gender'], $_FILES['image']);

        /**
         * Kontrola, zda byla registrace úspěšná.
         *
         * Při úspěšné registraci přesměrovává na přihlašovací stránku.
         *
         * @uses header
         * @uses exit
         */
        if ($user->success) {
            header("Location: login.php");
            exit();
        }
    }
}
include "head.php";
?>

<!-- Formulář také obsahuje ochranu proti neplatným hodnotám, které mohou být odeslány uživatelem, a zobrazuje chybové a úspěšné zprávy při registraci.-->
<form action="register.php" method="post" class="user_form" enctype="multipart/form-data" id="form" autocomplete="off">
    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">


    <label for="username">Username (required):</label>
    <input type="text" id="username" name="username" placeholder="Your username..." value="<?php if (isset($_POST['submit'])){ echo $_POST["username"];}?>" class="ajax-input" required maxlength="10">
    <span class="status-message"></span>



    <label for="email">Email (required):</label>
    <input type="email" id="email" name="email" placeholder="Your last email..." value="<?php if (isset($_POST['submit'])){ echo $_POST["email"];}?>" class="ajax-input" required>
    <span class="status-message"></span>


    <label for="password">Password (required): </label>
    <input type="password" name="password" placeholder="Choose a password" id="password" class="ajax-input" required>
    <span class="status-message"></span>


    <label for="password2">Confirm password (required): </label>
    <input type="password" name="password2" placeholder="Choose a password" id="password2" class="ajax-input" required>
    <span class="status-message"></span>


    <label for="FileToUpload">Photo </label>
        <input type="file" name="image" id="FileToUpload"  accept="image/png, image/jpeg, image/jpg">
    <div class="error">
        <?php
        if (isset($_POST['submit']) && $_POST['submit'] === "submitted" && $_FILES["image"]["size"] > 10485760) {
            echo "file can't be bigger than 10MB";
        }
        ?>
    </div>



    <label for="gender">Choose your gender (not required): </label>
    <select name="gender" id="gender">
        <option id="genderM" value="Male" >Male</option>
        <option id="genderF" value="Female">Female</option>
    </select>


    <button type="submit" name="submit"  value="submitted">Register</button>

    <div id="error" class="error">
        <?php
        if (isset($_POST['submit']) && !$user->success){
            /**
             * Kontrola, zda $user->error je polem před použitím foreach.
             * V případě pole zobrazuje chybové hlášky jednotlivě.
             * Pokud $user->error není pole, může to být řetězec, a proto se zobrazí jako jedna chyba.
             *
             * @uses is_array
             * @uses foreach
             */
            if (is_array($user->error)) {
                foreach ($user->error as $value){
                    echo "<p>$value</p>";
                }
            } else {
                /**
                 * Pokud $user->error není pole, může to být řetězec, a proto se zobrazí jako jedna chyba
                 */
                echo "<p>{$user->error}</p>";
            }
        }
        ?>
    </div>

    <p class="success">
        <?php
        /**
         * Pokud byl uživatel úspěšně registrován, je přesměrován na login.php
         */
        if (@$user->success) {
            header("Location: login.php");
        }
        ?>
    </p>

</form>

</body>
</html>
