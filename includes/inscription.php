<?php

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['inscription'])) {

    $nom = htmlspecialchars($_POST['nom_client']);
    $prenom = htmlspecialchars($_POST['prenom_client']);
    $username = htmlspecialchars($_POST['nom_utilisateur']);
    $mdp = hash('md5', $_POST['mdp_utilisateur']);

    $liste_client = json_decode(file_get_contents('../data/membre.json'), true);

    $new_client = array("nom" => $nom,
     "prenom" => $prenom, 
     "username" => $username, 
     "mdp" => $mdp,
    "money" => 50);

    array_push($liste_client,$new_client);
    file_put_contents('../data/membre.json', json_encode($liste_client));
    header('Location: index.php');
}
