<?php

// requete pour verifier qu'un joueur avec les données en parametre n'existe pas deja dans la BD
$qJoueurIdentique = 'SELECT Nom, Prenom,Numero_Licence, Date_Naissance FROM joueur 
                    WHERE Nom = :nom AND Prenom = :prenom AND Numero_Licence = :numeroLicence AND Date_Naissance = :dateNaissance';

// requete pour ajouter un joeur a la BD
$qAjouterJoueur = 'INSERT INTO joueur (Nom,Prenom,Numero_Licence,Photo,Date_Naissance,Taille,Poids,Poste_Prefere,Statut,Commentaires) 
                    VALUES (:nom , :prenom, :numeroLicence,:photo,:dateNaissance, :taille, :poids,:postePrefere, :statut, :commentaires)';

//requete pour afficher tous les joueurs
$qAfficherJoueurs = 'SELECT Id_Joueur, Photo, Nom, Prenom, Numero_Licence, Date_Naissance, Taille, Poids, Poste_Prefere, Statut FROM joueur';

//requete pour afficher les infos d'un joueur
$qAfficherUnJoueur = 'SELECT Id_Joueur, Photo, Nom, Prenom, Numero_Licence, Date_Naissance, Taille, Poids, Poste_Prefere, Statut, Commentaires FROM joueur WHERE Id_Joueur = :idJoueur';

// requete pour supprimer un membre de la BD
$qSupprimerJoueur = 'DELETE FROM joueur WHERE Id_Joueur = :idJoueur';

// requete pour recuperer l'image d'un joueur 
$qRecupererImageJoueur = 'SELECT Photo FROM joueur WHERE Id_Joueur = :idJoueur';

//requete de modification d'un joueur
$qModifierInformationsJoueur = 'UPDATE joueur SET Photo = :photo, Nom = :nom, Prenom = :prenom, Numero_Licence = :numeroLicence, Date_Naissance = :dateNaissance, Taille = :taille, Poids = :poids, Poste_Prefere = :postePrefere, Statut = :statut, Commentaires = :commentaires WHERE Id_Joueur = :idJoueur';

//requete pour suprimmer l'image d'un joueur
$qSupprimerImageJoueur = 'SELECT Photo from joueur WHERE Id_Joueur = :idJoueur';

//*Matchs
// requete pour verifier qu'un joueur avec les données en parametre n'existe pas deja dans la BD
$qmatchIdentique = 'SELECT Date_Heure_Match, Nom_Adversaire	, Lieu_Rencontre FROM unmatch 
                    WHERE Date_Heure_Match = :dateHeureMatch AND Nom_Adversaire = :nomAdversaire AND Lieu_Rencontre = :lieuRencontre';

// requete pour ajouter un match a la BD
$qAjouterMatch = 'INSERT INTO unmatch (Date_Heure_Match,Nom_Adversaire,Lieu_Rencontre,Resultat) 
VALUES (:dateHeureMatch , :nomAdversaire, :lieuRencontre,:resultat)';

//requete pour afficher tous les matchs
$qAfficherMatchs = 'SELECT Id_UnMatch,Nom_Adversaire,Date_Heure_Match,Lieu_Rencontre,Resultat FROM unmatch';

//requete pour afficher les infos d'un match
$qAfficherUnMatch = 'SELECT Id_UnMatch,Nom_Adversaire,Date_Heure_Match,Lieu_Rencontre,Resultat FROM unmatch WHERE Id_UnMatch = :idMatch';

//requete de modification d'un match
$qModifierInformationsMatch = 'UPDATE unmatch SET Nom_Adversaire = :nomAdversaire, Date_Heure_Match = :dateHeureMatch, Lieu_Rencontre = :lieuRencontre, Resultat = :resultat WHERE Id_UnMatch = :idMatch';

//requete pour entrer les resultats d'un match
$qEntrerResultats = 'UPDATE unmatch SET Resultat = :resultat WHERE Id_UnMatch = :idMatch';

// requete pour supprimer un membre de la BD
$qSupprimerMatch = 'DELETE FROM unmatch WHERE Id_UnMatch = :idMatch';

//* feuilles de matchs
//requete pour afficher tous les joueurs
$qAfficherJoueursDispos = 'SELECT joueur.Id_Joueur, joueur.Photo, joueur.Nom, joueur.Prenom, joueur.Taille, joueur.Poids, joueur.Commentaires, joueur.Poste_Prefere FROM joueur WHERE joueur.Statut = "Actif" AND joueur.Id_Joueur NOT IN (SELECT participe.Id_Joueur FROM participe WHERE participe.Id_UnMatch = :idMatch)';

//requete pour afficher tous les joueurs
$qAfficherSelectionMatch = 'SELECT joueur.Id_Joueur, joueur.Photo, joueur.Nom, joueur.Prenom, joueur.Taille, joueur.Poids, joueur.Commentaires, joueur.Poste_Prefere, participe.Role, participe.Notation, participe.Id_Joueur, participe.Id_UnMatch FROM joueur,participe WHERE joueur.Id_Joueur = participe.Id_Joueur AND participe.Id_UnMatch = :idMatch ';

// requete pour ajouter un joueur a la selection d'un match
$qAjouterASelection = 'INSERT INTO participe (Id_Joueur,Id_UnMatch,Notation,Role) VALUES (:idJoueur , :idMatch, :notation, :role)';

// requete pour ajouter un joueur a la selection d'un match
$qRetirerASelection = 'DELETE FROM participe WHERE Id_UnMatch = :idMatch AND Id_Joueur = :idJoueur';

//requete pour savoir combien de joueurs sont indisponibles
$qJoueursIndisponibles = 'SELECT * FROM joueur WHERE Statut IN ("Blesse", "Suspendu", "Absent")';

//requete pour verifier que les 5 postes differents au volley sont bien présent dans la selection
$qMatchValide = 'SELECT DISTINCT joueur.Poste_Prefere
FROM participe
JOIN joueur ON participe.Id_Joueur = joueur.Id_Joueur
WHERE participe.Id_UnMatch = :idMatch';

//*stats
//requete pour afficher les stats d'un joueur
$qAfficherStatsUnJoueur = 'SELECT Id_Joueur, Photo, Statut, Commentaires, Nom, Prenom, Numero_Licence, Poste_Prefere FROM joueur WHERE Id_Joueur = :idJoueur';

//requete pour avoir le nombre de selections en tant que titulaire
$qSelectionsTitulaire = 'SELECT participe.* FROM participe WHERE participe.Role = 1 AND participe.Id_Joueur = :idJoueur GROUP BY participe.Id_UnMatch';

//requete pour avoir le nombre de selections en tant que remplacant
$qSelectionsRemplacant = 'SELECT participe.* FROM participe WHERE participe.Role = 0 AND participe.Id_Joueur = :idJoueur GROUP BY participe.Id_UnMatch';

//moyenne du joueur
$qMoyenneUnJoueur = 'SELECT AVG(participe.Notation) as Moyenne FROM participe WHERE participe.Id_Joueur = :idJoueur';

$qVictoires = 'SELECT COUNT(*) FROM unmatch WHERE SUBSTR(Resultat,1,2) > SUBSTR(Resultat,4,2) AND Resultat IS NOT NULL';

$qDefaites = 'SELECT COUNT(*) FROM unmatch WHERE SUBSTR(Resultat,1,2) < SUBSTR(Resultat,4,2) AND Resultat IS NOT NULL';

$qEgalites = 'SELECT COUNT(*) FROM unmatch WHERE COALESCE(resultat,"00-00") = SUBSTR(COALESCE(resultat,"00-00"),1,2)';

//requete pour compter le nombre de joueurs
$qNbJoueurs = 'SELECT COUNT(*) FROM joueur';

//fonction pour se connecter a la bd (utilisée tout le temps)
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

//fonction pour faire le menu de toute l'application et toutes les pages
function faireMenu()
{
    testConnexion();
    echo '<script src="js/javascript.js"></script>';
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
            
            <li><a id="Joueurs" href="joueur.php">Equipe</a></li>        
            
            <div class="separateur"></div>
            
            <li><a id="Matchs" href="match.php">Matchs</a></li>

            <div class="separateur"></div>
            
            <li><a id="Statistiques" href="statistiques.php">Statistiques</a>
            </li>

            <li>
                <a href="deconnexion.php">Deconnexion</a>
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

//fonction utilisée pour nettoyer un champ entrant de tout caracteres pouvant entrainer une attaque
function clean($champEntrant)
{
    $champEntrant = strip_tags($champEntrant); // permet d'enlever les balises html, xml, php
    $champEntrant = htmlspecialchars($champEntrant); // permet de transformer les balises html en ""String""
    return $champEntrant;
}

//fonction utilisée une fois lors de la création du mdp dans la table de l'admin (normalement utilisée a chaque création de compte,
//mais dans cette application, nous n'avons qu'un utilisateur).
function psswdHash($mdp)
{
    $code = $mdp . "C3cI eSt lE h4sH dU M0t dE p4S5e !";
    return password_hash($code, PASSWORD_DEFAULT);
}

//fonction qui vérifie si l'utilisateur est bel et bien connecté sur le compte administrateur. dans le cas contraire, il est redirigé vers l'index
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

//fonction qui vérifie que chaque champ est rempli
function champRempli($field)
{
    foreach ($field as $name) {
        // vérifie s'ils sont vides 
        if (empty($_POST[$name])) {
            return false; // au moins un champ vide
        }
    }
    return true; // champs remplis
}

//fonction pour vérifier l'existence d'un joueur
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

//fonction pour ajouter un joueur dans la bd
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

//fonction d'ajout d'image dans la bd
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

//fonction pour afficher tous les joueurs 
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
            if ($key == 'Nom' || $key == 'Prenom' || $key == 'Numero_Licence' || $key == 'Poste_Prefere') {
                echo '<td>' . $value . '</td>';
            }
            if($key == 'Statut') {
                if($value == "Blesse") {
                    echo '<td style="background-color: red; color: white;">' . $value . '</td>';
                } else if ($value == "Suspendu" || $value == "Absent") {
                    echo '<td style="background-color: orange; color: white;">' . $value . '</td>';
                } else {
                    echo '<td>' . $value . '</td>';
                }
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
                <button type="submit" name="boutonConsulter" value="' . $idJoueur . '" 
                class="boutonConsulter" formaction="statsJoueur.php">
                <img src="images/oeil2.png" class="imageIcone" alt="icone consulter">
                <span>Consulter</span>
                </button>
            </td>
            <td>
                <button type="submit" name="boutonModifier" value="' . $idJoueur . '" class="boutonModifier" formaction="modifierJoueur.php">
                    <img src="images/edit.png" class="imageIcone" alt="icone modifier">
                    <span>Modifier</span>
                </button>
            </td>
            <td>
                <button type="submit" name="boutonSupprimer" value="' . $idJoueur . '
                " class="boutonSupprimer" onclick="return confirm(\'Êtes vous sûr de vouloir supprimer ce joueur ?\');" formaction="joueur.php">
                    <img src="images/bin.png" class="imageIcone" alt="icone supprimer">
                    <span>Supprimer</span>
                </button>
            </td>
        </tr>';
    }
}

//fonction pour afficher l'image d'un joueur
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

//fonction pour afficher seulement un joueur
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
                <input type="file" name="champPhoto" id="champPhoto" accept="image/png, image/jpeg, image/svg+xml, image/webp, image/bmp, image/gif" onchange="refreshImageSelector(\'champPhoto\',\'imageJoueur\')">
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
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour permet de modifier les informations d\'un joueur ');
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
        die('Erreur ! Il y a un probleme lors de l\'execution de la requete pour permet de modifier les informations d\'un joueur ');
    }
}

// fonction qui permet de supprimer un joueur a partir de son idJoueur
function supprimerJoueur($idJoueur)
{
    // connexion a la base de donnees
    $linkpdo = connexionBd();
    //on supprime le membre
    if(file_exists(supprimerImageJoueur($idJoueur))) {
        unlink(supprimerImageJoueur($idJoueur));
    }
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

//fonction qui permet de supprimmer l'image d'un joueur (appelée dans supprimerJoueur)
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

//!MATCHS

//fonction pour vérifier l'existence d'un match
function matchIdentique($date, $nom, $lieu)
{
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qmatchIdentique']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour verifier si un match existe deja');
    }
    // execution de la requete sql
    $req->execute(array(
        ':dateHeureMatch' => clean($date),
        ':nomAdversaire' => clean($nom),
        ':lieuRencontre' => clean($lieu)
    ));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors l\'execution de la requete pour verifier si un match existe deja');
    }
    return $req->rowCount(); // si ligne > 0 alors joueur deja dans la BD
}

//fonction pour ajouter un match dans la bd
function ajouterMatch($date, $nom, $lieu, $resultat)
{

    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qAjouterMatch']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour ajouter un match a la BD');
    }
    // execution de la requete sql
    $req->execute(array(
        ':dateHeureMatch' => clean($date),
        ':nomAdversaire' => clean($nom),
        ':lieuRencontre' => clean($lieu),
        ':resultat' => $resultat
    ));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors l\'execution de la requete pour ajouter un match a la BD');
    }
}

//fonction pour afficher tous les matchs 
function AfficherMatchs() {
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qAfficherMatchs']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour afficher les informations des matchs');
    }
    // execution de la requete sql
    $req->execute();
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour afficher les informations des matchs');
    }
    $idMatch=0;
    // permet de parcourir toutes les lignes de la requete
    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        // permet de parcourir toutes les colonnes de la requete
        foreach ($data as $key => $value) {
            // recuperation valeurs importantes dans des variables
            if ($key == 'Id_UnMatch') {
                $idMatch = $value;
            } elseif ($key == 'Date_Heure_Match') {
                echo '<td>' . date('d/m/Y à H:i', strtotime($value)) . '</td>';
            } elseif ($key == 'Resultat') {
                if($value == null) {
                    echo "<td><input style=\"width: fit-content; margin: 0;\" type=\"text\" name=\"".$idMatch."\" placeholder=\"Equipe-Adversaires: 00-00\" min=\"5\" max=\"5\" onkeyup=\"this.value = scoreMatch(this.value);\" oninput=\"this.value = this.value.replace(/[^0-9.-]/g, '').replace(/(\..*)\./g, '$1');\"><button type=\"submit\" name=\"boutonResultats\" value=\"".$idMatch."\" style=\"width: fit-content; margin: 0; padding: 2px;\" class=\"boutons\"><img class=\"imageIcone\" src=\"images/valider.png\"></button></td>";
                } else {
                    echo '<td>'.$value.'</td>';
                }
            } else {
                echo '<td>' . $value . ' </td>';
            }
            
        }
        if(MatchValide($idMatch) < 5) {
            echo '
            <td>
                <button type="submit" name="boutonConsulter" value="' . $idMatch . '" 
                class="boutonConsulter" formaction="feuilleDeMatch.php" style="background-color:red;">
                <img src="images/oeil2.png" class="imageIcone" alt="icone consulter">
                <span>Consulter</span>
                </button>
            </td>';
        } else {
            echo '
            <td>
                <button type="submit" name="boutonConsulter" value="' . $idMatch . '" 
                class="boutonConsulter" formaction="feuilleDeMatch.php">
                <img src="images/oeil2.png" class="imageIcone" alt="icone consulter">
                <span>Consulter</span>
                </button>
            </td>';
        }
        echo '
            <td>
                <button type="submit" name="boutonModifier" value="' . $idMatch . '" class="boutonModifier" formaction="modifierMatch.php">
                    <img src="images/edit.png" class="imageIcone" alt="icone modifier">
                    <span>Modifier</span>
                </button>
            </td>
            <td>
                <button type="submit" name="boutonSupprimer" value="' . $idMatch . '" class="boutonSupprimer" onclick="return confirm(\'Êtes vous sûr de vouloir supprimer ce match ?\');" formaction="match.php" >
                    <img src="images/bin.png" class="imageIcone" alt="icone supprimer">
                    <span>Supprimer</span>
                </button>
            </td>
        </tr>';
    }
}

//fonction pour afficher seulement un match
function afficherUnMatch($idMatch) {  
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qAfficherUnMatch']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour afficher un match a la BD');
    }
    // execution de la requete sql
    $req->execute(array(':idMatch' => clean($idMatch)));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de l\'execution de la requete pour afficher un match a la BD');
    }
    // permet de parcourir la ligne de la requetes 
    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
        // permet de parcourir toutes les colonnes de la requete 
        foreach ($data as $key => $value) {
            // recuperation de toutes les informations du membre de la session dans des inputs 
            if ($key == 'Nom_Adversaire') {
                echo '
                <label for="champEquipe">Equipe affrontee :</label>
                <input type="text" name="champEquipe" placeholder="Entrez le nom de l\'equipe affrontee" minlength="1" maxlength="50" value="'.$value.'" required>
                <span></span>
                ';
                echo '<input type="hidden" value="" name="hiddenImageLink">';
            } elseif ($key == 'Date_Heure_Match') {
                echo'
                <label for="champDate">Date de debut:</label>
                <input type="datetime-local" name="champDate" placeholder="Entrez la date de debut du match" min="1900-01-01T00:00" max="'. date('Y-m-d')."T00:00" . '" value="'.$value.'" required>
                <span></span>
                ';
            } elseif ($key == 'Lieu_Rencontre'){
                echo '
                <label for="champLieu">Lieu de la rencontre :</label>
                <input type="text" name="champLieu" placeholder="Entrez le lieu de la rencontre" minlength="1" maxlength="50" value="'.$value.'" required>
                <span></span>
                ';
            } elseif ($key == 'Resultat'){
                echo '
                <label for="champResultat">Score (optionnel) :</label>
                <input type="text" name="champResultat" placeholder="Entrez le score: 00-00" min="5" max="5" onkeypress="this.value = scoreMatch(this.value);" oninput="this.value = this.value.replace(/[^0-9.-]/g, \'\').replace(/(\..*)\./g, \'$1\');" value="'.$value.'">
                <span></span>
                ';
            } 
        }
    }
}

// fonction qui permet de modifier un match de la BD
function modifierMatch($nomAdversaire, $dateHeureMatch, $lieuRencontre, $resultat, $idMatch) {
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qModifierInformationsMatch']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour permet de modifier les informations d\'un match');
    }
    // execution de la requete sql
    $req->execute(array(
        ':nomAdversaire' => clean($nomAdversaire),
        ':dateHeureMatch' => clean($dateHeureMatch),
        ':lieuRencontre' => clean($lieuRencontre),
        ':resultat' => clean($resultat),
        ':idMatch' => clean($idMatch)
    ));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de l\'execution de la requete pour permet de modifier les informations d\'un match');
    }
}

// fonction qui permet de modifier un match de la BD
function entrerResultats($resultat, $idMatch) {
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qEntrerResultats']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour permet de modifier les informations d\'un match');
    }
    // execution de la requete sql
    $req->execute(array(
        ':resultat' => clean($resultat),
        ':idMatch' => clean($idMatch)
    ));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de l\'execution de la requete pour permet de modifier les informations d\'un match');
    }
    $req->debugDumpParams();
}

// fonction qui permet de supprimer un match a partir de son id
function supprimerMatch($idMatch)
{
    // connexion a la base de donnees
    $linkpdo = connexionBd();
    //on supprime le membre
    $req = $linkpdo->prepare($GLOBALS['qSupprimerMatch']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour supprimer un match de la BD');
    }
    // execution de la requete sql
    $req->execute(array(':idMatch' => clean($idMatch)));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors l\'execution de la requete pour supprimer un match de la BD');
    }
}

//!FEUILLE DE MATCHS

//fonction pour afficher l'intitulé du match
function afficherUnMatchFeuille($idMatch) {  
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qAfficherUnMatch']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour afficher un match a la BD');
    }
    // execution de la requete sql
    $req->execute(array(':idMatch' => clean($idMatch)));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de l\'execution de la requete pour afficher un match a la BD');
    }
    // permet de parcourir la ligne de la requetes 
    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
        // permet de parcourir toutes les colonnes de la requete 
        foreach ($data as $key => $value) {
            // recuperation de toutes les informations du membre de la session dans des inputs 
            if ($key == 'Nom_Adversaire') {
                echo '
                <h2 class="titreFeuille">Match contre : '.$value.', 
                ';
                echo '<input type="hidden" value="" name="hiddenImageLink">';
            } elseif ($key == 'Date_Heure_Match') {
                echo'
                le : '.$value.', 
                ';
            } elseif ($key == 'Lieu_Rencontre'){
                echo '
                a : '.$value.' </h2>
                ';
            } elseif ($key == 'Resultat'){
            } 
        }
    }
}

//fonction pour afficher tous les joueurs sélectionnés d'un match
function AfficherJoueursSelection($idMatch) {
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qAfficherSelectionMatch']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour afficher les informations des joueurs');
    }
    // execution de la requete sql
    $req->execute(array(':idMatch' => clean($idMatch)));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour afficher les informations des joueurs');
    }
    if($req->rowCount() == 0) {
        echo '<p class="msgSelection">Aucun joueur selectionne pour le moment.</p>';
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
            if ($key == 'Nom' || $key == 'Prenom' || $key == 'Commentaires' || $key == 'Poste_Prefere' || $key == 'Statut' || $key == 'Notation') {
                echo '<td>' . $value . '</td>';
            }
            if($key == 'Role') {
                if($value == 1) {
                    $value = "Titulaire";
                } else {
                    $value = "Remplacant";
                }
                echo '<td>' . $value . '</td>';
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
                <button type="submit" name="boutonSupprimer" value="' . $idJoueur . '
                " class="boutonSupprimer" onclick="return confirm(\'Êtes vous sûr de vouloir retirer ce joueur de la sélection?\');" formaction="feuilleDeMatch.php">
                    <img src="images/annuler.png" class="imageIcone" alt="icone supprimer">
                    <span>Retirer</span>
                </button>
            </td>
        </tr>';
    }
}

//fonction pour afficher tous les joueurs disponible a la selection
function AfficherJoueursDispos($idMatch) {
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qAfficherJoueursDispos']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour afficher les informations des joueurs');
    }
    // execution de la requete sql
    $req->execute(array(':idMatch' => clean($idMatch)));
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
            if ($key == 'Nom' || $key == 'Prenom' || $key == 'Commentaires' || $key == 'Poste_Prefere') {
                echo '<td>' . $value . '</td>';
            }
            if( $key == 'Taille') {
                echo '<td>' . $value . 'cm </td>';
            }
            if( $key == 'Poids') {
                echo '<td>' . $value . 'kg </td>';
            }
        }
        echo '
            <td>'.MoyenneUnJoueur($idJoueur).'</td>
            <td>
                <button type="button" name="boutonAjouterJoueurFeuille" class="boutons boutonAjouterA" onclick="fenOpen(\'aCacher\'),deCache(\'aCacher\'),ajouterSelection(this)" value="'.$idJoueur.'">
                    <span>Ajouter</span>
                    <img style="transform: rotate(-45deg);" src="images/annuler.png" class="imageIcone" alt="icone cadenas">
                </button>
            </td>
        </tr>';
    }
}

//fonction pour ajouter un joueur a la séléction
function ajouterJoueurASelection($idJoueur, $idMatch, $notation, $role)
{
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qAjouterASelection']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour ajouter un match a la BD');
    }
    // execution de la requete sql
    $req->execute(array(
        ':idJoueur' => clean($idJoueur),
        ':idMatch' => clean($idMatch),
        ':notation' => clean($notation),
        ':role' => clean($role)
    ));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors l\'execution de la requete pour ajouter un match a la BD');
    }
}

//fonction pour retirer un joueur de la sélection
function retirerJoueurASelection($idJoueur, $idMatch)
{
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qRetirerASelection']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour ajouter un match a la BD');
    }
    // execution de la requete sql
    $req->execute(array(
        ':idJoueur' => clean($idJoueur),
        ':idMatch' => clean($idMatch)
    ));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors l\'execution de la requete pour ajouter un match a la BD');
    }
}

//fonction pour afficher tous les joueurs disponible a la selection
function nbJoueurs() {
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qNbJoueurs']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour afficher les informations des joueurs');
    }
    // execution de la requete sql
    $req->execute();
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour afficher les informations des joueurs');
    }
    $res = $req->fetch();
    return $res[0];
}

//fonction pour afficher tous les joueurs disponible a la selection
function compterJoueursIndispos() {
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qJoueursIndisponibles']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour afficher les informations des joueurs');
    }
    // execution de la requete sql
    $req->execute();
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour afficher les informations des joueurs');
    }
    return $req->rowCount();
}

//fonction pour verifier si tous les postes necessaire sont bien dans la selection
function MatchValide($idMatch) {
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qMatchValide']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour afficher les informations des joueurs');
    }
    // execution de la requete sql
    $req->execute(array(':idMatch' => clean($idMatch)));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour afficher les informations des joueurs');
    }
    return $req->rowCount();
}

//!STATS PAR JOUEURS

//fonction pour afficher seulement un joueur
function afficherStatsUnJoueur($idJoueur) {
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qAfficherStatsUnJoueur']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour ajouter un membre a la BD');
    }
    // execution de la requete sql
    $req->execute(array(':idJoueur' => clean($idJoueur)));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de l\'execution de la requete pour ajouter un membre a la BD');
    }
    echo '<p id="noteJoueur"> Note moyenne : ' . MoyenneUnJoueur($idJoueur).'/5</p>';
    echo '<p id="tauxVictoire"> Taux victoire quand selectionne : A faire</p>';
    // permet de parcourir la ligne de la requetes 
    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
        // permet de parcourir toutes les colonnes de la requete 
        foreach ($data as $key => $value) {
            // recuperation de toutes les informations du membre de la session dans des inputs 
            if ($key == 'Photo') {
                echo '<img style="justify-self:center; margin-top: 50px;" src="' . AfficherImageJoueur($idJoueur) . '" id="imageJoueur" alt="image du joueur">';
            }else if ($key == 'Statut') {
                echo '<h2 style="color: black; font-size: 1.9em;">Statut actuel : '.$value.'<h2>';
            } elseif ($key == 'Commentaires') {
                echo '<p style="color: black;">Dernier commentaire : '.$value.'</p>';
            } elseif ($key == 'Nom') {
                echo'<div style="display:flex; position: absolute; top: -10px; left: 10px;"><h3>'.$value.' ';
            } elseif ($key == 'Prenom'){
                echo $value.', &ensp;&ensp;';
            } elseif ($key == 'Numero_Licence'){
                echo ' N°: '.$value.', ';
            } elseif ($key == 'Poste_Prefere'){
                echo '&ensp;&ensp;Poste prefere : '.$value.'</h3></div>';
            }
        }
    }
}

function selectionsTitulaire($idJoueur) {
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qSelectionsTitulaire']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour ajouter un membre a la BD');
    }
    // execution de la requete sql
    $req->execute(array(':idJoueur' => clean($idJoueur)));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de l\'execution de la requete pour ajouter un membre a la BD');
    }
    return $req->rowCount();
}
function selectionsRemplacant($idJoueur) {
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qSelectionsRemplacant']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour ajouter un membre a la BD');
    }
    // execution de la requete sql
    $req->execute(array(':idJoueur' => clean($idJoueur)));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de l\'execution de la requete pour ajouter un membre a la BD');
    }
    return $req->rowCount();
}
function MoyenneUnJoueur($idJoueur) {
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qMoyenneUnJoueur']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour ajouter un membre a la BD');
    }
    // execution de la requete sql
    $req->execute(array(':idJoueur' => clean($idJoueur)));
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de l\'execution de la requete pour ajouter un membre a la BD');
    }
    $moyenne = $req->fetch();
    return round($moyenne[0],1,PHP_ROUND_HALF_EVEN);
}

//!STATISTIQUES EQUIPE
function VictoiresEquipe() {
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qVictoires']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour ajouter un membre a la BD');
    }
    // execution de la requete sql
    $req->execute();
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de l\'execution de la requete pour ajouter un membre a la BD');
    }
    $res = $req->fetch();
    return $res[0];
}

function DefaitesEquipe() {
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qDefaites']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour ajouter un membre a la BD');
    }
    // execution de la requete sql
    $req->execute();
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de l\'execution de la requete pour ajouter un membre a la BD');
    }
    $res = $req->fetch();
    return $res[0];
}

function EgalitesEquipe() {
    // connexion a la BD
    $linkpdo = connexionBd();
    // preparation de la requete sql
    $req = $linkpdo->prepare($GLOBALS['qEgalites']);
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de la preparation de la requete pour ajouter un membre a la BD');
    }
    // execution de la requete sql
    $req->execute();
    if ($req == false) {
        die('Erreur ! Il y a un probleme lors de l\'execution de la requete pour ajouter un membre a la BD');
    }
    $res = $req->fetch();
    return $res[0];
}

?>