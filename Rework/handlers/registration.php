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
                $value = $_POST['nom'];
                $id = 'nom';
                echo "<script> setValue('" . $id . "','" . $value . "'); </script>";
            }
            if (isset($_POST['prenom']) and !empty($_POST['prenom'])) {
                $value = $_POST['prenom'];
                $id = 'prenom';
                echo "<script> setValue('" . $id . "','" . $value . "'); </script>";
            }
            if (isset($_POST['pseudo']) and !empty($_POST['pseudo'])) {
                $value = $_POST['pseudo'];
                $id = 'pseudo';
                echo "<script> setValue('" . $id . "','" . $value . "'); </script>";
            }
            if (isset($_POST['jour']) and !empty($_POST['jour'])) {
                $value = $_POST['jour'];
                $id = 'jour_' . $value;
                echo "<script> setOption('" . $id . "'); </script>";
            }
            if (isset($_POST['mois']) and !empty($_POST['mois'])) {
                $value = $_POST['mois'];
                $id = 'mois_' . $value;
                echo "<script> setOption('" . $id . "'); </script>";
            }
            if (isset($_POST['annee']) and !empty($_POST['annee'])) {
                $value = $_POST['annee'];
                $id = 'annee_' . $value;
                echo "<script> setOption('" . $id . "'); </script>";
            }
            if (isset($_POST['courriel']) and !empty($_POST['courriel'])) {
                $value = $_POST['courriel'];
                $id = 'courriel';
                echo "<script> setValue('" . $id . "','" . $value . "'); </script>";
            }
            if (isset($_POST['courriel_bis']) and !empty($_POST['courriel_bis'])) {
                $value = $_POST['courriel_bis'];
                $id = 'courriel_bis';
                echo "<script> setValue('" . $id . "','" . $value . "'); </script>";
            }
            foreach ($errorsArray as $error) {
                echo "<script> error('" . $error . "'); </script>";
            }
        }
    }
    public static function newUserRegistration(){
            $psersonne = new Personne;
            $person->setLastName($_POST['nom']);
            $person->setFirstName($_POST['prenom']);
            $person->setNickname($_POST['pseudo']);
            $birthDate = $_POST['annee'] . "-" . $_POST['mois'] . "-" . $_POST['jour'];
            $person->setBirthDate($birthDate);
            $person->setEmail($_POST['courriel']);
            $person->setPassword($_POST['mot_de_passe']);
            Database::constructPDO($pdodb_name, $host, $username, $password);
            Database::addPerson($person->getLastName(), $person->getFirstName(), $person->getNickname(), $person->getBirthDate(), $person->getEmail(), $person->getPassword());
            Manager::connection();
    }
}
?>