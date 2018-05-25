<html>
<head>
	<title>Mon journal de plouc</title>
	<!-- <LINK rel = stylesheet href = "style.css"/> -->
	<meta charset = "utf8"/>
	<meta name = "author" content = "Mathilde Alice Stiernet"/>
</head>
<body>
	<form method='POST'>
		<button type="submit" formaction = "router.php?handler=Session&action_du_plouc=default">Déconnexion</button>
	</form>
	<form method='POST'>
		<button type="submit" formaction = "router.php?handler=Session&action_du_plouc=messenger">Messenger</button>
	</form>
	
	<?php
	//Ici on devra faire appel à une classe non statique 'Personne' 
	echo "Coucou " . $plouc_connecte->getPrenom(); 
	?></br>
	<table>
	<?php
		echo $plouc_connecte->getNom() . "</br>";
		echo $plouc_connecte->getPrenom() . "</br>";
		echo $plouc_connecte->getPseudo() . "</br>";
		echo $plouc_connecte->getDate_anniversaire() . "</br>";

	?>
	</table>
	<?php 
		echo "Liste des potes : "; 
	?>
	<select name="potes_du_plouc" size="1">
	<?php
			$affichage_potes = FarceDePloucDbUtilities::getPotes($plouc_connecte->getId(),'confirme',7);
			//Ici on utilise "::" car on fait un appel de classe statique cad qu'on a une seule et unique instance
			foreach($affichage_potes as $pote){
				$truc=$pote['pseudo'];
				echo "<option value='$truc'>$truc</option>"; 
			}
	?>
	</select>
	<form method="POST">
		<label for="recherche">Ma recherche de personne: </label>
		<input type="text" name="recherche" placeholder="Qui veux-tu trouver?"/> 
		<input type = "submit" name = "search_people" formaction = "router.php?handler=Session&action_du_plouc=recherche" value = "Lancer la recherche !" />
	</form>

	<?php 
		echo "Amis en attente : "; 
			$affichage_potes = FarceDePloucDbUtilities::getPotes($plouc_connecte->getId(),'en_attente',7);
			//Ici on utilise "::" car on fait un appel de classe statique cad qu'on a une seule et unique instance
			$key=0;
			foreach($affichage_potes as $pote){
				echo "<form method='POST' action ='router.php?handler=Session&action_du_plouc=accepter_refuser'>";
				$truc=$pote['pseudo'];
				$id_valeur=$pote['id'];
				echo "<li>$truc <button type='submit' name='accepter_pote_".$key."'>Accepter</button><button type='submit' name='refuser_pote_".$key."'>Refuser</button></li>";
				//probleme de cette solution session contient les id a partir des numero de ligne, on ne sait pas quelle ligne a été choisie par l'utilisateur
				$keyString = 'key'.$key;
				$_SESSION[$keyString]=$id_valeur;
				echo "</form>"; 
				$key++;
			}
			$_SESSION['compteur']=$key;
	?>
</body>
</html> 