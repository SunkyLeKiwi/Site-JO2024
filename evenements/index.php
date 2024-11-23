<?php
session_start();
require_once("./../connection.php");

if (!isset($_SESSION['username'])) {
    header("location:./..");
}

if (isset($_SESSION['erreur'])) {
    if ($_SESSION['erreur'] == 4) {
        echo "<script>alert('Vous êtes connecté.')</script>";
        $_SESSION['erreur'] = 0;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./../css/gestion_compte.css">
    <link rel="stylesheet" type="text/css" href="./../css/style.css">
    <link rel="stylesheet" type="text/css" href="./../css/header.css">
    <link rel="stylesheet" type="text/css" href="./../css/footer.css">
    <link rel="stylesheet" type="text/css" href="./../css/evenement.css">
    <script type="text/javascript" src="./../js/script.js" defer></script>
    <title>Évènements</title>
</head>
<body>
    <?php
    require_once("./../header.php");
    require_once("./../gestion_compte.php");
    ?>
    <div class="site-entrer">
        <h1 class="title">Évènements</h1>
    </div>
    <main>
        <form method="get" action="index.php" class="form-recherche">
            <div class="barre-de-recherche">
                <input type="text" name="recherche" class="recherche" placeholder="Rechercher un évènement">
                <button type="submit" class="b-recherche"><img src="./../assets/loupe.svg"></button>
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
        <form method="post" action="gestion_inscription.php">
            <table style="border:solid 1px black">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Date</th>
                        <th>Lieu</th>
                        <th>Description</th>
                        <th>Type d'évènement</th>
                        <th>Choix de l'évènement</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (!isset($_GET["tries"])) {
                        $res = mysqli_query($db, "SELECT id_eve, nom, date_eve, lieu, description, type_eve, ins_spo, ins_spe, ins_org FROM Evenement ORDER BY nom");
                        if ($res) {
                            while ($evenement = mysqli_fetch_assoc($res)) {
                                echo "<tr>
                                <td><a style='color:red;text-decoration:underline' href='page_commentaire.php?id_eve={$evenement['id_eve']}'>{$evenement['nom']}</a></td>
                                <td>{$evenement['date_eve']}</td>
                                <td>{$evenement['lieu']}</td>
                                <td>{$evenement['description']}</td>
                                <td>{$evenement['type_eve']}</td>
                                <td>";
                                if (($evenement['ins_spo'] && ($_SESSION['type']=='Sportif')) || ($evenement['ins_spe'] && ($_SESSION['type']=='Spectateur')) || ($evenement['ins_org'] && ($_SESSION['type']=='Organisateur'))){
                                    $nom_boutton = $evenement['id_eve'];
                                    echo "<label class='radio'><input type='radio' name='choix' value='$nom_boutton'></label>";
                                }
                                echo "</td></tr>";
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
                        $query = "SELECT id_eve, nom, date_eve, lieu, description, type_eve, ins_spo, ins_spe, ins_org FROM Evenement WHERE nom LIKE ? ORDER BY $type_tri";
                        $stmt = mysqli_prepare($db, $query);
                        mysqli_stmt_bind_param($stmt, "s", $a_rechercher);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        while ($evenement = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                            <td><a style='color:red;text-decoration:underline' href='page_commentaire.php?id_eve={$evenement['id_eve']}'>{$evenement['nom']}</a></td>
                            <td>{$evenement['date_eve']}</td>
                            <td>{$evenement['lieu']}</td>
                            <td>{$evenement['description']}</td>
                            <td>{$evenement['type_eve']}</td>
                            <td>";
                            if (($evenement['ins_spo'] && ($_SESSION['type']=='Sportif')) || ($evenement['ins_spe'] && ($_SESSION['type']=='Spectateur')) || ($evenement['ins_org'] && ($_SESSION['type']=='Organisateur'))){
                                $nom_boutton = $evenement['id_eve'];
                                echo "<label class='radio'><input type='radio' name='choix' value='$nom_boutton'></label>";
                            }
                            echo "</td></tr>";
                        }
                        mysqli_stmt_close($stmt);
                    }
                    ?>
                </tbody>
            </table>  
            <?php
            $nom_boutton_ins = "S'inscrire";
            if (($_SESSION['type'] == 'Spectateur') || ($_SESSION['type'] == 'Organisateur')){
                echo "<button type='submit' class='inscription'>$nom_boutton_ins</button>";
            } else {
                echo "<label><input type='radio' name='action' value='inscription' class='choix_spo'> S'inscrire</label>
                      <label><input type='radio' name='action' value='participation' class='choix_spo'> Participer</label>
                      <button type='submit' class='inscription'>Valider</button>";
            }
            ?>
        </form>
    </main>
</body>
<?php
require_once("./../footer.php");
?>
</html>