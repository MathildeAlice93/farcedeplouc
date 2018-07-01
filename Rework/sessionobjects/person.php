<?php
/**
 * translate this to English
 **/

class Person
{
	/*Attributs*/
	private $id;
	private $lastName;
	private $firstName;
	private $nickname;
	private $birthDay;
	private $registrationDate;
	private $email;
	private $password;

	/*Consturcteur de la classe personne*/

	public function __construct($id = "", $lastName = "", $firstName = "", $nickname = "", $birthDay = "", $registrationDate = "", $email = "", $password = "")
	{
		$this->id = $id;
		$this->lastName = $lastName;
		/*$this sert à dire que le programme doit aller voir son attribut lastName et lui attribuer la valeur dans la variable $lastName*/
		$this->firstName = $firstName;
		$this->nickname = $nickname;
		$this->birthDay = $birthDay;
		$this->registrationDate = $registrationDate;
		$this->email = $email;
		$this->password = $password;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getLastName()
	{
		return $this->lastName;
	}

	public function getFirstName()
	{
		return $this->firstName;
	}

	public function getNickname()
	{
		return $this->nickname;
	}

	public function getBirthDate()
	{
		if ($this->birthDay != "") {
			return $this->birthDay;
		}
		return null;
	}

	public function getRegistrationDate()
	{
		return $this->registrationDate;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setLastName($lastName)
	{
		$this->lastName = $lastName;
	}

	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;
	}

	public function setNickname($nickname)
	{
		$this->nickname = $nickname;
	}

	public function setBirthDate($birthDay)
	{
		$this->birthDay = $birthDay;
	}

	public function setRegistrationDate($registrationDate)
	{
		$this->registrationDate = $registrationDate;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}
}
