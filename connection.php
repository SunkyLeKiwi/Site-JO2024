<?php
$db=mysqli_connect("dwarves.iut-fbleau.fr","aureau","mdp","aureau");
if (!$db){
	echo "Vous n'êtes pas connecté : échec";
}
