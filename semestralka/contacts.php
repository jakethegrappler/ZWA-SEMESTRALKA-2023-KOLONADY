<?php

/**
 * Start a new or resume an existing session.
 */

session_start();


/**
 * Require the LoginUser class file.
 */

require_once "login.class.php";

/**
 * Vytvoří novou instanci třídy LoginUser s nulovými hodnotami pro uživatelské jméno a heslo.
 *
 * @var LoginUser $user Instance třídy LoginUser.
 */

$user = new LoginUser(null, null);
include "head.php";


?>
<div class="page-container">
    <div class="kontakty">
        <p>Adresa: Karlovy Vary 36007</p>
        <p>Telefon: +420 314 159 123</p>
        <p>Email: kolonady@info.cz</p>
    </div>
</div>

<?php include 'footer.php'?>
</body>


</html>
