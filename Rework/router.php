<?php
/* inclusions */
// include_once "models/Database.php";
// include_once "models/Person.php";
// include_once "models/Conversation.php";
include_once "pages/manager.php";
include_once "pages/page.php"; 

/* Paramètres de connexion par défaut pour wamp (donc différent sur Linux) */
$dbName = "farce_de_plouc";
/* farce_de_plouc est le nom de la bdd dans PHP MyAdmin */
$host = "localhost";
$username = "root";
$password = "";

if(!empty($_POST['submit'])){
    $submitValue = $_POST['submit']; 
    $submitExplodedValues = explode(":", $submitValue); 
    $handler = $submitExplodedValues[0]; 
    $action = $submitExplodedValues[1]; 
    //... comment faire pour appeler une fonction a partir d'un string test
}
else{
    Manager::connection(); 
}

?>