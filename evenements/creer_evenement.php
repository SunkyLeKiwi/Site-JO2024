<?php
    session_start();
    require_once("./../connection.php");
    if (!isset($_SESSION['username'])){
        header("location:./..");
    }else if($_SESSION['type'] != 'Organisateur'){
        header("location:./..");
    }


    if (isset($_SESSION['erreur'])){
        if ($_SESSION['erreur'] == 7){
        echo "<script>alert('Erreur lors du choix du type d\'évènement.')</script>";
        $_SESSION['erreur'] = 0;
        }
        if ($_SESSION['erreur'] == 8){
        echo "<script>alert('Cet évènement existe déjà (même nom,même date et même lieu)')</script>";
        $_SESSION['erreur'] = 0;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creer un évènement</title>


    <link rel="stylesheet" type="text/css" href="./../css/gestion_compte.css">
    <link rel="stylesheet" type="text/css" href="./../css/style.css">
    <link rel="stylesheet" type="text/css" href="./../css/header.css">
    <link rel="stylesheet" type="text/css" href="./../css/footer.css">
    <link rel="stylesheet" type="text/css" href="./../css/creer_evenement.css">

    <script src="./../js/script.js" defer></script>
</head>
<body>
    <?php
        require_once("./../header.php");
        require_once("./../gestion_compte.php");
    ?>

    <main>
    <h1>Créer un évènement</h1>

    <form method="post" action="gestion_creer_evenement.php">
        <label for="event-name">Nom de l'événement</label>
        <input type="text" id="event-name" name="event-name" class="texte" required>

        <label for="event-location">Lieu</label>
        <input type="text" id="event-location" name="event-location" class="texte" required>

        <label for="event-date">Date</label>
        <input type="date" id="event-date" name="event-date" required>

        <label for="event-detail">Détail</label>
        <textarea id="event-detail" name="event-detail" required></textarea>

        
        <div class="roles">
            <span>Rôle pouvant s'inscrire :</span><br>
            <label><input type="checkbox" name="role[]" value="spectateur"> Spectateur</label>
            <label><input type="checkbox" name="role[]" value="organisateur"> Organisateur</label>
            <label><input type="checkbox" name="role[]" value="sportif"> Sportif</label>
        </div>

        <label for="event-type">Type d'évènement</label>
        <select id="event-type" name="event-type" required>
            <option value="" disabled selected>Selectionner le type d'évènement</option>
            <option value="Athletisme">Athlétisme</option>
            <option value="Badminton">Badminton</option>
            <option value="Basket-ball">Basket-ball</option>
            <option value="Boxe">Boxe</option>
            <option value="Breakdance">Breakdance</option>
            <option value="Canoe-kayak">Canoë-kayak</option>
            <option value="Cyclisme">Cyclisme</option>
            <option value="Equitation">Équitation</option>
            <option value="Escalade">Escalade</option>
            <option value="Escrime">Escrime</option>
            <option value="Football">Football</option>
            <option value="Golf">Golf</option>
            <option value="Handball">Handball</option>
            <option value="Judo">Judo</option>
            <option value="Natation">Natation</option>
            <option value="Surf">Surf</option>
            <option value="Tennis">Tennis</option>
            <option value="Tennis de table">Tennis de table</option>
            <option value="Volley-ball">Volley-ball</option>
        </select>

        <button type="submit" class="envoi">Créer un événement</button>
    </form>
    </main>

    <?php
        require_once("./../footer.php");
    ?>
</body>
</html>