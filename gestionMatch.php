<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <meta name="description" content="">
  <title>Gestion des matchs</title>
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

  <?php 
  faireMenu();
  if (isset($_POST['boutonSupprimer'])) {
    supprimerMatch($_POST['boutonSupprimer']);
    header("Location: gestionMatch.php?params=suppr");
  };
  if (isset($_GET['params'])) {
    $err = clean($_GET['params']);
    if ($err == 'suppr') {
      echo '
        <div class="supprPopup">
          <h2 class="txtPopup">Le joueur a ete supprime.</h2>
          <img src="images/bin.png" alt="image suppression" class="imageIcone centerIcon">
          <button class="boutonFermerPopup" onclick="erasePopup(\'supprPopup\')">Fermer X</button>
        </div>';
    } else if ($err == 'modif') {
      echo '
      <div class="editPopup">
        <h2 class="txtPopup">Le joueur a bien ete modifie !</h2>
        <img src="images/edit.png" alt="valider" class="imageIcone centerIcon">
        <button class="boutonFermerPopup" onclick="erasePopup(\'editPopup\')">Fermer X</button>
      </div>';
    }
  }

  //MODIFIER LE JOUEUR DANS LA PAGE DE MODIFICATION JOUEUR
  if (isset($_POST['boutonValider'])) {
    modifierMatch(
      $_POST['champEquipe'],
      $_POST['champDate'],
      $_POST['champLieu'],
      $_POST['champResultat'],
      $_POST['boutonValider']
    );
  }

  ?>

  <h1>Gestion des matchs</h1>

  <form id="formGestionMatchs" method="POST">

    <table>
      <thead>
        <th>Nom des adversaires</th>
        <th>Date du match</th>
        <th>Lieu de rencontre</th>
        <th>Resultats</th>
        <th>Modifier</th>
        <th>Supprimer</th>
      </thead>

      <tbody id="tbodyGererMatchs">
        <?php
          AfficherMatchs();
        ?>  
      </tbody>
    </table>
  </form>
</body>

</html>