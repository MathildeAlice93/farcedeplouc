<tr>
<td> <?php echo $result['pseudo']; ?> </td>
<td> <?php echo $result['prenom']; ?> </td>
<td> <?php echo $result['nom']; ?> </td>
<?php $idResult=$result['id'];?>		

<form method='POST'>
<td> 
<button type='submit' name='submit' value = "Session:addFriendForConversation:key<?php echo $key ?>">Ajouter mon ami à la conversation</button>
</td>
<?php 
$keyString = 'key'.$key;
$_SESSION[$keyString]=$idResult;
?>
</form>	
<?php
$key++;
?>  
</tr>