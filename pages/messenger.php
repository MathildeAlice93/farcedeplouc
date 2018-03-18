<html>
<head>
	<title>Mes discussions</title>
	<!-- <LINK rel = stylesheet href = "style.css"/> -->
	<meta charset = "utf8"/>
	<meta name = "author" content = "Mathilde Alice Stiernet"/>
</head>
<body>
    <form method='POST'>
		<button type="submit" formaction = "router.php?handler=Session&action_du_plouc=default">Déconnexion</button>
	</form>

	<form method='POST'>
		<button type="submit" formaction = "router.php?handler=Session&action_du_plouc=zonmai">Retour</button>
	</form>
    <div>
        <form method="POST">
            <table>		
                <?php
                    foreach($affichage_conversations as $conversation){
                        echo '<tr>';
                        $affichage_membres_conversation = FarceDePloucDbUtilities::getMembresConversation($conversation['id']);
                        if(empty($conversation['titre']))
                        {
                            $les_membres = "";
                            $passed = false; 
                            foreach($affichage_membres_conversation as $membre)
                            {
                                $les_membres =$les_membres . ($passed ? ',' : '') . $membre['pseudo'];
                                $passed = true; 
                            } 
                            echo "<td>".$les_membres."</td>";
                        }
                        else
                        {
                            echo "<td>".$conversation['titre']."</td>";
                        }		
                        echo "<form method='POST'>";
                        echo "<td> <button type='submit' name='tralala' value = '".$conversation['id']."' formaction='router.php?handler=Session&action_du_plouc=switch_conversation'>Causer ac mon pote!</button> </td>";	
                        /*Pas nécessaire de changer le nom tralala en autre chose vu que de toute façon si j'affiche un des deux boutons l'autre ne sera pas affiché !*/
                        echo "</form>";	
                        echo '</tr>';
                    }
                    
                ?>
            </table>
        </form>
    </div>
    <div>
        <form method="POST">
            <label for="recherche">Ma recherche: </label>
            <input type="text" name="recherche" placeholder="Qui veux-tu trouver?"/> 
            <input type = "submit" name = "search_people_2" formaction = "router.php?handler=Session&action_du_plouc=recherche_pour_ajout_a_discu" value = "Lancer la recherche !" />
        </form>
        <?php
            if (isset($affichage_personne))
            {
                echo '<form method="POST">';
                    echo '<table>';
                        foreach($affichage_personne as $personne){
                            echo '<tr>';
                            echo "<td>".$personne['pseudo']."</td>";
                            echo "<td>".$personne['prenom']."</td>";
                            echo "<td>".$personne['nom']."</td>";
                            $test_amitie = FarceDePloucDbUtilities::verifyExistingRelationship($plouc_connecte->getId(), $personne['id']);			
                            if ($test_amitie){
                                echo "<form method='POST'>";
                                echo "<td> <button type='submit' name='tralala' value = '".$personne['id']."' formaction='router.php?handler=Session&action_du_plouc=ajouter_pote_dans_convers'>J'ajoute mon pote à la convers !</button> </td>";	
                                /*Pas nécessaire de changer le nom tralala en autre chose vu que de toute façon si j'affiche un des deux boutons l'autre ne sera pas affiché !*/
                                echo "</form>";	
                            }
                            echo '</tr>';
                        }   
                    echo '</table>';
                echo '</form>';
            }
        ?>
    </div>
    <div>
        <?php
            $previous_messages = $current_conversation->getMessages();
            if(isset($previous_messages))
            {
                foreach($previous_messages as $message)
                {
                    echo "<div>";
                    echo $message['pseudo'] . ": " . $message["contenu"] . " envoyé à " . $message['date_envoi'];
                    echo "</div>";
                }
            }
        ?>  
         <form method="POST">
            <textarea name="nouveau_message" placeholder="Que veux-tu raconter?" rows="3" cols="30"></textarea>
            <input type = "submit" name = "post_message" formaction = "router.php?handler=Session&action_du_plouc=poster_un_message" value = "Je cause!" />
        </form>
    </div>

</body>
</html> 