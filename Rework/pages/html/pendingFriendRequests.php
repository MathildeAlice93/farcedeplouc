<?php 
    echo "Amis en attente : "; 
        $pendingFriendRequests = Database::getPendingFriendRequests($dictionary['person']->getId(),7);
        $key=0;
        foreach($pendingFriendRequests as $pendingRequest){ ?>
            <form method='POST'>
                <?php
                    $nickname=$pendingRequest['pseudo'];
                    $id=$pendingRequest['id'];
                ?>
                <li>
                    <?php $nickname ?>
                    <button type='submit' name='submit' value='Session:requestTreatment:accept_key<?php echo $key; ?>'>Accepter</button>
                    <button type='submit' name='submit' value='Session:requestTreatment:refuse_key<?php echo $key; ?>'>Refuser</button>
                </li>
                <?php $keyString = 'key'.$key;
                    $_SESSION[$keyString]=$id;
                ?>
            </form>
            <?php
            $key++;
        }
?>