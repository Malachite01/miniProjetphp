<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <meta name="description" content="">
  <title>Statistiques de l'équipe</title>
  <link rel="icon" type="image/x-icon" href="images/favicon.png">
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
  <link rel="stylesheet" href="style/style.css">
</head>

<?php
    require('FUNCTIONS.php');
?>

<body>
  <div class="svgWaveContains">
    <div class="svgWave"></div>
  </div>

  <?php faireMenu();?>

  <h1>Statistiques de l'equipe</h1>

  <form id="form" method="POST" onsubmit="erasePopup('erreurPopup'),erasePopup('validationPopup')">
  <div class="miseEnForme" id="miseEnFormeFormulaire">
    
    <label for="champGagnes">Nombre de matchs gagnes :</label> 
    <div class="progress-bar">
      <div class="progress" style="width: 50%; background-color: #5cd65c;"></div><p class="percentage">50%</p>
    </div>
    <input type="text" name="champGagnes" onfocus="blur();"  onfocus="blur();" readonly>


    
    <label for="champPerdus">Nombre de matchs perdus :</label> 
    <div class="progress-bar">
      <div class="progress" style="width: 100%; background-color: #ff6666;"></div><p class="percentage">100%</p>
    </div>
    <input type="text" name="champPerdus" value="Perdus 8" onfocus="blur();" readonly>


    <label for="champBlesses">Nombre de joueurs blesses :</label>
    <input type="text" name="champBlesses"  onfocus="blur();" readonly>
    <span></span>

  </div>
  </form>
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