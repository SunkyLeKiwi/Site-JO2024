<?php
session_start();
if (isset($_SESSION['erreur'])){
	if ($_SESSION['erreur'] == 3){
			echo"<script>alert('Cet identifiant est déjà utilisé (ce compte existe déjà). Veuillez réessayer avec un autre identifiant.')</script>";
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



		<form class="creer-compte" method="post" action="./../gestion_creation.php">
			<h1>Créer un compte</h1>

			<label for="identifiant">Identifiant</label>
			<input required type="text" name="identifiant" class="pseudo">

			<label for="mdp">Mot De Passe</label>
			<input required type="password" name="mdp" class="password">

			<label for="role">Rôle</label>
			<select name="role" class="roles">
				<option value="Spectateur">Spectateur</option>
				<option value="Sportif">Sportif</option>
				<option value="Organisateur">Organisateur</option>
				
			</select>

			<button type="submit" class="creer-compte">Valider</button>
		</form>



		
	</main>
</body>
</html>