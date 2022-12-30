<?php

// requete pour verifier qu'un joeur avec les données en parametre n'existe pas deja dans la BD
$qJoueurIdentique = 'SELECT Nom, Prenom,Numero_Licence, Date_Naissance FROM joueur 
                    WHERE Nom = :nom AND Prenom = :prenom AND Numero_Licence = :numeroLicence AND Date_Naissance = :dateNaissance';

// requete pour ajouter un joeur a la BD
$qAjouterJoueur = 'INSERT INTO joueur (Nom,Prenom,Numero_Licence,Photo,Date_Naissance,Taille,Poids,Poste_Prefere,Statut,Commentaires) 
                    VALUES (:nom , :prenom, :numeroLicence,:photo,:dateNaissance, :taille, :poids,:postePrefere, :statut, :commentaires)';

$qAfficherJoueurs = 'SELECT Id_Joueur, Photo, Nom, Prenom, Numero_Licence, Date_Naissance, Taille, Poids, Poste_Prefere, Statut FROM joueur';

$qAfficherUnJoueur = 'SELECT Id_Joueur, Photo, Nom, Prenom, Numero_Licence, Date_Naissance, Taille, Poids, Poste_Prefere, Statut, Commentaires FROM joueur WHERE Id_Joueur = :idJoueur';

// requete pour supprimer un membre de la BD
$qSupprimerJoueur = 'DELETE FROM joueur WHERE Id_Joueur = :idJoueur';

// requete pour recuperer l'image d'un joueur 
$qRecupererImageJoueur = 'SELECT Photo FROM joueur WHERE Id_Joueur = :idJoueur';

//requete de modification d'un joueur
$qModifierInformationsJoueur = 'UPDATE joueur SET Photo = :photo, Nom = :nom, Prenom = :prenom, Numero_Licence = :numeroLicence, Date_Naissance = :dateNaissance, Taille = :taille, Poids = :poids, Poste_Prefere = :postePrefere, Statut = :statut, Commentaires = :commentaires WHERE Id_Joueur = :idJoueur';

$qSupprimerImageJoueur = 'SELECT Photo from joueur WHERE Id_Joueur = :idJoueur';

function connexionBd()
{
    $SERVER = '127.0.0.1';
    $DB = 'miniprojetphp';
    $LOGIN = 'root';
    $MDP = '';
    // tentative de connexion a la BD
    try {
        // connexion a la BD
        $linkpdo = new PDO("mysql:host=$SERVER;dbname=$DB", $LOGIN, $MDP);
    } catch (Exception $e) {
        die('Erreur ! Probleme de connexion a la base de donnees' . $e->getMessage());
    }
    return $linkpdo;
}

    
function faireMenu()
{
    testConnexion();
    // $effacer = ["/leSite/", ".php", "?params=suppr"];
    // $get_url = str_replace($effacer, "", $_SERVER['REQUEST_URI']);
    $get_url = $_SERVER['REQUEST_URI'];
    $idAChercher = "";
    if (stripos($get_url, "joueur")) {
        $idAChercher = "Joueurs";
    } else if (stripos($get_url, "match")) {
        $idAChercher = "Matchs";
    } 
    echo
    '
    <nav class="navbar">
        <div class="fondMobile"></div>
        <a href="#"><img src="images/logo.png" alt="logo" class="logo"></a>
        
        <div class="nav-links">
          <ul class="nav-ul">
            
            <li><a id="Joueurs">Joueurs</a>
                <ul class="sousMenu">
                    <li><a href="ajoutJoueur.php" >Ajouter un joueur</a></li>
                    <li><a href="gestionJoueurs.php" >Gerer les joueurs</a></li>
                </ul>
            </li>        
            
            <div class="separateur"></div>
            
            <li><a id="Matchs">Matchs</a>
                <ul class="sousMenu">
                    <li><a href="ajoutMatch.php">Ajouter un match</a></li>
                    <li><a href="gestionMatch.php">Gerer les matchs</a></li>
                    <li><a href="finDeMatch.php">Fin de match</a></li>
                </ul>
            </li>
            
          </ul>
        </div>
        
        <img src="images/menu.png" onclick="menuMobile(\'nav-links\')" alt="barre de menu" class="menu-hamburger">
        
    </nav>';

    echo '
    <script>
        var elementActif = document.querySelector("#' . $idAChercher . '");
        elementActif.classList.add("active");
    </script>';
}

function clean($champEntrant)
{
    $champEntrant = strip_tags($champEntrant); // permet d'enlever les balises html, xml, php
    $champEntrant = htmlspecialchars($champEntrant); // permet de transformer les balises html en *String
    return $champEntrant;
}

function psswdHash($mdp)
{
    $code = $mdp . "C3cI eSt lE h4sH dU M0t dE p4S5e !";
    return password_hash($code, PASSWORD_DEFAULT);
}

function testConnexion()
{
    session_start();
    if ($_SESSION['estConnecte'] == null) {
        header('Location: index.php');
    }
    $get_url = $_SERVER['REQUEST_URI'];
    if (stripos($get_url, "upload")) {
        header('Location: index.php');
    }
}

//!AJOUTER UN JOUEUR

function champRempli($field)
{
    // parcoure la liste des champs 
    foreach ($field as $name) {
        // vérifie s'ils sont vides 
        if (empty($_POST[$name])) {
            return false; // au moins un champs vides
        }
    }
    return true; // champs remplis
}

function joueurIdentique($nom, $prenom, $numeroLicence, $dateNaissance)
{
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qJoueurIdentique']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour verifier si un joueur existe deja');
    }
    // execution de la requete sql
    $req->execute(array(
        ':nom' => clean($nom),
        ':prenom' => clean($prenom),
        ':numeroLicence' =>($numeroLicence),
        ':dateNaissance' => clean($dateNaissance)
    ));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors l\'execution de la requete pour verifier si un joueur existe deja');
    }
    return $req->rowCount(); // si ligne > 0 alors joueur deja dans la BD
}

function ajouterJoueur($nom, $prenom, $numeroLicence, $photo, $dateNaissance, $taille, $poids, $poste,$statut,$commentaires)
{

    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qAjouterJoueur']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour ajouter un joueur a la BD');
    }
    // execution de la requete sql
    $req->execute(array(
        ':nom' => clean($nom),
        ':prenom' => clean($prenom),
        ':numeroLicence' => clean($numeroLicence),
        ':photo' => clean($photo),
        ':dateNaissance' => clean($dateNaissance),
        ':taille' => clean($taille),
        ':poids' => clean($poids),
        ':postePrefere' => clean($poste),
        ':statut' => clean($statut),
        ':commentaires' => clean($commentaires)
    ));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors l\'execution de la requete pour ajouter un joueur a la BD');
    }
}

function uploadImage($photo)
{
    if (isset($photo)) {
        $tmpName = $photo['tmp_name'];
        $name = $photo['name'];
        $size = $photo['size'];
        $error = $photo['error'];

        $tabExtension = explode('.', $name);
        $extension = strtolower(end($tabExtension));

        $extensions = ['jpg', 'png', 'jpeg', 'gif', 'svg', 'webp', 'bmp'];
        $maxSize = 4000000;

        if (in_array($extension, $extensions) && $size <= $maxSize && $error == 0) {

            $uniqueName = uniqid('', true);
            //uniqid génère quelque chose comme ca : 5f586bf96dcd38.73540086
            $file = $uniqueName . "." . $extension;
            $chemin = "upload/";
            //$file = 5f586bf96dcd38.73540086.jpg
            move_uploaded_file($tmpName, 'upload/' . $file);
            $result = $chemin . $file;
        }
    } else {
        echo '<h1>erreur</h1>';
    }
    if (!isset($result)) {
        return null;
    }
    return $result;
}

function AfficherJoueurs() {
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qAfficherJoueurs']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour afficher les informations des joueurs');
    }
    // execution de la requete sql
    $req->execute();
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour afficher les informations des joueurs');
    }
    // permet de parcourir toutes les lignes de la requete
    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        // permet de parcourir toutes les colonnes de la requete
        foreach ($data as $key => $value) {
            // recuperation valeurs importantes dans des variables
            if ($key == 'Id_Joueur') {
                $idJoueur = $value;
            }
            if($key == 'Photo') {
                echo '<td><img class="imageJoueurGestion" src="' . $value . '" alt="photo du joueur"></td>';
            }
            // selectionne toutes les colonnes $key necessaires
            if ($key == 'Nom' || $key == 'Prenom' || $key == 'Numero_Licence' || $key == 'Poste_Prefere' || $key == 'Statut') {
                echo '<td>' . $value . '</td>';
            }
            if ($key == 'Date_Naissance') {
                echo '<td>' . date('d/m/Y', strtotime($value)) . '</td>';
            }
            if( $key == 'Taille') {
                echo '<td>' . $value . 'cm </td>';
            }
            if( $key == 'Poids') {
                echo '<td>' . $value . 'kg </td>';
            }
        }
        echo '
            <td>
                <button type="submit" name="boutonModifier" value="' . $idJoueur . '" class="boutonModifier" formaction="modifierJoueur.php">
                    <img src="images/edit.png" class="imageIcone" alt="icone modifier">
                    <span>Modifier</span>
                </button>
            </td>
            <td>
                <button type="submit" name="boutonSupprimer" value="' . $idJoueur . '
                " class="boutonSupprimer" onclick="return confirm(\'Êtes vous sûr de vouloir supprimer ce membre ?\');" >
                    <img src="images/bin.png" class="imageIcone" alt="icone supprimer">
                    <span>Supprimer</span>
                </button>
            </td>
        </tr>';
    }
}

function AfficherImageJoueur($idJoueur) {
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qRecupererImageJoueur']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour recuperer la photo d\'un joueur ');
    }
    // execution de la requete sql
    $req->execute(array(
        ':idJoueur' => clean($idJoueur)
    ));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de l\'execution de la requete pour recuperer la photo d\'un joueur ');
    }
    // permet de parcourir toutes les lignes de la requete
    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
        // permet de parcourir toutes les colonnes de la requete
        foreach ($data as $key => $value) {
            // selectionne toutes les colonnes $key necessaires
            if ($key == 'Photo') {
                $image = $value;
            }
        }
        return $image;
    }
}

function afficherUnJoueur($idJoueur) {
    
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qAfficherUnJoueur']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour ajouter un membre a la BD');
    }
    // execution de la requete sql
    $req->execute(array(':idJoueur' => clean($idJoueur)));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de l\'execution de la requete pour ajouter un membre a la BD');
    }
    // permet de parcourir la ligne de la requetes 
    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
        // permet de parcourir toutes les colonnes de la requete 
        foreach ($data as $key => $value) {
            // recuperation de toutes les informations du membre de la session dans des inputs 
            if ($key == 'Photo') {
                echo '
                <label for="champPhoto">Photo du joueur :</label>
                <input type="file" name="champPhoto" id="champPhoto" accept="image/png, image/jpeg, image/svg+xml, image/webp, image/bmp" onchange="refreshImageSelector(\'champPhoto\',\'imageJoueur\')">
                <img src="' . AfficherImageJoueur($idJoueur) . '" id="imageJoueur" alt="image du joueur">
                ';
                echo '<input type="hidden" value="' . AfficherImageJoueur($idJoueur) . '" name="hiddenImageLink">';
            } elseif ($key == 'Nom') {
                echo'
                <label for="champNom">Nom :</label>
                <input type="text" name="champNom" placeholder="Entrez le nom du joueur" minlength="1" maxlength="50" value="'.$value.'" required>
                <span></span>
                ';
            } elseif ($key == 'Prenom'){
                echo '
                <label for="champPrenom">Prenom :</label>
                <input type="text" name="champPrenom" placeholder="Entrez le prenom du joueur" minlength="1" maxlength="50" value="'.$value.'" required>
                <span></span>';
            } elseif ($key == 'Numero_Licence'){
                echo '
                <label for="champNumeroLicence">Numero de licence :</label>
                <input type="number" name="champNumeroLicence" placeholder="Entrez la licence du joueur" oninput="this.value = this.value.replace(/[^0-9.]/g, \'\').replace(/(\..*)\./g, \'$1\');" min="1" max="9999999999999" onkeypress="limitKeypress(event,this.value,11)" value="'.$value.'" required>
                <span></span>';
            } elseif ($key == 'Date_Naissance'){
                echo '
                <label for="champDateDeNaissance">Date de naissance :</label>
                <input type="date" name="champDateDeNaissance" min="1900-01-01" max="<?php echo date(\'Y-m-d\'); ?>" value="'.$value.'" required>
                <span></span>';
            } elseif ($key == 'Taille'){
                echo '
                <label for="champTaille">Taille :</label>
                <input type="number" name="champTaille" placeholder="Entrez la taille du joueur en cm" min="1" max="999" onkeypress="limitKeypress(event,this.value,3)" value="'.$value.'" required>
                <span></span>';
            } elseif ($key == 'Poids'){
                echo '
                <label for="champPoids">Poids :</label>
                <input type="number" name="champPoids" placeholder="Entrez le poids du joueur en kg" min="1" max="999" onkeypress="limitKeypress(event,this.value,3)" value="'.$value.'" required>
                <span></span>';
            } elseif ($key == 'Poste_Prefere'){
                echo '
                <label for="champPoste">Poste :</label>
                <select name="champPoste" id="" required>';
                if($value == "Passeur"){echo '<option value="Passeur" selected>Passeur</option>';} else {echo '<option value="Passeur">Passeur</option>';};
                if($value == "Receptionneur"){echo '<option value="Receptionneur" selected>Receptionneur</option>';} else {echo '<option value="Receptionneur">Receptionneur</option>';};
                if($value == "Attaquant"){echo '<option value="Attaquant" selected>Attaquant</option>';} else {echo '<option value="Attaquant">Attaquant</option>';};
                if($value == "Central"){echo '<option value="Central" selected>Central</option>';} else {echo '<option value="Central">Central</option>';};
                if($value == "Libero"){echo '<option value="Libero" selected>Libero</option>';} else {echo '<option value="Libero">Libero</option>';};
                echo '
                </select>
                <span></span>
                ';
            } elseif ($key == 'Statut') {
                echo '
                <label for="champStatut">Statut :</label>
                <div class="centerRadio" style="width: 100%;">
                <span class="center1Item">
                    <input type="radio" name="champStatut" id="statA" value="Actif" checked required';
                    if ($value == "Actif") echo ' checked>';
                    else echo '>';
                    echo '<label for="statA" class="radioLabel" tabindex="0">Actif</label>
                </span>
                <span class="center1Item">
                    <input type="radio" name="champStatut" id="statB" value="Blesse" required';
                    if ($value == "Blesse") echo ' checked>';
                    else echo '>';
                    echo' <label for="statB" class="radioLabel" tabindex="0">Blesse</label>
                </span>
                <span class="center1Item">
                    <input type="radio" name="champStatut" id="statS" value="Suspendu" required';
                    if ($value == "Suspendu") echo ' checked>';
                    else echo '>';
                    echo '<label for="statS" class="radioLabel" tabindex="0">Suspendu</label>
                </span>
                <span class="center1Item">
                    <input type="radio" name="champStatut" id="statAbs" value="Absent" required';
                    if ($value == "Absent") echo ' checked>';
                    else echo '>';
                    echo '<label for="statAbs" class="radioLabel" tabindex="0">Absent</label>
                </span>
                </div>
                <span></span>                
                ';
            } elseif ($key == 'Commentaires') {
                echo '
                <label for="champCommentaires">Commentaires :</label>
                <input type="text" name="champCommentaires" placeholder="Entrez un commentaire (optionnel)" minlength="0" maxlength="200" value="'.$value.'">
                <span></span>
                ';
            }
        }
    }
}

// fonction qui permet de modifier un joueur de la BD
function modifierJoueur($photo, $nom, $prenom, $numeroLicence, $dateNaissance, $taille, $poids, $postePrefere, $statut, $commentaires, $idJoueur) {
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qModifierInformationsJoueur']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour permet de modifier les informations d\'un objectif ');
    }
    // execution de la requete sql
    $req->execute(array(
        ':photo' => clean($photo),
        ':nom' => clean($nom),
        ':prenom' => clean($prenom),
        ':numeroLicence' => clean($numeroLicence),
        ':dateNaissance' => clean($dateNaissance),
        ':taille' => clean($taille),
        ':poids' => clean($poids),
        ':postePrefere' => clean($postePrefere),
        ':statut' => clean($statut),
        ':commentaires' => clean($commentaires),
        ':idJoueur' => clean($idJoueur)
    ));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de l\'execution de la requete pour permet de modifier les informations d\'un objectif ');
    }
}

// fonction qui permet de supprimer un joueur a partir de son idJoueur
function supprimerJoueur($idJoueur)
{
    // connexion a la base de donnees
    $linkpdo = connexionBd();
    //on supprime le membre
    unlink(supprimerImageJoueur($idJoueur));
    $req = $linkpdo->prepare($GLOBALS['qSupprimerJoueur']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour supprimer un joueur de la BD');
    }
    // execution de la requete sql
    $req->execute(array(':idJoueur' => clean($idJoueur)));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors l\'execution de la requete pour supprimer un joueur de la BD');
    }
}

function supprimerImageJoueur($idJoueur)
{
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qSupprimerImageJoueur']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour permet de modifier les informations d\'un Joueur ');
    }
    // execution de la requete sql
    $req->execute(array(
        ':idJoueur' => clean($idJoueur)
    ));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de l\'execution de la requete pour permet de modifier les informations d\'un Joueur ');
    }
    // permet de parcourir toutes les lignes de la requete
    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
        // permet de parcourir toutes les colonnes de la requete
        foreach ($data as $value) {
            // selectionne toutes les colonnes $key necessaires
            return $value;
        }
    }
}
?>