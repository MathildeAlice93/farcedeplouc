<html>
<head>
	<title>Mon journal de plouc</title>
	<!-- <LINK rel = stylesheet href = "style.css"/> -->
	<meta charset = "utf8"/>
	<meta name = "author" content = "Mathilde Alice Stiernet"/>
</head>
<body>
<?php
//Ici on devra faire appel à une classe non statique 'Personne' 
echo "Coucou " . $plouc_connecte->getPrenom(); 
?></br>
	<table>
	<?php
		$_SESSION["mes_infos"] = FarceDePloucDbUtilities::getInfos($plouc_connecte->getId());
		echo $_SESSION["mes_infos"][0]["nom"] . "</br>";
		echo $_SESSION["mes_infos"][0]["prenom"] . "</br>";
		echo $_SESSION["mes_infos"][0]["pseudo"] . "</br>";
		echo $_SESSION["mes_infos"][0]["date_anniversaire"] . "</br>";
	?>
	</table>
	<select name="potes_du_plouc" size="1">
	<?php
			$affichage_potes = FarceDePloucDbUtilities::getPotes($plouc_connecte->getId(),7);
			
			//Ici on utilise "::" car on fait un appel de classe statique cad qu'on a une seule et unique instance 
			foreach($affichage_potes as $pote){
				$truc=$pote['pseudo'];
				echo "<option value='$truc'>$truc</option>"; 
			}
	?>
	</select>
	<form method="POST">
		<label for="recherche">Ma recherche: </label>
		<input type="text" name="recherche" placeholder="Qui veux-tu trouver?"/> 
		<input type = "submit" name = "search_people" formaction = "router.php?handler=Session&action_du_plouc=recherche" value = "Lancer la recherche !" />
	</form>

</body>
</html> 