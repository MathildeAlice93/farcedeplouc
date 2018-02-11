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
	<form method="POST">
		<select name="nouveaux_potes">
		<?php
			foreach($affichage_personne as $personne){
				$truc=$personne['pseudo'];
				$truc_id = $personne['id'];
				echo "<option value='$truc_id'>$truc</option>"; 
			}
		?>
		</select>
		<input type="submit" name="add_friend" formaction="router.php?handler=Session&action_du_plouc=ajouter_un_pote" value="J'ajoute mon pote!"/>
	</form>


	<!--<input type = "submit" name = "submit" formaction = "router.php?handler=Session&action_du_plouc=zonmai" value = "Retour au journal" />-->

</body>
</html> 