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
		if (isset(self::$arguments[0]) and strpos(self::$arguments[0], 'person')==0) {
			$idNewFriend = $_SESSION[self::$arguments[0]]; 
			Database::addJoinPerson(self::getConnectedPerson()->getId(), $idNewFriend, 'en_attente');
			$addedFriend = Database::getPerson($idNewFriend);
			Manager::research($addedFriend);
		} else {
			Manager::home();
		}		
	}

	// case 'ajouter_pote_dans_convers':
	// 	if (isset($_POST['tralala']) and !empty($_POST['tralala'])) {
	// 		FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
	// 		$personne_ajoutee_a_discu = $_POST['tralala'];
	// 		$current_conversation = unserialize($_SESSION['current_conversation']);
	// 		$affichage_conversations = FarceDePloucDbUtilities::getConversations($plouc_connecte->getId());
	// 		FarceDePloucDbUtilities::addMemberToConversation($personne_ajoutee_a_discu, $current_conversation->getId());
	// 		include_once "pages/messenger.php";
	// 	}
	// 	break;

	public static function addFriendForConversation()
	{
		if (isset(self::$arguments[0]) and strpos(self::$arguments[0], 'key')==0) {
			$idFriendForConversation = $_SESSION[self::$arguments[0]];
			Database::addMemberToConversation($idFriendForConversation, self::getCurrentConversation()->getId());
			$conversations = Database::getUserConversations(self::getConnectedPerson()->getId());
			$_SESSION['currentConversation']=serialize(self::getCurrentConversation());
			Manager::messenger($conversations);
		} else {
			Manager::home();
		}		
	}
	
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
		if(!isset(self::$currentConversation))
		{
			if (session_status() != PHP_SESSION_NONE)
			{
				if (isset($_SESSION['currentConversation'])) {
					self::$currentConversation = unserialize($_SESSION['currentConversation']);
				} else {
					self::$currentConversation = new Conversation;
				}
			}
			//attention ici si on appelle cette fonction ailleurs, le if peut poser probleme
		}
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
		$keyString = self::$arguments[0];
		if(isset($keyString) and strpos($keyString, 'person')==0) {
			$idPerson = $_SESSION[$keyString];
			$idPrivateConversationArray = Database::privateConversationExistence(self::getConnectedPerson()->getId(),$idPerson); 
			if(!empty($idPrivateConversationArray)){
				$idConversation = $idPrivateConversationArray[0][0];
			}else{
				$idConversation = Database::createConversationWith(0, array($idPerson, self::getConnectedPerson()->getId()));
			}
			self::getCurrentConversation()->setId($idConversation); 
			self::getCurrentConversation()->setMessages(Database::getAllMessagesFromConversation(self::getCurrentConversation()->getId()));
			$members = Database::getConversationMembers(self::getCurrentConversation()->getId());
			$membersList = [];
			foreach ($members as $member) {
				$memberPerson = new Person($id = $member['id'], $nom = $member['nom'], $prenom = $member['prenom'], $pseudo = $member['pseudo']);
				$membersList[] = $memberPerson;
			}
			self::getCurrentConversation()->setMembers($membersList);
			$_SESSION['currentConversation']=serialize(self::getCurrentConversation());
			Manager::messenger($conversations); 
		}else{
			Manager::home();
		}

	}

	public static function postMessage(){
		if(isset($_SESSION['currentConversation']) and !empty($_SESSION['currentConversation'])){
			$idConnectedPerson = self::getConnectedPerson()->getId();
			$idCurrentConversation = self::getCurrentConversation()->getId();
			$myMessage = $_POST['newMessage']; 
			Database::postMessage($idConnectedPerson, $idCurrentConversation, $myMessage);
			$conversations = Database::getUserConversations($idConnectedPerson);
			self::getCurrentConversation()->setMessages(Database::getAllMessagesFromConversation($idCurrentConversation));
			$_SESSION['currentConversation']=serialize(self::getCurrentConversation());
			Manager::messenger($conversations);
		} else {
			echo 'to be continued - todo : define error message and erro handling';
		}
	}

	public static function friendRequestTreatment() 
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
	
	public static function researchPeople()
	{
		if (isset($_POST['research']) and !empty($_POST['research'])) {
			$myResearch = $_POST['research'];
			$researchResults = Database::searchPeople($myResearch, self::getConnectedPerson()->getId());
			Manager::research($researchResults); 
		} else {
			Manager::home();
		}
	}

	public static function researchFriendsForConversation()
	{
		if (isset($_POST['research']) and !empty($_POST['research'])) {
			$myResearch = $_POST['research'];
			$researchResults = Database::searchFriendsForConversation($myResearch, self::getConnectedPerson()->getId(), self::getCurrentConversation()->getId());
			$conversations = Database::getUserConversations(self::getConnectedPerson()->getId());
			Manager::messenger($conversations, $researchResults); 
		} else {
			Manager::home();
		}
	}

	public static function switchConversation(){
		$subArguments = explode("_", self::$arguments[0]); 
		$keyString = $subArguments[1];
		if (isset($keyString) and strpos($keyString, 'conversation')==0) {
			var_dump($subArguments); 
			$idConversation = $_SESSION[$keyString];
			$idConnectedPerson = self::getConnectedPerson()->getId();
			self::getCurrentConversation()->setId($idConversation); 
			var_dump(self::getCurrentConversation()); 
			self::getCurrentConversation()->setMessages(Database::getAllMessagesFromConversation(self::getCurrentConversation()->getId()));
			$members = Database::getConversationMembers(self::getCurrentConversation()->getId());
			$membersList = [];
			foreach ($members as $member) {
				$memberPerson = new Person($id = $member['id'], $nom = $member['nom'], $prenom = $member['prenom'], $pseudo = $member['pseudo']);
				$membersList[] = $memberPerson;
			}
			self::getCurrentConversation()->setMembers($membersList);
			$conversations = Database::getUserConversations(self::getConnectedPerson()->getId());
			//previous line might be useless
			$_SESSION['currentConversation']=serialize(self::getCurrentConversation());
			Manager::messenger($conversations);
		} else {
			Manager::home();
		}	
	}
}
?>


