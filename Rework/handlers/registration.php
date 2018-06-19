<?php 
class Registration 
{
    public static function inputValidation(){
        $errorsArray = [];
        if (!(isset($_POST['nom']) and !empty($_POST['nom']))) {
            $errorsArray['1'] = 'nom';
        }
        if (!(isset($_POST['prenom']) and !empty($_POST['prenom']))) {
            $errorsArray['2'] = 'prenom';
        }
        if (!(isset($_POST['pseudo']) and !empty($_POST['pseudo']))) {
            $errorsArray['3'] = 'pseudo';
        }
        if (!(isset($_POST['jour']) or !empty($_POST['jour']))) {
            $errorsArray['4'] = 'jour';
        }
        if (!(isset($_POST['mois']) or !empty($_POST['mois']))) {
            $errorsArray['5'] = 'mois';
        }
        if (!(isset($_POST['an']) or !empty($_POST['an']))) {
            $errorsArray['6'] = 'an';
        }
        if (isset($_POST['courriel']) and !empty($_POST['courriel']) and isset($_POST['courriel_bis']) and !empty($_POST['courriel_bis'])) {
            if ($_POST['courriel'] != $_POST['courriel_bis']) {
                $errorsArray['8'] = 'courriel_bis';
            }
        } else {
            $errorsArray['7'] = 'courriel';
            $errorsArray['8'] = 'courriel_bis';
            #erreur : on teste les deux en même temps donc on sait pas précisemnt lequel des deux n'était pas rempli
        }
        if (!(isset($_POST['mot_de_passe']) and !empty($_POST['mot_de_passe']))) {
            $errorsArray['9'] = 'mot_de_passe';
        }
        if (empty($errorsArray)){
            self::newUserRegistration(); 
        }
        else if (empty($_POST)){
            Manager::connection(); 
        }
        else{
            Manager::connection();
            if (isset($_POST['nom']) and !empty($_POST['nom'])) {
                $waarde = $_POST['nom'];
                $id = 'nom';
                echo "<script> setValue('" . $id . "','" . $waarde . "'); </script>";
            }
            if (isset($_POST['prenom']) and !empty($_POST['prenom'])) {
                $waarde = $_POST['prenom'];
                $id = 'prenom';
                echo "<script> setValue('" . $id . "','" . $waarde . "'); </script>";
            }
            if (isset($_POST['pseudo']) and !empty($_POST['pseudo'])) {
                $waarde = $_POST['pseudo'];
                $id = 'pseudo';
                echo "<script> setValue('" . $id . "','" . $waarde . "'); </script>";
            }
            if (isset($_POST['jour']) and !empty($_POST['jour'])) {
                $waarde = $_POST['jour'];
                $id = 'jour_' . $waarde;
                echo "<script> setOption('" . $id . "'); </script>";
            }
            if (isset($_POST['mois']) and !empty($_POST['mois'])) {
                $waarde = $_POST['mois'];
                $id = 'mois_' . $waarde;
                echo "<script> setOption('" . $id . "'); </script>";
            }
            if (isset($_POST['annee']) and !empty($_POST['annee'])) {
                $waarde = $_POST['annee'];
                $id = 'annee_' . $waarde;
                echo "<script> setOption('" . $id . "'); </script>";
            }
            if (isset($_POST['courriel']) and !empty($_POST['courriel'])) {
                $waarde = $_POST['courriel'];
                $id = 'courriel';
                echo "<script> setValue('" . $id . "','" . $waarde . "'); </script>";
            }
            if (isset($_POST['courriel_bis']) and !empty($_POST['courriel_bis'])) {
                $waarde = $_POST['courriel_bis'];
                $id = 'courriel_bis';
                echo "<script> setValue('" . $id . "','" . $waarde . "'); </script>";
            }
            foreach ($errorsArray as $error) {
                echo "<script> error('" . $error . "'); </script>";
            }
        }
    }
    public static function newUserRegistration(){
            $psersonne = new Personne;
            $personne->setNom($_POST['nom']);
            $personne->setPrenom($_POST['prenom']);
            $personne->setPseudo($_POST['pseudo']);
            $date_annif = $_POST['annee'] . "-" . $_POST['mois'] . "-" . $_POST['jour'];
            $personne->setDate_anniversaire($date_annif);
            $personne->setCourriel($_POST['courriel']);
            $personne->setMot_de_passe($_POST['mot_de_passe']);
            Database::connectPdodb($pdodb_name, $host, $username, $password);
            Database::addPersonne($personne->getNom(), $personne->getPrenom(), $personne->getPseudo(), $personne->getDate_anniversaire(), $personne->getCourriel(), $personne->getMot_de_passe());
            Manager::connection();
    }
}
?>