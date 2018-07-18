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
}
?> 