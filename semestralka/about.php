<?php

/**
 * @file
 * o_nas.php
 *
 * @brief Obsah souboru pro stránku "O Nás".
 */

/**
 * Inicializace relace pro aktuálního uživatele.
 */

session_start();



/**
 * Includování třídy pro přihlášení uživatele.
 *
 * Vytváří instanci třídy LoginUser pro zpracování přihlášení uživatele.
 *
 * @var LoginUser
 */
require_once "login.class.php";
$user = new LoginUser(null, null);

/**
 * Includování hlavičky HTML stránky.
 */

?>
<?php include "head.php"?>
<div class="page-container">
<div class="about_us">Vítejte na našem webu, který je věnován jednomu z nejkrásnějších a nejzajímavějších míst v České
    republice - Karlovým Varům. Jsme hrdými vlastníky a oddanými milovníky této kouzelné lázeňské destinace, která nás
    fascinuje svou historií, architekturou a léčivými prameny.</div>
</div>
<?php include 'footer.php'?>
</body>

</html>