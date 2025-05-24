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
<?php include "head.php"; ?>


<div class="page-container">
    <div class="kolonady">

        <?php
        /**
         * Pole obsahující jména kolonád.
         *
         * @var array $names Pole obsahující jména kolonád.
         */
        $names = getNames();

        /**
         * Prochází jména kolonád a vytváří odkazy a informační boxy pro každou kolonádu.
         */
        foreach ($names as $name) {
            echo "<a href='kolonada.php?name={$name}'>";
            echo "<div class='item-box'>";
            echo "<div class='kolonada-img'>";
            echo "<img src='images/{$name}-index.jpg' alt='{$name}'>";
            echo "</div>";
            $file = file_get_contents("textfiles/{$name}/nazev.txt");
            echo "<h3 class='name'>$file</h3>";
            echo "<div class='popis'>";

            /**
             * Zobrazuje stručný popis kolonády.
             *
             * @param string $name Název kolonády.
             */
            loadPar($name, "short");
            echo "</div></div></a>";
        }

        ?>

    </div>

</div>


<?php include "footer.php"; ?>
</body>


</html>