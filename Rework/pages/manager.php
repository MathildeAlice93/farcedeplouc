<?php 
//Le manager connait toutes les pages du sites 
//Son rôle est de construire et renvoyer celles-ci.
//Le handler s'occupe quand à lui de gérer une session (un handler/session). 
class Manager 
{
    public static function connexion(){
        $headSegmentsList[0] = "head.html";
        $bodySegmentsList[0] = "connexion.html"; 
        $bodySegmentsList[1] = "inscription.html"; 
        $bodySegmentsList[2] = "scriptlinks.html";
        return new Page($headSegmentsList, $bodySegmentsList);
    }
    //On pourra déterminer plus tard si ça doit être public ou non




}
?>