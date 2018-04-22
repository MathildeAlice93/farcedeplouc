<?php
	/**instal
	* @author Mathilde Alice Stiernet
	*/
	
	
	/**
	* provide tools to use a farce_de_plouc database
	*/
	class FarceDePloucDbUtilities
	{
		/* current pdo connection informations */
		private static $pdo = NULL;
		private static $cur_host = NULL;
		private static $cur_pdodb_name = NULL;
		private static $cur_username = NULL;
		private static $cur_password = NULL;
		
		/**
		* establish and return a pdo connection and create a database if necessary
		* the database is set as used by default
		* if no parameter is provided, use the previous database, or create database "default" if none exists
		* @param str pdodb_name : name of the database issued by the php data object
		* @param str host : hostname of the server hosting the database
		* @param str username : username (connecting the database)
		* @param str password : password (for the user "username" to connect the database)
		* @return PDO pdo : connection between php and database server)
		*/

		public static function connectPdodb($pdodb_name="default", $host="localhost", $username="", $password="")
		/*localhost signifie que ta base de données est stockée localement*/
		{
			try
			{
				if(self::$pdo == NULL or $pdodb_name != "default")
					/*Si la connexion n'existe pas ou on a spécifié un nom pour celle-ci, alors on crée une connexion.*/
					/*Entre accolades tu crées des environnements, ici dans l'environnement de la fonction public static,
					tu n'as pas créé la variable $pdo, donc tu dois sortir de ton environnment courant et du coup il faut utiliser self
					*/
				{
					self::$cur_host = $host;
					self::$cur_pdodb_name = $pdodb_name;
					self::$cur_username = $username;
					self::$cur_password = $password;
					self::$pdo = new PDO("mysql:host = ".self::$cur_host, self::$cur_username, self::$cur_password);
					self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					self::$pdo->exec("CREATE DATABASE IF NOT EXISTS ".self::$cur_pdodb_name); /*c'est cette ligne qui t'impose d'avoir un pdo name égal au nom de ta base de données*/
					self::$pdo->exec("USE ".self::$cur_pdodb_name); 
					/*self::createReservationTable();
					self::createPeopleTable();*/ 
					/*permet de recréer les tables de ta base de données si elles devaient être inexistantes*/
				}
				else
					/*Sinon on utilise celle qu'on a déjà.*/
				{
					self::$pdo->exec("USE ".self::$cur_pdodb_name);
				}
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
				/*getMessage est une fonction de la classe Exception qui permet d'afficher le message d'erreur*/
				/*comment savoir que c'est une fonction de la classe Exception? parce que tu applique la fct à $e
				et $e a été défini comme étant une instance de la classe Exception*/
			}
		}

		/**
		* insert values in tables "personne"
		* @return void
		*/

		public static function addPersonne($nom, $prenom, $pseudo, $date_anniversaire, $courriel, $mot_de_passe)
		{
			//insert data into "personne"
			try
			/*try est utilisé en cas de risque d'erreur*/
			/*le try te permettre de définir ta gestion personnelle de cas problématiques éventuels, les traitements d'erreurs suivront ta définition et pas une définition par défaut*/
			{
				$statement = self::$pdo->prepare(
					"INSERT INTO personne(id, nom, prenom, pseudo, date_anniversaire, date_inscription, courriel, mot_de_passe)
						VALUES (NULL, :nom, :prenom, :pseudo, :date_anniversaire, CURRENT_TIMESTAMP, :courriel, :mot_de_passe);"
				);
				$statement->execute(array(
					'nom' => $nom,
					'prenom' => $prenom,
					'pseudo' => $pseudo,
					'date_anniversaire' => $date_anniversaire,
					'courriel' => $courriel, 
					'mot_de_passe' => $mot_de_passe
				));
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
		}
		public static function addJoint_personne($id_demandeur, $id_receveur, $statut)
		/*static : veut dire qu'il s'agit d'une classe statique qui a une instance unique*/
		{
			if (self::verifyExistingRelationship($id_demandeur, $id_receveur)){
			/*j'appelle une fonction de la propre classe (model database)*/
				return 0; 
			}
			try
			{
				$statement = self::$pdo->prepare(
					"INSERT INTO joint_personne(id_demandeur, id_receveur, statut, date_demande, date_traitement)
						VALUES (:id_demandeur, :id_receveur, :statut, CURRENT_TIMESTAMP, NULL);"
				);
				$statement->execute(array(
					'id_demandeur' => $id_demandeur, 
					'id_receveur' => $id_receveur, 
					'statut' => "confirme"
				));
				return 1; 
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
		}
		public static function verifyExistingRelationship($id_demandeur, $id_receveur)
		{
			try
			{
				$statement = self::$pdo->prepare(
					/*on insère des variables php dans une requête mysql*/
					"SELECT id_demandeur, id_receveur 
					FROM joint_personne
					WHERE id_demandeur = :id_demandeur AND id_receveur = :id_receveur 
					OR id_demandeur = :id_receveur AND id_receveur = :id_demandeur;"
				);
				$statement->execute(array(
					'id_demandeur' => $id_demandeur, 
					'id_receveur' => $id_receveur	
				));
				$resultat = $statement->fetchAll();
				if (!empty($resultat)){
					return TRUE; 
				} else {
					return FALSE; 
				}
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
		}
		public static function getPotes($id, $limit, $offset=0)
		{
			try 
			{
				$statement = self::$pdo->prepare(
					"SELECT p.id, p.nom, p.prenom, p.pseudo 
					FROM personne AS p, joint_personne AS jp
					WHERE (
							jp.id_demandeur = :id AND jp.id_receveur = p.id
							OR jp.id_receveur = :id AND jp.id_demandeur = p.id
						)
						AND jp.statut = :statut
					ORDER BY p.pseudo ASC
					LIMIT $offset, $limit;"
				);
				$statement->execute(array(
					':id' => $id,
					':statut' => "confirme"
				));
				return $statement->fetchAll(); 
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
		}
		public static function getPersonne($id)
		{
			try{
				$statement = self::$pdo->prepare(
					"SELECT id, nom, prenom, pseudo
					FROM personne
					WHERE id = :id;"
				);
				$statement->execute(array(
					':id' => $id
				));
				return $statement->fetchAll();
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
		}
		public static function getInfos($id)
		{
			try 
			{
				$statement = self::$pdo->prepare(
					"CALL afficher_infos($id);"
				);
				$statement->execute(array());
				return $statement->fetchAll(); 
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
		}
		
		public static function isValidPerson($courriel, $mot_de_passe)
		{
			try
			{
				$statement = self::$pdo->prepare(
					"SELECT *
					FROM personne
					WHERE personne.courriel = :courriel AND personne.mot_de_passe = :mot_de_passe;"
				);
				$statement->execute(array(
					'courriel' => $courriel,
					'mot_de_passe' => $mot_de_passe
				));
				$line = $statement->fetchAll();
				if(count($line) == 1)
				{
					return $line;
				}
				else
				{
					return false;
				}
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
		}
		public static function searchPeople($wanted_plouc, $plouc_connecte_id)
		{
			try
			{
				$statement = self::$pdo->prepare(
					"SELECT *
					FROM personne
					WHERE (personne.nom = :wanted_plouc OR personne.pseudo = :wanted_plouc OR personne.prenom = :wanted_plouc) AND personne.id <> :ma_variable_id;"
				);	
				$statement->execute(array(
					'wanted_plouc' => $wanted_plouc,
					'ma_variable_id' => $plouc_connecte_id
				));
				return $statement->fetchAll();
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
		}
		private static function createConversation($public, $titre=NULL)
		{

			$statement = self::$pdo->prepare(
				"INSERT INTO conversation(id, date_creation, titre, public) 
				VALUES (NULL, CURRENT_TIMESTAMP, :titre, :public);"
			);	
			$statement->execute(array(
				':titre' => $titre,
				':public' => $public
			));
			return self::$pdo->lastInsertId();
		}
		private static function addPeopleToConversation($id_conversation, $id_personne)
		/*Ici j'ai mis la fonction en private car elle n'est sensée etre appelee que par createConversationWith, pas par l'utilisateur directement */
		{
			$statement = self::$pdo->prepare(
				"INSERT INTO joint_conversation_personne(id_conversation, id_personne, date_lecture, date_invitation) 
				VALUES (:id_conversation, :id_personne, NULL, CURRENT_TIMESTAMP);"
			);
			$statement->execute(array(
				':id_conversation' => $id_conversation,
				':id_personne' => $id_personne
			));
			return 1; 
		}
		public static function createConversationWith($public, $liste_id_personnes, $nom=NULL)
		{
			try 
			{
				self::$pdo->beginTransaction();
				$id_convers = self::createConversation($public, $nom);
				foreach($liste_id_personnes as $id_personne)
				{
					self::addPeopleToConversation($id_convers, $id_personne);
				}
				self::$pdo->commit();
				return $id_convers; 
			}
			catch(Exception $e)
			{
				self::$pdo->rollback();
				die('Erreur : '.$e->getMessage());
			}
		}	
		public static function existeConversationPrive($id_connecte, $id_demande)
		{
			try
			{
				$id_max = max($id_connecte, $id_demande);
				$id_min = min($id_connecte, $id_demande);
				$statement = self::$pdo->prepare(
					"SELECT jcp1.id_conversation 
					FROM joint_conversation_personne AS jcp1, 
						joint_conversation_personne AS jcp2
					WHERE jcp1.id_conversation = jcp2.id_conversation
						AND jcp1.id_conversation IN 
							(SELECT id_conversation
							FROM joint_conversation_personne
							GROUP BY id_conversation
							HAVING COUNT(*)=2)
						AND jcp1.id_personne > jcp2.id_personne
						AND jcp1.id_personne = :id_connecte
						AND jcp2.id_personne = :id_demande 
					;"
				);
				$statement->execute(array(
					':id_connecte' => $id_max, 
					'id_demande' => $id_min
				));
				return $statement->fetchAll();;	
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
		}
		public static function getAllMessagesFromConversation($id_conversation)
		{
			try
			{
				$statement = self::$pdo->prepare(
					"SELECT conversation.titre, pseudo, contenu, `date_envoi`
					FROM message
						JOIN conversation
							ON conversation.id = message.id_conversation
						JOIN personne 
							ON personne.id = message.id_expediteur
					WHERE conversation.id = :id_conversation
					ORDER BY `date_envoi`; "
				);
				$statement->execute(array(
					':id_conversation' => $id_conversation
				));
				return $statement->fetchAll();;	
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			} 
			
		}
		public static function postMessage($id_personne, $id_convers, $contenu)
		{
			try
			{
				$statement = self::$pdo->prepare(
					"INSERT INTO message(id, id_conversation, id_expediteur, contenu, `date_envoi`)
						VALUES (NULL, :id_convers, :id_personne, :contenu, CURRENT_TIMESTAMP);"
				);
				$statement->execute(array(
					':id_convers' => $id_convers, 
					':id_personne' => $id_personne, 
					':contenu' => $contenu
				));
				return 1; 
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
		}
		public static function getConversations($id_connecte)
		{
			try
			{
				$statement = self::$pdo->prepare(
					"SELECT conversation.*
					FROM conversation
						JOIN joint_conversation_personne  
						ON conversation.id = joint_conversation_personne.id_conversation
					WHERE joint_conversation_personne.id_personne = :id_connecte;"
				);
				$statement->execute(array(
					':id_connecte' => $id_connecte
				));
				return $statement->fetchAll();;	
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
		}	
		public static function getMembresConversation($id_conversation)
		{
			try
			{
				$statement = self::$pdo->prepare(
					"SELECT personne.nom, personne.pseudo, personne.prenom, personne.id
					FROM joint_conversation_personne 
						JOIN personne
						ON joint_conversation_personne.id_personne = personne.id
					WHERE joint_conversation_personne.id_conversation = :id_conversation;"
				);
				$statement->execute(array(
					':id_conversation' => $id_conversation
				));
				return $statement->fetchAll();
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
		}
		public static function addMemberToConversation($id_personne, $id_convers)
		/*static : veut dire qu'il s'agit d'une classe statique qui a une instance unique*/
		{
			try
			{
				$statement = self::$pdo->prepare(
					"INSERT INTO joint_conversation_personne(id_conversation, id_personne, date_lecture, date_invitation)
						VALUES (:id_convers, :id_personne, NULL, CURRENT_TIMESTAMP);"
				);
				$statement->execute(array(
					'id_convers' => $id_convers, 
					'id_personne' => $id_personne
				));
				return 1; 
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
		}
		public static function verifyMembership($id_convers, $id_personne)
		{
			try
			{
				$statement = self::$pdo->prepare(
					"SELECT COUNT(*)
					FROM joint_conversation_personne 
					WHERE joint_conversation_personne.id_conversation = :id_conversation
					AND joint_conversation_personne.id_personne = :id_personne;"
				);
				$statement->execute(array(
					':id_conversation' => $id_convers, 
					':id_personne' => $id_personne
				));
				$resultat_brut = $statement->fetchAll();	
				if($resultat_brut[0][0]>0)
				{
					return TRUE; 
				}
				else 
				{
					return FALSE;
				}
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
		}	
	}
?>