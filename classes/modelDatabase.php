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
			try
			{
				$statement = self::$pdo->prepare(
					"INSERT INTO addJoint_personne(id_demandeur, id_receveur, statut, date_demande, date_traitement)
						VALUES (:id_demandeur, :id_receveur, :statut, CURRENT_TIMESTAMP, NULL);"
				);
				$statement->execute(array(
					'id_demandeur' => $id_demandeur, 
					'id_receveur' => $id_receveur, 
					'statut' => "en_attente"
				)); 
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
		}
		public static function get_potes($id, $limit, $offset=1)
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
					'id' => $id,
					'statut' => "confirme"
				));
				return $statement->fetchAll(); 
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}
		}
		public static function isValidPerson($courriel, $mot_de_passe)
		{
			try{
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
	}
?>