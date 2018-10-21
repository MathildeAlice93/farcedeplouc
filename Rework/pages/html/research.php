<form method="POST">
    <label for="research">Ma recherche: </label>
    <input type="text" name="research" placeholder="Que veux-tu trouver?"/> 
    <button type = "submit" name="submit" value = "Session:<?php echo  $dictionary['researchType']; ?>">Lancer la recherche!</button>
</form>