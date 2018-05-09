	<?php 
	
		/*Création de l'objet personne*/

		$personne = new Personne;


		/*Gestion des vues*/

		if(isset($_POST['nom']) and !empty($_POST['nom']))
		{
			$personne->setNom($_POST['nom']);
		}
		if(isset($_POST['prenom']) and !empty($_POST['prenom']))
		{
			$personne->setPrenom($_POST['prenom']);
		}
		if(isset($_POST['pseudo']) and !empty($_POST['pseudo']))
		{
			$personne->setPseudo($_POST['pseudo']);
		}
		if(isset($_POST['jour']) and !empty($_POST['jour']) and isset($_POST['mois']) and !empty($_POST['mois']) and isset($_POST['annee']) and !empty($_POST['annee']))
		{
			$date_annif = $_POST['annee']."-".$_POST['mois']."-".$_POST['jour'];
			$personne->setDate_anniversaire($date_annif);
		}
		if(isset($_POST['courriel']) and !empty($_POST['courriel']) and isset($_POST['courriel_bis']) and !empty($_POST['courriel_bis']))
		{
			if($_POST['courriel']==$_POST['courriel_bis']){
				$personne->setCourriel($_POST['courriel']); 
			}
			else{
				echo "<script> erreurMail(); </script>";
			}
		}
		if(isset($_POST['mot_de_passe']) and !empty($_POST['mot_de_passe']))
		{
			$personne->setMot_de_passe($_POST['mot_de_passe']);
		}

		/*Connexion à la base de données*/

		FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
		/*Dans la classe modelDatabase tu appelles la fonction connectPdodb*/
		/*Le mode d'emploi de connectPdodb ets dans modelDatabase mnt tu l'appelle en lui donnant les arguments que tu as défini dans router.php pour te connecter à la bdd.*/
		
		FarceDePloucDbUtilities::addPersonne($personne->getNom(), $personne->getPrenom(), $personne->getPseudo(), $personne->getDate_anniversaire(), $personne->getCourriel(), $personne->getMot_de_passe());

		include_once "pages/connexion.php";
	?>

