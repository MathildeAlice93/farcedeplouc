<form method='POST'>
	<button type="submit" name="submit" value="Session:logOut">Déconnexion</button>
</form>
<form method='POST'>
    <button type="submit" name="submit" value="Session:messenger">Messenger</button>
</form>

<?php 
    echo "Coucou " . Session::getConnectedPerson()->getNickname() . " ! "; 
?>

</br>