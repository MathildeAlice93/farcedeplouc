<?php
	/**
	* @author Mathilde Alice Stiernet
	*/
	
	
	/**
	* provide object to represent a person at registration time 
	*/

	class Personne
	{
		/*Attributs*/
		private $id;
		private $nom; 
		private $prenom; 
		private $pseudo; 
		private $date_anniversaire; 
		private $date_inscription; 
		private $courriel; 
		private $mot_de_passe; 

		/*Consturcteur de la classe personne*/

		public function __construct($nom="", $prenom="", $pseudo="", $date_anniversaire="", $date_inscription="", $courriel="", $mot_de_passe="")
		{
			$this->nom = $nom; 
			/*$this sert à dire que le programme doit aller voir son attribut nom et lui attribuer la valeur dans la variable $nom*/
			$this->prenom = $prenom; 
			$this->pseudo = $pseudo; 
			$this->date_anniversaire = $date_anniversaire; 
			$this->date_inscription = $date_inscription; 
			$this->courriel = $courriel; 
			$this->mot_de_passe = $mot_de_passe;
		}

		public function getId()
		{
			return $this->id;
		}

		public function getNom()
		{
			return $this->nom; 
		}

		public function getPrenom()
		{
			return $this->prenom; 
		}

		public function getPseudo()
		{
			return $this->pseudo; 
		}

		public function getDate_anniversaire()
		{
			if($this->date_anniversaire != "")
			{
				return $this->date_anniversaire; 
			}
			return null; 
		}

		public function getDate_inscription()
		{
			return $this->date_inscription; 
		}

		public function getCourriel()
		{
			return $this->courriel; 
		}

		public function getMot_de_passe()
		{
			return $this->mot_de_passe;
		}

		public function setId($id)
		{
			$this->id = $id;
		}

		public function setNom($nom)
		{
			$this->nom = $nom; 
		}

		public function setPrenom($prenom)
		{
			$this->prenom = $prenom; 
		}

		public function setPseudo($pseudo)
		{
			$this->pseudo = $pseudo; 
		}

		public function setDate_anniversaire($date_anniversaire)
		{
			$this->date_anniversaire = $date_anniversaire; 
		}

		public function setDate_inscription($date_inscription)
		{
			$this->date_inscription = $date_inscription; 
		}

		public function setCourriel($courriel)
		{
			$this->courriel = $courriel; 
		}

		public function setMot_de_passe($mot_de_passe)
		{
			$this->mot_de_passe = $mot_de_passe; 
		}
	}

?>