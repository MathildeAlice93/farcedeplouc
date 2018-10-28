<?php

/* Initialization and/or plouc_connectee recovery */
if (session_status() == PHP_SESSION_NONE) {
	session_start();
	/*la fonction session_start donne la possiblité d'appeler la variable PHP $_SESSION*/
}
if (isset($_SESSION['plouc_connecte'])) {
	/*Est-ce que la variable de session plouc_connecte existe et contient des données*/
	$plouc_connecte = unserialize($_SESSION['plouc_connecte']);
	/*récupération du contenu de la variable plouc_connecte sous forme de string, introduit dans l'ojet $plouc_connecte*/
} else {
	$plouc_connecte = new Personne;

	/*création de l'objet personne, mis dans la variable $plouc_connecte*/
	$_SESSION['plouc_connecte'] = serialize($plouc_connecte);
	/*remise des infos séréalisées dans la variable PHP $_SESSION*/
	/*$_SESSION a une durée de vie plus grande que $plouc_connecte car il s'agit d'une variable PHP et donc globale*/
	/*$_SESSION, durée de vie déterminée par le programmeur, par défaut elle sera infinie*/
	/*$plouc_connecte, durée de vie uniquement entre les balises PHP de ce document*/
}

/* View handling */
$action_du_plouc = "";
if (isset($_GET['action_du_plouc'])) {
	$action_du_plouc = $_GET['action_du_plouc'];
}
switch ($action_du_plouc) {
	case 'connexion':
		$tentative_valide = 0b0;
		/*0b0 est un nombre entier écrit sous forme binaire, dans ce cas-ci le nombre entier représenté est zéro.*/
		if (isset($_POST['connect_email']) and !empty($_POST['connect_email'])) {
			$tentative_valide += 0b1;
		}
		if (isset($_POST['connect_mot_de_passe']) and !empty($_POST['connect_mot_de_passe'])) {
			$tentative_valide += 0b10;
		}
		if ($tentative_valide == 0b11) {
			FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
			$valid_user = FarceDePloucDbUtilities::isValidPerson($_POST['connect_email'], $_POST['connect_mot_de_passe']);
			if ($valid_user != false) {
				//boucle de principe, on est certain que valid_user ne contient qu'un seul élément
				foreach ($valid_user as $row) {
					$plouc_connecte->setId($row['id']);
					$plouc_connecte->setNom($row['nom']);
					$plouc_connecte->setPrenom($row['prenom']);
					$plouc_connecte->setPseudo($row['pseudo']);
					$plouc_connecte->setDate_anniversaire($row['date_anniversaire']);
					$plouc_connecte->setDate_inscription($row['date_inscription']);
					$plouc_connecte->setCourriel($row['courriel']);
					$plouc_connecte->setMot_de_passe($row['mot_de_passe']);
				}
				echo "<script>
					window.onload = function() {
						history.replaceState('', '', 'router.php?handler=Session&action_du_plouc=connexion');
					}
					</script>";

				include_once "pages/journal.php";
			} else {
				//erreur (personne pas dans base de donnnées) (plus tard)
				include_once "pages/connexion.php";
			}
		} else if($plouc_connecte->getId() != "") {
			include_once "pages/journal.php";
		} else {
			//traiter l'erreur plus tard (champs invalides)
			include_once "pages/connexion.php";
		}
		break;
	case 'zonmai':
		FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
		// ces deux appels de fonctions vont te permettre de récolter les données personnels dont tu auras besoin lors de l'affichage
		// remarque : l'affichage se passe directement dans la page 'journal'
		if (isset($_SESSION['current_conversation'])) {
			$_SESSION['current_conversation'] = null;
		}
		include_once "pages/journal.php";
		break;
	case 'recherche':
		if (isset($_POST['recherche']) and !empty($_POST['recherche'])) {
			$ma_recherche = $_POST['recherche'];
			FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
			$affichage_personne = FarceDePloucDbUtilities::searchPeople($ma_recherche, $plouc_connecte->getId());
			include_once "pages/recherche.php";
		} else {
			//erreur pas de recherche faite (plus tard)
			include_once "pages/journal.php";
		}
		break;
	case 'ajouter_un_pote':
		if (isset($_POST['tralala']) and $_POST['tralala']!="") {
			$keyString='key'.$_POST['tralala'];
			$mon_nouveau_pote = $_SESSION[$keyString];
			FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
			$id_demandeur = $plouc_connecte->getId();
			FarceDePloucDbUtilities::addJoint_personne($id_demandeur, $mon_nouveau_pote, "en_attente");
			include_once "pages/journal.php";
		} else {
			//erreur pas de recherche faite (plus tard)
			include_once "pages/journal.php";
		}
		break;
	case 'accepter_refuser':
		if (isset($_POST['accepter_pote'])) {
			$keyString = 'key' . $_POST['accepter_pote'];
			$recupere = $_SESSION[$keyString];
			FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
			$id_receveur = $plouc_connecte->getId();
			FarceDePloucDbUtilities::updateJoint_personne($id_receveur, $recupere, 'confirme');
			include_once "pages/journal.php";
		} elseif (isset($_POST['refuser_pote'])) {
			$keyString = 'key' . $_POST['refuser_pote'];
			$recupere = $_SESSION[$keyString];
			FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
			$id_receveur = $plouc_connecte->getId();
			FarceDePloucDbUtilities::updateJoint_personne($id_receveur, $recupere, 'refuse');
			include_once "pages/journal.php";
			//cas ou on n'a rien trouve (aucun bouton cliqué = bug)
			//traiter le cas du bouton refuser
			//probleme : debugger fonctionne pas
			//erreur affichee lors du chargement de la page (potentiellement $_SESSION qui refuse d'etre modifie)=> convertir $key en string avant de le mettre dans $_session

			//resolution : une clef de $_SESSION ne peut pas commencer par un chiffre (ajout du prefixe key)

			//meilleure solution : value du button peut stocker la clé, ce qui évite de devoir utiliser une boucle lors de la récupération

			//dernier probleme a resoudre : ne pas afficher les demandes en attente dont on est l'initiateur(car accepter ou refuser ne fera rien dans ces cas)
		} else {
			//erreur pas de recherche faite (plus tard)
			include_once "pages/journal.php";
		}
		break;
	case 'create_conversation':
		FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
		// ces deux appels de fonctions vont te permettre de récolter les données personnels dont tu auras besoin lors de l'affichage
		// remarque : l'affichage se passe directement dans la page 'journal'
		$nouveau_pote_convers = $_POST['tralala'];
		$mon_id = $plouc_connecte->getId();
		$liste_id_personnes = [];
		$liste_id_personnes[] = $mon_id;
		$liste_id_personnes[] = $nouveau_pote_convers;
		echo FarceDePloucDbUtilities::createConversationWith(0, $liste_id_personnes);
		break;
	case 'messenger':
		FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
		//liste toutes les conversations en cours
		$affichage_conversations = FarceDePloucDbUtilities::getConversations($plouc_connecte->getId());
		//affiche les messages de la conversation sélectionnée
		if (isset($_SESSION['current_conversation'])) {
			$current_conversation = unserialize($_SESSION['current_conversation']);
		} elseif (isset($_POST['tralala'])){
			$keyString='key'.$_POST['tralala'];
			$current_conversation = new Conversation;
			/*ceci est une nouvelle conversation créée au niveau de php mais pas au niveau de la base de données*/
			$membres = [];
			$membres[] = $plouc_connecte;
			$mon_pote = FarceDePloucDbUtilities::getPersonne($_SESSION[$keyString]);
			$plouc_avec_qui_parler = new Personne($id = $mon_pote[0]['id'], $nom = $mon_pote[0]['nom'], $prenom = $mon_pote[0]['prenom'], $pseudo = $mon_pote[0]['pseudo']);
			$membres[] = $plouc_avec_qui_parler;
			$current_conversation->setMembres($membres);
			/*ajout de membres à la conversation au niveau php*/
			$fetched_id_conversation = FarceDePloucDbUtilities::existeConversationPrive($membres[0]->getId(), $membres[1]->getId());
			if (!empty($fetched_id_conversation[0])) {
				$current_conversation->setId($fetched_id_conversation[0]["id_conversation"]);
				/* une conversation existe deja il faut l'afficher */
				$current_conversation->setMessages(FarceDePloucDbUtilities::getAllMessagesFromConversation($current_conversation->getId()));
				/*pas oublier de set le nom de la conversation */
			} else {
				/* on cree une nouvelle conversation (aucun message deja ecrit) */
				$liste_id_personnes = [];
				$liste_id_personnes[] = $membres[0]->getId();
				$liste_id_personnes[] = $membres[1]->getId();
				$current_conversation->setId(FarceDePloucDbUtilities::createConversationWith(0, $liste_id_personnes));
			}
			$_SESSION['current_conversation'] = serialize($current_conversation);
		}

		include_once "pages/messenger.php";
		break;
	case 'poster_un_message':
		FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
		$current_conversation = unserialize($_SESSION['current_conversation']);
		$affichage_conversations = FarceDePloucDbUtilities::getConversations($plouc_connecte->getId());
		$contenu_post = $_POST['nouveau_message'];
		FarceDePloucDbUtilities::postMessage($plouc_connecte->getId(), $current_conversation->getId(), $contenu_post);
		$current_conversation->setMessages(FarceDePloucDbUtilities::getAllMessagesFromConversation($current_conversation->getId()));
		include_once "pages/messenger.php";
		break;
	case 'switch_conversation':
		FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
		//incomplet (manque les membres)
		$current_conversation = new Conversation;
		$id_conversation = $_POST['tralala'];
		$current_conversation->setId($id_conversation);
		/* une conversation existe deja il faut l'afficher */
		$current_conversation->setMessages(FarceDePloucDbUtilities::getAllMessagesFromConversation($current_conversation->getId()));
		$membres = FarceDePloucDbUtilities::getMembresConversation($current_conversation->getId());
		$liste_membres = [];
		foreach ($membres as $membre) {
			$membre_personne = new Personne($id = $membre['id'], $nom = $membre['nom'], $prenom = $membre['prenom'], $pseudo = $membre['pseudo']);
			$liste_membres[] = $membre_personne;
		}
		$current_conversation->setMembres($liste_membres);
		$affichage_conversations = FarceDePloucDbUtilities::getConversations($plouc_connecte->getId());
		$_SESSION['current_conversation'] = serialize($current_conversation);
		include_once "pages/messenger.php";
		break;
	case 'recherche_pour_ajout_a_discu':
		if (isset($_POST['recherche']) and !empty($_POST['recherche'])) {
			$ma_recherche = $_POST['recherche'];
			FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
			$current_conversation = unserialize($_SESSION['current_conversation']);
			$affichage_conversations = FarceDePloucDbUtilities::getConversations($plouc_connecte->getId());
			$affichage_personne = FarceDePloucDbUtilities::searchPeople($ma_recherche, $plouc_connecte->getId());
			include_once "pages/messenger.php";
		} else {
			//erreur pas de recherche faite (plus tard)
			include_once "pages/journal.php";
		}
		break;
	case 'ajouter_pote_dans_convers':
		if (isset($_POST['tralala']) and !empty($_POST['tralala'])) {
			FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
			$personne_ajoutee_a_discu = $_POST['tralala'];
			$current_conversation = unserialize($_SESSION['current_conversation']);
			$affichage_conversations = FarceDePloucDbUtilities::getConversations($plouc_connecte->getId());
			FarceDePloucDbUtilities::addMemberToConversation($personne_ajoutee_a_discu, $current_conversation->getId());
			include_once "pages/messenger.php";
		}
		break;
	default:
		/* ici on sera déconnecté en cas d'action erronée (que le site ne prévoit pas) pour éviter toute possibilité de risque */
		session_destroy();
		include_once "pages/connexion.php";
		break;
}

/* Save object plouc_connecte in session */
if (isset($_SESSION['plouc_connecte'])) {
	/*Est-ce que la variable de session plouc_connecte existe et contient des données*/
	$_SESSION['plouc_connecte'] = serialize($plouc_connecte);
}
if (isset($_SESSION['current_conversation']) and isset($current_conversation)) {
	$_SESSION['current_conversation'] = serialize($current_conversation);
}
