<?php

/**
 * Zpracování komentářů k položkám v aplikaci.
 *
 * Skript obsahuje funkce pro přidání komentáře k určité položce a následné přesměrování.
 * Kontroluje, zda byl odeslán komentář a provádí jeho zpracování a ukládání do JSON souboru.
 * Následně přesměrovává zpět na původní stránku s položkou nebo na úvodní stránku.
 *
 * @package CommentProcessing
 */

/**
 * Spuštění relačního záznamu pro aktuálního uživatele.
 */
session_start();

/**
 * Načtení třídy pro ověření uživatele.
 */
require_once "login.class.php";

/**
 * Vytvoření instance třídy pro ověření uživatele.
 */
$user = new LoginUser(null, null);


/**
 * Získání názvu položky z parametru URL.
 */
$kolonadaName = isset($_GET['name']) ? $_GET['name'] : '';

/**
 * Získání informací o položce a uživateli.

 */
$item_name = isset($_GET['name']);
$item_name = pathinfo($item_name, PATHINFO_FILENAME);
$username = $user->getUsername();

/**
 * Získání komentáře z formuláře.
 */
$comment = $_POST['comment'];

/**
 * Uložení komentáře do JSON souboru, pokud byl zadán.
 */
if ($comment != null) {
    /**
     * Načtení stávajících komentářů z JSON souboru.
     */
    $comments = json_decode(file_get_contents('jsons/comments.json'), true);

    /**
     * Přidání nového komentáře do pole komentářů.
     */
    $comments[] = [
        'id' => uniqid(),
        'item_name' => $_POST['redirect'],
        'username' => $username,
        'comment' => $comment,
        'date' => date("d-m-y"),
    ];

    /**
     * Uložení aktualizovaného pole komentářů zpět do JSON souboru.
     */
    file_put_contents('jsons/comments.json', json_encode($comments));
}

    /**
     * Přesměrování zpět na původní nebo úvodní stránku.
     */
    if (isset($_POST['redirect']) && !empty($_POST['redirect'])) {
        header("Location: " . "kolonada.php?name=" . $_POST['redirect']);
    } else {
        header("Location: index.php");
    }
