<tr>
<td> <?php echo $result['pseudo']; ?> </td>
<td> <?php echo $result['prenom']; ?> </td>
<td> <?php echo $result['nom']; ?> </td>
<?php $relationshipStatus = Database::verifyExistingRelationship($dictionary['person']->getId(), $result['id']);
$idResult=$result['id'];		
if (!($relationshipStatus == 'confirme' || $relationshipStatus =='en_attente'))
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
} else if ($relationshipStatus =='confirme'){ ?>
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
} else {
    echo "traitement demande en cours";     
}
$key++;
?>  
</tr>