<?php 
    echo "Mes amis: "; 
?>
<select name="potes_du_plouc" size="1">
<?php
        $friends = Database::getRelatedPersonByStatus($dictionary['person']->getId(),'confirme',7);
        foreach($friends as $friend){
            $nickname=$friend['pseudo']; ?>
            <option value='$nickname'><?php echo $nickname; ?></option>
        <?php }
?>
</select>