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
										for ($day = 1; $day <= 31; $day++) {
											echo "<option id='jour_".$day."' value='".$day."' placeholder='Day'>".$day."</option>";
										}
									?>
              </select>
            </div>
            <div class="col-xs-4 col-md-4">
              <select id='mois' name="mois" class="form-control">
                <option value="" disabled selected>Mois</option>
                <?php 
										for ($month = 1; $month <= 12; $month++) {
											echo "<option id='mois_".$month."' value='".$month."'>".$month."</option>";
										}
									?>
              </select>
            </div>
            <div class="col-xs-4 col-md-4">
              <select id='an' name="annee" class="form-control">
                <option value="" disabled selected>Année</option>
                <?php 
										for ($year = date("Y"); $year >= 1900; $year--) {
											echo "<option id='annee_".$year."' value='".$year."'>".$year."</option>";
										}
									?>
              </select>
            </div>
          </div>
          <br />
          <br />
          <button type="submit" class="btn btn-lg btn-primary btn-block" name="submit" formaction=""
            value="Registration:inputValidation"> Inscription </button>
        </form>
      </div>
    </div>
  </div>
</div>