<form method='POST'>
    <?php
        $nickname=$pendingRequest['pseudo'];
        $id=$pendingRequest['id'];
    ?>
    <li>
        <?php $nickname ?>
        <button type='submit' name='submit' value='Session:requestTreatment:accept_key<?php $key ?>'>Accepter</button>
        <button type='submit' name='submit' value='Session:requestTreatment:refuse_key<?php $key ?>'>Refuser</button>
    </li>
    <?php $keyString = 'key'.$key;
        $_SESSION[$keyString]=$id;
    ?>
</form>