<html>
<head>
	<title>Mes discussions</title>
	<!-- <LINK rel = stylesheet href = "style.css"/> -->
	<meta charset = "utf8"/>
	<meta name = "author" content = "Mathilde Alice Stiernet"/>
</head>
<body>
    <?php
        if(isset($previous_message))
        {
            foreach($previous_message as $message)
            {
                echo "<div>";
                echo $message["contenu"];
                echo "</div>";
            }
        }
    ?>
</body>
</html> 