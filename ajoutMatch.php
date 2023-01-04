<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <meta name="description" content="">
  <title>Ajout d'un match</title>
  <link rel="icon" type="image/x-icon" href="images/favicon.png">
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
  <link rel="stylesheet" href="style/style.css">
</head>
<script src="js/javascript.js"></script>
<?php
    require('FUNCTIONS.php');
?>

<body>
  <div class="svgWaveContains">
    <div class="svgWave"></div>
  </div>

  <?php faireMenu();?>

  <h1>Ajout d'un match</h1>

  <form id="form" method="POST" onsubmit="erasePopup('erreurPopup'),erasePopup('validationPopup')">
  <div class="miseEnForme" id="miseEnFormeFormulaire">

      <label for="champEquipe">Equipe affrontee :</label>
      <input type="text" name="champEquipe" placeholder="Entrez le nom de l'equipe affrontee" minlength="1" maxlength="50" required>
      <span></span>

      <label for="champDate">Date de debut:</label>
      <input type="datetime-local" name="champDate" placeholder="Entrez la date de debut du match" min="1900-01-01T00:00" max="<?php echo date('Y-m-d')."T00:00" ?>" required>
      <span></span>

      <label for="champLieu">Lieu de la rencontre :</label>
      <input type="text" name="champLieu" placeholder="Entrez le lieu de la rencontre" minlength="1" maxlength="50" required>
      <span></span>

      <label for="champResultat">Resultats (optionnel) :</label>
      <input type="text" name="champResultat" placeholder="Entrez les resultats Equipe-Adversaires: 00-00" min="5" max="5" onkeyup="this.value = scoreMatch(this.value);" oninput="this.value = this.value.replace(/[^0-9.-]/g, '').replace(/(\..*)\./g, '$1');">
      <span></span>
    </div>

    <div class="center" id="boutonsValiderAnnuler">
      <button type="reset" name="boutonAnnuler" class="boutonAnnuler"><img src="images/annuler.png" class="imageIcone" alt="icone annuler"><span>Annuler</span></button>
      <button type="submit" name="boutonValider" class="boutonValider" id="boutonValider"><img src="images/valider.png" class="imageIcone" alt="icone valider"><span>Valider</span></button>
    </div>
  </form>
  <script src="js/javascript.js"></script>
</body>

<?php
  if (champRempli(array('champDate', 'champEquipe', 'champLieu'))) {
    if (matchIdentique(
      $_POST['champDate'],
      $_POST['champEquipe'],
      $_POST['champLieu']
    ) == 0) {
      ajouterMatch(
        $_POST['champDate'],
        $_POST['champEquipe'],
        $_POST['champLieu'],
        $_POST['champResultat']
      );
      
      echo '
      <div class="validationPopup">
        <h2 class="txtPopup">Le match a bien ete ajoute a la base !</h2>
        <img src="images/valider.png" alt="valider" class="imageIcone centerIcon">
        <button class="boutonFermerPopup" onclick="erasePopup(\'validationPopup\')">Fermer X</button>
      </div>';
    } else {
      echo'
      <div class="erreurPopup">
        <h2 class="txtPopup">Le match n\'a pas ete ajoute a la base car il existe deja.</h2>
        <img src="images/annuler.png" alt="valider" class="imageIcone centerIcon">
        <button class="boutonFermerPopup" onclick="erasePopup(\'erreurPopup\')">Fermer X</button>
      </div>';
    }
  }
  
  ?>

</html>