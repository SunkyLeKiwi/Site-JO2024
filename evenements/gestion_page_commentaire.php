<?php
session_start();
require_once("./../connection.php");

$com = mysqli_real_escape_string($db, htmlspecialchars($_POST['commentaire'], ENT_QUOTES, 'UTF-8'));
$id_eve = htmlspecialchars($_GET['id_eve'], ENT_QUOTES, 'UTF-8');

if ($com != "") {
    if (!ctype_digit($id_eve)) {
        $_SESSION["erreur"] = 12;
        header("Location: page_commentaire.php?id_eve=" . urlencode($id_eve));
        exit();
    }
    $id_eve = (int)$id_eve;
    $query = "INSERT INTO Commentaire VALUES(NULL, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "iss", $id_eve, $_SESSION["username"], $com);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_affected_rows($stmt);
    if ($result != 1) {
        die("Le commentaire n'a pas pu être ajouté à la base de données");
    } else {
        header("Location: page_commentaire.php?id_eve=" . urlencode($id_eve));
        exit();
    }
} else {
    $_SESSION["erreur"] = 11;
    header("Location: page_commentaire.php?id_eve=" . urlencode($id_eve));
    exit();
}
?>
