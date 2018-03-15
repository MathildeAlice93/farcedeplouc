<?php
	/**
	* @author Mathilde Alice Stiernet
	*/
	
	/* inclusions */
	include_once "classes/modelDatabase.php";
	include_once "classes/modelPersonne.php";
	include_once "classes/modelConversation.php";

	
	/* default connection parameters */
	$pdodb_name = "farce_de_plouc";
	/*doit apparemment avoir le même nom que la bdd php myadmin*/
	/*l'objet PDO de PHP sert de connexion entre PHP et la base de données MySQL, son nom est FarceDePloucApp*/
	$host = "localhost";
	$username = "root";
	$password = "";
	
	/**
	* router : redirects to the different controllers
	*/
	
	if(!empty($_GET['handler']) && is_file("handlers/handle".$_GET['handler'].".php"))
	{
		include "handlers/handle".$_GET['handler'].".php";
	}
	else
	{
		include "handlers/handleSession.php";
	}
?>