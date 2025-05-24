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

/**
 * Název aktuální stránky z URL parametru.
 *
 * @var string $current_page_name Název aktuální stránky z URL parametru.
 */
$current_page_name = $_GET['name'];

/**
 * Získání názvu kolonády z URL parametru.
 *
 * @var string $kolonadaName Název kolonády získaný z parametru URL.
 */$kolonadaName = isset($_GET['name']) ? $_GET['name'] : '';

include "head.php"?>

<div class="headline">
       <?php
        /**
         * Zobrazuje název kolonády z textového souboru.
         *
         * @param string $kolonadaName Název kolonády.
         * @param string $filename Název textového souboru.
         */
        loadPar($kolonadaName, "nazev");?>

</div>
<div class="head-img">
    <?php
    /**
     * Zobrazuje obrázek kolonády.
     */
    echo "<img src='./images/{$kolonadaName}.jpg' alt='kolonada'>"; ?>
</div>

<button type="button" class="collapsible" >Kudy?</button>
<div class="kolonada-info">
    <?php
    /**
     * Zobrazuje informace o cestách ke kolonádě.
     */
    loadPar($kolonadaName, "kudy");?>
</div>

<button type="button" class="collapsible" >Minulost</button>
<div class="kolonada-info">
    <?php
    /**
     * Zobrazuje informace o minulosti kolonády.
     */
    loadPar($kolonadaName, "minulost")?>
</div>

<button type="button" class="collapsible" >Popis</button>
<div class="kolonada-info">
    <?php
    /**
     * Zobrazuje architektonický popis kolonády.
     */
    loadPar($kolonadaName, "popis")?>

</div>

<button type="button" class="collapsible" >Zastřešené prameny</button>
<div class="kolonada-info">
    <?php
    /**
     * Zobrazuje informace o zastřešených pramenech v kolonádě.
     */
    loadPar($kolonadaName, "prameny")?>
</div>

<?php

/**
 * Pole dat načtených ze souboru JSON.
 */
$data = json_decode(file_get_contents('./jsons/data.json'), true);

echo "<div class='comment-section'>";

/**
 * Získá a dekóduje komentáře.
 */
$comments = json_decode(file_get_contents('./jsons/comments.json', true));
$commentsPerPage = 7;
$current_page_comments = [];

/**
 * Filtruje komentáře pro aktuální stránku.
 */
foreach ($comments as $comment) {
    if ($comment->item_name == $current_page_name) {
        $current_page_comments[] = $comment;
    }
}
/**
 * Uspořádá seznam komentářů od nejnovějších po nejstarší.
 */
$newest_comments = array_reverse($current_page_comments);

/**
 * Celkový počet komentářů.
 *
 * @var int $totalComments Celkový počet komentářů.
 */
$totalComments = count($current_page_comments);

/**
 * Celkový počet stránek.
 *
 * @var int $totalPages Celkový počet stránek.
 */
$totalPages = ceil($totalComments / $commentsPerPage);

/**
 * Aktuální stránka.
 *
 * @var int $current_page Aktuální stránka.
 */
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

/**
 * Výpočet začátečního indexu komentářů na aktuální stránce.
 *
 * @var int $startIndex Začáteční index komentářů na aktuální stránce.
 */
$startIndex = ($current_page - 1) * $commentsPerPage;



/**
 * Zobrazuje komentáře pro aktuální stránku.
 */
for ($i = $startIndex; $i < min($startIndex + $commentsPerPage, $totalComments); $i++) {
    $comment = $newest_comments[$i];

    echo '<p>';
    echo $comment->date . ' ';
    echo '<b>' . htmlspecialchars($comment->username) . '</b>' . ': ';
    echo htmlspecialchars($comment->comment);

    /**
     * Možnost úpravy komentáře pro přihlášeného uživatele, kterému náleží daný komentář.
     */
    if ($user->isLoggedIn() && $comment->username == $user->getUsername()){
        echo '<a class="edit_butt" href="edit_comment.php?comment_id=' . $comment->id . '">Upravit</a>';
    }

    echo '</p>';
}

/**
 * Zobrazuje tlačítko stránkování "Předchozí".
 */
if ($current_page > 1) {
    echo '<a href="?name=' . $current_page_name . '&page=' . ($current_page - 1) . '">Předchozí</a> ';
}

/**
 * Zobrazuje tlačítko stránkování "Další".
 */
if ($current_page < $totalPages) {
    echo '<a href="?name=' . $current_page_name . '&page=' . ($current_page + 1) . '">Další</a> ';
}


/**
 * Vloží formulář pro přidání nových komentářů.
 */
if ($user->isLoggedIn()) {
    include 'comments.php';
}

echo "</div>";
?>




<?php include 'footer.php'?>

</body>
</html>
