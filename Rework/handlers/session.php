<?php
class Session 
{
	private static $connectedPerson;
	private static $arguments = NULL; 
	private static $currentConversation; 

	//utilitaires
	public static function setArguments($arguments)
	{
		self::$arguments = $arguments;
	}

	//actions
    public static function accessHome() 
    {
        $isValidAttempt = 0b0;
		/*0b0 est un nombre entier écrit sous forme binaire, dans ce cas-ci le nombre entier représenté est zéro.*/
		if (isset($_POST['connect_email']) and !empty($_POST['connect_email'])) {
			$isValidAttempt += 0b1;
		}
		if (isset($_POST['connect_mot_de_passe']) and !empty($_POST['connect_mot_de_passe'])) {
			$isValidAttempt += 0b10;
		}
		if ($isValidAttempt == 0b11) {
			$isThisPersonValid = Database::isValidPerson($_POST['connect_email'], $_POST['connect_mot_de_passe']);
			if ($isThisPersonValid != false) {
				//boucle de principe, on est certain que isThisPersonValid ne contient qu'un seul élément
				foreach ($isThisPersonValid as $row) {
					self::getConnectedPerson()->setId($row['id']);
					self::getConnectedPerson()->setLastName($row['nom']);
					self::getConnectedPerson()->setFirstName($row['prenom']);
					self::getConnectedPerson()->setNickname($row['pseudo']);
					self::getConnectedPerson()->setBirthDate($row['date_anniversaire']);
					self::getConnectedPerson()->setRegistrationDate($row['date_inscription']);
					self::getConnectedPerson()->setEmail($row['courriel']);
					self::getConnectedPerson()->setPassword($row['mot_de_passe']);
				}
				$_SESSION['person'] = serialize(self::getConnectedPerson());
                Manager::home();
			} else {
				Manager::connection(); 
			}
		} else if(self::getConnectedPerson()->getId() != "") {
			Manager::home();
		} else {
			Manager::connection(); 
		}
	}

	public static function addFriend()
	{
		if (isset(self::$arguments[0]) and strpos(self::$arguments[0], 'key')==0) {
			$idNewFriend = $_SESSION[self::$arguments[0]]; 
			Database::addJoinPerson(self::getConnectedPerson()->getId(), $idNewFriend, 'en_attente');
			$addedFriend = Database::getPerson($idNewFriend);
			Manager::research($addedFriend);
		} else {
			Manager::home();
		}		
	}

	// case 'ajouter_un_pote':
	// 	if (isset($_POST['tralala']) and $_POST['tralala']!="") {
	// 		$keyString='key'.$_POST['tralala'];
	// 		$mon_nouveau_pote = $_SESSION[$keyString];
	// 		FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
	// 		$id_demandeur = $plouc_connecte->getId();
	// 		FarceDePloucDbUtilities::addJoint_personne($id_demandeur, $mon_nouveau_pote, "en_attente");
	// 		include_once "pages/journal.php";
	// 	} else {
	// 		// erreur pas de recherche faite (plus tard)
	// 		include_once "pages/journal.php";
	// 	}
	// 	break;
	
	public static function getConnectedPerson() 
	{
		if(!isset(self::$connectedPerson))
		{
			if (session_status() != PHP_SESSION_NONE)
			{
				if (isset($_SESSION['person'])) {
					self::$connectedPerson = unserialize($_SESSION['person']);
				} else {
					self::$connectedPerson = new Person;
				}
			}
			//attention ici si on appelle cette fonction ailleurs, le if peut poser probleme
		}
		return self::$connectedPerson; 
	}

	public static function getCurrentConversation()
	{
		return self::$currentConversation;
	}

	public static function logOut()
	{
		session_destroy(); 
		//finaliser la déconnexion et suppression de cookies 
		//documentation : php session_destroy / setcookie()
		/*if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params(); 
			setcookie(session_name(), '', time() - 42000, 
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			); 
		}*/
		Manager::connection(); 
    }	

	public static function messenger()
	{
		$conversations = Database::getUserConversations(self::getConnectedPerson()->getId());
		Manager::messenger($conversations); 
	}

	public static function messengerResearch()
	{
		/*if (isset($_POST['recherche']) and !empty($_POST['recherche'])) {
			$ma_recherche = $_POST['recherche'];
			FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
			$current_conversation = unserialize($_SESSION['current_conversation']);
			$affichage_conversations = FarceDePloucDbUtilities::getConversations($plouc_connecte->getId());
			$affichage_personne = FarceDePloucDbUtilities::searchPeople($ma_recherche, $plouc_connecte->getId());
			include_once "pages/messenger.php";
		} else {
			Manager::messenger()
		}*/
	}

	public static function requestTreatment() 
	{
		$subArguments = explode("_", self::$arguments[0]);  
		if($subArguments[0] = "accept"){ 
			$keyString = $subArguments[1]; 
			$id = $_SESSION[$keyString]; 
			$idConnectedPerson = self::getConnectedPerson()->getId(); 
			Database::updateJoinPerson($idConnectedPerson, $id, 'confirme'); 
			self::accessHome(); 
		} 
		else if($subArguments[1] = "refuse"){ 
			$keyString = $subArguments[1]; 
			$id = $_SESSION[$keyString]; 
			$idConnectedPerson = self::getConnectedPerson()->getId(); 
			Database::updateJoinPerson($idConnectedPerson, $id, 'refuse'); 
			self::accessHome(); 
		} 
		else{ 
			die("t'es trop nul sale hacker"); 
		}	 
	} 
	
	public static function research()
	{
		if (isset($_POST['recherche']) and !empty($_POST['recherche'])) {
			$myResearch = $_POST['recherche'];
			$researchResults = Database::searchPeople($myResearch, self::getConnectedPerson()->getId());
			Manager::research($researchResults); 
		} else {
			Manager::home();
		}
	}

	public static function switchConversation(){
		$subArguments = explode("_", self::$arguments[0]); 
		$keyString = $subArguments[1];
		var_dump($subArguments); 
		$idConversation = $_SESSION[$keyString];
		$idConnectedPerson = self::getConnectedPerson()->getId();
		self::$currentConversation = new Conversation; 
		self::$currentConversation->setId($idConversation); 
		self::$currentConversation->setMessages(Database::getAllMessagesFromConversation(self::$currentConversation->getId()));
		$members = Database::getConversationMembers(self::$currentConversation->getId());
		$membersList = [];
		foreach ($membersList as $member) {
			$memberPerson = new Personne($id = $member['id'], $nom = $member['nom'], $prenom = $member['prenom'], $pseudo = $member['pseudo']);
			$membersList[] = $memberPerson;
		}
		self::$currentConversation->setMembers($membersList);
		$conversations = Database::getUserConversations(self::getConnectedPerson()->getId());
		//previous line might be useless
		$_SESSION['currentConversation']=serialize(self::$currentConversation);
		Manager::messenger($conversations, self::$currentConversation);
	}
}
?>


