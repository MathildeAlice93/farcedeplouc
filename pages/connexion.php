<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp"
        crossorigin="anonymous">
    <style type="text/css">
        .redimension {
            width: 200px;
            height: 50px;
            float: left;
            margin-top: 7px;
        }

        .well {
            background: rgba(0, 0, 0, 0.3);
        }

        .fixedHeight {
            height: 50px;
        }
    </style>
    <script>
        function erreurMail(){
            var elemCBis = document.getElementById('courriel_bis');
            elemCBis.style.backgroundColor = "red";
        }
    </script>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-9 col-sm-4 col-md-4">
                        <img class="img-responsive" src="images/fardeplo.png"/></img>
                    </div>
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <form id="signin" class="navbar-form navbar-right" role="form" method="POST" action="router.php">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-user"></i>
                                </span>
                                <input id="connect_email" class="form-control" name="connect_email" value="" placeholder="Courriel"> <!-- type="email" -->
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-lock"></i>
                                </span>
                                <input id="connect_mot_de_passe" type="password" class="form-control" name="connect_mot_de_passe" value="" placeholder="Code secret">
                            </div>
                            <input type="submit" class="btn btn-primary" name="connexion" formaction="router.php?handler=Session&action_du_plouc=connexion"
                                value="Le clan me manque" />
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <div class="container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 well well-sm">
                    <legend>
                        <a href="">
                            <i class="glyphicon glyphicon-globe"></i>
                        </a> Rejoindre le clan !</legend>
                    <form method="POST" action="router.php" class="form" role="form">
                        <div class="row">
                            <div class="col-xs-6 col-md-6">
                                <input class="form-control" name='prenom' id='prenom' placeholder="Ton prénom" type="text" required autofocus />
                            </div>
                            <div class="col-xs-6 col-md-6">
                                <input class="form-control" name='nom' id='nom' placeholder="Ton blaze" type="text" required />
                            </div>
                        </div>
                        <input class="form-control" name='pseudo' id='pseudo' placeholder="Ton pseudo" type="pseudo" />
                        <input class="form-control" name='courriel' id='courriel' placeholder="Ton adresse email" type="email" />
                        <input class="form-control" name='courriel_bis' id='courriel_bis' placeholder="Retape-là une seconde fois !" type="email" />
                        <!--a adapter dans les fonctionnalités-->
                        <input class="form-control" name='mot_de_passe' id='mot_de_passe' placeholder="Ton mot de passe TOP secret" type="password"
                        />
                        <label for="">Ton anniversaire</label>
                        <!--a adapter dans les fonctionnalités-->
                        <div class="row">
                            <div class="col-xs-4 col-md-4">
                                <select name="jour" class="form-control">
                                    <option value="" disabled selected>Jour</option>
                                        <?php 
                                            for ($Day = 1; $Day <= 31; $Day++) {
                                                echo "<option value='".$Day."' placeholder='Day'>".$Day."</option>";
                                            }
                                        ?>
                                </select>
                            </div>
                            <div class="col-xs-4 col-md-4">
                                <select name="mois" class="form-control">
                                    <option value="" disabled selected>Mois</option>
                                        <?php 
                                            for ($Month = 1; $Month <= 12; $Month++) {
                                                echo "<option value='".$Month."'>".$Month."</option>";
                                            }
                                        ?>
                                </select>
                            </div>
                            <div class="col-xs-4 col-md-4">
                                <select name="annee" class="form-control">
                                    <option value="" disabled selected>Année</option>
                                        <?php 
                                            for ($Year = 1900; $Year <= date("Y"); $Year++) {
                                                echo "<option value='".$Year."'>".$Year."</option>";
                                            }
                                        ?>
                                </select>
                            </div>
                        </div>
                        <br />
                        <br />
                        <input type="submit" class="btn btn-lg btn-primary btn-block" name="registration" formaction="router.php?handler=Registration"
                            value="Je deviens plouc !" />
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
</body>

</html>