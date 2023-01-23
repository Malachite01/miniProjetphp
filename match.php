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

<?php
    require('FUNCTIONS.php');
?>

<body>
  <div class="svgWaveContains">
    <div class="svgWave"></div>
  </div>

  <?php 
  faireMenu();

  //!AJOUT
if (isset($_POST['boutonValider'])) {
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
}

  //!SUPRESSION
  if (isset($_POST['boutonSupprimer'])) {
    supprimerMatch($_POST['boutonSupprimer']);
    echo '
    <div class="supprPopup">
        <h2 class="txtPopup">Le match a ete supprime.</h2>
        <img src="images/bin.png" alt="image suppression" class="imageIcone centerIcon">
        <button class="boutonFermerPopup" onclick="erasePopup(\'supprPopup\')">Fermer X</button>
    </div>';
  };
  if (isset($_GET['params'])) {
    $err = clean($_GET['params']);
    if ($err == 'modif') {
      echo '
      <div class="editPopup">
        <h2 class="txtPopup">Le match a bien ete modifie !</h2>
        <img src="images/edit.png" alt="valider" class="imageIcone centerIcon">
        <button class="boutonFermerPopup" onclick="erasePopup(\'editPopup\')">Fermer X</button>
      </div>';
    }
  }

  //!MODIFIER LE JOUEUR DANS LA PAGE DE MODIFICATION JOUEUR
  if (isset($_POST['boutonEdit'])) {
    modifierMatch(
      $_POST['champEquipe'],
      $_POST['champDate'],
      $_POST['champLieu'],
      $_POST['champResultat'],
      $_POST['boutonEdit']
    );
  }

  //!VALIDER LE SCORE (aussi possible dans la modification)
  if (isset($_POST['boutonResultats'])) {
    $inputName = $_POST['boutonResultats'];
    if($_POST[$inputName] == 0 || $_POST[$inputName] == null) {
      echo '
      <div class="alertPopup">
          <h2 class="txtPopup">Attention, au volley il n\'y a pas de matchs nuls!</h2>
          <img src="images/annuler.png" alt="valider" class="imageIcone centerIcon">
          <button class="boutonFermerPopup" onclick="erasePopup(\'alertPopup\')">Fermer X</button>
      </div>';
    } else {
      entrerResultats(
        $_POST[$inputName],
        $_POST['boutonResultats']
      );
    }
    
  }

  ?>

  <h1>Gestion des matchs</h1>

<div class="aCacher fenButtonOff transparent" id="formAjoutJoueur">
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

            <label for="champResultat">Score (optionnel) :</label>
            <input type="text" name="champResultat" placeholder="Entrez le score Equipe-Adversaires: 00-00" min="5" max="5" onkeyup="this.value = scoreMatch(this.value);" oninput="this.value = this.value.replace(/[^0-9.-]/g, '').replace(/(\..*)\./g, '$1');">
            <span></span>
        </div>
        <div class="center" id="boutonsValiderAnnuler">
            <button type="button" name="boutonAnnuler" class="boutonAnnuler" id="boutonAnnuler" onclick="fenClose('aCacher')"><img src="images/annuler.png" class="imageIcone" alt="icone annuler"><span>Annuler</span></button>
            <button type="submit" name="boutonValider" class="boutonValider" id="boutonValider" formaction="match.php"><img src="images/valider.png" class="imageIcone" alt="icone valider"><span>Valider</span></button>
        </div>
    </form>
</div>

  <form id="formGestionMatchs" method="POST">
      
    <button type="button" name="boutonAjouterEnfant" class="boutons boutonAjouterA" onclick="fenOpen('aCacher'),deCache('aCacher')"><span>Ajouter un match</span><img style="transform: rotate(-45deg);" src="images/annuler.png" class="imageIcone" alt="icone cadenas"></button>
    <table>
      <thead>
        <th>Nom des adversaires</th>
        <th>Date du match</th>
        <th>Lieu de rencontre</th>
        <th>Score final (Nombre de sets gagnants)</th>
        <th>Feuille de match</th>
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