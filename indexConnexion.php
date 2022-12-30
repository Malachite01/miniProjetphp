<?php
require('FUNCTIONS.php');
session_start();
$linkpdo = connexionBd();
if (!empty($_POST['champIdentifiant']) && !empty($_POST['champMotDePasse'])) // Si il existe les champs email, password et qu'il sont pas vides
{
    $courriel = $_POST['champIdentifiant'];
    $mdp = $_POST['champMotDePasse'] . "C3cI eSt lE h4sH dU M0t dE p4S5e !";
    $check = $linkpdo->prepare('SELECT leLogin, lePassword from tableadmin where leLogin = ?');
    $check->execute(array($courriel));
    $data = $check->fetch();
    $row = $check->rowCount();

    $courriel = strtolower($courriel);
    $courriel = clean($courriel);

    if ($row > 0) {
        if (password_verify($mdp, $data['lePassword'])) {
            //page d'accueil  tableau de bord
            $_SESSION['estConnecte'] = "connecte";
            header('Location: ajoutJoueur.php');
            die();
            //Si mauvais password on redirige vers une autre page on l'on a codé une erreur du nom de 'password'
        } else {
            header('Location: index.php?login_err=password');
            die();
        }
    //Si compte inexistant
    } else {
        header('Location: index.php?login_err=inexistant');
        die();
    }
}
