<html>
<head>
	<title>Ma recherche de ploucs</title>
	<!-- <LINK rel = stylesheet href = "style.css"/> -->
	<meta charset = "utf8"/>
	<meta name = "author" content = "Mathilde Alice Stiernet"/>
</head>
<body>
	<form method='POST'>
		<button type="submit" formaction = "router.php?handler=Session&action_du_plouc=default">Déconnexion</button>
	</form>

	<form method='POST'>
		<button type="submit" formaction = "router.php?handler=Session&action_du_plouc=zonmai">Retour</button>
	</form>

	<form method="POST">
		<label for="recherche">Ma recherche: </label>
		<input type="text" name="recherche" placeholder="Qui veux-tu trouver?"/> 
		<input type = "submit" name = "search_people_2" formaction = "router.php?handler=Session&action_du_plouc=recherche" value = "Lancer la recherche !" />
	</form>


	<form method="POST">
		<table>		
			<?php
				foreach($affichage_personne as $personne){
					echo '<tr>';
					echo "<td>".$personne['pseudo']."</td>";
					echo "<td>".$personne['prenom']."</td>";
					echo "<td>".$personne['nom']."</td>";
					$test_amitie = FarceDePloucDbUtilities::verifyExistingRelationship($plouc_connecte->getId(), $personne['id'])=='confirme';			
					if (!$test_amitie){
						echo "<form method='POST'>";
						echo "<td> <button type='submit' name='tralala' value = '".$personne['id']."' formaction='router.php?handler=Session&action_du_plouc=ajouter_un_pote'>Ajouter un ami!</button> </td>";	
						/* Pour distinguer les différents buttons qui apparaissent sur la page, tralala est une liste qui contient autant d'éléments qu'il n'y a de boutons sur la page */
						echo "</form>";			
					}
					else{
						echo "<form method='POST'>";
						echo "<td> <button type='submit' name='tralala' value = '".$personne['id']."' formaction='router.php?handler=Session&action_du_plouc=messenger'>Causer ac mon pote!</button> </td>";	
						/*Pas nécessaire de changer le nom tralala en autre chose vu que de toute façon si j'affiche un des deux boutons l'autre ne sera pas affiché !*/
						echo "</form>";	
					}
					echo '</tr>';
				}
			?>
		</table>
	</form>


	<!--<input type = "submit" name = "submit" formaction = "router.php?handler=Session&action_du_plouc=zonmai" value = "Retour au journal" />-->

</body>
</html> 