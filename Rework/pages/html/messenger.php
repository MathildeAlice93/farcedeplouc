<?php
if(isset($dictionary['currentConversation']))
{ 
    ?>
    <form method="POST">
        <label for="research">Ma recherche: </label>
        <input type="text" name="research" placeholder="Que veux-tu trouver?"/> 
        <button type = "submit" name="submit" value = "Session:researchFriendsForConversation">Lancer la recherche!</button>
    </form>
    <?php
    $existingMessages = $dictionary['currentConversation']->getMessages();
    if(isset($existingMessages))
    {
        foreach($existingMessages as $message)
        {?>
            <div>
            <?php echo $message['pseudo'] . ": " . $message["contenu"] . " envoyé à " . $message['date_envoi']; ?>
            </div>
        <?php }
    }
    ?>
    <form method="POST">
        <textarea name="newMessage" placeholder="Wanna say somethin' ?" rows="3" cols="30"></textarea>
        <button type = "submit" name="submit" value = "Session:postMessage">Envoi!</button>
    </form>
    <?php
}
?>   