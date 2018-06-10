<!--TODO: séparéer PHP et HTML dans ce fichier? (open for discussion) -->
 <div class="container">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-4 well well-sm">
        <legend>
          <a href="">
            <i class="glyphicon glyphicon-globe"></i>
          </a> Rejoindre le clan !</legend>
        <form id="registration" method="POST" action="router.php" class="form" role="form">
          <div class="row">
            <div class="col-xs-6 col-md-6">
              <input class="form-control" name='prenom' id='prenom' placeholder="Ton prénom" type="text" autofocus />
            </div>
            <div class="col-xs-6 col-md-6">
              <input class="form-control" name='nom' id='nom' placeholder="Ton blaze" type="text" />
            </div>
          </div>
          <input class="form-control" name='pseudo' id='pseudo' placeholder="Ton pseudo" type="pseudo" />
          <input class="form-control" name='courriel' id='courriel' placeholder="Ton adresse email" type="email" />
          <input class="form-control" name='courriel_bis' id='courriel_bis' placeholder="Retape-là une seconde fois !" type="email"
          />
          <!--a adapter dans les fonctionnalités-->
          <input class="form-control" name='mot_de_passe' id='mot_de_passe' placeholder="Ton mot de passe TOP secret" type="password"
          />
          <label for="">Ton anniversaire</label>
          <!--a adapter dans les fonctionnalités-->
          <div class="row">
            <div class="col-xs-4 col-md-4">
              <select id='jour' name="jour" class="form-control">
                <option value="" disabled selected>Jour</option>
                <?php 
										for ($Day = 1; $Day <= 31; $Day++) {
											echo "<option id='jour_".$Day."' value='".$Day."' placeholder='Day'>".$Day."</option>";
										}
									?>
              </select>
            </div>
            <div class="col-xs-4 col-md-4">
              <select id='mois' name="mois" class="form-control">
                <option value="" disabled selected>Mois</option>
                <?php 
										for ($Month = 1; $Month <= 12; $Month++) {
											echo "<option id='mois_".$Month."' value='".$Month."'>".$Month."</option>";
										}
									?>
              </select>
            </div>
            <div class="col-xs-4 col-md-4">
              <select id='an' name="annee" class="form-control">
                <option value="" disabled selected>Année</option>
                <?php 
										for ($Year = date("Y"); $Year >= 1900; $Year--) {
											echo "<option id='annee_".$Year."' value='".$Year."'>".$Year."</option>";
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