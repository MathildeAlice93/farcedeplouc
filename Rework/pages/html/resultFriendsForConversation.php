<tr>
<td> <?php echo $result['pseudo']; ?> </td>
<td> <?php echo $result['prenom']; ?> </td>
<td> <?php echo $result['nom']; ?> </td>
<?php $idResult=$result['id'];?>		

<form method='POST'>
<td> 
<button type='submit' name='submit' value = "Session:addFriendForConversation:person<?php echo $key ?>">Ajouter mon ami à la conversation</button>
</td>
<?php 
$keyString = 'person'.$key;
$_SESSION[$keyString]=$idResult;
?>
</form>	
<?php
$key++;
?>  
</tr>