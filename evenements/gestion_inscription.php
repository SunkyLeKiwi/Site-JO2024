<?php
session_start();
require_once("./../connection.php");

$username = mysqli_real_escape_string($db, htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'));
$type_user= mysqli_real_escape_string($db, htmlspecialchars($_SESSION['type'], ENT_QUOTES, 'UTF-8'));
$id_eve = (int) mysqli_real_escape_string($db, htmlspecialchars($_POST['choix'], ENT_QUOTES, 'UTF-8'));
if (!is_int($id_eve)){
	die("Problème au niveau du numéro de l'évènement.");
}

if($type_user == 'Sportif'){
	$action = mysqli_real_escape_string($db, htmlspecialchars($_POST['action'], ENT_QUOTES, 'UTF-8'));
	$valid_columns = ['inscription','participation'];
	if (!in_array($action, $valid_columns)) {
        die("Problème au niveau des boutons radio.");
    } 
    if ($action == 'inscription'){
    	$query = "INSERT INTO Inscrire VALUES (?, ?)";
		$stmt = mysqli_prepare($db, $query);
		mysqli_stmt_bind_param($stmt, "si",$username, $id_eve);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_affected_rows($stmt);
		if($result != 1){
			die("Erreur lors de l'insertion dans la base de données");
		}
    }else{
    	$query = "INSERT INTO Participer VALUES (?, ?)";
		$stmt = mysqli_prepare($db, $query);
		mysqli_stmt_bind_param($stmt, "si",$username, $id_eve);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_affected_rows($stmt);
		if($result != 1){
			die("Erreur lors de l'insertion dans la base de données");
		}
    }
}else{
	$query = "INSERT INTO Inscrire VALUES (?, ?)";
	$stmt = mysqli_prepare($db, $query);
	mysqli_stmt_bind_param($stmt, "si",$username, $id_eve);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_affected_rows($stmt);
	if($result != 1){
		die("Erreur lors de l'insertion dans la base de données");
	}
}
header("location:./index.php");
?>