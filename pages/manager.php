<?php 
//Le manager connait toutes les pages du sites 
//Son rôle est de construire et renvoyer celles-ci.
//Le handler s'occupe quand à lui de gérer une session (un handler/session). 
class Manager 
{
    public static function connection(){
        $dictionary['title'] = "Page de connexion"; 
        $headSegmentsList[0] = "head.php";
        $bodySegmentsList[0] = "connection.html"; 
        $bodySegmentsList[1] = "inscription.php"; 
        $bodySegmentsList[2] = "scriptlinks.html";
        //Les scripts sont chargés vers la fin afin d'éviter que l'utilisateur ne puisse rien voir pdt le chargement de ceux-ci.
        $pageConnexion = new Page($headSegmentsList, $bodySegmentsList, $dictionary);
    }
    //On pourra déterminer plus tard si ça doit être public ou non

    public static function home(){
        $dictionary['title'] = "Journal"; 
        $dictionary['person'] = Session::getConnectedPerson(); 
        $dictionary['researchType']='researchPeople'; 
        $headSegmentsList[0] = "head.php"; 
        $bodySegmentsList[0]= "menu.php"; 
        $bodySegmentsList[1]="friends.php"; 
        $bodySegmentsList[2]="research.php"; 
        $bodySegmentsList[3]="pendingFriendRequests.php"; 
        $bodySegmentsList[4] = "scriptlinks.html";
        
        $pageConnexion = new Page($headSegmentsList, $bodySegmentsList, $dictionary);
    }

    public static function research($researchResults){
        $dictionary['title'] = "Recherche"; 
        $dictionary['results']= $researchResults; 
        $dictionary['person'] = Session::getConnectedPerson(); 
        $dictionary['include']="resultPeople.php"; 
        $dictionary['researchType']='researchPeople'; 
        $headSegmentsList[0] = "head.php"; 
        $bodySegmentsList[0]= "menu.php"; 
        $bodySegmentsList[1]="research.php";
        $bodySegmentsList[2]="results.php"; 
        $bodySegmentsList[3] = "scriptlinks.html";

        $pageConnexion = new Page($headSegmentsList, $bodySegmentsList, $dictionary);
    }

    public static function messenger($conversations, $researchResults=NULL){
        $dictionary['title'] = "Messenger"; 
        $dictionary['person'] = Session::getConnectedPerson(); 
        $dictionary['conversations'] = $conversations;
        if($researchResults!=NULL){
            $dictionary['include'] = 'resultFriendsForConversation.php'; 
            $bodySegmentsList[3]="results.php"; 
            $dictionary['results']= $researchResults; 
        }
        $dictionary['currentConversation']= Session::getCurrentConversation();
        $dictionary['researchType']='researchFriendsForConversation'; 
        $headSegmentsList[0] = "head.php"; 
        $bodySegmentsList[0]= "menu.php"; 
        $bodySegmentsList[1]="conversations.php";
        $bodySegmentsList[2]="research.php"; 
         
        $bodySegmentsList[4]="messenger.php"; 
        $bodySegmentsList[5] = "scriptlinks.html";

        $pageConnexion = new Page($headSegmentsList, $bodySegmentsList, $dictionary);
    }
}
?>