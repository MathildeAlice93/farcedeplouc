<?php
// echo "<script>
// 					window.onload = function() {
// 						history.replaceState('', '', 'router.php?handler=Registration');
// 					}
// 					</script>";
// else if($plouc_connecte->getId() != "") {
// 	include_once "pages/journal.php";
// } 
/*Création de l'objet personne*/

session_name("refresh");
session_start();
if(!isset($_SESSION['refresh'])){
	$_SESSION['refresh'] = false;
}

echo "<script>
		window.onload = function() {
			history.replaceState('', '', 'router.php?handler=Registration');
		}
		</script>";

$personne = new Personne;

$erreurs = [];

/*Gestion des vues*/

if (isset($_POST['nom']) and !empty($_POST['nom'])) {
	$personne->setNom($_POST['nom']);
} else {
	$erreurs['1'] = 'nom';
}
if (isset($_POST['prenom']) and !empty($_POST['prenom'])) {
	$personne->setPrenom($_POST['prenom']);
} else {
	$erreurs['2'] = 'prenom';
}
if (isset($_POST['pseudo']) and !empty($_POST['pseudo'])) {
	$personne->setPseudo($_POST['pseudo']);
} else {
	$erreurs['3'] = 'pseudo';
}
if (isset($_POST['jour']) and !empty($_POST['jour']) and isset($_POST['mois']) and !empty($_POST['mois']) and isset($_POST['annee']) and !empty($_POST['annee']))
#le php utilise comme référence le name d'une balise html alors que js utilise l'id
{
	$date_annif = $_POST['annee'] . "-" . $_POST['mois'] . "-" . $_POST['jour'];
	$personne->setDate_anniversaire($date_annif);
} else {
	if (!(isset($_POST['jour']) or !empty($_POST['jour']))) {
		$erreurs['4'] = 'jour';
	}
	if (!(isset($_POST['mois']) or !empty($_POST['mois']))) {
		$erreurs['8'] = 'mois';
	}
	if (!(isset($_POST['an']) or !empty($_POST['an']))) {
		$erreurs['9'] = 'an';
	}
	#il y a un problème ici
}
if (isset($_POST['courriel']) and !empty($_POST['courriel']) and isset($_POST['courriel_bis']) and !empty($_POST['courriel_bis'])) {
	if ($_POST['courriel'] == $_POST['courriel_bis']) {
		$personne->setCourriel($_POST['courriel']);
	} else {
		$erreurs['5'] = 'courriel_bis';
	}
} else {
	$erreurs['6'] = 'courriel';
	$erreurs['5'] = 'courriel_bis';
	#erreur : on teste les deux en même temps donc on sait pas précisemnt lequel des deux n'était pas rempli
}
if (isset($_POST['mot_de_passe']) and !empty($_POST['mot_de_passe'])) {
	$personne->setMot_de_passe($_POST['mot_de_passe']);
} else {
	$erreurs['7'] = 'mot_de_passe';
}
/*Connexion à la base de données*/
if (empty($erreurs)) {
	FarceDePloucDbUtilities::connectPdodb($pdodb_name, $host, $username, $password);
	/*Dans la classe modelDatabase tu appelles la fonction connectPdodb*/
	/*Le mode d'emploi de connectPdodb ets dans modelDatabase mnt tu l'appelle en lui donnant les arguments que tu as défini dans router.php pour te connecter à la bdd.*/

	FarceDePloucDbUtilities::addPersonne($personne->getNom(), $personne->getPrenom(), $personne->getPseudo(), $personne->getDate_anniversaire(), $personne->getCourriel(), $personne->getMot_de_passe());
	include_once "pages/connexion.php";
} else if ($_SESSION['refresh']) {
	session_destroy();
	include_once "pages/connexion.php";
} else {

	include_once "pages/connexion.php";

	if (isset($_POST['nom']) and !empty($_POST['nom'])) {
		$waarde = $_POST['nom'];
		$id = 'nom';
		echo "<script> set_value('" . $id . "','" . $waarde . "'); </script>";
	}
	if (isset($_POST['prenom']) and !empty($_POST['prenom'])) {
		$waarde = $_POST['prenom'];
		$id = 'prenom';
		echo "<script> set_value('" . $id . "','" . $waarde . "'); </script>";
	}
	if (isset($_POST['pseudo']) and !empty($_POST['pseudo'])) {
		$waarde = $_POST['pseudo'];
		$id = 'pseudo';
		echo "<script> set_value('" . $id . "','" . $waarde . "'); </script>";
	}
	if (isset($_POST['jour']) and !empty($_POST['jour'])) {
		$waarde = $_POST['jour'];
		$id = 'jour_' . $waarde;
		echo "<script> set_option('" . $id . "'); </script>";
	}
	if (isset($_POST['mois']) and !empty($_POST['mois'])) {
		$waarde = $_POST['mois'];
		$id = 'mois_' . $waarde;
		echo "<script> set_option('" . $id . "'); </script>";
	}
	if (isset($_POST['annee']) and !empty($_POST['annee'])) {
		$waarde = $_POST['annee'];
		$id = 'annee_' . $waarde;
		echo "<script> set_option('" . $id . "'); </script>";
	}
	if (isset($_POST['courriel']) and !empty($_POST['courriel'])) {
		$waarde = $_POST['courriel'];
		$id = 'courriel';
		echo "<script> set_value('" . $id . "','" . $waarde . "'); </script>";
	}
	if (isset($_POST['courriel_bis']) and !empty($_POST['courriel_bis'])) {
		$waarde = $_POST['courriel_bis'];
		$id = 'courriel_bis';
		echo "<script> set_value('" . $id . "','" . $waarde . "'); </script>";
	}
	foreach ($erreurs as $erreur) {
		echo "<script> erreur('" . $erreur . "'); </script>";
		/* $erreur est une variable php qui contient un string (en php)
	la ligne de code est du javascript, donc il faut qu'il comprenne que ce qu'il y a dans erreur
	est un string (compatibilité entre javascript et php =/= 100%)
	solution :
	remettre des apostrophes autour du contenu de la variable pour faire comprendre a javascript qu'il s'agit d'un
	string.
	(les guillemets servent pour le echo et disparaitront une fois cette ligne exécutée, seuls les apostrophes restent) */
	}
}
