<?php 

	/* Initialization and/or plouc_connectee recovery */
	if(session_status() == PHP_SESSION_NONE)
	{
		session_start(); 
		/*la fonction session_start donne la possiblité d'appeler la variable PHP $_SESSION*/
	}
	if(isset($_SESSION['plouc_connecte'])) 
	/*Est-ce que la variable de session plouc_connecte existe et contient des données*/
	{
		$plouc_connecte = unserialize($_SESSION['plouc_connecte']);
		/*récupération du contenu de la variable plouc_connecte sous forme de string, introduit dans l'ojet $plouc_connecte*/
	}
	else
	{
		$plouc_connecte = new personne; 

		/*création de l'objet personne, mis dans la variable $plouc_connecte*/
		$_SESSION['plouc_connecte'] = serialize($plouc_connecte); 
		/*remise des infos séréalisées dans la variable PHP $_SESSION*/
		/*$_SESSION a une durée de vie plus grande que $plouc_connecte car il s'agit d'une variable PHP et donc globale*/
		/*$_SESSION, durée de vie déterminée par le programmeur, par défaut elle sera infinie*/
		/*$plouc_connecte, durée de vie uniquement entre les balises PHP de ce document*/
	}

	/* View handling */
	$action_du_plouc = "";
	if(isset($_GET['action_du_plouc']))
	{
		$action_du_plouc = $_GET['action_du_plouc'];
	}
	switch ($action_du_plouc) {
		case 'connexion':
			$tentative_valide = 0b0;
			/*0b0 est un nombre entier écrit sous forme binaire, dans ce cas-ci le nombre entier représenté est zéro.*/
			if(isset($_POST['connect_email']) and !empty($_POST['connect_email']))
			{
				$tentative_valide += 0b1;
			}
			if(isset($_POST['connect_mot_de_passe']) and !empty($_POST['connect_mot_de_passe']))
			{
				$tentative_valide += 0b10;
			}
			if($tentative_valide == 0b11) 
			{
				FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
				$valid_user = FarceDePloucDbUtilities::isValidPerson($_POST['connect_email'], $_POST['connect_mot_de_passe']);
				if($valid_user != false)
				{
					//boucle de principe, on est certain que valid_user ne contient qu'un seul élément
					foreach($valid_user as $row)
					{
						$plouc_connecte->setId($row['id']);
						$plouc_connecte->setNom($row['nom']);
						$plouc_connecte->setPrenom($row['prenom']);
						$plouc_connecte->setPseudo($row['pseudo']); 
						$plouc_connecte->setDate_anniversaire($row['date_anniversaire']);
						$plouc_connecte->setDate_inscription($row['date_inscription']);
						$plouc_connecte->setCourriel($row['courriel']); 
						$plouc_connecte->setMot_de_passe($row['mot_de_passe']);
					}

					$affichage_potes = FarceDePloucDbUtilities::getPotes($plouc_connecte->getId(),7);
					//Ici on utilise "::" car on fait un appel de classe statique cad qu'on a une seule et unique instance

					include_once "pages/journal.php";
				}
				else
				{
					//erreur (personne pas dans base de donnnées) (plus tard)
					include_once "pages/connexion.php";
				}
			}
			else
			{
				//traiter l'erreur plus tard (champs invalides)
				include_once "pages/connexion.php";
			}
			break;
		case 'zonmai':
			FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
			$affichage_potes = FarceDePloucDbUtilities::getPotes($plouc_connecte->getId(),7);
			// ces deux appels de fonctions vont te permettre de récolter les données personnels dont tu auras besoin lors de l'affichage
			// remarque : l'affichage se passe directement dans la page 'journal'
			include_once "pages/journal.php";
			break;
		case 'recherche':
			if(isset($_POST['recherche']) and !empty($_POST['recherche']))
			{
				$ma_recherche = $_POST['recherche'];
				FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
				$affichage_personne = FarceDePloucDbUtilities::searchPeople($ma_recherche);
				include_once "pages/recherche.php";
			}
			else 
			{
				//erreur pas de recherche faite (plus tard)
				include_once "pages/journal.php";
			}
			break;
		case 'ajouter_un_pote':
			if(isset($_POST['nouveaux_potes']) and !empty($_POST['nouveaux_potes']))
			{
				$mon_nouveau_pote = $_POST['nouveaux_potes'];
				FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
				$id_demandeur=$plouc_connecte->getId();
				FarceDePloucDbUtilities::addJoint_personne($id_demandeur, $mon_nouveau_pote, "confirme");
				include_once "pages/recherche.php";
			}
			else 
			{
				//erreur pas de recherche faite (plus tard)
				include_once "pages/journal.php";
			}
			break;
		default:
			/* ici on sera déconnecté en cas d'action erronée (que le site ne prévoit pas) pour éviter toute possibilité de risque */
			session_destroy();
			include_once "pages/connexion.php";
			break;
	}

	/* Save object plouc_connecte in session */
	if(isset($_SESSION['plouc_connecte'])) 
	/*Est-ce que la variable de session plouc_connecte existe et contient des données*/
	{
		$_SESSION['plouc_connecte'] = serialize($plouc_connecte);
	}
?>

