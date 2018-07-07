<?php 
    echo "Mes amis: "; 
?>
<select name="potes_du_plouc" size="1">
<?php
        $friends = Database::getRelatedPersonByStatus($dictionary['person']->getId(),'confirme',7);
        foreach($friends as $friend){
            $nickname=$friend['pseudo'];
            echo "<option value='$nickname'>$nickname</option>"; 
        }
?>
</select>