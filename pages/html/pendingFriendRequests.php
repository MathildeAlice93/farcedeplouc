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
                    <?php echo $nickname; ?>
                    <button type='submit' name='submit' value='Session:friendRequestTreatment:accept_person<?php echo $key; ?>'>Accepter</button>
                    <button type='submit' name='submit' value='Session:friendRequestTreatment:refuse_person<?php echo $key; ?>'>Refuser</button>
                </li>
                <?php $keyString = 'person'.$key;
                    $_SESSION[$keyString]=$id;
                ?>
            </form>
            <?php
            $key++;
        }
?>