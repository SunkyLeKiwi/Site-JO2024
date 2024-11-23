<?php
require_once("connection.php");
session_start();

$identifiant = mysqli_real_escape_string($db, htmlspecialchars($_POST['identifiant'], ENT_QUOTES, 'UTF-8'));
$motdepasse_hash = password_hash(mysqli_real_escape_string($db, htmlspecialchars($_POST['mdp'], ENT_QUOTES, 'UTF-8')), PASSWORD_DEFAULT);
$type_utilisateur = mysqli_real_escape_string($db, htmlspecialchars($_POST['role'], ENT_QUOTES, 'UTF-8'));

$valid_columns = ['Spectateur', 'Organisateur', 'Sportif'];
if (!in_array($type_utilisateur, $valid_columns)) {
    $type_utilisateur = 'Spectateur';
}

$res= "SELECT identifiant FROM Compte WHERE identifiant=?";
$stmt = mysqli_prepare($db, $res);
mysqli_stmt_bind_param($stmt, "s", $identifiant);
mysqli_stmt_execute($stmt);
$resultat = mysqli_stmt_get_result($stmt);
if(!$resultat){
	die("Erreur lors de la recherche dans la base de données");
} else {
	if(!mysqli_num_rows($resultat)==0){
		$_SESSION['erreur'] = 3;
		header("location:creationCompte");
	}
}

$query = "INSERT INTO Compte (identifiant, mdp, type) VALUES(?,?,?)";
$stmt2 = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt2, "sss", $identifiant,$motdepasse_hash,$type_utilisateur);
mysqli_stmt_execute($stmt2);
$result = mysqli_stmt_affected_rows($stmt2);
if($result != 1){
	die("Erreur lors de l'insertion dans la base de données");
}
$_SESSION['erreur'] = 5;
header("location:connectionCompte");
?>