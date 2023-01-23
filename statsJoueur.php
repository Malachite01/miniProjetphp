<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <meta name="description" content="">
  <title>Statistiques d'un joueur</title>
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

  <form id="form" method="POST" onsubmit="erasePopup('erreurPopup'),erasePopup('validationPopup')" enctype="multipart/form-data">
    <?php
        if(isset($_POST['boutonConsulter'])) {
            $_SESSION['joueur'] = $_POST['boutonConsulter'];
        }
        afficherStatsUnJoueur($_SESSION['joueur']);
        $titulaire = selectionsTitulaire($_SESSION['joueur']);
        $remplacant = selectionsRemplacant($_SESSION['joueur']);
        $titulaire = json_encode($titulaire);
        $remplacant = json_encode($remplacant);
        if($titulaire > 0 || $remplacant > 0) {
            echo '<canvas id="pie-chart"></canvas>';
        } else {
            echo '<p class="msgSelection">Aucune statistiques sur les selections titulaire/remplacant</p>';
        }
    ?>
        <script>
        var value1 = <?php echo $titulaire ?>;
        var value2 = <?php echo $remplacant ?>;

        // Définir les données pour les sections du graphique
        var data = {
            labels: ['Sélections en tant que titulaire', 'Sélections en tant que remplaçant'],
            datasets: [{
                data: [value1, value2], // les valeurs en pourcentage
                backgroundColor: ['#8bc196', '#ff7474'],
                hoverBackgroundColor: ['#6aaf78', '#ff3333']
            }]
        };
        // Récupérer le conteneur pour le graphique
        var ctx = document.getElementById('pie-chart').getContext('2d');
        // Créer le graphique en forme de camembert
        var pieChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: {
                responsive: false
            }
        });
        </script>
  </form>
  
</body>
</html>