<?php
session_start();
require_once("connection.php");

// Vérification et mise à jour du username
if (isset($_POST['username']) && isset($_SESSION['username'])) {
    $username = mysqli_real_escape_string($db,htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8'));

    $stmt_verif = mysqli_prepare($db, "SELECT * FROM Compte WHERE identifiant = ?");
    mysqli_stmt_bind_param($stmt_verif, 's', $username);
    mysqli_stmt_execute($stmt_verif);
    $result = mysqli_stmt_get_result($stmt_verif);
    if ((!mysqli_num_rows($result)==0) && ($username != $_SESSION['username'])){
        echo "<script>alert('Cet identifiant est déjà utilisé. Veuillez choisir un autre identifiant.');</script>";
    }else if ($username != $_SESSION['username']){
        $stmt_user = mysqli_prepare($db, "UPDATE Compte SET identifiant = ? WHERE identifiant = ?");
        mysqli_stmt_bind_param($stmt_user, "ss", $username, $_SESSION['username']);
        if (mysqli_stmt_execute($stmt_user)) {
            $_SESSION['username'] = $username;
        } else {
            echo "<script>alert('Erreur lors de la mise à jour de l\'identifiant');</script>";
        }
        mysqli_stmt_close($stmt_user); 
    }
} 


// Vérification et mise à jour du numéro de téléphone
if (isset($_POST['tel']) && isset($_SESSION['username'])) {
    $tel = htmlspecialchars($_POST['tel'], ENT_QUOTES, 'UTF-8');

    // Filtrage du numéro de téléphone
    $tel = filter_var($tel, FILTER_SANITIZE_NUMBER_INT);
    $tel = str_replace(['-', '+'], '', $tel); // Supprimer les caractères supplémentaires
    if (strlen($tel) == 10) {
        $tel = mysqli_real_escape_string($db, $tel);
        $stmt_tel = mysqli_prepare($db, "UPDATE Compte SET numTel = ? WHERE identifiant = ?");
        mysqli_stmt_bind_param($stmt_tel, "ss", $tel, $_SESSION['username']);
        mysqli_stmt_execute($stmt_tel);
        $_SESSION['tel'] = $tel;
        mysqli_stmt_close($stmt_tel);
    } else {
        echo "<script>alert('Le numéro de téléphone n\'est pas valide');</script>";
    }
}

// Vérification et mise à jour de l'email
if (isset($_POST['email']) && isset($_SESSION['username'])) {
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');

    // Filtrage de l'email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email = mysqli_real_escape_string($db, $email);
        $stmt_email = mysqli_prepare($db, "UPDATE Compte SET adresseMail = ? WHERE identifiant = ?");
        mysqli_stmt_bind_param($stmt_email, "ss", $email, $_SESSION['username']);
        mysqli_stmt_execute($stmt_email);
        $_SESSION['email'] = $email;
        mysqli_stmt_close($stmt_email);
    } else {
        echo "<script>alert('L\'email n\'est pas valide');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JO-2024</title>

    <link rel="stylesheet" type="text/css" href="./css/gestion_compte.css">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/header.css">
    <link rel="stylesheet" type="text/css" href="./css/footer.css">

    <script src="./js/script.js" defer></script>
</head>
<body>

    <?php
        require_once("header.php");
        require_once("gestion_compte.php");
    ?>

    <div class="site-entrer">
        <h1 class="title">Bienvenue sur le site des jeux olympiques 2024 !</h1>
    </div>
    
<main>
        
    <form method="get" action="index.php" class="form-recherche">
        <div class="barre-de-recherche">
            <input type="text" name="recherche" class="recherche" placeholder="Rechercher un évènement">
            <button type="submit" class="b-recherche"><img src="./assets/loupe.svg"></button>
        </div>
        
        <section class="tableau">
            <label for="tries">Trier par :</label>
            <select name="tries">
                <option value="nom">nom</option>
                <option value="lieu">lieu</option>
                <option value="date_eve">date</option>
            </select>
        </section>
    </form>

    <table style="border:solid 1px black">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Date</th>
            <th>Lieu</th>
            <th>Description</th>
            <th>Type d'évènement</th>
    </thead>
    <tbody>
        <?php 
            if (!isset($_GET["tries"])) {
                $res = mysqli_query($db, "SELECT nom, date_eve, lieu, description, type_eve FROM Evenement ORDER BY nom");
                if ($res) {
                    while ($evenement = mysqli_fetch_assoc($res)) {
                        echo "<tr>
                        <td>{$evenement['nom']}</td>
                        <td>{$evenement['date_eve']}</td>
                        <td>{$evenement['lieu']}</td>
                        <td>{$evenement['description']}</td>
                        <td>{$evenement['type_eve']}</td>
                        </tr>";
                    }
                } else {
                    die("Erreur dans la requête SQL");
                }
            } else {
                $a_rechercher = mysqli_real_escape_string($db, $_GET['recherche']);
                $a_rechercher = '%' . $a_rechercher . '%';
                $type_tri = mysqli_real_escape_string($db, $_GET["tries"]);
                $valid_columns = ['nom', 'lieu', 'date_eve'];
                if (!in_array($type_tri, $valid_columns)) {
                    $type_tri = 'nom';
                }
                
                $query = "SELECT nom, date_eve, lieu, description, type_eve FROM Evenement WHERE nom LIKE ? ORDER BY $type_tri";
                $stmt = mysqli_prepare($db, $query);
                mysqli_stmt_bind_param($stmt, "s", $a_rechercher);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                while ($evenement = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                    <td>{$evenement['nom']}</td>
                    <td>{$evenement['date_eve']}</td>
                    <td>{$evenement['lieu']}</td>
                    <td>{$evenement['description']}</td>
                    <td>{$evenement['type_eve']}</td>
                    </tr>";
                }
                mysqli_stmt_close($stmt);
            }
        ?>
    </tbody>
    </table>
</main>

<br>
<br>

<?php
    require_once("footer.php");
?>
</body>
</html>
