<?php 

/************ Gère l'alimentation d'une carte' ******************/

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['acheter']))
{
    $j = $_POST['id_produit']; //On récupère l'index du produit cliqué
    $produit = json_decode(file_get_contents('../data/card.json'),true); //On ouvre le fichier contenant les infos des produits

   $produit[$j]['price'] += $produit[$j]['price_up']*0.01; //On augmente du prix_up de la carte qu'on multiplie par 0.01 car ce sont des centimes

    file_put_contents('../data/card.json', json_encode($produit)); //On enregistre les modifications 
}


header('Location: ../index.php') //On redirige l'utilisateur sur la page d'accueil
?>
