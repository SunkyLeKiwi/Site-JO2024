<?php
require_once("connection.php");
session_start();
if(isset($_SESSION['username'])){
	session_destroy();
	header("location:connectionCompte");
}

$identifiant = mysqli_real_escape_string($db, htmlspecialchars($_POST['identifiant'], ENT_QUOTES, 'UTF-8'));
$motdepasse = mysqli_real_escape_string($db, htmlspecialchars($_POST['mdp'], ENT_QUOTES, 'UTF-8'));

$query = "SELECT identifiant,mdp,numTel,adresseMail,type FROM Compte WHERE identifiant=?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "s", $identifiant);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if(!$result){
	die("Erreur lors de la recherche dans la base de données");
} else {
	if(mysqli_num_rows($result)==0){
		$_SESSION['erreur'] = 1;
		header("location:connectionCompte");
	}else{
		while($data_utilisateur = mysqli_fetch_assoc($result)){
			if (!password_verify($motdepasse, $data_utilisateur['mdp'])){
				$_SESSION['erreur'] = 2;
				header("location:connectionCompte");
			}else{
				$_SESSION['erreur'] = 4;
				$_SESSION['username'] = $identifiant;
				$_SESSION['type'] = $data_utilisateur['type'];
				if($data_utilisateur['numTel']!=null){
					$_SESSION['tel']= $data_utilisateur['numTel'];
				}
				if($data_utilisateur['adresseMail']!=null){
					$_SESSION['email']= $data_utilisateur['adresseMail'];
				}
				header("location:evenements");			
			}
		}
	}
}
?>