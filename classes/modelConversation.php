<?php
	/**
	* @author Mathilde Alice Stiernet
	*/
	
	
	/**
	* provide object to represent a conversation 
	*/

	class Conversation
	{
        /*Attributs*/
		private $id;
		private $date_creation; 
		private $titre; 
		private $public; 
		private $membres; 
		private $messages;
        
        		/*Consturcteur de la classe personne*/

		public function __construct($id="", $date_creation=NULL, $titre="", $public="", $membres=[], $messages=NULL)
		{
			$this->id = $id; 
			/*$this sert à dire que le programme doit aller voir son attribut nom et lui attribuer la valeur dans la variable $titre*/
			$this->date_creation = $date_creation; 
			$this->titre = $titre; 
			$this->public = $public; 
            $this->membres = $membres;
            $this->messages = $messages;
            //la structure de données de messages est celle obtenue apres un fetchAll
        }
        
        public function getId()
		{
			return $this->id;
		}

		public function getDate_creation()
		{
			return $this->titre; 
		}

		public function getNom()
		{
			return $this->prenom; 
		}

		public function getPublic()
		{
			return $this->pseudo; 
		}

		public function getMembres()
		{
			return $this->membres; 
        }
        public function getMessages()
        {
            return $this->messages;
        }
        public function setId($id)
		{
			$this->id = $id;
        }
        public function setDate_creation($date_creation)
        {
            $this->date_creation = $date_creation;
        }
        public function setNom($titre)
        {
            $this->titre = $titre;
        }
        public function setPublic($public)
        {
            $this->public = $public; 
        }
        public function setMembres($membres)
        {
            $this->membres = $membres; 
        }
        public function setMessages($messages)
        {
            $this->messages = $messages;
		}
		//creer fonction isMemberOfConversation (pas ajouter un membre deja present), modifier le stockage des membres,
		//créer une conversation a partir de la page conversation

    }

    


?>