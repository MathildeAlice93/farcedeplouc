<form method='POST'>
    <td> 
    <button type='submit' name='submit' value = "Session:messenger:key<?php $key ?>">Causer ac mon pote!</button> 
    </td>
    <?php
    $keyString = 'key'.$key;
    $_SESSION[$keyString]=$idResult;
    ?>
</form>	