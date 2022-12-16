<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <meta name="description" content="">
  <title>Gestion des joueurs</title>
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
    supprimerJoueur($_POST['boutonSupprimer']);
    header("Location: gestionJoueurs.php?params=suppr");
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
    }
  }
  ?>

  <h1>Gestion des joueurs</h1>

  <form id="formGestionJoueur" method="POST">

    <table>
      <thead>
        <th>Photo</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Numero de licence</th>
        <th>Date de naissance</th>
        <th>Taille</th>
        <th>Poids</th>
        <th>Poste prefere</th>
        <th>Statut</th>
        <th>Supprimer</th>
      </thead>

      <tbody id="tbodyGererJoueurs">
        <?php
          AfficherJoueurs();
        ?>  
      </tbody>
    </table>
  </form>
</body>

</html>