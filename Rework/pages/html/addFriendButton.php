<form method='POST'>
    <td> 
    <button type='submit' name='submit' value = "Session:addFriend:key<?php $key ?>">Ajouter un ami!</button>
    </td>
    <?php 
    $keyString = 'key'.$key;
    $_SESSION[$keyString]=$idResult;
    ?>
</form>	