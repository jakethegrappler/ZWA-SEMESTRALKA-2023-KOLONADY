<?php

/**
 * Start nové nebo obnov stávající relace.
 */
session_start();

/**
 * Vyžaduje soubor obsahující třídu LoginUser.
 */

require_once "login.class.php";

/**
 * Vytvoří novou instanci třídy LoginUser s nulovými hodnotami pro uživatelské jméno a heslo.
 *
 * @var LoginUser $user Instance třídy LoginUser.
 */
$user = new LoginUser(null, null);

?>

<?php
/**
 * Začátek výstupu HTML hlavičky stránky.
 */
include "head.php";
?>


<div class="profile-img">
    <?php
    /**
     * Získá uživatelské jméno a vytvoří cestu k obrázku profilu.
     *
     * @var string $username Uživatelské jméno aktuálního uživatele.
     * @var string $imagePath Cesta k obrázku profilu.
     */

    $username = $user->getUsername();
    $imagePath = "profiles/image{$username}.jpg";
    // Zkontroluje, zda soubor existuje, než ho zobrazí
    if (file_exists($imagePath)) {
        echo "<img src='{$imagePath}' alt='Profile Picture'>";
    } else {
        echo "<img src='images/fb-profile.jpg' alt='No Profile Picture'>";
    }
    ?>
</div>

<div class="user-info">
    <div class="user-name">
        <?php
        /**
         * Zobrazí informace o uživateli včetně uživatelského jména.
         *
         * @param string $uname Uživatelské jméno aktuálního uživatele.
         */

        $uname = $user->getUsername();
        echo "<b>Username: </b> " . "$uname";
        ?>
    </div>
    <div class="user-mail">
        <?php
        /**
         * Zobrazí informace o uživateli včetně emailové adresy.
         *
         * @param string $mail Emailová adresa aktuálního uživatele.
         */
        $mail = $user->getMail();
        echo "<b>Email: </b>" . "$mail";
        ?>
    </div>
</div>


<?php
include 'footer.php'
?>


</body>

</html>