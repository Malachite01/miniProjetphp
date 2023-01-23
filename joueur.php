<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <meta name="description" content="">
  <title>Gestion de l'équipe</title>
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

  //!AJOUT D'UN JOUEUR
  if (champRempli(array('champNom', 'champPrenom', 'champNumeroLicence', 'champDateDeNaissance', 'champTaille','champPoids'))) {
    if (isset($_POST['boutonValider'])) {
        if (joueurIdentique($_POST['champNumeroLicence']) == 0) {
          $image = uploadImage($_FILES['champPhoto']);
          if($image != null) {
              ajouterJoueur(
                $_POST['champNom'],
                $_POST['champPrenom'],
                $_POST['champNumeroLicence'],
                $image,
                $_POST['champDateDeNaissance'],
                $_POST['champTaille'],
                $_POST['champPoids'],
                $_POST['champPoste'],
                $_POST['champStatut'],
                $_POST['champCommentaires']
              );
              echo '
              <div class="validationPopup">
                <h2 class="txtPopup">Le joueur a bien ete ajoute a la base !</h2>
                <img src="images/valider.png" alt="valider" class="imageIcone centerIcon">
                <button class="boutonFermerPopup" onclick="erasePopup(\'validationPopup\')">Fermer X</button>
              </div>';
          } else {
              echo '
              <div class="erreurPopup">
                <h2 class="txtPopup">Erreur, image trop grande.</h2>
                <img src="images/annuler.png" alt="valider" class="imageIcone centerIcon">
                <button class="boutonFermerPopup" onclick="erasePopup(\'erreurPopup\')">Fermer X</button>
              </div>';
          }
        } else {
          echo'
          <div class="erreurPopup">
              <h2 class="txtPopup">Le joueur n\'a pas ete ajoute a la base car il existe deja.</h2>
              <img src="images/annuler.png" alt="valider" class="imageIcone centerIcon">
              <button class="boutonFermerPopup" onclick="erasePopup(\'erreurPopup\')">Fermer X</button>
          </div>';
        }
    }
  }
  //!SUPRESSION D'UN JOUEUR
  if (isset($_POST['boutonSupprimer'])) {
    supprimerJoueur($_POST['boutonSupprimer']);
    echo '
    <div class="supprPopup">
        <h2 class="txtPopup">Le joueur a ete supprime.</h2>
        <img src="images/bin.png" alt="image suppression" class="imageIcone centerIcon">
        <button class="boutonFermerPopup" onclick="erasePopup(\'supprPopup\')">Fermer X</button>
    </div>';
  };
  if (isset($_GET['params'])) {
    $err = clean($_GET['params']);
    if ($err == 'modif') {
      echo '
      <div class="editPopup">
        <h2 class="txtPopup">Le joueur a bien ete modifie !</h2>
        <img src="images/edit.png" alt="valider" class="imageIcone centerIcon">
        <button class="boutonFermerPopup" onclick="erasePopup(\'editPopup\')">Fermer X</button>
      </div>';
    }
  }

  //!MODIFIER LE JOUEUR DANS LA PAGE DE MODIFICATION JOUEUR
  if (isset($_POST['boutonEdit'])) {
    if ($_FILES['champPhoto']['name'] == "") {
      modifierJoueur(
        $_POST['hiddenImageLink'],
        $_POST['champNom'],
        $_POST['champPrenom'],
        $_POST['champNumeroLicence'],
        $_POST['champDateDeNaissance'],
        $_POST['champTaille'],
        $_POST['champPoids'],
        $_POST['champPoste'],
        $_POST['champStatut'],
        $_POST['champCommentaires'],
        $_POST['boutonEdit']
      );
    } else {
      $image = uploadImage($_FILES['champPhoto']);
      if ($image != null) {
        modifierJoueur(
          $image,
          $_POST['champNom'],
          $_POST['champPrenom'],
          $_POST['champNumeroLicence'],
          $_POST['champDateDeNaissance'],
          $_POST['champTaille'],
          $_POST['champPoids'],
          $_POST['champPoste'],
          $_POST['champStatut'],
          $_POST['champCommentaires'],
          $_POST['boutonEdit']
        );
        unlink($_POST['hiddenImageLink']);
      } else {
      echo '
      <div class="erreurPopup">
        <h2 class="txtPopup">Erreur, image trop grande.</h2>
        <img src="images/annuler.png" alt="valider" class="imageIcone centerIcon">
        <button class="boutonFermerPopup" onclick="erasePopup(\'erreurPopup\')">Fermer X</button>
      </div>';
      }
    }
  }

  ?>

  <h1>Gestion de l'equipe</h1>

  <div class="aCacher fenButtonOff transparent" id="formAjoutJoueur">
    <form id="form" method="POST" onsubmit="erasePopup('erreurPopup'),erasePopup('validationPopup')" enctype="multipart/form-data">
        <div class="miseEnForme" id="miseEnFormeFormulaire">
            <label for="champPhoto">Photo du joueur :</label>
            <input type="file" name="champPhoto" id="champPhoto" accept="image/png, image/jpeg, image/svg+xml, image/webp, image/bmp, image/gif" onchange="refreshImageSelector('champPhoto','imageJoueur')" required>
            <img src="images/placeholder.jpg" id="imageJoueur" alt=" ">

            <label for="champNom">Nom :</label>
            <input type="text" name="champNom" placeholder="Entrez le nom du joueur" minlength="1" maxlength="50" required>
            <span></span>

            <label for="champPrenom">Prenom :</label>
            <input type="text" name="champPrenom" placeholder="Entrez le prenom du joueur" minlength="1" maxlength="50" required>
            <span></span>

            <label for="champNumeroLicence">Numero de licence :</label>
            <input type="number" name="champNumeroLicence" placeholder="Entrez la licence du joueur" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" min="1" max="99999999999" onkeypress="limitKeypress(event,this.value,11)" required>
            <span></span>

            <label for="champDateDeNaissance">Date de naissance :</label>
            <input type="date" name="champDateDeNaissance" min="1900-01-01" max="<?php echo date('Y-m-d'); ?>" required>
            <span></span>

            <label for="champTaille">Taille :</label>
            <input type="number" name="champTaille" placeholder="Entrez la taille du joueur en cm" min="1" max="999" onkeypress="limitKeypress(event,this.value,3)" required>
            <span></span>

            <label for="champPoids">Poids :</label>
            <input type="number" name="champPoids" placeholder="Entrez le poids du joueur en kg" min="1" max="999" onkeypress="limitKeypress(event,this.value,3)" required>
            <span></span>

            <label for="champPoste">Poste :</label>
            <select name="champPoste" id="" required>
                <option value="">--Veuillez choisir un poste--</option>
                <option value="Passeur">Passeur</option>
                <option value="Receptionneur">Receptionneur</option>
                <option value="Attaquant">Attaquant</option>
                <option value="Central">Central</option>
                <option value="Libero">Libero</option>
            </select>
            <span></span>

            <label for="champStatut">Statut :</label>
            <div class="centerRadio" style="width: 100%;">
                <span class="center1Item">
                <input type="radio" name="champStatut" id="statA" value="Actif" checked required>
                <label for="statA" class="radioLabel" tabindex="0">Actif</label>
                </span>
                <span class="center1Item">
                <input type="radio" name="champStatut" id="statB" value="Blesse" required>
                <label for="statB" class="radioLabel" tabindex="0">Blesse</label>
                </span>
                <span class="center1Item">
                <input type="radio" name="champStatut" id="statS" value="Suspendu" required>
                <label for="statS" class="radioLabel" tabindex="0">Suspendu</label>
                </span>
                <span class="center1Item">
                <input type="radio" name="champStatut" id="statAbs" value="Absent" required>
                <label for="statAbs" class="radioLabel" tabindex="0">Absent</label>
                </span>
            </div>
            <span></span>

            <label for="champCommentaires">Commentaires :</label>
            <input type="text" name="champCommentaires" placeholder="Entrez un commentaire (optionnel)" minlength="0" maxlength="200">
            <span></span>
        </div>

            <div class="center" id="boutonsValiderAnnuler">
                <button type="button" name="boutonAnnuler" class="boutonAnnuler" id="boutonAnnuler" onclick="fenClose('aCacher')"><img src="images/annuler.png" class="imageIcone" alt="icone annuler"><span>Annuler</span></button>
                <button type="submit" name="boutonValider" class="boutonValider" id="boutonValider" formaction="joueur.php"><img src="images/valider.png" class="imageIcone" alt="icone valider"><span>Valider</span></button>
            </div>
    </form>
  </div>

  <form id="formGestionJoueur" method="POST">

  <button type="button" name="boutonAjouterEnfant" class="boutons boutonAjouterA" onclick="fenOpen('aCacher'),deCache('aCacher')"><span>Ajouter un joueur</span><img style="transform: rotate(-45deg);" src="images/annuler.png" class="imageIcone" alt="icone cadenas"></button>
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
        <th>Statistiques joueur</th>
        <th>Modifier</th>
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