<?php
/**
 * Tento kód slouží pro odhlášení uživatele.
 * Začíná tím, že ukončí aktuální relaci, odstraní všechny relační proměnné, smaže relační cookie a přesměruje na přihlašovací stránku.
 */

/**
 * Spustí novou nebo obnoví existující relaci.
 */
session_start();

/**
 * Odstraní všechny proměnné ze relace.
 */
session_unset();

/**
 * Zničí relaci a odstraní všechny údaje ze session.
 */
session_destroy();

/**
 * Smaže relační cookie nastavením jeho expirace na minulý čas.
 */
setcookie(session_name(), '', time() - 3600);

/**
 * Přesměruje na přihlašovací stránku.
 */
header('Location: login.php');
exit();
