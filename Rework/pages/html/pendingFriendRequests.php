<?php 
    echo "Amis en attente : "; 
        $pendingFriendRequests = Database::getPendingFriendRequests($dictionary['person']->getId(),7);
        $key=0;
        foreach($pendingFriendRequests as $pendingRequest){
            include_once "pages/html/pendingFriendRequest.php"; 
            $key++;
        }
?>