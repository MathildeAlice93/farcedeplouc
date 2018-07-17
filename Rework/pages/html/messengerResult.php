<tr>
<td> <?php echo $result['pseudo']; ?> </td>
<td> <?php echo $result['prenom']; ?> </td>
<td> <?php echo $result['nom']; ?> </td>






<?php
//work in progress
$isAFriend = Database::verifyExistingRelationship($dictionary['person']->getId(), $result['id'])=='confirme';	
$existsConversation = Database::verifyConversationMembership($result['id']);
$idResult=$result['id'];		
if ($isAFriend and )
{
    include_once "addFriendButton.php"; 
}
else{
    include_once "talkWithButton.php"; 
}
$key++;
?>
</tr>