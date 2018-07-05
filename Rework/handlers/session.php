<?php
class Session 
{
    private static $connectedPerson;


    public static function createSession()
    {
        if (session_status() == PHP_SESSION_NONE) 
        {
	        session_start();
        }
        if (isset($_SESSION['person'])) {
            self::$connectedPerson = unserialize($_SESSION['person']);
        } else {
            self::$connectedPerson = new Person;
            $_SESSION['person'] = serialize(self::$connectedPerson);
        }
    }
    
    public static function connection() 
    {
        $isValidAttempt = 0b0;
		/*0b0 est un nombre entier écrit sous forme binaire, dans ce cas-ci le nombre entier représenté est zéro.*/
		if (isset($_POST['connect_email']) and !empty($_POST['connect_email'])) {
			$isValidAttempt += 0b1;
		}
		if (isset($_POST['connect_mot_de_passe']) and !empty($_POST['connect_mot_de_passe'])) {
			$isValidAttempt += 0b10;
		}
		if ($isValidAttempt == 0b11) {
			$isThisPersonValid = Database::isValidPerson($_POST['connect_email'], $_POST['connect_mot_de_passe']);
			if ($isThisPersonValid != false) {
				//boucle de principe, on est certain que isThisPersonValid ne contient qu'un seul élément
				foreach ($isThisPersonValid as $row) {
					self::$connectedPerson->setId($row['id']);
					self::$connectedPerson->setNom($row['nom']);
					self::$connectedPerson->setPrenom($row['prenom']);
					self::$connectedPerson->setPseudo($row['pseudo']);
					self::$connectedPerson->setDate_anniversaire($row['date_anniversaire']);
					self::$connectedPerson->setDate_inscription($row['date_inscription']);
					self::$connectedPerson->setCourriel($row['courriel']);
					self::$connectedPerson->setMot_de_passe($row['mot_de_passe']);
				}
				echo "<script>
					window.onload = function() {
						history.replaceState('', '', 'router.php?handler=Session&action_du_plouc=connexion');
					}
					</script>";

                Manager::home();
			} else {
				//erreur (personne pas dans base de donnnées) (plus tard)
				include_once "pages/connexion.php";
			}
		} else if(self::$connectedPerson->getId() != "") {
			include_once "pages/journal.php";
		} else {
			//traiter l'erreur plus tard (champs invalides)
			include_once "pages/connexion.php";
		}
		break;
    }


    
    //définir les autres attributs privés
    //créer les fonctions qui contiendront, 
    //entre autres, l'instanciation de personne.
}
?>