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
 * Získá data komentáře pro specifikované ID komentáře.
 *
 * @var int $comment_id ID komentáře, který má být upraven.
 * @var array $comments Pole obsahující načtené komentáře ze souboru JSON.
 */

$comment_id = $_GET['comment_id'];
$comments = json_decode(file_get_contents('./jsons/comments.json'), true);

/**
 * Najde komentář k úpravě na základě ID a aktuálního uživatele.
 *
 * @var array|null $editable_comment Reference to the editable comment if found; otherwise, null.
 */

$editable_comment = null;
foreach ($comments as &$comment) {
    if ($comment['id'] == $comment_id && $comment['username'] == $user->getUsername()) {
        $editable_comment = &$comment;
        break;
    }
}
/**
 * Přesměruje na indexovou stránku, pokud komentář nebyl nalezen nebo nepatří aktuálnímu uživateli.
 */
if (!$editable_comment) {
    header("Location: index.php");
    exit();
}

/**
 * Zpracuje odeslaný formulář s úpravou komentáře.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /**
     * Obsah upraveného komentáře z POST dat.
     *
     * @var string $edited_comment_content
     */
    $edited_comment_content = $_POST['edited_comment'];
    /**
     * Upraví obsah komentáře.
     */
    $editable_comment['comment'] = $edited_comment_content;

    /**
     * Uloží aktualizovaný seznam komentářů zpět do JSON souboru.
     */
    file_put_contents('./jsons/comments.json', json_encode($comments, JSON_PRETTY_PRINT));

    /**
     * Přesměruje zpět na stránku s komentáři pro danou kolonadu..
     */
    header("Location: kolonada.php?name={$editable_comment['item_name']}");
    exit();
}

include "head.php";

?>


<div class="kolonady">
<h2>Upravit komentář</h2>

<form action="edit_comment.php?comment_id=<?php echo $comment_id; ?>" method="post" class="user_form">
    <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>">
    <textarea name="edited_comment"><?php echo htmlspecialchars($editable_comment['comment']); ?></textarea>
    <button type="submit" class="edit_butt">Upravit komentář</button>
</form>
</div>
<!-- Další obsah stránky, pokud potřebujete -->

<?php include "footer.php"; ?>

</body>
</html>
