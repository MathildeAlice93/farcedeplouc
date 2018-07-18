<?php
    $key=0;
    foreach($dictionary['conversations'] as $conversation){ ?>
        <tr>
        <?php 
        $members = Database::getConversationMembers($conversation['id']);
        if(empty($conversation['titre']))
        {
            $diplayMembers = "";
            $passed = false; 
            foreach($members as $member)
            {
                $diplayMembers = $diplayMembers . ($passed ? ',' : '') . $member['pseudo'];
                $passed = true; 
            }
        ?> 
            <td><?php echo $diplayMembers ?></td>
        <?php 
        }
        else
        {
        ?>
            <td><?php echo $conversation['titre']; ?></td>
        <?php
        }	
        ?>	
        <form method='POST'>
            <td> 
            <button type='submit' name='submit' value='Session:switchConversation:open_key<?php echo $key; ?>'>Ouvrir conversation</button>
            </td>	
            <?php 
            $keyString = "key".$key;
            $_SESSION[$keyString] = $conversation['id'];
            ?>
        </form>	
        </tr>
    <?php }   
?>