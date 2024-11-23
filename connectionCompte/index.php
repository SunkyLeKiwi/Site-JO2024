<?php
session_start();
require_once("./../connection.php");
if (isset($_SESSION['erreur'])){
	if ($_SESSION['erreur'] == 1){
		echo "<script>alert('Cet identifiant n\'existe pas. Veuillez vérifier les informations rentrées.')</script>";
		$_SESSION['erreur'] = 0;
	}else if ($_SESSION['erreur'] == 2){
		echo"<script>alert('Mot de passe incorrect. Veuillez vérifier les informations rentrées.')</script>";
		$_SESSION['erreur'] = 0;
	}else if ($_SESSION['erreur'] == 5){
		echo"<script>alert('Votre compte a bien été créé.')</script>";
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
	<link rel="stylesheet" type="text/css" href="./../css/compte.css">
	<link rel="stylesheet" type="text/css" href="./../css/footer.css">

	
	<script type="text/javascript" src="./../js/script.js" defer></script>

	<title>Compte</title>
</head>
<body>
	<?php

		require_once("./../header.php");
		require_once("./../gestion_compte.php");

	?>

	<main>
		<img src="./../assets/jo_cercle.jpg" class="cercles">

		<form class="connection" method="post" action="./../gestion_connection.php">
			<h1>Connexion</h1>
			<?php
			if(!isset($_SESSION['username'])) { ?>
				<label for="identifiant">Identifiant</label>
				<input required type="text" name="identifiant" class="pseudo">

				<label for="mdp">Mot De Passe</label>
				<input required type="password" name="mdp" class="password">

				<a href="https://dwarves.iut-fbleau.fr/~aureau/SAe_2.2_Web/creationCompte/">Creer un compte</a>

				<button type="submit" class="se-connecter">Valider</button>
			<?php }
			else { ?>
				<a href="https://dwarves.iut-fbleau.fr/~aureau/SAe_2.2_Web/creationCompte/" >Creer un compte</a>
				<button type="submit" class="se-deconnecter">Se déconnecter</button>
			<?php } ?>
		</form>
	</main>
	<?php
		require_once("./../footer.php");
	?>
</body>
</html>