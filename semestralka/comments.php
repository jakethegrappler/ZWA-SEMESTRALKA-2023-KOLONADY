<form action="submit_comment.php" method="post">
    <textarea name="comment" placeholder="Zanechat komentář"></textarea><br>

    <input type="hidden" name="redirect" value="<?php echo $_GET['name']; ?>"/>

    <input type="submit" value="Zverejnit">
</form>