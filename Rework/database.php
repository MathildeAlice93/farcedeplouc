<?php

class Database
{
	/* current pdo connection informations */
	private static $pdo = null;
	private static $host = null;
	private static $dbName = null;
	private static $username = null;
	private static $password = null;

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

	 //connection
	public static function constructPDO($dbName = "default", $host = "localhost", $username = "", $password = "")
	/*localhost signifie que ta base de données est stockée localement*/ {
		try
		{
			if (isset(self::$pdo) or $dbName != "default")
			{
				self::$host = $host;
				self::$dbName = $dbName;
				self::$username = $username;
				self::$password = $password;
				self::$pdo = new PDO("mysql:host = " . self::$host, self::$username, self::$password);
				self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$pdo->exec("CREATE DATABASE IF NOT EXISTS " . self::$dbName); 
				self::$pdo->exec("USE " . self::$dbName);
			} else
			{
				self::$pdo->exec("USE " . self::$dbName);
			}
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}

	/* fonctions relatives à la table Personne */
	public static function addPerson($lastName, $firstName, $nickname, $birthDate, $email, $password)
	{
		try
		{
			$statement = self::$pdo->prepare(
				"INSERT INTO personne(id, nom, prenom, pseudo, date_anniversaire, date_inscription, courriel, mot_de_passe)
						VALUES (NULL, :nom, :prenom, :pseudo, :date_anniversaire, CURRENT_TIMESTAMP, :courriel, :mot_de_passe);"
			);
			$statement->execute(array(
				'nom' => $lastName,
				'prenom' => $firstName,
				'pseudo' => $nickname,
				'date_anniversaire' => $birthDate,
				'courriel' => $email,
				'mot_de_passe' => $password,
			));
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}
	public static function getPerson($id)
	{
		try {
			$statement = self::$pdo->prepare(
				"SELECT id, nom, prenom, pseudo, date_anniversaire, courriel
					FROM personne
					WHERE id = :id;"
			);
			$statement->execute(array(
				':id' => $id,
			));
			return $statement->fetchAll();
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}
	public static function isValidPerson($email, $password)
	{
		try
		{
			$statement = self::$pdo->prepare(
				"SELECT *
					FROM personne
					WHERE personne.courriel = :courriel AND personne.mot_de_passe = :mot_de_passe;"
			);
			$statement->execute(array(
				'courriel' => $email,
				'mot_de_passe' => $password,
			));
			$line = $statement->fetchAll();
			if (count($line) == 1) {
				return $line;
			} else {
				return false;
			}
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}
	public static function searchPeople($userSearch, $idConnectedUser)
	{
		try
		{
			$statement = self::$pdo->prepare(
				"SELECT id, nom, prenom, pseudo, date_anniversaire, courriel
					FROM personne
					WHERE (personne.nom = :wanted_plouc OR personne.pseudo = :wanted_plouc OR personne.prenom = :wanted_plouc) AND personne.id <> :ma_variable_id;"
			);
			$statement->execute(array(
				'wanted_plouc' => $userSearch,
				'ma_variable_id' => $idConnectedUser,
			));
			return $statement->fetchAll();
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}

	public static function searchFriendsForConversation($userSearch, $idConnectedUser, $idCurrentConversation)
	{
		try
		{
			$statement = self::$pdo->prepare(
				"SELECT id, nom, prenom, pseudo, date_anniversaire, courriel
					FROM personne, joint_personne
					WHERE (id_demandeur = :id_connected_person AND id_receveur = personne.id OR id_demandeur = personne.id AND id_receveur = :id_connected_person)
						AND (personne.nom = :searched_person OR personne.pseudo = :searched_person OR personne.prenom = :searched_person) 
						AND personne.id <> :id_connected_person
						AND personne.id NOT IN (SELECT id_personne FROM joint_conversation_personne WHERE id_conversation = :id_current_conversation);"
			);
			$statement->execute(array(
				'searched_person' => $userSearch,
				'id_connected_person' => $idConnectedUser,
				'id_current_conversation' => $idCurrentConversation
			));
			return $statement->fetchAll();
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}
	/* fonctions relatives à la relation entre personnes (table join_person) */
	public static function addJoinPerson($idRequestor, $idReceiver, $status)
	{
		if (self::verifyExistingRelationship($idRequestor, $idReceiver) == 'confirme') {
			return 0;
		}
		try
		{
			$statement = self::$pdo->prepare(
				"INSERT INTO joint_personne(id_demandeur, id_receveur, statut, date_demande, date_traitement)
						VALUES (:id_demandeur, :id_receveur, :statut, CURRENT_TIMESTAMP, NULL);"
			);
			$statement->execute(array(
				'id_demandeur' => $idRequestor,
				'id_receveur' => $idReceiver,
				'statut' => $status,
			));
			return 1;
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}
	public static function getPendingFriendRequests($id, $limit, $offset = 0)
	{
		try
		{
			$statement = self::$pdo->prepare(
				"SELECT p.id, p.nom, p.prenom, p.pseudo
					FROM personne AS p, joint_personne AS jp
					WHERE jp.id_receveur = :id AND jp.id_demandeur = p.id 
						AND jp.statut = :statut
					ORDER BY p.pseudo ASC
					LIMIT $offset, $limit;"
			);
			$statement->execute(array(
				':id' => $id,
				':statut' => 'en_attente',
			));
			return $statement->fetchAll();
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}
	public static function getRelatedPersonByStatus($id, $status, $limit, $offset = 0)
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
				':statut' => $status,
			));
			return $statement->fetchAll();
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}
	public static function updateJoinPerson($idReceiver, $idRequestor, $status)
	{
		try
		{
			$statement = self::$pdo->prepare(
				"UPDATE joint_personne
					SET statut = :statut
					WHERE (id_receveur = :id_receveur AND id_demandeur = :mon_nouveau_pote);"
			);
			$statement->execute(array(
				'id_receveur' => $idReceiver,
				'mon_nouveau_pote' => $idRequestor,
				'statut' => $status,
			));
			return 1;
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}
	public static function verifyExistingRelationship($idRequestor, $idReceiver)
	{
		try
		{
			$statement = self::$pdo->prepare(
				"SELECT id_demandeur, id_receveur, statut
					FROM joint_personne
					WHERE id_demandeur = :id_demandeur AND id_receveur = :id_receveur
					OR id_demandeur = :id_receveur AND id_receveur = :id_demandeur;"
			);
			$statement->execute(array(
				'id_demandeur' => $idRequestor,
				'id_receveur' => $idReceiver,
			));
			$resultat = $statement->fetchAll();
			if (!empty($resultat)) {
				if ($resultat[0]["statut"] == 'confirme') {
					return "confirme";
				} else if ($resultat[0]["statut"] == 'en_attente') {
					return "en_attente";
				} else {
					return "refuse";
				}
			} else {
				return "refuse";
			}
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}
	/* fonctions relatives aux conversations */
	public static function addMemberToConversation($idPerson, $idConversation)
	/*static : veut dire qu'il s'agit d'une classe statique qui a une instance unique*/ {
		try
		{
			$statement = self::$pdo->prepare(
				"INSERT INTO joint_conversation_personne(id_conversation, id_personne, date_lecture, date_invitation)
						VALUES (:id_convers, :id_personne, NULL, CURRENT_TIMESTAMP);"
			);
			$statement->execute(array(
				'id_convers' => $idConversation,
				'id_personne' => $idPerson,
			));
			return 1;
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}
	private static function addPeopleToConversation($idConversation, $idPerson)
	{
		$statement = self::$pdo->prepare(
			"INSERT INTO joint_conversation_personne(id_conversation, id_personne, date_lecture, date_invitation)
				VALUES (:id_conversation, :id_personne, NULL, CURRENT_TIMESTAMP);"
		);
		$statement->execute(array(
			':id_conversation' => $idConversation,
			':id_personne' => $idPerson,
		));
		return 1;
	}
	private static function createConversation($public, $title = null)
	{

		$statement = self::$pdo->prepare(
			"INSERT INTO conversation(id, date_creation, titre, public)
				VALUES (NULL, CURRENT_TIMESTAMP, :titre, :public);"
		);
		$statement->execute(array(
			':titre' => $title,
			':public' => $public,
		));
		return self::$pdo->lastInsertId();
	}
	public static function createConversationWith($public, $idPersonsList, $name = null)
	{
		try
		{
			self::$pdo->beginTransaction();
			$idConversation = self::createConversation($public, $name);
			if(empty($idPersonsList))
			{
				throw new Exception("Il n'y a personne dans cette conversation...");
			}
			foreach ($idPersonsList as $idPerson) {
				self::addPeopleToConversation($idConversation, $idPerson);
			}
			self::$pdo->commit();
			return $idConversation;
		} catch (Exception $e) {
			self::$pdo->rollback();
			die('Erreur : ' . $e->getMessage());
		}
	}
	public static function getAllMessagesFromConversation($idConversation)
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
				':id_conversation' => $idConversation,
			));
			return $statement->fetchAll();
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}
	public static function getConversationMembers($idConversation)
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
				':id_conversation' => $idConversation,
			));
			return $statement->fetchAll();
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}
	public static function getUserConversations($idConnectedUser, $limit=50, $offset=0)
	{
		try
		{
			$statement = self::$pdo->prepare(
				"SELECT conversation.*
					FROM conversation
						JOIN joint_conversation_personne
						ON conversation.id = joint_conversation_personne.id_conversation
					WHERE joint_conversation_personne.id_personne = :id_connecte
					LIMIT $offset, $limit;"
			);
			$statement->execute(array(
				':id_connecte' => $idConnectedUser,
			));
			return $statement->fetchAll();
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}
	public static function postMessage($idPerson, $idConversation, $content)
	{
		if(self::verifyConversationMembership($idConversation, $idPerson))
		{
			try
			{
				$statement = self::$pdo->prepare(
					"INSERT INTO message(id, id_conversation, id_expediteur, contenu, `date_envoi`)
							VALUES (NULL, :id_convers, :id_personne, :contenu, CURRENT_TIMESTAMP);"
				);
				$statement->execute(array(
					':id_convers' => $idConversation,
					':id_personne' => $idPerson,
					':contenu' => $content,
				));
				return 1;
			} catch (Exception $e) {
				die('Erreur : ' . $e->getMessage());
			}
		}
		else{
			die('Vous ne faites pas partie de la conversation');
		}
	}
	public static function privateConversationExistence($idConnectedUser, $idInterlocutor)
	{
		//probleme si conversation groupe perd membres jusque 2 => conflit entre conversation privée et groupe conversation de 2 personnes (lequel sera choisi par cette fonction?)
		//solution : flag pour conversation privee ou de groupe
		try
		{
			$idMax = max($idConnectedUser, $idInterlocutor);
			$idMin = min($idConnectedUser, $idInterlocutor);
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
				':id_connecte' => $idMax,
				'id_demande' => $idMin,
			));
			return $statement->fetchAll();
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}
	public static function verifyConversationMembership($idConversation, $idPerson)
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
				':id_conversation' => $idConversation,
				':id_personne' => $idPerson,
			));
			$resultat_brut = $statement->fetchAll();
			if ($resultat_brut[0][0] > 0) {
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}
}
