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
<script src="js/chart.js"></script>

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
  <div class="miseEnForme stats" id="miseEnFormeFormulaire">

    <label for="champBlesses">Pourcentage de joueurs indisponibles :</label>
    <div class="progress-bar">
      <div class="progress" style="width: <?php echo round(compterJoueursIndispos()/nbJoueurs()*100);?>%; background-color: #ff6666;"></div><p class="percentage"><?php echo round(compterJoueursIndispos()/nbJoueurs()*100) ?>%</p>
    </div>
    <input type="text" name="champPerdus" value="<?php echo compterJoueursIndispos()?> Indispos" onfocus="blur();" readonly>
    <?php 
    $v = json_encode(VictoiresEquipe()); 
    $d = json_encode(DefaitesEquipe()); 
    $e = json_encode(EgalitesEquipe());
    echo '<canvas id="pie-chartStats"></canvas>';
    ?>
    <script>
        var value1 = <?php echo $v ?>;
        var value2 = <?php echo $d ?>;
        var value3 = <?php echo $e ?>;

        // Définir les données pour les sections du graphique
        var data = {
            labels: ['Nombre de victoires', 'Nombre de défaites', 'Nombre d\'égalités'],
            datasets: [{
                data: [value1, value2, value3], // les valeurs en pourcentage
                backgroundColor: ['#8bc196', '#ff7474', '#ffa64d'],
                hoverBackgroundColor: ['#6aaf78', '#ff3333', '#e67300']
            }]
        };
        // Récupérer le conteneur pour le graphique
        var ctx = document.getElementById('pie-chartStats').getContext('2d');
        // Créer le graphique en forme de camembert
        var pieChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: {
                responsive: false
            }
        });
      </script>
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