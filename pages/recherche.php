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
		<table>		
			<?php
				foreach($affichage_personne as $personne){
					echo '<tr>';
					echo "<td>".$personne['pseudo']."</td>";
					echo "<td>".$personne['prenom']."</td>";
					echo "<td>".$personne['nom']."</td>";
					$test_amitie = FarceDePloucDbUtilities::verifyExistingRelationship($plouc_connecte->getId(), $personne['id']);			
					if ($test_amitie){
						echo "<td> <input type='submit' name='tralala[]' value = '".$personne['id']."' formaction='router.php?handler=Session&action_du_plouc=ajouter_un_pote'/> </td>";				
					}
				}
				echo '</tr>';
			?>
		</table>
	</form>


	<!--<input type = "submit" name = "submit" formaction = "router.php?handler=Session&action_du_plouc=zonmai" value = "Retour au journal" />-->

</body>
</html> 