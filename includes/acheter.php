<?php
session_start();

/************ Gère l'alimentation d'une carte' ******************/

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['acheter'])) {
    if ($_SESSION['user'] != '') {
        $liste_membre =  json_decode(file_get_contents('../data/membre.json'), true);
        $id_membre = -1;
        $j = $_POST['id_produit']; //On récupère l'index du produit cliqué
        $produit = json_decode(file_get_contents('../data/card.json'), true); //On ouvre le fichier contenant les infos des produits

        foreach($liste_membre as $key => $value){
            if ($_SESSION['user'] === $value['name']) {
                $id_membre = $key;
            }
        }

        if ($id_membre >= 0) {
            if ($liste_membre[$id_membre]['money'] != 0 and $liste_membre[$id_membre]['money'] > $produit[$j]['prix_clic'] * 0.01) {
                $j = $_POST['id_produit']; //On récupère l'index du produit cliqué
                $produit = json_decode(file_get_contents('../data/card.json'), true); //On ouvre le fichier contenant les infos des produits

                $produit[$j]['price'] += $produit[$j]['price_up'] * 0.01; //On augmente du prix_up de la carte qu'on multiplie par 0.01 car ce sont des centimes
                $produit[$j]['timer'] += $produit[$j]['time_up'] * 60; //On augmente les minutes, *60 car le timer est en secondes 

                file_put_contents('../data/card.json', json_encode($produit)); //On enregistre les modifications 

                $liste_membre[$id_membre]['money'] -=   $produit[$j]['prix_clic'] * 0.01;
                $_SESSION['money'] = $liste_membre[$id_membre]['money'];

                $_SESSION['debite'] = true;
                $_SESSION['debite_prix'] = $produit[$j]['prix_clic'] * 0.01;
                file_put_contents('../data/membre.json', json_encode($liste_membre)); //On enregistre les modifications 
            }
            else {
                $_SESSION['enchere_impossible'] = true;
            }
        }
    }

    header('Location: ../index.php#card_' . $j); //On redirige l'utilisateur sur l'enchère
}
