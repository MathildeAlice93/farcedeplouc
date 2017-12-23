<html>
<head>
	<title>Mon journal de plouc</title>
	<!-- <LINK rel = stylesheet href = "style.css"/> -->
	<meta charset = "utf8"/>
	<meta name = "author" content = "Mathilde Alice Stiernet"/>
</head>
<body>
coucou toi ! 
	
		
			<?php
				$affichage_potes = FarceDePloucDbUtilities::get_potes($plouc_connecte->getId(),1);
				foreach($affichage_potes as $pote){
					echo $pote['pseudo']; 
				}
			?>
		<form>
		<select name="potes_du_plouc" size="1">
		</select>
	</form>

</body>
</html>