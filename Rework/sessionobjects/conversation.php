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
	private $creationDate;
	private $title;
	private $public;
	private $members;
	private $messages;

	/*Consturcteur de la classe personne*/

	public function __construct($id = "", $creationDate = null, $title = "", $public = "", $members = [], $messages = null)
	{
		$this->id = $id;
		/*$this sert à dire que le programme doit aller voir son attribut nom et lui attribuer la valeur dans la variable $title*/
		$this->creationDate = $creationDate;
		$this->title = $title;
		$this->public = $public;
		$this->members = $members;
		$this->messages = $messages;
		//la structure de données de messages est celle obtenue apres un fetchAll
	}

	public function getId()
	{
		return $this->id;
	}

	public function getCreationDate()
	{
		return $this->creationDate;
	}

	public function getNom()
	{
		return $this->prenom;
	}

	public function getPublic()
	{
		return $this->public;
	}

	public function getMembres()
	{
		return $this->members;
	}
	public function getMessages()
	{
		return $this->messages;
	}
	public function setId($id)
	{
		$this->id = $id;
	}
	public function setCreationDate($creationDate)
	{
		$this->creationDate = $creationDate;
	}
	public function setNom($title)
	{
		$this->title = $title;
	}
	public function setPublic($public)
	{
		$this->public = $public;
	}
	public function setMembres($members)
	{
		$this->members = $members;
	}
	public function setMessages($messages)
	{
		$this->messages = $messages;
	}
}
