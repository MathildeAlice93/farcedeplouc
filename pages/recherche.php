<html>
<head>
	<title>Ma recherche de ploucs</title>
	<!-- <LINK rel = stylesheet href = "style.css"/> -->
	<meta charset = "utf8"/>
	<meta name = "author" content = "Mathilde Alice Stiernet"/>
</head>
<body>

	<form method="POST">
		<label for="recherche">Ma recherche: </label>
		<input type="text" name="recherche" placeholder="Qui veux-tu trouver?"/> 
		<input type = "submit" name = "search_people_2" formaction = "router.php?handler=Session&action_du_plouc=recherche" value = "Lancer la recherche !" />
	</form>
	<select name="recherche_personne" size="1">
	<?php
		$affichage_personne = FarceDePloucDbUtilities::searchPeople($ma_recherche);
		foreach($affichage_personne as $personne){
			$truc=$personne['pseudo'];
			echo "<option value='$truc'>$truc</option>"; 
		}
	?>
	</select>


	<!--<input type = "submit" name = "submit" formaction = "router.php?handler=Session&action_du_plouc=zonmai" value = "Retour au journal" />-->

</body>
</html> 