<html>
<head>
	<title>Mes discussions</title>
	<!-- <LINK rel = stylesheet href = "style.css"/> -->
	<meta charset = "utf8"/>
	<meta name = "author" content = "Mathilde Alice Stiernet"/>
</head>
<body>
    <?php
        $previous_messages = $current_conversation->getMessages();
        if(isset($previous_messages))
        {
            foreach($previous_messages as $message)
            {
                echo "<div>";
                echo $message["contenu"];
                echo "</div>";
            }
        }
    ?>
    <form method="POST">
        <textarea name="nouveau_message" placeholder="Que veux-tu raconter?" rows="3" cols="30"></textarea>
        <input type = "submit" name = "post_message" formaction = "router.php?handler=Session&action_du_plouc=poster_un_message" value = "Je cause!" />
	</form>

</body>
</html> 