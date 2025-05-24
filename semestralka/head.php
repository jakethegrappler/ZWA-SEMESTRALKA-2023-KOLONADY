<?php
/**
 * @file
 * head.php
 *
 * @brief Obsah souboru pro hlavičku HTML stránky.
 */

/**
 * Includování souboru s obecnými funkcemi.
 */
require "functions.php";

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
 * Zobrazuje lištu v závislosti na přihlášení uživatele.
 *
 * Pokud je uživatel přihlášen, zobrazí se lišta pro přihlášeného uživatele (`bar_in.php`), jinak se zobrazí lišta pro nepřihlášeného uživatele (`bar.php`).
 */



?>
<!DOCTYPE html>
<html lang="zxx">
<meta charset="UTF-8">

<head>
    <title>Kolonády Karlovarska</title>
    <link rel="stylesheet" href="CSS/zkusebni_kaskady.css">
    <link rel="stylesheet" media="print" href="CSS/styl_pro_tisk.css">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-kolonady-final.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <script defer src="JS/funkce.js"></script>
    <script defer src="JS/validace.js"></script>



</head>
<?php
if ($user->isLoggedIn()) {
    include "bar_in.php";
} else {
    include "bar.php";
}
?>
<body>

