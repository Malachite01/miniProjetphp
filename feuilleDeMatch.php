<?php session_start();require('FUNCTIONS.php');testConnexion();?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <meta name="description" content="">
  <title>Feuille de match</title>
  <link rel="icon" type="image/x-icon" href="images/favicon.png">
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
  <link rel="stylesheet" href="style/style.css">
</head>

<body>
  <div class="svgWaveContains">
    <div class="svgWave"></div>
  </div>

  <?php 
  faireMenu();

  ?>

<h1>Feuille de match</h1>
<?php
    if(isset($_POST['boutonConsulter'])) {
        $_SESSION['match'] = $_POST['boutonConsulter'];
    }
    afficherUnMatchFeuille($_SESSION['match']);

    //!AJOUT A LA SELECTION
    if(isset($_POST['boutonValider'])) {
        ajouterJoueurASelection(
            $_POST['valeurJoueur'],
            $_SESSION['match'],
            $_POST['champNote'],
            $_POST['champRole']
        );
        echo '
        <div class="validationPopup">
            <h2 class="txtPopup">Le joueur a bien ete ajoute a la selection !</h2>
            <img src="images/valider.png" alt="valider" class="imageIcone centerIcon">
            <button class="boutonFermerPopup" onclick="erasePopup(\'validationPopup\')">Fermer X</button>
        </div>';
    }

    //!SUPPRIMER DE LA SELECTION
    if(isset($_POST['boutonSupprimer'])) {
        retirerJoueurASelection(
            $_POST['boutonSupprimer'],
            $_SESSION['match']
        );
        echo'
        <div class="erreurPopup">
            <h2 class="txtPopup">Le joueur a ete retire de la selection.</h2>
            <img src="images/annuler.png" alt="valider" class="imageIcone centerIcon">
            <button class="boutonFermerPopup" onclick="erasePopup(\'erreurPopup\')">Fermer X</button>
        </div>';
    }

?>

<!-- FORMULAIRE AJOUT A LA SELECTION -->
<div style="position: fixed;" class="aCacher fenButtonOff transparent">
    <form id="formAjoutFeuille" method="POST" onsubmit="erasePopup('erreurPopup'),erasePopup('validationPopup')">
        <div class="miseEnForme" id="miseEnFormeFormulaire">
            <label for="champRole">Statut :</label>
            <div class="centerRadio" style="width: 100%;">
                <span class="center1Item">
                <input type="radio" name="champRole" id="statS" value="1" required>
                <label for="statS" class="radioLabel" tabindex="0">Titulaire</label>
                </span>
                <span class="center1Item">
                <input type="radio" name="champRole" id="statAbs" value="0" required>
                <label for="statAbs" class="radioLabel" tabindex="0">Remplacant</label>
                </span>
            </div>
            <span></span>
            
            <label for="champNote">Note :</label>
            <input type="number" name="champNote" placeholder="Entrez la note du joueur" oninput="this.value = this.value.replace(/[^0-5.]/g, '').replace(/(\..*)\./g, '$1');" min="1" max="5" onkeypress="limitKeypress(event,this.value,1)" required>
            <span></span>
        </div>

        <div class="center" id="boutonsValiderAnnuler">
            <button type="button" name="boutonAnnuler" class="boutonAnnuler" id="boutonAnnuler" onclick="fenClose('aCacher'),deleteSelection()"><img src="images/annuler.png" class="imageIcone" alt="icone annuler"><span>Annuler</span></button>
            <button type="submit" name="boutonValider" class="boutonValider" id="boutonValider" formaction="feuilleDeMatch.php"><img src="images/valider.png" class="imageIcone" alt="icone valider"><span>Valider</span></button>
        </div>
    </form>
</div>

<!-- JOUEURS DEJA DANS LE MATCH -->
<form method="POST">
    <h3>Selection actuelle : </h3>
    
    <table>
        <thead>
            <th>Photo</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Taille</th>
            <th>Poids</th>
            <th>Commentaires</th>
            <th>Poste prefere</th>
            <th>Role pour le match</th>
            <th>Note pour le match</th>
        </thead>

        <tbody id="tbodyGererSelection">
            <?php
                if(MatchValide($_SESSION['match']) < 5) {
                    echo '<p class="msgSelection" style="display: inline;"><img src="images/warning.png" class="imageIcone" alt="icone consulter">Selection invalide car tous les postes necessaires ne sont pas occupés!</p>';
                }
                AfficherJoueursSelection($_SESSION['match']);
            ?>
        </tbody>
    </table>
</form>

<!-- JOUEURS DISPOS A L'AJOUT (pas blesse pas suspendu pas absent,pas dans un autre match au meme moment)-->
<form id="formGestionDispos" method="POST">
    <h3>Joueurs disponibles <?php if(compterJoueursIndispos() == 1){echo '(dont '.compterJoueursIndispos().' joueur indisponible)';} else if(compterJoueursIndispos() > 1) {echo '(dont '.compterJoueursIndispos().' joueurs indisponibles)';};?>: </h3>
    <table>
        <thead>
        <th>Photo</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Taille</th>
        <th>Poids</th>
        <th>Commentaires</th>
        <th>Poste prefere</th>
        <th>Note moyenne</th>
        <th>Ajouter a la selection</th>
        </thead>

        <tbody id="tbodyGererDispos">
        <?php
            AfficherJoueursDispos($_SESSION['match']);
        ?>  
        </tbody>
    </table>
</form>
</body>

</html>