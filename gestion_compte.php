<div class="gestion-compte">
    <?php
    if (isset($_SESSION['username'])) {
        ?>
        <form method="post" action="https://dwarves.iut-fbleau.fr/~aureau/SAe_2.2_Web/index.php">
            <label for="username">Changer de Pseudo:</label>
            <br>
            <?php
            $username = $_SESSION['username'];
            echo "<input type=\"text\" name=\"username\" class=\"username\" id=\"username\" value=\"$username\">";
            ?>
            <br>

            <label for="tel">Numéro de Téléphone:</label>
            <br>
            <?php
            if (isset($_SESSION['tel'])) {
                $tel = $_SESSION['tel'];
                echo "<input type=\"tel\" name=\"tel\" class=\"tel\" id=\"tel\" value=\"$tel\">";
            } else {
                echo "<input type=\"tel\" name=\"tel\" class=\"tel\" id=\"tel\">";
            }
            ?>
            <br>

            <label for="email">Adresse E-mail:</label>
            <br>
            <?php
            if (isset($_SESSION['email'])) {
                $email = $_SESSION['email'];
                echo "<input type=\"email\" name=\"email\" class=\"email\" id=\"email\" value=\"$email\">";
            } else {
                echo "<input type=\"email\" name=\"email\" class=\"email\" id=\"email\">";
            }
            ?>
            <br>

            <button type="submit" class="envoie-gestion">Valider</button>
        </form>
        <?php
    }
    ?>
</div>
