<html>
<head>
	<title>Connexion</title>
	<!-- <LINK rel = stylesheet href = "style.css"/> -->
	<meta charset = "utf8"/>
	<meta name = "author" content = "Mathilde Alice Stiernet"/>
</head>
<body>
	<form method="POST" action="router.php">
			<table>
				<tr>
					<td>Nom : </td>
					<td>
						<input type = "text" name = 'nom' id = 'nom'/>
					</td>
				</tr>
				<tr>
					<td>Prénom : </td>
					<td>
						<input type = "text" name = 'prenom' id = 'prenom'/>
					</td>
				</tr>
				<tr>
					<td>Pseudo : </td>
					<td>
						<input type = "text" name = 'pseudo' id = 'pseudo'/>
					</td>
				</tr>
				<tr>
					<td>Date d'anniversaire : </td>
					<td>
						<input type = "text" name = 'date_anniversaire' id = 'date_anniversaire'/>
					</td>
				</tr>
				<tr> 
					<td>Courriel : </td>
					<td>
						<input type = "text" name = 'courriel' id = 'courriel'/>
					</td>
				</tr>
				<tr>
					<td>Mot de passe top secret : </td>
					<td>
						<input type = "text" name = 'mot_de_passe' id = 'mot_de_passe'/>
					</td>
				</tr>
			</table>
		<input type = "submit" name = "submit" formaction = "router.php?handler=Registration" value = "Je rejoins le klan des ploucs" />

	</form>
	<form method="POST" action="router.php">
			<table>
				<tr>
					<td>Email </td>
					<td>
						<input type = "text" name = 'connect_email' id = 'connect_email'/>
					</td>
				</tr>
				<tr>
					<td>Mot de passe </td>
					<td>
						<input type = "text" name = 'connect_mot_de_passe' id = 'connect_mot_de_passe'/>
					</td>
				</tr>
			</table>
		<input type = "submit" name = "submit" formaction = "router.php?handler=Session&action_du_plouc=connexion" value = "Le klan des ploucs me manque !" />

	</form>
</body>
</html>