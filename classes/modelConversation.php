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
		private $nom; 
		private $public; 
        private $membres; 
        
        		/*Consturcteur de la classe personne*/

		public function __construct($id="", $date_creation=NULL, $nom="", $public="", $membres=[], $messages=NULL)
		{
			$this->id = $id; 
			/*$this sert à dire que le programme doit aller voir son attribut nom et lui attribuer la valeur dans la variable $nom*/
			$this->date_creation = $date_creation; 
			$this->nom = $nom; 
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
			return $this->nom; 
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
        public function setNom($nom)
        {
            $this->nom = $nom;
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

    }

    


?>