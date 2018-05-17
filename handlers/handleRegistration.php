	<?php 
	
		/*Création de l'objet personne*/

		$personne = new Personne;

		$erreurs = []; 


		/*Gestion des vues*/

		if(isset($_POST['nom']) and !empty($_POST['nom']))
		{
			$personne->setNom($_POST['nom']);
		}
		else{
			$erreurs['1']='nom';
		}
		if(isset($_POST['prenom']) and !empty($_POST['prenom']))
		{
			$personne->setPrenom($_POST['prenom']);
		}
		else{
			$erreurs['2']='prenom';
		}
		if(isset($_POST['pseudo']) and !empty($_POST['pseudo']))
		{
			$personne->setPseudo($_POST['pseudo']);
		}
		else{
			$erreurs['3']='pseudo';
		}
		if(isset($_POST['jour']) and !empty($_POST['jour']) and isset($_POST['mois']) and !empty($_POST['mois']) and isset($_POST['annee']) and !empty($_POST['annee']))
		{
			$date_annif = $_POST['annee']."-".$_POST['mois']."-".$_POST['jour'];
			$personne->setDate_anniversaire($date_annif);
		}
		else{
			$erreurs['4']='jour';
			#il y a un problème ici
		}
		if(isset($_POST['courriel']) and !empty($_POST['courriel']) and isset($_POST['courriel_bis']) and !empty($_POST['courriel_bis']))
		{
			if($_POST['courriel']==$_POST['courriel_bis']){
				$personne->setCourriel($_POST['courriel']); 
			}
			else{
				$erreurs['5']='courriel_bis';
			}
		}
		else{
			$erreurs['6']='courriel'; 
			$erreurs['5']='courriel_bis'; 
			#erreur : on teste les deux en même temps donc on sait pas précisemnt lequel des deux n'était pas rempli
		}
		if(isset($_POST['mot_de_passe']) and !empty($_POST['mot_de_passe']))
		{
			$personne->setMot_de_passe($_POST['mot_de_passe']);
		}
		else{
			$erreurs['7']='mot_de_passe'; 
		}
		/*Connexion à la base de données*/
		if(empty($erreurs))
		{
			FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
			/*Dans la classe modelDatabase tu appelles la fonction connectPdodb*/
			/*Le mode d'emploi de connectPdodb ets dans modelDatabase mnt tu l'appelle en lui donnant les arguments que tu as défini dans router.php pour te connecter à la bdd.*/
			
			FarceDePloucDbUtilities::addPersonne($personne->getNom(), $personne->getPrenom(), $personne->getPseudo(), $personne->getDate_anniversaire(), $personne->getCourriel(), $personne->getMot_de_passe());
	
			include_once "pages/connexion.php";
		}else{
			include_once "pages/connexion.php";
			foreach($erreurs as $erreur){
				echo "<script> erreur('".$erreur."'); </script>";
				/* $erreur est une variable php qui contient un string (en php)
				la ligne de code est du javascript, donc il faut qu'il comprenne que ce qu'il y a dans erreur
				est un string (compatibilité entre javascript et php =/= 100%)
				solution :
				remettre des apostrophes autour du contenu de la variable pour faire comprendre a javascript qu'il s'agit d'un
				string.
				(les guillemets servent pour le echo et disparaitront une fois cette ligne exécutée, seuls les apostrophes restent) */
			}
		}
	?>