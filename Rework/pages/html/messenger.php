<?php
if(isset($dictionary['currentConversation']))
{ 
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
        <textarea name="new_message" placeholder="Wanna say somethin' ?" rows="3" cols="30"></textarea>
        <button type = "submit" name="submit" value = "Session:postMessage">Envoi!</button>
    </form>
    <?php
}
?>   