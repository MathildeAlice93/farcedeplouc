<?php

/* inclusions */
include_once "database.php";
include_once "sessionobjects/person.php";
include_once "sessionobjects/conversation.php";
include_once "handlers/registration.php";
include_once "pages/manager.php";
include_once "pages/page.php"; 
include_once "handlers/session.php";

/* Paramètres de connexion par défaut pour wamp (donc différent sur Linux) */
$dbName = "farce_de_plouc";
/* farce_de_plouc est le nom de la bdd dans PHP MyAdmin */
$host = "localhost";
$username = "root";
$password = "";

if(!empty($_POST['submit'])){
    session_start();
    $submitValue = $_POST['submit']; 
    $submitExplodedValues = explode(":", $submitValue); 
    var_dump($submitExplodedValues);
    $handler = $submitExplodedValues[0];
    $action = $submitExplodedValues[1]; 
    $arguments = array_slice($submitExplodedValues, 2); 
    Session::setArguments($arguments);
    Database::constructPDO($dbName, $host, $username, $password);
    $handler::$action();
}else{
    Manager::connection(); 
}

?>