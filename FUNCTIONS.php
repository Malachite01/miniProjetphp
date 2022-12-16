<?php

// requete pour verifier qu'un joeur avec les données en parametre n'existe pas deja dans la BD
$qJoueurIdentique = 'SELECT Nom, Prenom,Numero_Licence, Date_Naissance FROM joueur 
                    WHERE Nom = :nom AND Prenom = :prenom AND Numero_Licence = :numeroLicence AND Date_Naissance = :dateNaissance';

// requete pour ajouter un joeur a la BD
$qAjouterJoueur = 'INSERT INTO joueur (Nom,Prenom,Numero_Licence,Photo,Date_Naissance,Taille,Poids,Poste_Prefere,Statut,Commentaires) 
                    VALUES (:nom , :prenom, :numeroLicence,:photo,:dateNaissance, :taille, :poids,:postePrefere, :statut, :commentaires)';

$qAfficherJoueurs = 'SELECT Id_Joueur, Photo, Nom, Prenom, Numero_Licence, Date_Naissance, Taille, Poids, Poste_Prefere, Statut FROM joueur';

// requete pour supprimer un membre de la BD
$qSupprimerJoueur = 'DELETE FROM joueur WHERE Id_Joueur = :idJoueur';

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
    // $effacer = ["/leSite/", ".php", "?params=suppr"];
    // $get_url = str_replace($effacer, "", $_SERVER['REQUEST_URI']);
    $get_url = $_SERVER['REQUEST_URI'];
    $idAChercher = "";
    if (stripos($get_url, "tableau")) {
        $idAChercher = "tableauDeBord";
    } else if (stripos($get_url, "joueur")) {
        $idAChercher = "joueurs";
    } else if (stripos($get_url, "membre")) {
        $idAChercher = "Membres";
    } else if (stripos($get_url, "objectif")) {
        $idAChercher = "Objectifs";
    } else if (stripos($get_url, "recompense")) {
        $idAChercher = "Recompenses";
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
            
            <li><a id="Membres">Matchs</a>
                <ul class="sousMenu">
                    <li><a href="#">Ajouter un match</a></li>
                    <li><a href="#">Gerer les matchs</a></li>
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
                <button type="submit" name="boutonSupprimer" value="' . $idJoueur . '
                " class="boutonSupprimer" onclick="return confirm(\'Êtes vous sûr de vouloir supprimer ce membre ?\');" >
                    <img src="images/bin.png" class="imageIcone" alt="icone supprimer">
                    <span>Supprimer</span>
                </button>
            </td>
        </tr>';
    }
}

// fonction qui permet de supprimer un joueur a partir de son idJoueur
function supprimerJoueur($idJoueur)
{
    // connexion a la base de donnees
    $linkpdo = connexionBd();
    //on supprime le membre
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
?>