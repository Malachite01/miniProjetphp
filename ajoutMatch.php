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

  <form id="form" method="POST" onsubmit="erasePopup('erreurPopup'),erasePopup('validationPopup')" enctype="multipart/form-data">
  <div class="miseEnForme" id="miseEnFormeFormulaire">
      <label for="champPhoto">Photo du joueur :</label>
      <input type="file" name="champPhoto" id="champPhoto" accept="image/png, image/jpeg, image/svg+xml, image/webp, image/bmp" onchange="refreshImageSelector('champPhoto','imageJoueur')" required>
      <img src="images/placeholder.jpg" id="imageJoueur" alt=" ">

      <label for="champNom">Nom :</label>
      <input type="text" name="champNom" placeholder="Entrez le nom du joueur" minlength="1" maxlength="50" required>
      <span></span>

      <label for="champPrenom">Prenom :</label>
      <input type="text" name="champPrenom" placeholder="Entrez le prenom du joueur" minlength="1" maxlength="50" required>
      <span></span>

      <label for="champNumeroLicence">Numero de licence :</label>
      <input type="number" name="champNumeroLicence" placeholder="Entrez la licence du joueur" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" min="1" max="9999999999999" onkeypress="limitKeypress(event,this.value,11)" required>
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
      <button type="reset" name="boutonAnnuler" class="boutonAnnuler"><img src="images/annuler.png" class="imageIcone" alt="icone annuler"><span>Annuler</span></button>
      <button type="submit" name="boutonValider" class="boutonValider" id="boutonValider"><img src="images/valider.png" class="imageIcone" alt="icone valider"><span>Valider</span></button>
    </div>
  </form>
  <script src="js/javascript.js"></script>
</body>

<?php
  if (champRempli(array('champNom', 'champPrenom', 'champNumeroLicence', 'champDateDeNaissance', 'champTaille','champPoids'))) {
    if (joueurIdentique(
      $_POST['champNom'],
      $_POST['champPrenom'],
      $_POST['champNumeroLicence'],
      $_POST['champDateDeNaissance']
    ) == 0) {
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
  
  ?>

</html>