<tr>
<td> <?php echo $result['pseudo']; ?> </td>
<td> <?php echo $result['prenom']; ?> </td>
<td> <?php echo $result['nom']; ?> </td>
<?php $isAFriend = Database::verifyExistingRelationship($dictionary['person']->getId(), $result['id'])=='confirme';	
$idResult=$result['id'];		
if (!$isAFriend)
{ ?>
    <form method='POST'>
    <td> 
    <button type='submit' name='submit' value = "Session:addFriend:key<?php echo $key ?>">Ajouter un ami!</button>
    </td>
    <?php 
    $keyString = 'key'.$key;
    $_SESSION[$keyString]=$idResult;
    ?>
</form>	
<?php
}
else{ ?>
    <form method='POST'>
    <td> 
    <button type='submit' name='submit' value = "Session:messenger:key<?php echo $key ?>">Causer ac mon pote!</button> 
    </td>
    <?php
    $keyString = 'key'.$key;
    $_SESSION[$keyString]=$idResult;
    ?>
</form>	
<?php
}
$key++;
?>
</tr>