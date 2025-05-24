<?php

/**
 * Načte odstavce z určeného textového souboru a vytiskne každý odstavec v HTML elementu <p>.
 *
 * @param string $kolonadaName Název adresáře Kolonády obsahujícího textový soubor.
 * @param string $filename Název textového souboru (bez přípony), který má být načten.
 * @return void
 */

function loadPar($kolonadaName, $filename)
{
    $file = file("textfiles/{$kolonadaName}/{$filename}.txt");
    foreach ($file as $value) {
        echo "<p>$value</p>";
    }
}

/**
 * Získá pole jmen z textového souboru "kolonady.txt".
 *
 * @return array Pole obsahující jména získaná ze souboru.
 */

function getNames()
{
    $file = file_get_contents("./textfiles/kolonady.txt");
    return explode(",", $file);
}
/**
 * Vygeneruje a získá CSRF token.
 *
 * Pokud relace ještě nemá CSRF token, vygeneruje ho a uloží do relace.
 *
 * @return string Vygenerovaný nebo existující CSRF token.
 */

function csrf_token()
{
    if (empty($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    }
    return $_SESSION['csrf_token'];
}
