<header>
 	<nav>
 		<img class="logo" src="https://dwarves.iut-fbleau.fr/~aureau/SAe_2.2_Web/assets/jo_Logo.png">
 		<div class="lien">
 			
 			<a href="https://dwarves.iut-fbleau.fr/~aureau/SAe_2.2_Web/"><h1>Accueil</h1></a>
 			<?php
 				if(isset($_SESSION['username'])){
 					echo '<a href="https://dwarves.iut-fbleau.fr/~aureau/SAe_2.2_Web/evenements"><h1>évènements</h1></a>';
 					if ($_SESSION['type'] == 'Organisateur'){
                    	echo '<a href="https://dwarves.iut-fbleau.fr/~aureau/SAe_2.2_Web/evenements/creer_evenement.php"><h1>Créer un évènement</h1></a>';
            		}
 				}
 
 			?>
	 		<a href="https://dwarves.iut-fbleau.fr/~aureau/SAe_2.2_Web/connectionCompte"><h1>Connexion</h1></a>


 		</div>
 		
 	</nav>

 	<div class="connexion">
 		<?php
 			if(isset($_SESSION['username'])){
 				$pseudo = $_SESSION['username'];
 				echo "<h2>$pseudo</h2>";
 			}
 		?>
 		<img class="account" src="https://dwarves.iut-fbleau.fr/~aureau/SAe_2.2_Web/assets/account.png">
 	</div>
 	
 	<div class="menu">
 			
		<a href="https://dwarves.iut-fbleau.fr/~aureau/SAe_2.2_Web/"><h1>Accueil</h1></a>
		<?php
 			if(isset($_SESSION['username'])){
 				echo '<a href="https://dwarves.iut-fbleau.fr/~aureau/SAe_2.2_Web/evenements"><h1>évènements</h1></a>';
 				if ($_SESSION['type'] == 'Organisateur'){
                    echo '<a href="https://dwarves.iut-fbleau.fr/~aureau/SAe_2.2_Web/evenements/creer_evenement.php"><h1>Créer un évènement</h1></a>';
            	}
 			}
 		?>
 		<a href="https://dwarves.iut-fbleau.fr/~aureau/SAe_2.2_Web/connectionCompte"><h1>Connexion</h1></a>

 	</div>

 </header>