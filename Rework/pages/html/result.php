<tr>
<td> <?php $result['pseudo'] ?> </td>
<td> <?php $result['prenom'] ?> </td>
<td> <?php $result['nom'] ?> </td>
<?php $isAFriend = Database::verifyExistingRelationship($dictionary['person']->getId(), $result['id'])=='confirme';	
$idResult=$result['id'];		
if (!$isAFriend)
{
    include_once "addFriendButton.php"; 
}
else{
    include_once "talkWithButton.php"; 
}
$key++;
?>
</tr>