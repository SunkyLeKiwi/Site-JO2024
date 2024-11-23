<?php
session_start();
require_once("./../connection.php");

$nom_eve = mysqli_real_escape_string($db, htmlspecialchars($_POST['event-name'], ENT_QUOTES, 'UTF-8'));
$lieu_eve = mysqli_real_escape_string($db, htmlspecialchars($_POST['event-location'], ENT_QUOTES, 'UTF-8'));
$date_eve = mysqli_real_escape_string($db, htmlspecialchars($_POST['event-date'], ENT_QUOTES, 'UTF-8'));

$query2 = "SELECT * FROM Evenement WHERE nom = ? AND date_eve = ? AND lieu = ?";
$stmt2 = mysqli_prepare($db, $query2);
mysqli_stmt_bind_param($stmt2, "sss", $nom_eve, $date_eve, $lieu_eve);
mysqli_stmt_execute($stmt2);
$result = mysqli_stmt_affected_rows($stmt2);
if ($result != 0){
	$_SESSION['erreur'] = 8;
	header("location:./creer_evenement.php");
}

$desc_eve = mysqli_real_escape_string($db, htmlspecialchars($_POST['event-detail'], ENT_QUOTES, 'UTF-8'));

$valid_columns = ['Spectateur', 'Sportif', 'Organisateur'];
if ( (!isset($_POST['roles']) ) || (!in_array($_POST['roles'], $valid_columns) )) {
        $roles_eve = ['Spectateur'];
    } else {
        $roles_eve = $_POST['roles'];
    }

if (in_array('Sportif', $roles_eve)){
	$roles_eve_spo=1;
}
else{
	$roles_eve_spo=0;
}

if (in_array('Spectateur', $roles_eve)){
	$roles_eve_spe=1;
}
else{
	$roles_eve_spe=0;
}
if (in_array('Organisateur', $roles_eve)){
	$roles_eve_org=1;
}
else{
	$roles_eve_org=0;
}

$valid_columns_sport = ['Athletisme','Badminton','Basket-ball','Boxe','Breakdance','Canoe-kayak','Cyclisme','Equitation','Escalade','Escrime','Football','Golf','Handball','Judo','Natation','Tennis','Surf','Tennis de table','Volley-ball'];
if (!in_array($_POST['event-type'], $valid_columns_sport)) {
        $_SESSION['erreur']=7;
        header('location:creer_evenement.php');
    } else {
        $type_eve = $_POST['event-type'];
}

$id_eve = null;
$id_orga_eve = mysqli_real_escape_string($db, htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'));
$query = "INSERT INTO Evenement VALUES(?,?,?,?,?,?,?,?,?,?)";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "isssssiiis",$id_eve,$nom_eve,$date_eve,$lieu_eve,$desc_eve,$type_eve, $roles_eve_spo, $roles_eve_spe , $roles_eve_org , $id_orga_eve);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_affected_rows($stmt);
if($result != 1){
	die("Erreur lors de la création de l'évènement la base de données");
}
header("location:./index.php");
?>