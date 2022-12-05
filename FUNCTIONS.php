<?php
function connexionBd()
{
    // parametre de connexion a la BD
    // cDRvPP\2mwea(LGp
    // https://test-saetrisomie21.000webhostapp.com/
    $SERVER = '127.0.0.1';
    $DB = 'miniprojetphp';
    $LOGIN = 'root';
    $MDP = '';
    // tentative de connexion a la BD
    try {
        // connexion a la BD
        $linkpdo = new PDO("mysql:host=$SERVER;dbname=$DB", $LOGIN, $MDP);
        echo "ouioui";
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
    } else if (stripos($get_url, "enfant")) {
        $idAChercher = "Enfants";
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
?>