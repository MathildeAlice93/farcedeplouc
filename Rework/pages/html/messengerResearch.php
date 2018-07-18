<?php
if (isset($current_conversation)){
    echo '<form method="POST">
        <label for="recherche">Ajouter un ami à la conversation: </label>
        <input type="text" name="submit" placeholder="Qui veux-tu trouver?"/> 
        <button name="submit" value="Session:messengerResearch">Rechercher personne</button>
        </form>';
}
?>